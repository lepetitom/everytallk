<?php
if (!class_exists('atbs_card_1')) {
    class atbs_card_1 {
        
        function render($postAttr) {
            ob_start();
            $postID = $postAttr['postID'];
            $bk_permalink = get_permalink($postID);
            $bk_post_title = get_the_title($postID);
            $thumbAttr = array (
                'postID'        => $postID,
                'thumbSize'     => $postAttr['thumbSize'],                                
            );
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
            $theBGLink = ceris_core::bk_get_post_thumbnail_bg_link($thumbAttr);
            ?>
            <article class="post post--card <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
				<div class="post__thumb <?php if(isset($postAttr['additionalThumbClass']) && ($postAttr['additionalThumbClass'] != null)) echo esc_attr($postAttr['additionalThumbClass']);?>">
					<?php echo ceris_core::get_feature_image($postID, $postAttr['thumbSize'], true, '');?>
                    <?php if(isset($postAttr['cat']) && ($postAttr['cat'] == 2)) echo ceris_core::bk_get_post_cat_link($postID, $catClass);?>
				    <?php 
                    if($postIcon != '') :
                        echo ceris_core::bk_get_post_icon($postID, $postIcon);
                    else :
                        if(get_comments_number($postID) > 0) {
                            echo '<a href="'.get_permalink($postID).'" title="'.ceris_core::bk_get_comment_number_and_text($postID).'" class="comments-count-box overlay-item">'.get_comments_number($postID).'</a>';
                        }
                    endif;
                    ?>
                </div>
				<div class="post__text <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
					<?php if(isset($postAttr['cat']) && ($postAttr['cat'] != 0) && ($postAttr['cat'] != 1) && ($postAttr['cat'] != 2)) echo ceris_core::bk_get_post_cat_link($postID, $catClass);?>
                    <h3 class="post__title <?php if(isset($postAttr['typescale'])) echo esc_attr($postAttr['typescale']);?>"><?php echo ceris_core::bk_get_post_title_link($postAttr['postID']);?></h3>
				</div>
                <?php if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) :?>
                    <?php if (isset($postAttr['footerType']) && ($postAttr['footerType'] == '2-cols')) :?>
        				<div class="post__footer">
        					<div class="post__footer-left post__meta">
        						<?php echo ceris_core::bk_meta_cases($postAttr['meta'][0]);?>
        					</div>
        					<div class="post__footer-right post__meta">
        						<?php echo ceris_core::bk_meta_cases($postAttr['meta'][1]);?>
        					</div>
        				</div>
                    <?php else:?>
                        <div class="post__footer text-center">
                            <div class="post__meta">
        					<?php 
                                echo ceris_core::bk_get_post_meta($postAttr['meta']);
                            ?>
                            </div>
        				</div>
                    <?php endif;?>
                <?php endif;?>
                <?php if(isset($postAttr['cat']) && ($postAttr['cat'] == 1)) echo ceris_core::bk_get_post_cat_link($postID, $catClass);?>
			</article>
            
            
            <?php return ob_get_clean();
        }
        
    }
}