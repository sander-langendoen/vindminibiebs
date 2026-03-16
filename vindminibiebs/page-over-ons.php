<?php
/**
 * Template Name: Over ons Timeline
 */

get_header();

$content = get_field('about_page_content') ?: [];

$page_title    = $content['page_title'] ?? get_the_title();
$page_intro    = $content['page_intro'] ?? '';
$timeline_items = $content['timeline_items'] ?? [];
?>

<main class="sl-page sl-page--about">
	<div class="container pt-xl pb-xl">

		<header class="sl-page-header">
			<h1><?php echo esc_html($page_title); ?></h1>

			<?php if (!empty($page_intro)) : ?>
				<p class="sl-page-intro"><?php echo $page_intro; ?></p>
			<?php endif; ?>
		</header>

		<?php if (!empty($timeline_items)) : ?>
			<section class="sl-timeline" >
				<div class="sl-timeline__grid">

					<aside class="sl-timeline__rail" aria-hidden="true">
						<div class="sl-timeline__line"></div>
						<div class="sl-timeline__dots"></div>
					</aside>

					<div class="sl-timeline__items">
						<?php foreach ($timeline_items as $item) : 
							$period      = $item['period'] ?? '';
							$item_title  = $item['item_title'] ?? '';
							$item_content = $item['item_content'] ?? '';
						?>
							<article class="sl-timeline__item" >
								<?php if (!empty($period)) : ?>
									<p class="sl-timeline__subheading">
										<?php echo esc_html($period); ?>
									</p>
								<?php endif; ?>

								<?php if (!empty($item_title)) : ?>
									<h3><?php echo esc_html($item_title); ?></h3>
								<?php endif; ?>

								<?php if (!empty($item_content)) : ?>
									<div class="sl-timeline__content">
										<?php echo wp_kses_post($item_content); ?>
									</div>
								<?php endif; ?>
							</article>
						<?php endforeach; ?>
					</div>

				</div>
			</section>
		<?php endif; ?>

	</div>
</main>

<?php get_footer(); ?>