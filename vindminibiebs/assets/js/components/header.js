document.addEventListener('DOMContentLoaded', () => {
  headerFunctions();
});

function headerFunctions() {
  const header = document.querySelector('header');
  if (!header) return;

  /**
   * Calc the scroll position on the page
   */
  function calcScrollPos() {
    const scrollPos = document.documentElement.scrollTop || window.scrollY; // scrollY needed for Safari

    if (scrollPos >= 5) {
      header.setAttribute('data-header-state', 'scroll');
    }
    if (scrollPos < 5) {
      header.setAttribute('data-header-state', 'default');
    }
  }

  window.addEventListener('scroll', calcScrollPos, false);
  window.addEventListener('load', calcScrollPos, false);

  /**
   * We like to have a state on the mobile searchbar - so we can target some CSS-classes
   */
  function addStateToHeaderElements() {
    const searchContainer = document.querySelector('.search-bar-container');
    const searchIconContainer = document.querySelector('.icon-search');
    const navContainer = document.querySelector('.nav-container');
    const logoContainer = document.querySelector('.logo-container');
    const autocompleteContainer = document.querySelector('.autocomplete-container');

    // Als er iets mist: stop netjes (zoals jQuery "leeg selection" vaak stil faalt)
    if (!searchContainer || !searchIconContainer || !navContainer || !logoContainer || !autocompleteContainer) {
      return;
    }

    /**
     * Run a callback after the user scrolls, calculating the distance and direction scroll
     * (vanilla versie van je scrollDistance helper)
     */
    const scrollDistance = (callback, refresh) => {
      if (!callback || typeof callback !== 'function') return;

      let isScrolling = null;
      let start = null;

      window.addEventListener(
        'scroll',
        () => {
          if (start === null) start = window.pageYOffset;

          window.clearTimeout(isScrolling);

          isScrolling = window.setTimeout(() => {
            const end = window.pageYOffset;
            const distance = end - start;

            callback(distance, start, end);

            // reset
            start = null;
          }, refresh || 66);
        },
        false
      );
    };

    scrollDistance((distance) => {
      // Scroll UP (distance negatief)
      if (distance <= -300) {
        // first check if the searchresult list - autocomplete is open - don't change state when open
        if (!autocompleteContainer.classList.contains('is-visible')) {
          searchContainer.setAttribute('data-searchbar-state', 'visible');
          header.setAttribute('data-searchbar-state', 'searchbar-visible');
        }

        // hide the the search icon again
        searchIconContainer.classList.add('is-vishidden');

        // check on smaller devices if the logo has to be moved - then move back
        if (window.screen.width <= xxsWidth) {
          logoContainer.classList.remove('is-moved');
        }

        // add state to nav-container
        navContainer.setAttribute('data-navbar-state', 'navbar-default');
      }

      // Scroll DOWN (distance positief)
      if (distance >= 200) {
        // first check if the searchresult list - autocomplete is open - don't change state when open
        if (!autocompleteContainer.classList.contains('is-visible')) {
          searchContainer.setAttribute('data-searchbar-state', 'hidden');
          header.setAttribute('data-searchbar-state', 'searchbar-hidden');
        }

        // show the the search icon again
        searchIconContainer.classList.remove('is-vishidden');

        // check on smaller devices if the logo has to be moved
        if (window.screen.width <= xxsWidth) {
          logoContainer.classList.add('is-moved');
        }

        // add state to nav-container
        navContainer.setAttribute('data-navbar-state', 'navbar-scroll');
      }
    });

    // Click: show searchbar again
    searchIconContainer.addEventListener('click', () => {
      searchContainer.setAttribute('data-searchbar-state', 'visible');
      header.setAttribute('data-searchbar-state', 'searchbar-visible');
    });
  }

  addStateToHeaderElements();
}