<?php
/**
 * Block: TND Hero Heading
 */

$anchor = ! empty( $block['anchor'] ) ? $block['anchor'] : $block['id'];

// Alle ACF-velden ophalen
$fields = get_fields( $block['id'] ) ?: [];

// Defaults zodat je nooit undefined vars krijgt
$defaults = [
    'heading_line_1' => '',
    'heading_line_2' => '',
];

// Defaults + echte waarden samenvoegen
$fields = array_merge( $defaults, $fields );
extract( $fields );
?>

<section id="<?php echo esc_attr( $anchor ); ?>" class="tnd-hero-heading">
    <div class="tnd-hero-heading__inner container">

        <div class="tnd-hero-heading__content">
            <?php if ( $heading_line_1 || $heading_line_2 ) : ?>
                <h1 class="tnd-hero-heading__title">
                    <?php if ( $heading_line_1 ) : ?>
                        <span><?php echo esc_html( $heading_line_1 ); ?></span>
                    <?php endif; ?>

                    <?php if ( $heading_line_2 ) : ?>
                        <span><?php echo esc_html( $heading_line_2 ); ?></span>
                    <?php endif; ?>
                </h1>
            <?php endif; ?>
        </div>
    </div>
</section>