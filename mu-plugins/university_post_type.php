<?php

function university_post_type()
{
    register_post_type('event', array(
        'show_in_rest' => true,
        'capability_type' => 'event',
        'map_meta_cap' => true,
        'supports' => array('title', 'editor', 'excerpt'),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Events',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'singular_name' => 'event'
        ),
        'menu_icon' => 'dashicons-star-filled'
    ));

    register_post_type('program', array(
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'programs'),
        'public' => true,
        'labels' => array(
            'name' => 'Program',
            'add_new_item' => 'Add New Program',
            'edit_item' => 'Edit Program',
            'all_items' => 'All Programs',
            'singular_name' => 'Program'
        ),
        'menu_icon' => 'dashicons-awards'
    ));

    register_post_type('professor', array(
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
        'public' => true,
        'labels' => array(
            'name' => 'professor',
            'add_new_item' => 'Add New professor',
            'edit_item' => 'Edit professor',
            'all_items' => 'All professors',
            'singular_name' => 'professor'
        ),
        'menu_icon' => 'dashicons-welcome-learn-more'
    ));

    register_post_type('campus', array(
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
        'public' => true,
        'labels' => array(
            'name' => 'campus',
            'add_new_item' => 'Add New campus',
            'edit_item' => 'Edit campus',
            'all_items' => 'All campuses',
            'singular_name' => 'campus'
        ),
        'menu_icon' => 'dashicons-location-alt'
    ));
}
add_action('init', 'university_post_type');
