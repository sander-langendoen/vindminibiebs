<?php
/**
 * Block: TND Media Highlight
 *
 * Hero media met:
 * - Vimeo via blok-instelling
 * - Image via blok-instelling
 * - Per-post hero image override (ACF)
 * - Fallback naar uitgelichte afbeelding
 */

if ( ! isset( $block ) ) {
    return;
}

// Uniek ID / anchor
$anchor = ! empty( $block['anchor'] ) ? $block['anchor'] : $block['id'];

// Velden op basis van block-ID (template-level)
$fields = get_fields( $block['id'] ) ?: [];

$defaults = [
    'vimeo_id'      => '',
    'image'         => null, // fallback image vanuit het blok zelf
    'wrapper_class' => '',
];

$fields = array_merge( $defaults, $fields );
extract( $fields ); // $vimeo_id, $image, $wrapper_class

// ----------------------------------------------------
// Context post bepalen (voor per-post overrides / thumb)
// ----------------------------------------------------
$context_post_id = 0;

if ( isset( $block['post_id'] ) ) {
    $context_post_id = $block['post_id'];
} elseif ( get_queried_object_id() ) {
    $context_post_id = get_queried_object_id();
}

$has_meta_context = $context_post_id > 0;

// ----------------------------------------------------
// Per-post image override ophalen (ACF)
// - tnd_media_image_override (image)
// ----------------------------------------------------
$override_image = null;

if ( $has_meta_context ) {
    $override_image = get_field( 'tnd_media_image_override', $context_post_id );
}

// ----------------------------------------------------
// Effectieve media bepalen met prioriteit:
//
// 1) Vimeo-ID uit blok → video tonen
// 2) Image override via ACF per post
// 3) Uitgelichte afbeelding van de post
// 4) Image vanuit het blok zelf
// ----------------------------------------------------

// 1) Vimeo uit blok
$effective_vimeo_id = trim( (string) $vimeo_id );

// 2–4) Image bepalen
$effective_image_id = 0;

// 2) Per-post override
if ( $override_image && ! empty( $override_image['ID'] ) ) {
    $effective_image_id = (int) $override_image['ID'];
}

// 3) Uitgelichte afbeelding, als er nog geen override is
if ( ! $effective_image_id && $has_meta_context && has_post_thumbnail( $context_post_id ) ) {
    $effective_image_id = (int) get_post_thumbnail_id( $context_post_id );
}

// Extra fallback: als er geen context is maar we zitten wel op een single met thumbnail
if ( ! $effective_image_id && is_singular() && has_post_thumbnail() ) {
    $effective_image_id = (int) get_post_thumbnail_id();
}

// 4) Blok-image als allerlaatste fallback
if ( ! $effective_image_id && $image && ! empty( $image['ID'] ) ) {
    $effective_image_id = (int) $image['ID'];
}

// ----------------------------------------------------
// HTML voorbereiden
// ----------------------------------------------------
$has_vimeo = $effective_vimeo_id !== '';

$img_html = '';
if ( ! $has_vimeo && $effective_image_id ) {
    $img_html = wp_get_attachment_image(
        $effective_image_id,
        'full',
        false,
        [
            'class'   => 'tnd-media-highlight__image',
            'loading' => 'lazy',
        ]
    );
}

// Als er echt niks is, dan niks renderen
if ( ! $has_vimeo && ! $img_html ) {
    return;
}

$wrapper_class = trim( (string) $wrapper_class );
?>

<section id="<?php echo esc_attr( $anchor ); ?>"
         class="tnd-media-highlight alignwide <?php echo esc_attr( $wrapper_class ); ?>">
    <div class="tnd-media-highlight__inner container container-wide">

        <div class="tnd-media-highlight__media">
            <?php if ( $has_vimeo ) : ?>
                <div class="tnd-media-highlight__video-wrap">
                    <iframe
                        src="https://player.vimeo.com/video/<?php echo esc_attr( $effective_vimeo_id ); ?>"
                        class="tnd-media-highlight__video"
                        frameborder="0"
                        allow="autoplay; fullscreen; picture-in-picture"
                        allowfullscreen
                        loading="lazy">
                    </iframe>
                </div>
            <?php else : ?>
                <?php echo $img_html; ?>
            <?php endif; ?>
        </div>

    </div>
</section>