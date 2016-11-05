<?php

// add custom menu item for theme options
add_action("admin_menu", "setup_theme_admin_menus");
function setup_theme_admin_menus() {
	$page_title = 'Theme Settings';
    $menu_title = 'Customize';
    $capability = 'manage_options';
    $menu_slug = 'setup_options';
    $function = 'theme_settings_page';
    $icon_url = '';
    $position = 30;
    add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);
}

function theme_settings_page() {
	// if (!empty($_POST['aweber_AppID']) || !empty($_POST['aweber_Key']) || !empty($_POST['switch_on']) || !empty($_POST['popup_title']) ) {
	// 	update_option('aweber_AppID', $_POST['aweber_AppID']);
	// 	update_option('aweber_Key', $_POST['aweber_Key']);
	// 	update_option('switch_on', $_POST['switch_on']);
	// 	update_option('popup_title', $_POST['popup_title']);
	// }

	// $appID = esc_attr(get_option('aweber_AppID'));
	// $aweberKey = esc_attr(get_option('aweber_Key'));

	$homeBanner = esc_attr(get_option('meg_homeImage'));
	// $Horizontal = esc_attr(get_option('meg_horizontalImage'));
	// $Vertical = esc_attr(get_option('meg_verticalImage'));

	// $switch = esc_attr(get_option('switch_on'));
	// $popupImage = esc_attr(get_option('meg_popup'));

	// $popupTitle = esc_attr(get_option('popup_title'));

?>

	<div class="wrap">

		<h2><?php _e('Theme Options', 'Sophie'); ?></h2>

		<form method="post" id="options_frm">

			<?php if(isset( $_GET['settings-updated'])) { ?>
				<div class="updated">
			        <p><?php _e('Settings updated successfully', $textdomain); ?></p>
			    </div>
			<?php } ?>

			<h3>Banner Image</h3>
			<p>Set the background images of the call to action sections on the site.</p>

			<table class="form-table">
				<tr valign="top">
					<th> Homepage Main Image <br /> (2400px by 800px) </th>
					<td>
						<div class="image-placeholder homeImage">
							<img src="<?php echo $homeBanner; ?>" alt="" />
						</div>
						<button class="add button button-primary button-large upload-image" style="text-align:center;" data-input="meg_homeImage" data-img="homeImage">
				            Upload/Set Image
				        </button>
				        <?php if ( get_option('meg_homeImage') ) { ?>
				        	<button class="remove button button-large">Remove</button>
				    	<?php } ?>
				        <input type="hidden" name="meg_homeImage" id="meg_homeImage" value="<?php echo $homeBanner; ?>" />
					</td>
				</tr>
		    </table>
		    
		    <?php // submit_button(); ?>

		</form>

	</div>

<?php }

// ajax call to set download track on select
add_action( 'admin_footer', 'uploadImage_js' );
function uploadImage_js() { 
    global $post;
    ?>
     <script type="text/javascript">
     	var meta_image_frame;
     	 // Runs when the image button is clicked.
	    jQuery('.upload-image').click(function(e){

	    	var image = jQuery(this).attr("data-img");
	    	var val = jQuery(this).attr("data-input");
	    	var input = jQuery('#'+val);
	    	var img = jQuery('.'+image);

	        // Prevents the default action from occuring.
	        e.preventDefault();

	        // Sets up the media library frame
	        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
	            title: meta_image.title,
	            button: { text:  meta_image.button },
	            library: { type: 'image' },
	            multiple: false
	        });

	        // Runs when an image is selected.
	        meta_image_frame.on('select', function(){
	            // Grabs the attachment selection and creates a JSON representation of the model.
	            var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
	            // Sends the attachment URL to our custom image input field.
	            img.find("img").remove();
	            img.append('<img src="'+media_attachment.url+'" alt="" />' );
	            input.val(media_attachment.url);
	            saveImage(val, media_attachment.url);
	            input.before('<button class="remove button button-large">Remove</button>');
	        });

	        // Opens the media library frame.
	        meta_image_frame.open();
	    });
        saveImage = function(input, url) {
            jQuery.ajax({
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                type: "GET",
                data: {
                	field: input,
                	image: url,
                    action: 'setImage'
                },
                dataType: 'html',
                error : function(jqXHR, textStatus, errorThrown) {
                    window.alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            }); 
        };
        jQuery('.remove').click(function(e){
			e.preventDefault();
			var val = jQuery(this).prev().attr("data-input");
			jQuery(this).prev().prev().find("img").remove();
			jQuery(this).next().val("");
			jQuery(this).hide();
			saveImage(val, "");
		});
		jQuery('#popup_switch').click(function(e){
			if( jQuery(this).attr("checked") ) {
				jQuery('#switch_on').val("0");
			} else {
				jQuery(this).attr("checked");
				jQuery('#switch_on').val("1");
			}
		});
    </script> <?php
}
// ajax response to save download track
add_action('wp_ajax_setImage', 'setUniqueImage');
add_action('wp_ajax_nopriv_setImage', 'setUniqueImage');
function setUniqueImage() {
	$field = (isset($_GET['field'])) ? $_GET['field'] : 0;
	$url = (isset($_GET['image'])) ? $_GET['image'] : 0;
	if (!empty($field) || !empty($url)) {
		update_option($field, $url);
	}
}


