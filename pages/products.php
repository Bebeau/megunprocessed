<?php 

/*
Template Name: Products
*/

get_header(); ?>

	<div class="container">

		<div class="row">

			<div class="col-sm-12">
				<div class="single-content" id="Products">
					<?php 
						the_title("<h1>","</h1>");
						the_content();
						$terms = get_terms('product_type');
						foreach ( $terms as $term ) {
						   	echo '<h2 class="secTitle"><span>'.$term->name.'</span></h2>';
						   	query_posts( 
								array(
									'post_type' => 'products',
									'order' => 'DESC',
									'tax_query' => array(
											array(
												'taxonomy' => 'product_type',
												'field' => 'id',
												'terms' => $term->term_id
											)
										),
									'posts_per_page' => -1
								)
						    );
						    if ( have_posts() ) : while ( have_posts() ) : the_post();
						    	$link = get_post_meta($post->ID, 'product_link', true);
						    	echo '<a class="singleProduct" href="'.$link.'" target="_BLANK">';
						    		the_post_thumbnail();
						    		the_title();
						    	echo '</a>';
						    endwhile; endif;
						    wp_reset_query();
						}
					?>

				</div>
			</div>

		</div>

	</div>

<?php get_footer(); ?>