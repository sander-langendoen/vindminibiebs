<?php
$post_id = get_the_ID();
$cats = get_the_category($post_id);

// Filter “default”/uncategorized eruit
$cats = array_values(array_filter($cats, function($cat) {
  if (! $cat || is_wp_error($cat)) return false;

  // WordPress default category is meestal term_id 1
  if ((int) $cat->term_id === 1) return false;

  // Extra zekerheid op slug
  $slug = strtolower($cat->slug ?? '');
  if (in_array($slug, ['uncategorized', 'ongecategoriseerd'], true)) return false;

  return true;
}));
?>

<div class="tnd-single-sidebar">

    <?php get_template_part('template-parts/sidebar/single-contact-person'); ?>

  <?php if ( !empty($cats) ) : ?>
    <div class="tnd-single-sidebar__section">
      <h3 class="tnd-single-sidebar__label">Categories</h3>

      <div class="tnd-single-sidebar__cats">
        <?php foreach ( $cats as $cat ) : ?>
          <a class="tnd-single-sidebar__cat" href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
            <span><?php echo esc_html($cat->name); ?></span>
            <span aria-hidden="true">›</span>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>

  <div class="tnd-single-sidebar__section">
    <h3 class="tnd-single-sidebar__label">Share this</h3>

    <div class="tnd-single-sidebar__share">
      <a class="tnd-share-btn" target="_blank" rel="noopener"
         href="<?php echo esc_url('https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode(get_permalink())); ?>">f</a>

      <a class="tnd-share-btn" target="_blank" rel="noopener"
         href="<?php echo esc_url('https://twitter.com/intent/tweet?url=' . rawurlencode(get_permalink()) . '&text=' . rawurlencode(get_the_title())); ?>">𝕏</a>

      <a class="tnd-share-btn" target="_blank" rel="noopener"
         href="<?php echo esc_url('https://www.linkedin.com/sharing/share-offsite/?url=' . rawurlencode(get_permalink())); ?>">in</a>
    </div>
  </div>

</div>