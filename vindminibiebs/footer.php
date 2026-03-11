<?php wp_footer(); ?>

<?php
$footer_logo   = get_field('footer_logo', 'option');
$footer_adres  = get_field('footer_adres', 'option');
$company_title = get_field('company_description_title', 'option');
$footer_desc   = get_field('footer_company_description', 'option');

$col2_title = get_field('first_footer_menu_title', 'option');

$col2_2_title = get_field('second_footer_menu_title', 'option');
$col2_menu  = get_field('second_footer_menu', 'option');

$col3_title = get_field('third_footer_menu_title', 'option');
$col3_menu  = get_field('third_footer_menu', 'option');

$col3_2_title = get_field('third_footer_second_menu_title', 'option');
?>

<footer class="site-footer" role="contentinfo">
  <div class="site-footer__inner container">
    <div class="site-footer__grid">

      <!-- Col 1 (breder) -->
      <div class="site-footer__col site-footer__col--brand">
        <?php if (!empty($footer_logo) && !empty($footer_logo['ID'])) : ?>
          <a class="site-footer__logo" href="<?php echo esc_url(home_url('/')); ?>">
            <?php echo wp_get_attachment_image((int) $footer_logo['ID'], 'medium'); ?>
          </a>
        <?php endif; ?>

        <?php if (!empty($company_title)) : ?>
            <h3 class="site-footer__title"><?php echo esc_html($company_title); ?></h3>
        <?php endif; ?>

        <?php if (!empty($footer_desc)) : ?>
          <p class="site-footer__desc">
            <?php echo esc_html($footer_desc); ?>
          </p>
        <?php endif; ?>
      </div>

      <!-- Col 2 -->
      <div class="site-footer__col site-footer__col--menu">

        <?php if (!empty($col2_title)) : ?>
          <h3 class="site-footer__title"><?php echo esc_html($col2_title); ?></h3>          
        <?php endif; ?>

        <?php if ( $footer_adres ) : ?>
        <div class="site-footer__address">
            <?php echo wp_kses_post( $footer_adres ); ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($col2_2_title)) : ?>
          <h3 class="site-footer__title"><?php echo esc_html($col2_2_title); ?></h3>
        <?php endif; ?>

        <?php
        wp_nav_menu([
          'theme_location' => 'footer_1',
          'container'      => false,
          'menu_class'     => 'site-footer__menu',
          'fallback_cb'    => false,
        ]);
        ?>
      </div>

      <!-- Col 3 -->
      <div class="site-footer__col site-footer__col--menu">
        <?php if (!empty($col3_title)) : ?>
          <h3 class="site-footer__title"><?php echo esc_html($col3_title); ?></h3>
        <?php endif; ?>

        <?php if (!empty($col3_text)) : ?>
          <div class="site-footer__text">
            <?php
            // is een text-field in je export, dus veilig als tekst:
            echo wp_kses_post(wpautop($col3_text));
            ?>
          </div>
        <?php else : ?>
          <?php
          // Optioneel: als je later toch een 2e menu wilt i.p.v. tekst
          wp_nav_menu([
            'theme_location' => 'footer_2',
            'container'      => false,
            'menu_class'     => 'site-footer__menu',
            'fallback_cb'    => false,
          ]);
          ?>
        <?php endif; ?>

        <?php if (!empty($col3_2_title)) : ?>
          <h3 class="site-footer__title"><?php echo esc_html($col3_2_title); ?></h3>
        <?php endif; ?>

        <a class="tnd-share__link" href="https://www.linkedin.com/company/thenextdigitals/" target="_blank" rel="nofollow">
            <svg class="tnd-icon" height="50" viewBox="0 0 30 30" width="50" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.3 11.4h3v9.8h-3zM9.8 10.2c-.5 0-.8-.1-1.1-.4s-.5-.7-.5-1.1c0-.4.1-.8.4-1.1s.7-.4 1.2-.4.9.1 1.1.4.4.6.4 1.1c0 .4-.1.8-.4 1.1s-.6.4-1.1.4zM22.4 21.2h-3v-5.4c0-.6-.1-1.1-.4-1.5s-.6-.6-1.2-.6c-.4 0-.7.1-1 .4-.3.2-.4.5-.6.8 0 .1-.1.2-.1.4v6h-3v-6.7-1.7-1.4h2.6l.2 1.3h.1c.2-.3.5-.7 1-1 .5-.4 1.1-.5 2-.5 1 0 1.8.3 2.5 1s1 1.8 1 3.2v5.7z"></path>
            </svg>
            <span class="sr-only">LinkedIn</span>
        </a>
      </div>
    </div>

    <p class="site-footer__copyright">
        &copy; <?php echo date('Y'); ?> <?php echo esc_html( get_bloginfo('name') ); ?>.
    </p>
  </div>
</footer>

<span class="overlay overlay-default"></span>

</body>
</html>