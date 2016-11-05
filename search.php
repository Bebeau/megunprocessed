<?php
/*
Template Name: Search Page
*/
get_header(); 

$page = get_page_by_title('Unprocessed Productions');
$videos_link = get_permalink($page->ID);

?>

	<div class="container" id="listing">

		<?php if (have_posts()) { ?>

			<div class="post-header">
				<?php
					$hit_count = $wp_query->found_posts;
					echo '<h1>We Found <span class="searched">' . $hit_count . '</span> Results for "<span class="searched">'.$s.'</span>"</h1>';
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
														$videoID = get_post_meta( $post->ID, 'video_link', true );
														$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'large' );
														if ($image) {
															echo '<article class="col-sm-6 col-md-8 featured-image" style="background: url('.$image[0].') no-repeat scroll center / cover; ">';
														} elseif(has_category("Videos")) {
								                            echo '<article class="post-image" style="background: url(http://img.youtube.com/vi/'.$videoID.'/sddefault.jpg) no-repeat scroll center / cover;">';
								                        } else {
															echo '<article class="col-sm-6 col-md-8 featured-image post-image" style="background: url(http://img.youtube.com/vi/'.$videoID.'/sddefault.jpg) no-repeat scroll center / cover; ">';
														} 
														echo '</article>'; 
													?>
												</a>
											</div>
										</div>
										<div class="visible-xs">
											<iframe width="100%" height="225" src="https://www.youtube.com/embed/<?php echo $videoID; ?>?&showinfo=0&controls=0" frameborder="0" allowfullscreen showinfo="false"></iframe>
											<div class="col-sm-6 col-md-4 copyWrap">
												<div class="featured-copy outer" data-animation="slideInLeft">
													<div class="inner">
														<h3>Watch <span class="cursive">Sophie</span> On...</h3>
														<img src="<?php echo bloginfo('template_directory');?>/assets/images/hnf-logo.jpg" />
														<a href="<?php echo $videos_link; ?>" class="btn-custom btn-darkgreen">Watch Videos</a>
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
														<h3>Watch <span class="cursive">Sophie</span> On...</h3>
														<img src="<?php echo bloginfo('template_directory');?>/assets/images/hnf-logo.jpg" />
														<a href="<?php echo $videos_link; ?>" class="btn-custom btn-darkgreen">Watch Videos</a>
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
												<div class="featured-copy outer" data-animation="slideInLeft">
													<div class="inner">
														<h3>Watch <span class="cursive">Sophie</span> On...</h3>
														<img src="<?php echo bloginfo('template_directory');?>/assets/images/hnf-logo.jpg" />
														<a href="<?php echo $videos_link; ?>" class="btn-custom btn-darkgreen">Watch Videos</a>
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
							<a href="<?php the_permalink();?>">
								<?php if ($image) {
									echo '<article class="post-image" style="background: url('.$image[0].') no-repeat scroll center / cover;">';
								} elseif(has_category("Videos")) {
									echo '<article class="post-image" style="background: url(http://img.youtube.com/vi/'.$videoID.'/sddefault.jpg) no-repeat scroll center / cover;">';
								} else {
									echo '<article class="post-image default-image" >';
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
			    };

				$count++;
				
				endwhile; else :
					echo '<p class="alert alert-warning">There are no results for this listing.</p>';
				endif;
				wp_reset_query();
			?>
		</section>

		<?php } else { ?>

			<div class="post-header">
				<h1>There are no search results for "<span class="searched"><?php echo $s; ?></span>"</h1>
			</div>

		<?php } ?>

		<!-- Newsletter CTA -->
		<?php get_template_part( 'partials/cta/body', 'banner' ); ?>

	</div>

<?php get_footer(); ?>