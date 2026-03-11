<?php
// Minimal theme setup
add_action('after_setup_theme', function () {
  add_theme_support('wp-block-styles');
  add_theme_support('responsive-embeds');
  add_theme_support('appearance-tools'); // padding/margin/typography UI
  add_theme_support('editor-styles');
  add_editor_style('editor.css');
  add_theme_support('align-wide');
  add_theme_support( 'block-patterns' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'site-icon' );
    add_theme_support('custom-logo', [
        'height'      => 120,
        'width'       => 320,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
});

/**
 * Frontend assets
 */
add_action('wp_enqueue_scripts', function () {

  // Theme CSS
  wp_enqueue_style(
    'sl-theme',
    get_theme_file_uri('/assets/css/theme.css'),
    ['wp-block-library'],
    filemtime(get_theme_file_path('/assets/css/theme.css'))
  );

  // Swiper (register + enqueue)
  wp_register_style(
    'swiper',
    'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
    [],
    '11.0.0'
  );

  wp_register_script(
    'swiper',
    'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
    [],
    '11.0.0',
    true
  );

  wp_enqueue_style('swiper');

  // Bundle JS — afhankelijk van Swiper
  wp_enqueue_script(
    'tnd-bundle',
    get_theme_file_uri('/assets/js/bundle.js'),
    ['swiper'], // ⬅️ cruciaal
    filemtime(get_theme_file_path('/assets/js/bundle.js')),
    true
  );

}, 20);

add_action('enqueue_block_editor_assets', function () {

  wp_enqueue_style(
    'tnd-editor-styles',
    get_theme_file_uri('/assets/css/editor.css'),
    [],
    filemtime(get_theme_file_path('/assets/css/editor.css'))
  );

  // Swiper ook in editor
  wp_enqueue_style(
    'swiper',
    'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
    [],
    '11.0.0'
  );

  wp_enqueue_script(
    'swiper',
    'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
    [],
    '11.0.0',
    true
  );

  // Zelfde bundle gebruiken in editor
  wp_enqueue_script(
    'tnd-bundle-editor',
    get_theme_file_uri('/assets/js/bundle.js'),
    ['swiper'],
    filemtime(get_theme_file_path('/assets/js/bundle.js')),
    true
  );
});



add_action('enqueue_block_editor_assets', function () {
  wp_enqueue_style(
    'tnd-editor-styles',
    get_theme_file_uri('/assets/css/editor.css'),
    [],
    filemtime(get_theme_file_path('/assets/css/editor.css'))
  );

  wp_enqueue_style('swiper');
  wp_enqueue_script('swiper');
  wp_enqueue_script('tnd-slider');
});

require_once get_theme_file_path( '/inc/tnd-social-share.php' );




add_action('after_setup_theme', function () {
  add_theme_support('editor-styles');
  add_editor_style('assets/css/editor.css');

  add_theme_support( 'menus' );
    register_nav_menus( [
        'primary' => __( 'Hoofdmenu', 'tnd' ),
        'footer_1'  => __( 'Footer menu primary', 'tnd' ),
        'footer_2'  => __( 'Footer menu secondary', 'tnd' ),
    ] );
});



add_action( 'acf/init', function() {
    if ( ! function_exists( 'acf_register_block_type' ) ) {
        return;
    }

    acf_register_block_type( [
        'name'            => 'tnd-hero-heading',
        'title'           => __( 'TND Hero Heading', 'tnd' ),
        'description'     => __( 'Hero heading block voor The Next Digitals', 'tnd' ),
        'category'        => 'layout',
        'icon'            => 'heading',
        'keywords'        => [ 'hero', 'heading', 'tnd' ],
        'mode'            => 'preview',
        'supports'        => [
            'align' => ['wide', 'full'],
            'anchor'  => true,
        ],
        'render_template' => 'template-parts/blocks/tnd-hero-heading.php',
    ] );

     acf_register_block_type( [
        'name'            => 'tnd-split-content',
        'title'           => __( 'TND Split Content', 'tnd' ),
        'description'     => __( 'Split content block voor The Next Digitals', 'tnd' ),
        'category'        => 'layout',
        'icon'            => 'heading',
        'keywords'        => [ 'hero', 'heading', 'tnd', 'split', 'columns', 'col' ],
        'mode'            => 'preview',
        'supports'        => [
            'align' => ['wide', 'full'],
            'anchor'  => true,
        ],
        'render_template' => 'template-parts/blocks/tnd-split-content.php',
    ] );

    acf_register_block_type( [
        'name'            => 'tnd-client-logos',
        'title'           => __( 'TND Client Logos', 'tnd' ),
        'description'     => __( 'Logo-overzicht: “Wij werken voor …”', 'tnd' ),
        'render_template' => 'template-parts/blocks/tnd-client-logos.php',
        'category'        => 'formatting',
        'icon'            => 'groups',
        'keywords'        => [ 'logos', 'client', 'klanten', 'tnd' ],

        // ✨ hier de belangrijke stukken:
        'mode'            => 'preview',          // standaard in "Edit" tonen (ACF velden)
        'supports'        => [
            'align'  => [ 'wide', 'full' ],
            'anchor' => true,
            'mode'   => true,                // gebruiker kan wisselen tussen Edit/Preview
        ],
    ] );

    acf_register_block_type( [
        'name'            => 'tnd-expertise-grid',
        'title'           => __( 'TND Expertise Grid', 'tnd' ),
        'description'     => __( 'Overzicht van Expertises in twee kolommen.', 'tnd' ),
        'render_template' => 'template-parts/blocks/tnd-expertise-grid.php',
        'category'        => 'formatting',
        'icon'            => 'screenoptions',
        'keywords'        => [ 'expertise', 'tnd', 'grid' ],
        'mode'            => 'preview',
        'supports'        => [
            'align'  => [ 'wide', 'full' ],
            'anchor' => true,
            'mode'   => true,
        ],
    ] );

    acf_register_block_type( [
      'name'            => 'tnd-contact-block', // interne slug, mag je zo laten
      'title'           => __( 'TND Contactblok', 'tnd' ), // dit zie je in de editor
      'description'     => __( 'Contact CTA met afbeelding, tekst en button.', 'tnd' ),
      'render_template' => 'template-parts/blocks/tnd-contact-block.php',
      'category'        => 'formatting',
      'icon'            => 'email',
      'keywords'        => [ 'contact', 'cta', 'tnd' ],
      'mode'            => 'preview',
      'supports'        => [
          'align'  => [ 'wide', 'full' ],
          'anchor' => true,
          'mode'   => true,
      ],
  ] );

  acf_register_block_type( [
      'name'            => 'tnd-hero-overlay',
      'title'           => __( 'TND Hero Overlay', 'tnd' ),
      'description'     => __( 'Hero met grote afbeelding en overlappende kaart met tekst + CTA.', 'tnd' ),
      'render_template' => 'template-parts/blocks/tnd-hero-overlay.php',
      'category'        => 'formatting',
      'icon'            => 'align-wide',
      'keywords'        => [ 'hero', 'overlay', 'tnd' ],
      'mode'            => 'preview',
      'align'           => 'wide',
      'supports'        => [
          'align'  => [ 'wide', 'full' ],
          'anchor' => true,
          'mode'   => true,
      ],
  ] );

  acf_register_block_type( [
      'name'            => 'tnd-highlight-cards',
      'title'           => __( 'TND Highlight Cards', 'tnd' ),
      'description'     => __( 'Drie (of meer) gele kaarten met titel, tekst en link.', 'tnd' ),
      'render_template' => 'template-parts/blocks/tnd-highlight-cards.php',
      'category'        => 'formatting',
      'icon'            => 'columns',
      'keywords'        => [ 'cards', 'pages', 'highlight' ],
      'mode'            => 'preview',
      'supports'        => [
          'align'  => [ 'wide', 'full' ],
          'anchor' => true,
          'mode'   => true,
      ],
  ] );

//   acf_register_block_type( [
//       'name'            => 'tnd-media-highlight',
//       'title'           => __( 'TND Media Highlight', 'tnd' ),
//       'description'     => __( 'Visueel blok met Vimeo video of afbeelding.', 'tnd' ),
//       'render_template' => 'template-parts/blocks/tnd-media-highlight.php',
//       'category'        => 'formatting',
//       'icon'            => 'format-video',
//       'keywords'        => [ 'media', 'video', 'vimeo', 'image', 'highlight' ],
//       'mode'            => 'preview',
//       'supports'        => [
//           'align'  => [ 'wide', 'full' ],
//           'anchor' => true,
//           'mode'   => true,
//       ],
//   ] );

  acf_register_block_type( [
      'name'            => 'tnd-blog-cases-grid',
      'title'           => __( 'TND Blog & Cases Grid', 'tnd' ),
      'description'     => __( 'Overzicht van blogs en cases met categorie-filter.', 'tnd' ),
      'render_template' => 'template-parts/blocks/tnd-blog-cases-grid.php',
      'category'        => 'formatting',
      'icon'            => 'screenoptions',
      'keywords'        => [ 'blog', 'case', 'archive', 'grid' ],
      'mode'            => 'preview',
      'supports'        => [
          'align'  => [ 'wide', 'full' ],
          'anchor' => true,
          'mode'   => true,
      ],
  ] );

  acf_register_block_type([
      'name'              => 'tnd-map-block',
      'title'             => __('TND Map Block', 'tnd'),
      'description'       => __('Een blok met een Google Maps embed iframe.', 'tnd'),
      'category'          => 'formatting',
      'icon'              => 'location-alt',
      'keywords'          => ['map', 'google maps', 'kaart', 'location'],
      'supports'          => [
          'align' => ['wide', 'full'],
          'anchor'  => true,
          'mode'    => false,
          'jsx'     => false,
      ],
      'render_template'   => get_template_directory() . '/template-parts/blocks/tnd-map-block.php',
  ]);

  acf_register_block_type( [
      'name'            => 'tnd-related-cases',
      'title'           => __( 'TND Related Cases & Blogs', 'tnd' ),
      'description'     => __( 'Gerelateerde cases / artikelen met handmatige selectie of laatste cases of blogs.', 'tnd' ),
      'render_template' => 'template-parts/blocks/tnd-related-cases.php',
      'category'        => 'formatting',
      'icon'            => 'slides',
      'keywords'        => [ 'cases', 'related', 'meer artikelen', 'tnd' ],
      'mode'            => 'preview',
      'supports'        => [
          'align'  => [ 'wide', 'full' ],
          'anchor' => true,
          'mode'   => true,
      ],
  ] );

  acf_register_block_type( [
        'name'            => 'tnd-intro-block',
        'title'           => __( 'TND Intro', 'tnd' ),
        'description'     => __( 'Introblok met titel, tekst en CTA knop.', 'tnd' ),
        'render_template' => 'template-parts/blocks/tnd-intro-block.php',
        'category'        => 'formatting',
        'icon'            => 'editor-paragraph',
        'keywords'        => [ 'intro', 'tekst', 'tnd' ],
        'mode'            => 'edit',
        'supports'        => [
            'align'  => [ 'wide', 'full' ],
            'anchor' => true,
            'mode'   => true,
        ],
    ] );

    acf_register_block_type( [
        'name'            => 'tnd-slider-split',
        'title'           => __( 'TND Slider (Split / Full)', 'tnd' ),
        'description'     => __( 'Swiper slider, full width of split met content.', 'tnd' ),
        'render_template' => get_template_directory() . '/template-parts/blocks/tnd-slider-split.php',
        'category'        => 'media',
        'icon'            => 'images-alt2',
        'keywords'        => [ 'slider', 'carousel', 'split', 'swiper' ],
        'supports'        => [
            'align' => false,
            'jsx'   => true
        ],
    ] );


    acf_register_block_type([
        'name'            => 'tnd-benefit-grid',
        'title'           => __( 'TND Benefit Grid', 'tnd' ),
        'description'     => __( 'Grid met benefit/USP items.', 'tnd' ),
        'render_template' => get_template_directory() . '/template-parts/blocks/tnd-benefit-grid.php',
        'category'        => 'layout',
        'icon'            => 'screenoptions',
        'keywords'        => [ 'benefits', 'usp', 'grid', 'values' ],
        'supports'        => [
        'align' => false,
        'jsx'   => true,
        ],
    ]);

    acf_register_block_type([
        'name'            => 'tnd-vacancy-cards',
        'title'           => __( 'TND Vacancy Cards', 'tnd' ),
        'description'     => __( 'Toont vacatures als cards (auto uit CPT vacancy of handmatig selecteren).', 'tnd' ),
        'render_template' => get_template_directory() . '/template-parts/blocks/tnd-vacancy-cards.php',
        'category'        => 'widgets',
        'icon'            => 'id-alt',
        'keywords'        => [ 'vacancy', 'jobs', 'cards', 'grid' ],
        'supports'        => [
        'align' => false,
        'jsx'   => true,
        ],
    ]);
} );


// CPT: Expertise
add_action( 'init', function () {

    $labels = [
        'name'                  => _x( 'Expertises', 'Post type general name', 'tnd' ),
        'singular_name'         => _x( 'Expertise', 'Post type singular name', 'tnd' ),
        'menu_name'             => _x( 'Expertises', 'Admin Menu text', 'tnd' ),
        'name_admin_bar'        => _x( 'Expertise', 'Add New on Toolbar', 'tnd' ),
        'add_new'               => __( 'Nieuwe expertise', 'tnd' ),
        'add_new_item'          => __( 'Nieuwe expertise toevoegen', 'tnd' ),
        'new_item'              => __( 'Nieuwe expertise', 'tnd' ),
        'edit_item'             => __( 'Expertise bewerken', 'tnd' ),
        'view_item'             => __( 'Expertise bekijken', 'tnd' ),
        'all_items'             => __( 'Alle expertises', 'tnd' ),
        'search_items'          => __( 'Expertises zoeken', 'tnd' ),
        'not_found'             => __( 'Geen expertises gevonden.', 'tnd' ),
        'not_found_in_trash'    => __( 'Geen expertises in prullenbak.', 'tnd' ),
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'show_in_rest'       => true,              // Gutenberg
        'has_archive'        => true,
        'rewrite'            => [ 'slug' => 'expertise' ],
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-awards',
        'supports'           => [ 'title', 'editor', 'excerpt', 'thumbnail' ],
        'hierarchical'       => false,
    ];

    register_post_type( 'expertise', $args );


    // CPT Case
    register_post_type( 'case', [
        'labels' => [
            'name'          => __( 'Cases', 'tnd' ),
            'singular_name' => __( 'Case', 'tnd' ),
        ],
        'public'       => true,
        'has_archive'  => true,
        'menu_position'=> 21,
        'menu_icon'    => 'dashicons-portfolio',
        'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'show_in_rest' => true,
    ] );

    // Koppel standaard categorieën ook aan cases
    register_taxonomy_for_object_type( 'category', 'case' );


    // CPT: Team member
    $labels = [
        'name'                  => _x( 'Team members', 'Post type general name', 'tnd' ),
        'singular_name'         => _x( 'Team member', 'Post type singular name', 'tnd' ),
        'menu_name'             => _x( 'Team members', 'Admin Menu text', 'tnd' ),
        'name_admin_bar'        => _x( 'Team member', 'Add New on Toolbar', 'tnd' ),
        'add_new'               => __( 'Nieuwe team member', 'tnd' ),
        'add_new_item'          => __( 'Nieuwe team member toevoegen', 'tnd' ),
        'new_item'              => __( 'Nieuwe team member', 'tnd' ),
        'edit_item'             => __( 'Team member bewerken', 'tnd' ),
        'view_item'             => __( 'Team member bekijken', 'tnd' ),
        'all_items'             => __( 'Alle team members', 'tnd' ),
        'search_items'          => __( 'Team members zoeken', 'tnd' ),
        'not_found'             => __( 'Geen team members gevonden.', 'tnd' ),
        'not_found_in_trash'    => __( 'Geen team members in prullenbak.', 'tnd' ),
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'show_in_rest'       => true,
        'has_archive'        => false,
        'rewrite'            => [ 'slug' => 'team' ],
        'menu_icon'          => 'dashicons-groups',
        'menu_position'      => 22,
        'supports'           => [ 'title', 'editor', 'thumbnail' ],
    ];

    register_post_type( 'team', $args );


    /**
   * Custom Post Type: Vacancies
   */
    $labels = [
        'name'                  => __( 'Vacatures', 'tnd' ),
        'singular_name'         => __( 'Vacature', 'tnd' ),
        'menu_name'             => __( 'Vacatures', 'tnd' ),
        'name_admin_bar'        => __( 'Vacature', 'tnd' ),
        'add_new'               => __( 'Nieuwe vacature', 'tnd' ),
        'add_new_item'          => __( 'Nieuwe vacature toevoegen', 'tnd' ),
        'edit_item'             => __( 'Vacature bewerken', 'tnd' ),
        'new_item'              => __( 'Nieuwe vacature', 'tnd' ),
        'view_item'             => __( 'Bekijk vacature', 'tnd' ),
        'view_items'            => __( 'Bekijk vacatures', 'tnd' ),
        'search_items'          => __( 'Zoek vacatures', 'tnd' ),
        'not_found'             => __( 'Geen vacatures gevonden', 'tnd' ),
        'not_found_in_trash'    => __( 'Geen vacatures in de prullenbak', 'tnd' ),
        'all_items'             => __( 'Alle vacatures', 'tnd' ),
        'archives'              => __( 'Vacature archief', 'tnd' ),
        'attributes'            => __( 'Vacature eigenschappen', 'tnd' ),
        'insert_into_item'      => __( 'In vacature invoegen', 'tnd' ),
        'uploaded_to_this_item' => __( 'Geüpload naar deze vacature', 'tnd' ),
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,              // /vacancy/ of /vacatures/ als je rewrite aanpast
        'rewrite'            => [
            'slug'       => 'vacatures',          // frontend URL: /vacatures/…
            'with_front' => false,
        ],
        'menu_position'      => 22,
        'menu_icon'          => 'dashicons-id-alt',
        'supports'           => [
            'title',
            'editor',
            'excerpt',
            'thumbnail',
            'revisions',
        ],
        'show_in_rest'       => true,    
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'capability_type'    => 'post',
    ];

    register_post_type( 'vacancy', $args );
} );


// CPT evenementen
function tnd_register_cpt_evenementen() {

    $labels = [
        'name'               => 'Evenementen',
        'singular_name'      => 'Evenement',
        'menu_name'          => 'Evenementen',
        'add_new'            => 'Nieuw evenement',
        'add_new_item'       => 'Nieuw evenement toevoegen',
        'edit_item'          => 'Evenement bewerken',
        'new_item'           => 'Nieuw evenement',
        'view_item'          => 'Bekijk evenement',
        'search_items'       => 'Zoek evenementen',
        'not_found'          => 'Geen evenementen gevonden',
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'menu_icon'          => 'dashicons-calendar-alt',
        'has_archive'        => false,
        'rewrite'            => ['slug' => 'evenement'],
        'supports'           => ['title', 'editor', 'thumbnail'],
        'show_in_rest'       => true,
    ];

    register_post_type('evenement', $args);
}
add_action('init', 'tnd_register_cpt_evenementen');


/* add favicon */
add_action('wp_head', function() {
    ?>
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/favicon.ico" />
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/assets/apple-touch-icon.png" />
    <?php

});


/* remove all unwanted core block patternsand Openverse images */
add_action( 'init', function() {
    remove_theme_support( 'core-block-patterns' );
});

add_filter( 'block_editor_settings_all', function( $settings ) {
    if ( isset( $settings['mediaSources'] ) ) {
        $settings['mediaSources'] = array( 'library' );
    }
    return $settings;
});


/* allow iframes */
function tnd_allow_iframes_in_content( $tags, $context ) {
    if ( $context === 'post' ) {
        $tags['iframe'] = [
            'src'             => true,
            'width'           => true,
            'height'          => true,
            'frameborder'     => true,
            'allow'           => true,
            'allowfullscreen' => true,
            'referrerpolicy'  => true,
            'loading'         => true,
        ];
    }

    return $tags;
}
add_filter( 'wp_kses_allowed_html', 'tnd_allow_iframes_in_content', 10, 2 );


/**
 * ACF Theme Options
 */
add_action('acf/init', function () {

  if ( ! function_exists('acf_add_options_page') ) {
    return;
  }

  // Hoofd: Theme Options
  acf_add_options_page([
    'page_title'      => __('Theme Options', 'tnd'),
    'menu_title'      => __('Theme Options', 'tnd'),
    'menu_slug'       => 'tnd-theme-options',
    'capability'      => 'manage_options',
    'redirect'        => true,
    'position'        => 61,
    'icon_url'        => 'dashicons-admin-generic',
    'update_button'   => __('Opslaan', 'tnd'),
    'updated_message' => __('Opgeslagen.', 'tnd'),
  ]);

  // Subpage: 404 Page
  acf_add_options_sub_page([
    'page_title'  => __('404 Page', 'tnd'),
    'menu_title'  => __('404 Page', 'tnd'),
    'parent_slug' => 'tnd-theme-options',
    'menu_slug'   => 'tnd-theme-options-404',
  ]);

  // Subpage: Footer
  acf_add_options_sub_page([
    'page_title'  => __('Footer', 'tnd'),
    'menu_title'  => __('Footer', 'tnd'),
    'parent_slug' => 'tnd-theme-options',
    'menu_slug'   => 'tnd-theme-options-footer',
  ]);

});



add_filter('big_image_size_threshold', '__return_false');



// ADD all scripts
add_action('wp_head', function () { ?>
  <!-- Google Tag Manager -->
  <script>
    (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KRHRBBC');
  </script>
  <!-- End Google Tag Manager -->
<?php }, 0);

add_action('wp_body_open', function () { ?>
  <!-- Google Tag Manager (noscript) -->
  <noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KRHRBBC"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
  </noscript>
  <!-- End Google Tag Manager (noscript) -->
<?php }, 0);

add_action('wp_head', function () { ?>
  <!-- Matomo -->
  <script>
     var _paq = window._paq = window._paq || [];
    /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
    _paq.push(["setExcludedQueryParams", ["stg.thenextdigitals.nl"]]);
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
        var u="https://analytics.thenextdigitals.nl/";
        _paq.push(['setTrackerUrl', u+'matomo.php']);
        _paq.push(['setSiteId', '1']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
    })();
  </script>
  <!-- End Matomo -->
<?php }, 1);


/**
 * Gutenberg blocks blacklisten (makkelijk aan/uit te commenten)
 * - Werkt op basis van: "alles toegestaan" MINUS blacklist
 * - Tip: zet dit liever in een mu-plugin zodat theme updates het niet slopen.
 */

add_filter('allowed_block_types_all', function ($allowed_blocks, $editor_context) {

  // Optioneel: admins alles laten zien
  // if (current_user_can('manage_options')) {
  //   return $allowed_blocks;
  // }

  $registry = WP_Block_Type_Registry::get_instance();
  $all = array_keys($registry->get_all_registered());

  /**
   * BLACKLIST
   * Comment regels/secties aan of uit om blokken te verbergen.
   */
  $blacklist = [

    /**
     * ========== SITE / THEMA (vrijwel altijd weg voor klanten) ==========
     */
    'core/site-title',
    'core/site-tagline',
    'core/site-logo',
    'core/template-part',
    'core/pattern',
    'core/home-link',

    // Navigatie (meestal alleen voor theme builders)
    'core/navigation',
    'core/navigation-link',
    'core/navigation-submenu',
    'core/page-list',
    'core/page-list-item',

    /**
     * ========== QUERY / ARCHIVE BUILDING (bijna altijd weg) ==========
     */
    'core/query',
    'core/post-template',
    'core/query-no-results',
    'core/query-pagination',
    'core/query-pagination-next',
    'core/query-pagination-previous',
    'core/query-pagination-numbers',
    'core/query-title',
    'core/query-total',

    /**
     * ========== POST META / DYNAMISCHE “THEMA” BLOKKEN (weg) ==========
     */
    'core/post-title',
    'core/post-content',
    'core/post-excerpt',
    'core/post-featured-image',
    'core/post-date',
    'core/post-author',
    'core/post-author-biography',
    'core/post-author-name',
    'core/post-terms',
    'core/post-time-to-read',
    'core/post-navigation-link',
    'core/read-more',

    // Comments / reacties (meestal theme-only)
    'core/comments',
    'core/comments-title',
    'core/comments-pagination',
    'core/comments-pagination-next',
    'core/comments-pagination-previous',
    'core/comments-pagination-numbers',
    'core/comments-query-loop',
    'core/comment-template',

    // losse comment sub-blokken (ook weg)
    'core/comment-author-name',
    'core/comment-content',
    'core/comment-date',
    'core/comment-edit-link',
    'core/comment-reply-link',

    // jij hebt ook:
    'core/post-comments',
    'core/post-comments-count',
    'core/post-comments-form',
    'core/post-comments-link',

    /**
     * ========== WIDGETS (legacy, meestal weg) ==========
     */
    'core/legacy-widget',
    'core/widget-group',
    'core/archives',
    'core/calendar',
    'core/categories',
    'core/latest-comments',
    'core/latest-posts',
    'core/rss',
    'core/search',
    'core/tag-cloud',
    'core/loginout',

    /**
     * ========== “TECH / RISICO” BLOKKEN (vaak weg bij klanten) ==========
     */
    'core/shortcode',
    'core/html',
    'core/code',
    'core/freeform', // classic editor block
    'core/missing',

    /**
     * ========== EMBEDS (optioneel beperken) ==========
     * Zet dit AAN als je niet wil dat ze random embeds plakken.
     */
    // 'core/embed',

    /**
     * ========== LAYOUT BLOKKEN (optioneel) ==========
     * Als jij vooral met ACF/TND layouts werkt: aanzetten.
     * Als klanten soms zelf wat layout moeten kunnen: uit laten.
     */
    // 'core/group',
    // 'core/columns',
    // 'core/column',
    // 'core/cover',
    // 'core/media-text',
    // 'core/buttons',

    /**
     * ========== “NIEUW / UI” BLOKKEN (optioneel) ==========
     * Deze zie ik in jouw lijst:
     */
    // 'core/accordion',
    // 'core/accordion-item',
    // 'core/accordion-heading',
    // 'core/accordion-panel',

    /**
     * ========== TAXONOMY / TERMS (bijna altijd weg in content) ==========
     */
    'core/term-template',
    'core/term-name',
    'core/term-description',
    'core/term-count',
    'core/terms-query',

    /**
     * ========== SOCIAL (optioneel) ==========
     * Als je dit niet wil in content: aanzetten
     */
    // 'core/social-links',
    // 'core/social-link',
  ];

  // Alles minus blacklist = toegestaan
  return array_values(array_diff($all, $blacklist));

}, 100, 2);



/**
 * One-time migration: ACF Block "Split Content" hero_image
 * Converts numeric hero_image to FocusPoint format: {id,left,top}
 *
 * Run once as admin:
 * /wp-admin/?tnd_migrate_split_focuspoint=1
 */
// add_action('admin_init', function () {

//     if ( ! current_user_can('manage_options') ) {
//         return;
//     }

//     if ( empty($_GET['tnd_migrate_split_focuspoint']) ) {
//         return;
//     }

//     // Pas dit aan als jouw blockName anders is.
//     // Vaak: "acf/tnd-split-content" of "acf/tnd-split-content-block"
//     $target_block_name = 'acf/tnd-split-content';

//     $updated_posts = 0;
//     $updated_blocks_total = 0;

//     // Alleen posts pakken die blocks hebben
//     $q = new WP_Query([
//         'post_type'      => 'any',
//         'post_status'    => 'any',
//         'posts_per_page' => 200,
//         'paged'          => 1,
//         'fields'         => 'ids',
//     ]);

//     $process_blocks = function(array $blocks) use (&$process_blocks, $target_block_name, &$updated_blocks_total) {
//         foreach ($blocks as &$block) {

//             if ( ! is_array($block) ) continue;

//             // Recurse innerBlocks
//             if ( ! empty($block['innerBlocks']) && is_array($block['innerBlocks']) ) {
//                 $block['innerBlocks'] = $process_blocks($block['innerBlocks']);
//             }

//             if ( empty($block['blockName']) || $block['blockName'] !== $target_block_name ) {
//                 continue;
//             }

//             // ACF stores values under attrs['data']
//             $data = $block['attrs']['data'] ?? null;
//             if ( ! is_array($data) ) {
//                 continue;
//             }

//             // Jouw field name
//             if ( ! array_key_exists('hero_image', $data) ) {
//                 continue;
//             }

//             $val = $data['hero_image'];

//             // Als het al FocusPoint-format is (array met id), niets doen
//             if ( is_array($val) && isset($val['id']) ) {
//                 continue;
//             }

//             // Als het een (string) numeric attachment ID is: migreren
//             if ( is_numeric($val) && (int)$val > 0 ) {
//                 $data['hero_image'] = [
//                     'id'   => (int) $val,
//                     'left' => 50,
//                     'top'  => 50,
//                 ];

//                 $block['attrs']['data'] = $data;
//                 $updated_blocks_total++;
//             }
//         }

//         return $blocks;
//     };

//     // Batch loop
//     while ($q->have_posts()) {
//         $q->the_post();
//         $post_id = get_the_ID();

//         $content = get_post_field('post_content', $post_id);
//         if ( empty($content) || ! has_blocks($content) ) {
//             continue;
//         }

//         $blocks = parse_blocks($content);
//         $blocks_before = wp_json_encode($blocks);

//         $blocks = $process_blocks($blocks);

//         $blocks_after = wp_json_encode($blocks);

//         if ( $blocks_after !== $blocks_before ) {
//             $new_content = serialize_blocks($blocks);

//             wp_update_post([
//                 'ID'           => $post_id,
//                 'post_content' => $new_content,
//             ]);

//             $updated_posts++;
//         }
//     }

//     wp_reset_postdata();

//     wp_die(
//         'Klaar. Bijgewerkt: ' . (int)$updated_posts . ' posts, aangepaste blocks: ' . (int)$updated_blocks_total .
//         '. Verwijder nu de migratiecode uit functions.php.'
//     );
// });


function tnd_events_order_by_date($query) {

    if (!is_admin() && $query->is_main_query() && is_post_type_archive('evenement')) {

        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value');
        $query->set('order', 'ASC');
    }
}
add_action('pre_get_posts', 'tnd_events_order_by_date');