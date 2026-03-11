<?php
/**
 * Block: TND Highlight Cards
 */

if ( ! isset( $block ) ) {
    return;
}

// Uniek ID / anchor
$anchor = ! empty( $block['anchor'] ) ? $block['anchor'] : $block['id'];

// Alle velden obv block-ID
$fields = get_fields( $block['id'] ) ?: [];

// Defaults
$defaults = [
    'bg_color'  => 'f1b300', // standaard geel
    'text_color'=> 'white',
    'cards'     => [],
];

$fields = array_merge( $defaults, $fields );
extract( $fields );

// Kleuren whitelists
$bg_allowed   = [ 'ffffff', 'F0F0F4', 'f1b300', '008ece' ];
$text_allowed = [ 'white', 'black', 'grey' ];

if ( ! in_array( $bg_color, $bg_allowed, true ) ) {
    $bg_color = 'f1b300';
}
if ( ! in_array( $text_color, $text_allowed, true ) ) {
    $text_color = 'white';
}

$bg_class   = 'tnd-bg--' . sanitize_html_class( $bg_color );
$text_class = 'tnd-text--' . sanitize_html_class( $text_color );

if ( empty( $cards ) ) {
    return;
}
?>

<section id="<?php echo esc_attr( $anchor ); ?>"
         class="tnd-highlight-cards <?php echo esc_attr( $bg_class ); ?>">
    <div class="tnd-highlight-cards__inner container <?php echo esc_attr( $text_class ); ?>">

        <div class="tnd-highlight-cards__grid">
            <?php foreach ( $cards as $card ) :

                $image   = $card['image'] ?? null;
                $title   = $card['title'] ?? '';
                $content = $card['content'] ?? '';
                $link    = $card['link'] ?? null;

                $url   = $link['url'] ?? '';
                $label = $link['title'] ?? __( 'Lees meer', 'tnd' );
                $target = ! empty( $link['target'] ) ? $link['target'] : '_self';
                ?>
                <article class="tnd-highlight-card">
                    <div class="tnd-highlight-card__content">

                        <?php if ( $title ) : ?>
                            <h3 class="tnd-highlight-card__title">
                                <?php echo esc_html( $title ); ?>
                            </h3>
                        <?php endif; ?>

                        <?php if ( $content ) : ?>
                            <div class="tnd-highlight-card__text">
                                <?php echo wp_kses_post( wpautop( $content ) ); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $url ) : ?>
                            <div class="tnd-highlight-card__actions">
                                <a href="<?php echo esc_url( $url ); ?>"
                                   target="<?php echo esc_attr( $target ); ?>"
                                   class="tnd-highlight-card__button">
                                    <?php echo esc_html( strtoupper( $label ) ); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                    </div>

                    <?php if ( $url ) : ?>
                        <a href="<?php echo esc_url( $url ); ?>"
                            target="<?php echo esc_attr( $target ); ?>"
                            class="anchor-full-overlay">
                        </a>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>