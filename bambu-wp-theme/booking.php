<?php
defined( 'ABSPATH' ) || exit;

// Obtain a fresh token even when the page itself was cached.
add_action( 'wp_ajax_bambu_booking_token', 'bambu_booking_token' );
add_action( 'wp_ajax_nopriv_bambu_booking_token', 'bambu_booking_token' );
function bambu_booking_token() {
    nocache_headers();
    wp_send_json_success( array( 'nonce' => wp_create_nonce( 'bambu_booking' ) ) );
}
add_action( 'wp_ajax_bambu_booking', 'bambu_submit_booking' );
add_action( 'wp_ajax_nopriv_bambu_booking', 'bambu_submit_booking' );
function bambu_submit_booking() {
    if ( 'POST' !== $_SERVER['REQUEST_METHOD'] ) {
        wp_send_json_error( array( 'message' => 'Please submit the booking form.' ), 405 );
    }
    if ( ! check_ajax_referer( 'bambu_booking', 'nonce', false ) ) {
        wp_send_json_error( array( 'message' => 'Your session expired. Please try again.' ), 403 );
    }
    $fields = array( 'guest_name', 'guest_email', 'guest_phone', 'booking_date', 'booking_time', 'guests', 'guest_message', 'website' );
    $data = array();
    foreach ( $fields as $field ) {
        if ( isset( $_POST[$field] ) && ! is_string( $_POST[$field] ) ) {
            wp_send_json_error( array( 'message' => 'Invalid booking details.' ), 400 );
        }
        $data[$field] = isset( $_POST[$field] ) ? trim( wp_unslash( $_POST[$field] ) ) : '';
    }
    if ( '' !== $data['website'] ) {
        wp_send_json_error( array( 'message' => 'Unable to submit this request. Please call us.' ), 400 );
    }
    $name = sanitize_text_field( $data['guest_name'] );
    $email = sanitize_email( $data['guest_email'] );
    $phone = sanitize_text_field( $data['guest_phone'] );
    $notes = sanitize_textarea_field( $data['guest_message'] );
    if ( '' === $name || strlen($name) > 120 || ! is_email($email) || preg_match('/[\r\n]/', $data['guest_email']) || strlen($email) > 254 ||
        ! preg_match('/^[0-9+().\s-]{6,40}$/', $phone) || strlen($notes) > 3000 ) {
        wp_send_json_error( array( 'message' => 'Please enter a valid name, email and phone number. Keep notes under 3,000 characters.' ), 400 );
    }
    $zone = new DateTimeZone( 'Europe/Dublin' );
    $date = DateTimeImmutable::createFromFormat( '!Y-m-d H:i', $data['booking_date'].' '.$data['booking_time'], $zone );
    $now = new DateTimeImmutable( 'now', $zone );
    $guests = $data['guests'];
    if ( ! $date || $date->format('Y-m-d H:i') !== $data['booking_date'].' '.$data['booking_time'] || $date <= $now ||
        $date > $now->modify('+1 year') || ! in_array($guests, array_merge(array_map('strval',range(1,20)),array('20+')), true) ) {
        wp_send_json_error( array( 'message' => 'Choose a future booking within the next year and a valid number of guests.' ), 400 );
    }
    $sunday = '0' === $date->format('w');
    $slots = array();
    for ( $hour = $sunday ? 14 : 17; $hour <= 21; $hour++ ) {
        $slots[] = sprintf('%02d:00',$hour);
        $slots[] = sprintf('%02d:30',$hour);
    }
    $slots[] = '22:00';
    if (!$sunday) { $slots[] = '22:45'; }
    if (!in_array($data['booking_time'],$slots,true)) {
        wp_send_json_error(array('message'=>'Please select a time during our opening hours.'),400);
    }
    // Use the direct connection address, not a spoofable forwarded header.
    $key = 'bambu_booking_'.hash_hmac('sha256', isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown', wp_salt('auth'));
    $attempts = (int) get_transient($key);
    if ($attempts >= 5) {
        wp_send_json_error(array('message'=>'Too many requests. Please wait 15 minutes or call +353 61 217 661.'),429);
    }
    set_transient($key,$attempts+1,15*MINUTE_IN_SECONDS);
    // Preferred path: save the request in the Five Star Restaurant Reservations
    // plugin (free). The plugin then emails the guest "waiting to be confirmed",
    // emails the restaurant with Confirm / Reject links, and emails the guest
    // again once staff confirm or reject it.
    if ( class_exists( 'rtbBooking' ) ) {
        if ( '20+' === $guests ) {
            $notes = trim( 'Large group: more than 20 guests. ' . $notes );
        }
        $_POST['action']      = 'booking_request';
        $_POST['rtb-date']    = $date->format( 'Y-m-d' );
        $_POST['rtb-time']    = $date->format( 'H:i' );
        $_POST['rtb-party']   = '20+' === $guests ? 20 : (int) $guests;
        $_POST['rtb-name']    = $name;
        $_POST['rtb-email']   = $email;
        $_POST['rtb-phone']   = $phone;
        $_POST['rtb-message'] = $notes;

        $booking = new rtbBooking();
        $booking->insert_booking();

        if ( ! empty( $booking->request_inserted ) ) {
            wp_send_json_success( array( 'message' => 'Booking request sent — awaiting confirmation. Check your email: Bambu will confirm your table shortly.' ) );
        }

        $messages = array();
        foreach ( (array) $booking->validation_errors as $error ) {
            if ( ! empty( $error['message'] ) ) {
                $messages[] = wp_strip_all_tags( $error['message'] );
            }
        }
        wp_send_json_error( array( 'message' => $messages ? implode( ' ', array_unique( $messages ) ) : 'We could not save your request. Please retry or call +353 61 217 661.' ), 400 );
    }

    // Fallback if the plugin is ever deactivated: plain email to the restaurant.
    $body = "New booking request — confirmation required\n\nName: ".$name."\nEmail: ".$email."\nPhone: ".$phone.
        "\nDate: ".$date->format('d F Y')."\nTime (Ireland): ".$date->format('H:i')."\nGuests: ".$guests."\n\nNotes:\n".($notes ?: 'None').
        "\n\nPlease contact the guest to confirm availability. This is a request, not a confirmed reservation.";
    $sent = wp_mail('info@bambu.ie','Bambu booking request: '.$date->format('d M Y H:i'),$body,array('Content-Type: text/plain; charset=UTF-8','Reply-To: '.$email));
    if (!$sent) {
        wp_send_json_error(array('message'=>'We could not send your request. Your details are still here. Please retry or call +353 61 217 661.'),500);
    }
    wp_send_json_success(array('message'=>'Booking request sent—awaiting confirmation. Bambu will contact you to confirm availability.'));
}
