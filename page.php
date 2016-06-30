<?php get_header(); ?>

	<div class="container single-page">

		<div class="row">

			<div class="col-sm-8">

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php the_post_thumbnail(); ?>
					<div class="single-content">
						<?php the_title('<h1>','</h1>'); ?>
					    <?php the_content(); ?>
					    <?php get_template_part( 'partials/social', 'share' ); ?>
					    <div class="fb-comments" data-href="<?php the_permalink() ?>" data-width="100%" data-num-posts="6"></div>
					</div>
				<?php endwhile; endif; ?>

			</div>

			<div class="col-md-4">
				<?php get_sidebar(); ?>
			</div>

		</div>

	</div>

<?php get_footer(); ?>