<?php get_header(); 
	$ptype = get_post_type();
	$catID = get_query_var('cat');
?>
	<div class="container" id="listing" data-id="<?php echo $catID; ?>">

		<div class="post-header">
			<?php
			
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
			<?php } elseif(is_category('Blog')) { ?>
				<h1 class="archive-title">
		    		Philo<span class="cursive">Sophie</span>
		    	</h1>
			<?php } elseif(is_category('Reviews')) { ?>
				<h1 class="archive-title"><span class="cursive">
		    		Sophie's</span> Reviews
		    	</h1>
			<?php } elseif(is_category('Recipes')) { ?>
				<h1 class="archive-title">
		    		<span class="cursive">Sophie's</span> Recipes
		    	</h1>
			<?php } ?>

			<?php
				get_template_part( 'partials/posts/category', 'filter' );

				$args = array(
					'type'                     => 'post',
					'child_of'                 => 0,
					'parent'                   => $catID,
					'orderby'                  => 'name',
					'order'                    => 'ASC',
					'hide_empty'               => 1,
					'hierarchical'             => 1,
					'exclude'                  => '',
					'include'                  => '',
					'number'                   => '',
					'taxonomy'                 => 'category',
					'pad_counts'               => false 
				); 

			    $sub = get_categories( $args );

			    $parentCatID = get_cat_ID(single_cat_title('',false));

			    if ($sub) {
			    	$sub_args = array(
			    		'cat' => $catID,
			    		'post_type' => array("post", "recipes", "reviews", "videos", "splash"),
			    		'category__not_in' => array(2218)
		    		);
			    	query_posts( $sub_args );
				} else {
					$args = array(
						'cat' => $catID,
						'post_type' => array("post", "recipes", "reviews", "videos", "splash"),
						'category__not_in' => array(2218)
					);

					query_posts( $args );
				}

			?>
		</div>

		<section class="row">

			<?php 

				$count = 0;

				if (have_posts()) : while (have_posts()) : the_post(); 
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'large' ); 
					$videoID = get_post_meta( $post->ID, 'video_link', true );

					if ($count % 4 == 0 || $count === 0) { 

						if($count % 8 == 0) { ?>

							<div class="col-sm-12">

								<section class="row hidden-xs featured-post square-feature featured-right">

									<?php if(!has_category("Videos")) { ?>

										<div class="col-sm-6 col-md-4">
											<div class="featured-copy outer">
												<div class="inner">
													<h3><?php the_title(); ?></h3>
													<?php // the_excerpt(25); ?>
													<a href="<?php echo the_permalink(); ?>" class="btn-custom btn-darkgreen">Read Article</a>
												</div>
											</div>
										</div>

										<a href="<?php echo the_permalink(); ?>">
											<?php
												if ($image) {
													echo '<article class="col-sm-6 col-md-8 featured-image" style="background: url('.$image[0].') no-repeat scroll center / cover; ">';
												} else {
													echo '<article class="col-sm-6 col-md-8 featured-image post-image default-image">';
												} 
											echo '</article>'; ?>
										</a>

									<?php } else { ?>

										<div class="hidden-xs">
											<div class="col-sm-6 col-md-4">
												<div class="featured-copy outer">
													<div class="inner">
														<h3><?php the_title(); ?></h3>
														<?php // the_excerpt(25); ?>
														<a href="<?php echo the_permalink(); ?>" class="btn-custom btn-darkgreen">Read Article</a>
													</div>
												</div>
											</div>
											<div class="videoWrap">
												<a href="<?php the_permalink(); ?>">
													<?php
														$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'large' );
														if ($image) {
															echo '<article class="col-sm-6 col-md-8 featured-image" style="background: url('.$image[0].') no-repeat scroll center / cover; ">';
														} else {
															echo '<article class="col-sm-6 col-md-8 featured-image post-image" style="background: url(http://img.youtube.com/vi/'.$videoID.'/sddefault.jpg) no-repeat scroll center / cover; ">';
														} 
														echo '<div class="playwrap"><i class="fa fa-play"></i></div>';
														echo '</article>'; 
													?>
												</a>
											</div>
										</div>
										<div class="visible-xs">
											<iframe width="100%" height="225" src="https://www.youtube.com/embed/<?php echo $videoID; ?>?&showinfo=0&controls=0" frameborder="0" allowfullscreen showinfo="false"></iframe>
											<div class="col-sm-6 col-md-4">
												<div class="featured-copy outer">
													<div class="inner">
														<h3><?php the_title(); ?></h3>
														<?php // the_excerpt(25); ?>
														<a href="<?php echo the_permalink(); ?>" class="btn-custom btn-darkgreen">View</a>
													</div>
												</div>
											</div>
										</div>

									<?php } ?>

								</section>

							</div>

						<?php } else { ?>

							<div class="col-sm-12">

								<section class="row hidden-xs featured-post square-feature featured-left">

									<?php if(!has_category("Videos")) { ?>

										<a href="<?php echo the_permalink(); ?>">
											<?php
												if ($image) {
													echo '<article class="col-sm-6 col-md-8 featured-image" style="background: url('.$image[0].') no-repeat scroll center / cover; ">';
												} else {
													echo '<article class="col-sm-6 col-md-8 featured-image post-image default-image">';
												} 
											echo '</article>'; ?>
										</a>

										<div class="col-sm-6 col-md-4">
											<div class="featured-copy outer">
												<div class="inner">
													<h3><?php the_title(); ?></h3>
													<?php // the_excerpt(25); ?>
													<a href="<?php echo the_permalink(); ?>" class="btn-custom btn-darkgreen">Read Article</a>
												</div>
											</div>
										</div>

									<?php } else { ?>

										<div class="hidden-xs">
											<div class="col-sm-6 col-md-4 col-sm-push-6 col-md-push-8">
												<div class="featured-copy outer">
													<div class="inner">
														<h3><?php the_title(); ?></h3>
														<?php // the_excerpt(25); ?>
														<a href="<?php echo the_permalink(); ?>" class="btn-custom btn-darkgreen">View</a>
													</div>
												</div>
											</div>
											<div class="videoWrap">
												<a href="<?php the_permalink(); ?>">
													<?php
														$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'large' );
														if ($image) {
															echo '<article class="col-sm-6 col-md-8 col-sm-pull-6 col-sm-pull-4 featured-image" style="background: url('.$image[0].') no-repeat scroll center / cover; ">';
														} else {
															echo '<article class="col-sm-6 col-md-8 col-sm-pull-6 col-sm-pull-4 featured-image post-image" style="background: url(http://img.youtube.com/vi/'.$videoID.'/sddefault.jpg) no-repeat scroll center / cover; ">';
														} 
														echo '<div class="playwrap"><i class="fa fa-play"></i></div>';
														echo '</article>'; 
													?>
												</a>
											</div>
										</div>
										<div class="visible-xs">
											<iframe width="100%" height="225" src="https://www.youtube.com/embed/<?php echo $videoID; ?>?&showinfo=0&controls=0" frameborder="0" allowfullscreen showinfo="false"></iframe>
											<div class="col-sm-6 col-md-4 copyWrap">
												<div class="featured-copy outer">
													<div class="inner">
														<h3><?php the_title(); ?></h3>
														<?php // the_excerpt(25); ?>
														<a href="<?php echo the_permalink(); ?>" class="btn-custom btn-darkgreen">View</a>
													</div>
												</div>
											</div>
										</div>

									<?php } ?>

								</section>

							</div>

						<?php }

					} else { ?>

						<div class="square col-sm-4">
							<?php if ($image) { ?>
								<a href="<?php the_permalink(); ?>">
								<article class="post-image" style="background: url('<?php echo $image[0]; ?>') no-repeat scroll center / cover;">
							<?php } elseif(has_category("Videos")) { ?>
								<a href="<?php the_permalink(); ?>">
								<article class="post-image" style="background: url(http://img.youtube.com/vi/<?php echo $videoID; ?>/sddefault.jpg) no-repeat scroll center / cover;">
							<?php } else { ?>
								<a href="<?php the_permalink(); ?>">
								<article class="post-image default-image" >
							<?php } ?>

							<div class="outer barwrap" data-animation="postBar">
								<div class="inner bar">
									<div class="text">
										<div class="outer">
											<div class="inner">
												<h3><?php the_title(); ?></h3>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php echo '</article></a>'; ?>
								
						</div>

						<?php

					}

				if ($count % 4 == 3 || $count % 4 == 0 || $count === 0 ) {
			    	echo '</section><section class="row">';
			    };

				$count++;
				
				endwhile; else :
					echo '<p class="alert alert-warning">There are no results for this listing.</p>';
				endif;
				wp_reset_query();
			?>

		</section>

		<?php // init_pagination(); ?>

	</div>

<?php get_footer(); ?>