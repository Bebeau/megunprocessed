<?php

global $post;

// Create custom post type for recipes
add_action( 'init', 'init_testimonials' );
function init_testimonials() {

    $artist_type_labels = array(
        'name' => _x('Testimonials', 'post type general name'),
        'singular_name' => _x('Testimonial', 'post type singular name'),
        'add_new' => _x('Add New Testimonial', 'video'),
        'add_new_item' => __('Add New Testimonial'),
        'edit_item' => __('Edit Testimonial'),
        'new_item' => __('Add New Testimonial'),
        'all_items' => __('View Testimonials'),
        'view_item' => __('View Testimonial'),
        'search_items' => __('Search Testimonials'),
        'not_found' =>  __('No Testimonials found'),
        'not_found_in_trash' => __('No Testimonials found in Trash'), 
        'parent_item_colon' => '',
        'menu_name' => 'Testimonials'
    );
    $artist_type_args = array(
        'labels' => $artist_type_labels,
        'public' => true,
        'publicly_queryable' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'testimonial' ),
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => false, 
        'hierarchical' => false,
        'map_meta_cap' => true,
        'menu_position' => null,
        'supports' => array('editor', 'thumbnail')
    );
    register_post_type('Testimonials', $artist_type_args);
}
// Add custom meta boxes to display recipe specs
add_action( 'add_meta_boxes', 'portfolio_meta_box', 1 );
function portfolio_meta_box( $post ) {
    add_meta_box(
        'client_info', 
        'Cite Info', 
        'client_info',
        'testimonials', 
        'side', 
        'low'
    );
}

function client_info($post) {
    // Use nonce for verification
    wp_nonce_field( 'testimonials', 'testimonials_noncename' );

    //get the saved meta as an arry
    $name = get_post_meta($post->ID,'testimonial_name', true);
    $title = get_post_meta($post->ID,'testimonial_title', true);
    $company = get_post_meta($post->ID,'testimonial_company', true);

    echo '<label for="testimonial_name">Name</label>';
    echo '<input type="text" name="testimonial_name" id="testimonial_name" value="'.$name.'"/>';
    
    echo '<label for="testimonial_title">Job Title</label>';
    echo '<input type="text" name="testimonial_title" id="testimonial_title" value="'.$title.'"/>';
    
    echo '<label for="testimonial_company">Company</label>';
    echo '<input type="text" name="testimonial_company" id="testimonial_company" value="'.$company.'"/>';
}

/* When the post is saved, saves our custom data */
add_action( 'save_post', 'dynamic_save_testimonial' );
function dynamic_save_testimonial( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return;

    // check for nonce
    if ( !isset( $_POST['testimonials_noncename'] ) || !wp_verify_nonce( $_POST['testimonials_noncename'], 'testimonials' ) )
        return;

    $name = $_POST['testimonial_name'];
    $title = $_POST['testimonial_title'];
    $company = $_POST['testimonial_company'];

    if($name) {
        update_post_meta($post_id,'testimonial_name',$name);
    }
    if($title) {
        update_post_meta($post_id,'testimonial_title',$title);
    }
    if($company) {
        update_post_meta($post_id,'testimonial_company',$company);
    }
}

add_filter( 'manage_edit-testimonials_columns', 'testimonial_columns' ) ;

function testimonial_columns( $columns ) {

    $columns = array(
        'cb' => '<input type="checkbox" />',
        'cite' => __( 'Cite' ),
        'testimonial' => __( 'Testimonial' ),
        'date' => __( 'Date' )
    );

    return $columns;
}

add_action( 'manage_testimonials_posts_custom_column', 'manage_testimonail_columns', 10, 2 );
function manage_testimonail_columns( $column, $post_id ) {
    global $post;
    switch( $column ) {
        case 'cite' :
            $name = get_post_meta( $post_id, 'testimonial_name', true );
            $title = get_post_meta( $post_id, 'testimonial_title', true );
            $company = get_post_meta( $post_id, 'testimonial_company', true );
            if ( empty( $name ) )
                echo __( 'Unknown' );
            else
                echo '<strong><a href="'.get_edit_post_link($post_id).'">'.$name.'</a></strong><br />'.$title.'<br />'.$company;
            break;
        case 'testimonial' :
            $quote = get_the_content();
            if ( empty( $quote ) )
                echo __( 'Unknown' );
            else
                echo __($quote);
            break;
    default :
        break;
    }
}

?>