<?php
if (!class_exists('ceris_post_horizontal_2')) {
    class ceris_post_horizontal_2 {
        
        function render($postAttr) {
            ob_start();
            $postID = $postAttr['postID'];
            if(isset($postAttr['postIcon']) && ($postAttr['postIcon'] != '')) {
                $postIcon = $postAttr['postIcon']; 
            }else {
                $postIcon = '';
            }
            if(isset($postAttr['catClass']) && ($postAttr['catClass'] != '')) {
                $catClass = $postAttr['catClass']; 
            }else {
                $catClass = '';
            }
            ?>
            
            <article class="post post-horizontal <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
                <div class="post__thumb <?php if(isset($postAttr['additionalThumbClass']) && ($postAttr['additionalThumbClass'] != null)) echo esc_attr($postAttr['additionalThumbClass']);?>">
                    <?php echo ceris_core::get_feature_image($postID, $postAttr['thumbSize'], true, $postIcon);?>
                </div>
                <div class="post__text <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
                    <div class="post__text--wrap">
                        <?php if(isset($postAttr['cat']) && ($postAttr['cat'] != 0) && ($postAttr['cat'] != 1)) echo ceris_core::bk_get_post_cat_link($postID, $catClass);?>
					   <h3 class="post__title <?php echo esc_attr($postAttr['typescale']);?>"><?php echo ceris_core::bk_get_post_title_link($postAttr['postID']);?></h3>
                    </div>
                    <?php 
                        if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) :
                            if($postAttr['meta'] != array('author')):
                            ?>
                                <div class="post__meta post__meta-count-interactive">
                                <?php
                                echo ceris_core::bk_get_post_meta($postAttr['meta']);
                                ?>
                                </div>
                                <?php 
                                else:
                                
                                 ?>
                                <span class="entry-author <?php if(isset($postAttr['additionalAuthorClass']) && ($postAttr['additionalAuthorClass'] != null)) echo esc_attr($postAttr['additionalAuthorClass']);?>">
                                    <?php 
                                        echo ceris_core::bk_get_post_meta($postAttr['meta']);
                                    ?>
                                </span>
                        
                        <?php
                            endif;
                        endif;
                    ?>
                </div>
            </article>
            <?php return ob_get_clean();
        }
        
    }
}