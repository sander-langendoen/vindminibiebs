// /* dropdown */
document.addEventListener("DOMContentLoaded", function () {
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

  // klik buiten dropdown sluit alles
  document.addEventListener("click", function (event) {
    dropdowns.forEach(function (dropdown) {
      if (!dropdown.contains(event.target)) {
        closeDropdown(dropdown);
      }
    });
  });

  dropdowns.forEach(function (dropdown) {
    const trigger = dropdown.querySelector(".gw-taxonomy-dropdown__trigger");
    const menu = dropdown.querySelector(".gw-taxonomy-dropdown__menu");

    if (!trigger || !menu) return;

    // klik op trigger → toggle
    trigger.addEventListener("click", function (event) {
      event.preventDefault();
      const isOpen = dropdown.classList.contains("is-open");
      if (isOpen) {
        closeDropdown(dropdown);
      } else {
        // eerst alle andere dicht
        dropdowns.forEach(closeDropdown);
        openDropdown(dropdown);
      }
    });

    // ESC sluit dropdown
    dropdown.addEventListener("keydown", function (event) {
      if (event.key === "Escape") {
        closeDropdown(dropdown);
        trigger.focus();
      }
    });

    // bij klik op een link dropdown sluiten (navigatie gaat gewoon door)
    const links = dropdown.querySelectorAll(".gw-taxonomy-dropdown__link");
    links.forEach(function (link) {
      link.addEventListener("click", function () {
        closeDropdown(dropdown);
      });
    });
  });
});