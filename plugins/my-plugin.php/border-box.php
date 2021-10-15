<?php
/*
    Plugin Name: Border Box
    Author: Anish Shrestha
    Version: 1.0
*/

function loadBlockFiles()
{
    wp_enqueue_script(
        'my-super-unique-handle',
        plugin_dir_url(__FILE__) . 'my-block.js',
        array('wp-blocks', 'wp-i18n', 'wp-editor'),
        true
    );

   
}

add_action('enqueue_block_editor_assets', 'loadBlockFiles');


/* To Save Post Meta from your block uncomment
  the code below and adjust the post type and
  meta name values accordingly. If you want to
  allow multiple values (array) per meta remove
  the 'single' property.
*/

/*
function myBlockMeta() {
  register_meta('post', 'color', array('show_in_rest' => true, 'type' => 'string', 'single' => true));
}

add_action('init', 'myBlockMeta');
*/