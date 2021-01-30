<?php
if (!class_exists('ceris_update_overlay_2')) {
    class ceris_update_overlay_2 {
        
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
            <article class="post post--overlay <?php echo esc_attr($bookmarkClass);?> <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
                <div class="post__thumb <?php if(isset($postAttr['additionalThumbClass']) && ($postAttr['additionalThumbClass'] != null)) echo esc_attr($postAttr['additionalThumbClass']);?> <?php if(isset($postAttr['additionalBGClass']) && ($postAttr['additionalBGClass'] != null)) echo esc_attr($postAttr['additionalBGClass']);?>">
                    <?php echo ceris_core::get_feature_image($postID, $postAttr['thumbSize'], '', '');?>
                </div>
                <div class="post__text <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
                    <div class="post__text-inner <?php if(isset($postAttr['additionalTextInnerClass']) && ($postAttr['additionalTextInnerClass'] != null)) echo esc_attr($postAttr['additionalTextInnerClass']);?>">
                        <?php if(isset($postAttr['cat']) && ($postAttr['cat'] != null)) echo ceris_core::bk_get_post_cat_link($postID, $catClass);?>
                        <h3 class="post__title <?php if(isset($postAttr['typescale'])) echo esc_attr($postAttr['typescale']);?>"><?php echo ceris_core::bk_get_post_title_link(get_the_ID());?></h3>
                        <?php if(isset($postAttr['except_length']) && ($postAttr['except_length'] != null)) {?>
                        <div class="post__excerpt <?php if(isset($postAttr['additionalExcerptClass']) && ($postAttr['additionalExcerptClass'] != null)) echo esc_attr($postAttr['additionalExcerptClass']);?>">
    						<?php echo ceris_core::bk_get_post_excerpt($postAttr['except_length']);?>
    					</div>
                        <?php }?>
                        <?php
                            if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) :
                                echo '<div class="post__meta">';
                                echo ceris_core::bk_get_post_meta($postAttr['meta']);
                                echo '</div>';
                            endif;
                        ?>
                    </div>
                    <?php 
                    if(($postIcon != '') && (isset($postAttr['iconPosition'])) && ($postAttr['iconPosition'] == 'right-center')) :
                        echo ceris_core::bk_get_post_icon($postID, $postIcon);
                    endif;
                    ?>
                </div>
                <a href="<?php echo get_permalink($postID);?>" class="link-overlay"></a>

                <?php
                if(($postIcon != '') && ((!isset($postAttr['iconPosition'])) || ($postAttr['iconPosition'] == ''))) :
                    echo ceris_core::bk_get_post_icon($postID, $postIcon);
                endif;
                ?>
                
            </article>
            <?php return ob_get_clean();
        }
        
    }
}