<?php
/**
 * Index Page -- Latest Page
 *
 */
 ?>
<?php get_header();?>
<?php
$sidebar_option = '';
if(!is_active_sidebar('home_sidebar')) {
    $sidebar_option = 'disable';
}
?>
<div class="site-content">
    <div class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-posts-latest-has--smallpost atbs-ceris--index-page">
        <div class="container <?php if($sidebar_option == 'disable') echo 'container--narrow';?>">
            <?php if($sidebar_option != 'disable') echo '<div class="row">';?>
                <div class="<?php if($sidebar_option != 'disable'): echo 'atbs-ceris-main-col'; else: echo 'container--narrow-inner'; endif;?>" role="main">
                <?php //echo ceris_archive::archive_main_col('listing_list');?>
                <?php
                    $cat = 4; //Above the Title - No BG
                    $cat_Class = ceris_core::bk_get_cat_class($cat);
                    $cat_Class .= ' cat-theme';
                    $metaArray = array('author_name', 'date');
                ?>
                <div class="posts-list list-unstyled ">
                    <?php while (have_posts()): the_post(); $postID = get_the_ID();?>
                    <div class="list-item">
                        <article class="post post--horizontal post--horizontal-middle remove-margin-bottom-lastchild post__thumb--width-450 post--horizontal-normal icon-has-animation <?php if(is_sticky($postID)) echo 'sticky-ceris-post';?>">
                            <?php if(ceris_core::bk_check_has_post_thumbnail($postID)) :?>
                            <div class="post__thumb">
                                <?php echo ceris_core::get_feature_image($postID, 'ceris-xs-4_3', true);?>
                            </div>
                            <?php endif;?>
                            <div class="post__text">
                                <?php echo ceris_core::bk_get_post_cat_link($postID, $cat_Class);?>
                                <?php if(is_sticky($postID)) echo '<span class="cerisStickyMark"><i class="mdicon mdicon-fire"></i></span>';?>
                                <h3 class="post__title typescale-2">
                                    <?php echo ceris_core::bk_get_post_title_link($postID);?>
                                </h3>
                                <div class="post__excerpt">
                                    <a class="excerpt-link" href="<?php echo get_permalink($postID);?>">
                                        <?php echo ceris_core::bk_get_post_excerpt(23);?>
                                    </a>
                                </div>
                                <div class="post__meta">
                                    <?php echo ceris_core::bk_get_post_meta($metaArray); ?>
                                </div>
                            </div>
                        </article>
                    </div>
                    <?php endwhile;?>
                </div>
                <?php
                    if (function_exists('ceris_paginate')) {
                        echo ceris_core::ceris_get_pagination();
                    }
                ?>
                </div><!-- .atbs-ceris-main-col -->
                <?php if($sidebar_option != 'disable') : ?>
                <div class="atbs-ceris-sub-col atbs-ceris-sub-col--right sidebar js-sticky-sidebar" role="complementary">
                    <?php dynamic_sidebar( 'home_sidebar' );?>
                </div> <!-- .atbs-ceris-sub-col -->
                <?php endif;?>
            <?php if($sidebar_option != 'disable') echo '</div><!-- .row -->';?>
        </div><!-- .container -->
    </div><!-- .atbs-ceris-block -->
</div>
<?php get_footer();?>