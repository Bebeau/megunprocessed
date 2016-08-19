<?php
global $post;
add_action('admin_init','times10_video_init');
function times10_video_init() {
    if(isset($_GET['action']) && $_GET['action'] === "edit") {
        // Add custom meta boxes to display video management
        $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
        $page = get_page_by_title('Unprocessed Productions');
        $page_id = strval($page->ID);
        // checks for post/page ID
        if ($post_id === $page_id) {
            add_action( 'add_meta_boxes', 'videos_meta_box', 1 );
            function videos_meta_box( $post ) {
                add_meta_box(
                    'videos', 
                    'Videos', 
                    'videos',
                    'page', 
                    'normal', 
                    'low'
                );
            }
            function videos($post) {
                // Use nonce for verification
                wp_nonce_field( 'videos', 'videos_noncename' );

                //get the saved meta as an arry
                $videos = get_post_meta($post->ID,'videos', true);
                echo '<p>Copy &amp; paste <a href="https://youtube.com/" alt="YouTube" target="_BLANK">YouTube</a> or <a href="https://vimeo.com/" alt="Vimeo" target="_BLANK">Vimeo</a> video links below and click "Add Video" to save. Once saved, videos will display below. Drag and drop the thumbnails to rearrange the order, and simply click the "x" to remove the video.</p>';
                echo '<section id="Videos">';
                    echo '<article class="link"> <i class="youtube"></i><input type="text" name="yt_video" value="" placeholder="https://www.youtube.com/watch?v=VIDEOID"/><button type="submit" class="button button-large">+ Add Video</button></article>';
                    echo '<article class="link"> <i class="vimeo"></i><input type="text" name="vimeo_video" value="" placeholder="https://www.vimeo.com/VIDEOID"/><button type="submit" class="button button-large">+ Add Video</button></article>';
                echo '</section>'; ?>
                <?php if ( !empty($videos) ) {
                    echo '<ul class="videoWrap sortable" data-post="'.$post->ID.'" data-type="videos">';
                        foreach( $videos as $key => $video ) {
                            if($video['type'] === "youtube") { ?>
                                <li class="video ui-state-default" data-key="<?php echo $key; ?>" data-order="<?php echo $video['id'];?>" data-video="youtube" data-link="https://www.youtube.com/watch?v=<?php echo $video['id']; ?>" style="background: url('https://i1.ytimg.com/vi/<?php echo $video['id']; ?>/hqdefault.jpg') no-repeat scroll center / cover;">
                                    <span class="button button-remove">X</span>
                                </li>
                            <?php } elseif($video['type'] === "vimeo") {
                                $imgid = $video['id'];
                                $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imgid.php"));
                                $thumb = $hash[0]['thumbnail_large'];
                            ?>
                            <li class="video ui-state-default" data-key="<?php echo $key; ?>" data-order="<?php echo $video['id'];?>" data-video="vimeo" data-link="https://www.vimeo.com/<?php echo $video['id']; ?>" style="background: url('<?php echo $thumb; ?>') no-repeat scroll center / contain;">
                                <span class="button button-remove">X</span>
                            </li>
                            <?php }
                        }
                    echo '</ul>';
                }
            }
        }
    }
}
/* When the post is saved, saves our custom data */
add_action( 'save_post', 'save_video_postdata' );
function save_video_postdata( $post_id ) {
    // check for commercial nonce
    if ( !isset( $_POST['videos_noncename'] ) || !wp_verify_nonce( $_POST['videos_noncename'], 'videos' ) )
        return;

    // save videos
    $videos  = get_post_meta($post_id,'videos', true);
    $yt_new  = $_POST['yt_video'];
    $vimeo_new  = $_POST['vimeo_video'];

    if(!empty($yt_new) || !empty($vimeo_new) ) {
        
        if($videos && $yt_new) {
            $old[] = array(
                    'id' => getVideoIdFromUrl($yt_new),
                    'type' => 'youtube'
                );
            $vids = array_merge($videos, $old);
        } elseif($videos && $vimeo_new) {
            $old[] = array(
                    'id' => getVideoIdFromUrl($vimeo_new),
                    'type' => 'vimeo'
                );
            $vids = array_merge($videos, $old);
        } elseif($yt_new) {
            $videos[] = array(
                    'id' => getVideoIdFromUrl($yt_new),
                    'type' => 'youtube'
                );
            $vids = $videos;
        } elseif($vimeo_new) {
            $videos[] = array(
                    'id' => getVideoIdFromUrl($vimeo_new),
                    'type' => 'vimeo'
                );
            $vids = $videos;
        }

        update_post_meta($post_id,'videos',$vids);
    }
    // update_post_meta($post_id,'videos',"");
}
// parse youtube/vimeo id from url submitted
function getVideoIdFromUrl($url) {
    $parts = parse_url($url);
    if(isset($parts['query'])){
        parse_str($parts['query'], $qs);
        if(isset($qs['v'])){
            return $qs['v'];
        }else if(isset($qs['vi'])){
            return $qs['vi'];
        }
    }
    if(isset($parts['path'])){
        $path = explode('/', trim($parts['path'], '/'));
        return $path[count($path)-1];
    }
    return false;
}

