<?php
/**
 * Block: TND Blog & Cases Grid
 */

if ( ! isset( $block ) ) {
    return;
}

$anchor = ! empty( $block['anchor'] ) ? $block['anchor'] : $block['id'];

$fields = get_fields( $block['id'] ) ?: [];

$defaults = [
    'heading'       => '',
    'intro_text'    => '',
    'posts_per_page'=> -1,
    'show_filter'   => true,
];

$fields = array_merge( $defaults, $fields );
extract( $fields );

// Zorg dat posts_per_page een fatsoenlijk getal is
$posts_per_page = -1;

// Gekozen categorie via GET
$current_cat = isset( $_GET['tnd_cat'] ) ? (int) $_GET['tnd_cat'] : 0;

// Query args
$query_args = [
    'post_type'      => [ 'post', 'case' ],
    'posts_per_page' => $posts_per_page,
    'post_status'    => 'publish',
];

if ( $current_cat ) {
    $query_args['cat'] = $current_cat; // werkt met standaard category-tax
}

$loop = new WP_Query( $query_args );
?>

<section id="<?php echo esc_attr( $anchor ); ?>" class="tnd-articles-grid pb-xl">
    <div class="tnd-articles-grid__inner container">

        <?php if ( $heading || $intro_text || $show_filter ) : ?>
            <header class="tnd-articles-grid__header">
                <div class="tnd-articles-grid__header-left">
                    <?php if ( $heading ) : ?>
                        <h2 class="tnd-articles-grid__heading">
                            <?php echo esc_html( $heading ); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if ( $intro_text ) : ?>
                        <div class="tnd-articles-grid__intro">
                            <?php echo wp_kses_post( wpautop( $intro_text ) ); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ( $show_filter ) : ?>
                    <?php
                    // Alle categorieën die gebruikt worden (ook bij cases, omdat case aan category hangt)
                    $cats = get_categories( [
                        'hide_empty' => true,
                    ] );

                    // Basis-URL zonder tnd_cat parameter
                    $base_url = remove_query_arg( 'tnd_cat' );

                    // Uniek ID voor aria-labelledby
                    $dropdown_id = $anchor . '-cat-dropdown';

                    // Label van de button (actieve categorie of default)
                    $current_label = $current_cat
                        ? get_cat_name( $current_cat )
                        : __( 'Filter by category', 'tnd' );
                    ?>

                    <?php if ( ! empty( $cats ) ) : ?>
                        <div class="tnd-articles-grid__filter mb-sm">
                            <div class="dropdown gw-taxonomy-dropdown">
                                <button
                                    id="<?php echo esc_attr( $dropdown_id ); ?>"
                                    class="gw-taxonomy-dropdown__trigger"
                                    type="button"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                    data-toggle="dropdown"
                                    data-display="static"
                                >
                                    <?php echo esc_html( $current_label ); ?>
                                </button>

                                <ul
                                    class="gw-taxonomy-dropdown__menu dropdown-menu"
                                    aria-labelledby="<?php echo esc_attr( $dropdown_id ); ?>"
                                >
                                    <li class="gw-taxonomy-dropdown__item">
                                        <a
                                            class="gw-taxonomy-dropdown__link <?php echo $current_cat ? '' : 'is-active'; ?>"
                                            href="<?php echo esc_url( $base_url ); ?>"
                                        >
                                            <?php esc_html_e( 'Alle categorieën', 'tnd' ); ?>
                                        </a>
                                    </li>

                                    <?php foreach ( $cats as $cat ) : ?>
                                        <?php
                                        $cat_url   = add_query_arg( 'tnd_cat', $cat->term_id, $base_url );
                                        $is_active = (int) $current_cat === (int) $cat->term_id;
                                        ?>
                                        <li class="gw-taxonomy-dropdown__item">
                                            <a
                                                class="gw-taxonomy-dropdown__link <?php echo $is_active ? 'is-active' : ''; ?>"
                                                href="<?php echo esc_url( $cat_url ); ?>"
                                            >
                                                <?php echo esc_html( $cat->name ); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </header>
        <?php endif; ?>

        <?php if ( $loop->have_posts() ) : ?>
            <div class="tnd-articles-grid__items">
                <?php
                $index = 0;

                while ( $loop->have_posts() ) :
                    $loop->the_post();
                    $index++;

                    // Featured (blijft zoals het was)
                    $is_featured = ( 1 === $index );
                    $classes     = $is_featured
                        ? 'tnd-article tnd-article--featured'
                        : 'tnd-article tnd-article--standard';

                    // Case check: post type OF categorie = case
                    $post_type = get_post_type();
                    $is_case   = ( $post_type === 'case' ) || has_category( 'case' );

                    $type_class = $is_case ? 'is-case' : 'is-post';

                    // Knowledge categorie (NL + EN)
                    $is_knowledge    = has_category( [ 'kennis', 'knowledge' ] );
                    $knowledge_class = $is_knowledge ? 'is-knowledge' : '';

                    // Classes samenvoegen
                    $classes .= ' ' . $type_class . ' ' . $knowledge_class;

                    // Thumbnail
                    $thumb_id = get_post_thumbnail_id();
                    $thumb    = $thumb_id ? wp_get_attachment_image(
                        $thumb_id,
                        $is_featured ? 'large' : 'medium_large',
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
                            // categorie badge(s)
                            $cats = get_the_category();
                            // Filter “default”/uncategorized eruit
                            $cats = array_values(array_filter($cats, function($cat) {
                            if (! $cat || is_wp_error($cat)) return false;

                            // WordPress default category is meestal term_id 1
                            if ((int) $cat->term_id === 1) return false;

                            return true;
                            }));
                            if ( $cats ) :
                                ?>
                                <div class="tnd-article__badges">
                                    <?php foreach ( $cats as $cat ) : ?>
                                        <span class="tnd-article__badge">
                                            <?php echo esc_html( $cat->name ); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <h3 class="tnd-article__title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>

                            <div class="tnd-article__excerpt">
                                <?php
                                // Gebruik excerpt of gestripte content
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

                        <a href="<?php the_permalink(); ?>" class="anchor-full-overlay"></a>
                    </article>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <p><?php esc_html_e( 'Geen berichten gevonden.', 'tnd' ); ?></p>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
    </div>
</section>