<?php

function u_post_types()
{
    // Location Post Type
    register_post_type('location', array(
        'capability_type' => 'location',
        'map_meta_cap' => true,
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt'),
        'rewrite' => array('slug' => 'locations'),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Locations',
            'add_new_item' => 'Add New Location',
            'edit_item' => 'Edit Location',
            'all_items' => 'All Locations',
            'singular_name' => 'Location'
        ),
        'menu_icon' => 'dashicons-location-alt'
    ));

    

    // medical specialties Post Type
    register_post_type('specialty', array(
        'show_in_rest' => true,
        'supports' => array('title'),
        'rewrite' => array('slug' => 'specialties'),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Specialties',
            'add_new_item' => 'Add New Specialty',
            'edit_item' => 'Edit Specialty',
            'all_items' => 'All Specialties',
            'singular_name' => 'Specialty'
        ),
        'menu_icon' => 'dashicons-awards'
    ));

    // Doctor Post Type
    register_post_type('doctor', array(
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'public' => true,
        'labels' => array(
            'name' => 'Doctors',
            'add_new_item' => 'Add New Doctor',
            'edit_item' => 'Edit Doctor',
            'all_items' => 'All Doctors',
            'singular_name' => 'Doctor'
        ),
        'menu_icon' => 'dashicons-welcome-learn-more'
    ));

    // // Note Post Type
    // register_post_type('note', array(
    //     'capability_type' => 'note',
    //     'map_meta_cap' => true,
    //     'show_in_rest' => true,
    //     'supports' => array('title', 'editor'),
    //     'public' => false,
    //     'show_ui' => true,
    //     'labels' => array(
    //         'name' => 'Notes',
    //         'add_new_item' => 'Add New Note',
    //         'edit_item' => 'Edit Note',
    //         'all_items' => 'All Notes',
    //         'singular_name' => 'Note'
    //     ),
    //     'menu_icon' => 'dashicons-welcome-write-blog'
    // ));

    // Like Post Type
    register_post_type('like', array(
        'supports' => array('title'),
        'public' => false,
        'show_ui' => true,
        'labels' => array(
            'name' => 'Likes',
            'add_new_item' => 'Add New Like',
            'edit_item' => 'Edit Like',
            'all_items' => 'All Likes',
            'singular_name' => 'Like'
        ),
        'menu_icon' => 'dashicons-heart'
    ));

    // Event Post Type
    register_post_type('event', array(
        'capability_type' => 'event',
        'map_meta_cap' => true,
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt'),
        'rewrite' => array('slug' => 'events'),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Events',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'singular_name' => 'Event'
        ),
        'menu_icon' => 'dashicons-calendar'
    ));
}

add_action('init', 'u_post_types');
