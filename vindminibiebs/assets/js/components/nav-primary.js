export class NavPrimary {
  constructor() {
    this.navContainer = document.querySelector('.site-navigation');
    this.parents = document.querySelectorAll('.site-navigation .menu-item-has-children');
    this.parentLinks = document.querySelectorAll('.site-navigation .menu-item-has-children > a');
    this.noChildrenLinks = document.querySelectorAll('.site-navigation .menu-item:not(.menu-item-has-children) > a');

    this.overlay = document.querySelector('.overlay'); // moet bestaan óf we skippen fade
    this.timer = null;

    if (!this.navContainer || !this.parents.length) return;

    this.addEvents();
  }

  addEvents() {
    // click op items zonder children
    this.noChildrenLinks.forEach(a => {
      a.addEventListener('click', () => {
        if (this.overlay) this.fadeIn(this.overlay, 200);
      });
    });

    // hover op parent li
    this.parents.forEach(li => {
      li.addEventListener('mouseenter', (e) => this.mouseEnterEvents(e));
      li.addEventListener('mouseleave', () => this.mouseLeaveEvents());
    });
  }

  mouseEnterEvents(e) {
    clearTimeout(this.timer);

    const li = e.currentTarget; // ✅ bewaar nu (element)

    this.timer = setTimeout(() => {
        if (!li) return; // extra safety

        if (this.overlay) this.fadeIn(this.overlay, 150);
        this.navContainer.classList.add('nav-active');

        const link = li.querySelector(':scope > a') || li.querySelector('a');
        if (link) link.classList.add('child-list-open');
    }, 250);
    }

  mouseLeaveEvents() {
    clearTimeout(this.timer);

    if (this.overlay) this.fadeOut(this.overlay, 150);
    this.navContainer.classList.remove('nav-active');

    // ✅ class eraf bij alle parent links
    this.parentLinks.forEach(a => a.classList.remove('child-list-open'));
  }

  fadeIn(el, duration = 200) {
    el.style.opacity = 0;
    el.style.display = 'block';
    let start = null;

    const animate = t => {
      if (!start) start = t;
      const p = t - start;
      el.style.opacity = Math.min(p / duration, 1);
      if (p < duration) requestAnimationFrame(animate);
    };
    requestAnimationFrame(animate);
  }

  fadeOut(el, duration = 200) {
    let start = null;

    const animate = t => {
      if (!start) start = t;
      const p = t - start;
      el.style.opacity = Math.max(1 - p / duration, 0);
      if (p < duration) requestAnimationFrame(animate);
      else el.style.display = 'none';
    };
    requestAnimationFrame(animate);
  }
}