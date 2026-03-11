<?php
/**
 * Block: TND Map Block
 */

$anchor   = ! empty($block['anchor']) ? $block['anchor'] : $block['id'];
$map_url  = get_field('map_url', $block['id']);
?>

<section id="<?php echo esc_attr($anchor); ?>" class="tnd-map-block">
    <div class="tnd-map-block__inner">

        <?php if ($map_url): ?>
            <iframe 
                src="<?php echo esc_url($map_url); ?>"
                width="100%"
                height="600"
                style="border:0;"
                allowfullscreen
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        <?php else: ?>
            <p>Geen map URL ingesteld.</p>
        <?php endif; ?>

    </div>
</section>