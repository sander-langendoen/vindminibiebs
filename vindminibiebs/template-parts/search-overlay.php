<?php
// template-parts/header/search-overlay.php
?>

<div class="tnd-search-overlay">
  <button
    type="button"
    class="tnd-search-overlay__toggle"
    aria-haspopup="dialog"
    aria-expanded="false"
    aria-controls="tnd-search-overlay-dialog"
  >
    <span class="screen-reader-text">
      <?php esc_html_e('Open zoekveld', 'tnd'); ?>
    </span>

    <svg width="17" height="16" xmlns="http://www.w3.org/2000/svg" class="tnd-search-overlay__icon" fill="none" stroke="currentColor">
      <g stroke="currentColor" stroke-width="1.5" fill="none" fill-rule="evenodd">
        <circle cx="7.393" cy="6.908" r="6" />
        <path d="M11.719 11.234l4.242 4.242" />
      </g>
    </svg>
  </button>

  <div class="tnd-search-overlay__backdrop" aria-hidden="true">
    <div
      class="tnd-search-overlay__dialog"
      id="tnd-search-overlay-dialog"
      role="dialog"
      aria-modal="true"
      aria-labelledby="tnd-search-overlay-title"
    >
      <button
        type="button"
        class="tnd-search-overlay__close"
        aria-label="<?php esc_attr_e('Sluit zoekveld', 'tnd'); ?>"
      >
        &times;
      </button>

      <form
        role="search"
        method="get"
        class="tnd-search-overlay__form"
        action="<?php echo esc_url(home_url('/')); ?>"
      >
        <input
          class="tnd-search-overlay__input form-control"
          id="s"
          name="s"
          type="search"
          placeholder="<?php esc_attr_e('Search', 'tnd'); ?>"
          value="<?php echo esc_attr(get_search_query()); ?>"
        >

        <button class="tnd-search-overlay__trigger tnd-search-overlay__trigger--submit" type="submit">
          <svg width="17" height="16" xmlns="http://www.w3.org/2000/svg" class="tnd-search-overlay__icon" fill="none" stroke="currentColor">
            <g stroke="currentColor" stroke-width="1.5" fill="none" fill-rule="evenodd">
              <circle cx="7.393" cy="6.908" r="6" />
              <path d="M11.719 11.234l4.242 4.242" />
            </g>
          </svg>
        </button>
      </form>
    </div>
  </div>
</div>