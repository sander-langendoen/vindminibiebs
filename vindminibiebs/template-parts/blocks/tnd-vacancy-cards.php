<?php
/**
 * Block: TND Vacancy Cards
 */

if ( ! isset( $block ) ) {
  return;
}

$anchor = ! empty( $block['anchor'] ) ? $block['anchor'] : $block['id'];

$mode        = get_field('vc_mode') ?: 'auto';
$count       = (int) ( get_field('vc_count') ?: 3 );
$selected    = get_field('vc_selected') ?: [];
$heading     = get_field('vc_heading') ?: '';
$buttonLabel = get_field('vc_button_label') ?: __( 'Lees meer', 'tnd' );

// query vacatures
$posts = [];

if ( $mode === 'manual' && ! empty( $selected ) ) {
  // Relationship return_format: object
  $posts = $selected;
} else {
  $query = new WP_Query([
    'post_type'      => 'vacancy',
    'post_status'    => 'publish',
    'posts_per_page' => max(1, min(12, $count)),
    'orderby'        => 'date',
    'order'          => 'DESC',
    'no_found_rows'  => true,
  ]);

  if ( $query->have_posts() ) {
    $posts = $query->posts;
  }
}

if ( empty( $posts ) ) {
  return;
}
?>

<section id="<?php echo esc_attr( $anchor ); ?>" class="tnd-vacancy-cards pb-xl">
  <div class="tnd-vacancy-cards__inner container">

    <?php if ( $heading ) : ?>
      <h2 class="tnd-vacancy-cards__heading"><?php echo esc_html( $heading ); ?></h2>
    <?php endif; ?>

    <div class="tnd-vacancy-cards__grid">

      <?php foreach ( $posts as $post ) :
        $post_id = is_object($post) ? $post->ID : (int) $post;

        $title = get_the_title( $post_id );
        $url   = get_permalink( $post_id );

        // tekst: excerpt -> content fallback (kort)
        $excerpt = get_the_excerpt( $post_id );
        if ( ! $excerpt ) {
          $excerpt = wp_strip_all_tags( get_post_field( 'post_content', $post_id ) );
        }
        $excerpt = wp_trim_words( $excerpt, 26, '…' );
      ?>
        <article class="tnd-highlight-card">

          <div class="tnd-highlight-card__content">

            <?php if ( $title ) : ?>
              <h3 class="tnd-highlight-card__title">
                <?php echo esc_html( $title ); ?>
              </h3>
            <?php endif; ?>

            <?php if ( $excerpt ) : ?>
              <div class="tnd-highlight-card__text">
                <?php echo wp_kses_post( wpautop( $excerpt ) ); ?>
              </div>
            <?php endif; ?>

            <?php if ( $url ) : ?>
              <div class="tnd-highlight-card__actions">
                <a href="<?php echo esc_url( $url ); ?>"
                   class="tnd-highlight-card__button">
                  <?php echo esc_html( strtoupper( $buttonLabel ) ); ?>
                </a>
              </div>
            <?php endif; ?>

          </div>

          <?php if ( $url ) : ?>
            <a href="<?php echo esc_url( $url ); ?>" class="anchor-full-overlay" aria-label="<?php echo esc_attr( $title ); ?>"></a>
          <?php endif; ?>

        </article>
      <?php endforeach; ?>

    </div>

  </div>
</section>