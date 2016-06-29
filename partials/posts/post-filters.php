<?php 

$term = get_queried_object();

$children = get_terms( $term->taxonomy, array(
	'parent'    => $term->term_id,
	'hide_empty' => false
) );

?>
<div id="filters">

	<div class="row">

		<div class="dropdown col-md-4 col-md-offset-2">  

			<button id="FilterDropdown" class="btn btn-blue btn-filter" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<span>filter by</span> Ingredients
				<i class="fa fa-caret-down"></i>
			</button>

			<ul class="dropdown-menu" aria-labelledby="FilterDropdown">
				<?php
					if(is_category("Blog")) {
						$args = array(
							'style' => 'list',
							'hide_empty' => 1,
							'hierarchical' => 0,
							'title_li' => ''
						);
						wp_list_categories($args);
					} elseif(!$children) {
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
							'taxonomy'           => 'ingredient',
							'walker'             => null
					    );
						wp_list_categories($args);
					} else {
						$cat_object = $wp_query->get_queried_object();
						$parentcat = ($cat_object->category_parent) ? $cat_object->category_parent : $cat;
						wp_list_categories("child_of=$parentcat&title_li=");
					}

				?>
			</ul>

		</div>

		<div class="dropdown col-md-4">  

			<button id="FilterDropdown" class="btn btn-blue btn-filter" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<span>filter by</span> Category
				<i class="fa fa-caret-down"></i>
			</button>

			<ul class="dropdown-menu" aria-labelledby="FilterDropdown">
				<?php
					if(is_category("Blog")) {
						$args = array(
							'style' => 'list',
							'hide_empty' => 1,
							'hierarchical' => 0,
							'title_li' => ''
						);
						wp_list_categories($args);
					} elseif(!$children) {
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
					} else {
						$cat_object = $wp_query->get_queried_object();
						$parentcat = ($cat_object->category_parent) ? $cat_object->category_parent : $cat;
						wp_list_categories("child_of=$parentcat&title_li=");
					}

				?>
			</ul>

		</div>

	</div>

</div>