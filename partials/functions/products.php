<?php

global $post;

// Create custom post type for products
add_action( 'init', 'init_products' );
function init_products() {

    $product_type_labels = array(
        'name' => _x('Products', 'post type general name'),
        'singular_name' => _x('Product', 'post type singular name'),
        'add_new' => _x('Add New Product', 'video'),
        'add_new_item' => __('Add New Product'),
        'edit_item' => __('Edit Product'),
        'new_item' => __('Add New Product'),
        'all_items' => __('View Products'),
        'view_item' => __('View Product'),
        'search_items' => __('Search Products'),
        'not_found' =>  __('No Products found'),
        'not_found_in_trash' => __('No Products found in Trash'), 
        'parent_item_colon' => '',
        'menu_name' => 'Products'
    );
    $product_type_args = array(
        'labels' => $product_type_labels,
        'public' => true,
        'publicly_queryable' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'product' ),
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => false, 
        'hierarchical' => true,
        'map_meta_cap' => true,
        'menu_position' => null,
        'show_in_nav_menus' => true,
        'supports' => array('title', 'thumbnail')
    );
    register_post_type('Products', $product_type_args);
}

// add custom taxonomy for ingredients
function init_product_type() {
    $labels = array(
        'name' => _x( 'Product Type', 'taxonomy general name' ),
        'singular_name' => _x( 'Product Type', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Product Types' ),
        'all_items' => __( 'All Product Types' ),
        'parent_item' => __( 'Parent Product Type' ),
        'parent_item_colon' => __( 'Parent Product Type:' ),
        'edit_item' => __( 'Edit Product Type' ), 
        'update_item' => __( 'Update Product Type' ),
        'add_new_item' => __( 'Add New Product Type' ),
        'new_item_name' => __( 'New Product Type Name' ),
        'menu_name' => __( 'Product Types' ),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'type' ),
        'show_admin_column' => true,
        'show_ui' => true
    );
    register_taxonomy(
        'product_type',
        'products',
        $args
    );
}
add_action( 'init', 'init_product_type' );

// Add custom meta boxes to display recipe specs
add_action( 'add_meta_boxes', 'product_meta_box', 1 );
function product_meta_box( $post ) {
    add_meta_box(
        'link', 
        'Product Purchase Link', 
        'product_link',
        'products', 
        'normal', 
        'low'
    );
}
function product_link($post) {
	// Use nonce for verification
    wp_nonce_field( 'products_links', 'link_noncename' );
    //get the saved meta as an arry
    $link = get_post_meta($post->ID,'product_link', true);

    echo '<input type="text" name="product_link" id="product_link" placeholder="http://..." value="'.$link.'" />';
}

/* When the post is saved, saves our custom data */
add_action( 'save_post', 'save_product' );
function save_product( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return;

    // check for social link nonce
    if ( !isset( $_POST['link_noncename'] ) || !wp_verify_nonce( $_POST['link_noncename'], 'products_links' ) )
        return;
    
    $link  = $_POST['product_link'];

    if(isset($link)) {
        update_post_meta($post_id,'product_link',$link);
    } else {
        update_post_meta($post_id,'product_link',"");
    }
}

?>