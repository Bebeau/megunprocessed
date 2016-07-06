<?php 

$term = get_queried_object();

$children = get_terms( $term->taxonomy, array(
	'parent'    => $term->term_id,
	'hide_empty' => false
) );

?>

<div class="row" id="filters">

	<div class="dropdown col-md-6">  

		<button id="FilterDropdown" class="btn btn-blue btn-filter" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Ingredients
			<i class="fa fa-caret-down"></i>
		</button>

		<ul class="dropdown-menu" aria-labelledby="FilterDropdown">
			<?php
				function get_terms_dropdown($taxonomies, $args){
					$myterms = get_terms($taxonomies, $args);
					foreach($myterms as $term){
						$root_url = get_bloginfo('url');
						$term_taxonomy=$term->taxonomy;
						$term_slug=$term->slug;
						$term_name =$term->name;
						$link = $root_url.'/'.$term_taxonomy.'/'.$term_slug;
						$output .="<li class='cat-item'><a href='".$link."' />".$term_name."</a></li>";
					}
					return $output;
				}
				$taxonomies = array('ingredients');
				$args = array('orderby'=>'count','hide_empty'=>true);
				echo get_terms_dropdown($taxonomies, $args);
			?>
		</ul>

	</div>

	<div class="dropdown col-md-6">  

		<button id="FilterDropdown" class="btn btn-blue btn-filter" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Categories
			<i class="fa fa-caret-down"></i>
		</button>

		<ul class="dropdown-menu" aria-labelledby="FilterDropdown">
			<?php
				$args = array(
						'show_option_all'    => '',
						'orderby'            => 'name',
						'order'              => 'ASC',
						'style'              => 'list',
						'show_count'         => 0,
						'hide_empty'         => 1,
						'use_desc_for_title' => 1,
						'child_of'           => 0,
						'feed'               => '',
						'feed_type'          => '',
						'feed_image'         => '',
						'exclude'            => '',
						'exclude_tree'       => '',
						'include'            => '',
						'hierarchical'       => 1,
						'title_li'           => '',
						'show_option_none'   => __( '' ),
						'number'             => null,
						'echo'               => 1,
						'depth'              => 1,
						'current_category'   => 0,
						'pad_counts'         => 0,
						'taxonomy'           => 'category',
						'walker'             => null
				    );
				wp_list_categories($args);
			?>
		</ul>

	</div>

</div>