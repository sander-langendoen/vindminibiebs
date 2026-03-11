<?php
/**
 * Block: TND Related Cases & Blogs (PAGE ONLY)
 * - Alleen bedoeld als ACF block op pagina’s.
 * - Haalt posts/cases op via: handmatige selectie óf latest.
 */

if ( ! isset( $block ) || ! is_array( $block ) ) {
    return;
}

// Anchor
$anchor = ! empty( $block['anchor'] ) ? $block['anchor'] : ( $block['id'] ?? 'tnd-related-cases' );

// Post types
$post_types = [ 'case', 'post' ];

// Block fields (op basis van block-id, voorkomt bleeding)
$fields = get_fields( $block['id'] ) ?: [];

$heading      = $fields['heading'] ?? 'Cases & blogs';
$content      = $fields['content'] ?? '';
$show_latest  = ! empty( $fields['show_latest'] ); // bool
$cases_manual = $fields['cases_manual'] ?? [];
$button_label = $fields['button_label'] ?? 'All content';
$button_url   = $fields['button_url'] ?? '';

// Determine posts
$related_posts = [];

if ( $show_latest ) {
    $args = [
        'post_type'           => $post_types,
        'posts_per_page'      => 2,
        'post_status'         => 'publish',
        'orderby'             => 'date',
        'order'               => 'DESC',
        'ignore_sticky_posts' => true,
    ];

    $q = new WP_Query( $args );
    if ( $q->have_posts() ) {
        $related_posts = $q->posts;
    }
    wp_reset_postdata();

} else {
    if ( ! empty( $cases_manual ) && is_array( $cases_manual ) ) {
        $related_posts = $cases_manual;
    }
}

if ( empty( $related_posts ) ) {
    return;
}
?>

<section id="<?php echo esc_attr( $anchor ); ?>" class="tnd-related-cases pt-xl pb-xl">
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
                            // categorie badge(s)
                            $cats = get_the_category();
                            // Filter “default”/uncategorized eruit
                            $cats = array_values(array_filter($cats, function($cat) {
                            if (! $cat || is_wp_error($cat)) return false;

                            // WordPress default category is meestal term_id 1
                            if ((int) $cat->term_id === 1) return false;

                            return true;
                            }));
                            
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

        <?php if ( ! empty( $button_url ) && ! empty( $button_label ) ) : ?>
            <div class="tnd-related-cases__actions">
                <a href="<?php echo esc_url( $button_url ); ?>"
                   class="tnd-btn tnd-related-cases__button">
                    <?php echo esc_html( $button_label ); ?>
                </a>
            </div>
        <?php endif; ?>

    </div>
</section>