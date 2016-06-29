<?php
	class RecentGiveaway extends WP_Widget {

		/**
		 * Sets up the widgets name etc
		 */
		public function __construct() {
			parent::__construct(
				'giveaway_widget',
				__( 'Most Recent Giveaway', 'sophie' ),
				array( 
					'description' => __( 'This displays the most recent giveaway.', 'sophie' ), 
					'classname'   => 'giveaway_widget'
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

			// List most recent Giveaway
			query_posts( array(
					'posts_per_page' => 1,
					'order' => 'DESC',
					'post_type' => array('giveaways'),
					'post_status' => array('publish')
				)
		    );

			if (have_posts()) {

				echo $args['before_widget']; 
				
				while (have_posts()) : the_post();
				$image = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
				?>
					<h3><span class="cursive pink">Sophie's</span> Giveaways</h3>
					<div class="giveaways-listing">
						<div class="m-item">
							<a class="link" href="<?php the_permalink(); ?>" target="_blank">
								<?php if ($image) {
									echo '<article class="single-giveaway" style="background: url('.$image.') no-repeat scroll center / cover; ">';
								} else {
									echo '<article class="single-giveaway default-image">';
								} ?>
								<?php 
								echo '<div class="playwrap"><i class="fa fa-plus"></i></div>';
								echo '</article>'; ?>
							</a>
						</div>
					</div>
					<a href="<?php echo site_url('/giveaways'); ?>" class="btn btn-custom btn-blue" target="_blank">View All</a>
				<?php endwhile; ?>
				<?php wp_reset_query();

				echo $args['after_widget']; 
			}
		}

		/**
		 * Outputs the options form on admin
		 *
		 * @param array $instance The widget options
		 */
		public function form( $instance ) { ?>
			<p>Dynamically displays most recent giveaway.</p>
		<?php }

		/**
		 * Processing widget options on save
		 *
		 * @param array $new_instance The new options
		 * @param array $old_instance The previous options
		 */
		public function update( $new_instance, $old_instance ) {

		}
	}
	add_action( 'widgets_init', function(){
		register_widget( 'RecentGiveaway' );
	});
?>