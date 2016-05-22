<?php

/**
 * Register new custom post types
 * @package Onesie Pro
 * @since Onesie Pro 1.0
 */

/*-----------------------------------------------------------------------------------*/
/* Register new post type */
/*-----------------------------------------------------------------------------------*/

function onesie_pro_ps_portfolio_create_type() {


    register_post_type('portfolio',
        array(
            'labels' => array(
                'name'                      => __('Portfolios','onesie_pro'),
                'singular_name'             => __('Portfolio','onesie_pro'),
                'add_new'                   => __('Add New', 'onesie_pro'),
                'add_new_item'              => __('Add Portfolio', 'onesie_pro'),
                'new_item'                  => __('Add Portfolio', 'onesie_pro'),
                'view_item'                 => __('View Portfolio', 'onesie_pro'),
                'search_items'              => __('Search Portfolios', 'onesie_pro'),
                'edit_item'                 => __('Edit Portfolio', 'onesie_pro'),
                'all_items'                 => __('All Portfolios', 'onesie_pro'),
                'not_found'                 => __('No Portfolio found', 'onesie_pro'),
                'not_found_in_trash'        => __('No Portfolio found in Trash', 'onesie_pro')
            ),
            'taxonomies'    => array('pcategory', 'ptag'),
            'public' => true,
            'show_ui' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => array( 'slug' => 'portfolio', 'with_front' => false ),
            'query_var' => true,
            'supports' => array('title','revisions','thumbnail','author','editor'),
            'menu_position' => 5,
            'menu_icon' => get_template_directory_uri() .'/images/portfolio.png',
            'has_archive' => true
        )
    );
}
add_action( 'init', 'onesie_pro_ps_portfolio_create_type' );