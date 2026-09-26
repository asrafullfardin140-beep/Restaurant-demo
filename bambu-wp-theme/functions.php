<?php
/**
 * Bambu Restaurant — WordPress Theme Functions
 *
 * Sets up theme support features and enqueues all CSS/JS assets.
 */

// ─── Theme Setup ────────────────────────────────────────────────────────────
function bambu_theme_setup() {
    // Allow WordPress to manage the <title> tag
    add_theme_support( 'title-tag' );

    // Support for custom logo via Customizer
    add_theme_support( 'custom-logo' );

    // Register navigation menus (optional – for future CMS use)
    register_nav_menus( [
        'primary' => __( 'Primary Navigation', 'bambu-restaurant' ),
    ] );
}
add_action( 'after_setup_theme', 'bambu_theme_setup' );


// ─── Enqueue Scripts & Styles ────────────────────────────────────────────────
function bambu_enqueue_scripts() {

    // 1. Google Fonts — Playfair Display + Inter
    wp_enqueue_style(
        'bambu-google-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&family=Inter:wght@300;400;500;600&display=swap',
        [],
        null
    );

    // 2. Main site stylesheet (all theme CSS)
    wp_enqueue_style(
        'bambu-main-style',
        get_template_directory_uri() . '/assets/css/bambu.css',
        [ 'bambu-google-fonts' ],
        '1.0'
    );

    // Gallery page styles are kept separate so the homepage stays lean.
    if ( is_page_template( 'page-gallery.php' ) || is_page( 'gallery' ) ) {
        wp_enqueue_style(
            'bambu-gallery-style',
            get_template_directory_uri() . '/assets/css/gallery.css',
            [ 'bambu-main-style' ],
            '1.0'
        );
    }

    // 3. EmailJS — loaded in <head> so it's available when our script runs
    wp_enqueue_script(
        'emailjs',
        'https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js',
        [],
        null,
        false // load in head
    );

    // 4. Main site script
    wp_enqueue_script(
        'bambu-script',
        get_template_directory_uri() . '/assets/js/script.js',
        [ 'emailjs' ],
        '1.0',
        true // load in footer
    );

    if ( is_page_template( 'page-gallery.php' ) || is_page( 'gallery' ) ) {
        wp_enqueue_script(
            'bambu-gallery-script',
            get_template_directory_uri() . '/assets/js/gallery.js',
            [ 'bambu-script' ],
            '1.0',
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'bambu_enqueue_scripts' );


// ─── Remove WordPress Emoji Scripts (performance) ───────────────────────────
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );


// ─── Remove Unnecessary <link> Tags ─────────────────────────────────────────
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
