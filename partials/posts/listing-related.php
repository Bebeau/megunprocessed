<?php 

global $post;
$type = get_post_type( $post->ID );
query_posts( array(
		'post_type' => $type,
		'posts_per_page' => 4,
		'order' => 'DESC',
		'post__not_in' => array($post->ID)
	)
);

if (have_posts()) { ?>

	<div class="related-posts">
		<h3>You Might Also Like...</h3>
		<section class="row listing">
			<?php
				while (have_posts()) { 
					the_post();
						$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'large' ); 
						$videoID = get_post_meta( $post->ID, 'video_link', true ); ?>
						<div class="col-sm-3">
							<a href="<?php the_permalink(); ?>">
								<?php 
								if ($image) {
									echo '<article class="post-image" style="background: url('.$image[0].') no-repeat scroll center / cover;">';
								} elseif(has_category("Videos")) {
									echo '<article class="post-image" style="background: url(http://img.youtube.com/vi/'.$videoID.'/sddefault.jpg) no-repeat scroll center / cover;">';
								} else {
									echo '<article class="post-image default-image" >';
								} ?>
								<?php echo '</article>'; ?>
								<h3><?php the_title(); ?></h3>
							</a>
						</div>
				<?php }
			?>
		</section>
	</div>

<?php } wp_reset_query(); ?>