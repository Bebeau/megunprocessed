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

				echo '<img class="up_logo" src="'.get_bloginfo('template_directory').'/assets/images/up_logo.jpg" alt="Unprocessed Productions" />';
				
				// List most recent Videos
				$videos = get_post_meta(2075,'videos',true);

                if(!empty($videos)) {
                	$count = count($videos) - 1;
					$pick = rand(0, $count);
                	$videoID = $videos[$pick]['id'];
                	$videoType = $videos[$pick]['type'];

                	if(wp_is_mobile()) {
                                            
                        if($videoType === "youtube") {
                            echo '<iframe src="https://www.youtube.com/embed/'.$videoID.'" class="m-item videoFrame" width="100%" frameborder="0" allowfullscreen></iframe>';
                        } elseif($videoType === 'vimeo') {
                            echo '<iframe src="https://player.vimeo.com/video/'.$videoID.'" class="m-item videoFrame" width="100%" frameborder="0" allowfullscreen></iframe>';
                        }

                    } else {

                        if($videoType === "youtube") {
                            echo '<a href="#videomodal" data-toggle="modal" class="singlevideo video" data-type="youtube" data-video="'.$videoID.'" style="background:url(https://i1.ytimg.com/vi/'.$videoID.'/hqdefault.jpg) no-repeat scroll center / cover;">';
                                echo '<div class="playwrap"><i class="fa fa-play"></i></div>';
                                echo '<div class="outer"><div class="inner"></div></div>';
                            echo '</a>';
                        } elseif($videoType === 'vimeo') {
                            $imgid = $videoID;
                            $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imgid.php"));
                            $thumb = $hash[0]['thumbnail_large'];
                            echo '<a href="#videomodal" data-toggle="modal" class="singlevideo video" data-type="vimeo" data-video="'.$videoID.'" style="background:url('.$thumb.') no-repeat scroll center / cover;" data-ibg-bg="'.$thumb.'">';
                                echo '<div class="playwrap"><i class="fa fa-play"></i></div>';
                                echo '<div class="outer"><div class="inner"></div></div>';
                            echo '</a>';
                        }

                    }
                }
				
				$page = get_page_by_title('Unprocessed Productions');
				$videos_link = get_permalink($page->ID);
				?>
				<div class="hidden-xs">
					<p>Interested in shooting your own video? We produce and shoot all of our own videos, and can help you shoot yours.</p>
					<a href="<?php echo $videos_link; ?>" class="btn">Work With Us</a>
				</div>

			<?php echo $args['after_widget']; 
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