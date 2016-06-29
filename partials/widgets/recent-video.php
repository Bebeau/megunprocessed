<?php
	class RecentVideo extends WP_Widget {

		/**
		 * Sets up the widgets name etc
		 */
		public function __construct() {
			parent::__construct(
				'video_widget',
				__( 'Most Recent Video', 'sophie' ),
				array( 
					'description' => __( 'This displays the most recent video.', 'sophie' ), 
					'classname'   => 'video_widget'
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
				
				// List most recent Videos
				$Videos = get_cat_ID('Videos');
				$videos_link = get_category_link( $Videos );
				query_posts( array(
						'cat' => $Videos,
						'posts_per_page' => 1,
						'order' => 'DESC',
						'post_type' => array('post', 'recipes', 'reviews'),
						'post__not_in' => array($post->ID)
					)
			    );
				if (have_posts()) : while (have_posts()) : the_post(); 
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'large' );
					$videoID = get_post_meta( $post->ID, 'video_link', true );
				?>
				<div class="hidden-xs">
					<div class="videoWrap">
						<a href="<?php the_permalink(); ?>">
							<?php
								if ($image) {
									echo '<article class="recent-video" style="background: url('.$image[0].') no-repeat scroll center / cover; ">';
								} else {
									echo '<article class="recent-video" style="background: url(http://img.youtube.com/vi/'.$videoID.'/sddefault.jpg) no-repeat scroll center / cover; ">';
								} 
								echo '<div class="playwrap"><i class="fa fa-play"></i></div>';
								echo '</article>'; 
							?>
						</a>
					</div>
					<a href="<?php echo $videos_link; ?>" class="btn btn-custom btn-blue">Watch Videos</a>
				</div>
				<div class="visible-xs">
					<iframe width="100%" height="225" src="https://www.youtube.com/embed/<?php echo $videoID; ?>?&showinfo=0&controls=0" frameborder="0" allowfullscreen showinfo="false"></iframe>
					<a href="<?php echo $videos_link; ?>" class="btn btn-custom btn-blue">Watch Videos</a>
				</div>
				<?php endwhile; endif;
				wp_reset_query();

			echo $args['after_widget']; 
		}

		/**
		 * Outputs the options form on admin
		 *
		 * @param array $instance The widget options
		 */
		public function form( $instance ) { ?>
			<p>Dynamically displays most recent video.</p>
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
		register_widget( 'RecentVideo' );
	});
?>