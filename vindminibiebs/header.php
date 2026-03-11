<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="header has-js" data-header-state="default" data-searchbar-state="searchbar-visible" role="banner">

    <span class="menu-icon-container hide-lg-up">
		<svg height="32" viewBox="0 0 32 32" width="32" xmlns="http://www.w3.org/2000/svg"><path d="m30.8571429 24c.6311825 0 1.1428571.4477153 1.1428571 1 0 .5128358-.4411888.9355072-1.0095759.9932723l-.1332812.0067277h-29.71428576c-.63118257 0-1.14285714-.4477153-1.14285714-1 0-.5128358.44118879-.9355072 1.00957586-.9932723l.13328128-.0067277zm0-9c.6311825 0 1.1428571.4477153 1.1428571 1 0 .5128358-.4411888.9355072-1.0095759.9932723l-.1332812.0067277h-29.71428576c-.63118257 0-1.14285714-.4477153-1.14285714-1 0-.5128358.44118879-.9355072 1.00957586-.9932723l.13328128-.0067277zm0-9c.6311825 0 1.1428571.44771525 1.1428571 1 0 .51283584-.4411888.93550716-1.0095759.99327227l-.1332812.00672773h-29.71428576c-.63118257 0-1.14285714-.44771525-1.14285714-1 0-.51283584.44118879-.93550716 1.00957586-.99327227l.13328128-.00672773z" fill="#4d4d4d" fill-rule="evenodd"/></svg>
	</span>

    <div class="header__inner ui-container">
        <div class="ui-grid">
            <div class="logo-container">

                <?php
                if (function_exists('the_custom_logo') && has_custom_logo()) {
                    the_custom_logo();
                } else {
                    echo '<span class="site-header__title">' . esc_html(get_bloginfo('name')) . '</span>';
                }
                ?>
                
            </div>

            <div class="nav-container hide-md-down">
                <div class="ui-container">
                    <div class="ui-grid">

                        <nav class="header__nav site-navigation" aria-label="<?php esc_attr_e('Hoofdmenu', 'tnd'); ?>">
                        <?php
                        wp_nav_menu([
                            'theme_location' => 'primary',
                            'menu'       => 'hoofdmenu',
                            'container'      => false,
                            'menu_class'     => 'nav-primary',
                            'fallback_cb'    => false,
                            'depth'          => 2,
                        ]);
                        ?>
                        </nav>

                        <?php if ( function_exists('icl_get_languages') ) : ?>
                            <?php
                            $langs = icl_get_languages('skip_missing=1&orderby=code');
                            if ( ! empty($langs) ) :
                            ?>
                                <div class="gw-page-navigation-bar__language-switch">
                                <div class="gw-page-language-switch">
                                    <ul class="gw-page-language-switch__list">
                                    <?php foreach ( $langs as $lang ) : ?>
                                        <li class="gw-page-language-switch__item <?php echo $lang['active'] ? 'is-active' : ''; ?>">
                                        <a class="gw-page-language-switch__language"
                                            href="<?php echo esc_url($lang['url']); ?>"
                                            lang="<?php echo esc_attr($lang['language_code']); ?>"
                                            title="<?php echo esc_attr($lang['native_name']); ?>">
                                            <?php echo esc_html( strtoupper($lang['language_code']) ); ?>
                                        </a>
                                        </li>
                                    <?php endforeach; ?>
                                    </ul>
                                </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php get_template_part('template-parts/search-overlay'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
	
<nav class="nav-mobile hide-lg-up">
  
    <div class="nav-heading">

        <div class="logo-container">

            <?php
            if (function_exists('the_custom_logo') && has_custom_logo()) {
                the_custom_logo();
            } else {
                echo '<span class="site-header__title">' . esc_html(get_bloginfo('name')) . '</span>';
            }
            ?>
        </div>

        <span class="close-icon-container">
			<svg height="32" viewBox="0 0 32 32" width="32" xmlns="http://www.w3.org/2000/svg"><path d="m31.7071068.29155984c.3644894.36448934.3887887.94034568.0728979 1.33301728l-.0728979.08119628-14.2921068 14.2928932 14.2921068 14.2928933c.3905243.3905243.3905243 1.0236893 0 1.4142136-.3644893.3644893-.9403456.3887886-1.3330173.0728979l-.0811962-.0728979-14.2928933-14.2921069-14.29289326 14.2921069c-.3905243.3905243-1.02368928.3905243-1.41421357 0-.36448934-.3644893-.38878863-.9403457-.07289787-1.3330173l.07289787-.0811963 14.29210683-14.2928933-14.29210683-14.2928932c-.39052429-.39052429-.39052429-1.02368927 0-1.41421356.36448934-.36448934.94034568-.38878863 1.33301729-.07289787l.08119628.07289787 14.29289326 14.29210676 14.2928933-14.29210676c.3905243-.3905243 1.0236892-.3905243 1.4142135 0z" fill="#4d4d4d" fill-rule="evenodd"/></svg>
        </span>
    </div>

	<?php
		wp_nav_menu( array( 
			'theme_location' => 'primary', 
			'menu'       => 'hoofdmenu', 
			'menu_class' => "nav-primary", 
		) ); 
	?>

    <div class="nav-mobile__extras">

        <?php if ( function_exists('icl_get_languages') ) : ?>
            <?php $langs = icl_get_languages('skip_missing=1&orderby=code'); ?>
            <?php if ( ! empty($langs) ) : ?>
            <div class="nav-mobile__language-switch">
                <ul class="nav-mobile__language-list">
                <?php foreach ( $langs as $lang ) : ?>
                    <li class="nav-mobile__language-item <?php echo $lang['active'] ? 'is-active' : ''; ?>">
                    <a class="nav-mobile__language-link"
                        href="<?php echo esc_url($lang['url']); ?>"
                        lang="<?php echo esc_attr($lang['language_code']); ?>"
                        title="<?php echo esc_attr($lang['native_name']); ?>">
                        <?php echo esc_html( strtoupper($lang['language_code']) ); ?>
                    </a>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="nav-mobile__search">
            <form role="search" method="get" class="nav-mobile__search-form" action="<?php echo esc_url( home_url('/') ); ?>">
            <label class="screen-reader-text" for="nav-mobile-search"><?php esc_html_e('Zoeken', 'tnd'); ?></label>

            <input id="nav-mobile-search"
                    class="nav-mobile__search-input"
                    type="search"
                    name="s"
                    placeholder="<?php esc_attr_e('Zoeken…', 'tnd'); ?>"
                    value="<?php echo get_search_query(); ?>" />

            <button class="nav-mobile__search-submit" type="submit" aria-label="<?php esc_attr_e('Zoeken', 'tnd'); ?>">
                <!-- search svg -->
                <svg width="24" height="24" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M10 2a8 8 0 105.293 14.293l4.207 4.207 1.414-1.414-4.207-4.207A8 8 0 0010 2zm0 2a6 6 0 110 12 6 6 0 010-12z" fill="#000000"/>
                </svg>
            </button>
            </form>
        </div>

        </div>
</nav>