<?php get_header(); 
	$ptype = get_post_type();
	if(is_tax('ingredients')) {  
		$termSlug = get_query_var('ingredients');
		$term = get_term_by('slug', $termSlug, 'ingredients');
		$catID = $term->term_id;
	} else {
		$catID = get_query_var('cat');
	}
?>

	<!-- Recipes -->
	<?php get_template_part( 'partials/posts/post', 'filters' ); ?>

	<div class="container" data-id="<?php echo $catID; ?>" id="listing" data-animation="slideUp">

			<?php
			if (is_category() && !is_category('Blog') && !is_category('Reviews') && !is_category('Recipes') && !is_tax()) { ?>
			    <h2 class="secTitle" >
			        <span><?php echo single_cat_title(); ?></span>
			    </h2>
			    <?php } elseif (is_day()) { ?>
			    <h2 class="secTitle">
			      	<span>Megunprocessed - <?php the_time('F jS, Y'); ?></span>
			    </h2>
			    <?php } elseif (is_month()) { ?>
			    <h2 class="secTitle">
			      	<span>Megunprocessed - <?php the_time('F, Y'); ?></span>
			    </h2>
			    <?php } elseif (is_year()) { ?>
			    <h2 class="secTitle">
			      	<span>Megunprocessed - <?php the_time('Y'); ?></span>
			    </h2>
			    <?php } elseif (is_author()) { ?>
			    <h2 class="secTitle">
			        <span>Megunprocessed - <?php echo $curauth->nickname; ?></span>
			    </h2>
			    <?php } elseif (is_tag()) { ?>
			    <h2 class="secTitle">
			        <span><?php echo single_tag_title('', true); ?></span>
			    </h2>
			    <?php } elseif ($ptype === 'reviews' && !is_tax()) { ?>
			    	<h2 class="secTitle">
			    		<span>Reviews</span>
			    	</h2>
		    	<?php } elseif ($ptype === 'recipes' && !is_tax()) { ?>
			    	<h2 class="secTitle">
			    		<span>Recipes</span>
			    	</h2>
			<?php } elseif(is_tax('ingredients')) { ?>
				<h2 class="secTitle">
		    		<span><?php single_term_title(); ?></span>
		    	</h2>
			<?php } elseif(is_category('Blog')) { ?>
				<h2 class="secTitle">
		    		<span>Lifestyle</span>
		    	</h2>
			<?php } elseif(is_category('Reviews')) { ?>
				<h2 class="secTitle">
		    		<span>Reviews</span>
		    	</h2>
			<?php } elseif(is_category('Recipes')) { ?>
				<h2 class="secTitle">
		    		<span>Recipes</span>
		    	</h2>
			<?php } 

			// get_template_part( 'partials/posts/feature', 'post' );

			echo '<section class="row listing">';

			if(is_tax('ingredients')) {
				$args = array(
			        'posts_per_page' => 12,
			        'post_type' => array("post", "recipes", "reviews"),
			        'tax_query' => array(
						array(
							'taxonomy' => 'ingredients',
							'field'    => 'slug',
							'terms'    => get_queried_object()->slug,
						),
					)
			    );
			} else {
				$args = array(
			        'cat'   => $catID,
			        'posts_per_page' => 12,
			        'post_type' => array("post", "recipes", "reviews")
			    );
			}

		    $archives = new WP_Query($args);

			$count = 0;
			$all = wp_count_posts();
			$total = $all->publish;

			if ($archives->have_posts()) : while ($archives->have_posts()) : $archives->the_post();
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'large' ); 
				$videoID = get_post_meta( $post->ID, 'video_link', true ); ?>

					<div class="col-sm-3 entry">
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
			
			<?php
			$count++;
			if($count % 4 === 0) {
				echo '</section><section class="row listing">';
			} elseif($count === $total) {
				echo '</section>';
			}
			endwhile; else :
				echo '<p class="alert alert-warning">There are no results for this listing.</p>';
			endif;
			wp_reset_query(); ?>

	</div>

<?php get_footer(); ?>