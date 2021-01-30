<?php
if (!class_exists('ceris_post_nothumb_1')) {
    class ceris_post_nothumb_1 {
           function render($postAttr) {
            ob_start();
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
            <article class="post posts-no-thumb <?php echo esc_attr($bookmarkClass);?> <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
                <div class="post__text <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
                    <?php if(isset($postAttr['cat']) && ($postAttr['cat'] != 0) && ($postAttr['cat'] != 1) && ($postAttr['cat'] != 2)) echo ceris_core::bk_get_post_cat_link($postID, $catClass);?>
                    <h3 class="post__title <?php echo esc_attr($postAttr['typescale']);?>"><a href="<?php echo esc_url($bk_permalink);?>"><?php echo esc_attr($bk_post_title);?></a></h3>
                    <?php if(isset($postAttr['except_length']) && ($postAttr['except_length'] != null)) {?>
                        <div class="post__excerpt <?php if(isset($postAttr['additionalExcerptClass']) && ($postAttr['additionalExcerptClass'] != null)) echo esc_attr($postAttr['additionalExcerptClass']);?>">
    						<?php echo ceris_core::bk_get_post_excerpt($postAttr['except_length']);?>
    					</div>
                    <?php }?>
                    <?php 
                        if (isset($postAttr['readmore']) && ($postAttr['readmore'] != '')) :
                    ?>
                    <div class="post__readmore  <?php if(isset($postAttr['additionalTextReadMore']) && ($postAttr['additionalTextReadMore'] != null)) echo esc_attr($postAttr['additionalTextReadMore']);?>">
                        <a href="<?php echo get_permalink($postID);?>" class="button__readmore">
                            <span class="readmore__text"><span class="hidden-xs"><?php esc_html_e('Read more','ceris'); ?></span><i class="mdicon mdicon-arrow_forward"></i></span>
                        </a>
                    </div>        
                    <?php
                        endif;
                    ?>
                     <?php 
                        if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) :
                            if($postAttr['meta'] != array('author')):
                        ?>
                            <div class="post__meta">
                            <?php
                            echo ceris_core::bk_get_post_meta($postAttr['meta']);
                            ?>
                            </div>
                            <?php 
                            else:
                            
                     ?>
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
                        if($postIcon != '') :
                            echo ceris_core::bk_get_post_icon($postID, $postIcon);
                        endif;
                    ?>
                </div>
                <?php
                if($bookmark == 'on') :
                    if(is_user_logged_in()) {
                        get_template_part( '/library/templates/bookmark/ceris-bookmark-user');
                    }else {
                        get_template_part( '/library/templates/bookmark/ceris-bookmark-guest');
                    }
                endif;
                ?>
            </article>
            <?php return ob_get_clean();
        }
      
        
    }
}