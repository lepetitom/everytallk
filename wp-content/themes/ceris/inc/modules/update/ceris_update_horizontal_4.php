<?php
if (!class_exists('ceris_update_horizontal_4')) {
    class ceris_update_horizontal_4 {
        
        function render($postAttr) {
            ob_start();
            $postID = $postAttr['postID'];
            $bk_permalink = get_permalink($postID);
            $bk_post_title = get_the_title($postID);
            
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
            $thumbAttr = array (
                'postID'        => $postID,
                'thumbSize'     => $postAttr['thumbSize'],                                
            );
            $theBGLink = ceris_core::bk_get_post_thumbnail_bg_link($thumbAttr);
            ?>
            <article class="post post--horizontal <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
                <div class="post__thumb <?php if(isset($postAttr['additionalThumbClass']) && ($postAttr['additionalThumbClass'] != null)) echo esc_attr($postAttr['additionalThumbClass']);?>">
                    <?php echo ceris_core::get_feature_image($postID, $postAttr['thumbSize'], true, $postIcon);?>
                </div>
                <div class="post__text <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
                    <div class="post__text--wrap <?php if(isset($postAttr['additionalTextWrapClass']) && ($postAttr['additionalTextWrapClass'] != null)) echo esc_attr($postAttr['additionalTextWrapClass']);?>">
                        <?php if(isset($postAttr['cat']) && ($postAttr['cat'] != 0)) echo ceris_core::bk_get_post_cat_link($postID, $catClass);?>
                        <h3 class="post__title <?php if(isset($postAttr['typescale'])) echo esc_attr($postAttr['typescale']);?>"><?php echo ceris_core::bk_get_post_title_link($postAttr['postID']);?></h3>
                        <?php if(isset($postAttr['except_length']) && ($postAttr['except_length'] != null)) :?>
    					<div class="post__excerpt <?php if(isset($postAttr['additionalExcerptClass']) && ($postAttr['additionalExcerptClass'] != null)) echo esc_attr($postAttr['additionalExcerptClass']);?>">
    						<?php echo ceris_core::bk_get_post_excerpt($postAttr['except_length']);?>
    					</div>
                        <?php endif;?>
                        <?php if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) : ?>
                            <div class="post__meta">
                                <?php echo ceris_core::bk_get_post_meta($postAttr['meta']); ?>
                            </div>
                        <?php endif; ?>
                        <?php 
                            if (isset($postAttr['readmore']) && ($postAttr['readmore'] != '')) :
                        ?>
                        <div class="post__readmore">
                            <a href="<?php echo get_permalink($postID);?>" class="button__readmore">
                                <span class="readmore__text"><?php esc_html_e('Read more','ceris'); ?><i class="mdicon mdicon-navigate_next"></i></span>
                            </a>
                        </div>        
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