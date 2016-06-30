<?php get_header(); ?>

	<div class="container">

		<div class="row">

			<div class="col-sm-8">

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php
						$video = get_post_meta( $post->ID, 'video_link', true );  
						if($video) {
							echo '<iframe width="100%" height="422" src="https://www.youtube.com/embed/'.$video.'?autoplay=1" frameborder="0" allowfullscreen></iframe>';
						} elseif(has_post_thumbnail()) {
							the_post_thumbnail();
						} else {

						}
				 	?>
					<div class="single-content">
						<h1><?php the_title(); ?></h1>
					    <?php the_content(); ?>
					    <?php 
					    $link = get_post_meta( $post->ID, 'product_link', true );
					    if( $link != "") { ?>
					    	<a href="<?php echo $link; ?>" target="_blank" class="btn-custom btn-green btn-review">Buy Now</a>
					    <?php } ?>
					    <?php get_template_part( 'partials/social', 'share' ); ?>
					    <div class="fb-comments" data-href="<?php the_permalink() ?>" data-width="100%" data-num-posts="6"></div>
					</div>
				<?php endwhile; endif; ?>

			</div>
			
			<div class="col-md-4">

				<?php get_sidebar(); ?>

			</div>

		</div>

		<!-- Newsletter CTA -->
		<?php // get_template_part( 'partials/cta/body', 'banner' ); ?>

		<!-- Related -->
		<?php get_template_part( 'partials/posts/listing', 'related' ); ?>

	</div>

<?php get_footer(); ?>