<?php
	class Bestsellers extends WP_Widget {

		/**
		 * Sets up the widgets name etc
		 */
		public function __construct() {
			parent::__construct(
				'bestseller_widget',
				__( 'Sophies Bestsellers', 'sophie' ),
				array( 
					'description' => __( 'This displays the most recent product review.', 'sophie' ), 
					'classname'   => 'bestseller_widget'
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

				global $post;

				echo $args['before_widget']; 

			    echo '<a href="#">';

			    	if ( !empty( $instance['title'] ) ) {
						echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
					} else {
						echo $args['before_title'] .'See <span class="cursive pink">Sophie&#39;s</span> Bestseller'. $args['after_title'];
					}

				echo '</a>';

			echo $args['after_widget']; 
		}

		/**
		 * Outputs the options form on admin
		 *
		 * @param array $instance The widget options
		 */
		public function form( $instance ) {
			$title = !empty( $instance['title'] ) ? $instance['title'] : 'See <span class="cursive pink">Sophie&#39;s</span> Bestseller';
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
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
			return $instance;
		}
	}
	add_action( 'widgets_init', function(){
		register_widget( 'Bestsellers' );
	});
?>