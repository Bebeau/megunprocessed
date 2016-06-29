<div class="clearfix dropdown" id="filter">  

	<button id="FilterDropdown" class="btn btn-blue btn-filter" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Filter By Category
		<i class="fa fa-caret-down"></i>
	</button>

	<ul class="dropdown-menu" aria-labelledby="FilterDropdown">
		<?php
			$cat_object = $wp_query->get_queried_object();
			$parentcat = ($cat_object->category_parent) ? $cat_object->category_parent : $cat;
			wp_list_categories("child_of=$parentcat&title_li=");
		?>
	</ul>

</div>