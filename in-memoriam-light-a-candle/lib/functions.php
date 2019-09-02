<?php
/*
Helper functions for In Memoriam (Light a Candle)
*/

function the_prayer () {

	global $post;
	
	return get_post_meta( $post->ID, 'candle_prayer_name', true );

}

function get_the_prayer ( $candle_id ) {

	return get_post_meta( $candle_id, 'candle_prayer_name', true );

}

function the_location () {

	global $post;
	
	return get_post_meta( $post->ID, 'candle_prayer_location', true );

}

function get_the_location ( $candle_id ) {

	return get_post_meta( $candle_id, 'candle_prayer_location', true );

}

function ct_candle_on_all_status_transitions( $new_status, $old_status, $post ) {
  if ( $post->post_type == 'candle' ) {
    if ( $new_status != $old_status ) {
      if ( $new_status == 'publish' ) {
        $ct_recipient = get_post_meta( $post->ID, 'candle_title_email', true);
        if ( ! empty($ct_recipient) ) {
          ct_send_recipient_notice( $post, $ct_recipient );
        }
        $ct_prayer_email = get_post_meta( $post->ID, 'candle_prayer_email', true);
        if ( ! empty($ct_prayer_email) ) {
          ct_send_prayer_notice( $post, $ct_prayer_email );
        }
      }
    }
  }
}

if( 1 == get_option('imlac_candle_publish_notification') ) {
  // only instantiate this hook if imlac_candle_publish_notification is enabled
  add_action( 'transition_post_status', 'ct_candle_on_all_status_transitions', 10, 3 );
}

function ct_send_recipient_notice( $candle, $recipient_email ) {

    // Send email notification to recipient
    // This will only be called if imlac_candle_publish_notification is enabled
    // Since this happens AFTER the administrator validates the candle there 
    // is no chance of generating spam email.

    $admin_email = apply_filters( 'new_candle_notification_email', get_option( 'admin_email' ) );

    // Start output buffering and grab contents of email
    ob_start();

    include( trailingslashit( dirname( __FILE__) ) . 'templates/email-recipient-candle.php' );

    $html = ob_get_contents();
    ob_end_clean();

    // Prepare headers and send email

    $headers = array(
      'From: ' . sprintf( '%s <%s>', get_option( 'blogname' ), $admin_email ),
      'Content-type: text/html',
      'Reply-to: ' . $admin_email
    );

    wp_mail( $recipient_email, 'Candle Posted | ' . get_option( 'blogname' ), $html, $headers );
}

function ct_send_prayer_notice( $candle, $prayer_email ) {

    // Send email notification to prayer (originator)
    // This will only be called if imlac_candle_publish_notification is enabled
    // Since this happens AFTER the administrator validates the candle there 
    // is no chance of generating spam email.

    $admin_email = apply_filters( 'new_candle_notification_email', get_option( 'admin_email' ) );

    // Start output buffering and grab contents of email
    ob_start();

    include( trailingslashit( dirname( __FILE__) ) . 'templates/email-prayer-candle.php' );

    $html = ob_get_contents();
    ob_end_clean();

    // Prepare headers and send email

    $headers = array(
      'From: ' . sprintf( '%s <%s>', get_option( 'blogname' ), $admin_email ),
      'Content-type: text/html',
      'Reply-to: ' . $admin_email
    );

    wp_mail( $prayer_email, 'Candle Posted | ' . get_option( 'blogname' ), $html, $headers );

}

require_once ( trailingslashit( dirname( __FILE__) ) . 'options.php' );


?>
