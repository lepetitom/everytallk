<?php
if (!class_exists('ceris_overlay_1')) {
    class ceris_overlay_1 {
        
        function render($postAttr) {
            ob_start();
            global $ceris_DismissPage;
                                                
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
            $bk_post_title = get_the_title($postID);
            $thumbAttr = array (
                'postID'        => $postID,
                'thumbSize'     => $postAttr['thumbSize'],                                
            );
            $theBGLink = ceris_core::bk_get_post_thumbnail_bg_link($thumbAttr);
            
            if(isset($postAttr['bookmark']) && ($postAttr['bookmark'] != '')) {
                $bookmark = $postAttr['bookmark']; 
            }else {
                $bookmark = '';
            }
            
            if(($bookmark == 'on') && is_user_logged_in()) {
                $userID = get_current_user_id();    
                $bookmarkData = get_user_meta( $userID, 'atbs_posts_bookmarked', true );
                
                if($bookmarkData == '') {
                    $bookmarkData = array();
                }
                
                if( in_array(intval($postID), $bookmarkData)) {
                    $bookmarkClass = 'active-status-bookmark bookmark__notice_align_right';
                }else {
                    $bookmarkClass = 'bookmark__notice_align_right';
                }
            }else {
                $bookmarkClass = 'bookmark__notice_align_right';
            }
            ?>
            <article class="post--overlay <?php echo esc_attr($bookmarkClass);?> <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
				<?php if(ceris_core::bk_check_has_post_thumbnail($postID) && isset($postAttr['thumbSize']) && ($postAttr['thumbSize'] != '')) :?>
				    <div class="post__thumb <?php if(isset($postAttr['additionalThumbClass']) && ($postAttr['additionalThumbClass'] != null)) echo esc_attr($postAttr['additionalThumbClass']); ?> <?php if(isset($postAttr['additionalBGClass']) && ($postAttr['additionalBGClass'] != null)) echo esc_attr($postAttr['additionalBGClass']);?>">
                        <?php echo ceris_core::get_feature_image($postID, $postAttr['thumbSize'], '', $postIcon);?>
                        <?php 
                            if($postIcon != '') :
                                echo ceris_core::bk_get_post_icon($postID, $postIcon);
                            endif;
                        ?>
                    </div>
                <?php endif;?>
				<div class="post__text inverse-text">
					<div class="post__text-wrap">
						<div class="post__text-inner <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
							<?php if(isset($postAttr['cat']) && ($postAttr['cat'] != 0) && ($postAttr['cat'] != '1')) echo ceris_core::bk_get_post_cat_link($postID, $catClass);?>
                            <h3 class="post__title <?php if(isset($postAttr['typescale'])) echo esc_attr($postAttr['typescale']);?>"><?php echo ceris_core::bk_get_post_title_link(get_the_ID());?></h3>
                			<?php if(isset($postAttr['except_length']) && ($postAttr['except_length'] != null)) {?>
                            <div class="post__excerpt <?php if(isset($postAttr['additionalExcerptClass']) && ($postAttr['additionalExcerptClass'] != null)) echo esc_attr($postAttr['additionalExcerptClass']);?>">
        						<?php echo ceris_core::bk_get_post_excerpt($postAttr['except_length']);?>
        					</div>
                            <?php }?>
                            <?php if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) :?>
                                <?php if (isset($postAttr['footerType']) && ($postAttr['footerType'] == '2-cols')) :?>
                    				<div class="post__meta <?php if(isset($postAttr['additionalMetaClass']) && ($postAttr['additionalMetaClass'] != null)) echo esc_attr($postAttr['additionalMetaClass']);?>">
                    					<div class="post__meta-left">
                    						<?php echo ceris_core::bk_meta_cases($postAttr['meta'][0]);?>
                    					</div>
                    					<div class="post__meta-right">
                    						<?php echo ceris_core::bk_meta_cases($postAttr['meta'][1]);?>
                    					</div>
                    				</div>
                                <?php else:?>
                                    <div class="post__meta <?php if(isset($postAttr['additionalMetaClass']) && ($postAttr['additionalMetaClass'] != null)) echo esc_attr($postAttr['additionalMetaClass']);?>">
                    					<?php 
                                            if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) :
                                                echo ceris_core::bk_get_post_meta($postAttr['meta']);
                                            endif;
                                        ?>
                    				</div>
                                <?php endif;?>
                            <?php endif;?>
						</div>
					</div>
				</div>
                <?php 
                if($postIcon != '') :
                    echo ceris_core::bk_get_post_icon($postID, $postIcon);
                endif;
                ?>
				<a href="<?php echo esc_url($bk_permalink);?>" class="link-overlay"></a>
                <?php if(isset($postAttr['cat']) && ($postAttr['cat'] == '1')) echo ceris_core::bk_get_post_cat_link($postID, $catClass);?>
                <?php
                if($ceris_DismissPage == 1) {
                    echo '<div class="inverse-text bookmark__buttons-section">';
                    get_template_part( '/library/templates/bookmark/ceris-bookmark-user-dismiss');
                    echo '</div>';
                }else {
                    if($bookmark == 'on') :
                        echo '<div class="inverse-text bookmark__buttons-section">';
                        if(is_user_logged_in()) {
                            get_template_part( '/library/templates/bookmark/ceris-bookmark-user');
                        }else {
                            get_template_part( '/library/templates/bookmark/ceris-bookmark-guest');
                        }
                        echo '</div>';
                    endif;
                }
                ?>     
			</article>
            <?php return ob_get_clean();
        }
        
    }
}