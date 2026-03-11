document.addEventListener('DOMContentLoaded', () => {
  if (window.screen.width < lgWidth) {

    const menuIcon = document.querySelector('.menu-icon-container');
    const closeIcon = document.querySelector('.close-icon-container');
    const overlay = document.querySelector('.overlay-default');
    const navMobileParentItems = document.querySelectorAll(
      '.nav-mobile .menu-item-has-children a'
    );
    const navHeaderItemSecondary = document.querySelectorAll(
      '.nav-mobile .menu-item-has-children .sub-menu a'
    );

    if (!menuIcon || !closeIcon || !overlay) return;

    // Open mobile menu
    menuIcon.addEventListener('click', () => {
      document.body.classList.add('mobile-nav-active');
      overlay.style.display = 'block';
    });

    // Close mobile menu (close icon)
    closeIcon.addEventListener('click', () => {
      document.body.classList.remove('mobile-nav-active');
      overlay.style.display = 'none';
    });

    // Close mobile menu (overlay)
    overlay.addEventListener('click', () => {
      document.body.classList.remove('mobile-nav-active');
      overlay.style.display = 'none';
    });

    // Toggle submenus
    // Inject toggle buttons for parent items (mobile)
    const parentLis = document.querySelectorAll('.nav-mobile .menu-item-has-children');

    parentLis.forEach(li => {
      const link = li.querySelector(':scope > a');
      const submenu = li.querySelector(':scope > .sub-menu');
      if (!link || !submenu) return;

      // voorkom dubbel injecteren
      if (li.querySelector('.submenu-toggle')) return;

      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'submenu-toggle';
      btn.setAttribute('aria-label', 'Open submenu');
      btn.setAttribute('aria-expanded', 'false');

      link.insertAdjacentElement('afterend', btn);

      btn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();

        const isOpen = link.classList.contains('child-list-open');

        // sluit andere submenus
        parentLis.forEach(otherLi => {
          const otherLink = otherLi.querySelector(':scope > a');
          const otherBtn = otherLi.querySelector(':scope > .submenu-toggle');
          if (!otherLink) return;

          otherLink.classList.remove('child-list-open');
          if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
        });

        // toggle current
        if (!isOpen) {
          link.classList.add('child-list-open');
          btn.setAttribute('aria-expanded', 'true');
        } else {
          link.classList.remove('child-list-open');
          btn.setAttribute('aria-expanded', 'false');
        }
      });
    });

    // Secondary items (placeholder zoals in jQuery)
    navHeaderItemSecondary.forEach(item => {
      item.addEventListener('click', () => {
        // intentionally empty
      });
    });

  }
});