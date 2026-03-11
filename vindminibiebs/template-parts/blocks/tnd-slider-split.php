<?php
/**
 * Block: TND Slider (Split / Full) - per slide layout
 */

wp_enqueue_style('swiper');

$anchor = ! empty($block['anchor']) ? $block['anchor'] : $block['id'];

$autoplay = (bool) get_field('slider_autoplay');
$delay    = (int) (get_field('slider_delay') ?: 5000);
$slides   = get_field('slides') ?: [];

/**
 * Backwards compatibility:
 * Als slides leeg zijn, val terug op oude gallery-setup (handig bij bestaande content).
 */
if (empty($slides)) {
  $legacy_images = get_field('slider_images') ?: [];
  if (!empty($legacy_images)) {
    foreach ($legacy_images as $img) {
      $slides[] = [
        'slide_layout' => (get_field('slider_layout') ?: 'full'),
        'slide_image'  => $img,
        'slide_heading'=> get_field('split_heading') ?: '',
        'slide_text'   => get_field('split_text') ?: '',
        'slide_cta'    => get_field('split_cta'),
        'slide_order'  => (get_field('split_order') === 'slider-left') ? 'image-left' : 'image-right',
        'slide_bg'     => get_field('split_bg') ?: '#f1b300',
      ];
    }
  }
}

if (empty($slides)) return;

$data_autoplay = $autoplay ? 'true' : 'false';
$data_delay    = $delay;

?>
<section
  id="<?php echo esc_attr($anchor); ?>"
  class="tnd-slider pb-xl"
  data-autoplay="<?php echo esc_attr($data_autoplay); ?>"
  data-delay="<?php echo esc_attr($data_delay); ?>"
>
  <div class="tnd-slider__inner container container-wide">
    <div class="tnd-slider__media">
      <div class="swiper tnd-slider__swiper">
        <div class="swiper-wrapper">

          <?php foreach ($slides as $slide) :
            $layout = $slide['slide_layout'] ?? 'full';
            $img    = $slide['slide_image'] ?? null;

            if (empty($img) || empty($img['ID'])) continue;

            $heading = $slide['slide_heading'] ?? '';
            $text    = $slide['slide_text'] ?? '';
            $cta     = $slide['slide_cta'] ?? null;
            $order   = $slide['slide_order'] ?? 'image-right';
            $bg      = $slide['slide_bg'] ?? '#f1b300';

            $slide_classes = ['tnd-slider__slide'];
            $slide_classes[] = $layout === 'split' ? 'tnd-slider__slide--split' : 'tnd-slider__slide--full';
            if ($layout === 'split') {
              $slide_classes[] = $order === 'image-left' ? 'tnd-slider__slide--image-left' : 'tnd-slider__slide--image-right';
            }
          ?>
            <div class="swiper-slide <?php echo esc_attr(implode(' ', $slide_classes)); ?>">

              <?php if ($layout === 'split') : ?>
                <div class="tnd-slider__slide-inner tnd-slider__slide-inner--split" style="--tnd-slider-bg: <?php echo esc_attr($bg); ?>;">
                  <div class="tnd-slider__content">
                    <?php if ($heading) : ?>
                      <h2 class="tnd-slider__heading"><?php echo esc_html($heading); ?></h2>
                    <?php endif; ?>

                    <?php if ($text) : ?>
                      <div class="tnd-slider__text"><?php echo wp_kses_post($text); ?></div>
                    <?php endif; ?>

                    <?php if (is_array($cta) && !empty($cta['url'])) : ?>
                      <div class="tnd-slider__actions">
                        <a class="tnd-btn tnd-btn--primary"
                           href="<?php echo esc_url($cta['url']); ?>"
                           target="<?php echo esc_attr($cta['target'] ?: '_self'); ?>">
                          <?php echo esc_html($cta['title'] ?: 'Meer info'); ?>
                        </a>
                      </div>
                    <?php endif; ?>
                  </div>

                  <div class="tnd-slider__image-wrap">
                    <?php echo wp_get_attachment_image(
                      $img['ID'],
                      'large',
                      false,
                      [
                        'class'   => 'tnd-slider__image',
                        'loading' => 'lazy',
                      ]
                    ); ?>
                  </div>
                </div>

              <?php else : ?>
                <div class="tnd-slider__slide-inner tnd-slider__slide-inner--full">
                  <?php echo wp_get_attachment_image(
                    $img['ID'],
                    'large',
                    false,
                    [
                      'class'   => 'tnd-slider__image',
                      'loading' => 'lazy',
                    ]
                  ); ?>
                </div>
              <?php endif; ?>

            </div>
          <?php endforeach; ?>

        </div>

        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
      </div>
    </div>
  </div>
</section>