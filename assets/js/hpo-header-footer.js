/**
 * HPO Header, Footer & Floating Dock Interactions
 * Deferred script — zero jQuery dependency required for scroll/top actions.
 */
(function () {
  'use strict';

  function initHeaderFooter() {
    var masthead = document.getElementById('masthead');
    var floats = document.querySelector('.floats');
    var topBtn = document.querySelector('.floats .float-top');
    var mobileClose = document.getElementById('hpoMobileClose');
    var mobileMenu = document.getElementById('main-menu');
    var burger = document.getElementById('burger');

    // 1. Scroll listeners for #masthead.is-scrolled (>16px) & .floats.is-scrolled (>2*innerHeight)
    var ticking = false;
    function syncScrollState() {
      ticking = false;
      var y = window.scrollY || window.pageYOffset || 0;
      if (masthead) {
        masthead.classList.toggle('is-scrolled', y > 16);
      }
      if (floats) {
        floats.classList.toggle('is-scrolled', y > window.innerHeight * 2);
      }
    }

    window.addEventListener(
      'scroll',
      function () {
        if (!ticking) {
          ticking = true;
          window.requestAnimationFrame(syncScrollState);
        }
      },
      { passive: true }
    );
    syncScrollState();

    // 2. Smooth scroll to top
    if (topBtn) {
      topBtn.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });
    }

    // 3. Mobile drawer close helpers & aria-expanded sync
    function closeMobileDrawer() {
      if (window.jQuery && window.jQuery.magnificPopup) {
        window.jQuery.magnificPopup.close();
      }
      if (burger) {
        burger.setAttribute('aria-expanded', 'false');
      }
    }

    if (mobileClose) {
      mobileClose.addEventListener('click', closeMobileDrawer);
    }

    if (mobileMenu) {
      mobileMenu.addEventListener('click', function (event) {
        var link = event.target.closest('a[href]');
        if (!link) return;
        var href = link.getAttribute('href') || '';
        if (href && href !== '#') {
          closeMobileDrawer();
        }
      });
    }

    if (window.jQuery && burger) {
      window.jQuery(document).on('mfpOpen', function () {
        if (mobileMenu && !mobileMenu.classList.contains('mfp-hide')) {
          burger.setAttribute('aria-expanded', 'true');
        }
      });
      window.jQuery(document).on('mfpClose', function () {
        burger.setAttribute('aria-expanded', 'false');
      });
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHeaderFooter, { once: true });
  } else {
    initHeaderFooter();
  }
})();
