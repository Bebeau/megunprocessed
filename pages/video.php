<?php 

/*
Template Name: Unprocessed Productions
*/

get_header(); ?>

	<section class="container-fluid" id="Videos">
        <div class="videoWrap">
    		<div class="videoCopy">
                <div class="outer">
                    <div class="inner">
                        <div class="visible-xs">
                            <img class="videoImageMobile" src="<?php echo bloginfo('template_directory'); ?>/assets/images/cameraman.jpg" alt="" />
                        </div>
            			<img src="<?php echo bloginfo('template_directory'); ?>/assets/images/up_logo.jpg" alt="" />
                        <?php the_content(); ?>
                        <a href="#videoConsultation" class="btn">Get A Free Consultation</a>
                    </div>
                </div>
    		</div>
            <div class="videoImage"></div>
        </div>
        <div class="videoCarousel">
            <div class="outer">
                <div class="inner">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <h2 class="secTitle"><span>Our Work</span></h2>
                            </div>
                        </div>
                    </div>
                    <?php 
                        $videos = get_post_meta($post->ID,'videos',true);
                        if(!empty($videos)) {
                            echo '<div class="m-scooch m-scooch-videos">'; ?>

                                <div class="arrows m-scooch-controls">
                                    <i class="arrow left fa fa-angle-left" data-m-slide="prev"></i>
                                    <i class="arrow right fa fa-angle-right" data-m-slide="next"></i>
                                </div>

                                <?php 
                                echo '<div class="m-scooch-inner">';
                                    $count = 1;
                                    $c = 1;
                                    $total = count($videos);
                                    foreach($videos as $video) {

                                        if(wp_is_mobile()) {
                                            
                                            if($video['type'] === "youtube") {
                                                echo '<iframe src="https://www.youtube.com/embed/'.$video['id'].'" class="m-item videoFrame" width="100%" frameborder="0" allowfullscreen></iframe>';
                                            } elseif($video['type'] === 'vimeo') {
                                                echo '<iframe src="https://player.vimeo.com/video/'.$video['id'].'" class="m-item videoFrame" width="100%" frameborder="0" allowfullscreen></iframe>';
                                            }

                                        } else {

                                            if($video['type'] === "youtube") {
                                                echo '<a href="#videomodal" data-toggle="modal" class="singlevideo video square-'.$c.' m-item" data-type="youtube" data-video="'.$video['id'].'" style="background:url(https://i1.ytimg.com/vi/'.$video['id'].'/hqdefault.jpg) no-repeat scroll center / cover;">';
                                                    echo '<div class="playwrap"><i class="fa fa-play"></i></div>';
                                                    echo '<div class="outer"><div class="inner"></div></div>';
                                                echo '</a>';
                                            } elseif($video['type'] === 'vimeo') {
                                                $imgid = $video['id'];
                                                $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imgid.php"));
                                                $thumb = $hash[0]['thumbnail_large'];
                                                echo '<a href="#videomodal" data-toggle="modal" class="singlevideo video square-'.$c.' m-item" data-type="vimeo" data-video="'.$video['id'].'" style="background:url('.$thumb.') no-repeat scroll center / cover;" data-ibg-bg="'.$thumb.'">';
                                                    echo '<div class="playwrap"><i class="fa fa-play"></i></div>';
                                                    echo '<div class="outer"><div class="inner"></div></div>';
                                                echo '</a>';
                                            }

                                        }
                                    }
                                echo '</div>';
                            echo '</div>';
                            echo '<div class="mobile">';
                                foreach($videos as $video) {

                                    if(wp_is_mobile()) {
                                        
                                        if($video['type'] === "youtube") {
                                            echo '<iframe src="https://www.youtube.com/embed/'.$video['id'].'" class="videoFrame" width="100%" frameborder="0" allowfullscreen></iframe>';
                                        } elseif($video['type'] === 'vimeo') {
                                            echo '<iframe src="https://player.vimeo.com/video/'.$video['id'].'" class="videoFrame" width="100%" frameborder="0" allowfullscreen></iframe>';
                                        }

                                    }

                                }
                            echo '</div>';
                        }

                    ?>
                    <a href="#videoConsultation" class="btn">Get A Free Consultation</a>
                </div>
            </div>
        </div>
        <div class="videoTestimonials">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="secTitle"><span>What They're Saying...</span></h2>
                    </div>
                </div>
            </div>
            <?php 
                query_posts( array(
                        'order' => 'DESC',
                        'post_type' => 'testimonials'
                    )
                );
                if (have_posts()) :
                    echo '<div class="m-scooch m-fluid m-scooch-testimonials">';
                        echo '<div class="m-scooch-inner">';
                            while (have_posts()) : the_post();

                            $name = get_post_meta($post->ID,'testimonial_name', true);
                            $title = get_post_meta($post->ID,'testimonial_title', true);
                            $company = get_post_meta($post->ID,'testimonial_company', true);

                            if(!empty($name) && !empty($title) && !empty($company)) {
                                echo '<div class="m-item active">';
                                    echo '<div class="wrap">';
                                        echo '<cite class="hidden-xs">';
                                            the_post_thumbnail();
                                            echo '<span class="name">'.$name.'</span>';
                                            echo '<span class="title">'.$title.'</span>';
                                            echo '<span class="company">'.$company.'</span>';
                                        echo '</cite>';
                                        echo '<blockquote>';
                                            echo '<div class="outer"><div class="inner">';
                                                the_content();
                                            echo '</div></div>';
                                        echo '</blockquote>';
                                        echo '<cite class="visible-xs">';
                                            the_post_thumbnail();
                                            echo '<span class="name">'.$name.'</span>';
                                            echo '<span class="title">'.$title.'</span>';
                                            echo '<span class="company">'.$company.'</span>';
                                        echo '</cite>';
                                    echo '</div>';
                                echo '</div>';
                            }
                            endwhile;
                        echo '</div>';
                endif;
                $c = 1;
                if (have_posts()) : 
                    echo '<div class="m-scooch-controls m-scooch-bulleted">';
                    while (have_posts()) : the_post();
                    echo '<a href="" data-m-slide="'.$c.'"></a>';
                    $c++;
                    endwhile;
                    echo '</div></div>';
                endif;
                wp_reset_query();
            ?>
        </div>
        <div class="videoServices">
            <div class="outer">
                <div class="inner">
                    <div class="container">
                        <h2 class="secTitle"><span>Services</span></h2>
                        <div class="row">
                            <div class="service col-md-6">
                                <h3><i class="fa fa-line-chart"></i> Business Video Marketing</h3>
                                <p>Online marketing drives today’s business, which is why we specialize in innovative digital business videos to promote your company and brand across a range of online platforms including YouTube, Kickstarter and more.</p>
                            </div>
                            <div class="service col-md-6">
                                <h3><i class="fa fa-briefcase"></i> Internal Corporate Videos</h3>
                                <p>High-quality videos are essential for maintaining brand image. We will help you create effective training and compliance videos that will clearly communicate your company’s mission to employees.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="service col-md-6">
                                <h3><i class="fa fa-camera"></i> Still Photography</h3>
                                <p>We offer portrait, event and commercial photography services that will complement your company’s online portfolio. Promote your business or ad campaign by adding still pictures to your digital videos.</p>
                            </div>
                            <div class="service col-md-6">
                                <h3><i class="fa fa-video-camera"></i> Website Videos</h3>
                                <p>Use compelling, high-quality video content to appeal to your customers and drive more traffic to your website. We will work with you to develop website videos that highlight your company’s best assets using action shots, motion graphics, interviews and more.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="service col-md-6">
                                <h3><i class="fa fa-film"></i> Video Editing</h3>
                                <p>If you have video footage from a prior shoot or a lot of footage to compile together, we can work with you to edit a piece that will best market your company and its products. Give your videos a boost with our services to ensure you are set up for success.</p>
                            </div>
                            <div class="service col-md-6">
                                <h3><i class="fa fa-calendar"></i> Event Coverage</h3>
                                <p>Event videos are perfect for displaying your connection to customers and promoting upcoming events. Show clients what you have been up to and how you will meet their needs with high-quality videos.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="videoConsultation">
            <div class="outer">
                <div class="inner">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <h2 class="secTitle"><span>Get A Free Consultation</span></h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <form role="form" action="" id="consultationfrm" data-form="consultation">
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="firstname" class="control-label">First Name <span class="required">*</span></label>
                                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="jane"/>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="lastname" class="control-label">Last Name <span class="required">*</span></label>
                                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="doe"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="emailaddress" class="control-label">Email <span class="required">*</span></label>
                                        <input type="text" name="emailaddress" id="emailaddress" class="form-control" placeholder="email@address.." />
                                    </div>
                                    <div class="form-group">
                                        <label for="message" class="control-label">Message <span class="required">*</span></label>
                                        <textarea type="text" name="message" id="message" class="form-control" placeholder="How can I help?"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-submit">Submit</button>
                                    </div>
                                    <input type="hidden" name="password" id="password" val="" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</section>

<?php 

get_footer(); ?>