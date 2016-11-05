<?php get_header(); ?>

	<div class="container" id="singleReview">

		<div class="row">

			<div class="col-md-8">

				<?php if (have_posts()) : while (have_posts()) : the_post();

					$rating = get_post_meta($post->ID, 'review_ranking', true);
					
					$address = get_post_meta(get_the_ID(), 'address', true);
				    $city = get_post_meta(get_the_ID(), 'city', true);
				    $state = get_post_meta(get_the_ID(), 'state', true);
				    $zip = get_post_meta(get_the_ID(), 'zip', true);

	    			if(has_post_thumbnail()) {
						$postImage = wp_get_attachment_image_url(get_post_thumbnail_id($post->ID), 'large', false ); 
					} else { 
						$postImage = get_bloginfo('template_directory').'/assets/images/default_facebook.jpg'; 
					};

					echo '<div class="single-top clearfix">';
							the_post_thumbnail();
					echo '</div>';
					list_ranking($post);
					echo '<div class="single-content">';
						the_title('<h1>','</h1>');
						the_content();
						the_map($post);
						get_template_part( 'partials/social', 'share' );
				    	echo '<div class="fb-comments" data-href="'.get_the_permalink().'" data-width="100%" data-num-posts="6"></div>';
				    echo '</div>';
				endwhile; endif; ?>

			</div>

			<div class="col-md-4">
				<?php get_sidebar(); ?>
			</div>

		</div>

		<!-- Related -->
		<?php get_template_part( 'partials/posts/listing', 'related' ); ?>

	</div>

<?php get_footer(); ?>