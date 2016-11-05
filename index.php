<?php get_header(); ?>

	<div class="grey">

		<div class="container">

<<<<<<< HEAD
			<!-- Featured -->
			<?php get_template_part( 'partials/posts/feature', 'post' ); ?>

		</div>

			<!-- Recipes -->
			<?php get_template_part( 'partials/posts/post', 'filters' ); ?>

		<div class="container">

			<!-- Recipes -->
			<?php get_template_part( 'partials/posts/listing', 'recipes' ); ?>
=======
		<!-- Recipes -->
		<?php get_template_part( 'partials/posts/home', 'filters' ); ?>
>>>>>>> eec28e7c92d40ab0d187379188b1ff2b9a1fcb8a

			<!-- Lifestyle posts -->
			<?php get_template_part( 'partials/posts/listing', 'lifestyle' ); ?>

			<!-- Reviews -->
			<?php get_template_part( 'partials/posts/listing', 'reviews' ); ?>

		</div>

	</div>

		<!-- Unprocessed Productions -->
		<?php get_template_part( 'partials/posts/unprocessed', 'productions' ); ?>


<?php get_footer(); ?>