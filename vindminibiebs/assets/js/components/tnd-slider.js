function initTNDSwipers(root = document) {
  root.querySelectorAll('.tnd-slider').forEach((slider) => {
    const swiperEl = slider.querySelector('.swiper');
    if (!swiperEl) return;

    // voorkom dubbel init (Gutenberg re-renders / AJAX)
    if (swiperEl.dataset.initialized === 'true') return;

    const SwiperClass = window.Swiper;
    if (!SwiperClass) {
      // Swiper (CDN) nog niet beschikbaar
      return;
    }

    const autoplay = slider.dataset.autoplay === 'true';
    const delay = parseInt(slider.dataset.delay, 10) || 5000;

    new SwiperClass(swiperEl, {
      loop: true,
      slidesPerView: 1,
      pagination: {
        el: slider.querySelector('.swiper-pagination'),
        clickable: true,
      },
      navigation: {
        nextEl: slider.querySelector('.swiper-button-next'),
        prevEl: slider.querySelector('.swiper-button-prev'),
      },
      autoplay: autoplay ? { delay, disableOnInteraction: false } : false,
    });

    swiperEl.dataset.initialized = 'true';
  });
}

// Frontend: normaal
document.addEventListener('DOMContentLoaded', () => initTNDSwipers());

// Gutenberg/editor: DOM kan later renderen → nog een paar keer proberen
setTimeout(() => initTNDSwipers(), 300);
setTimeout(() => initTNDSwipers(), 1200);