<?php

/**
 * Register new custom taxonomies
 * @package Onesie Pro
 * @since Onesie Pro 1.0
 */

/*-----------------------------------------------------------------------------------*/
/* Register taxonomy for new post type */
/*-----------------------------------------------------------------------------------*/

function onesie_pro_ps_portfolio_taxonomy() {
    // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name' => _x( 'Categories', 'taxonomy general name', 'onesie_pro' ),
    'singular_name' => _x( 'Category', 'taxonomy singular name', 'onesie_pro' ),
    'search_items' =>  __( 'Search Categories', 'onesie_pro' ),
    'all_items' => __( 'All Categories', 'onesie_pro' ),
    'parent_item' => __( 'Parent Category', 'onesie_pro' ),
    'parent_item_colon' => __( 'Parent Category:', 'onesie_pro' ),
    'edit_item' => __( 'Edit Category', 'onesie_pro' ),
    'update_item' => __( 'Update Category', 'onesie_pro' ),
    'add_new_item' => __( 'Add New Category', 'onesie_pro' ),
    'new_item_name' => __( 'New Category Name', 'onesie_pro' ),
    'menu_name' => __( 'Categories', 'onesie_pro' )
  );
    register_taxonomy('pcategory','portfolio',array(
                'hierarchical' => true,
                'labels' => $labels,
                'query_var' => true,
                'rewrite' => array( 'slug' => 'pcategory' )
    ));
}
add_action( 'init', 'onesie_pro_ps_portfolio_taxonomy', 0 );

function onesie_pro_ps_portfolio_tags() {
    register_taxonomy( 'ptag', 'portfolio', array(
                'hierarchical' => false,
                'update_count_callback' => '_update_post_term_count',
                'label' => __('Tags', 'onesie_pro'),
                'query_var' => true,
                'rewrite' => array( 'slug' => 'ptags' )
    )) ;
}
add_action( 'init', 'onesie_pro_ps_portfolio_tags', 1 );