<?php
if (!class_exists('ceris_post_vertical_4')) {
    class ceris_post_vertical_4 {
        
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
            <article class="post post--vertical <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
               
                <?php if(ceris_core::bk_check_has_post_thumbnail($postID) && isset($postAttr['thumbSize']) && ($postAttr['thumbSize'] != '')) :?>
				    <div class="post__thumb <?php if(isset($postAttr['additionalThumbClass']) && ($postAttr['additionalThumbClass'] != null)) echo esc_attr($postAttr['additionalThumbClass']);?>">
                        <?php echo ceris_core::get_feature_image($postID, $postAttr['thumbSize'], true, $postIcon);?>
                    </div>
                <?php endif;?>
                <div class="post__text <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
                    <?php if(isset($postAttr['cat']) && ($postAttr['cat'] != 0) && ($postAttr['cat'] != 1) && ($postAttr['cat'] != 2)) echo ceris_core::bk_get_post_cat_link($postID, $catClass);?>
                    <div class="post__text--wrap <?php if(isset($postAttr['additionalTextWrapClass']) && ($postAttr['additionalTextWrapClass'] != null)) echo esc_attr($postAttr['additionalTextWrapClass']);?>">
                        <div class="post__text--column-1">
                            <h3 class="post__title <?php echo esc_attr($postAttr['typescale']);?>"><a href="<?php echo esc_url($bk_permalink);?>"><?php echo esc_attr($bk_post_title);?></a></h3>
                            <?php if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) : ?>
                                <div class="post__meta">
                                    <?php echo ceris_core::bk_get_post_meta($postAttr['meta']); ?>
                                </div>
                            <?php endif; ?>
                        </div><!-- post__text--column-1 -->
                        <div class="post__text--column-2">
                        <?php if(isset($postAttr['except_length']) && ($postAttr['except_length'] != null)) {?>
                        <div class="post__excerpt <?php if(isset($postAttr['additionalExcerptClass']) && ($postAttr['additionalExcerptClass'] != null)) echo esc_attr($postAttr['additionalExcerptClass']);?>">
    						<?php echo ceris_core::bk_get_post_excerpt($postAttr['except_length']);?>
    					</div>
                        <?php }?>
                        <?php
                        if (isset($postAttr['readmore']) && ($postAttr['readmore'] != '')) :
                            ?>
                            <div class="post__readmore  <?php if(isset($postAttr['additionalTextReadMore']) && ($postAttr['additionalTextReadMore'] != null)) echo esc_attr($postAttr['additionalTextReadMore']);?>">
                                <a href="<?php echo get_permalink($postID);?>" class="button__readmore">
                                    <span class="readmore__text"><?php esc_html_e('Read more', 'ceris');?></span>
                                    <i class="mdicon mdicon-arrow_forward"></i>
                                </a>
                            </div>
                        <?php endif;?>
                        </div><!-- post__text--column-2 -->
                    </div>
                </div>
            </article>
            <?php return ob_get_clean();
            
        }
        
    }
}
?>
