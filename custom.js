document.addEventListener('DOMContentLoaded', () => {
  const timeline = document.querySelector('[data-sl-timeline]');
  if (!timeline) return;

  const items = timeline.querySelectorAll('[data-sl-item]');
  const dotsWrap = timeline.querySelector('.sl-timeline__dots');

  const buttons = [];

  items.forEach((item, i) => {
    const btn = document.createElement('button');
    btn.className = 'sl-timeline__dot-btn';
    btn.innerHTML = '<span class="sl-timeline__dot"></span>';

    btn.addEventListener('click', () => {
      item.scrollIntoView({ behavior: 'smooth' });
    });

    dotsWrap.appendChild(btn);
    buttons.push(btn);
  });

  const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const index = [...items].indexOf(entry.target);
      buttons.forEach(b => b.classList.remove('active'));
      buttons[index].classList.add('active');
    });
  }, { threshold: 0.5 });

  items.forEach(item => io.observe(item));
});