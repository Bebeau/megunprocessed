<?php get_header(); ?>

	<div class="container" id="singleRecipe">

		<div class="row">

			<div class="col-md-8">

				<?php if (have_posts()) : while (have_posts()) : the_post();
					$prepHour = get_post_meta( get_the_ID(), 'recipePrep_hours', true );
			        $prepMinute = get_post_meta( get_the_ID(), 'recipePrep_minutes', true );
			        $cookHour = get_post_meta( get_the_ID(), 'recipeTime_hours', true );
			        $cookMinute = get_post_meta( get_the_ID(), 'recipeTime_minutes', true );
			        $servingSize = get_post_meta( get_the_ID(), 'recipeServing', true );
        
					echo '<div class="single-top clearfix">';
						the_post_thumbnail();
						echo '<div>';
							echo '<div class="col-xs-4 stat"><span>Prep <i class="fa fa-clock-o"></i></span>'.$prepHour.':'.$prepMinute.'</div>';
			                echo '<div class="col-xs-4 stat"><span>Cook <i class="fa fa-clock-o"></i></span>'.$cookHour.':'.$cookMinute.'</div>';
			                echo '<div class="col-xs-4 stat"><span>Servings</span>'.$servingSize.'</div>';
			            echo '</div>';
					echo '</div>';
					echo '<div class="single-content">';
						the_title('<h1>','</h1>');
						the_content();
						listIngredients($post->ID);
						listInstructions($post->ID); ?>
						<?php 
							if(has_post_thumbnail()) {
								$postImage = wp_get_attachment_image_url(get_post_thumbnail_id($post->ID), 'large', false ); 
							} else { 
								$postImage = get_bloginfo('template_directory').'/assets/images/default_facebook.jpg'; 
							};
						?>
				    	<div class="social-share">
							<div class="share-text">Share with your friends &amp; followers!</div>
							<!-- Facebook (url) -->
							<a target="_blank" href="http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" class="facebook">
							    <i class="fa fa-facebook"></i>
							</a>
							<!-- Twitter (url, text, @mention) -->
							<a class="twitter" target="_blank" href="http://twitter.com/share?url=<?php the_permalink(); ?>&text=Thanks to this, I'm one step closer to a Gorgeously Green Life - &via=sophieuliano">
							    <i class="fa fa-twitter"></i>
							</a>
							<!-- Google Plus (url) -->
							<a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo $postImage; ?>&description=<?php echo strip_tags(get_the_excerpt()); ?>" class="pinterest" count-layout="horizontal">
							    <i class="fa fa-pinterest"></i>
							</a>
						</div>
				    	<?php echo '<div class="fb-comments" data-href="'.get_the_permalink().'" data-width="100%" data-num-posts="6"></div>';
				    echo '</div>';
				endwhile; else: ?>
				    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
				<?php endif; ?>

			</div>

			<div class="col-md-4">
				<?php get_sidebar(); ?>
			</div>

		</div>

		<!-- Reviews -->
		<?php get_template_part( 'partials/posts/listing', 'related' ); ?>

	</div>

<?php get_footer(); ?>