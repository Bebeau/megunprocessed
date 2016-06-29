<?php get_header(); ?>

	<div class="container post-single">

		<div class="post-header">
			<h1><?php the_title(); ?></h1>
		</div>

		<div class="row">

			<div class="col-sm-8">

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php the_post_thumbnail(); ?>
					<div class="single-text">
					    <?php the_content(); ?>
					    <?php get_template_part( 'partials/social', 'share' ); ?>
					    <div class="fb-comments" data-href="<?php the_permalink() ?>" data-width="100%" data-num-posts="6"></div>
					</div>
				<?php endwhile; endif; ?>

			</div>

			<?php get_sidebar(); ?>

		</div>

		<!-- Newsletter CTA -->
		<?php get_template_part( 'partials/cta/body', 'banner' ); ?>

	</div>

<?php get_footer(); ?>