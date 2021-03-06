<?php

// Hide admin bar
add_filter('show_admin_bar', '__return_false');

// Load all styles and scripts for the site
add_action( 'wp_enqueue_scripts', 'load_custom_scripts' );
if (!function_exists( 'load_custom_scripts' ) ) {
	function load_custom_scripts() {
		// Styles
		wp_enqueue_style( 'Bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css', false, '', 'all' );
		wp_enqueue_style( 'Style CSS', get_bloginfo( 'template_url' ) . '/style.css', false, '', 'all' );
		// Load default Wordpress jQuery
		wp_deregister_script('jquery');
		wp_register_script('jquery', ("https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"), false, '', false);
		wp_enqueue_script('jquery');
		// Load custom scripts
        wp_enqueue_script( 'FontAwesome', 'https://use.fontawesome.com/0af0859db9.js', false, '', 'all' );
		wp_enqueue_script('bootstrap_js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js', array('jquery'), null, true);
		wp_enqueue_script('custom', get_bloginfo( 'template_url' ) . '/assets/js/custom.js', array('jquery'), null, false);

        wp_localize_script( 'custom', 'ajaxbloglisting', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'page' => 2,
            'loading' => false
        ));
    }
}

// Add admin styles for login page customization
add_action( 'admin_enqueue_scripts', 'load_admin_styles' );
function load_admin_styles() {
	wp_enqueue_style( 'admin-styles', get_bloginfo( 'template_url' ) . '/assets/css/admin.css', false, '1.0.0' );
    wp_enqueue_media();
    // Registers and enqueues the required javascript.
    wp_register_script( 'admin-js', get_template_directory_uri() . '/assets/js/admin.js', array( 'jquery' ) );
    wp_localize_script( 'admin-js', 'meta_image',
        array(
            'title' => 'Choose or Upload Image',
            'button' => 'Select Image',
            'ajaxurl' => admin_url( 'admin-ajax.php' )
        )
    );
    wp_enqueue_script( 'admin-js' );
}

// Thumbnail Support
add_theme_support( 'post-thumbnails', array('post', 'page', 'reviews', 'recipes', 'giveaways', 'testimonials', 'products') );

