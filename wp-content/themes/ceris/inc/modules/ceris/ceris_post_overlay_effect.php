<?php
if (!class_exists('ceris_post_overlay_effect')) {
    class ceris_post_overlay_effect {
        
        function render($postAttr) {
            ob_start();
            global $ceris_DismissPage;
                                    
            $postID = $postAttr['postID'];
            $bk_permalink = get_permalink($postID);
            $bk_post_title = get_the_title($postID);
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
           
            ?>
            <article class="post--overlay <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
                <?php if(ceris_core::bk_check_has_post_thumbnail($postID) && isset($postAttr['thumbSize']) && ($postAttr['thumbSize'] != '')) :?>
				    <div class="post__thumb <?php if(isset($postAttr['additionalThumbClass']) && ($postAttr['additionalThumbClass'] != null)) echo esc_attr($postAttr['additionalThumbClass']); ?> <?php if(isset($postAttr['additionalBGClass']) && ($postAttr['additionalBGClass'] != null)) echo esc_attr($postAttr['additionalBGClass']);?>">
                        <?php echo ceris_core::get_feature_image($postID, $postAttr['thumbSize'], true, $postIcon);?>
                    </div>
                <?php endif;?>
                <div class="post__text <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
                    <div class="post__text-wrap">
                        <div class="post__text-inner">
                            <div class="post__text-front flexbox-wrap flexbox-wrap-1i flexbox-space-y">
                                <div class="post__cat-wrap flexbox-wrap flexbox-center-x">
                                    <?php 
                                        $catStyle = 3;
                                        $catClass = ceris_core::bk_get_cat_class($catStyle);
                                        echo ceris_core::bk_get_post_cat_link($postID, $catClass);
                                    ?>
                                </div>
                                <?php 
                                    if (isset($postAttr['readmore']) && ($postAttr['readmore'] != '')) :
                                ?>
                                <div class="post__readmore text-center">
                                    <a href="<?php echo get_permalink($postID);?>" class="button__readmore">
                                        <span class="readmore__text"><?php esc_html_e('Read Now','ceris') ?></span>
                                    </a>
                                </div>    
                                <?php
                                    endif;
                                ?>
                                <?php if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) : ?>    
                                <div class="post__meta">
                                    <div class="entry-author post-author-avatar-50 post-author-font-weight-400 post-author-vertical post-author">
                                        <?php 
                                            echo ceris_core::bk_get_post_meta(array('author_name'));
                                        ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="post__text-backface flexbox-wrap flexbox-wrap-1i flexbox-space-y">
                                <div class="post__text-backface-top">
                                    <div class="post__cat-wrap">
                                        <?php 
                                            $catStyle = 4;
                                            $catClass = ceris_core::bk_get_cat_class($catStyle);
                                            echo ceris_core::bk_get_post_cat_link($postID, $catClass);
                                        ?>
                                    </div>
                                    <h3 class="post__title <?php echo esc_attr($postAttr['typescale']);?>"><a href="<?php echo esc_url($bk_permalink);?>"><?php echo esc_attr($bk_post_title);?></a></h3>
                                    <?php if(isset($postAttr['except_length']) && ($postAttr['except_length'] != null)) {?>
                                        <div class="post__excerpt <?php if(isset($postAttr['additionalExcerptClass']) && ($postAttr['additionalExcerptClass'] != null)) echo esc_attr($postAttr['additionalExcerptClass']);?>">
                    						<?php echo ceris_core::bk_get_post_excerpt($postAttr['except_length']);?>
                    					</div>
                                    <?php }?>
                                </div>
                                <div class="post__text-backface-bottom flexbox-wrap flexbox-bottom-y flexbox-wrap-1i">  
                                    <div class="post__meta flexbox-wrap flexbox-center-y flexbox-space-x">
                                        <?php if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) : ?>
                                        <div class="entry-author post-author-avatar-40 post-author-font-weight-400 post-author flexbox-wrap flexbox-center-y">
                                            <?php 
                                                echo ceris_core::bk_get_post_meta($postAttr['meta']);
                                            ?>
                                        </div>
                                        <?php endif; ?>
                                        <?php 
                                            if (isset($postAttr['readmore']) && ($postAttr['readmore'] != '')) :
                                        ?>
                                        <div class="post__readmore text-center">
                                            <a href="<?php echo get_permalink($postID);?>" class="button__readmore flexbox-wrap flexbox-center-xy">
                                                <span class="readmore__text"><i class="mdicon mdicon-arrow_forward"></i></span>
                                            </a>
                                        </div>    
                                        <?php
                                            endif;
                                        ?>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="<?php echo get_permalink($postID);?>" class="link-overlay"></a>
            </article>
            
            <?php return ob_get_clean();
        }
        
    }
}