<?php
if (!class_exists('ceris_post_nothumb_sidebar')) {
    class ceris_post_nothumb_sidebar {
        
        function render($postAttr) {
            ob_start();
            $postID = $postAttr['postID'];
            $bk_permalink = get_permalink($postID);
            $bk_post_title = get_the_title($postID);
            if(isset($postAttr['catClass']) && ($postAttr['catClass'] != '')) {
                $catClass = $postAttr['catClass']; 
            }else {
                $catClass = '';
            }
            if(isset($postAttr['postIcon']) && ($postAttr['postIcon'] != '')) {
                $postIcon = $postAttr['postIcon']; 
            }else {
                $postIcon = '';
            }
            if(isset($postAttr['meta_seperator']) && ($postAttr['meta_seperator'] != '')) {
                $metaSeperator = 1;
            }else {
                $metaSeperator = 0;
            }
            if(isset($postAttr['index']) && ($postAttr['index'] != '')) {
                $index = $postAttr['index']; 
            }else {
                $index = '';
            }
            ?>
            <article class="post">
                <div class="media">
                    <div class="media-left media-middle">
                        <span class="list-index"><?php echo esc_html($index); ?></span>
                    </div>
                    <div class="media-body media-middle">
                        <h3 class="post__title <?php echo esc_attr($postAttr['typescale']);?>"><a href="<?php echo esc_url($bk_permalink);?>"><?php echo esc_attr($bk_post_title);?></a></h3>
                    </div><!--End media-body-->
                </div><!--End media-->
            </article>

            <?php return ob_get_clean();
        }
        
    }
}