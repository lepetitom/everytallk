<?php
if (!class_exists('ceris_update_overlay_8')) {
    class ceris_update_overlay_8 {
        
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
            $bk_permalink = get_permalink($postID);
            $thumbAttr = array (
                'postID'        => $postID,
                'thumbSize'     => $postAttr['thumbSize'],                                
            );
            $theBGLink = ceris_core::bk_get_post_thumbnail_bg_link($thumbAttr);
            ?>
            <article class="post post--overlay <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
                <div class="post__thumb <?php if(isset($postAttr['additionalThumbClass']) && ($postAttr['additionalThumbClass'] != null)) echo esc_attr($postAttr['additionalThumbClass']);?> <?php if(isset($postAttr['additionalBGClass']) && ($postAttr['additionalBGClass'] != null)) echo esc_attr($postAttr['additionalBGClass']);?>">
                    <?php echo ceris_core::get_feature_image($postID, $postAttr['thumbSize'], 'true', $postIcon);?>
                    <a href="<?php echo esc_url($bk_permalink);?>" class="link-overlay"></a>
                </div>
                <div class="post__text <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
                    <div class="post__text-inner">
                        <div class="post__text-inner-top">
                            <?php if(isset($postAttr['cat']) && ($postAttr['cat'] != null)) echo ceris_core::bk_get_post_cat_link($postID, $catClass);?>
                            <h3 class="post__title <?php if(isset($postAttr['typescale'])) echo esc_attr($postAttr['typescale']);?>"><?php echo ceris_core::bk_get_post_title_link(get_the_ID());?></h3>
                        </div>
                        <?php if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) : ?>
                        <span class="entry-author entry-author--horizontal item-justify-center <?php if(isset($postAttr['additionalAuthorClass']) && ($postAttr['additionalAuthorClass'] != null)) echo esc_attr($postAttr['additionalAuthorClass']);?>">
                            <?php 
                                echo ceris_core::bk_get_post_meta($postAttr['meta']);
                            ?>
                        </span>
                        <?php
                          endif;
                        ?>
                    </div>
                </div>
                
            </article>
            <?php return ob_get_clean();
        }
        
    }
}