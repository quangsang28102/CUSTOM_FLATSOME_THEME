/**
 * HPO Platform & 6-Subject Curriculum + 5 Modals (M5)
 * Consolidated from WEB-HPO-V2:
 * - HPOStickyScrollSpy (core.js:101-233)
 * - Engine 4-Ky media & SpeechSynthesis voice (engine-media.js, engine-voice.js)
 * - Platform 01/02 accordions, ResizeObserver & auto-open (homepage.js:342-564, homepage-platform-accordion-autoopen.js)
 * - Syllabus subject accordion (media.js:172-213)
 * - 5 active curriculum modals & featured chapter collapse (learning.js:1-861)
 * - Delegated click/keyboard bindings for [data-phan-toggle], .chap--video[data-chap-video-src], [data-chap-video-close]
 */
(() => {
  'use strict';

  const getConfig = () => window.HPO_PLATFORM_CONFIG || {};

  function trimTrailingSlash(url) {
    return String(url || '').replace(/\/+$/, '');
  }

  function resolveDataUrl(filename) {
    const cleanFile = String(filename || '').replace(/^\/+/, '');
    const cfg = getConfig();
    if (cfg.dataBaseUrl) {
      return `${trimTrailingSlash(cfg.dataBaseUrl)}/${cleanFile}`;
    }
    return `assets/data/${cleanFile}`;
  }

  function resolveAssetUrl(rawPath) {
    if (!rawPath) return '';
    const trimmed = String(rawPath).trim();
    if (/^(https?:)?\/\//i.test(trimmed) || trimmed.startsWith('/') || trimmed.startsWith('data:') || trimmed.startsWith('blob:')) {
      return trimmed;
    }
    const cfg = getConfig();
    if (trimmed.startsWith('assets/')) {
      const rel = trimmed.slice('assets/'.length).replace(/^\/+/, '');
      if (cfg.themeAssetsUrl) {
        return `${trimTrailingSlash(cfg.themeAssetsUrl)}/${rel}`;
      }
      if (cfg.themeUrl) {
        return `${trimTrailingSlash(cfg.themeUrl)}/assets/${rel}`;
      }
      return trimmed;
    }
    if (cfg.themeUrl) {
      return `${trimTrailingSlash(cfg.themeUrl)}/${trimmed.replace(/^\/+/, '')}`;
    }
    return trimmed;
  }

  function localizeFragmentHtml(html) {
    const cfg = getConfig();
    const assetsBase = cfg.themeAssetsUrl
      ? `${trimTrailingSlash(cfg.themeAssetsUrl)}/`
      : (cfg.themeUrl ? `${trimTrailingSlash(cfg.themeUrl)}/assets/` : '');
    if (!assetsBase || typeof html !== 'string') return html;

    return html
      .replace(/(src=["'])assets\//gi, `$1${assetsBase}`)
      .replace(/(data-video-src=["'])assets\//gi, `$1${assetsBase}`);
  }

  /* ==========================================================================
     1. Reusable Sticky Table-of-Contents Scroll Spy (core.js:101-233)
     ========================================================================== */
  if (!window.HPOStickyScrollSpy) {
    const instances = new WeakMap();

    const getScrollTop = (scroller) => (scroller === window ? window.scrollY : scroller.scrollTop);

    const getElementTop = (el, scroller) => {
      const rect = el.getBoundingClientRect();
      if (scroller === window) return rect.top + window.scrollY;
      const scrollerRect = scroller.getBoundingClientRect();
      return rect.top - scrollerRect.top + scroller.scrollTop;
    };

    const scrollToPos = (scroller, top, behavior) => {
      const value = Math.max(0, top);
      if (scroller === window) {
        window.scrollTo({ top: value, behavior });
      } else {
        scroller.scrollTo({ top: value, behavior });
      }
    };

    const initStickyScrollSpy = (root, options = {}) => {
      if (!root) return null;
      if (instances.has(root)) return instances.get(root);

      const scroller = options.scrollContainer || window;
      const links = Array.from(root.querySelectorAll(options.linksSelector || '[data-scrollspy-link]'));
      const panes = Array.from(root.querySelectorAll(options.panesSelector || '[data-scrollspy-pane]'));
      const linkId = options.linkId || ((link) => link.dataset.scrollspyLink);
      const paneId = options.paneId || ((pane) => pane.dataset.scrollspyPane);
      const getOffset = options.getOffset || (() => options.offset || 0);
      const onActiveChange = typeof options.onActiveChange === 'function' ? options.onActiveChange : null;
      const stickyWrap = options.stickyWrapSelector ? root.querySelector(options.stickyWrapSelector) : null;
      const ids = links.map(linkId).filter(Boolean);

      if (!links.length || !panes.length || !ids.length) return null;

      const applyOffsets = () => {
        const offset = Math.max(0, Math.round(getOffset() || 0));
        root.style.setProperty('--hpo-scroll-top', offset + 'px');
        if (stickyWrap) stickyWrap.style.setProperty('--hpo-top', offset + 'px');
      };

      let activeId = null;

      const setActive = (nextActiveId) => {
        links.forEach((link) => {
          const isActive = linkId(link) === nextActiveId;
          link.classList.toggle('is-active', isActive);
          if (isActive) link.setAttribute('aria-current', 'true');
          else link.removeAttribute('aria-current');
        });

        if (activeId !== nextActiveId) {
          activeId = nextActiveId;
          if (onActiveChange) onActiveChange(nextActiveId);
        }
      };

      const findPane = (id) => panes.find((pane) => paneId(pane) === id);

      const scrollToPane = (id, behavior = 'smooth') => {
        const pane = findPane(id);
        if (!pane) return;

        applyOffsets();
        const y = getElementTop(pane, scroller) - getOffset() - 12;
        scrollToPos(scroller, y, behavior);
        setActive(id);
      };

      let ticking = false;

      const updateActiveByScroll = () => {
        applyOffsets();

        const topLine = getScrollTop(scroller) + getOffset() + 40;
        let currentId = ids[0];

        panes.forEach((pane) => {
          const id = paneId(pane);
          if (!id || !ids.includes(id)) return;
          if (getElementTop(pane, scroller) <= topLine) {
            currentId = id;
          }
        });

        setActive(currentId);
      };

      const onScroll = () => {
        if (ticking) return;
        ticking = true;
        requestAnimationFrame(() => {
          updateActiveByScroll();
          ticking = false;
        });
      };

      links.forEach((link) => {
        link.addEventListener('click', (event) => {
          const id = linkId(link);
          if (!id) return;
          event.preventDefault();
          scrollToPane(id);
        });
      });

      scroller.addEventListener('scroll', onScroll, { passive: true });
      window.addEventListener('resize', updateActiveByScroll, { passive: true });

      const api = {
        scrollTo: scrollToPane,
        update: updateActiveByScroll,
      };

      instances.set(root, api);
      applyOffsets();
      updateActiveByScroll();
      return api;
    };

    window.HPOStickyScrollSpy = { init: initStickyScrollSpy };
  }

  /* ==========================================================================
     2. Engine 4-Ky Media Playback (engine-media.js)
     ========================================================================== */
  function setupEngineMedia() {
    const videos = new Set();
    const pausedByVisibility = new WeakSet();
    const inViewport = new WeakSet();
    const reducedMotion = () => window.matchMedia?.('(prefers-reduced-motion: reduce)').matches ?? false;

    function loadVideo(video) {
      if (video.dataset.engineVideoLoaded === 'true') return;
      const source = video.dataset.videoSrc;
      if (!source) return;

      video.src = resolveAssetUrl(source);
      video.dataset.engineVideoLoaded = 'true';
      video.load();
    }

    function playVideo(video) {
      if (reducedMotion() || video.dataset.userPaused === 'true') return;
      const playRequest = video.play();
      if (playRequest?.catch) playRequest.catch(() => {});
    }

    const observer = 'IntersectionObserver' in window
      ? new IntersectionObserver((entries) => {
          entries.forEach((entry) => {
            const video = entry.target;
            if (entry.isIntersecting) {
              inViewport.add(video);
              loadVideo(video);
              playVideo(video);
            } else {
              inViewport.delete(video);
              if (!video.paused) {
                pausedByVisibility.add(video);
                video.pause();
              }
            }
          });
        }, { rootMargin: '0px', threshold: 0.12 })
      : null;

    function initializeEngineVideoPlayback(root = document) {
      if (!root?.querySelectorAll) return;
      root.querySelectorAll('video[data-engine-video]').forEach((video) => {
        if (video.dataset.engineVideoReady === 'true') return;
        video.dataset.engineVideoReady = 'true';
        video.muted = true;
        video.loop = true;
        video.playsInline = true;
        videos.add(video);

        video.addEventListener('play', () => {
          video.dataset.userPaused = 'false';
        });
        video.addEventListener('pause', () => {
          if (pausedByVisibility.delete(video)) return;
          video.dataset.userPaused = 'true';
        });

        if (observer) {
          observer.observe(video);
        } else {
          loadVideo(video);
          playVideo(video);
        }
      });
    }

    document.addEventListener('visibilitychange', () => {
      if (document.hidden) {
        videos.forEach((video) => {
          if (!video.paused) {
            pausedByVisibility.add(video);
            video.pause();
          }
        });
        return;
      }

      videos.forEach((video) => {
        if (inViewport.has(video)) playVideo(video);
      });
    });

    window.initializeEngineVideoPlayback = initializeEngineVideoPlayback;
    initializeEngineVideoPlayback(document);
  }

  /* ==========================================================================
     3. Engine 4-Ky SpeechSynthesis Voice (engine-voice.js)
     ========================================================================== */
  function setupEngineVoice() {
    const modal = document.getElementById('engineViewModal');
    const scroller = document.getElementById('engineViewScroll');
    const toggle = document.getElementById('engineVoiceToggle');
    const speech = window.speechSynthesis;
    const canSpeak = Boolean(
      speech && window.SpeechSynthesisUtterance && window.IntersectionObserver,
    );

    if (!modal || !scroller || !toggle) return;

    let enabled = false;
    let observer = null;
    let activeCopy = null;
    let speakingCopy = null;
    let activeUtterance = null;
    let pendingCopy = null;
    let speakTimer = 0;
    let scrollFrame = 0;
    const visibleCopies = new Set();

    function updateToggle() {
      toggle.setAttribute('aria-pressed', String(enabled));
      toggle.setAttribute('aria-label', enabled ? 'Tắt giọng đọc' : 'Bật giọng đọc');
      toggle.title = enabled ? 'Tắt giọng đọc' : 'Bật giọng đọc';
    }

    function clearPendingSpeech() {
      window.clearTimeout(speakTimer);
      speakTimer = 0;
      pendingCopy = null;
    }

    function setItemButtonState(copy, isSpeaking) {
      const button = copy.querySelector('.engine-view-item-voice');
      if (!button) return;
      button.setAttribute('aria-pressed', String(isSpeaking));
      const label = isSpeaking ? 'Dừng đọc mục này' : 'Đọc mục này';
      button.setAttribute('aria-label', label);
      button.title = label;
    }

    function cancelSpeech() {
      clearPendingSpeech();
      if (speakingCopy) setItemButtonState(speakingCopy, false);
      speakingCopy = null;
      activeUtterance = null;
      if (canSpeak) speech.cancel();
    }

    function textFor(copy) {
      const heading = copy.querySelector('.step-title')?.textContent.trim();
      const paragraphs = Array.from(copy.querySelectorAll('.p'), (paragraph) =>
        paragraph.textContent
          .replace(/^\s*[-–—•]+\s*/, '')
          .replace(/\s+/g, ' ')
          .trim(),
      ).filter(Boolean);

      return [heading, ...paragraphs].filter(Boolean).join('. ');
    }

    function speak(copy) {
      if (!enabled || !canSpeak || !copy || !modal.classList.contains('is-open')) return;

      const text = textFor(copy);
      if (!text) return;

      cancelSpeech();
      const utterance = new window.SpeechSynthesisUtterance(text);
      utterance.lang = 'vi-VN';
      utterance.rate = 0.94;
      const vietnameseVoice = speech.getVoices().find((voice) => /^vi([_-]|$)/i.test(voice.lang));
      if (vietnameseVoice) utterance.voice = vietnameseVoice;
      speakingCopy = copy;
      activeUtterance = utterance;
      setItemButtonState(copy, true);
      const finish = () => {
        if (activeUtterance !== utterance) return;
        setItemButtonState(copy, false);
        speakingCopy = null;
        activeUtterance = null;
      };
      utterance.onend = finish;
      utterance.onerror = finish;
      speech.speak(utterance);
    }

    function addItemButton(copy) {
      if (copy.querySelector('.engine-view-item-voice')) return;

      const button = document.createElement('button');
      button.type = 'button';
      button.className = 'engine-view-item-voice';
      button.setAttribute('aria-pressed', 'false');
      button.setAttribute('aria-label', 'Đọc mục này');
      button.title = 'Đọc mục này';
      button.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 5 6 9H2v6h4l5 4V5z"/><path d="M15.5 8.5a5 5 0 0 1 0 7"/><path d="M19 5a10 10 0 0 1 0 14"/></svg>';

      if (canSpeak) {
        button.addEventListener('click', () => {
          if (speakingCopy === copy) {
            cancelSpeech();
            return;
          }

          if (!enabled) {
            enabled = true;
            updateToggle();
          }
          activeCopy = copy;
          speak(copy);
        });
      } else {
        button.disabled = true;
        button.setAttribute('aria-label', 'Trình duyệt không hỗ trợ đọc văn bản');
        button.title = 'Trình duyệt không hỗ trợ đọc văn bản';
      }

      const titleRow = copy.querySelector('.step-title-row');
      if (titleRow) {
        titleRow.append(button);
      } else {
        const actions = document.createElement('div');
        actions.className = 'engine-view-item-actions';
        actions.append(button);
        copy.insertBefore(actions, copy.firstChild);
      }

      if (canSpeak) setItemButtonState(copy, false);
    }

    function copyAtReadingLine() {
      let bestCopy = null;
      const scrollerBounds = scroller.getBoundingClientRect();
      const visibleTop = scrollerBounds.top + scroller.clientTop;
      const readingLine = visibleTop + Math.min(scroller.clientHeight * 0.25, 190);
      let bestDistance = Infinity;

      visibleCopies.forEach((copy) => {
        const bounds = copy.getBoundingClientRect();
        const distance = readingLine < bounds.top
          ? bounds.top - readingLine
          : readingLine > bounds.bottom
            ? readingLine - bounds.bottom
            : 0;
        if (distance < bestDistance) {
          bestCopy = copy;
          bestDistance = distance;
        }
      });

      return bestCopy;
    }

    function scheduleSpeech(copy, delay = 180) {
      clearPendingSpeech();
      if (!copy || !enabled) return;

      pendingCopy = copy;
      speakTimer = window.setTimeout(() => {
        speakTimer = 0;
        if (pendingCopy !== copy) return;
        pendingCopy = null;
        speak(copy);
      }, delay);
    }

    function updateActiveCopy() {
      const nextCopy = copyAtReadingLine();
      if (nextCopy === activeCopy) return;

      activeCopy = nextCopy;
      cancelSpeech();
      if (nextCopy) scheduleSpeech(nextCopy);
    }

    function initialize(root = scroller) {
      if (!root?.querySelectorAll) return;

      const copies = root.querySelectorAll('.engine-media-copy');
      if (!copies.length) return;
      copies.forEach(addItemButton);
      if (!canSpeak || observer) return;

      observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting && entry.intersectionRatio > 0) {
            visibleCopies.add(entry.target);
          } else {
            visibleCopies.delete(entry.target);
          }
        });
        updateActiveCopy();
      }, {
        root: scroller,
        threshold: [0, 0.15, 0.3, 0.5, 0.75],
      });

      copies.forEach((copy) => observer.observe(copy));
      scroller.addEventListener('scroll', () => {
        if (scrollFrame) return;
        scrollFrame = window.requestAnimationFrame(() => {
          scrollFrame = 0;
          updateActiveCopy();
        });
      }, { passive: true });
    }

    toggle.addEventListener('click', () => {
      enabled = !enabled;
      updateToggle();

      if (!enabled) {
        cancelSpeech();
        return;
      }

      activeCopy = copyAtReadingLine();
      speak(activeCopy);
    });

    if (!canSpeak) {
      enabled = false;
      toggle.disabled = true;
      toggle.setAttribute('aria-label', 'Trình duyệt không hỗ trợ đọc văn bản');
      toggle.title = 'Trình duyệt không hỗ trợ đọc văn bản';
      toggle.setAttribute('aria-pressed', 'false');
    } else {
      updateToggle();
    }

    window.initializeEngineVoice = initialize;
    window.stopEngineVoice = () => {
      cancelSpeech();
      activeCopy = null;
      visibleCopies.clear();
      enabled = false;
      updateToggle();
    };
  }

  /* ==========================================================================
     4. Platform 01 & 02 Accordions, ResizeObserver, AutoController & Auto-Open
     ========================================================================== */
  function setupPlatformAccordions() {
    let learningAutoController = null;
    let practiceYouTubePlayer = null;

    document.querySelectorAll('.platform-acc').forEach((accGroup) => {
      const items = Array.from(accGroup.querySelectorAll('.pacc-item'));
      const section = accGroup.closest('.platform-v2-panel, section');
      if (!section || !items.length) return;
      const platformImg = section.querySelector('.platform-circle img');
      const platformVideo = section.querySelector('[data-platform-video]');
      if (!platformImg && !platformVideo) return;
      const stackedBody = accGroup.closest('.platform-v2-body--stacked');
      const scopeItems = items;
      const platformVisual = section.querySelector('.platform-v2-panel-visual');
      const platformCaption = section.querySelector('.platform-circle-cap--v2');

      const swap = (item) => {
        const imgAttr = item.dataset.img || '';
        const isFace = imgAttr.includes('xacthuc') || imgAttr.includes('xac-thuc');
        platformVisual?.classList.toggle('is-face-preview', isFace);

        if (platformVideo && item.dataset.videoId) {
          const videoId = item.dataset.videoId;
          if (practiceYouTubePlayer?.cueVideoById) {
            practiceYouTubePlayer.cueVideoById(videoId);
          } else {
            const url = new URL(`https://www.youtube-nocookie.com/embed/${encodeURIComponent(videoId)}`);
            url.searchParams.set('playsinline', '1');
            url.searchParams.set('enablejsapi', '1');
            if (window.location.origin !== 'null') {
              url.searchParams.set('origin', window.location.origin);
            }
            platformVideo.src = url.toString();
          }
          platformVideo.title = 'Video ' + (item.dataset.title || 'practice');
          return;
        }

        const src = resolveAssetUrl(imgAttr);
        if (!platformImg || !src) return;
        platformImg.alt = item.dataset.title || '';
        platformImg.src = src;
        platformImg.style.opacity = '1';
        platformImg.style.removeProperty('transform');
      };

      const setState = (item, isActive) => {
        item.classList.toggle('is-active', isActive);
        const button = item.querySelector('.pacc-head');
        const body = item.querySelector('.pacc-body');
        if (button) button.setAttribute('aria-expanded', isActive ? 'true' : 'false');
        if (body) body.setAttribute('aria-hidden', isActive ? 'false' : 'true');
      };

      const activate = (item, allowToggle = true) => {
        const wasActive = item.classList.contains('is-active');
        if (allowToggle && wasActive) {
          if (platformVideo) practiceYouTubePlayer?.pauseVideo?.();
          scopeItems.forEach((card) => setState(card, false));
          section.classList.remove('has-active-accordion');
          return;
        }
        scopeItems.forEach((card) => setState(card, card === item));
        section.classList.add('has-active-accordion');
        swap(item);
        if (platformCaption && item.dataset.title) platformCaption.textContent = item.dataset.title;
      };

      items.forEach((item) => {
        setState(item, item.classList.contains('is-active'));
        item.addEventListener('click', () => {
          activate(item);
          if (learningAutoController && stackedBody) learningAutoController.defer();
        });
      });

      section.classList.toggle('has-active-accordion', items.some((item) => item.classList.contains('is-active')));
      accGroup.__activateLearningItem = (item) => activate(item, false);
    });

    /* Equal-height accordion cards via ResizeObserver */
    (() => {
      const stackedBody = document.querySelector('.platform-v2-body--stacked');
      if (!stackedBody) return;
      const items = Array.from(stackedBody.querySelectorAll('.platform-acc--v2 .pacc-item'));
      if (!items.length) return;

      const updateHeights = () => {
        stackedBody.style.setProperty('--platform-acc-head-height', 'auto');
        stackedBody.style.removeProperty('--platform-acc-content-height');

        const headHeight = Math.max(
          ...items.map((item) => item.querySelector('.pacc-head')?.getBoundingClientRect().height || 0),
        );
        const contentHeight = Math.max(
          ...items.map((item) => item.querySelector('.pacc-body > p')?.getBoundingClientRect().height || 0),
        );

        if (headHeight) stackedBody.style.setProperty('--platform-acc-head-height', `${Math.ceil(headHeight)}px`);
        if (contentHeight) {
          stackedBody.style.setProperty('--platform-acc-content-height', `${Math.ceil(contentHeight + 4)}px`);
        }
      };

      updateHeights();
      let resizeFrame = 0;
      window.addEventListener('resize', () => {
        window.cancelAnimationFrame(resizeFrame);
        resizeFrame = window.requestAnimationFrame(updateHeights);
      }, { passive: true });
      document.fonts?.ready?.then(updateHeights);

      if (window.ResizeObserver) {
        const observer = new ResizeObserver(() => updateHeights());
        items.forEach((item) => {
          const paragraph = item.querySelector('.pacc-body > p');
          if (paragraph) observer.observe(paragraph);
        });
      }
    })();

    /* learningAutoController (guarded by data-auto-advance !== 'false') */
    (() => {
      const stackedBody = document.querySelector('.platform-v2-body--stacked');
      if (!stackedBody) return;
      const groups = Array.from(stackedBody.querySelectorAll('.platform-acc'))
        .filter((group) => group.dataset.autoAdvance !== 'false');
      if (!groups.length) return;
      const groupItems = groups.map((group) => Array.from(group.querySelectorAll('.pacc-item')));
      const sequence = [];
      const maxItems = Math.max(...groupItems.map((items) => items.length));
      for (let index = 0; index < maxItems; index += 1) {
        groupItems.forEach((items) => {
          if (items[index]) sequence.push(items[index]);
        });
      }
      const reduceMotion = window.matchMedia?.('(prefers-reduced-motion: reduce)').matches;
      if (sequence.length < 2 || reduceMotion) return;

      const activeIndex = sequence.findIndex((item) => item.classList.contains('is-active'));
      let cursor = activeIndex < 0 ? 0 : (activeIndex + 1) % sequence.length;
      let timerId = null;
      let videoIsPlaying = false;
      const stop = () => {
        if (timerId) window.clearTimeout(timerId);
        timerId = null;
      };
      const schedule = (delay = 3000) => {
        stop();
        if (
          videoIsPlaying ||
          document.hidden ||
          stackedBody.matches(':hover') ||
          stackedBody.contains(document.activeElement)
        ) return;
        timerId = window.setTimeout(() => {
          const item = sequence[cursor % sequence.length];
          const group = item.closest('.platform-acc');
          if (group?.__activateLearningItem) group.__activateLearningItem(item);
          cursor = (cursor + 1) % sequence.length;
          schedule();
        }, delay);
      };
      learningAutoController = {
        defer: () => schedule(4500),
        setVideoPlaying: (isPlaying) => {
          videoIsPlaying = isPlaying;
          if (isPlaying) stop();
          else schedule();
        },
      };
      stackedBody.addEventListener('mouseenter', stop);
      stackedBody.addEventListener('mouseleave', () => schedule(800));
      stackedBody.addEventListener('focusin', stop);
      stackedBody.addEventListener('focusout', (event) => {
        if (!stackedBody.contains(event.relatedTarget)) schedule(800);
      });
      document.addEventListener('visibilitychange', () => {
        if (document.hidden) stop();
        else schedule(1000);
      });
      schedule(1500);
    })();

    /* Optional YouTube iframe API pause hook when [data-platform-video] exists */
    (() => {
      const iframe = document.querySelector('[data-platform-video]');
      if (!iframe) return;

      const initPlayer = () => {
        if (!window.YT?.Player || practiceYouTubePlayer) return;
        practiceYouTubePlayer = new window.YT.Player(iframe, {
          events: {
            onStateChange: (event) => {
              const states = window.YT.PlayerState;
              const isPlaying = event.data === states.PLAYING || event.data === states.BUFFERING;
              learningAutoController?.setVideoPlaying(isPlaying);
            },
          },
        });
      };

      if (window.YT?.Player) {
        initPlayer();
        return;
      }

      const previousReadyHandler = window.onYouTubeIframeAPIReady;
      window.onYouTubeIframeAPIReady = function onYouTubeIframeAPIReady(...args) {
        try {
          if (typeof previousReadyHandler === 'function') previousReadyHandler.apply(this, args);
        } finally {
          initPlayer();
        }
      };

      if (!document.querySelector('script[src="https://www.youtube.com/iframe_api"]')) {
        const script = document.createElement('script');
        script.src = 'https://www.youtube.com/iframe_api';
        script.async = true;
        document.head.appendChild(script);
      }
    })();

    /* Auto-open first item per .platform-acc group on first viewport intersection */
    (() => {
      const groups = Array.from(document.querySelectorAll('.platform-v2-body--stacked .platform-acc'));
      if (!groups.length || !('IntersectionObserver' in window)) return;

      const openFirst = (group) => {
        const items = group.querySelectorAll('.pacc-item');
        const anyOpen = Array.from(items).some((item) => item.classList.contains('is-active'));
        if (!items.length || anyOpen || typeof group.__activateLearningItem !== 'function') return;
        group.__activateLearningItem(items[0]);
        items[0].classList.add('is-auto-highlight');
        items[0].addEventListener('animationend', () => items[0].classList.remove('is-auto-highlight'), { once: true });
        window.setTimeout(() => items[0].classList.remove('is-auto-highlight'), 2500);
      };

      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;
          observer.unobserve(entry.target);
          openFirst(entry.target);
        });
      }, { rootMargin: (window.navigator?.webdriver ? '0px' : '0px 0px -10% 0px'), threshold: 0.05 });

      groups.forEach((group) => {
        group.addEventListener('click', () => observer.unobserve(group), { once: true });
        observer.observe(group);
      });
    })();
  }

  /* ==========================================================================
     5. Syllabus Subject Row Accordion (.syll-down / .syll-row)
     ========================================================================== */
  function setupSyllabusAccordions() {
    const arrows = document.querySelectorAll('.syll-down');
    if (!arrows.length) return;

    arrows.forEach((arrow) => {
      arrow.addEventListener('click', (e) => {
        e.stopPropagation();
        const target = arrow.dataset.toggle;
        const detailId = 'syllDetail-' + target;
        const section = arrow.closest('.syll');
        const detail = Array.from(
          section?.querySelectorAll('.syll-detail') || [],
        ).find(
          (item) => item.id === detailId || item.id.startsWith(detailId + '-'),
        );
        if (!detail) return;
        const isOpen = arrow.getAttribute('aria-expanded') === 'true';
        document.querySelectorAll('.syll-down').forEach((a) => a.setAttribute('aria-expanded', 'false'));
        document.querySelectorAll('.syll-detail').forEach((d) => d.classList.remove('is-open'));
        if (!isOpen) {
          arrow.setAttribute('aria-expanded', 'true');
          detail.classList.add('is-open');
        }
      });
    });

    document.querySelectorAll('.syll-row').forEach((row) => {
      const arrow = row.querySelector('.syll-down');
      if (!arrow) return;
      row.style.cursor = 'pointer';
      row.addEventListener('click', (e) => {
        if (e.target.closest('.syll-play')) return;
        if (e.target.closest('.syll-down')) return;
        arrow.click();
      });
    });
  }

  /* ==========================================================================
     6. Five Curriculum Modals & Nested .phan / .chap.is-featured Accordions
     ========================================================================== */
  function setupCurriculumModalsAndAccordions() {
    /* 6.1 Biển báo modal view */
    (() => {
      const modal = document.getElementById('bbViewModal');
      const scroller = document.getElementById('bbViewScroll');
      const closeBtn = document.getElementById('bbViewClose');
      const title = document.getElementById('bbViewTitle');
      const triggers = document.querySelectorAll('.bb-card[data-bb-view]');
      if (!modal || !scroller || !closeBtn || !triggers.length) return;

      const DATA_URL = resolveDataUrl('bien-bao-view.html');
      const TITLES = {
        'bien-cam': 'Biển báo cấm',
        'nguy-hiem': 'Biển nguy hiểm',
        'hieu-lenh': 'Biển hiệu lệnh',
        'chi-dan': 'Biển chỉ dẫn',
        'bien-phu': 'Biển phụ',
      };

      let htmlPromise = null;
      let loaded = false;
      let spy = null;
      let lastFocus = null;
      let previousBodyOverflow = '';

      function updateModalTitle(activeId) {
        if (title) title.textContent = TITLES[activeId] || '5 loại biển báo';
      }

      async function loadContent() {
        if (loaded) return;

        if (!htmlPromise) {
          htmlPromise = fetch(DATA_URL)
            .then((response) => {
              if (!response.ok) throw new Error('Không tải được nội dung biển báo');
              return response.text();
            })
            .then(localizeFragmentHtml);
        }

        try {
          scroller.innerHTML = await htmlPromise;
          loaded = true;
        } catch (error) {
          htmlPromise = null;
          scroller.innerHTML = '<div class="bb-view-loading">Không tải được nội dung biển báo. Vui lòng kiểm tra file assets/data/bien-bao-view.html.</div>';
          throw error;
        }
      }

      function initSpy() {
        const page = scroller.querySelector('#hpo-sign-page');
        if (!page || !window.HPOStickyScrollSpy) return null;

        spy = window.HPOStickyScrollSpy.init(page, {
          scrollContainer: scroller,
          linksSelector: '#hpo-sign-tabs a[data-hpo-tab]',
          panesSelector: '[data-hpo-pane]',
          stickyWrapSelector: '#hpo-sign-sidebar-wrap',
          linkId: (link) => link.getAttribute('data-hpo-tab'),
          paneId: (pane) => pane.getAttribute('data-hpo-pane'),
          getOffset: () => (window.matchMedia('(max-width: 900px)').matches ? 0 : 16),
          onActiveChange: updateModalTitle,
        });

        return spy;
      }

      function waitForImages(root) {
        const images = Array.from(root.querySelectorAll('img'));
        if (!images.length) return Promise.resolve();

        return Promise.allSettled(images.map((img) => {
          if (img.complete) return Promise.resolve();
          return new Promise((resolve) => {
            img.addEventListener('load', resolve, { once: true });
            img.addEventListener('error', resolve, { once: true });
          });
        }));
      }

      async function openSignView(target = 'bien-cam') {
        lastFocus = document.activeElement;
        previousBodyOverflow = document.body.style.overflow;
        document.body.style.overflow = 'hidden';
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        updateModalTitle(target);

        try {
          await loadContent();
        } catch (_) {
          return;
        }

        const api = initSpy();

        const alignToTarget = () => {
          if (!modal.classList.contains('is-open')) return;
          if (api) api.scrollTo(target, 'auto');
          updateModalTitle(target);
        };

        alignToTarget();
        requestAnimationFrame(() => {
          alignToTarget();
          closeBtn.focus({ preventScroll: true });
        });

        setTimeout(alignToTarget, 250);
        waitForImages(scroller).then(alignToTarget);
      }

      function closeSignView() {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = previousBodyOverflow;
        if (lastFocus && typeof lastFocus.focus === 'function') {
          lastFocus.focus({ preventScroll: true });
        }
      }

      triggers.forEach((trigger) => {
        trigger.addEventListener('click', (event) => {
          event.preventDefault();
          openSignView(trigger.dataset.bbView);
        });
      });

      closeBtn.addEventListener('click', closeSignView);
      modal.addEventListener('click', (event) => {
        if (event.target === modal) closeSignView();
      });
      document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal.classList.contains('is-open')) {
          closeSignView();
        }
      });

      window.openBienBaoView = openSignView;
    })();

    /* 6.2 Sa hình modal view */
    (() => {
      const modal = document.getElementById('shViewModal');
      const scroller = document.getElementById('shViewScroll');
      const closeBtn = document.getElementById('shViewClose');
      const title = document.getElementById('shViewTitle');
      const triggers = document.querySelectorAll('.sa-card[data-sh-view]');
      if (!modal || !scroller || !closeBtn || !triggers.length) return;

      const DATA_URL = resolveDataUrl('sa-hinh-view.html');
      const TITLES = {
        'nguyen-tac-1': 'Xe có đường riêng',
        'nguyen-tac-2': 'Quyền bình đẳng xe vào nơi đường giao nhau',
        'nguyen-tac-3': 'Xe ưu tiên theo luật giao thông đường bộ',
        'nguyen-tac-4': 'Xe ở đường ưu tiên',
        'nguyen-tac-5': 'Xe có quyền ưu tiên bên phải',
        'nguyen-tac-6': 'Quyền ưu tiên đối với xe đi cùng đoàn, cùng hướng',
        'nguyen-tac-7': 'Xe phải nhường đường khi rẽ trái',
      };

      let htmlPromise = null;
      let loaded = false;
      let spy = null;
      let lastFocus = null;
      let previousBodyOverflow = '';

      function updateModalTitle(activeId) {
        if (title) title.textContent = TITLES[activeId] || 'Nguyên tắc đi sa hình';
      }

      async function loadContent() {
        if (loaded) return;

        if (!htmlPromise) {
          htmlPromise = fetch(DATA_URL)
            .then((response) => {
              if (!response.ok) throw new Error('Không tải được nội dung sa hình');
              return response.text();
            })
            .then(localizeFragmentHtml);
        }

        try {
          scroller.innerHTML = await htmlPromise;
          loaded = true;
        } catch (error) {
          htmlPromise = null;
          scroller.innerHTML = '<div class="sh-view-loading">Không tải được nội dung sa hình. Vui lòng kiểm tra file assets/data/sa-hinh-view.html.</div>';
          throw error;
        }
      }

      function initSpy() {
        const page = scroller.querySelector('#hpo-sh-page');
        if (!page || !window.HPOStickyScrollSpy) return null;

        spy = window.HPOStickyScrollSpy.init(page, {
          scrollContainer: scroller,
          linksSelector: '#hpo-sh-tabs [data-sh-tab]',
          panesSelector: '[data-sh-pane]',
          stickyWrapSelector: '#hpo-sh-sidebar-wrap',
          linkId: (link) => link.getAttribute('data-sh-tab'),
          paneId: (pane) => pane.getAttribute('data-sh-pane'),
          getOffset: () => (window.matchMedia('(max-width: 900px)').matches ? 0 : 16),
          onActiveChange: updateModalTitle,
        });

        return spy;
      }

      function waitForImages(root) {
        const images = Array.from(root.querySelectorAll('img'));
        if (!images.length) return Promise.resolve();

        return Promise.allSettled(images.map((img) => {
          if (img.complete) return Promise.resolve();
          return new Promise((resolve) => {
            img.addEventListener('load', resolve, { once: true });
            img.addEventListener('error', resolve, { once: true });
          });
        }));
      }

      async function openSaHinhView(target = 'nguyen-tac-1') {
        lastFocus = document.activeElement;
        previousBodyOverflow = document.body.style.overflow;
        document.body.style.overflow = 'hidden';
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        updateModalTitle(target);

        try {
          await loadContent();
        } catch (_) {
          return;
        }

        const api = initSpy();

        const alignToTarget = () => {
          if (!modal.classList.contains('is-open')) return;
          if (api) api.scrollTo(target, 'auto');
          updateModalTitle(target);
        };

        alignToTarget();
        requestAnimationFrame(() => {
          alignToTarget();
          closeBtn.focus({ preventScroll: true });
        });

        setTimeout(alignToTarget, 250);
        waitForImages(scroller).then(alignToTarget);
      }

      function closeSaHinhView() {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = previousBodyOverflow;
        scroller.querySelectorAll('iframe').forEach((frame) => {
          frame.src = frame.src;
        });
        if (lastFocus && typeof lastFocus.focus === 'function') {
          lastFocus.focus({ preventScroll: true });
        }
      }

      triggers.forEach((trigger) => {
        trigger.addEventListener('click', (event) => {
          event.preventDefault();
          openSaHinhView(trigger.dataset.shView);
        });
      });

      closeBtn.addEventListener('click', closeSaHinhView);
      modal.addEventListener('click', (event) => {
        if (event.target === modal) closeSaHinhView();
      });
      document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal.classList.contains('is-open')) {
          closeSaHinhView();
        }
      });

      window.openSaHinhView = openSaHinhView;
    })();

    /* 6.3 Lỗi sa hình modal view */
    (() => {
      const modal = document.getElementById('lshViewModal');
      const scroller = document.getElementById('lshViewScroll');
      const closeBtn = document.getElementById('lshViewClose');
      const title = document.getElementById('lshViewTitle');
      const triggers = document.querySelectorAll('.sa-card[data-lsh-view]');
      if (!modal || !scroller || !closeBtn || !triggers.length) return;

      const DATA_URL = resolveDataUrl('loi-sa-hinh-view.html');
      const TITLES = {
        'bai-1': 'Bài thi Xuất phát',
        'bai-2': 'Dừng xe nhường đường cho người đi bộ',
        'bai-3': 'Dừng xe và khởi hành ngang dốc',
        'bai-4': 'Qua vệt bánh xe và đường hẹp vuông góc',
        'bai-5': 'Qua ngã tư có đèn tín hiệu giao thông',
        'bai-6': 'Đường vòng quanh co',
        'bai-7': 'Ghép xe dọc vào nơi đỗ',
        'bai-8': 'Tạm dừng ở nơi có đường sắt chạy qua',
        'bai-9': 'Thay đổi số trên đường bằng',
        'bai-10': 'Ghép xe ngang vào nơi đỗ',
        'bai-11': 'Bài kết thúc',
      };

      let htmlPromise = null;
      let loaded = false;
      let videosReady = false;
      let videoObserver = null;
      let lastFocus = null;
      let previousBodyOverflow = '';

      function updateModalTitle(activeId) {
        if (title) title.textContent = TITLES[activeId] || '11 bài thi sa hình';
      }

      async function loadContent() {
        if (loaded) return;

        if (!htmlPromise) {
          htmlPromise = fetch(DATA_URL)
            .then((response) => {
              if (!response.ok) throw new Error('Không tải được nội dung lỗi sa hình');
              return response.text();
            })
            .then(localizeFragmentHtml);
        }

        try {
          scroller.innerHTML = await htmlPromise;
          loaded = true;
        } catch (error) {
          htmlPromise = null;
          scroller.innerHTML = '<div class="lsh-view-loading">Không tải được nội dung lỗi sa hình. Vui lòng kiểm tra file assets/data/loi-sa-hinh-view.html.</div>';
          throw error;
        }
      }

      function initSpy() {
        const page = scroller.querySelector('#hpo-shl-page');
        if (!page || !window.HPOStickyScrollSpy) return null;

        return window.HPOStickyScrollSpy.init(page, {
          scrollContainer: scroller,
          linksSelector: '#hpo-shl-tabs a[data-shl-tab]',
          panesSelector: '[data-shl-pane]',
          stickyWrapSelector: '#hpo-shl-sidebar-wrap',
          linkId: (link) => link.getAttribute('data-shl-tab'),
          paneId: (pane) => pane.getAttribute('data-shl-pane'),
          getOffset: () => (window.matchMedia('(max-width: 900px)').matches ? 0 : 16),
          onActiveChange: updateModalTitle,
        });
      }

      function initVideos() {
        if (videosReady) return;
        const videos = Array.from(scroller.querySelectorAll('.hpo-shl__video video'));
        if (!videos.length) return;

        videos.forEach((video) => {
          try {
            video.muted = true;
            video.loop = true;
            video.autoplay = true;
            video.playsInline = true;
            video.setAttribute('muted', '');
            video.setAttribute('loop', '');
            video.setAttribute('autoplay', '');
            video.setAttribute('playsinline', '');
            video.preload = video.preload || 'metadata';
          } catch (_) {}
        });

        if ('IntersectionObserver' in window) {
          videoObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
              const video = entry.target;
              if (entry.isIntersecting && entry.intersectionRatio >= 0.55) {
                video.play?.().catch(() => {});
              } else {
                video.pause?.();
              }
            });
          }, {
            root: scroller,
            threshold: [0, 0.25, 0.55, 0.75, 1],
          });

          videos.forEach((video) => videoObserver.observe(video));
        } else {
          videos.forEach((video) => video.play?.().catch(() => {}));
        }

        videosReady = true;
      }

      function pauseVideos() {
        scroller.querySelectorAll('.hpo-shl__video video').forEach((video) => {
          try {
            video.pause();
          } catch (_) {}
        });
      }

      function playVisibleVideo() {
        const videos = Array.from(scroller.querySelectorAll('.hpo-shl__video video'));
        const scrollerRect = scroller.getBoundingClientRect();

        videos.forEach((video) => {
          const rect = video.getBoundingClientRect();
          const visible = Math.min(rect.bottom, scrollerRect.bottom) - Math.max(rect.top, scrollerRect.top);
          const ratio = rect.height ? visible / rect.height : 0;
          if (ratio >= 0.55) video.play?.().catch(() => {});
          else video.pause?.();
        });
      }

      async function openLoiSaHinhView(target = 'bai-1') {
        lastFocus = document.activeElement;
        previousBodyOverflow = document.body.style.overflow;
        document.body.style.overflow = 'hidden';
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        updateModalTitle(target);

        try {
          await loadContent();
        } catch (_) {
          return;
        }

        const api = initSpy();
        initVideos();

        const alignToTarget = () => {
          if (!modal.classList.contains('is-open')) return;
          if (api) api.scrollTo(target, 'auto');
          setTimeout(playVisibleVideo, 80);
        };

        requestAnimationFrame(() => {
          scroller.scrollTop = 0;
          requestAnimationFrame(() => {
            alignToTarget();
            closeBtn.focus({ preventScroll: true });
          });
        });

        setTimeout(alignToTarget, 250);
      }

      function closeLoiSaHinhView() {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = previousBodyOverflow;
        pauseVideos();
        if (lastFocus && typeof lastFocus.focus === 'function') {
          lastFocus.focus({ preventScroll: true });
        }
      }

      triggers.forEach((trigger) => {
        trigger.addEventListener('click', (event) => {
          event.preventDefault();
          openLoiSaHinhView(trigger.dataset.lshView);
        });
      });

      closeBtn.addEventListener('click', closeLoiSaHinhView);
      modal.addEventListener('click', (event) => {
        if (event.target === modal) closeLoiSaHinhView();
      });
      document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal.classList.contains('is-open')) {
          closeLoiSaHinhView();
        }
      });

      window.openLoiSaHinhView = openLoiSaHinhView;
    })();

    /* 6.4 Động cơ 4 kỳ modal view */
    (() => {
      const modal = document.getElementById('engineViewModal');
      const scroller = document.getElementById('engineViewScroll');
      const closeBtn = document.getElementById('engineViewClose');
      const triggers = document.querySelectorAll('.chap[data-engine-view]');
      if (!modal || !scroller || !closeBtn || !triggers.length) return;

      const DATA_URL = resolveDataUrl('engine-4ky-view.html');
      let htmlPromise = null;
      let loaded = false;
      let lastFocus = null;
      let previousBodyOverflow = '';

      async function loadContent() {
        if (loaded) return;

        if (!htmlPromise) {
          htmlPromise = fetch(DATA_URL)
            .then((response) => {
              if (!response.ok) throw new Error('Không tải được nội dung động cơ 4 kỳ');
              return response.text();
            })
            .then(localizeFragmentHtml);
        }

        try {
          scroller.innerHTML = await htmlPromise;
          loaded = true;
          window.initializeEngineVideoPlayback?.(scroller);
          window.initializeEngineVoice?.(scroller);
        } catch (error) {
          htmlPromise = null;
          scroller.innerHTML = '<div class="engine-view-loading">Không tải được nội dung động cơ 4 kỳ. Vui lòng kiểm tra file assets/data/engine-4ky-view.html.</div>';
          throw error;
        }
      }

      async function openEngineView() {
        lastFocus = document.activeElement;
        previousBodyOverflow = document.body.style.overflow;
        document.body.style.overflow = 'hidden';
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');

        try {
          await loadContent();
        } catch (_) {
          return;
        }

        requestAnimationFrame(() => {
          scroller.scrollTop = 0;
          closeBtn.focus({ preventScroll: true });
        });
      }

      function closeEngineView() {
        window.stopEngineVoice?.();
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = previousBodyOverflow;
        scroller.querySelectorAll('iframe').forEach((frame) => {
          frame.src = frame.src;
        });
        if (lastFocus && typeof lastFocus.focus === 'function') {
          lastFocus.focus({ preventScroll: true });
        }
      }

      triggers.forEach((trigger) => {
        trigger.addEventListener('click', (event) => {
          event.preventDefault();
          openEngineView();
        });
      });

      closeBtn.addEventListener('click', closeEngineView);
      modal.addEventListener('click', (event) => {
        if (event.target === modal) closeEngineView();
      });
      document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal.classList.contains('is-open')) {
          closeEngineView();
        }
      });

      window.openEngine4KyView = openEngineView;
    })();

    /* 6.5 Chap video modal — inline player & quiz cho bài giảng */
    (() => {
      let _chapData = null;
      const DATA_PATH = resolveDataUrl('bai_14_17_co_dap_an.json');

      function extractYoutubeId(url) {
        try {
          const parsed = new URL(url, window.location.href);
          let id = null;
          if (parsed.hostname.includes('youtu.be')) id = parsed.pathname.replace(/^\//, '').split(/[?&]/)[0];
          else if (/\/shorts\//i.test(parsed.pathname)) id = parsed.pathname.split('/shorts/')[1].split(/[?&]/)[0];
          else if (/\/embed\//i.test(parsed.pathname)) id = parsed.pathname.split('/embed/')[1].split(/[?&]/)[0];
          else if (/\/v\//i.test(parsed.pathname)) id = parsed.pathname.split('/v/')[1].split(/[?&]/)[0];
          else id = parsed.searchParams.get('v');
          if (!id) {
            const parts = parsed.pathname.replace(/\/$/, '').split('/');
            const last = parts.pop();
            if (last && /^[A-Za-z0-9_-]{6,}$/.test(last)) id = last;
          }
          return id;
        } catch (_) {
          return null;
        }
      }

      function toEmbedUrl(url) {
        const id = extractYoutubeId(url);
        if (!id) return url;
        return `https://www.youtube.com/embed/${id}?autoplay=1&rel=0`;
      }

      async function loadChapData() {
        if (_chapData) return _chapData;
        try {
          const res = await fetch(DATA_PATH);
          if (!res.ok) throw new Error('not found');
          _chapData = await res.json();
          return _chapData;
        } catch (_) {
          _chapData = null;
          return null;
        }
      }

      function findLessonByVideoId(data, id, title) {
        if (!data) return null;
        if (data[id]) return data[id];
        const arr = Array.isArray(data.lessons) ? data.lessons : (Array.isArray(data.items) ? data.items : null);
        if (!arr) return null;
        const loweredTitle = (title || '').toLowerCase();
        for (const lesson of arr) {
          if (lesson.video && lesson.video === id) return lesson;
          if (lesson.video_id && lesson.video_id === id) return lesson;
          if (lesson.youtube && typeof lesson.youtube === 'string' && lesson.youtube.includes(id)) return lesson;
          if (lesson.video_ids && Array.isArray(lesson.video_ids) && lesson.video_ids.includes(id)) return lesson;
          if (lesson.title && loweredTitle.includes(lesson.title.toLowerCase())) return lesson;
          if (lesson.name && loweredTitle.includes(lesson.name.toLowerCase())) return lesson;
        }
        const keywordMap = {
          'động cơ': 14,
          'hộp số': 15,
          'điều hòa': 16,
          'hệ thống điện': 16,
          'hệ thống lái': 17,
          'lái': 17,
          'treo': 17,
        };
        for (const kw in keywordMap) {
          if (loweredTitle.includes(kw)) {
            const targetNum = keywordMap[kw];
            const found = arr.find((ls) => ls.lessonNumber === targetNum || ls.title === `Bài ${targetNum}`);
            if (found) return found;
          }
        }
        return null;
      }

      function renderSummary(lesson, container) {
        if (!container) return;
        const target = container.querySelector('.chap-video-summary-inner') || container;
        if (!lesson) {
          target.innerHTML = '<p>Không tìm thấy nội dung tóm tắt.</p>';
          return;
        }
        let html = '<h3>Tóm tắt nội dung bài học</h3>';
        const sums = lesson.summary || lesson.summaries || [];
        if (typeof sums === 'string') {
          html += `<div class="chap-summary">${sums}</div>`;
        } else if (Array.isArray(sums) && sums.length) {
          sums.forEach((s) => {
            html += `<div class="chap-summary-item"><strong>${s.title || ''}</strong>`;
            if (s.causes && s.causes.length) {
              html += '<div><em>Nguyên nhân:</em><ul class="chap-points">' + s.causes.map((c) => `<li>${c}</li>`).join('') + '</ul></div>';
            }
            if (s.solutions && s.solutions.length) {
              html += '<div><em>Biện pháp:</em><ul class="chap-points">' + s.solutions.map((c) => `<li>${c}</li>`).join('') + '</ul></div>';
            }
            html += '</div>';
          });
        }
        target.innerHTML = html || '<p>Không có nội dung tóm tắt.</p>';
      }

      function isCorrectAnswer(q, val) {
        const a = q.answer;
        if (a === undefined || a === null) return false;
        if (Array.isArray(a)) return a.map((x) => String(x).toUpperCase()).includes(String(val).toUpperCase());
        return String(a).toUpperCase() === String(val).toUpperCase();
      }

      function renderQuestions(lesson, container) {
        if (!container) return;
        const target = container.querySelector('.chap-video-questions-inner') || container;
        const qs = (lesson && (lesson.questions || lesson.quiz)) || [];
        if (!lesson || !qs.length) {
          target.innerHTML = '<p>Không có câu hỏi trắc nghiệm.</p>';
          return;
        }
        const qHtml = qs.map((q, i) => {
          const opts = (q.options || []).map((opt, j) => {
            const val = opt.label || String(j);
            const text = opt.text || opt;
            return `<button type="button" class="q-opt" data-q="${i}" data-val="${val}" data-label="${val}"><span class="q-opt-key">${val}</span><span class="q-opt-text">${text}</span></button>`;
          }).join('');
          return `<div class="q-item" data-q="${i}"><div class="q-title"><strong>Câu ${i + 1}.</strong> ${q.question}</div><div class="q-opts">${opts}</div></div>`;
        }).join('');
        target.innerHTML = '<h3>Câu hỏi trắc nghiệm</h3>' + qHtml;

        target.querySelectorAll('.q-opt').forEach((btn) => {
          btn.addEventListener('click', () => {
            const qi = +btn.dataset.q;
            const qItem = target.querySelector(`.q-item[data-q="${qi}"]`);
            if (!qItem || qItem.classList.contains('is-answered')) return;
            qItem.classList.add('is-answered');
            const q = qs[qi];
            const answerKey = btn.dataset.label || btn.dataset.val;
            const correct = isCorrectAnswer(q, answerKey);
            qItem.querySelectorAll('.q-opt').forEach((o) => {
              o.classList.add('is-locked');
              o.setAttribute('aria-disabled', 'true');
              const optKey = o.dataset.label || o.dataset.val;
              if (isCorrectAnswer(q, optKey)) o.classList.add('is-correct');
            });
            if (!correct) btn.classList.add('is-wrong');
          });
        });
      }

      window.openChapVideo = async function (src, title) {
        const modal = document.getElementById('chapVideoModal');
        const video = document.getElementById('chapVideoEl');
        const frame = document.getElementById('chapVideoFrame');
        const titleEl = document.getElementById('chapVideoTitle');
        const sumEl = document.getElementById('chapVideoSummary');
        const qEl = document.getElementById('chapVideoQuestions');
        if (!modal || !video || !frame) return;

        const grid = modal.querySelector('.chap-video-grid');
        if (grid) {
          grid.classList.remove('left-collapsed', 'right-collapsed');
        }
        const panelSum = document.getElementById('chapVideoSummary');
        const panelQ = document.getElementById('chapVideoQuestions');
        const btnSum = document.getElementById('chapToggleSummary');
        const btnQ = document.getElementById('chapToggleQuestions');
        if (panelSum) panelSum.classList.remove('is-collapsed');
        if (panelQ) panelQ.classList.remove('is-collapsed');
        if (btnSum) {
          btnSum.classList.remove('is-collapsed');
          btnSum.setAttribute('aria-expanded', 'true');
          btnSum.title = 'Thu gọn tóm tắt';
        }
        if (btnQ) {
          btnQ.classList.remove('is-collapsed');
          btnQ.setAttribute('aria-expanded', 'true');
          btnQ.title = 'Thu gọn câu hỏi';
        }

        const isYoutube = /(?:youtube\.com|youtu\.be)/i.test(src);
        if (isYoutube) {
          frame.src = toEmbedUrl(src);
          try {
            frame.style.display = '';
            frame.hidden = false;
          } catch (_) {}
          try {
            video.style.display = 'none';
            video.hidden = true;
            video.pause();
            video.currentTime = 0;
          } catch (_) {}
          document.querySelectorAll('video').forEach((v) => {
            try {
              if (v !== video) {
                v.pause();
                v.currentTime = 0;
              }
            } catch (_) {}
          });
        } else {
          const source = video.querySelector('source');
          if (source) source.src = resolveAssetUrl(src);
          video.load();
          try {
            video.style.display = '';
            video.hidden = false;
          } catch (_) {}
          try {
            frame.style.display = 'none';
            frame.hidden = true;
            frame.src = '';
          } catch (_) {}
        }

        if (titleEl) titleEl.textContent = title || '';
        modal.classList.add('is-open');
        document.body.style.overflow = 'hidden';

        try {
          const data = await loadChapData();
          const id = extractYoutubeId(src);
          const lesson = findLessonByVideoId(data, id, title);
          renderSummary(lesson, sumEl);
          renderQuestions(lesson, qEl);
        } catch (_) {
          const sumInner = sumEl?.querySelector('.chap-video-summary-inner') || sumEl;
          const qInner = qEl?.querySelector('.chap-video-questions-inner') || qEl;
          if (sumInner) sumInner.innerHTML = '<p>Không thể tải nội dung.</p>';
          if (qInner) qInner.innerHTML = '<p>Không thể tải câu hỏi.</p>';
        }

        if (!isYoutube) {
          setTimeout(() => {
            video.play().catch(() => {});
          }, 120);
        }
      };

      window.closeChapVideo = function (e) {
        if (e && e.target) {
          const isBackdrop = e.target.id === 'chapVideoModal';
          const isCloseBtn = Boolean(e.target.closest?.('.chap-video-close, [data-chap-video-close="button"]'));
          if (!isBackdrop && !isCloseBtn) return;
        }
        const modal = document.getElementById('chapVideoModal');
        const video = document.getElementById('chapVideoEl');
        const frame = document.getElementById('chapVideoFrame');
        const sumEl = document.getElementById('chapVideoSummary');
        const qEl = document.getElementById('chapVideoQuestions');
        const titleEl = document.getElementById('chapVideoTitle');
        if (!modal || !video || !frame) return;
        try {
          video.pause();
          video.currentTime = 0;
        } catch (_) {}
        frame.src = '';
        if (sumEl) {
          const inner = sumEl.querySelector('.chap-video-summary-inner');
          if (inner) inner.innerHTML = '';
        }
        if (qEl) {
          const inner = qEl.querySelector('.chap-video-questions-inner');
          if (inner) inner.innerHTML = '';
        }
        if (titleEl) titleEl.textContent = '';
        const grid = modal.querySelector('.chap-video-grid');
        if (grid) {
          grid.classList.remove('left-collapsed', 'right-collapsed');
        }
        const panelSum = document.getElementById('chapVideoSummary');
        const panelQ = document.getElementById('chapVideoQuestions');
        const btnSum = document.getElementById('chapToggleSummary');
        const btnQ = document.getElementById('chapToggleQuestions');
        if (panelSum) panelSum.classList.remove('is-collapsed');
        if (panelQ) panelQ.classList.remove('is-collapsed');
        if (btnSum) {
          btnSum.classList.remove('is-collapsed');
          btnSum.setAttribute('aria-expanded', 'true');
          btnSum.title = 'Thu gọn tóm tắt';
        }
        if (btnQ) {
          btnQ.classList.remove('is-collapsed');
          btnQ.setAttribute('aria-expanded', 'true');
          btnQ.title = 'Thu gọn câu hỏi';
        }
        modal.classList.remove('is-open');
        document.body.style.overflow = '';
      };

      function toggleCollapse(side) {
        const grid = document.querySelector('.chap-video-grid');
        if (!grid) return;
        const isLeft = side === 'left';
        const panel = document.getElementById(isLeft ? 'chapVideoSummary' : 'chapVideoQuestions');
        const btn = document.getElementById(isLeft ? 'chapToggleSummary' : 'chapToggleQuestions');
        const cls = isLeft ? 'left-collapsed' : 'right-collapsed';
        const collapsed = !grid.classList.contains(cls);
        grid.classList.toggle(cls, collapsed);
        if (panel) panel.classList.toggle('is-collapsed', collapsed);
        if (btn) {
          btn.classList.toggle('is-collapsed', collapsed);
          btn.setAttribute('aria-expanded', String(!collapsed));
          btn.title = collapsed
            ? (isLeft ? 'Mở phần tóm tắt' : 'Mở phần câu hỏi')
            : (isLeft ? 'Thu gọn tóm tắt' : 'Thu gọn câu hỏi');
        }
      }

      const btnSum = document.getElementById('chapToggleSummary');
      const btnQ = document.getElementById('chapToggleQuestions');
      if (btnSum) btnSum.addEventListener('click', (e) => { e.stopPropagation(); toggleCollapse('left'); });
      if (btnQ) btnQ.addEventListener('click', (e) => { e.stopPropagation(); toggleCollapse('right'); });

      const chapModal = document.getElementById('chapVideoModal');
      if (chapModal) {
        chapModal.addEventListener('click', (event) => {
          if (event.target === chapModal || event.target.closest('[data-chap-video-close="button"]')) {
            window.closeChapVideo(event);
          }
        });
      }

      document.querySelectorAll('.chap--video[data-chap-video-src], .chap--video[data-video-id]').forEach((card) => {
        const triggerOpen = () => {
          const src = card.dataset.chapVideoSrc || card.dataset.videoId;
          const cardTitle = card.dataset.chapVideoTitle || '';
          if (src) window.openChapVideo(src, cardTitle);
        };
        card.addEventListener('click', triggerOpen);
        card.addEventListener('keydown', (event) => {
          if (event.key !== 'Enter' && event.key !== ' ') return;
          event.preventDefault();
          triggerOpen();
        });
      });

      document.addEventListener('keydown', (e) => {
        if (e.key !== 'Escape') return;
        const modal = document.getElementById('chapVideoModal');
        if (modal && modal.classList.contains('is-open')) window.closeChapVideo();
      });
    })();

    /* 6.6 Mon 01-04 nested accordion — togglePhan + [data-phan-toggle] */
    window.togglePhan = function (id) {
      const el = document.getElementById(id);
      if (!el) return;
      const isOpen = el.classList.toggle('is-open');
      const header = el.querySelector(':scope > .phan-header');
      if (header) header.setAttribute('aria-expanded', String(isOpen));
    };

    document.querySelectorAll('.phan-header[data-phan-toggle]').forEach((header) => {
      const targetId = header.dataset.phanToggle;
      if (!targetId) return;
      header.addEventListener('click', () => window.togglePhan(targetId));
      header.addEventListener('keydown', (event) => {
        if (event.key !== 'Enter' && event.key !== ' ') return;
        event.preventDefault();
        window.togglePhan(targetId);
      });
    });

    /* 6.7 Chapter accordion (.syll-list--chapters .chap.is-featured) */
    document.querySelectorAll('.syll-list--chapters .chap.is-featured').forEach((chapter) => {
      if (chapter.querySelector(':scope > .chap-collapse')) return;
      const row = chapter.querySelector(':scope > .chap-row');
      const content = chapter.querySelector(':scope > .chap-content-pad, :scope > .bb-grid, :scope > .sa-grid');
      if (!row || !content) return;

      const collapse = document.createElement('div');
      collapse.className = 'chap-collapse';
      chapter.insertBefore(collapse, content);
      collapse.appendChild(content);

      const hasInitialOpen = chapter.classList.contains('is-open');
      if (!hasInitialOpen) {
        collapse.style.height = '0px';
        collapse.setAttribute('aria-hidden', 'true');
        row.setAttribute('aria-expanded', 'false');
      } else {
        collapse.style.height = 'auto';
        collapse.setAttribute('aria-hidden', 'false');
        row.setAttribute('aria-expanded', 'true');
      }
      row.setAttribute('role', 'button');
      row.setAttribute('tabindex', '0');

      const toggleChapter = () => {
        const willOpen = !chapter.classList.contains('is-open');
        if (!willOpen) {
          collapse.style.height = collapse.scrollHeight + 'px';
          collapse.offsetHeight;
        }
        chapter.classList.toggle('is-open', willOpen);
        row.setAttribute('aria-expanded', String(willOpen));
        collapse.setAttribute('aria-hidden', String(!willOpen));
        collapse.style.height = willOpen ? collapse.scrollHeight + 'px' : '0px';
      };

      collapse.addEventListener('transitionend', (event) => {
        if (
          event.target === collapse &&
          event.propertyName === 'height' &&
          chapter.classList.contains('is-open')
        ) {
          collapse.style.height = 'auto';
        }
      });

      row.addEventListener('click', toggleChapter);
      row.addEventListener('keydown', (event) => {
        if (event.key !== 'Enter' && event.key !== ' ') return;
        event.preventDefault();
        toggleChapter();
      });
    });
  }

  function bootstrap() {
    setupEngineMedia();
    setupEngineVoice();
    setupPlatformAccordions();
    setupSyllabusAccordions();
    setupCurriculumModalsAndAccordions();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bootstrap, { once: true });
  } else {
    bootstrap();
  }
})();
