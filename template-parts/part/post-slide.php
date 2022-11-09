<?php
$post = get_post();
$title = $post->post_title;
$ID = get_the_ID();
// $content = $post->post_content;
$post_id = get_the_ID();
$post_field = get_post_field( 'post_content', $post_id );
$content_parts = get_extended( $post_field );
$content = $content_parts['main'];
$content = apply_filters( 'the_content', $content );
?>
<div class="carousel-item<?php echo ($args['counter'] == 0) ? ' active' : ''; ?>">
    <div class="post-slide">
        <a href="#post-<?php echo $ID?>"><h3><?php echo $title;?></h3></a>
        <?php echo $content?>
        <a class="btn light-green" href="#post-<?php echo $ID?>" role="button">خواندن مطلب</a>
    </div>
</div>