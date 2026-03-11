<?php
/**
 * Section: Contact CTA (single + 404 options)
 * Usage:
 * - single: get_template_part(..., null, ['source'=>'post'])
 * - 404:    get_template_part(..., null, ['source'=>'404-options'])
 */

$source = $args['source'] ?? 'post';

// --------------------
// 1) Source bepalen
// --------------------
if ( $source === '404-options' ) {
    $context_id = 'option'; // ACF options storage
    $show   = (bool) get_field('404_contact_show', $context_id);
    if ( ! $show ) return;

    $profile    = get_field('404_contact_profile', $context_id);
    $heading    = (string) ( get_field('404_contact_heading', $context_id) ?: '' );
    $intro_text = (string) ( get_field('404_contact_intro_text', $context_id) ?: '' );
    $cta        = get_field('404_contact_cta', $context_id);
    $fallback_image = get_field('404_contact_image', $context_id);

} else {
    // default: post context (single post/case/vacancy)
    $context_id = (int) get_the_ID();

    $show = get_field('tnd_single_contact_show', $context_id);
    $show = ( $show !== null ) ? (bool) $show : true; // als field niet bestaat: default aan
    if ( ! $show ) return;

    $profile    = get_field('tnd_single_contact_profile', $context_id);
    $heading    = (string) ( get_field('tnd_single_contact_heading', $context_id) ?: '' );
    $intro_text = (string) ( get_field('tnd_single_contact_intro_text', $context_id) ?: '' );
    $cta        = get_field('tnd_single_contact_cta', $context_id);
    $fallback_image = get_field('tnd_single_contact_image', $context_id);
}

// --------------------
// 2) Team data
// --------------------
$profile_post = is_object($profile) ? $profile : null;
$profile_id   = $profile_post ? (int) $profile_post->ID : 0;

$profile_name = $profile_id ? get_the_title($profile_id) : '';
$team_email   = $profile_id ? (string) get_field('email_address', $profile_id) : '';
$team_phone   = $profile_id ? (string) get_field('phone_number', $profile_id) : '';

$avatar_html = '';
if ( $profile_id ) {
    $profile_image = get_field('image', $profile_id);
    if ( $profile_image && ! empty($profile_image['ID']) ) {
        $avatar_html = wp_get_attachment_image($profile_image['ID'], 'medium', false, [
            'class' => 'tnd-page-cta__img',
            'loading' => 'lazy',
        ]);
    }
}
if ( ! $avatar_html && $fallback_image && ! empty($fallback_image['ID']) ) {
    $avatar_html = wp_get_attachment_image($fallback_image['ID'], 'medium', false, [
        'class' => 'tnd-page-cta__img',
        'loading' => 'lazy',
    ]);
}

// CTA link
$cta_href   = is_array($cta) ? ($cta['url'] ?? '') : '';
$cta_label  = is_array($cta) ? ($cta['title'] ?? '') : '';
$cta_target = is_array($cta) ? ($cta['target'] ?? '_self') : '_self';
?>

<section class="tnd-page-cta">
  <div class="tnd-page-cta__inner container">

    <?php if ( $avatar_html ) : ?>
      <div class="tnd-page-cta__image-wrap">
        <div class="tnd-page-cta__image-circle">
          <?php echo $avatar_html; ?>
        </div>
      </div>
    <?php endif; ?>

    <div class="tnd-page-cta__content">
      <?php if ( $heading ) : ?>
        <h2 class="tnd-page-cta__heading"><?php echo esc_html($heading); ?></h2>
      <?php endif; ?>

      <?php if ( $intro_text ) : ?>
        <div class="tnd-page-cta__intro"><?php echo wp_kses_post(wpautop($intro_text)); ?></div>
      <?php endif; ?>

      <?php if ( $cta_href && $cta_label ) : ?>
        <div class="tnd-page-cta__actions">
          <a href="<?php echo esc_url($cta_href); ?>" target="<?php echo esc_attr($cta_target); ?>" class="tnd-btn tnd-btn--ghost tnd-page-cta__button">
            <?php echo esc_html($cta_label); ?>
          </a>
        </div>
      <?php endif; ?>
    </div>

  </div>
</section>