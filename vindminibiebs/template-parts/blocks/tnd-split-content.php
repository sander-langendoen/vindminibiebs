<?php
/**
 * Block: TND Split Content
 */

$anchor = ! empty( $block['anchor'] ) ? $block['anchor'] : $block['id'];

// Alle ACF-velden ophalen
$fields = get_fields( $block['id'] ) ?: [];

// Defaults
$defaults = [
	'intro_heading' => '',
	'intro_text'    => '',
	'cta_label'     => '',
	'cta_url'       => null,
	'hero_image'    => null,
	'column_order'  => 'text-left',
];

$fields = array_merge( $defaults, $fields );
extract( $fields );

// Alias
$text  = $intro_text;
$image = $hero_image;

// CTA link verwerken
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

// Veiligheid column order
$allowed_orders = [ 'text-left', 'text-right' ];
if ( ! in_array( $column_order, $allowed_orders, true ) ) {
	$column_order = 'text-left';
}

$order_class = 'tnd-split-content--' . sanitize_html_class( $column_order );

// ----------------------------------------------------
// ACF FocusPoint support (en backwards compatible)
// ----------------------------------------------------
$image_id    = 0;
$focus_left  = 50;
$focus_top   = 50;

if ( is_array( $image ) ) {
	// Klassieke ACF image array gebruikt meestal 'ID'
	// ACF FocusPoint gebruikt 'id' + 'left'/'top'
	$image_id = (int) ( $image['ID'] ?? $image['id'] ?? $image['attachment_id'] ?? $image['image_id'] ?? 0 );

	if ( isset( $image['left'] ) ) {
		$focus_left = (float) $image['left'];
	}
	if ( isset( $image['top'] ) ) {
		$focus_top = (float) $image['top'];
	}
} elseif ( is_numeric( $image ) ) {
	// Indien return format ooit "Image ID" is
	$image_id = (int) $image;
}

// Clamp waardes (veilig)
$focus_left = max( 0, min( 100, $focus_left ) );
$focus_top  = max( 0, min( 100, $focus_top ) );

// Inline object-position style (werkt samen met object-fit: cover in CSS)
$img_style = sprintf(
	'object-position:%s%% %s%%;',
	$focus_left,
	$focus_top
);
?>

<section id="<?php echo esc_attr( $anchor ); ?>"
		 class="tnd-split-content <?php echo esc_attr( $order_class ); ?>">

	<div class="tnd-split-content__inner container container-wide">

		<div class="tnd-split-content__content">

			<?php if ( $intro_heading ) : ?>
				<h2 class="tnd-split-content__intro-heading">
					<?php echo esc_html( $intro_heading ); ?>
				</h2>
			<?php endif; ?>

			<?php if ( $text ) : ?>
				<div class="tnd-split-content__text">
					<?php echo wp_kses_post( $text ); ?>
				</div>
			<?php endif; ?>

			<?php if ( $cta_label && $cta_href ) : ?>
				<div class="tnd-split-content__actions">
					<a href="<?php echo esc_url( $cta_href ); ?>"
					   target="<?php echo esc_attr( $cta_target ); ?>"
					   class="tnd-btn tnd-btn--primary">
						<?php echo esc_html( $cta_label ); ?>
					</a>
				</div>
			<?php endif; ?>

		</div>

		<?php if ( $image_id ) : ?>
			<div class="tnd-split-content__image">
				<?php
				echo wp_get_attachment_image(
					$image_id,
					'full', // of tijdelijk 'full' als deze image size nog niet bestaat
					false,
					[
						'class'    => 'tnd-split-content__img',
						'loading'  => 'lazy',
						'decoding' => 'async',
						'sizes'    => '(min-width: 1024px) 50vw, 100vw',
						'style'    => esc_attr( $img_style ),
					]
				);
				?>
			</div>
		<?php endif; ?>

	</div>
</section>