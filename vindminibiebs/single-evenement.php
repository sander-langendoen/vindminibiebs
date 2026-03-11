<?php get_header(); ?>

<main>

  <?php if ( function_exists('yoast_breadcrumb') && ! is_front_page() && ! is_home() ) : ?>
    <div class="breadcrumbs container" aria-label="<?php esc_attr_e('Breadcrumbs', 'tnd'); ?>">
      <?php yoast_breadcrumb('<p class="breadcrumbs__inner">','</p>'); ?>
    </div>
  <?php endif; ?>

  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <?php
      // ACF event fields
      $date  = get_field('event_date');  // bij voorkeur Ymd of iets parsebaar
      $time  = get_field('event_time');  // H:i
      $intro = get_field('event_intro'); // tekst
      $location = get_field('event_location');
      $url      = get_field('event_link');

      $day = '';
      $month = '';

      if ( $date ) {
        $ts = strtotime($date);
        if ( $ts ) {
          $day = date('d', $ts);
          $month = date('m', $ts);
        }
      }
    ?>

    <?php if ( has_post_thumbnail() ) : ?>
      <section class="tnd-hero-overlay tnd-hero-overlay--event">

        <div class="tnd-hero-overlay__image-wrapper">
          <?php the_post_thumbnail('full', [
            'class'         => 'tnd-hero-overlay__image',
            'loading'       => 'eager',
            'fetchpriority' => 'high',
            'decoding'      => 'async',
          ]); ?>
        </div>

        <div class="tnd-hero-overlay__card-wrapper container">
          <div class="tnd-hero-overlay__card tnd-bg--0b87c6 tnd-text--white">

            <h1 class="tnd-hero-overlay__title"><?php the_title(); ?></h1>

            <?php if ( $day || $month || $time ) : ?>
              <div class="tnd-hero-overlay__meta">
                <?php if ( $day ) : ?><span class="tnd-hero-overlay__chip tnd-hero-overlay__chip--day"><?php echo esc_html($day); ?></span><?php endif; ?>
                <?php if ( $month ) : ?><span class="tnd-hero-overlay__chip tnd-hero-overlay__chip--month"><?php echo esc_html($month); ?></span><?php endif; ?>
                <?php if ( $time ) : ?><span class="tnd-hero-overlay__chip tnd-hero-overlay__chip--time"><?php echo esc_html($time); ?> h</span><?php endif; ?>
              </div>
            <?php endif; ?>

            <?php if ( $intro ) : ?>
              <div class="tnd-hero-overlay__text">
                <p><?php echo esc_html( $intro ); ?></p>
              </div>
            <?php endif; ?>

            <br>
            <?php if ( $location ) : ?>
              <div class="tnd-hero-overlay__sub">
                <?php echo esc_html__('Locatie', 'tnd'); ?>:
                <?php echo esc_html($location); ?>
              </div>
            <?php endif; ?>

          </div>
        </div>

      </section>
    <?php endif; ?>

    <div class="tnd-single-layout container pb-xl">

      <div class="tnd-single-layout__grid">

        <article class="tnd-single-layout__content">

          <div class="tnd-single-layout__body">
            <?php the_content(); ?>
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
    </div>

  <?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>