// ajax response to save download track
add_action('wp_ajax_removeItem', 'removeItem');
add_action('wp_ajax_nopriv_removeItem', 'removeItem');
function removeItem() {
    $postID = (isset($_GET['postID'])) ? $_GET['postID'] : 0;
    $key = (isset($_GET['key'])) ? $_GET['key'] : 0;
    $type = (isset($_GET['type'])) ? $_GET['type'] : 0;

    $array = get_post_meta($postID, $type, true );
    unset($array[$key]);

    update_post_meta($postID, $type, $array);
}
// ajax response to save order
add_action('wp_ajax_setOrder', 'setOrder');
add_action('wp_ajax_nopriv_setOrder', 'setOrder');
function setOrder() {
    $order = str_replace( array( '[', ']','"' ),'', $_GET['order'] );
    $postID = (isset($_GET['postID'])) ? $_GET['postID'] : 0;
    $type = (isset($_GET['type'])) ? $_GET['type'] : 0;
    update_post_meta($postID, $type, $order );
}

function list_videos($post) {
    $videos = get_post_meta($post->ID,'videos',true);

    if(!empty($videos)) {
        foreach($videos as $video) {
            
            if($video['type'] === "youtube") {
                echo '<div data-toggle="modal" class="singlevideo" data-type="youtube" data-video="'.$video['id'].'" style="background:url(https://i1.ytimg.com/vi/'.$video['id'].'/hqdefault.jpg) no-repeat scroll center / cover;" data-ibg-bg="https://i1.ytimg.com/vi/'.$video['id'].'/hqdefault.jpg">';
                    echo '<div class="playwrap"><i class="fa fa-play"></i></div>';
                    echo '<div class="outer"><div class="inner"></div></div>';
                    echo '<div class="close"><span class="bar"></span><span class="bar"></span></div>';
                echo '</div>';
            } elseif($video['type'] === 'vimeo') {
                $imgid = $video['id'];
                $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imgid.php"));
                $thumb = $hash[0]['thumbnail_large'];
                echo '<div data-toggle="modal" class="singlevideo" data-type="vimeo" data-video="'.$video['id'].'" style="background:url('.$thumb.') no-repeat scroll center / cover;" data-ibg-bg="'.$thumb.'">';
                    echo '<div class="playwrap"><i class="fa fa-play"></i></div>';
                    echo '<div class="outer"><div class="inner"></div></div>';
                    echo '<div class="close"><span class="bar"></span><span class="bar"></span></div>';
                echo '</div>';
            }
            
        }
    }
}

?>