// Load widget areas
function megan_sidebar_init() {
    register_sidebar(array(
        'name' => 'Main Sidebar',
        'id' => 'main_sidebar',
        'description' => __( 'Widgets in this area will be shown on all single posts and pages.', 'sophie' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
}
add_action( 'widgets_init', 'megan_sidebar_init' );

// Register Navigation Menu Areas
add_action( 'after_setup_theme', 'register_my_menu' );
function register_my_menu() {
  register_nav_menu( 'primary', 'Primary Menu' );
  register_nav_menu( 'footer', 'Footer Menu' );
}

// Create social bookmark input fields in general settings
add_action('admin_init', 'my_general_section');  
function my_general_section() {  
    add_settings_section(  
        'my_settings_section', // Section ID 
        'Social Media', // Section Title
        'my_section_options_callback', // Callback
        'general' // What Page?  This makes the section show up on the General Settings Page
    );
    add_settings_field( // Option 1
        'facebook', // Option ID
        'Facebook URL', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed
        'my_settings_section', // Name of our section (General Settings)
        array( // The $args
            'facebook' // Should match Option ID
        )  
    );
    add_settings_field( // Option 2
        'twitter', // Option ID
        'Twitter URL', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed
        'my_settings_section', // Name of our section (General Settings)
        array( // The $args
            'twitter' // Should match Option ID
        )  
    );
    add_settings_field( // Option 2
        'instagram', // Option ID
        'Instagram URL', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed
        'my_settings_section', // Name of our section (General Settings)
        array( // The $args
            'instagram' // Should match Option ID
        )  
    );
    add_settings_field( // Option 2
        'pinterest', // Option ID
        'Pinterest URL', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed
        'my_settings_section', // Name of our section (General Settings)
        array( // The $args
            'pinterest' // Should match Option ID
        )  
    );
    add_settings_field( // Option 2
        'googleplus', // Option ID
        'GooglePlus URL', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed
        'my_settings_section', // Name of our section (General Settings)
        array( // The $args
            'googleplus' // Should match Option ID
        )  
    );
    add_settings_field( // Option 2
        'youtube', // Option ID
        'Youtube URL', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed
        'my_settings_section', // Name of our section (General Settings)
        array( // The $args
            'youtube' // Should match Option ID
        )  
    );
    register_setting('general','facebook', 'esc_attr');
    register_setting('general','twitter', 'esc_attr');
    register_setting('general','instagram', 'esc_attr');
    register_setting('general','pinterest', 'esc_attr');
    register_setting('general','googleplus', 'esc_attr');
    register_setting('general','youtube', 'esc_attr');
}
function my_section_options_callback() { // Section Callback
    echo '<p>Enter your social media links to have them automatically display in the website footer.</p>';  
}
function my_textbox_callback($args) {  // Textbox Callback
    $option = get_option($args[0]);
    echo '<input type="text" class="regular-text" id="'. $args[0] .'" name="'. $args[0] .'" value="' . $option . '" />';
}

// Add custom meta boxes to display youtube video
add_action( 'add_meta_boxes', 'youtube_video_meta_box', 1 );
function youtube_video_meta_box( $post ) {
    add_meta_box(
        'video', 
        'YouTube Video Link', 
        'youtube_video_link', 
        array('post','page','recipes','reviews','giveaways'),
        'side', 
        'high'
    );
}
// create custom youtube video link input
function youtube_video_link() { 
    global $post;
    wp_nonce_field( basename( __FILE__ ), 'youtube_video_link' );
    $prfx_stored_meta = get_post_meta( $post->ID );
    ?>
    <div>
        <?php 
            if ( !empty( $prfx_stored_meta['video_link'][0] ) ) {
                echo '<iframe width="100%" height="140" src="https://www.youtube.com/embed/'.$prfx_stored_meta['video_link'][0].'" frameborder="0" allowfullscreen showinfo="0"></iframe>'; 
                echo '<button class="remove-btn button" style="display:block;width:100%;" data-post="'.$post->ID.'">Remove Video</button>';
            }
        ?>
        <input type="<?php if ( !empty( $prfx_stored_meta['video_link'][0] ) ) { echo 'hidden'; } else { echo 'text'; } ?>" name="video_link" id="video_link" value="<?php if ( !empty( $prfx_stored_meta['video_link'][0] ) ) { echo $prfx_stored_meta['video_link'][0]; } else { echo ''; } ?>" style="width:100%;margin: 5px 0 10px;" placeholder="http://..." />
    </div>
<?php 
}
// save video link
add_action( 'save_post', 'youtube_video_link_save' );
function youtube_video_link_save( $post_id ) {
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'video_link' ] ) && wp_verify_nonce( $_POST[ 'youtube_video_link' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'video_link' ] )) {
        if(filter_var($_POST[ 'video_link' ], FILTER_VALIDATE_URL) ) {
            parse_str( parse_url( $_POST[ 'video_link' ], PHP_URL_QUERY ), $my_array_of_vars );
            $videoID = $my_array_of_vars['v'];
        } else {
            $videoID = $_POST[ 'video_link' ];
        }
        update_post_meta( $post_id, 'video_link', $videoID );
    }
}
// add javascript to remove youtube link
add_action( 'admin_footer', 'removeYoutTubeURL_javascript' );
function removeYoutTubeURL_javascript() { 
    global $post;
    ?>
     <script type="text/javascript">
        removeURL = function(postID) {
            jQuery.ajax({
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                type: "GET",
                data: {
                    action: 'VideoRemove',
                    postID: postID
                },
                dataType: 'html',
                success: function(response){
                    jQuery('#video iframe').remove();
                    jQuery('.remove-btn').remove();
                    jQuery('#video_link').attr("type", "text");
                },
                error : function(jqXHR, textStatus, errorThrown) {
                    window.alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            }); 
        };
        jQuery(".remove-btn").click(function(e){
            e.preventDefault();
            jQuery('#video_link').val("");
            var postID = jQuery(this).attr("data-post");
            removeURL(postID);
        });
    </script> <?php
}
// ajax response to display random winner
add_action('wp_ajax_VideoRemove', 'VideoRemove');
add_action('wp_ajax_nopriv_VideoRemove', 'VideoRemove');
function VideoRemove() {
    $postID = (isset($_GET['postID'])) ? $_GET['postID'] : 0;
    update_post_meta( $postID, 'video_link', '' );
}

// Breadcrumbs
function init_breadcrumbs() {
       
    // Settings
    $separator          = '&gt;';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = 'Home';
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'ingredients';
       
    // Get the query & post information
    global $post,$wp_query;
       
    // Do not display on the homepage
    if ( !is_front_page() ) {
       
        // Build the breadcrums
        echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';
           
        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';
           
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
              
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title("", false) . '</strong></li>';
              
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type !== 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';
              
        } else if ( is_single() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            // Get post category info
            $category = get_the_category();
             
            if(!empty($category)) {
              
                // Get last category post is in
                $last_catVals = array_values($category);
                $last_category = end($last_catVals);
                  
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                  
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                    $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }
             
            }
              
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists && $post_type != 'splash') {
                   
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
               
            }
              
            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                  
                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
              
            } else {
                  
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            }
              
        } else if ( is_category() ) {
               
            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';
               
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
                   
                // Parent page loop
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }
                   
                // Display parent pages
                echo $parents;
                   
                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';
                   
            } else {
                   
                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';
                   
            }
               
        } else if ( is_tag() ) {
               
            // Tag page
               
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
               
            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';
           
        } elseif ( is_day() ) {
               
            // Day archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';
               
            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_month() ) {
               
            // Month Archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_year() ) {
               
            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';
               
        } else if ( is_author() ) {
               
            // Auhor archive
               
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
               
            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';
           
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';
               
        } else if ( is_search() ) {
           
            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';
           
        } elseif ( is_404() ) {
               
            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }
       
        echo '</ul>';
           
    }
       
}

