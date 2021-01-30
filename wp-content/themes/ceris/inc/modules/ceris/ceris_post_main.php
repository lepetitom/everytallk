<?php
if (!class_exists('ceris_post_main')) {
    class ceris_post_main {
        
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
            $bypassPostIconDetech = 1;  
            if(isset($postAttr['postIcon']) && ($postAttr['postIcon'] != '')) {
                $postIcon = $postAttr['postIcon']; 
                $bypassPostIconDetech = 0;
            }else {
                $postIcon = '';
                $bypassPostIconDetech = 1;
            }
            if(isset($postAttr['meta_seperator']) && ($postAttr['meta_seperator'] != '')) {
                $metaSeperator = 1;
            }else {
                $metaSeperator = 0;
            }
            $thumbAttr = array (
                'postID'        => $postID,
                'thumbSize'     => $postAttr['thumbSize'],                                
            );

            $theBGLink = ceris_core::bk_get_post_thumbnail_bg_link($thumbAttr);
            ?> 
            
            <article class="post <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?> ">
               <?php if(ceris_core::bk_check_has_post_thumbnail($postID) && isset($postAttr['thumbSize']) && ($postAttr['thumbSize'] != '')) :?>
				    <div class="post__thumb <?php if(isset($postAttr['additionalThumbClass']) && ($postAttr['additionalThumbClass'] != null)) echo esc_attr($postAttr['additionalThumbClass']);?>">
                        <?php echo ceris_core::get_feature_image($postID, $postAttr['thumbSize'], true, '');?>
                    </div>
                <?php endif;?>
               <div class="post__text--wrap">
                   <div class="post__text inverse-text <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
                        <?php if(isset($postAttr['cat']) && ($postAttr['cat'] != 0) && ($postAttr['cat'] != 1) && ($postAttr['cat'] != 2)) echo ceris_core::bk_get_post_cat_link($postID, $catClass);?>
                        <h3 class="post__title <?php echo esc_attr($postAttr['typescale']);?>"><a href="<?php echo esc_url($bk_permalink);?>"><?php echo esc_attr($bk_post_title);?></a></h3>
                        <?php if(isset($postAttr['except_length']) && ($postAttr['except_length'] != null)) {?>
                            <div class="post__excerpt <?php if(isset($postAttr['additionalExcerptClass']) && ($postAttr['additionalExcerptClass'] != null)) echo esc_attr($postAttr['additionalExcerptClass']);?>">
        						<?php echo ceris_core::bk_get_post_excerpt($postAttr['except_length']);?>
        					</div>
                        <?php }?>
                        <?php if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) : ?>
                            <div class="post__meta">
                                <?php echo ceris_core::bk_get_post_meta($postAttr['meta']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                   <?php 
                    if(($postIcon != '') && (isset($postAttr['iconPosition'])) && ($postAttr['iconPosition'] == 'right-center')) :
                        echo ceris_core::bk_get_post_icon($postID, $postIcon);
                    endif;
                    ?>
               </div>
           </article>

            <?php return ob_get_clean();
            
        }
        
    }
}
?>
