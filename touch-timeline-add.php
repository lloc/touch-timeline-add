<?php

/*
Plugin Name: Touch Timeline Add
Plugin URI: https://github.com/lloc/touch-timeline-add
Version: 0.1
Author: <a href="http://lloc.de/">Dennis Ploetner</a>
Description: Addon for the Plugin <a href="http://www.nikolaydyankov.com/">Touch Timeline for WordPress</a> by Nikolay Dyankov
*/

define( 'TIMELINE_ADD_VERSION', 0.1 );

function timeline_add_create_post_type() {
    register_post_type(
        'eventi',
        array(
            'labels' => array(
                'name' => 'Eventi',
                'singular_name' => 'Evento',
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array( 'slug' => 'eventi' ),
        )
    );
}
add_action( 'init', 'timeline_add_create_post_type', 10, 0 );

function timeline_add_build_taxonomies() {  
    register_taxonomy(
        'Tipo',
        'tipo',
        array(
            'hierarchical' => true,
            'label' => 'Tipo',
            'query_var' => true,
            'rewrite' => true,
        )
    );
}
add_action( 'init', 'timeline_add_build_taxonomies', 10, 0 );

function timeline_add_refresh_plugin() {
    if ( TIMELINE_ADD_VERSION != get_option( 'TIMELINE_ADD_VERSION' ) ) {
        update_option( 'TIMELINE_ADD_VERSION', TIMELINE_ADD_VERSION );
        flush_rewrite_rules( false );
    }
}
add_action( 'init', 'timeline_add_refresh_plugin', 11, 0 );

if ( function_exists( 'timeline_shortcode' ) && !function_exists( 'timeline_add_shortcode' ) ) {
    function timeline_add_shortcode() {
        global $touch_timeline;
        $options = $touch_timeline->get_admin_options();
        $events  = $options['events'];

        $result = '<div class="timeline-wrap">';
        foreach ($events as $event) {
            $result .= '<div class="timeline-event">';
                $result .= '<div class="timeline-title">' . $event['title'] . '</div>';
                $result .= '<div class="timeline-content">' . $event['text'] . '</div>';
            $result .= '</div>';
        }
        $result .= '</div>';
        return $result;
    }
    add_shortcode( 'touch_timeline_add', 'timeline_add_shortcode');
}

?>