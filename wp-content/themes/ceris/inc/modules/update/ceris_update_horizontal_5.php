<?php
if (!class_exists('ceris_update_horizontal_5')) {
    class ceris_update_horizontal_5 {
        
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
                    $bookmarkClass = 'active-status-bookmark';
                }else {
                    $bookmarkClass = '';
                }
            }else {
                $bookmarkClass = '';
            }
            ?>
            <article class="post post--horizontal <?php echo esc_attr($bookmarkClass);?> <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
                <?php if(ceris_core::bk_check_has_post_thumbnail($postID) && isset($postAttr['thumbSize']) && ($postAttr['thumbSize'] != '')) :?>
				    <div class="post__thumb <?php if(isset($postAttr['additionalThumbClass']) && ($postAttr['additionalThumbClass'] != null)) echo esc_attr($postAttr['additionalThumbClass']);?>">
                        <?php echo ceris_core::get_feature_image($postID, $postAttr['thumbSize'], true, $postIcon);?>
                    </div>
                <?php endif;?>
                <div class="post__text <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
                    <div class="post__text--wrap <?php if(isset($postAttr['additionalTextWrapClass']) && ($postAttr['additionalTextWrapClass'] != null)) echo esc_attr($postAttr['additionalTextWrapClass']);?>">
                        <div class="post__text--wrap-time-cat">
                            <?php if(isset($postAttr['cat']) && ($postAttr['cat'] != 0) && ($postAttr['cat'] != 1) && ($postAttr['cat'] != 2)) echo ceris_core::bk_get_post_cat_link($postID, $catClass);?>
                            <?php 
                                if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) :
                                    echo ceris_core::bk_get_post_meta($postAttr['meta']);
                                endif;
                            ?>
                        </div>
                        <h3 class="post__title <?php if(isset($postAttr['typescale'])) echo esc_attr($postAttr['typescale']);?>"><?php echo ceris_core::bk_get_post_title_link($postAttr['postID']);?></h3>
                        <?php if(isset($postAttr['except_length']) && ($postAttr['except_length'] != null)) :?>
    					<div class="post__excerpt <?php if(isset($postAttr['additionalExcerptClass']) && ($postAttr['additionalExcerptClass'] != null)) echo esc_attr($postAttr['additionalExcerptClass']);?>">
    						<?php echo ceris_core::bk_get_post_excerpt($postAttr['except_length']);?>
    					</div>
                        <?php endif;?>
                        <?php
                        if($bookmark == 'on') :
                            if(is_user_logged_in()) {
                                get_template_part( '/library/templates/bookmark/ceris-bookmark-user');
                            }else {
                                get_template_part( '/library/templates/bookmark/ceris-bookmark-guest');
                            }
                        else:
                                if (isset($postAttr['readmore']) && ($postAttr['readmore'] != '')) :
                            ?>
                            <div class="post__readmore">
                                <a href="<?php echo get_permalink($postID);?>" class="button__readmore">
                                    <span class="readmore__text"><?php esc_html_e('Read more','ceris'); ?><i class="mdicon mdicon-navigate_next"></i></span>
                                </a>
                            </div>        
                            <?php
                                endif;                                                    
                        endif;
                        ?>
                    </div>
                </div>
            </article>
            <?php return ob_get_clean();
        }
        
    }
}