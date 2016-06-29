<?php get_template_part( 'partials/video', 'modal' ); ?>
<footer>
	<div class="outer">
		<div class="inner">
			<div class="container">
				<div class="row">
					<div class="col-md-4">
						<?php include (TEMPLATEPATH . '/partials/social.php'); ?>
					</div>
					<div class="col-md-4">
						<p><?php echo bloginfo('description'); ?></p>
					</div>
					<div class="col-md-4">
						<h3>Get A Free eBook</h3>
						<form method="POST" action="">
							<div class="form-group">
								<input type="text" name="" placeholder="name" />
							</div>
							<div class="form-group">
								<input type="email" name="emailaddress" placeholder="emailaddress" />
							</div>
							<div class="form-group">
								<button type="submit" class="btn-main btn-submit">Submit</button>
							</div>
						</form>
					</div>
				</div>
				<nav id="FooterButtons">
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
				<div id="legal">
					&copy; <?php echo date("Y"); ?> <?php bloginfo('name'); ?>.  All Rights Reserved. <br />
					<small><span id="INiT-legal"><a href="http://theinitgroup.com" target="_blank">Los Angeles Web Design</a> by The INiT Group.</span></small>
					<a href="<?php echo get_the_permalink(32312);?>" class="btn-custom btn-darkgreen" target="_blank">Disclaimer</a>
				</div>
			</div>
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

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-44007005-11', 'auto');
  ga('send', 'pageview');

</script>

<?php 
if(is_single(39378)) { ?>
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');

fbq('init', '835670603230646');
fbq('track', "PageView");</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=835670603230646&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<?php } ?>

<?php wp_footer(); ?>  