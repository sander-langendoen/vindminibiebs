<?php get_header(); ?>

<main>

  <?php if ( function_exists('yoast_breadcrumb') && ! is_front_page() && ! is_home() ) : ?>
    <div class="breadcrumbs container" aria-label="<?php esc_attr_e('Breadcrumbs', 'tnd'); ?>">
      <?php yoast_breadcrumb('<p class="breadcrumbs__inner">','</p>'); ?>
    </div>
  <?php endif; ?>

  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <?php if ( has_post_thumbnail() ) : ?>
      <div class="tnd-single-hero">
        <?php the_post_thumbnail('full', [
          'class'         => 'tnd-single-hero__img',
          'loading'       => 'eager',
          'fetchpriority' => 'high',
          'decoding'      => 'async',
        ]); ?>
      </div>
    <?php endif; ?>

    <div class="tnd-single-layout container">

      <div class="tnd-single-layout__grid">

        <article class="tnd-single-layout__content">

          <div class="tnd-single-layout__body pb-xl">
            <?php echo get_field('text_editor'); ?>
          </div>

          <?php if ( get_the_tags() ) : ?>
            <div class="tnd-single-layout__tags">
              <?php the_tags('', ', ', ''); ?>
            </div>
          <?php endif; ?>
        </article>

        <aside class="tnd-single-layout__sidebar">
          <?php get_template_part('template-parts/sidebar/single-sidebar'); ?>
        </aside>

      </div>

      <?php the_content(); ?>

      <?php
        if ( is_singular(['post', 'case']) ) {
          get_template_part('template-parts/sections/single-related-content');
        }
        get_template_part('template-parts/sections/single-contact-cta', null, [
          'source' => 'post',
        ]);
      ?>
    </div>

  <?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>