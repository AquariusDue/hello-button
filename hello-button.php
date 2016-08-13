<?php

/**
 * Plugin Name: Hello Button
 * Plugin URI: http://aquariusdue.com
 * Description: Send a notification when someone says hi through Pushbullet
 * Version: 1.0.0
 * Author: Mihai Dumitru
 * Author URI: http://aquariusdue.com
 * License: MIT
 */

add_action('wp_enqueue_scripts', 'hello_button_enqueue_scripts');

function hello_button_enqueue_scripts() {
  if ( is_home() ) {
    wp_enqueue_script( 'hello-button', plugins_url( 'hello-button.js', __FILE__ ), array('jquery'), null, true);

    wp_localize_script( 'hello-button', 'hello_button_object', array(
       'ajax_url' => admin_url( 'admin-ajax.php' )
     ));
  }
}

add_action('wp_ajax_say_hello', 'wp_ajax_say_hello_callback');
add_action('wp_ajax_nopriv_say_hello', 'wp_ajax_say_hello_callback');

function wp_ajax_say_hello_callback() {
  $ch = curl_init( "https://api.pushbullet.com/v2/pushes" );
  $payload = json_encode( array( 'type' => 'note', 'title' => 'aquariusdue.com', 'body' => 'Someone says hello!' ) );

  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Access-Token: o.kzQcOHAY5uRWm7egHlXcw8aS8DjIB8ZY'));
  curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

  curl_exec($ch);
  curl_close($ch);

  die();
}
