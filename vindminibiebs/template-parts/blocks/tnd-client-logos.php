<?php
/**
 * Block: TND Client Logos
 */

if ( ! isset( $block ) ) {
    return;
}

// Uniek ID / anchor
$anchor = ! empty( $block['anchor'] ) ? $block['anchor'] : $block['id'];

// ACF velden
$fields = get_fields( $block['id'] ) ?: [];

$defaults = [
    'heading'    => 'Wij werken voor',
    'intro_text' => '',
    'bg_color'   => 'ffffff',
    'text_color' => 'black',
    'logos'      => [],
];

$fields = array_merge( $defaults, $fields );
extract( $fields );

// Kleuren whitelist
$bg_allowed   = [ 'ffffff', 'F0F0F4', 'f1b300', '008ece' ];
$text_allowed = [ 'white', 'black', 'grey' ];

if ( ! in_array( $bg_color, $bg_allowed, true ) ) {
    $bg_color = 'ffffff';
}
if ( ! in_array( $text_color, $text_allowed, true ) ) {
    $text_color = 'black';
}

$bg_class   = 'tnd-bg--' . sanitize_html_class( $bg_color );
$text_class = 'tnd-text--' . sanitize_html_class( $text_color );
?>

<section id="<?php echo esc_attr( $anchor ); ?>"
         class="tnd-client-logos <?php echo esc_attr( $bg_class ); ?>">
    <div class="tnd-client-logos__inner container">

        <?php if ( $heading ) : ?>
            <h2 class="tnd-client-logos__heading">
                <?php echo esc_html( $heading ); ?>
            </h2>
        <?php endif; ?>

        <div class="tnd-client-logos__content <?php echo esc_attr( $text_class ); ?>">

            <?php if ( $intro_text ) : ?>
                <div class="tnd-client-logos__intro">
                    <?php echo wp_kses_post( $intro_text ); ?>
                </div>
            <?php endif; ?>

            <?php if ( ! empty( $logos ) ) : ?>
                <ul class="tnd-client-logos__list">
                    <?php foreach ( $logos as $row ) :

                        $logo_image = $row['logo_image'] ?? null;
                        $logo_name  = $row['logo_name']  ?? '';
                        $logo_url   = $row['logo_url']   ?? '';

                        if ( ! $logo_image || empty( $logo_image['ID'] ) ) {
                            continue;
                        }

                        $alt = $logo_name ?: get_post_meta( $logo_image['ID'], '_wp_attachment_image_alt', true );

                        $img_html = wp_get_attachment_image(
                            $logo_image['ID'],
                            'medium',
                            false,
                            [
                                'class'   => 'tnd-client-logos__img',
                                'loading' => 'lazy',
                                'alt'     => $alt,
                            ]
                        );
                        ?>
                        <li class="tnd-client-logos__item">
                            <?php if ( $logo_url ) : ?>
                                <a href="<?php echo esc_url( $logo_url ); ?>"
                                   class="tnd-client-logos__link"
                                   target="_blank" rel="noopener">
                                    <?php echo $img_html; ?>
                                </a>
                            <?php else : ?>
                                <?php echo $img_html; ?>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

        </div>

    </div>
</section>