<div id="Sidebar">
	<?php if ( !dynamic_sidebar() ) {
		$sidebar = 'main_sidebar';
		dynamic_sidebar( $sidebar );
		echo '<div class="ad_placeholder"></div>';
	} ?>
</div>