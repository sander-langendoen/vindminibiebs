// assets/js/components/variables.js
window.xxsWidth = 320;
window.xsWidth = 414;
window.smWidth = 600;
window.mdWidth = 768;
window.lgWidth = 1024;
window.xlWidth = 1440;

// assets/js/components/header.js
document.addEventListener("DOMContentLoaded", () => {
  headerFunctions();
});
function headerFunctions() {
  const header = document.querySelector("header");
  if (!header) return;
  function calcScrollPos() {
    const scrollPos = document.documentElement.scrollTop || window.scrollY;
    if (scrollPos >= 5) {
      header.setAttribute("data-header-state", "scroll");
    }
    if (scrollPos < 5) {
      header.setAttribute("data-header-state", "default");
    }
  }
  window.addEventListener("scroll", calcScrollPos, false);
  window.addEventListener("load", calcScrollPos, false);
  function addStateToHeaderElements() {
    const searchContainer = document.querySelector(".search-bar-container");
    const searchIconContainer = document.querySelector(".icon-search");
    const navContainer = document.querySelector(".nav-container");
    const logoContainer = document.querySelector(".logo-container");
    const autocompleteContainer = document.querySelector(".autocomplete-container");
    if (!searchContainer || !searchIconContainer || !navContainer || !logoContainer || !autocompleteContainer) {
      return;
    }
    const scrollDistance = (callback, refresh) => {
      if (!callback || typeof callback !== "function") return;
      let isScrolling = null;
      let start = null;
      window.addEventListener(
        "scroll",
        () => {
          if (start === null) start = window.pageYOffset;
          window.clearTimeout(isScrolling);
          isScrolling = window.setTimeout(() => {
            const end = window.pageYOffset;
            const distance = end - start;
            callback(distance, start, end);
            start = null;
          }, refresh || 66);
        },
        false
      );
    };
    scrollDistance((distance) => {
      if (distance <= -300) {
        if (!autocompleteContainer.classList.contains("is-visible")) {
          searchContainer.setAttribute("data-searchbar-state", "visible");
          header.setAttribute("data-searchbar-state", "searchbar-visible");
        }
        searchIconContainer.classList.add("is-vishidden");
        if (window.screen.width <= xxsWidth) {
          logoContainer.classList.remove("is-moved");
        }
        navContainer.setAttribute("data-navbar-state", "navbar-default");
      }
      if (distance >= 200) {
        if (!autocompleteContainer.classList.contains("is-visible")) {
          searchContainer.setAttribute("data-searchbar-state", "hidden");
          header.setAttribute("data-searchbar-state", "searchbar-hidden");
        }
        searchIconContainer.classList.remove("is-vishidden");
        if (window.screen.width <= xxsWidth) {
          logoContainer.classList.add("is-moved");
        }
        navContainer.setAttribute("data-navbar-state", "navbar-scroll");
      }
    });
    searchIconContainer.addEventListener("click", () => {
      searchContainer.setAttribute("data-searchbar-state", "visible");
      header.setAttribute("data-searchbar-state", "searchbar-visible");
    });
  }
  addStateToHeaderElements();
}

