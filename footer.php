<?php get_template_part( 'partials/video', 'modal' ); ?>
<footer>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<h2>Megunprocessed</h2>
				<?php include (TEMPLATEPATH . '/partials/social.php'); ?>
			</div>
			<div class="col-md-4">
				<p class="timeline"><?php echo bloginfo('description'); ?></p>
			</div>
			<div class="col-md-4" id="SignUp">
				<h3>Get A Free eBook</h3>
				<form method="POST" action="" data-type="ebook">
					<div class="form-group">
						<input type="text" name="name" placeholder="name" />
					</div>
					<div class="form-group">
						<input type="email" name="emailaddress" placeholder="emailaddress" />
					</div>
					<button type="submit" class="btn">Submit</button>
				</form>
			</div>
		</div>
		<div id="legal">
			<nav>
				<?php
					$defaults = array(
						'theme_location'  => 'footer',
						'menu'            => 'Footer Buttons',
						'container'       => 'div',
						'container_class' => '',
						'container_id'    => '',
						'menu_class'      => 'menu',
						'menu_id'         => '',
						'echo'            => true,
						'fallback_cb'     => 'wp_page_menu',
						'before'          => '',
						'after'           => '',
						'link_before'     => '',
						'link_after'      => '',
						'items_wrap'      => '<ul id="%1$s" class="%2$s list-unstyled">%3$s</ul>',
						'depth'           => 0,
						'walker'          => ''
					);

					wp_nav_menu( $defaults );
				?>
			</nav>
			&copy; <?php echo date("Y"); ?> <?php bloginfo('name'); ?>.  All Rights Reserved. <br />
			<small><span id="INiT-legal"><a href="http://theinitgroup.com" target="_blank">Los Angeles Web Design</a> by The INiT Group.</span></small>
		</div>
	</div>
</footer>
    
</body>
</html>

<?php wp_footer(); ?>  