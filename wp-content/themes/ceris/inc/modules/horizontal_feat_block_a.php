<?php
if (!class_exists('ceris_horizontal_feat_block_a')) {
    class ceris_horizontal_feat_block_a {
        
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
            ?>
            <article class="post post--horizontal <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
                 <?php if(ceris_core::bk_check_has_post_thumbnail($postID) && isset($postAttr['thumbSize']) && ($postAttr['thumbSize'] != '')) :?>
				    <div class="post__thumb <?php if(isset($postAttr['additionalThumbClass']) && ($postAttr['additionalThumbClass'] != null)) echo esc_attr($postAttr['additionalThumbClass']);?>">
                        <?php echo ceris_core::get_feature_image($postID, $postAttr['thumbSize'], true, $postIcon);?>
                    </div>
                <?php endif;?>
				<div class="post__text <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
                    <?php if(isset($postAttr['cat']) && ($postAttr['cat'] != 0) && ($postAttr['cat'] != 1)) echo ceris_core::bk_get_post_cat_link($postID, $catClass);?>
					<h3 class="post__title <?php echo esc_attr($postAttr['typescale']);?>"><?php echo ceris_core::bk_get_post_title_link($postAttr['postID']);?></h3>
				    <?php if(isset($postAttr['except_length']) && ($postAttr['except_length'] != null)) {?>
                    <div class="post__excerpt <?php if(isset($postAttr['additionalExcerptClass']) && ($postAttr['additionalExcerptClass'] != null)) echo esc_attr($postAttr['additionalExcerptClass']);?>">
						<?php echo ceris_core::bk_get_post_excerpt($postAttr['except_length']);?>
					</div>
                    <?php }?>
                    <?php
                        echo '<div class="post__meta">';
                        $timestamp_lastweek  = strtotime("-1 week");
                        $timestamp_post      = get_the_time('U', $postID);
                        $ceris_article_date_unix = get_the_time('U', $postID);   
                        if($timestamp_post <= $timestamp_lastweek) {
                            echo '<time class="time published" datetime="'.date(DATE_W3C, $ceris_article_date_unix).'" title="'.get_the_time('F j, Y \a\t g:i a', $postID) .'"><i class="mdicon mdicon-schedule"></i>'.get_the_date('', $postID).'</time>';
                        }else {
                            echo '<time class="time published" datetime="'.date(DATE_W3C, $ceris_article_date_unix).'" title="'.get_the_time('F j, Y \a\t g:i a', $postID) .'"><i class="mdicon mdicon-schedule"></i>'.human_time_diff( get_the_time('U'), current_time('timestamp') ) . esc_html__(' ago', 'ceris') .'</time>';
                        }
                        echo '</div>';
                    ?> 
                    <?php
                    if (isset($postAttr['scoreStar']) && ($postAttr['scoreStar'] != '')) :
                        echo '<div class="post-score-star">';
    					echo ceris_core::bk_get_post_score_star($postAttr['scoreStar']);
    					echo '</div>';
                    endif;
                    ?>
                </div>
                <?php if(ceris_core::bk_check_has_post_thumbnail($postID) && isset($postAttr['cat']) && ($postAttr['cat'] == 1)) echo ceris_core::bk_get_post_cat_link($postID, $catClass);?>
			</article>
            <?php return ob_get_clean();
        }
        
    }
}