<?php
$post = get_post();
$title = $post->post_title;
$ID = get_the_ID();
$content = $post->post_content;
Console_log([
    "title"=>$title,
    "ID"=>$ID,
    "content"=>$content,
    "summery"=>$summery
    ])
?>
<div class="item<?php echo ($args['counter'] == 0) ? ' active' : ''; ?>">
    <div class="post-slide">
        <a href="#post-<?php echo $ID?>"><h3><?php echo $title;?></h3></a>
        <?php echo $content?>
        <a class="btn light-blue" href="#post-<?php echo $ID?>" role="button">خواندن مطلب</a>
    </div>
</div>