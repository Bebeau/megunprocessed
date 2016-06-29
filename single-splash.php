<?php get_header('single'); ?>

	<div class="container post-single single-splash" id="Splash">

		<div class="row">

			<div class="col-sm-8 col-sm-offset-2">

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php
						if(has_post_thumbnail()) {
							the_post_thumbnail();
						}
				 	?>
				 	<div class="single-text">
						<h1><?php the_title(); ?></h1>
					    <?php the_content(); ?>
					</div>
				<?php endwhile; endif; ?>

			</div>

		</div>

	</div>

<?php get_footer(); ?>