<?php get_header(); ?>

<main>

  <?php if ( function_exists('yoast_breadcrumb') && ! is_front_page() && ! is_home() ) : ?>
    <div class="breadcrumbs container" aria-label="<?php esc_attr_e('Breadcrumbs', 'tnd'); ?>">
      <?php yoast_breadcrumb('<p class="breadcrumbs__inner">','</p>'); ?>
    </div>
  <?php endif; ?>

  <?php
    the_content();
  ?>
</main>

<?php get_footer(); ?>