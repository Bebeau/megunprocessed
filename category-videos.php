<?php get_header(); ?>
	
	<div class="container" id="listing" data-id="<?php echo get_query_var('cat'); ?>">

		<div class="post-header">
			<h1>Video Gallery</h1>
		</div>

		<section class="row">

			<?php 
				$Videos = get_cat_ID('Videos');
				query_posts( 
					array(
						'post_type' => array('post', 'recipes', 'reviews'),
						'cat' => $Videos,
						'order' => 'DESC',
						'category__not_in' => array(2218)
					)
			    );

				$count = 0;
				global $videoID;

				if (have_posts()) : while (have_posts()) : the_post(); 
					$videoID = get_post_meta( $post->ID, 'video_link', true );
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'large' ); 

					if ($count % 4 == 0 || $count === 0) { 

						if($count % 8 == 0) { ?>

							<div class="col-sm-12">

								<section class="row hidden-xs featured-post square-feature featured-right">

									<div class="col-sm-6 col-md-4">
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
												if ($image) {
													echo '<article class="col-sm-6 col-md-8 featured-image" style="background: url('.$image[0].') no-repeat scroll center / cover; ">';
												} else {
													echo '<article class="col-sm-6 col-md-8 featured-image post-image" style="background: url(http://img.youtube.com/vi/'.$videoID.'/sddefault.jpg) no-repeat scroll center / cover; ">';
												} 
												echo '<div class="playwrap"><i class="fa fa-play"></i></div>';
											echo '</article>'; ?>
										</a>
									</div>

								</section>

							</div>

						<?php } else { ?>

							<div class="col-sm-12">

								<section class="row hidden-xs featured-post square-feature featured-left">

									<div class="videoWrap">
										<a href="<?php the_permalink(); ?>">
											<?php
												if ($image) {
													echo '<article class="col-sm-6 col-md-8 featured-image" style="background: url('.$image[0].') no-repeat scroll center / cover; ">';
												} else {
													echo '<article class="col-sm-6 col-md-8 featured-image post-image" style="background: url(http://img.youtube.com/vi/'.$videoID.'/sddefault.jpg) no-repeat scroll center / cover; ">';
												} 
												echo '<div class="playwrap"><i class="fa fa-play"></i></div>';
											echo '</article>'; ?>
										</a>
									</div>

									<div class="col-sm-6 col-md-4">
										<div class="featured-copy outer">
											<div class="inner">
												<h3><?php the_title(); ?></h3>
												<?php // the_excerpt(25); ?>
												<a href="<?php echo the_permalink(); ?>" class="btn-custom btn-darkgreen">View</a>
											</div>
										</div>
									</div>

								</section>

							</div>

						<?php }

					} else { ?>

						<div class="square col-sm-4">
							<a href="<?php the_permalink(); ?>">
								<?php if ($image) {
									echo '<article style="background: url('.$image[0].') no-repeat scroll center / cover; ">';
								} else {
									echo '<article style="background: url(http://img.youtube.com/vi/'.$videoID.'/sddefault.jpg) no-repeat scroll center / cover; ">';
								} ?>
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
								<?php echo '</article>'; ?>
							</a>

						</div>

						<?php

					}

				if ($count % 4 == 3 || $count % 4 == 0 || $count === 0 ) {
			    	echo '</section><section class="row">';
			    }; ?>

				<?php $count++;
				
				endwhile; endif;
				wp_reset_query();
			?>
		</section>

		<?php // init_pagination(); ?>

	</div>

<?php get_footer(); ?>