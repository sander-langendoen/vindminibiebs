// assets/js/tnd-search-overlay.js
(function () {
  function initTndSearchOverlays() {
    var containers = document.querySelectorAll('.tnd-search-overlay');
    if (!containers.length) return;

    containers.forEach(function (container) {
      var toggleBtn = container.querySelector('.tnd-search-overlay__toggle');
      var backdrop  = container.querySelector('.tnd-search-overlay__backdrop');
      var closeBtn  = container.querySelector('.tnd-search-overlay__close');
      var input     = container.querySelector('.tnd-search-overlay__input');

      if (!toggleBtn || !backdrop) return;

      function openOverlay() {
        container.classList.add('tnd-search-overlay--open');
        toggleBtn.setAttribute('aria-expanded', 'true');
        backdrop.setAttribute('aria-hidden', 'false');

        if (input) {
          setTimeout(function () {
            input.focus();
          }, 50);
        }
      }

      function closeOverlay() {
        container.classList.remove('tnd-search-overlay--open');
        toggleBtn.setAttribute('aria-expanded', 'false');
        backdrop.setAttribute('aria-hidden', 'true');
        toggleBtn.focus();
      }

      toggleBtn.addEventListener('click', function () {
        var isOpen = container.classList.contains('tnd-search-overlay--open');
        if (isOpen) {
          closeOverlay();
        } else {
          openOverlay();
        }
      });

      if (closeBtn) {
        closeBtn.addEventListener('click', function () {
          closeOverlay();
        });
      }

      backdrop.addEventListener('click', function (e) {
        if (e.target === backdrop) {
          closeOverlay();
        }
      });

      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && container.classList.contains('tnd-search-overlay--open')) {
          closeOverlay();
        }
      });
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initTndSearchOverlays);
  } else {
    initTndSearchOverlays();
  }
})();



import './components/variables';
import './components/header';
import './components/nav-mobile';
import './components/cat-dropdown';
import './components/tnd-slider';


import {NavPrimary} from "./components/nav-primary";

new NavPrimary();