<div class="col-sm-4" id="Sidebar">
	<?php if ( !dynamic_sidebar() ) {
		$sidebar = 'main_sidebar';
		dynamic_sidebar( $sidebar );
	} ?>
</div>