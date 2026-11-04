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

    // 4. Main site script
    wp_enqueue_script(
        'bambu-script',
        get_template_directory_uri() . '/assets/js/script.js',
        [],
        '1.1',
        true // load in footer
    );

    // Booking form posts to admin-ajax, which hands it to the
    // Five Star Restaurant Reservations plugin (see bambu_handle_booking).
    wp_localize_script( 'bambu-script', 'bambuBooking', [
        'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
        'nonce'        => wp_create_nonce( 'bambu_booking' ),
        'pluginActive' => class_exists( 'rtbBooking' ),
    ] );

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


// ─── Booking form → Five Star Restaurant Reservations ──────────────────────
// The theme keeps its own booking modal, but each submission is stored as a
// plugin booking. The plugin then sends the "pending" email to the guest,
// the "new booking" email (with Confirm / Reject links) to the restaurant,
// and the "confirmed" / "rejected" email once staff act on it.
function bambu_handle_booking() {
    if ( ! check_ajax_referer( 'bambu_booking', 'nonce', false ) ) {
        wp_send_json_error( [ 'messages' => [ 'Your session expired. Please refresh the page and try again.' ] ], 403 );
    }

    // Honeypot: real visitors never fill this hidden field.
    if ( ! empty( $_POST['website'] ) ) {
        wp_send_json_success( [ 'status' => 'pending' ] );
    }

    if ( ! class_exists( 'rtbBooking' ) ) {
        wp_send_json_error( [ 'messages' => [ 'Online booking is unavailable right now. Please call us on +353 61 217 661.' ] ], 503 );
    }

    $field = function ( $key ) {
        return isset( $_POST[ $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) : '';
    };

    // The plugin reads its submission straight from $_POST.
    $_POST['action']      = 'booking_request';
    $_POST['rtb-date']    = $field( 'booking_date' );  // YYYY-MM-DD
    $_POST['rtb-time']    = $field( 'booking_time' );  // HH:MM
    $_POST['rtb-party']   = absint( $field( 'guests' ) );
    $_POST['rtb-name']    = $field( 'guest_name' );
    $_POST['rtb-email']   = isset( $_POST['guest_email'] ) ? sanitize_email( wp_unslash( $_POST['guest_email'] ) ) : '';
    $_POST['rtb-phone']   = $field( 'guest_phone' );
    $_POST['rtb-message'] = isset( $_POST['guest_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['guest_message'] ) ) : '';
    if ( ! empty( $_POST['consent'] ) ) {
        $_POST['rtb-consent-statement'] = '1';
    }

    $booking = new rtbBooking();
    $booking->insert_booking();

    if ( ! empty( $booking->request_inserted ) ) {
        wp_send_json_success( [ 'status' => $booking->post_status ] );
    }

    $messages = [];
    foreach ( (array) $booking->validation_errors as $error ) {
        if ( ! empty( $error['message'] ) ) {
            $messages[] = wp_strip_all_tags( $error['message'] );
        }
    }
    if ( ! $messages ) {
        $messages[] = 'We could not save your booking. Please call us on +353 61 217 661.';
    }
    wp_send_json_error( [ 'messages' => array_values( array_unique( $messages ) ) ], 422 );
}
add_action( 'wp_ajax_bambu_booking', 'bambu_handle_booking' );
add_action( 'wp_ajax_nopriv_bambu_booking', 'bambu_handle_booking' );
