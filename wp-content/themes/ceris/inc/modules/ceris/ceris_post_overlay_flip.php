<?php
if (!class_exists('ceris_post_overlay_flip')) {
    class ceris_post_overlay_flip {
        
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
            if(isset($postAttr['catClass_back']) && ($postAttr['catClass_back'] != '')) {
                $catClass_Back = $postAttr['catClass_back']; 
            }else {
                $catClass_Back = '';
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
           
            ?>
             <article class="post--overlay <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
            	<div class="post--overlay-front-face post--overlay-face">
                    <?php if(ceris_core::bk_check_has_post_thumbnail($postID) && isset($postAttr['thumbSize']) && ($postAttr['thumbSize'] != '')) :?>
    				    <div class="post__thumb <?php if(isset($postAttr['additionalThumbClass']) && ($postAttr['additionalThumbClass'] != null)) echo esc_attr($postAttr['additionalThumbClass']); ?> <?php if(isset($postAttr['additionalBGClass']) && ($postAttr['additionalBGClass'] != null)) echo esc_attr($postAttr['additionalBGClass']);?>">
                            <?php echo ceris_core::get_feature_image($postID, $postAttr['thumbSize'], true, $postIcon);?>
                        </div>
                    <?php endif;?>
                    
					<div class="post__text  <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
						<div class="post__text-wrap">
							<div class="post__text-inner ">
								<h3 class="post__title <?php echo esc_attr($postAttr['typescale']);?>"><a href="<?php echo esc_url($bk_permalink);?>"><?php echo esc_attr($bk_post_title);?></a></h3>
							     <?php if (isset($postAttr['meta_front']) && ($postAttr['meta_front'] != '')) : ?>
                                    <div class="post__meta">
                                        <?php echo ceris_core::bk_get_post_meta($postAttr['meta_front']); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
						</div>
					</div>
                    <?php if(isset($postAttr['cat']) && ($postAttr['cat'] != 0) && ($postAttr['cat'] != 1) && ($postAttr['cat'] != 2)) echo ceris_core::bk_get_post_cat_link($postID, $catClass);?>
					<a href="<?php echo get_permalink($postID);?>" class="link-overlay"></a>
				</div>
				<div class="post--overlay-back-face post--overlay-face">
					<div class="post__text <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
						<div class="post__text-wrap">
							<div class="post__text-inner ">
								<div class="post--overlay-body">
									<?php if(isset($postAttr['cat_back']) && ($postAttr['cat_back'] != 0) && ($postAttr['cat_back'] != 1) && ($postAttr['cat_back'] != 2)) echo ceris_core::bk_get_post_cat_link($postID, $catClass_Back);?>
								    <h3 class="post__title <?php echo esc_attr($postAttr['typescale_2']);?>"><a href="<?php echo esc_url($bk_permalink);?>"><?php echo esc_attr($bk_post_title);?></a></h3>
									<?php if(isset($postAttr['except_length']) && ($postAttr['except_length'] != null)) {?>
                                        <div class="post__excerpt <?php if(isset($postAttr['additionalExcerptClass']) && ($postAttr['additionalExcerptClass'] != null)) echo esc_attr($postAttr['additionalExcerptClass']);?>">
                    						<?php echo ceris_core::bk_get_post_excerpt($postAttr['except_length']);?>
                    					</div>
                                    <?php }?>
								</div>
								<div class="post--overlay-footer flexbox-wrap">
                                    <?php if (isset($postAttr['meta_back']) && ($postAttr['meta_back'] != '')) : ?>
                                    <span class="entry-author post-author-font-weight-400 <?php if(isset($postAttr['additional_meta_back_Class']) && ($postAttr['additional_meta_back_Class'] != null)) echo esc_attr($postAttr['additionalAuthorClass']);?>">
                                        <?php 
                                            echo ceris_core::bk_get_post_meta($postAttr['meta_back']);
                                        ?>
                                    </span>
                                    <?php
                                      endif;
                                    ?>
                                    <?php 
                                        if (isset($postAttr['readmore']) && ($postAttr['readmore'] != '')) :
                                    ?>
                                    <div class="post__readmore flexbox flexbox--middle text-center">
                                        <a href="<?php echo get_permalink($postID);?>" class="button__readmore button__readmore--round">
                                            <i class="mdicon mdicon-arrow_forward"></i>
                                        </a>
                                    </div>        
                                    <?php
                                        endif;
                                    ?>
								</div>
							</div>
						</div>
                       
					</div>
					<a href="<?php echo get_permalink($postID);?>" class="link-overlay"></a>
				</div>
			</article>
            <?php return ob_get_clean();
        }
        
    }
}