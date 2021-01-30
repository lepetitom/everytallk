<?php
if (!class_exists('ceris_post_vertical_10')) {
    class ceris_post_vertical_10 {
        
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
            <article class="post post--vertical <?php echo esc_attr($bookmarkClass);?>  <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
                <?php if(ceris_core::bk_check_has_post_thumbnail($postID) && isset($postAttr['thumbSize']) && ($postAttr['thumbSize'] != '')) :?>
				    <div class="post__thumb <?php if(isset($postAttr['additionalThumbClass']) && ($postAttr['additionalThumbClass'] != null)) echo esc_attr($postAttr['additionalThumbClass']);?>">
                        <?php echo ceris_core::get_feature_image($postID, $postAttr['thumbSize'], true, $postIcon);?>
                    </div>
                <?php endif;?>
                <div class="post__text <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
                    <?php if(isset($postAttr['cat']) && ($postAttr['cat'] != 0) && ($postAttr['cat'] != 1) && ($postAttr['cat'] != 2)) echo ceris_core::bk_get_post_cat_link($postID, $catClass);?>
                    <h3 class="post__title <?php echo esc_attr($postAttr['typescale']);?>"><a href="<?php echo esc_url($bk_permalink);?>"><?php echo esc_attr($bk_post_title);?></a></h3>
                    <?php if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) : ?>
                        <div class="post__meta">
                            <?php echo ceris_core::bk_get_post_meta($postAttr['meta']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(isset($postAttr['except_length']) && ($postAttr['except_length'] != null)) {?>
                        <div class="post__excerpt <?php if(isset($postAttr['additionalExcerptClass']) && ($postAttr['additionalExcerptClass'] != null)) echo esc_attr($postAttr['additionalExcerptClass']);?>">
    						<?php echo ceris_core::bk_get_post_excerpt($postAttr['except_length']);?>
    					</div>
                    <?php }?>
                    <div class="post-footer">
                        <div class="entry-more">
                            <a href="<?php echo esc_url(get_permalink($postID));?>"><?php esc_html_e('Continue reading', 'ceris');?>
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="16px" height="9px" viewBox="0 0 1638 1024"><path d="M1024.568 730.231v-436.531l327.373 218.317-327.373 218.214zM1593.4 426.717l-614.4-409.498c-31.437-20.992-71.885-22.938-105.165-5.12-33.28 17.92-54.067 52.531-54.067 90.214v307.2c0 0.307 0 0.614 0 0.819h-718.336c-56.627 0-102.4 45.773-102.4 102.4s45.773 102.4 102.4 102.4h718.336v306.483c0 37.683 20.787 72.397 54.067 90.214 15.155 8.192 31.846 12.186 48.333 12.186 19.866 0 39.731-5.837 56.832-17.203l614.4-409.702c28.467-18.944 45.568-50.893 45.568-85.094 0-34.304-17.101-66.253-45.568-85.299v0z"></path></svg>
                            </a>
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
                    </div>
                    <?php 
                        if (isset($postAttr['readmore']) && ($postAttr['readmore'] != '')) :
                    ?>
                    <div class="post__readmore  <?php if(isset($postAttr['additionalTextReadMore']) && ($postAttr['additionalTextReadMore'] != null)) echo esc_attr($postAttr['additionalTextReadMore']);?>">
                        <a href="<?php echo get_permalink($postID);?>" class="button__readmore">
                            <span class="readmore__text"><?php esc_html_e('Read more', 'ceris');?></span>
                        </a>
                    </div>        
                    <?php
                        endif;
                    ?>
                </div>
            </article>
            <?php return ob_get_clean();
            
        }
        
    }
}
?>
