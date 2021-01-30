<?php
if (!class_exists('ceris_update_vertical_1')) {
    class ceris_update_vertical_1 {
        
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
            if (isset($postAttr['thumbSize']) && ($postAttr['thumbSize'] != '')) :
                $thumbAttr = array (
                    'postID'        => $postID,
                    'thumbSize'     => $postAttr['thumbSize'],                                
                );
                $theBGLink = ceris_core::bk_get_post_thumbnail_bg_link($thumbAttr);
            endif;
            ?>
            <article class="post post--vertical <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
                <?php if(ceris_core::bk_check_has_post_thumbnail($postID) && isset($postAttr['thumbSize']) && ($postAttr['thumbSize'] != '')) :?>
				    <div class="post__thumb <?php if(isset($postAttr['additionalThumbClass'])) echo esc_attr($postAttr['additionalThumbClass']);?>">
                        <?php echo ceris_core::get_feature_image($postID, $postAttr['thumbSize'], true, $postIcon);?>
                    </div>
                <?php endif;?>
                <div class="post__text">
                    <?php if(isset($postAttr['cat']) && ($postAttr['cat'] != 0) && ($postAttr['cat'] != 2)) echo ceris_core::bk_get_post_cat_link($postID, $catClass);?>
                    <h3 class="post__title <?php echo esc_attr($postAttr['typescale']);?>"><?php echo ceris_core::bk_get_post_title_link($postAttr['postID']);?></h3>
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
                    <?php
                    if (isset($postAttr['readmore']) && ($postAttr['readmore'] != '')) :
                        ?>
                        <div class="post__readmore  <?php if(isset($postAttr['additionalTextReadMore']) && ($postAttr['additionalTextReadMore'] != null)) echo esc_attr($postAttr['additionalTextReadMore']);?>">
                            <a href="<?php echo get_permalink($postID);?>" class="button__readmore">
                                <span class="readmore__text"><?php esc_html_e('Read more', 'ceris');?></span>
                            </a>
                        </div>
                    <?php endif;?>
                </div>
            </article>
            <?php return ob_get_clean();
        }
        
    }
}