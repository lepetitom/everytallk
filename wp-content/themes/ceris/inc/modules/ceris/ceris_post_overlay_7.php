<?php
if (!class_exists('ceris_post_overlay_7')) {
    class ceris_post_overlay_7 {
        
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
            $thumbAttr = array (
                'postID'        => $postID,
                'thumbSize'     => $postAttr['thumbSize'],                                
            );
            $theBGLink = ceris_core::bk_get_post_thumbnail_bg_link($thumbAttr);
            ?>

            <article class="post--overlay <?php if(!(ceris_core::bk_check_has_post_thumbnail($postID) && isset($postAttr['thumbSize']) && ($postAttr['thumbSize'] != ''))): echo 'post-not-exist-thumb'; endif;?> <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
                <?php if( isset($postAttr['thumbSize']) && ($postAttr['thumbSize'] != '')) :?>
                    <div class="post__thumb <?php if(isset($postAttr['additionalThumbClass']) && ($postAttr['additionalThumbClass'] != null)) echo esc_attr($postAttr['additionalThumbClass']);?>">
                        <?php echo ceris_core::get_feature_image($postID, $postAttr['thumbSize'], true, $postIcon);?>
                    </div>
                <?php endif;?>
                <div class="post__text <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
                    <div class="post__text-wrap">
                        <div class="post__text-inner ">
                            <div class="post--overlay-head post--overlap-header">
                                <?php if(isset($postAttr['cat']) && ($postAttr['cat'] != 0) && ($postAttr['cat'] != 1) && ($postAttr['cat'] != 2)) echo ceris_core::bk_get_post_cat_link($postID, $catClass);?>
                                <h3 class="post__title <?php echo esc_attr($postAttr['typescale']);?>"><a href="<?php echo esc_url($bk_permalink);?>"><?php echo esc_attr($bk_post_title);?></a></h3>
                            </div>
                            <div class="post--overlay-footer flexbox-wrap">
                                <?php if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) : ?>
                                    <div class="post__meta">
                                        <?php echo ceris_core::bk_get_post_meta($postAttr['meta']); ?>
                                    </div>
                                <?php endif; ?>      
                                <?php if (isset($postAttr['readmore']) && ($postAttr['readmore'] != '')) : ?>
                                <div class="post__readmore text-center">
                                    <a href="<?php echo get_permalink($postID);?>" class="button__readmore flexbox-wrap flexbox-center-xy">
                                        <span class="readmore__text button__readmore--round"><i class="mdicon mdicon-arrow_forward"></i></span>
                                    </a>
                                </div>    
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="<?php echo get_permalink($postID);?>" class="link-overlay"></a>
            </article>

            <?php return ob_get_clean();
        }
        
    }
}