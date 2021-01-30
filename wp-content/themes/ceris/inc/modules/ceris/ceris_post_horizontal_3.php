<?php
if (!class_exists('ceris_post_horizontal_3')) {
    class ceris_post_horizontal_3 {
        
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
            <article class="post post--horizontal <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
                <?php if(ceris_core::bk_check_has_post_thumbnail($postID) && isset($postAttr['thumbSize']) && ($postAttr['thumbSize'] != '')) :?>
				    <div class="post__thumb <?php if(isset($postAttr['additionalThumbClass']) && ($postAttr['additionalThumbClass'] != null)) echo esc_attr($postAttr['additionalThumbClass']);?>">
                        <?php echo ceris_core::get_feature_image($postID, $postAttr['thumbSize'], true, '');?>
                    </div>
                <?php endif;?>
                <div class="post__text--wrap">
                    <div class="post__text <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
                        <?php if(isset($postAttr['cat']) && ($postAttr['cat'] != 0) && ($postAttr['cat'] != 1)) echo ceris_core::bk_get_post_cat_link($postID, $catClass);?>
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
                                <span class="readmore__text"><i class="mdicon mdicon-arrow_forward"></i></span>
                            </a>
                        </div>        
                        <?php
                            endif;
                        ?>
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