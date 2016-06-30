<!-- Reviews Books and Freebies -->
<div class="row">
	<h2 class="secTitle"><span>Recipes</span></h2>
</div>
<section class="row listing">
	<?php 
		// List most recent Product Review
		$featuredPosts = get_cat_ID('Featured');
		query_posts( array(
				'post_type' => 'recipes',
				'posts_per_page' => 4,
				'order' => 'DESC',
				'category__not_in' => $featuredPosts
			)
	    );
		if (have_posts()) : while (have_posts()) : the_post();
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'large' );
			$videoID = get_post_meta( $post->ID, 'video_link', true ); ?>
			<div class="col-sm-3">
				<a href="<?php the_permalink(); ?>">
				<?php if ($image) { ?>
					<article class="post-image" style="background: url('<?php echo $image[0]; ?>') no-repeat scroll center / cover;">
				<?php } else { ?>
					<article class="post-image default-image" >
				<?php } ?>
					</article>
					<h3><?php the_title(); ?></h3>
				</a>
			</div>
	<?php endwhile; endif;
	wp_reset_query(); ?>
</section>