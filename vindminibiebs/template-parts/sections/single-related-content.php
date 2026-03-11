<?php
/**
 * Section: Single Related Content
 * - Alleen gebruiken op single post/case.
 * - Gebruikt Post Settings – Related Content (ACF group):
 *   - tnd_show_related (true/false)
 *   - tnd_manual_mode (true/false)
 *   - tnd_manual_items (relationship)
 *   - tnd_latest_count (number)
 */

$post_id     = (int) get_the_ID();
$post_types  = [ 'case', 'post' ];

if ( ! is_singular( $post_types ) ) {
    return;
}

/**
 * ACF post settings
 * Let op: true/false kan '0'/'1' zijn → casten!
 */
$show_related = get_field( 'tnd_show_related', $post_id );
$show_related = ( $show_related !== null ) ? (bool) $show_related : true; // als field niet bestaat: default = true

if ( ! $show_related ) {
    return;
}

$manual_mode  = (bool) get_field( 'tnd_manual_mode', $post_id );
$manual_items = get_field( 'tnd_manual_items', $post_id ) ?: [];
$count        = (int) ( get_field( 'tnd_latest_count', $post_id ) ?: 2 );
$count        = max( 1, min( 6, $count ) );

// UI teksten (kun je later ook als ACF toevoegen als je wilt)
$heading = (defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE === 'en')
  ? 'More articles'
  : 'Meer artikelen';
$content = '';

$related_posts = [];

/**
 * MODE 1: Handmatig gekozen
 */
if ( $manual_mode ) {

    if ( ! empty( $manual_items ) && is_array( $manual_items ) ) {
        // Relationship return_format = object (zoals in je ACF group)  [oai_citation:1‡acf-export-2025-12-22 (2).json](sediment://file_000000008950722faa90a106f29f46d8)
        $related_posts = $manual_items;
    }

} else {

    /**
     * MODE 2: Categorie-match → fallback latest
     */
    $category_ids = wp_get_post_categories( $post_id );

    $args = [
        'post_type'           => $post_types,
        'posts_per_page'      => $count,
        'post_status'         => 'publish',
        'orderby'             => 'date',
        'order'               => 'DESC',
        'ignore_sticky_posts' => true,
        'post__not_in'        => [ $post_id ],
    ];

    if ( ! empty( $category_ids ) ) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $category_ids,
            ]
        ];
    }

    $query = new WP_Query( $args );

    // fallback latest
    if ( ! $query->have_posts() ) {
        unset( $args['tax_query'] );
        $query = new WP_Query( $args );
    }

    if ( $query->have_posts() ) {
        $related_posts = $query->posts;
    }

    wp_reset_postdata();
}

if ( empty( $related_posts ) ) {
    return;
}
?>

<section class="tnd-related-cases pt-xl pb-xl">
    <div class="tnd-related-cases__inner container">

        <?php if ( $heading ) : ?>
            <h2 class="tnd-related-cases__title"><?php echo esc_html( $heading ); ?></h2>
        <?php endif; ?>

        <?php if ( $content ) : ?>
            <div class="tnd-related-cases__intro"><?php echo wp_kses_post( wpautop( $content ) ); ?></div>
        <?php endif; ?>

        <div class="tnd-related-cases__grid">
            <div class="tnd-articles-grid__items">
                <?php
                global $post;

                foreach ( $related_posts as $post ) :
                    setup_postdata( $post );

                    // Case check: post type OF categorie = case
                    $post_type = get_post_type();
                    $is_case   = ( $post_type === 'case' ) || has_category( 'case' );

                    // Knowledge categorie (NL + EN)
                    $is_knowledge = has_category( [ 'kennis', 'knowledge' ] );

                    // Classes
                    $classes = 'tnd-article';
                    $classes .= $is_case ? ' is-case' : ' is-post';
                    $classes .= $is_knowledge ? ' is-knowledge' : '';

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
                            <div class="tnd-article__image-wrap"><?php echo $thumb; ?></div>
                        <?php endif; ?>

                        <div class="tnd-article__content">
                            <?php
                            $cats = get_the_category();
                            if ( $cats ) : ?>
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
                <?php endforeach; ?>

                <?php wp_reset_postdata(); ?>
            </div>
        </div>

    </div>
</section>