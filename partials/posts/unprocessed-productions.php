<?php 
    $page = get_page_by_title('Unprocessed Productions');
    $videos_link = get_permalink($page->ID);
?>

<div class="videoCarousel">
    <div class="outer">
        <div class="inner">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <a href="<?php echo $videos_link; ?>">
                            <img class="upLogo" src="<?php echo bloginfo('template_directory');?>/assets/images/up_logo.png" alt="Unprocessed Productions" />
                        </a>
                        <p class="upDesc">Add a Professional Touch to Your Cooking, Crafting, DIY How-to, Lifestyle and Travel Videos.</p>
                    </div>
                </div>
            </div>
            <?php 
                $videos = get_post_meta(2075,'videos',true);
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
                }

            ?>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <a href="<?php echo $videos_link; ?>" class="btn">Get A Free Consultation</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>