function init_pagination() {

    if( is_singular() )
        return;

    global $wp_query;

    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );

    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<div id="pagination"><ul>' . "\n";

    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li class="pull-left btn-custom btn-blue">%s</li>' . "\n", get_previous_posts_link() );

    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

        if ( ! in_array( 2, $links ) )
            echo '<li>…</li>';
    }

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }

    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li>…</li>' . "\n";

        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }

    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li class="pull-right btn-custom btn-blue">%s</li>' . "\n", get_next_posts_link() );

    echo '</ul></div>' . "\n";

}

// ajax response to return posts
add_action('wp_ajax_ajaxBlog', 'addPosts');
add_action('wp_ajax_nopriv_ajaxBlog', 'addPosts');
function addPosts() {
    global $post;

    $page = (isset($_POST['pageNumber'])) ? $_POST['pageNumber'] : 0;
    $catID = (isset($_POST['cat'])) ? $_POST['cat'] : 0;

    $args = array(
        'cat'   => $catID,
        'posts_per_page' => 12,
        'paged'          => $page,
        'post_type' => array("post", "recipes", "reviews")
    );

    $results = new WP_Query($args);

    $count = 0;
    $all = wp_count_posts();
    $total = $all->publish;

    if ($results->have_posts()) :

    echo '<section class="row listing">';
    
    while ($results->have_posts()) : $results->the_post();
        
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'large' ); 
        $videoID = get_post_meta( $post->ID, 'video_link', true ); ?>

        <div class="col-sm-3 entry">
            <a href="<?php the_permalink(); ?>">
            <?php if ($image) { ?>
                <article class="post-image" style="background: url('<?php echo $image[0]; ?>') no-repeat scroll center / cover;">
            <?php } else { ?>
                <article class="post-image default-image" >
            <?php } ?>
                </article>
                <h3><?php the_title(); ?></h3>
            </a>
        </div>
    
    <?php

    $count++;

    if($count % 4 === 0) {
        echo '</section><section class="row listing">';
    } elseif($count === $total) {
        echo '</section>';
    }

    endwhile; endif;

    wp_reset_query();

    exit;

}

add_action( 'init', 'allow_origin' );
function allow_origin() {
    header("Access-Control-Allow-Origin: *");
}

