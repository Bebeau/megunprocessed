<?php
	class NewsletterSignUp extends WP_Widget {

		/**
		 * Sets up the widgets name etc
		 */
		public function __construct() {
			parent::__construct(
				'cta_widget',
				__( 'Newsletter SignUp Widget', 'sophie' ),
				array( 
					'description' => __( 'This displays a Weekly Dose of Goodness sign up form.', 'sophie' ), 
					'classname'   => 'cta_widget'
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
				
				$widgetImage = get_option('sophie_verticalImage');

				if(!empty($widgetImage)) {
					echo '<div id="NewsletterWidgetWrap" style="background: url('.$widgetImage.') no-repeat scroll top center / cover #1e2015;">';
				} else {
					echo '<div id="NewsletterWidgetWrap">';
				}

				if ( !empty( $instance['title'] ) ) {
					echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
				} else {
					echo $args['before_title'] .'Sign Up for <span class="cursive">Sophie&#39;s</span><br /> Weekly Dose of Goodnes'. $args['after_title'];
				}

			?>
				<form role="form" method="POST" id="newsletter-frm-3" data-form="3" action="<?php echo bloginfo('template_directory');?>/partials/forms/newsletter.php" />
					<div class="row">
						<div class="form-group col-md-6">
							<label for="firstname_3" class="control-label">First Name <span class="required">*</span></label>
							<input type="text" name="firstname_3" class="form-control" id="firstname_3" placeholder="jane" />
						</div>
						<div class="form-group col-md-6">
							<label for="lastname_3" class="control-label">Last Name <span class="required">*</span></label>
							<input type="text" name="lastname_3" class="form-control" id="lastname_3" placeholder="doe" />
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							<label for="emailaddress_3" class="control-label">Email <span class="required">*</span></label>
							<input type="text" name="emailaddress_3" class="form-control" id="emailaddress_3" placeholder="email@address.." />
						</div>
					</div>
					<div class="clearfix">
						<button type="submit" class="btn btn-pink btn-submit">subscribe</button>
					</div>
				</form>
			<?php 
			echo '</div>';
			echo $args['after_widget']; 
		}

		/**
		 * Outputs the options form on admin
		 *
		 * @param array $instance The widget options
		 */
		public function form( $instance ) {
			$title = !empty( $instance['title'] ) ? $instance['title'] : 'Sign Up for <span class="cursive">Sophie&#39;s</span><br /> Weekly Dose of Goodnes';
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
		register_widget( 'NewsletterSignUp' );
	});
?>