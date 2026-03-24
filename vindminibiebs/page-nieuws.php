<?php
/**
 * Template Name: Nieuws overzicht
 */

get_header();
?>

<main class="sl-page sl-page--news-overview">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<?php
		// Gutenberg/page content
		$page_content = get_the_content();
		?>

		<?php if ( ! empty( trim( wp_strip_all_tags( $page_content ) ) ) ) : ?>
			<section class="tnd-related-cases pt-xl pb-xl">
				<div class="tnd-related-cases__inner container">

					<div class="tnd-related-cases__intro entry-content">
						<?php the_content(); ?>
					</div>

				</div>
			</section>
		<?php endif; ?>

	<?php endwhile; endif; ?>

	<?php
	$news_query = new WP_Query([
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'paged'          => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
	]);
	?>

	<section class="tnd-related-cases pt-xl pb-xl">
		<div class="tnd-related-cases__inner container">

			<h2 class="tnd-related-cases__title"><?php esc_html_e( 'Nieuwsberichten', 'tnd' ); ?></h2>

			<div class="tnd-related-cases__grid">
				<div class="tnd-articles-grid__items">

					<?php if ( $news_query->have_posts() ) : ?>
						<?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>

							<?php
							$post_type = get_post_type();
							$is_case   = ( $post_type === 'case' ) || has_category( 'case' );
							$is_knowledge = has_category( [ 'kennis', 'knowledge' ] );

							$classes = 'tnd-article';
							$classes .= $is_case ? ' is-case' : ' is-post';
							$classes .= $is_knowledge ? ' is-knowledge' : '';

							$thumb_id = get_post_thumbnail_id();
							$thumb    = $thumb_id ? wp_get_attachment_image(
								$thumb_id,
								'medium_large',
								false,
								[
									'class'   => 'tnd-article__image',
									'loading' => 'lazy',
								]
							) : '';
							?>

							<article class="<?php echo esc_attr( $classes ); ?>">

								<?php if ( $thumb ) : ?>
									<div class="tnd-article__image-wrap"><?php echo $thumb; ?></div>
								<?php endif; ?>

								<div class="tnd-article__content">
									<?php
									$cats = get_the_category();
									if ( $cats ) :
									?>
										<div class="tnd-article__badges">
											<?php foreach ( $cats as $cat ) : ?>
												<span class="tnd-article__badge"><?php echo esc_html( $cat->name ); ?></span>
											<?php endforeach; ?>
										</div>
									<?php endif; ?>

									<h3 class="tnd-article__title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>

									<div class="tnd-article__excerpt">
										<?php
										if ( has_excerpt() ) {
											the_excerpt();
										} else {
											echo wp_kses_post( wp_trim_words( get_the_content(), 40 ) );
										}
										?>
									</div>

									<div class="tnd-article__actions">
										<a href="<?php the_permalink(); ?>" class="tnd-article__button">
											<?php esc_html_e( 'Lees meer', 'tnd' ); ?>
										</a>
									</div>
								</div>

								<a href="<?php the_permalink(); ?>" class="anchor-full-overlay" aria-label="<?php echo esc_attr( get_the_title() ); ?>"></a>
							</article>

						<?php endwhile; ?>
					<?php else : ?>
						<p><?php esc_html_e( 'Er zijn nog geen nieuwsberichten gevonden.', 'tnd' ); ?></p>
					<?php endif; ?>

					<?php wp_reset_postdata(); ?>

				</div>
			</div>

		</div>
	</section>

</main>

<?php get_footer(); ?>