<?php

// Add a Settings module for the Administrator to control email notifications

// cmb: References:
// http://wordpress.stackexchange.com/questions/21256/how-to-pass-arguments-from-add-settings-field-to-the-callback-function
// http://wordpress.stackexchange.com/questions/26607/add-section-add-settings-section-to-a-custom-page-add-submenu-page

function imlac_plugin_admin_init() {

    register_setting( 'imlac_option_group', 'imlac_candle_publish_notification');

    add_settings_section( 'imlac_section_id', 'In Memoriam (Light A Candle) Options', 'imlac_section_callback', 'imlac_section_page_type' );

    // cmb: not actually sure of difference between "name" and "id"
    $args = array(
      'id'   => 'imlac_candle_publish_notification',
      'name' => 'imlac_candle_publish_notification',
      'type' => 'checkbox',
    );

    // add_settings_field($id, $title, $callback, $page, $section, $args);
    add_settings_field(
      $args['id'],
      'Send notification email when new candle is published',
      'print_input_field_cb',
      'imlac_section_page_type',
      'imlac_section_id',
      $args
    );

    do_action('candle_option_fields');

    // cmb: more fields can be added by duplicating
    // cmb: the $args arrray, and add_settings_field
    // cmb: 'type' only supports "text" or "checkbox"
}

add_action( 'admin_init', 'imlac_plugin_admin_init' );

function add_menus() {
  add_options_page(
    'Settings Admin',
    'In Memoriam',
    'manage_options',
    'imlac_options_slug',
    'submenu_callback');
}

add_action( 'admin_menu', 'add_menus' );

function submenu_callback() {
     ?>
     <div class='wrap'>
          <h2>Settings</h2>
          <form method='post' action='options.php'>
          <?php 
               /* 'option_group' must match 'option_group' from register_setting call */
               settings_fields( 'imlac_option_group' );
               do_settings_sections( 'imlac_section_page_type' );
               submit_button();
          ?>
          </form>
     </div>
     <?php
}

function imlac_section_callback(){
  // cmb: don't need any actions to separate this section
}

function print_input_field_cb( array $args ) {
  $type    = $args['type'];
  $id      = $args['id'];
  $name    = $args['name'];
  $value   = get_option( $name );

  if( 'checkbox' == $type) {
    print "<input name='$name' type='$type' id='$id' value='1' " . checked(1, get_option($name),false) . " />";
  } else {
    print "<input name='$name' type='$type' id='$id' value='" . get_option($name) . "' />";
  }
}

?>
