<?php get_header('giveaways');?>

<div class="gradients">
	<div class="left"></div>
	<div class="right"></div>
</div>
<div class="arrows m-scooch-controls">
	<span class="arrow left" data-m-slide="prev"></span>
	<span class="arrow right" data-m-slide="next"></span>
</div>

<div class="outer">
	<div class="inner">

		<div class="text-center giveaways-title">
			<a href="<?php echo site_url('/sophies-giveaways'); ?>">
                <h1>Sophie's <span class="pink">Giveaways</span></h1>
            </a>
		</div>

		<section class="giveaways-listing" data-giveaway="0">

			<!-- the viewport -->
			<div class="m-scooch m-fluid m-scooch-giveaways">
				<!-- the slider -->
				<div class="m-scooch-inner">

				<?php 
					$args = array(
						'post_type' 	=> 'giveaways',
						'post_status'	=> array('publish', 'expired'),
						'orderby' 		=> 'date',
						'order' 		=> 'DESC'
					);
							
					$giveaways = new WP_Query( $args );
					$count = 0;

					if ($giveaways->have_posts()) : while ($giveaways->have_posts()) : $giveaways->the_post(); 
						$live = get_post_status();
						$image = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
					?>

						<!-- the items -->
						<div class="m-item">
							<?php if($live !== "expired") { ?>
								<a class="link" href="<?php echo the_permalink(); ?>">
							<?php } else { ?>
								<span class="link">
							<?php } ?>
						
							<?php
								if ($image) {
									echo '<article class="single-giveaway" data-count="'.$count.'" style="background: url('.$image.') no-repeat scroll center / cover; ">';
								} else {
									echo '<article class="single-giveaway default-image" data-count="'.$count.'">';
								}
								$status = get_post_status( $post->ID );
								if( $status === 'expired' ) { ?>
									<div class="giveaway-copy expired">
										<div class="outer">
											<div class="inner">
												<h2 class="title"><?php the_title(); ?></h2>
												<span class="enter">Expired</span>
											</div>
										</div>
									</div>
								<?php } else { ?>
									<div class="outer">
										<div class="inner">
											<div class="giveaway-copy">
												<h2 class="title"><?php the_title(); ?></h2>
												<div class="enter">
													Enter To Win!
												</div>
											</div>
										</div>
									</div>
								<?php }
						
							echo '</article>';

							if($live !== "expired") { 
								echo '</a>';
							} else {
								echo '</span>';
							}

							echo '</div>';
						
						$count++;

					endwhile; endif; 
				?>

		</section>

		<?php include(TEMPLATEPATH . '/partials/social.php'); ?>

	</div>
</div>

<?php get_footer('giveaways'); ?>