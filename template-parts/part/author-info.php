<div class="author-info box">
    <span class="about-author"><?php echo esc_html__("About author","pcworms") ?></span>
    <?php echo get_avatar(get_the_author_meta( 'ID' ), 300);?>
    <span class="name"><?php echo get_the_author_meta('display_name')?></span>
    <div class="desc">
        <?php render_badges(get_the_author_meta('description'))?>
    </div>
</div>