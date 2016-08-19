<?php 

/*
Template Name: Unprocessed Productions
*/

get_header(); ?>

	<div class="container" id="Videos">
		<div class="single-content">
			<div class="post-header">
				<img src="<?php echo bloginfo('template_directory'); ?>/assets/images/up_logo.jpg" alt="" />
			</div>
			<?php 

			list_videos($post);

			if(wp_is_mobile()) {
                if($video['type'] === "youtube") {
                    echo '<iframe src="https://www.youtube.com/embed/'.$video['id'].'" class="m-item videoFrame" width="100%" frameborder="0" allowfullscreen></iframe>';
                } elseif($video['type'] === 'vimeo') {
                    echo '<iframe src="https://player.vimeo.com/video/'.$video['id'].'" class="m-item videoFrame" width="100%" frameborder="0" allowfullscreen></iframe>';
                }
            }
			 ?>
		</div>
	</div>

	<div class="modal fade in bs-example-modal-lg" id="videomodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <i class="fa fa-times-circle" data-dismiss="modal"></i>
                </div>
            </div>
        </div>
    </div>

<?php 

get_footer(); ?>