// assets/js/components/nav-mobile.js
document.addEventListener("DOMContentLoaded", () => {
  if (window.screen.width < lgWidth) {
    const menuIcon = document.querySelector(".menu-icon-container");
    const closeIcon = document.querySelector(".close-icon-container");
    const overlay = document.querySelector(".overlay-default");
    const navMobileParentItems = document.querySelectorAll(
      ".nav-mobile .menu-item-has-children a"
    );
    const navHeaderItemSecondary = document.querySelectorAll(
      ".nav-mobile .menu-item-has-children .sub-menu a"
    );
    if (!menuIcon || !closeIcon || !overlay) return;
    menuIcon.addEventListener("click", () => {
      document.body.classList.add("mobile-nav-active");
      overlay.style.display = "block";
    });
    closeIcon.addEventListener("click", () => {
      document.body.classList.remove("mobile-nav-active");
      overlay.style.display = "none";
    });
    overlay.addEventListener("click", () => {
      document.body.classList.remove("mobile-nav-active");
      overlay.style.display = "none";
    });
    const parentLis = document.querySelectorAll(".nav-mobile .menu-item-has-children");
    parentLis.forEach((li) => {
      const link = li.querySelector(":scope > a");
      const submenu = li.querySelector(":scope > .sub-menu");
      if (!link || !submenu) return;
      if (li.querySelector(".submenu-toggle")) return;
      const btn = document.createElement("button");
      btn.type = "button";
      btn.className = "submenu-toggle";
      btn.setAttribute("aria-label", "Open submenu");
      btn.setAttribute("aria-expanded", "false");
      link.insertAdjacentElement("afterend", btn);
      btn.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
        const isOpen = link.classList.contains("child-list-open");
        parentLis.forEach((otherLi) => {
          const otherLink = otherLi.querySelector(":scope > a");
          const otherBtn = otherLi.querySelector(":scope > .submenu-toggle");
          if (!otherLink) return;
          otherLink.classList.remove("child-list-open");
          if (otherBtn) otherBtn.setAttribute("aria-expanded", "false");
        });
        if (!isOpen) {
          link.classList.add("child-list-open");
          btn.setAttribute("aria-expanded", "true");
        } else {
          link.classList.remove("child-list-open");
          btn.setAttribute("aria-expanded", "false");
        }
      });
    });
    navHeaderItemSecondary.forEach((item) => {
      item.addEventListener("click", () => {
      });
    });
  }
});

// assets/js/components/cat-dropdown.js
document.addEventListener("DOMContentLoaded", function() {
  const dropdowns = document.querySelectorAll(".gw-taxonomy-dropdown");
  if (!dropdowns.length) return;
  function closeDropdown(dropdown) {
    const trigger = dropdown.querySelector(".gw-taxonomy-dropdown__trigger");
    dropdown.classList.remove("is-open");
    if (trigger) {
      trigger.setAttribute("aria-expanded", "false");
    }
  }
  function openDropdown(dropdown) {
    const trigger = dropdown.querySelector(".gw-taxonomy-dropdown__trigger");
    dropdown.classList.add("is-open");
    if (trigger) {
      trigger.setAttribute("aria-expanded", "true");
    }
  }
  document.addEventListener("click", function(event) {
    dropdowns.forEach(function(dropdown) {
      if (!dropdown.contains(event.target)) {
        closeDropdown(dropdown);
      }
    });
  });
  dropdowns.forEach(function(dropdown) {
    const trigger = dropdown.querySelector(".gw-taxonomy-dropdown__trigger");
    const menu = dropdown.querySelector(".gw-taxonomy-dropdown__menu");
    if (!trigger || !menu) return;
    trigger.addEventListener("click", function(event) {
      event.preventDefault();
      const isOpen = dropdown.classList.contains("is-open");
      if (isOpen) {
        closeDropdown(dropdown);
      } else {
        dropdowns.forEach(closeDropdown);
        openDropdown(dropdown);
      }
    });
    dropdown.addEventListener("keydown", function(event) {
      if (event.key === "Escape") {
        closeDropdown(dropdown);
        trigger.focus();
      }
    });
    const links = dropdown.querySelectorAll(".gw-taxonomy-dropdown__link");
    links.forEach(function(link) {
      link.addEventListener("click", function() {
        closeDropdown(dropdown);
      });
    });
  });
});

// assets/js/components/tnd-slider.js
function initTNDSwipers(root = document) {
  root.querySelectorAll(".tnd-slider").forEach((slider) => {
    const swiperEl = slider.querySelector(".swiper");
    if (!swiperEl) return;
    if (swiperEl.dataset.initialized === "true") return;
    const SwiperClass = window.Swiper;
    if (!SwiperClass) {
      return;
    }
    const autoplay = slider.dataset.autoplay === "true";
    const delay = parseInt(slider.dataset.delay, 10) || 5e3;
    new SwiperClass(swiperEl, {
      loop: true,
      slidesPerView: 1,
      pagination: {
        el: slider.querySelector(".swiper-pagination"),
        clickable: true
      },
      navigation: {
        nextEl: slider.querySelector(".swiper-button-next"),
        prevEl: slider.querySelector(".swiper-button-prev")
      },
      autoplay: autoplay ? { delay, disableOnInteraction: false } : false
    });
    swiperEl.dataset.initialized = "true";
  });
}
document.addEventListener("DOMContentLoaded", () => initTNDSwipers());
setTimeout(() => initTNDSwipers(), 300);
setTimeout(() => initTNDSwipers(), 1200);

