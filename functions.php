<?php
// Child theme scripts/styles laden
function twentytwentyfour_child_enqueue_styles() {
    // Parent theme CSS
    wp_enqueue_style(
        'twentytwentyfour-style',
        get_template_directory_uri() . '/style.css'
    );

    // Child theme CSS
    wp_enqueue_style(
        'twentytwentyfour-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('twentytwentyfour-style'),
        wp_get_theme()->get('Version')
    );

    wp_enqueue_script(
        'custom',
        get_stylesheet_directory_uri() . '/custom.js',
        [],
        '1.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'twentytwentyfour_child_enqueue_styles');