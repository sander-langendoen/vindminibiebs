<?php
/**
 * Archive template: TND Articles Grid (no filter)
 */

get_header();

$queried = get_queried_object();

// Archive title + optional intro
$archive_title = get_the_archive_title();
$archive_intro = get_the_archive_description(); // kan HTML bevatten

// Pagination via main query
global $wp_query;
?>

<main id="primary" class="site-main">

    <?php if ( function_exists('yoast_breadcrumb') && ! is_front_page() && ! is_home() ) : ?>
        <div class="breadcrumbs container" aria-label="<?php esc_attr_e('Breadcrumbs', 'tnd'); ?>">
        <?php yoast_breadcrumb('<p class="breadcrumbs__inner">','</p>'); ?>
        </div>
    <?php endif; ?>

  <section class="tnd-articles-grid pb-xl">
    <div class="tnd-articles-grid__inner container">

      <header class="tnd-articles-grid__header">
        <div class="tnd-articles-grid__header-left">
          <?php if ( $archive_title ) : ?>
            <h1 class="tnd-articles-grid__heading">
              <?php echo wp_kses_post( $archive_title ); ?>
            </h1>
          <?php endif; ?>

          <?php if ( $archive_intro ) : ?>
            <div class="tnd-articles-grid__intro">
              <?php echo wp_kses_post( wpautop( $archive_intro ) ); ?>
            </div>
          <?php endif; ?>
        </div>
      </header>

      <?php if ( have_posts() ) : ?>
        <div class="tnd-articles-grid__items">
          <?php
          $index = 0;

          while ( have_posts() ) : the_post();

            $classes = 'tnd-article tnd-article--standard';

            $post_type = get_post_type();

            // Case check: post type OF categorie = case (zoals in je block)
            $is_case    = ( $post_type === 'case' ) || has_category( 'case' );
            $type_class = $is_case ? 'is-case' : 'is-post';

            // Knowledge categorie (NL + EN)
            $is_knowledge    = has_category( [ 'kennis', 'knowledge' ] );
            $knowledge_class = $is_knowledge ? 'is-knowledge' : '';

            $classes .= ' ' . $type_class . ' ' . $knowledge_class;

            // Thumbnail
            $thumb_id = get_post_thumbnail_id();
            $thumb    = $thumb_id ? wp_get_attachment_image(
                $thumb_id,
                'medium_large',
                false,
                [
                'class'   => 'tnd-article__image',
                'loading' => 'lazy',
                ]
            ) : '';
            ?>
            <article class="<?php echo esc_attr( $classes ); ?>">

                <?php if ( $thumb ) : ?>
                <div class="tnd-article__image-wrap">
                    <?php echo $thumb; ?>
                </div>
                <?php endif; ?>

                <div class="tnd-article__content">
                <?php
                $cats = get_the_category();
                $cats = array_values(array_filter($cats, function($cat) {
                    if (! $cat || is_wp_error($cat)) return false;
                    if ((int) $cat->term_id === 1) return false;
                    return true;
                }));
                ?>

                <?php if ( $cats ) : ?>
                    <div class="tnd-article__badges">
                    <?php foreach ( $cats as $cat ) : ?>
                        <span class="tnd-article__badge"><?php echo esc_html( $cat->name ); ?></span>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <h3 class="tnd-article__title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>

                <div class="tnd-article__excerpt">
                    <?php
                    if ( has_excerpt() ) {
                    the_excerpt();
                    } else {
                    echo wp_kses_post( wp_trim_words( get_the_content(), 40 ) );
                    }
                    ?>
                </div>

                <div class="tnd-article__actions">
                    <a href="<?php the_permalink(); ?>" class="tnd-article__button">
                    <?php esc_html_e( 'Lees meer', 'tnd' ); ?>
                    </a>
                </div>
                </div>

                <a href="<?php the_permalink(); ?>" class="anchor-full-overlay" aria-label="<?php echo esc_attr( get_the_title() ); ?>"></a>
            </article>
            <?php endwhile; ?>
        </div>

        <nav class="tnd-pagination mt-lg">
          <?php
          echo paginate_links([
            'total'   => (int) $wp_query->max_num_pages,
            'current' => max(1, get_query_var('paged')),
            'prev_text' => '‹',
            'next_text' => '›',
          ]);
          ?>
        </nav>

      <?php else : ?>
        <p><?php esc_html_e( 'Geen berichten gevonden.', 'tnd' ); ?></p>
      <?php endif; ?>

    </div>
  </section>

</main>

<?php get_footer(); ?>