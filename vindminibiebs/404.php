<?php get_header(); ?>

<main class="page-404">
  <div class="page-404__inner container">

    <h1 class="page-404__title">
      <?php echo esc_html( get_field('404_title', 'option') ?: __('Pagina niet gevonden', 'tnd') ); ?>
    </h1>

    <div class="page-404__content pb-xl">
      <?php
      $content = get_field('404_content', 'option');
      echo $content ? wp_kses_post($content) : '<p>' . esc_html__('De pagina die je zoekt bestaat niet (meer).', 'tnd') . '</p>';
      ?>
    </div>

  </div>

  <?php 
    get_template_part('template-parts/sections/single-contact-cta', null, [
      'source' => '404-options',
    ]);
  ?>
</main>

<?php get_footer(); ?>