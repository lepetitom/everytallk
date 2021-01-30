<?php
$postID = get_the_ID();
?>
<footer class="single-footer entry-footer">
    <div class="entry-interaction entry-interaction--horizontal">
        <div class="entry-interaction__left">
            <div class="entry-tags">
                <ul>
                    <?php
                    $tags = get_the_tags();
                    if($tags != '') :
                    ?>
                    <?php
                        foreach ($tags as $tag):
                			echo '<li><a class="post-tag" rel="tag" href="'. get_tag_link($tag->term_id) .'">'. $tag->name.'</a></li>';
                		endforeach;
                    ?>
                    <?php endif;?>
                </ul>
            </div>
        </div>
        <div class="entry-interaction__right">
            <?php
                if (defined('CERIS_FUNCTIONS_PLUGIN_DIR')) {
                    echo ceris_single::bk_entry_comments($postID);
                    echo ceris_single::bk_entry_views($postID);
                }else {
                    echo ceris_single::bk_entry_comments($postID);
                }
            ?>
        </div>
    </div>
    
</footer>