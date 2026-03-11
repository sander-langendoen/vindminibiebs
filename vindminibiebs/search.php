<?php
get_header();

global $wp_query;

$search_query = get_search_query();
$found_posts  = (int) $wp_query->found_posts;
?>

<main class="tnd-search">

    <?php if ( function_exists('yoast_breadcrumb') && ! is_front_page() && ! is_home() ) : ?>
    <div class="breadcrumbs container" aria-label="<?php esc_attr_e('Breadcrumbs', 'tnd'); ?>">
      <?php yoast_breadcrumb('<p class="breadcrumbs__inner">','</p>'); ?>
    </div>
  <?php endif; ?>

  <div class="tnd-container container">

    <header class="tnd-search__header">
      <h1 class="tnd-search__title"><?php esc_html_e( 'Zoekresultaten', 'tnd' ); ?></h1>

      <form role="search" method="get" class="tnd-search__form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <label class="screen-reader-text" for="tnd-search-input">
          <?php esc_html_e( 'Zoeken naar:', 'tnd' ); ?>
        </label>

        <span class="tnd-search__icon" aria-hidden="true">
          <!-- simple search icon -->
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
            <path d="M10.5 19a8.5 8.5 0 1 1 0-17 8.5 8.5 0 0 1 0 17Z" stroke="currentColor" stroke-width="2"/>
            <path d="M16.8 16.8 22 22" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </span>

        <input
          id="tnd-search-input"
          class="tnd-search__input"
          type="search"
          placeholder="<?php echo esc_attr__( 'Zoeken …', 'tnd' ); ?>"
          value="<?php echo esc_attr( $search_query ); ?>"
          name="s"
        />

        <button class="tnd-search__submit" type="submit">
          <?php esc_html_e( 'Zoeken', 'tnd' ); ?>
        </button>
      </form>

      <?php if ( $search_query !== '' ) : ?>
        <p class="tnd-search__meta">
          <?php
            echo esc_html(
              sprintf(
                _n( '%s result for “%s”', '%s resultaten voor “%s”', $found_posts, 'tnd' ),
                number_format_i18n( $found_posts ),
                $search_query
              )
            );
          ?>
        </p>
      <?php endif; ?>
    </header>

    <?php if ( have_posts() ) : ?>
      <div class="tnd-search__results">
        <?php while ( have_posts() ) : the_post(); ?>
          <article <?php post_class( 'tnd-search__result' ); ?>>
            <h2 class="tnd-search__result-title">
              <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
              </a>
            </h2>

            <div class="tnd-search__result-url">
              <?php echo esc_html( wp_parse_url( get_permalink(), PHP_URL_PATH ) ); ?>
            </div>

            <div class="tnd-search__result-excerpt">
              <?php
                $excerpt = get_the_excerpt();
                if ( ! $excerpt ) {
                  $excerpt = wp_strip_all_tags( get_the_content() );
                }
                echo esc_html( wp_trim_words( $excerpt, 34 ) );
              ?>
            </div>
          </article>
        <?php endwhile; ?>
      </div>

      <nav class="tnd-search__pagination">
        <?php
          the_posts_pagination([
            'mid_size'  => 1,
            'prev_text' => '‹',
            'next_text' => '›',
          ]);
        ?>
      </nav>

    <?php else : ?>
      <p><?php esc_html_e( 'Geen resultaten gevonden. Probeer een andere zoekterm', 'tnd' ); ?></p>
    <?php endif; ?>

  </div>
</main>

<?php get_footer(); ?>