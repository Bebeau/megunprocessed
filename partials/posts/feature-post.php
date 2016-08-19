<!-- Featured post -->
<section class="hidden-xs featured-post">
	<?php if(is_front_page()) {
		echo '<h2 class="secTitle"><span>Featured</span></h2>';
	} ?>
	<?php 
		// List most recent Featured
		$catID = get_cat_ID('Featured');
		query_posts( array(
				'cat' => $catID,
				'posts_per_page' => 1,
				'order' => 'DESC',
				'post_type' => array("post", "recipes", "reviews", "videos", "splash")
			)
	    );
		if (have_posts()) : while (have_posts()) : the_post(); 
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'large' ); ?>
			<a href="<?php echo the_permalink(); ?>">
				<?php if ($image) {
					echo '<article class="col-sm-6 col-md-6 featured-image" style="background: url('.$image[0].') no-repeat scroll center / cover; ">';
				} else {
					echo '<article class="col-sm-6 col-md-6 featured-image post-image default-image">';
				} 
				echo '</article>'; ?>
			</a>
			<div class="featured-copy col-sm-6 col-md-6">
				<div class="outer">
					<div class="inner">
						<a href="<?php echo the_permalink(); ?>">
							<h3><?php the_title(); ?></h3>
						</a>
						<?php the_excerpt(); ?>
						<a href="<?php echo the_permalink(); ?>">Read Article</a>
					</div>
				</div>
			</div>
			
		<?php 
		endwhile; endif;
		wp_reset_query();
	?>
</section>