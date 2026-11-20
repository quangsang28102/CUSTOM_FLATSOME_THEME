/**
 * HPO Showcase Scripts (Milestone M3: Features F10–F14)
 * Enqueued with defer in footer via inc/modules/showcase.php.
 *
 * Modules:
 *  1. [data-reveal] & [data-count] observers (from core.js)
 *  2. #awardSlider infinite cloned-track carousel (from awards.js)
 *  3. #imgLb shared image lightbox (from media.js + focus management & alt sync)
 */
(() => {
  'use strict';

  const initShowcase = () => {
    const reducedMotion = window.matchMedia
      ? window.matchMedia('(prefers-reduced-motion: reduce)')
      : { matches: false, addEventListener: null };

    const isUxBuilder =
      document.body &&
      (document.body.classList.contains('ux-builder') ||
        document.body.classList.contains('ux-builder-active') ||
        document.documentElement.classList.contains('ux-builder'));

    /* ======================================================================
       1. Scroll Reveal ([data-reveal]) & Count-Up ([data-count])
       ====================================================================== */
    const revealEls = document.querySelectorAll('[data-reveal]');
    if (revealEls.length) {
      if (isUxBuilder || reducedMotion.matches || !('IntersectionObserver' in window) || navigator.webdriver) {
        revealEls.forEach((el) => {
          el.classList.add('is-visible');
          el.style.opacity = '1';
          el.style.transition = 'none';
        });
      } else {
        const revealObserver = new IntersectionObserver(
          (entries) => {
            entries.forEach((entry) => {
              if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                revealObserver.unobserve(entry.target);
              }
            });
          },
          { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
        );
        revealEls.forEach((el) => revealObserver.observe(el));
      }
    }

    const formatNumber = (n) => {
      if (n >= 1000) return Math.round(n / 1000) + '.000';
      return String(n);
    };

    const countUp = (el, target, duration = 1800) => {
      if (!Number.isFinite(target)) return;
      if (reducedMotion.matches || typeof window.requestAnimationFrame !== 'function') {
        el.textContent = formatNumber(target);
        return;
      }
      const start = performance.now();
      const step = (now) => {
        const p = Math.min((now - start) / duration, 1);
        const eased = 1 - Math.pow(1 - p, 3);
        const val = Math.round(eased * target);
        el.textContent = formatNumber(val);
        if (p < 1) {
          requestAnimationFrame(step);
        } else {
          el.textContent = formatNumber(target);
        }
      };
      requestAnimationFrame(step);
    };

    const countEls = document.querySelectorAll('[data-count]');
    if (countEls.length) {
      if (reducedMotion.matches || !('IntersectionObserver' in window)) {
        countEls.forEach((el) => {
          const target = parseInt(el.dataset.count || '', 10);
          if (Number.isFinite(target)) el.textContent = formatNumber(target);
        });
      } else {
        const countObserver = new IntersectionObserver(
          (entries) => {
            entries.forEach((entry) => {
              if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseInt(el.dataset.count || '', 10);
                countUp(el, target);
                countObserver.unobserve(el);
              }
            });
          },
          { threshold: 0.4 }
        );
        countEls.forEach((el) => countObserver.observe(el));
      }
    }

    /* ======================================================================
       2. Awards Showcase Slider (#awardSlider)
       ====================================================================== */
    const slider = document.getElementById('awardSlider');
    if (slider) {
      // 2a. Section block reveal
      const blocks = slider.querySelectorAll(':scope > .award-slider__heading, :scope > .award-slider__body');
      if (blocks.length) {
        if (isUxBuilder || reducedMotion.matches || !('IntersectionObserver' in window)) {
          blocks.forEach((block) => block.classList.add('is-scroll-revealed'));
        } else {
          const awardRevealObserver = new IntersectionObserver(
            (entries) => {
              entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-scroll-revealed');
                awardRevealObserver.unobserve(entry.target);
              });
            },
            { threshold: 0, rootMargin: '0px 0px -40px 0px' }
          );
          blocks.forEach((block) => {
            block.classList.add('award-scroll-motion');
            awardRevealObserver.observe(block);
          });
          slider.addEventListener('focusin', () => {
            slider.querySelectorAll('.award-scroll-motion').forEach((block) => {
              block.classList.add('is-scroll-revealed');
              awardRevealObserver.unobserve(block);
            });
          });
        }
      }

      // 2b. Carousel logic
      const track = slider.querySelector('.award-slider__track');
      const viewport = slider.querySelector('.award-slider__viewport');
      const slides = [...slider.querySelectorAll('.award-slide')];
      const choices = [...slider.querySelectorAll('.award-slider__choice')];
      const autoplayToggle = slider.querySelector('.award-slider__autoplay-toggle');
      const subtitle = slider.querySelector('#awardSliderSubtitle');
      const prev = slider.querySelector('.award-slider__prev');
      const next = slider.querySelector('.award-slider__next');

      if (track && viewport && slides.length >= 2 && prev && next) {
        const parsedMs = parseInt(slider.dataset.autoplayMs || '', 10);
        const DURATION = Number.isFinite(parsedMs) && parsedMs >= 1000 ? parsedMs : 6500;
        slider.style.setProperty('--slider-duration', `${DURATION}ms`);

        let current = 0;
        let timer = null;
        let pointerStartX = null;
        let pointerStartTime = 0;
        let pointerId = null;
        let dragged = false;
        let physicalPosition = 1;
        let boundaryReset = null;
        let paused = false;
        let userPaused = false;
        let interactionPaused = false;
        let scrollStory = false;

        const firstClone = slides[0].cloneNode(true);
        const lastClone = slides[slides.length - 1].cloneNode(true);
        [firstClone, lastClone].forEach((clone) => {
          clone.classList.add('award-slide--loop-clone');
          clone.classList.remove('is-active');
          clone.setAttribute('aria-hidden', 'true');
          clone.setAttribute('tabindex', '-1');
          clone.removeAttribute('data-img-open-group');
          clone.querySelectorAll('[data-img-group]').forEach((el) => {
            el.removeAttribute('data-img-group');
          });
          if ('inert' in clone) clone.inert = true;
        });
        track.prepend(lastClone);
        track.append(firstClone);

        const setTrackPosition = (position, animate = true) => {
          physicalPosition = position;
          if (!animate) track.style.transition = 'none';
          track.style.transform = `translate3d(-${position * 100}%, 0, 0)`;
          if (!animate) {
            void track.offsetWidth;
            track.style.transition = '';
          }
        };

        const restartProgress = () => {
          slider.classList.remove('is-running');
          void slider.offsetWidth;
          if (!scrollStory && !userPaused && !interactionPaused && !reducedMotion.matches && !document.hidden) {
            slider.classList.add('is-running');
          }
        };

        const schedule = () => {
          window.clearTimeout(timer);
          timer = null;
          paused = userPaused || interactionPaused;
          restartProgress();
          if (scrollStory || paused || reducedMotion.matches || document.hidden) return;
          timer = window.setTimeout(() => goTo(current + 1), DURATION);
        };

        const goTo = (index, animate = true) => {
          if (scrollStory && animate) {
            slider.dispatchEvent(
              new CustomEvent('award-story-navigate', {
                detail: { index: Math.max(0, Math.min(slides.length - 1, index)) },
              })
            );
            return;
          }

          // If a boundary snap was pending from a previous transition, apply it immediately
          if (boundaryReset !== null) {
            const resetPosition = boundaryReset;
            boundaryReset = null;
            setTrackPosition(resetPosition, false);
          }

          if (index < 0) {
            current = slides.length - 1;
            boundaryReset = slides.length;
            physicalPosition = 0;
          } else if (index >= slides.length) {
            current = 0;
            boundaryReset = 1;
            physicalPosition = slides.length + 1;
          } else {
            current = index;
            physicalPosition = current + 1;
          }

          slider.classList.toggle('is-asean-pair', slides[current].classList.contains('award-slide--asean-custom'));
          slider.classList.toggle('is-global-pair', slides[current].classList.contains('award-slide--global-custom'));
          setTrackPosition(physicalPosition, animate);

          if (!animate && boundaryReset !== null) {
            const resetPosition = boundaryReset;
            boundaryReset = null;
            physicalPosition = resetPosition;
            setTrackPosition(resetPosition, false);
          }

          slides.forEach((slide, slideIndex) => {
            const active = slideIndex === current;
            slide.classList.toggle('is-active', active);
            slide.setAttribute('aria-hidden', String(!active));
            if ('inert' in slide) slide.inert = !active;
          });

          choices.forEach((choice, choiceIndex) => {
            const active = choiceIndex === current;
            choice.classList.toggle('is-active', active);
            if (active) choice.setAttribute('aria-current', 'step');
            else choice.removeAttribute('aria-current');
          });

          if (subtitle && choices[current] && choices[current].dataset.awardSubtitle !== undefined) {
            subtitle.textContent = choices[current].dataset.awardSubtitle;
          }

          schedule();
        };

        track.addEventListener('transitionend', (event) => {
          if (event.propertyName !== 'transform' || boundaryReset === null) return;
          const resetPosition = boundaryReset;
          boundaryReset = null;
          setTrackPosition(resetPosition, false);
        });

        const setPaused = (value) => {
          interactionPaused = value;
          schedule();
        };

        prev.addEventListener('click', () => goTo(current - 1));
        next.addEventListener('click', () => goTo(current + 1));
        choices.forEach((choice, index) => choice.addEventListener('click', () => goTo(index)));

        if (autoplayToggle) {
          autoplayToggle.addEventListener('click', () => {
            userPaused = !userPaused;
            if (!userPaused) interactionPaused = false;
            autoplayToggle.setAttribute('aria-pressed', String(userPaused));
            autoplayToggle.setAttribute(
              'aria-label',
              userPaused ? 'Tiếp tục tự chuyển giải thưởng' : 'Tạm dừng tự chuyển giải thưởng'
            );
            const icon = autoplayToggle.querySelector('[aria-hidden="true"]');
            const label = autoplayToggle.querySelector('span:last-child');
            if (icon) icon.textContent = userPaused ? '▶' : 'Ⅱ';
            if (label) label.textContent = userPaused ? 'Tiếp tục tự chuyển' : 'Tạm dừng tự chuyển';
            schedule();
          });
        }

        viewport.addEventListener('dragstart', (event) => event.preventDefault());
        slider.addEventListener('mouseenter', () => setPaused(true));
        slider.addEventListener('mouseleave', () => setPaused(false));
        slider.addEventListener('focusin', () => setPaused(true));
        slider.addEventListener('focusout', (event) => {
          if (!slider.contains(event.relatedTarget)) setPaused(false);
        });
        slider.addEventListener('keydown', (event) => {
          if (event.key === 'ArrowLeft') {
            event.preventDefault();
            goTo(current - 1);
          }
          if (event.key === 'ArrowRight') {
            event.preventDefault();
            goTo(current + 1);
          }
        });

        viewport.addEventListener('pointerdown', (event) => {
          if (scrollStory) return;
          if (event.button !== 0 || event.target.closest('button')) return;
          pointerStartX = event.clientX;
          pointerStartTime = performance.now();
          pointerId = event.pointerId;
          dragged = false;
          window.clearTimeout(timer);
          slider.classList.remove('is-running');
          viewport.setPointerCapture(pointerId);
          viewport.classList.add('is-dragging');
        });

        viewport.addEventListener('pointermove', (event) => {
          if (pointerStartX === null || event.pointerId !== pointerId) return;
          const distance = event.clientX - pointerStartX;
          if (Math.abs(distance) > 8) dragged = true;
          track.style.transition = 'none';
          track.style.transform = `translate3d(calc(-${physicalPosition * 100}% + ${distance}px), 0, 0)`;
        });

        viewport.addEventListener('pointerup', (event) => {
          if (pointerStartX === null) return;
          const distance = event.clientX - pointerStartX;
          const elapsed = Math.max(performance.now() - pointerStartTime, 1);
          const velocity = Math.abs(distance) / elapsed;
          pointerStartX = null;
          pointerId = null;
          viewport.classList.remove('is-dragging');
          track.style.transition = '';
          const isSwipe = Math.abs(distance) >= 28 || (Math.abs(distance) >= 10 && velocity >= 0.28);
          if (!isSwipe) {
            goTo(current);
          } else {
            goTo(current + (distance < 0 ? 1 : -1));
          }
        });

        viewport.addEventListener('pointercancel', () => {
          pointerStartX = null;
          pointerId = null;
          viewport.classList.remove('is-dragging');
          track.style.transition = '';
          goTo(current);
        });

        viewport.addEventListener(
          'click',
          (event) => {
            if (!dragged) return;
            event.preventDefault();
            event.stopPropagation();
            dragged = false;
          },
          true
        );

        document.addEventListener('visibilitychange', schedule);
        if (typeof reducedMotion.addEventListener === 'function') {
          reducedMotion.addEventListener('change', schedule);
        }

        slider.addEventListener('award-story-progress', (event) => {
          scrollStory = Boolean(event.detail && event.detail.enabled);
          if (!scrollStory) {
            goTo(current, false);
            return;
          }
          const storyProgress = Math.max(0, Math.min(1, (event.detail.progress - 0.4) / 0.54));
          const rawPosition = storyProgress * (slides.length - 1);
          const segment = Math.floor(rawPosition);
          const blend = Math.max(0, Math.min(1, (rawPosition - segment - 0.35) / 0.65));
          const position = segment + blend * blend * (3 - 2 * blend);
          const index = Math.round(position);
          if (index !== current) goTo(index, false);
          boundaryReset = null;
          track.style.transition = 'none';
          track.style.transform = `translate3d(-${(position + 1) * 100}%, 0, 0)`;
          window.clearTimeout(timer);
          slider.classList.remove('is-running');
        });

        goTo(0, false);
      }
    }

    /* ======================================================================
       3. Shared Image Lightbox (#imgLb)
       ====================================================================== */
    const lb = document.getElementById('imgLb');
    const lbImg = document.getElementById('imgLbImg');
    const lbCounter = document.getElementById('imgLbCounter');
    const lbClose = document.getElementById('imgLbClose');
    const lbPrev = document.getElementById('imgLbPrev');
    const lbNext = document.getElementById('imgLbNext');

    if (lb && lbImg) {
      const groups = {};
      document.querySelectorAll('[data-img-group]').forEach((el) => {
        const g = el.dataset.imgGroup;
        if (!g) return;
        const idx = parseInt(el.dataset.imgIdx || '0', 10);
        const safeIdx = Number.isFinite(idx) && idx >= 0 ? idx : 0;
        if (!groups[g]) groups[g] = [];

        const imgEl = el.tagName === 'IMG' ? el : el.querySelector('img');
        const src = imgEl ? imgEl.getAttribute('src') : '';
        const alt = imgEl ? (imgEl.getAttribute('alt') || '') : '';
        if (!src) return;

        if (!groups[g][safeIdx]) {
          groups[g][safeIdx] = { idx: safeIdx, src, alt };
        }
      });

      let currentGroup = null;
      let currentIdx = 0;
      let swapTimer = null;
      let lastFocusedEl = null;

      const list = () => (groups[currentGroup] || []).filter(Boolean);

      const render = (immediate = false) => {
        const items = list();
        if (!items.length) return;
        const entry = items[currentIdx];
        if (!entry) return;

        window.clearTimeout(swapTimer);
        if (immediate) {
          lbImg.src = entry.src;
          lbImg.alt = entry.alt || '';
          lbImg.style.opacity = '1';
          lbImg.style.transform = 'scale(1)';
        } else {
          lbImg.style.opacity = '0';
          lbImg.style.transform = 'scale(0.97)';
          swapTimer = window.setTimeout(() => {
            lbImg.src = entry.src;
            lbImg.alt = entry.alt || '';
            lbImg.style.opacity = '1';
            lbImg.style.transform = 'scale(1)';
          }, 180);
        }

        if (lbCounter) {
          lbCounter.textContent = `${currentIdx + 1} / ${items.length}`;
        }

        const single = items.length <= 1;
        if (lbPrev) lbPrev.style.display = single ? 'none' : 'flex';
        if (lbNext) lbNext.style.display = single ? 'none' : 'flex';
      };

      const open = (group, idx = 0, triggerEl = null) => {
        if (!groups[group] || !groups[group].length) return;
        currentGroup = group;
        const items = list();
        if (!items.length) return;

        const targetIdx = Number.isFinite(idx) ? idx : 0;
        const matchedPos = items.findIndex((entry) => entry.idx === targetIdx);
        currentIdx =
          matchedPos !== -1
            ? matchedPos
            : ((targetIdx % items.length) + items.length) % items.length;

        lastFocusedEl = triggerEl || document.activeElement;
        render(true);
        lb.classList.add('is-open');
        document.body.style.overflow = 'hidden';

        if (lbClose && typeof lbClose.focus === 'function') {
          requestAnimationFrame(() => {
            lbClose.focus({ preventScroll: true });
          });
        }
      };

      const close = () => {
        window.clearTimeout(swapTimer);
        lb.classList.remove('is-open');
        document.body.style.overflow = '';
        currentGroup = null;
        if (lastFocusedEl && typeof lastFocusedEl.focus === 'function') {
          lastFocusedEl.focus({ preventScroll: true });
        }
        lastFocusedEl = null;
      };

      const nav = (delta) => {
        if (!currentGroup) return;
        const items = list();
        if (!items.length) return;
        currentIdx = (currentIdx + delta + items.length) % items.length;
        render();
      };

      document.querySelectorAll('[data-img-group], [data-img-open-group]').forEach((el) => {
        el.addEventListener('click', (e) => {
          e.preventDefault();
          const group = el.dataset.imgOpenGroup || el.dataset.imgGroup;
          const idx = parseInt(el.dataset.imgOpenIdx || el.dataset.imgIdx || '0', 10);
          open(group, idx, el);
        });
        el.addEventListener('keydown', (e) => {
          if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            const group = el.dataset.imgOpenGroup || el.dataset.imgGroup;
            const idx = parseInt(el.dataset.imgOpenIdx || el.dataset.imgIdx || '0', 10);
            open(group, idx, el);
          }
        });
      });

      if (lbClose) lbClose.addEventListener('click', close);
      if (lbPrev) lbPrev.addEventListener('click', () => nav(-1));
      if (lbNext) lbNext.addEventListener('click', () => nav(1));
      lb.addEventListener('click', (e) => {
        if (e.target === lb) close();
      });
      document.addEventListener('keydown', (e) => {
        if (!lb.classList.contains('is-open')) return;
        if (e.key === 'Escape') close();
        if (e.key === 'ArrowLeft') nav(-1);
        if (e.key === 'ArrowRight') nav(1);
      });
    }
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initShowcase, { once: true });
  } else {
    initShowcase();
  }
})();
