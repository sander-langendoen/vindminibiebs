<?php
/**
 * Sidebar component: Single contactpersoon (team)
 * Toont alleen: avatar + email + telefoon
 */

$post_id = get_queried_object_id();
if ( ! $post_id ) return;

$enabled = get_field('tnd_sidebar_contact_enable', $post_id);
if ( $enabled === false ) return;

$person = get_field('tnd_sidebar_contact_person', $post_id);
if ( ! is_object($person) ) return;

$team_id = $person->ID;

// ACF velden op team CPT
$img   = get_field('image', $team_id);          // image field (array)
$email = get_field('email_address', $team_id);  // text/email
$phone = get_field('phone_number', $team_id);   // text

// Avatar html
$avatar = '';
if ( is_array($img) && ! empty($img['ID']) ) {
  $avatar = wp_get_attachment_image(
    $img['ID'],
    'medium',
    false,
    [
      'class'   => 'tnd-single-contact__avatar',
      'loading' => 'lazy',
    ]
  );
}

if ( ! $avatar && ! $email && ! $phone ) {
  return;
}

// tel normaliseren
$tel_href = $phone ? preg_replace('/\s+/', '', $phone) : '';
?>
<div class="tnd-single-contact pb-md">
  <?php if ( $avatar ) : ?>
    <div class="tnd-single-contact__avatar-wrap">
      <?php echo $avatar; ?>
    </div>
  <?php endif; ?>

  <div class="tnd-single-contact__links">
    <?php if ( $email ) : ?>
      <a class="tnd-single-contact__link" href="mailto:<?php echo esc_attr($email); ?>">
        <?php echo esc_html($email); ?>
      </a>
    <?php endif; ?>

    <?php if ( $phone ) : ?>
      <a class="tnd-single-contact__link" href="tel:<?php echo esc_attr($tel_href); ?>">
        <?php echo esc_html($phone); ?>
      </a>
    <?php endif; ?>
  </div>
</div>