add_action('wp_ajax_sendContact', 'emailSubmit');
add_action('wp_ajax_nopriv_sendContact', 'emailSubmit');
function emailSubmit() {
    global $post;
    if( empty($_POST['password']) ) {

        $success = false;

        $firstname = isset( $_POST['firstname'] ) ? $_POST['firstname'] : "";
        $lastname = isset( $_POST['lastname'] ) ? $_POST['lastname'] : "";
        $emailaddress = filter_var($_POST['emailaddress'], FILTER_SANITIZE_EMAIL);
        $message = isset( $_POST['message'] ) ? $_POST['message'] : "";

        $email = esc_attr(get_option('admin_email'));
        $to = $firstname.' '.$lastname.' <'.$emailaddress.'>';

        if ( $firstname && $lastname && $emailaddress && $message ) {

            $subject = "Megunprocessed Website Lead";

            $headers = 'From:' . $email . "\r\n";
            $headers .= 'Reply-To:' . $to . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html\r\n";
            $headers .= "charset: ISO-8859-1\r\n";
            $headers .= "X-Mailer: PHP/".phpversion()."\r\n";

            $formcontent = '<html><body><center>';
                $formcontent .= '<table rules="all" style="border: 1px solid #cccccc; width: 600px;" cellpadding="10">';
                $formcontent .= "<tr><td><strong>Name:</strong></td><td>" . $firstname .' '. $lastname . "</td></tr>";
                $formcontent .= "<tr><td><strong>Email:</strong></td><td>" . $emailaddress . "</td></tr>";
                $formcontent .= "<tr><td><strong>Message:</strong></td><td>" . $message . "</td></tr>";
            $formcontent .= '</table></center></body></html>';

            $success = mail( $email, $subject, $formcontent, $headers );

            $key = esc_attr(get_option('mailchimp_api'));
            $list = esc_attr(get_option('mailchimp_list'));

            if(!empty($key) && !empty($list)) {

                $auth = base64_encode( 'user:'.$key );

                $data = array(
                    'apikey'        => $key,
                    'email_address' => $emailaddress,
                    'status'        => 'subscribed',
                    'merge_fields'  => array(
                        'FNAME'     => $firstname,
                        'LNAME'     => $lastname,
                        'COMPANY'   => $company,
                        'TITLE'     => $title,
                        'INTEREST'  => $interest
                    )
                );

                $json_data = json_encode($data);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://us11.api.mailchimp.com/3.0/lists/'.$list.'/members/');
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                                                            'Authorization: Basic '.$auth));
                curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);                                                                                                                  

                $result = curl_exec($ch);
            }
        }

        // Return an appropriate response to the browser
        if ( defined( 'DOING_AJAX' ) ) {
            echo $success ? "Success" : "E";
        }
    }
    die();

}
add_action('wp_ajax_sendNewsletter', 'newsletterSubmit');
add_action('wp_ajax_nopriv_sendNewsletter', 'newsletterSubmit');
function newsletterSubmit() {
    global $post;
    if( empty($_POST['password']) ) {

        $success = false;

        $firstname = isset( $_POST['firstname'] ) ? $_POST['firstname'] : "";
        $lastname = isset( $_POST['lastname'] ) ? $_POST['lastname'] : "";
        $emailaddress = filter_var($_POST['emailaddress'], FILTER_SANITIZE_EMAIL);

        if ( $firstname && $lastname && $emailaddress ) {

            $key = esc_attr(get_option('mailchimp_api'));
            $list = esc_attr(get_option('mailchimp_list'));

            if(!empty($key) && !empty($list)) {

                $auth = base64_encode( 'user:'.$key );

                $data = array(
                    'apikey'        => $key,
                    'email_address' => $emailaddress,
                    'status'        => 'subscribed',
                    'merge_fields'  => array(
                        'FNAME'     => $firstname,
                        'LNAME'     => $lastname
                    )
                );

                $json_data = json_encode($data);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://us11.api.mailchimp.com/3.0/lists/'.$list.'/members/');
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                                                            'Authorization: Basic '.$auth));
                curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);                                                                                                                  

                $result = curl_exec($ch);
            }
        }

        // Return an appropriate response to the browser
        if ( defined( 'DOING_AJAX' ) ) {
            echo $success ? "Success" : "E";
        }
    }
    die();

}

include(TEMPLATEPATH.'/partials/widgets/newsletter.php');
include(TEMPLATEPATH.'/partials/widgets/instaphoto.php');
include(TEMPLATEPATH.'/partials/widgets/recent-video.php');
include(TEMPLATEPATH.'/partials/widgets/testimonials.php');
include(TEMPLATEPATH.'/partials/functions/theme-options.php');
include(TEMPLATEPATH.'/partials/functions/videos.php');
include(TEMPLATEPATH.'/partials/functions/products.php');
