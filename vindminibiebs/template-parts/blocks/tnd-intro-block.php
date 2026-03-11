<?php
/**
 * Block: TND Intro Block
 */

if ( ! isset( $block ) ) {
    return;
}

// Uniek ID / anchor
$anchor = ! empty( $block['anchor'] ) ? $block['anchor'] : $block['id'];

// Alle velden op basis van block-ID (voorkomt "bleeding")
$fields = get_fields( $block['id'] ) ?: [];

// Defaults
$defaults = [
    'heading'   => '',
    'intro_text'=> '',
    'cta_label' => '',
    'cta_url'   => null, // ACF Link field (array) of string fallback
];

$fields = array_merge( $defaults, $fields );
extract( $fields );

// Link uitpakken (werkt voor Link field én string)
$cta_href   = '';
$cta_target = '_self';

if ( is_array( $cta_url ) ) {
    $cta_href   = $cta_url['url']    ?? '';
    $cta_target = $cta_url['target'] ?? '_self';

    if ( ! $cta_label && ! empty( $cta_url['title'] ) ) {
        $cta_label = $cta_url['title'];
    }
} else {
    $cta_href = $cta_url ?: '';
}

?>
<section id="<?php echo esc_attr( $anchor ); ?>" class="tnd-intro">
    <div class="tnd-intro__inner container">
        <div class="tnd-intro__content">

            <?php if ( $heading ) : ?>
                <h1 class="tnd-intro__heading">
                    <?php echo esc_html( $heading ); ?>
                </h1>
            <?php endif; ?>

            <?php if ( $intro_text ) : ?>
                <div class="tnd-intro__text">
                    <?php echo wp_kses_post( $intro_text ); ?>
                </div>
            <?php endif; ?>

            <?php if ( $cta_label && $cta_href ) : ?>
                <div class="tnd-intro__actions">
                    <a href="<?php echo esc_url( $cta_href ); ?>"
                    target="<?php echo esc_attr( $cta_target ); ?>"
                    class="tnd-btn tnd-btn--primary">
                        <?php echo esc_html( $cta_label ); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>