// assets/js/components/nav-primary.js
var NavPrimary = class {
  constructor() {
    this.navContainer = document.querySelector(".site-navigation");
    this.parents = document.querySelectorAll(".site-navigation .menu-item-has-children");
    this.parentLinks = document.querySelectorAll(".site-navigation .menu-item-has-children > a");
    this.noChildrenLinks = document.querySelectorAll(".site-navigation .menu-item:not(.menu-item-has-children) > a");
    this.overlay = document.querySelector(".overlay");
    this.timer = null;
    if (!this.navContainer || !this.parents.length) return;
    this.addEvents();
  }
  addEvents() {
    this.noChildrenLinks.forEach((a) => {
      a.addEventListener("click", () => {
        if (this.overlay) this.fadeIn(this.overlay, 200);
      });
    });
    this.parents.forEach((li) => {
      li.addEventListener("mouseenter", (e) => this.mouseEnterEvents(e));
      li.addEventListener("mouseleave", () => this.mouseLeaveEvents());
    });
  }
  mouseEnterEvents(e) {
    clearTimeout(this.timer);
    const li = e.currentTarget;
    this.timer = setTimeout(() => {
      if (!li) return;
      if (this.overlay) this.fadeIn(this.overlay, 150);
      this.navContainer.classList.add("nav-active");
      const link = li.querySelector(":scope > a") || li.querySelector("a");
      if (link) link.classList.add("child-list-open");
    }, 250);
  }
  mouseLeaveEvents() {
    clearTimeout(this.timer);
    if (this.overlay) this.fadeOut(this.overlay, 150);
    this.navContainer.classList.remove("nav-active");
    this.parentLinks.forEach((a) => a.classList.remove("child-list-open"));
  }
  fadeIn(el, duration = 200) {
    el.style.opacity = 0;
    el.style.display = "block";
    let start = null;
    const animate = (t) => {
      if (!start) start = t;
      const p = t - start;
      el.style.opacity = Math.min(p / duration, 1);
      if (p < duration) requestAnimationFrame(animate);
    };
    requestAnimationFrame(animate);
  }
  fadeOut(el, duration = 200) {
    let start = null;
    const animate = (t) => {
      if (!start) start = t;
      const p = t - start;
      el.style.opacity = Math.max(1 - p / duration, 0);
      if (p < duration) requestAnimationFrame(animate);
      else el.style.display = "none";
    };
    requestAnimationFrame(animate);
  }
};

// assets/js/custom.js
(function() {
  function initTndSearchOverlays() {
    var containers = document.querySelectorAll(".tnd-search-overlay");
    if (!containers.length) return;
    containers.forEach(function(container) {
      var toggleBtn = container.querySelector(".tnd-search-overlay__toggle");
      var backdrop = container.querySelector(".tnd-search-overlay__backdrop");
      var closeBtn = container.querySelector(".tnd-search-overlay__close");
      var input = container.querySelector(".tnd-search-overlay__input");
      if (!toggleBtn || !backdrop) return;
      function openOverlay() {
        container.classList.add("tnd-search-overlay--open");
        toggleBtn.setAttribute("aria-expanded", "true");
        backdrop.setAttribute("aria-hidden", "false");
        if (input) {
          setTimeout(function() {
            input.focus();
          }, 50);
        }
      }
      function closeOverlay() {
        container.classList.remove("tnd-search-overlay--open");
        toggleBtn.setAttribute("aria-expanded", "false");
        backdrop.setAttribute("aria-hidden", "true");
        toggleBtn.focus();
      }
      toggleBtn.addEventListener("click", function() {
        var isOpen = container.classList.contains("tnd-search-overlay--open");
        if (isOpen) {
          closeOverlay();
        } else {
          openOverlay();
        }
      });
      if (closeBtn) {
        closeBtn.addEventListener("click", function() {
          closeOverlay();
        });
      }
      backdrop.addEventListener("click", function(e) {
        if (e.target === backdrop) {
          closeOverlay();
        }
      });
      document.addEventListener("keydown", function(e) {
        if (e.key === "Escape" && container.classList.contains("tnd-search-overlay--open")) {
          closeOverlay();
        }
      });
    });
  }
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initTndSearchOverlays);
  } else {
    initTndSearchOverlays();
  }
})();
new NavPrimary();
