<?php
/*
Template Name: Single Template 5
*/
?>
<?php
        global $post;
    $ceris_option = ceris_core::bk_get_global_var('ceris_option');
    $currentPost        = $post;
    $postID             = get_the_ID();
    $catIDClass         = '';
    
    $bkEntryTeaser      = get_post_meta($postID,'bk_post_subtitle',true);
    
    $sidebar            =  ceris_single::bk_get_post_option($postID, 'bk_post_sb_select');
    $sidebarPos         =  ceris_single::bk_get_post_option($postID, 'bk_post_sb_position');
    $sidebarSticky      =  ceris_single::bk_get_post_option($postID, 'bk_post_sb_sticky');

    $reviewBoxPosition  = get_post_meta($postID,'bk_review_box_position',true);

    //Switch
    $bkAuthorSW         = ceris_single::bk_get_post_option($postID, 'bk-authorbox-sw');
    $bkPostNavSW        = ceris_single::bk_get_post_option($postID, 'bk-postnav-sw');
    $bkRelatedSW        = ceris_single::bk_get_post_option($postID, 'bk-related-sw');
    $bkSameCatSW        = ceris_single::bk_get_post_option($postID, 'bk-same-cat-sw');

    $featuredImageSTS   = ceris_single::bk_get_post_option($postID, 'bk-feat-img-status');
    $bk_author_name = get_the_author_meta('display_name', $post->post_author);
    $authorImgALT = $bk_author_name;
    $authorArgs = array(
        'class' => 'entry-author__avatar',
    );

    if (defined('CERIS_FUNCTIONS_PLUGIN_DIR')) {
        $reactionSW = $ceris_option['bk-reaction-sw'];
        if($reactionSW == null) :
            $reactionSW = 0;
        endif;
        $header_meta = array('author_has_wrap', 'date', 'view', 'comment');
    }else {
        $reactionSW = 0;
        $header_meta = array('date', 'comment');
    }

    $cerisExtension = '';
    if (!defined('CERIS_FUNCTIONS_PLUGIN_DIR')) :
        $cerisExtension = 'ceris-no-extension';
    endif;

    // Single Infinity Scrolling Options
    $infinityScrolling  = $ceris_option['single-sections-infinity-scrolling'] ? $ceris_option['single-sections-infinity-scrolling'] : 0;
    if(($infinityScrolling != '') || ($infinityScrolling != 0)):
        $infinity_PrevPost = ceris_single::bk_get_previous_post($postID);
        if(($infinity_PrevPost != '') || (is_array($infinity_PrevPost)) && (sizeof($infinity_PrevPost) != 0)) {
            $infinity_postIDtoLoad = $infinity_PrevPost->ID;
            $infinity_PermalinkToLoad = get_permalink($infinity_postIDtoLoad);
            $nextPostTitle = get_the_title($infinity_postIDtoLoad);
            $infinity_wrapDivClass = 'single-infinity-scroll';
            $next_article_wcount = ceris_single::article_wcount($infinity_postIDtoLoad);
        }else {
            $infinity_PrevPost = '';
            $infinity_PermalinkToLoad = '';
            $infinity_wrapDivClass = '';
            $nextPostTitle = '';
            $next_article_wcount = '';
        }
    else:
        $infinity_PrevPost = '';
        $infinity_PermalinkToLoad = '';
        $infinity_wrapDivClass = '';
        $nextPostTitle = '';
        $next_article_wcount = '';
    endif;

    if(is_user_logged_in()) :
        $currentPostID = get_the_ID();
        $currentUserID = get_current_user_id();
        $bookmarkData = get_user_meta( $currentUserID, 'atbs_posts_bookmarked', true );

        if($bookmarkData == '') {
            $bookmarkData = array();
        }

        if( in_array(intval($currentPostID), $bookmarkData)) {
            $bookmarkClass = 'ceris-already-bookmarked';
        }else {
            $bookmarkClass = '';
        }
    else :
        $bookmarkClass = '';
    endif;
    
    $article_wcount = ceris_single::article_wcount($postID);
    
    //Check Sticky Social Share Bar
    if ( isset($ceris_option['bk-sticky-share-bar']) && ($ceris_option['bk-sticky-share-bar'] != 0) && function_exists( 'ceris_extension_single_entry_interaction__sticky_share_box' ) ) {
        $stickySocialShareBar = 1;
        $stickySocialShareBar__Class = '';
    }else {
        $stickySocialShareBar = 0;
        $stickySocialShareBar__Class = 'ceris-sticky-social-share-bar-off';
    }
