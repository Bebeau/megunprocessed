<?php get_header(); ?>

	<div class="container post-single">

		<div class="post-header">
			<?php
			$ptype = get_post_type();
			if (is_category() && !is_category('Blog') && !is_category('Reviews') && !is_category('Recipes')) { ?>
			    <h1 class="archive-title" >
			        <span><?php echo single_cat_title(); ?></span>
			    </h1>
			    <?php } elseif (is_day()) { ?>
			    <h1 class="archive-title">
			      	Philo<span class="cursive">Sophie</span> - <?php the_time('F jS, Y'); ?>
			    </h1>
			    <?php } elseif (is_month()) { ?>
			    <h1 class="archive-title">
			      	Philo<span class="cursive">Sophie</span> - <?php the_time('F, Y'); ?>
			    </h1>
			    <?php } elseif (is_year()) { ?>
			    <h1 class="archive-title">
			      	Philo<span class="cursive">Sophie</span> - <?php the_time('Y'); ?>
			    </h1>
			    <?php } elseif (is_author()) { ?>
			    <h1 class="archive-title">
			        Philo<span class="cursive">Sophie</span> - <?php echo $curauth->nickname; ?>
			    </h1>
			    <?php } elseif (is_tag()) { ?>
			    <h1 class="archive-title">
			        <?php echo single_tag_title('', true); ?> 
			    </h1>
			    <?php } elseif ($ptype === 'reviews') { ?>
			    	<h1 class="archive-title"><span class="cursive">
			    		Sophie's</span> Reviews
			    	</h1>
		    	<?php } elseif ($ptype === 'recipes') { ?>
			    	<h1 class="archive-title">
			    		<span class="cursive">Sophie's</span> Recipes
			    	</h1>
			<?php } else {
				if(has_category('Blog')) { ?>
					<h1 class="archive-title">
			    		Philo<span class="cursive">Sophie</span>
			    	</h1>
				<?php } elseif(has_category('Reviews')) { ?>
					<h1 class="archive-title"><span class="cursive">
			    		Sophie's</span> Reviews
			    	</h1>
				<?php } elseif(has_category('Recipes')) { ?>
					<h1 class="archive-title">
			    		<span class="cursive">Sophie's</span> Recipes
			    	</h1>
				<?php } 
			} ?>

		</div>

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
					<div class="single-text">
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

			<?php get_sidebar(); ?>

		</div>

		<!-- Newsletter CTA -->
		<?php get_template_part( 'partials/cta/body', 'banner' ); ?>

		<!-- Related -->
		<?php get_template_part( 'partials/posts/listing', 'related' ); ?>

	</div>

<?php get_footer(); ?>