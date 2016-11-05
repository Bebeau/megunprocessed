<div id="filters">

	<div class="dropdown">  

		<button id="FilterDropdown" class="btn btn-blue btn-filter" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<span>filter by</span> Ingredients
			<i class="fa fa-caret-down"></i>
		</button>

		<ul class="dropdown-menu" aria-labelledby="FilterDropdown">
			<?php
				$args = array(
				    'taxonomy' => 'ingredients',
				    'hide_empty' => false,
				);
				$terms = get_terms($args);
				foreach($terms as $term) {
					echo '<li><a href="'.get_term_link($term->term_taxonomy_id).'">'.$term->name.'</a></li>';
				}
			?>
		</ul>

	</div>
	
	<div class="dropdown">  

		<button id="FilterDropdown" class="btn btn-blue btn-filter" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<span>filter by</span> Category
			<i class="fa fa-caret-down"></i>
		</button>

		<ul class="dropdown-menu" aria-labelledby="FilterDropdown">
			<?php
				$args = array(
						'style' => 'list',
						'hide_empty' => 1,
						'hierarchical' => 0,
						'title_li' => ''
					);
				wp_list_categories($args);
			?>
		</ul>

	</div>

</div>