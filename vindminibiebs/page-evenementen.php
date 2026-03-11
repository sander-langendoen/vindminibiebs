<?php
/**
 * Template Name: Page Evenementen Overzicht
 */
get_header();

$today = current_time('Ymd');

// ?show=all | ?show=past | default = upcoming
$show = isset($_GET['show']) ? sanitize_text_field($_GET['show']) : 'upcoming';

$args = [
    'post_type'      => 'evenement',
    'posts_per_page' => -1,
    'meta_key'       => 'event_date',
    'orderby'        => 'meta_value_num',
    'order'          => 'ASC',
];

// Filter op datum
if ($show === 'upcoming') {
    $args['meta_query'] = [
        [
            'key'     => 'event_date',
            'value'   => $today,
            'compare' => '>=',
            'type'    => 'NUMERIC',
        ]
    ];
} elseif ($show === 'past') {
    $args['meta_query'] = [
        [
            'key'     => 'event_date',
            'value'   => $today,
            'compare' => '<',
            'type'    => 'NUMERIC',
        ]
    ];
    // verleden meestal newest first netter
    $args['order'] = 'DESC';
}

// all = geen meta_query

$events = new WP_Query($args);
?>

<main>

  <?php if ( function_exists('yoast_breadcrumb') && ! is_front_page() && ! is_home() ) : ?>
    <div class="breadcrumbs container" aria-label="<?php esc_attr_e('Breadcrumbs', 'tnd'); ?>">
      <?php yoast_breadcrumb('<p class="breadcrumbs__inner">','</p>'); ?>
    </div>
  <?php endif; ?>

  <div class="tnd-events__intro container">
    <h1><?php the_title(); ?></h1>

    <?php if ( get_the_content() ) : ?>
      <?php the_content(); ?>
    <?php endif; ?>
  </div>

  <?php if ( $events->have_posts() ) : ?>

    <?php
    $show = isset($_GET['show']) ? sanitize_text_field($_GET['show']) : 'upcoming';
    $base_url = get_permalink();

    // upcoming = base url (zonder query), rest = ?show=...
    $filter_urls = [
    'upcoming' => $base_url,
    'all'      => add_query_arg('show', 'all', $base_url),
    'past'     => add_query_arg('show', 'past', $base_url),
    ];
    ?>

    <div class="tnd-articles-grid__filter tnd-events-filter container mb-sm">
        <div class="dropdown gw-taxonomy-dropdown">
            <button
            id="events-date-filter-dropdown"
            class="gw-taxonomy-dropdown__trigger"
            type="button"
            aria-haspopup="true"
            aria-expanded="false"
            data-toggle="dropdown"
            data-display="static"
            >
            <?php echo esc_html__('Filter op datum', 'tnd'); ?>
            </button>

            <ul class="gw-taxonomy-dropdown__menu dropdown-menu" aria-labelledby="events-date-filter-dropdown">

            <li class="gw-taxonomy-dropdown__item">
                <a class="gw-taxonomy-dropdown__link <?php echo ($show === 'upcoming') ? 'is-active' : ''; ?>"
                href="<?php echo esc_url($filter_urls['upcoming']); ?>">
                <?php echo esc_html__('Toekomstige evenementen', 'tnd'); ?>
                </a>
            </li>

            <li class="gw-taxonomy-dropdown__item">
                <a class="gw-taxonomy-dropdown__link <?php echo ($show === 'all') ? 'is-active' : ''; ?>"
                href="<?php echo esc_url($filter_urls['all']); ?>">
                <?php echo esc_html__('Alle evenementen', 'tnd'); ?>
                </a>
            </li>

            <li class="gw-taxonomy-dropdown__item">
                <a class="gw-taxonomy-dropdown__link <?php echo ($show === 'past') ? 'is-active' : ''; ?>"
                href="<?php echo esc_url($filter_urls['past']); ?>">
                <?php echo esc_html__('Afgelopen evenementen', 'tnd'); ?>
                </a>
            </li>

            </ul>
        </div>
    </div>

    <div class="tnd-events-grid container pb-xl">

      <?php while ( $events->have_posts() ) : $events->the_post(); ?>

        <?php
          $date  = get_field('event_date');
          $time  = get_field('event_time');
          $intro = get_field('event_intro');

          // Robuust parsen (d/m/Y of Ymd)
          $day = '';
          $month = '';

          if ($date) {
            if (preg_match('~^\d{2}/\d{2}/\d{4}$~', $date)) {
              $dt = DateTime::createFromFormat('d/m/Y', $date);
            } elseif (preg_match('~^\d{8}$~', $date)) {
              $dt = DateTime::createFromFormat('Ymd', $date);
            } else {
              $dt = new DateTime($date);
            }

            if ($dt) {
              $day   = $dt->format('d');
              $month = $dt->format('m');
            }
          }
        ?>

        <article class="tnd-event-card">

          <div class="tnd-event-card__date">
            <?php if($day): ?><span class="day"><?php echo esc_html($day); ?></span><?php endif; ?>
            <?php if($month): ?><span class="month"><?php echo esc_html($month); ?></span><?php endif; ?>
            <?php if($time): ?><span class="time"><?php echo esc_html($time); ?> h</span><?php endif; ?>
          </div>

          <h2><?php the_title(); ?></h2>

          <?php if($intro): ?>
            <p><?php echo esc_html($intro); ?></p>
          <?php endif; ?>

          <div class="tnd-event-card__actions more">
            <span class="tnd-event-card__button">
              <?php echo esc_html__( 'Meer informatie', 'tnd' ); ?>
            </span>
          </div>

          <a href="<?php the_permalink(); ?>" class="anchor-full-overlay" aria-label="<?php echo esc_attr( get_the_title() ); ?>"></a>

        </article>

      <?php endwhile; wp_reset_postdata(); ?>

    </div>

  <?php else: ?>

    <div class="container pb-xl">
      <p>
        <?php
          // vertaalbaar + afhankelijk van filter
          if ($show === 'past') {
            esc_html_e('Er zijn momenteel geen afgelopen evenementen.', 'tnd');
          } elseif ($show === 'all') {
            esc_html_e('Er zijn momenteel geen evenementen.', 'tnd');
          } else {
            esc_html_e('Er zijn momenteel geen geplande evenementen.', 'tnd');
          }
        ?>
      </p>
    </div>

  <?php endif; ?>

</main>

<?php get_footer(); ?>