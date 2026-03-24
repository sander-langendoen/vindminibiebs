document.addEventListener("DOMContentLoaded", () => {

  const counters = document.querySelectorAll(".home-counter-card__number span");

  const animateCounter = (el) => {

    const target = parseInt(el.textContent.replace(/\D/g, ""));
    const duration = 1600;
    let startTime = null;

    const easeOut = (t) => 1 - Math.pow(1 - t, 3);

    const step = (timestamp) => {

      if (!startTime) startTime = timestamp;

      const progress = Math.min((timestamp - startTime) / duration, 1);
      const eased = easeOut(progress);

      const value = Math.floor(target * eased);

      el.textContent = value.toLocaleString("nl-NL");

      if (progress < 1) {
        requestAnimationFrame(step);
      } else {
        el.textContent = target.toLocaleString("nl-NL");
      }

    };

    requestAnimationFrame(step);

  };

  const observer = new IntersectionObserver((entries, obs) => {

    entries.forEach(entry => {

      if (!entry.isIntersecting) return;

      const spans = entry.target.querySelectorAll("span");

      spans.forEach((span, i) => {

        setTimeout(() => {
          animateCounter(span);
        }, i * 120); // kleine vertraging per kaart

      });

      obs.unobserve(entry.target);

    });

  }, {
    threshold: 0.35
  });

  const band = document.querySelector(".home-counter-band");

  if (band) observer.observe(band);

});