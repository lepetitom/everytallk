<?php
if (!class_exists('ceris_overlay_3')) {
    class ceris_overlay_3 {
        
        function render($postAttr) {
            ob_start();
            $postID = $postAttr['postID'];
            
            if(isset($postAttr['catClass']) && ($postAttr['catClass'] != '')) {
                $catClass = $postAttr['catClass']; 
            }else {
                $catClass = '';
            }
            
            $bk_permalink = get_permalink($postID);
            $bk_post_title = get_the_title($postID);
            $thumbAttr = array (
                'postID'        => $postID,
                'thumbSize'     => $postAttr['thumbSize'],                                
            );
            $theBGLink = ceris_core::bk_get_post_thumbnail_bg_link($thumbAttr);
            ?>
            <article class="post--overlay <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
				<div class="background-img <?php if(isset($postAttr['additionalBGClass']) && ($postAttr['additionalBGClass'] != null)) echo esc_attr($postAttr['additionalBGClass']);?>" style="background-image: url('<?php echo esc_url($theBGLink);?>');"></div>
				<div class="post__text inverse-text">
					<div class="post__text-wrap">
						<div class="post__text-inner <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
                            <?php if(isset($postAttr['cat']) && ($postAttr['cat'] != 0)) echo ceris_core::bk_get_post_cat_link($postID, $catClass);?>
                            <h3 class="post__title <?php if(isset($postAttr['typescale'])) echo esc_attr($postAttr['typescale']);?>"><?php echo ceris_core::bk_get_post_title_link(get_the_ID());?></h3>
                            <?php
                            if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) :
                                echo '<div class="post__meta">';
                                echo ceris_core::bk_get_post_meta($postAttr['meta']);
                                echo '</div>';
                            endif;
                            ?>
						</div>
					</div>
				</div>
                <?php 
                    if(isset($postAttr['postIcon']) && ($postAttr['postIcon'] != '')) :
                        echo ceris_core::bk_get_post_icon($postID, $postAttr['postIcon']);               
                    elseif(isset($postAttr['comment_box']) && (get_comments_number($postID) > 0)) :
                        echo '<a href="'.get_permalink($postID).'" title="'.ceris_core::bk_get_comment_number_and_text($postID).'" class="comments-count-box overlay-item">'.get_comments_number($postID).'</a>';                    
                    endif;
                ?>
				<a href="<?php echo esc_url($bk_permalink);?>" class="link-overlay"></a>
			</article>
            <?php return ob_get_clean();
        }
        
    }
}