<?php get_header(); ?>

	<div class="container">

		<!-- Featured -->
		<?php get_template_part( 'partials/posts/feature', 'post' ); ?>

		<!-- Recipes -->
		<?php get_template_part( 'partials/posts/home', 'filters' ); ?>

		<!-- Recipes -->
		<?php get_template_part( 'partials/posts/listing', 'recipes' ); ?>

		<!-- Lifestyle posts -->
		<?php get_template_part( 'partials/posts/listing', 'lifestyle' ); ?>

		<!-- Reviews -->
		<?php get_template_part( 'partials/posts/listing', 'reviews' ); ?>

	</div>

		<!-- Unprocessed Productions -->
		<?php get_template_part( 'partials/posts/unprocessed', 'productions' ); ?>


<?php get_footer(); ?>