<?php
if (!class_exists('ceris_post_horizontal_4')) {
    class ceris_post_horizontal_4 {
        
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
            $background_color = '';
            $background_color = $postAttr['background-color'];
            
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
            <article class="post post--horizontal <?php echo esc_attr($bookmarkClass);?> <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>"  <?php if($postAttr['background-color'] !=''): ?> style=" background-color: <?php echo esc_attr($background_color) ?> ; " <?php endif; ?>>
                <?php if(ceris_core::bk_check_has_post_thumbnail($postID) && isset($postAttr['thumbSize']) && ($postAttr['thumbSize'] != '')) :?>
				    <div class="post__thumb <?php if(isset($postAttr['additionalThumbClass']) && ($postAttr['additionalThumbClass'] != null)) echo esc_attr($postAttr['additionalThumbClass']);?>">
                        <?php echo ceris_core::get_feature_image($postID, $postAttr['thumbSize'], true, $postIcon);?>
                    </div>
                <?php endif;?>
                <div class="post__text <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
                    <div class="post__text-inner">
                        <?php if(isset($postAttr['cat']) && ($postAttr['cat'] != 0) && ($postAttr['cat'] != 1)) echo ceris_core::bk_get_post_cat_link($postID, $catClass);?>
    					<h3 class="post__title <?php echo esc_attr($postAttr['typescale']);?>"><?php echo ceris_core::bk_get_post_title_link($postAttr['postID']);?></h3>
                        <?php if(isset($postAttr['except_length']) && ($postAttr['except_length'] != null)) {?>
                            <div class="post__excerpt <?php if(isset($postAttr['additionalExcerptClass']) && ($postAttr['additionalExcerptClass'] != null)) echo esc_attr($postAttr['additionalExcerptClass']);?>">
        						<?php echo ceris_core::bk_get_post_excerpt($postAttr['except_length']);?>
        					</div>
                        <?php }?>
                        <?php 
                        if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) :
                            if($postAttr['meta'] != array('author')):
                        ?>
                                <div class="post__meta">
                                <?php
                                echo ceris_core::bk_get_post_meta($postAttr['meta']);
                                ?>
                                </div>
                                <?php else:?>
                                <span class="entry-author <?php if(isset($postAttr['additionalAuthorClass']) && ($postAttr['additionalAuthorClass'] != null)) echo esc_attr($postAttr['additionalAuthorClass']);?>">
                                    <?php 
                                        echo ceris_core::bk_get_post_meta($postAttr['meta']);
                                    ?>
                                </span>
                        <?php
                                endif;
                            endif;
                        ?>
                        
                        <?php
                        if($bookmark == 'on') :
                            if(is_user_logged_in()) {
                                get_template_part( '/library/templates/bookmark/ceris-bookmark-user');
                            }else {
                                get_template_part( '/library/templates/bookmark/ceris-bookmark-guest');
                            }                                                    
                        endif;
                        ?>
                    </div>
                </div>
            </article>
            <?php return ob_get_clean();
        }
        
    }
}