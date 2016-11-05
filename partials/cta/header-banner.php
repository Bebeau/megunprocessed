<?php 
	$homeBanner = get_option('meg_homeImage');
if(!empty($homeBanner)) {
?>
<div class="header-CTA cta" style="background: url('<?php echo $homeBanner; ?>') no-repeat scroll top left / cover #FFFFFF;" data-parallax='{"y" : 230, "smoothness": 1}'>
<?php } else { ?>
<div class="header-CTA cta" data-parallax='{"y" : 230, "smoothness": 1}'>
<?php } ?>

	<div class="outer">
		<div class="inner">
			<div id="purpleBar">
				<div class="container">
					<div class="row">
						<div class="col-md-4 col-md-offset-1">
							<img src="<?php echo bloginfo('template_directory'); ?>/assets/images/placeholder.png" alt="" />
						</div>
						<div class="col-md-7 hidden-xs" id="BarTitle">
							<div class="outer">
								<div class="inner">
									<h1>Megunprocessed</h1>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<form role="form" class="form" id="newsletterfrm" data-form="newsletter" method="post" action="">
						<div class="row">
							<div class="col-md-4">
								<h3 class="cta-title">Get a free eBook</h3>
							</div>
							<div class="col-md-7">
								<div class="row">
									<div class="col-md-4">
										<input type="text" name="firstname_1" id="firstname_1" placeholder="first name" class="form-control"/>
									</div>
									<div class="col-md-4">
										<input type="text" name="lastname_1" id="lastname_1" placeholder="last name" class="form-control"/>
									</div>
									<div class="col-md-4">
										<input type="email" name="emailaddress_1" id="emailaddress_1" placeholder="email@address.." class="form-control"/>
									</div>
								</div>
							</div>
							<div class="col-md-1">
								<button class="btn btn-custom btn-pink btn-submit">
									Go
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>