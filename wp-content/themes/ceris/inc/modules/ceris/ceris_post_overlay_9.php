<?php
if (!class_exists('ceris_post_overlay_9')) {
    class ceris_post_overlay_9 {
        
        function render($postAttr) {
            ob_start();
            global $ceris_DismissPage;
                        
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
            $theBGLink = ceris_core::bk_get_post_thumbnail_bg_link($thumbAttr);
            ?>
            
            <article class="post--overlay <?php echo esc_attr($bookmarkClass);?> <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
                <?php if(ceris_core::bk_check_has_post_thumbnail($postID) && isset($postAttr['thumbSize']) && ($postAttr['thumbSize'] != '')) :?>
				    <div class="post__thumb <?php if(isset($postAttr['additionalThumbClass']) && ($postAttr['additionalThumbClass'] != null)) echo esc_attr($postAttr['additionalThumbClass']); ?> <?php if(isset($postAttr['additionalBGClass']) && ($postAttr['additionalBGClass'] != null)) echo esc_attr($postAttr['additionalBGClass']);?>">
                        <?php echo ceris_core::get_feature_image($postID, $postAttr['thumbSize'], true, $postIcon);?>
                    </div>
                <?php endif;?>
                <div class="post__text  <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
                    <div class="post__text-wrap">
                        <?php if(isset($postAttr['cat']) && ($postAttr['cat'] != 0) && ($postAttr['cat'] != 1) && ($postAttr['cat'] != 2)) echo ceris_core::bk_get_post_cat_link($postID, $catClass);?>
                        <h3 class="post__title <?php echo esc_attr($postAttr['typescale']);?>"><a href="<?php echo esc_url($bk_permalink);?>"><?php echo esc_attr($bk_post_title);?></a></h3>
                        <!-- -->
                        <div class="post-meta--bookmark__wrap">                 
                        <?php if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) : ?>
                            <div class="post__meta">
                                <?php echo ceris_core::bk_get_post_meta($postAttr['meta']); ?>
                            </div>
                            <?php
                            if($ceris_DismissPage == 1) {
                                get_template_part( '/library/templates/bookmark/ceris-bookmark-user-dismiss');
                            }else {
                                if($bookmark == 'on') :
                                    if(is_user_logged_in()) {
                                        get_template_part( '/library/templates/bookmark/ceris-bookmark-user');
                                    }else {
                                        get_template_part( '/library/templates/bookmark/ceris-bookmark-guest');
                                    }
                                endif;
                            }
                            ?>  
                        <?php endif; ?>      
                        </div>                                                                                                             
                        <!-- -->                        
                    </div>
                </div>
            </article>

            <?php return ob_get_clean();
        }
        
    }
}