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
				<form method="POST" action="">
					<div class="form-group">
						<input type="text" name="" placeholder="name" />
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

<?php 

$activeModal = get_option('switch_on');
$popupImage = get_option('sophie_popup');
$popupTitle = get_option('popup_title');

if($activeModal === "1") {
?>
	<div class="modal fade" tabindex="-1" role="dialog" id="NewsletterModal">
		<div class="outer">
			<div class="inner">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-body">
							<button type="button" class="close-btn" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
							<form role="form" class="form" id="newsletter-frm-4" data-form="4" method="post" action="<?php echo bloginfo('template_directory');?>/partials/forms/newsletter.php">
								<div class="form-group clearfix">
									<div class="col-md-6">
										<div id="popupImage">
											<?php if($popupImage) { ?>
												<img src="<?php echo $popupImage; ?>" alt="" />
											<?php } else { ?>
												<img src="<?php echo bloginfo('template_directory') ?>/assets/images/popup_default.jpg" alt="" />
											<?php } ?>
										</div>
									</div>
									<div class="col-md-6">
										<div id="popupForm">
											<div class="outer">
												<div class="inner">
													<?php if($popupTitle) {
														echo '<h3>'.$popupTitle.'</h3>';
													} else { ?>
														<img class="popup-title" src="<?php echo bloginfo('template_directory'); ?>/assets/images/title.jpg" alt="" />
													<?php } ?>
													<label for="emailaddress">Email <span class="required">*</span></label>
													<input type="email" name="emailaddress_4" id="emailaddress_4" placeholder="email@address.." class="form-control"/>
													<br />
													<button type="submit" class="btn-custom btn-pink btn-submit">
														Subscribe
													</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
    
</body>
</html>

<?php wp_footer(); ?>  