?>
<div class="site-content atbs-single-style-no-sidebar-4 atbs-single-style-17 <?php echo esc_attr($stickySocialShareBar__Class);?> <?php echo esc_attr($infinity_wrapDivClass);?> <?php echo esc_attr($cerisExtension);?>">
    <div class="single-entry-wrap <?php if(($infinityScrolling != '') || ($infinityScrolling != 0)): echo 'single-infinity-container'; endif;?>">
        <?php
            $thumbAttrXXL = array (
                'postID'        => $postID,
                'thumbSize'     => 'ceris-xxl',
            );
            $thumbAttr = array (
                'postID'        => $postID,
                'thumbSize'     => 'ceris-l-2_1',
            );
            $theBGLinkXXL   = ceris_core::bk_get_post_thumbnail_bg_link($thumbAttrXXL);
            $theBGLink      = ceris_core::bk_get_post_thumbnail_bg_link($thumbAttr);
        ?>
        <div class="atbs-ceris-block atbs-ceris-block-<?php echo esc_attr($currentPostID);?> atbs-ceris-block--fullwidth element-scroll-percent single-entry single-entry--billboard-floorfade <?php if($infinity_wrapDivClass == '') echo 'single-end-infinity';?> <?php echo esc_attr($bookmarkClass);?> <?php if(($infinityScrolling != '') || ($infinityScrolling != 0)): echo 'single-infinity-inner'; endif;?>" data-url-to-load="<?php echo esc_url($infinity_PermalinkToLoad);?>" data-post-title-to-load="<?php echo esc_attr($nextPostTitle);?>" data-postid="<?php echo esc_attr($currentPostID);?>" data-wcount="<?php echo esc_attr($article_wcount);?>" data-next-wcount="<?php echo esc_attr($next_article_wcount);?>">
            <div class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block--contiguous single-billboard single-billboard--video">
                <?php if (ceris_core::bk_check_has_post_thumbnail($postID)) {?>
                <div class="single-billboard__background background-img blurred-more" style="background-image: url('<?php echo esc_url($theBGLink);?>');"></div>
                <?php }?>
                <div class="container">
                    <div class="row">
                        <div class="atbs-ceris-main-col">
        					<?php
                                echo ceris_single::bk_entry_media($postID);
                            ?>
        				</div>
                        <div class="atbs-ceris-sub-col">
        					<div class="block-heading block-heading--inverse">
        						<h2 class="block-heading__title"><?php esc_html_e('Watch next', 'ceris');?></h2>
        					</div>

                            <ul class="list-unstyled list-space-lg inverse-text">
                                <?php
                                    $args = array(
                                        'post_type'      => 'post',
                            			'orderby'        => 'post_date',
                                        'post__not_in'   => array($postID),
                            			'ignore_sticky_posts' => 1,
                                        'post_status'    => 'publish',
                            			'posts_per_page' => 4,
                                    	'tax_query'      => array(
                                    		array(
                                    			'taxonomy' => 'post_format',
                                    			'field'    => 'slug',
                                    			'terms'    => array('post-format-video' ),
                                    		),
                                    	),
                                    );
                                    $postHorizontalHTML = new ceris_horizontal_1;
                                    $postHorizontalAttr = array (
                                        'additionalClass'   => 'post--horizontal-xs',
                                        'thumbSize'         => 'ceris-xxs-4_3',
                                        'typescale'         => 'typescale-0',
                                    );
                                    $nextPosts = new WP_Query( $args );
                                    while ( $nextPosts->have_posts() ): $nextPosts->the_post();
                                        $postHorizontalAttr['postID'] = get_the_ID();
                                        echo '<li>';
                                        echo ceris_core::ceris_html_render($postHorizontalHTML->render($postHorizontalAttr));
                                        echo '</li>';
                                    endwhile;
                                    wp_reset_postdata();
                                ?>
        					</ul>
        				</div>
                    </div><!-- .row -->
        		</div><!-- .container -->
        	</div><!-- .atbs-ceris-block -->

            <div class="atbs-ceris-block atbs-ceris-block--fullwidth single-entry-wrap">
                <div class="container container--narrow">
                    <div class="atbs-ceris-main">
                        <article <?php post_class();?>>
                            <div class="single-content">
                                <div class="single-body entry-content typography-copy">
                                    <?php
                                        if ($stickySocialShareBar == 1) {
                                            echo ceris_extension_single_entry_interaction__sticky_share_box(get_the_ID(), 'js-sticky-sidebar');
                                        }
                                    ?>
                                    <div class="single-body--content">
                                        <header class="single-header single-header--body">
                                            <?php 
                                                $catClass = 'entry-cat post__cat post__cat--bg cat-theme-bg';
                                                echo ceris_core::bk_get_post_cat_link($postID, $catClass, true);
                                            ?>
                                            <h1 class="entry-title post__title"><?php echo get_the_title($postID);?></h1>
                                            <?php if($bkEntryTeaser):?>
                                                <div class="entry-teaser">
                									<?php echo esc_html($bkEntryTeaser);?>
                								</div>
                                            <?php endif;?>
                                            <div class="entry-meta">
                                                <?php echo ceris_core::bk_get_post_meta($header_meta); ?>
                                            </div>
            							</header>
                                        <?php
                                            if($reviewBoxPosition == 'top') {
                                                echo ceris_single::bk_post_review_box_default($postID, $reviewBoxPosition);
                                            }
                                        ?>
                                        <?php the_content();?>
                                        <?php echo ceris_single::bk_post_pagination();?>
                                        <?php
                                            if($reviewBoxPosition == 'default') {
                                                echo ceris_single::bk_post_review_box_default($postID);
                                            }
                                            echo ceris_single::bk_performance_post_review($postID);
                                        ?>
                                        <?php echo ceris_single::bk_entry_mobile_share($postID);?>
                                        <?php
                                            if(($reactionSW != '') && ($reactionSW != 0)) {
                                                get_template_part( 'library/templates/single/atbs-reaction');
                                            }
                                        ?>
                                        <?php
                                            if(($bkAuthorSW != '') && ($bkAuthorSW != 0)) {
                                                echo ceris_single::bk_author_box($currentPost->post_author);
                                            }
                                        ?>
                                        <?php get_template_part( 'library/templates/single/single-footer');?>
                                    </div>
                                </div>
                            </div><!-- .single-content -->
                        </article><!-- .post-single -->
                        <div class="navigation-author__wrap">
                            <?php
                                if(($bkPostNavSW != '') && ($bkPostNavSW != 0)) {
                                    echo ceris_single::bk_post_navigation();
                                }
                            ?>
                        </div><!-- .navigation-author__wrap -->
                        <?php
                            $sectionsSorter = $ceris_option['single-sections-sorter']['enabled'];

                            if ($sectionsSorter): foreach ($sectionsSorter as $key=>$value) {

                                switch($key) {

                                    case 'related':
                                        if(($bkRelatedSW != '') && ($bkRelatedSW != 0)) {
                                            echo ceris_single::bk_related_post($currentPost);
                                        }
                                        break;

                                    case 'comment':
                                        comments_template();
                                    break;

                                    case 'same-cat':
                                        if(($bkSameCatSW != '') && ($bkSameCatSW != 0)) {
                                            echo ceris_single::bk_same_category_posts($currentPost);
                                        }
                                    break;

                                    default:
                                    break;
                                }
                            }
                            endif;
                        ?>
                    </div>
        		</div><!-- .container -->
        	</div>
        </div><!-- .atbs-ceris-block -->
    </div>
    <?php if(($infinity_wrapDivClass != '') && (($infinityScrolling != '') || ($infinityScrolling != 0))): ?>
        <div class="infinity-single-trigger"></div>
    <?php endif;?>
</div><!-- .site-content -->
