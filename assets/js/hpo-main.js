/**
 * HPO Main JavaScript
 * Initialization for Hero Slider, System Ring Motion & Interactive Elements.
 * Project: HPO Flatsome Child Theme
 */
(function($) {
  'use strict';

  /* ==========================================================================
     1. HPO Company Slider (Hero Dual Slide)
     ========================================================================== */
  function initHeroSlider() {
    const root = document.querySelector('.company-slider');
    if (!root) return;

    const track = root.querySelector('.company-slider-track');
    if (!track) return;

    const slides = Array.from(track.children);
    if (slides.length <= 1) return;

    const controls = root.querySelector('.company-slider-controls');
    let active = 0;
    let pending = false;
    const AUTO_SLIDE_MS = 6000;
    let autoTimer = null;
    let hovered = false;
    let touching = false;

    // Build dots navigation
    const dots = document.createElement('div');
    dots.className = 'company-slider-dots';
    root.style.setProperty('--company-slide-ms', `${AUTO_SLIDE_MS}ms`);

    const dotButtons = slides.map((slide, index) => {
      const dot = document.createElement('button');
      dot.type = 'button';
      dot.setAttribute('aria-controls', 'companySliderTrack');
      dot.setAttribute('aria-label', `Slide ${index + 1}`);
      dot.addEventListener('click', () => go(index));
      dots.appendChild(dot);
      return dot;
    });

    if (controls) {
      const nextBtn = controls.querySelector('[data-company-step="1"]');
      if (nextBtn) {
        nextBtn.before(dots);
      } else {
        controls.appendChild(dots);
      }
    }

    function go(index) {
      const target = (index + slides.length) % slides.length;
      track.scrollTo({
        left: target * track.clientWidth,
        behavior: 'smooth'
      });
    }

    function scheduleAutoSlide() {
      clearTimeout(autoTimer);
      root.classList.remove('is-autoplaying');
      if (document.hidden || hovered || touching || root.contains(document.activeElement)) return;
      void root.offsetWidth; // reset dot progress animation
      root.classList.add('is-autoplaying');
      autoTimer = setTimeout(() => {
        go(active + 1);
        scheduleAutoSlide();
      }, AUTO_SLIDE_MS);
    }

    function update() {
      pending = false;
      active = Math.max(0, Math.min(slides.length - 1, Math.round(track.scrollLeft / track.clientWidth)));
      slides.forEach((slide, index) => {
        slide.classList.toggle('is-active', index === active);
        if (index === active) {
          dotButtons[index]?.setAttribute('aria-current', 'true');
        } else {
          dotButtons[index]?.removeAttribute('aria-current');
        }
      });
    }

    root.querySelectorAll('[data-company-step]').forEach(button => {
      button.addEventListener('click', () => {
        const step = parseInt(button.dataset.companyStep, 10) || 1;
        go(active + step);
      });
    });

    track.addEventListener('scroll', () => {
      scheduleAutoSlide();
      if (!pending) {
        pending = true;
        requestAnimationFrame(update);
      }
    }, { passive: true });

    root.addEventListener('pointerenter', () => {
      hovered = true;
      scheduleAutoSlide();
    });

    root.addEventListener('pointerleave', () => {
      hovered = false;
      scheduleAutoSlide();
    });

    track.addEventListener('touchstart', () => { touching = true; }, { passive: true });
    track.addEventListener('touchend', () => { touching = false; scheduleAutoSlide(); }, { passive: true });

    update();
    scheduleAutoSlide();
  }

  /* ==========================================================================
     2. HPO System Card Motion (Ring & 6 Nodes)
     ========================================================================== */
  function initSystemCardMotion() {
    const card = document.querySelector('.hpo-sys-card');
    if (!card) return;

    const ring = card.querySelector('.hpo-sys-ring');
    const svg = ring && ring.querySelector('.hpo-sys-motion');
    if (!svg) return;

    const NS = 'http://www.w3.org/2000/svg';
    const CENTER = { x: 181, y: 186 };
    const SWEEP_SECONDS = 6;
    const TRAVEL = 0.18;
    const GLOW_PEAK = 0.2;

    const NODES = [
      { name: 'face', x: 117, y: 104 },
      { name: 'cloud', x: 250, y: 98 },
      { name: 'dat', x: 309, y: 178 },
      { name: 'cabin', x: 246, y: 268 },
      { name: 'sim', x: 114, y: 264 },
      { name: 'platform', x: 58, y: 166 },
    ];

    const el = (tag, attrs, parent) => {
      const n = document.createElementNS(NS, tag);
      for (const k in attrs) n.setAttribute(k, attrs[k]);
      if (parent) parent.appendChild(n);
      return n;
    };

    const defs = el('defs', {}, svg);
    const glowGrad = el('radialGradient', { id: 'hpoSysNodeGlow' }, defs);
    el('stop', { offset: '0', 'stop-color': '#d6f8ff', 'stop-opacity': '1' }, glowGrad);
    el('stop', { offset: '.5', 'stop-color': '#6fdcff', 'stop-opacity': '.6' }, glowGrad);
    el('stop', { offset: '1', 'stop-color': '#2b8cff', 'stop-opacity': '0' }, glowGrad);

    // Orbit ring
    const orbit = el('g', { class: 'hpo-sys-orbit' }, svg);
    el('circle', { cx: 181, cy: 181, r: 172, fill: 'none', stroke: '#cfeeff', 'stroke-opacity': '.35', 'stroke-width': '1', 'stroke-dasharray': '2 7' }, orbit);
    el('circle', { cx: 181, cy: 9, r: 2.6, fill: '#e6fbff' }, orbit);

    const items = new Map();
    card.querySelectorAll('[data-hpo-node]').forEach((li) => items.set(li.dataset.hpoNode, li));
    const focusRings = new Map();

    NODES.forEach((n) => {
      const dx = n.x - CENTER.x, dy = n.y - CENTER.y;
      const len = Math.hypot(dx, dy), ux = dx / len, uy = dy / len;
      const a = { x: CENTER.x + ux * 50, y: CENTER.y + uy * 50 };
      const b = { x: n.x - ux * 30, y: n.y - uy * 30 };
      const d = `M${a.x.toFixed(1)} ${a.y.toFixed(1)}L${b.x.toFixed(1)} ${b.y.toFixed(1)}`;

      el('path', { d, class: 'hpo-sys-spoke' }, svg);

      const angle = (Math.atan2(dx, -dy) * 180 / Math.PI + 360) % 360;
      const hitAt = (angle / 360) * SWEEP_SECONDS;
      const begin = `${(hitAt - GLOW_PEAK * SWEEP_SECONDS).toFixed(2)}s`;
      const common = { dur: `${SWEEP_SECONDS}s`, begin, repeatCount: 'indefinite' };

      const glow = el('circle', { cx: n.x, cy: n.y, r: 34, fill: 'url(#hpoSysNodeGlow)', opacity: 0 }, svg);
      el('animate', { attributeName: 'opacity', values: '0;0;1;.7;0;0', keyTimes: `0;${GLOW_PEAK - 0.03};${GLOW_PEAK};0.3;0.45;1`, ...common }, glow);
      el('animate', { attributeName: 'r', values: '24;24;44;50;50', keyTimes: `0;${GLOW_PEAK - 0.03};${GLOW_PEAK};0.45;1`, ...common }, glow);

      const packet = el('circle', { r: 3.4, class: 'hpo-sys-packet', opacity: 0 }, svg);
      el('animateMotion', { path: d, keyPoints: '0;1;1', keyTimes: `0;${TRAVEL};1`, calcMode: 'linear', ...common }, packet);
      el('animate', { attributeName: 'opacity', values: '0;1;1;0;0', keyTimes: `0;0.02;${TRAVEL - 0.02};${TRAVEL + 0.01};1`, ...common }, packet);

      focusRings.set(n.name, el('circle', { cx: n.x, cy: n.y, r: 40, class: 'hpo-sys-focus' }, svg));
    });

    // Hover sync with list items
    items.forEach((li, name) => {
      li.addEventListener('pointerenter', () => {
        focusRings.get(name)?.classList.add('is-on');
      });
      li.addEventListener('pointerleave', () => {
        focusRings.get(name)?.classList.remove('is-on');
      });
    });
  }

  // Document Ready
  $(document).ready(function() {
    initHeroSlider();
    initSystemCardMotion();
  });

})(jQuery);
