<?php
	class InstaPhoto extends WP_Widget {

		/**
		 * Sets up the widgets name etc
		 */
		public function __construct() {
			parent::__construct(
				'photo_widget',
				__( 'Photo Of The Day', 'sophie' ),
				array( 
					'description' => __( 'This widget displays the latest instagram photo of a user.', 'sophie' ), 
					'classname'   => 'photo_widget'
				)
			);
		}

		/**
		 * Outputs the content of the widget
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) { 

			echo $args['before_widget']; 

			echo '<div id="instafeed" class="results" data-id="'.$instance['instagram_id'].'"></div>';

			if ( !empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
			} else {
				echo $args['before_title'] .'<span class="cursive pink">Sophie&#39;s</span> Photo of the Day'. $args['after_title'];
			}

			if( get_option('instagram')) { 
				$instaURL = get_option('instagram');
				echo '<a href="'.$instaURL.'" class="btn btn-custom btn-blue" target="_blank"><i class="fa fa-instagram"></i> Follow</a>';
			}

			echo $args['after_widget']; ?>

			<script type="text/javascript">
				var instaID = jQuery('#instafeed').attr("data-id");
		        var userFeed = new Instafeed({
		            get: 'user',
		            userId: instaID,
		            accessToken: '1385988408.467ede5.af559d047b17438984c0feaa4f29bf65',
		            resolution: 'standard_resolution',
		            template: '<a class="photo" href="{{link}}" target="_blank"><div class="playwrap"><i class="fa fa-plus"></i></div><img src="{{image}}" /></a>',
		            sortBy: 'most-recent',
		            limit: 1
		        });
		        userFeed.run();
		    </script>
		<?php }

		/**
		 * Outputs the options form on admin
		 *
		 * @param array $instance The widget options
		 */
		public function form( $instance ) {
			$title = !empty( $instance['title'] ) ? $instance['title'] : '<span class="cursive pink">Sophie&#39;s</span> Photo of the Day';
			$instagram_id = !empty( $instance['instagram_id'] ) ? $instance['instagram_id'] : '183930317';
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'instagram_id' ); ?>"><?php _e( 'Instagram User ID:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'instagram_id' ); ?>" name="<?php echo $this->get_field_name( 'instagram_id' ); ?>" type="text" value="<?php echo esc_attr( $instagram_id ); ?>">
			</p>
		<?php }

		/**
		 * Processing widget options on save
		 *
		 * @param array $new_instance The new options
		 * @param array $old_instance The previous options
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['instagram_id'] = ( ! empty( $new_instance['instagram_id'] ) ) ? strip_tags( $new_instance['instagram_id'] ) : '';
			return $instance;
		}
	}
	add_action( 'widgets_init', function(){
		register_widget( 'InstaPhoto' );
	});
?>