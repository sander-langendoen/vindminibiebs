<?php
/**
 * Block: TND Hero Overlay
 */

if ( ! isset( $block ) ) {
    return;
}

// Uniek ID / anchor
$anchor = ! empty( $block['anchor'] ) ? $block['anchor'] : $block['id'];

$wrapper_attributes = get_block_wrapper_attributes([
    'class' => 'tnd-hero-overlay',
]);

// Alignment class (alignwide / alignfull / etc.)
$align_class = ! empty( $block['align'] ) ? 'align' . $block['align'] : '';

// Alle velden per block instance ophalen
$fields = get_fields( $block['id'] ) ?: [];

// Defaults (geen default teksten)
$defaults = [
    'hero_image'  => null,
    'hero_title'  => '',
    'hero_text'   => '',
    'bg_color'    => 'f1b300',
    'text_color'  => 'white',
    'cta_label'   => '',
    'cta_url'     => '',
];

$fields = array_merge( $defaults, $fields );
extract( $fields );


?>

<section id="<?php echo esc_attr( $anchor ); ?>" class="tnd-hero-overlay">

    <?php if ( $hero_image && ! empty( $hero_image['ID'] ) ) : ?>
        <div class="tnd-hero-overlay__image-wrapper">
            <?php echo wp_get_attachment_image(
                $hero_image['ID'],
                'full',
                false,
                [
                    'class'   => 'tnd-hero-overlay__image',
                    'loading' => 'lazy',
                ]
            ); ?>
        </div>
    <?php endif; ?>

    <div class="tnd-hero-overlay__card-wrapper container">
        <div class="tnd-hero-overlay__card tnd-bg--f1b300 tnd-text--white">

            <?php if ( $hero_title ) : ?>
                <h1 class="tnd-hero-overlay__title">
                    <?php echo esc_html( $hero_title ); ?>
                </h1>
            <?php endif; ?>

            <?php if ( $hero_text ) : ?>
                <div class="tnd-hero-overlay__text">
                    <?php echo wp_kses_post( $hero_text ); ?>
                </div>
            <?php endif; ?>

            <?php if ( $cta_label && $cta_url ) : ?>
                <div class="tnd-hero-overlay__actions">
                    <a href="<?php echo esc_url( $cta_url ); ?>"
                       class="tnd-btn tnd-btn--ghost tnd-hero-overlay__button">
                        <?php echo esc_html( $cta_label ); ?>
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>

</section>