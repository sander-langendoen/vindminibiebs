<?php
/**
 * Block: TND Expertise Grid
 */

if ( ! isset( $block ) ) {
    return;
}

// Uniek ID / anchor
$anchor = ! empty( $block['anchor'] ) ? $block['anchor'] : $block['id'];

// Velden voor dit block (via block-ID)
$fields = get_fields( $block['id'] ) ?: [];

// Defaults
$defaults = [
    'heading'      => '',
    'intro_text'   => '',
    'bg_color'     => 'ffffff',
    'text_color'   => 'grey',
    'source_type'  => 'latest',   // latest | manual
    'posts_count'  => 0,
    'posts_manual' => [],
];

$fields = array_merge( $defaults, $fields );
extract( $fields );

// Kleuren (komen uit je color component via clone; velden zelf heten bg_color / text_color)
$bg_allowed   = [ 'ffffff', 'F0F0F4', 'f1b300', '008ece' ];
$text_allowed = [ 'white', 'black', 'grey' ];

if ( ! in_array( $bg_color, $bg_allowed, true ) ) {
    $bg_color = 'ffffff';
}
if ( ! in_array( $text_color, $text_allowed, true ) ) {
    $text_color = 'grey';
}

$bg_class   = 'tnd-bg--' . sanitize_html_class( $bg_color );
$text_class = 'tnd-text--' . sanitize_html_class( $text_color );

// ----------------------------------------------------
// Query opbouwen
// ----------------------------------------------------
$post_type = 'expertise'; // ← evt. aanpassen naar 'service'

$query_args = [
    'post_type'      => $post_type,
    'posts_per_page' => -1,
];

if ( $source_type === 'manual' && ! empty( $posts_manual ) ) {

    // Relationship return_format = object → IDs eruit vissen
    $ids = array_map(
        static function ( $item ) {
            return is_object( $item ) ? $item->ID : (int) $item;
        },
        $posts_manual
    );
    $ids = array_filter( $ids );

    if ( empty( $ids ) ) {
        return; // niks te tonen
    }

    $query_args['post__in']       = $ids;
    $query_args['orderby']        = 'post__in';
    $query_args['posts_per_page'] = -1;

} else {

    // "latest" mode
    $count = (int) $posts_count;
    if ( $count <= 0 ) {
        $count = -1; // alle
    }

    $query_args['posts_per_page'] = $count;
    $query_args['orderby']        = [
        'menu_order' => 'ASC',
        'date'       => 'DESC',
    ];
}

$exp_query = new WP_Query( $query_args );

if ( ! $exp_query->have_posts() ) {
    return;
}
?>

<section id="<?php echo esc_attr( $anchor ); ?>"
         class="tnd-expertise-grid <?php echo esc_attr( $bg_class ); ?>">
    <div class="tnd-expertise-grid__inner container <?php echo esc_attr( $text_class ); ?>">

        <?php if ( $heading || $intro_text ) : ?>
            <header class="tnd-expertise-grid__header pb-md">
                <?php if ( $heading ) : ?>
                    <h2 class="tnd-expertise-grid__heading">
                        <?php echo esc_html( $heading ); ?>
                    </h2>
                <?php endif; ?>

                <?php if ( $intro_text ) : ?>
                    <div class="tnd-expertise-grid__intro">
                        <?php echo wp_kses_post( wpautop( $intro_text ) ); ?>
                    </div>
                <?php endif; ?>
            </header>
        <?php endif; ?>

        <div class="tnd-expertise-grid__items">
            <?php
            while ( $exp_query->have_posts() ) :
                $exp_query->the_post();

                $post_id   = get_the_ID();
                $title     = get_the_title();
                $permalink = get_permalink();
                $thumb_html = '';

                if ( has_post_thumbnail() ) {
                    $thumb_html = get_the_post_thumbnail(
                        $post_id,
                        'large',
                        [
                            'class'   => 'tnd-expertise-card__image',
                            'loading' => 'lazy',
                        ]
                    );
                }

                $excerpt = get_the_excerpt();
                ?>
                <article class="tnd-expertise-card">
                    <?php if ( $thumb_html ) : ?>
                        <a href="<?php echo esc_url( $permalink ); ?>"
                           class="tnd-expertise-card__image-link">
                            <?php echo $thumb_html; ?>
                        </a>
                    <?php endif; ?>

                    <div class="tnd-expertise-card__body">
                        <?php if ( $title ) : ?>
                            <h3 class="tnd-expertise-card__title">
                                <?php echo esc_html( $title ); ?>
                            </h3>
                        <?php endif; ?>

                        <?php if ( $excerpt ) : ?>
                            <div class="tnd-expertise-card__excerpt">
                                <?php echo wp_kses_post( wpautop( $excerpt ) ); ?>
                            </div>
                        <?php endif; ?>

                        <div class="tnd-expertise-card__actions">
                            <a href="<?php echo esc_url( $permalink ); ?>"
                               class="tnd-btn tnd-btn--ghost">
                                <?php esc_html_e( 'Lees meer', 'tnd' ); ?>
                            </a>
                        </div>
                    </div>
                    <a href="<?php echo esc_url( $permalink ); ?>" class="anchor-full-overlay"></a>
                </article>
            <?php endwhile; ?>
        </div>

    </div>
</section>

<?php
wp_reset_postdata();