<?php
/**
 * Block: TND Benefit Grid
 */

$anchor  = ! empty( $block['anchor'] ) ? $block['anchor'] : $block['id'];
$items   = get_field('bg_items') ?: [];
$columns = get_field('bg_columns') ?: '2';

if ( empty( $items ) ) {
  return;
}

$columns = in_array( $columns, ['2','3'], true ) ? $columns : '2';

$classes = [
  'tnd-benefit-grid',
  'tnd-benefit-grid--cols-' . $columns
];
?>

<section id="<?php echo esc_attr($anchor); ?>" class="<?php echo esc_attr(implode(' ', $classes)); ?> pb-xl">
  <div class="tnd-benefit-grid__inner container">

    <div class="tnd-benefit-grid__grid">
      <?php foreach ( $items as $item ) :
        $title = $item['title'] ?? '';
        $text  = $item['text'] ?? '';
        $link = $item['link'] ?? '';
        $linktext = $item['link_text'] ?? '';
        if ( ! $title && ! $text && ! $link ) continue;
      ?>
        <article class="tnd-benefit-grid__item">
          <span class="tnd-benefit-grid__line" aria-hidden="true"></span>

          <?php if ( $title ) : ?>
            <h3 class="tnd-benefit-grid__title"><?php echo esc_html($title); ?></h3>
          <?php endif; ?>

          <?php if ( $text ) : ?>
                <div class="tnd-benefit-grid__text <?php if ( $link ) : ?>has-link<?php endif; ?>">
                    <?php echo wp_kses_post( wpautop( $text ) ); ?>
                </div>
            <?php endif; ?>

            <?php if ( $link ) : ?>
                <a class="tnd-benefit-grid__link" href="<?php echo esc_url( $link ); ?>">
                    <?php echo esc_url( $linktext ); ?>
                </a>
            <?php endif; ?>
        </article>
      <?php endforeach; ?>
    </div>

  </div>
</section>