<?php get_header(); ?>

	<div class="container">

		<!-- Featured -->
		<?php get_template_part( 'partials/posts/feature', 'post' ); ?>

		<!-- Recipes -->
		<?php get_template_part( 'partials/posts/post', 'filters' ); ?>

		<!-- Recipes -->
		<?php get_template_part( 'partials/posts/listing', 'recipes' ); ?>

		<!-- Lifestyle posts -->
		<?php get_template_part( 'partials/posts/listing', 'lifestyle' ); ?>

		<!-- Reviews -->
		<?php get_template_part( 'partials/posts/listing', 'reviews' ); ?>

		<!-- Unprocessed Productions -->
		<?php get_template_part( 'partials/posts/unprocessed', 'productions' ); ?>

	</div>

<?php get_footer(); ?>