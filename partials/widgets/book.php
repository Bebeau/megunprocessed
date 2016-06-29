<?php
	class SophieBook extends WP_Widget {

		/**
		 * Sets up the widgets name etc
		 */
		public function __construct() {
			parent::__construct(
				'book_widget',
				__( 'Sophies Book Widget', 'sophie' ),
				array( 
					'description' => __( 'This displays a linked ad image meant to market Sophies books.', 'sophie' ), 
					'classname'   => 'book_widget'
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

				// $numb = rand(0,3);

				// $stack = array(
				// 	"http://www.amazon.com/Gorgeously-Green-Simple-Earth-Friendly-Paperback/dp/B00HUC325G/&tag=sophulia00-20", 
				// 	"http://www.amazon.com/Gorgeously-Green-Diet-Sophie-Uliano/dp/0452295912/&tag=sophulia00-20",
				// 	"http://www.amazon.com/Do-Gorgeously-Expensive-Beautiful-Products/dp/140134139X/&tag=sophulia00-20",
				// 	"http://www.amazon.com/Gorgeous-Good-Simple-Program-Lasting/dp/1401946194/&tag=sophulia00-20",
				// );

				// $bookstack = array(
				// 	"http://ecx.images-amazon.com/images/I/51-xQV%2BNGPL.jpg", 
				// 	"http://ecx.images-amazon.com/images/I/51UueUy01cL.jpg",
				// 	"http://ecx.images-amazon.com/images/I/518RrvOISFL.jpg",
				// 	"http://ecx.images-amazon.com/images/I/51TIODJjl7L.jpg",
				// );

				// $book = $bookstack[$numb];
				// $link = $stack[$numb];

				$book = 'http://ecx.images-amazon.com/images/I/51TIODJjl7L.jpg';
				$link = 'http://www.amazon.com/Gorgeous-Good-Simple-Program-Lasting/dp/1401946194/&tag=sophulia00-20';

			?>
				<div class="books">
					<div class="component">
						<ul class="align">
							<li>
								<figure class='book'>

									<!-- Front -->
									<ul class='hardcover_front'>
										<li>
											<img src="<?php echo $book; ?>" alt="<?php echo $instance['title']; ?>" height="100%">
										</li>
										<li></li>
									</ul>

									<!-- Pages -->
									<ul class='page'>
										<li></li>
										<li>
											<a class="btn" href="<?php echo $link; ?>" target="_BLANK">Buy Now</a>
										</li>
										<li></li>
										<li></li>
										<li></li>
									</ul>

									<!-- Back -->
									<ul class='hardcover_back'>
										<li></li>
										<li></li>
									</ul>
									<ul class='book_spine'>
										<li></li>
										<li></li>
									</ul>
									<!-- <figcaption>
										<h3>Gorgeously Green</h3>
									</figcaption> -->
								</figure>
							</li>
						</ul>
					</div>
					<a href="<?php echo $link; ?>" target="_BLANK">
						<?php
							if ( !empty( $instance['title'] ) ) {
								echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
							} else {
								echo $args['before_title'] .'Buy <span class="cursive pink">Sophie&#39;s</span> Book Today!'. $args['after_title'];
							}
						?>
					</a>
				</div>
			<?php 
			echo $args['after_widget']; 
		}

		/**
		 * Outputs the options form on admin
		 *
		 * @param array $instance The widget options
		 */
		public function form( $instance ) {
			$title = !empty( $instance['title'] ) ? $instance['title'] : 'Buy <span class="cursive pink">Sophie&#39;s</span> Book Today!';
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
			$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			return $instance;
		}
	}
	add_action( 'widgets_init', function(){
		register_widget( 'SophieBook' );
	});
?>