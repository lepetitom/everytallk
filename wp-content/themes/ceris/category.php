<?php
/**
 * The template for displaying Category archive pages
 *
 */
 ?>
<?php
    $ceris_option = ceris_core::bk_get_global_var('ceris_option');
    
    get_header('category');
    
    $paged = intval(get_query_var('paged'));
    if(empty($paged) || $paged == 0) {
        $paged = 1;
    }
    
    if (function_exists('get_queried_object_id')) :
        $catID          = get_queried_object_id();
    else:
        $catID          = $wp_query->get_queried_object_id();
    endif;
    
    $archiveLayout  = ceris_archive::bk_get_archive_option($catID, 'bk_category_content_layout');
    
    if($archiveLayout == 'listing_grid_b') {
        $archiveLayoutClass = 'posts-listing-grid-b';
    }else if($archiveLayout == 'listing_grid_b_no_sidebar') {
         $archiveLayoutClass = 'posts-listing-grid-b-no-sidebar';
    }else {
        $archiveLayoutClass = $archiveLayout;
    }
        
    $pagination     = ceris_archive::bk_get_archive_option($catID, 'bk_category_pagination');
    $featLayout     = ceris_archive::bk_get_archive_option($catID, 'bk_category_feature_area');
    $featAreaShowHide  = ceris_archive::bk_get_archive_option($catID, 'bk_feature_area__show_hide');
    $sidebar        = ceris_archive::bk_get_archive_option($catID, 'bk_category_sidebar_select');
    $sidebarPos     = ceris_archive::bk_get_archive_option($catID, 'bk_category_sidebar_position');
    $sidebarSticky  = ceris_archive::bk_get_archive_option($catID, 'bk_category_sidebar_sticky');
    $featAreaOption = ceris_archive::bk_get_archive_option($catID, 'bk_category_feature_area__post_option');
    
    $bookmark       = ceris_core::bk_get_theme_option('bk_category_page_post_bookmark');
    
    $sidebar_option = '';
    if(!is_active_sidebar($sidebar)) {
        $sidebar_option = 'disable';
    }
    
    $moduleID = uniqid('ceris_posts_'.$archiveLayout.'-');
    $posts_per_page = intval(get_query_var('posts_per_page'));
    
    if(function_exists('rwmb_meta')) {
        $is_exclude = rwmb_meta( 'bk_category_exclude_posts', array( 'object_type' => 'term' ), $catID );
    }else {
        $is_exclude = '';
    }
    if (isset($is_exclude) && ($is_exclude == 'global_settings')): 
        $is_exclude = $ceris_option['bk_category_exclude_posts'];
    endif;
    if(($is_exclude == 1) || ($featAreaOption == 'latest')) {
        $excludeID = ceris_archive::get_sticky_ids__category_feature_area($catID, $featLayout);
    }else {
        $excludeID = '';
    }
    $customArgs = array(
        'cat'               => $catID,
        'post__not_in'      => $excludeID,
		'post_type'         => array( 'post' ),
		'posts_per_page'    => $posts_per_page,
        'post_status'       => 'publish',
        'offset'            => 0,
        'orderby'           => 'date',
	);

    ceris_core::bk_add_buff('query', $moduleID, 'args', $customArgs);
?>
<div class="site-content <?php if($bookmark=='on') echo 'bookmark-without-dismiss';?>">

    <?php 
        if($featAreaShowHide != 1) {
            echo ceris_archive::ceris_archive_header($catID);
            echo ceris_archive::archive_feature_area($catID, $featLayout);
        }else {
            if($paged == 1) {
                echo ceris_archive::ceris_archive_header($catID);
                echo ceris_archive::archive_feature_area($catID, $featLayout);
            }else {
                echo ceris_archive::ceris_archive_header($catID);
            }
        }
    ?>          
    
    <?php if( ($archiveLayout == 'listing_list')             ||
              ($archiveLayout == 'listing_list_b')           || 
              ($archiveLayout == 'listing_list_large_a')     || 
              ($archiveLayout == 'listing_list_large_b')     || 
              ($archiveLayout == 'listing_list_alt_a')       || 
              ($archiveLayout == 'listing_list_alt_b')       ||
              ($archiveLayout == 'listing_list_alt_c')       || 
              ($archiveLayout == 'listing_grid')             ||
              ($archiveLayout == 'listing_grid_b')           ||
              ($archiveLayout == 'listing_grid_alt_a')       ||
              ($archiveLayout == 'listing_grid_alt_b')       ||
              ($archiveLayout == 'listing_grid_small')
            ) {?>
    <div class="atbs-ceris-block atbs-ceris-block-custom-margin atbs-ceris-block--fullwidth">
        <div class="container <?php if($sidebar_option == 'disable') echo 'container--narrow';?>">
            <?php if($sidebar_option != 'disable') echo '<div class="row">';?>
                <div class="<?php if($sidebar_option != 'disable'): echo 'atbs-ceris-main-col'; else: echo 'container--narrow-inner'; endif; ?> <?php if($sidebarPos == 'left') echo('has-left-sidebar');?>" role="main">
                    <div id="<?php echo esc_attr($moduleID);?>" class="atbs-ceris-block <?php echo esc_attr($archiveLayoutClass);?>">
                        <?php 
                        if($pagination == 'ajax-loadmore') {
                            echo '<div class="js-ajax-load-post">';
                        }elseif($pagination == 'infinity'){
                             echo '<div class="js-ajax-load-post infinity-ajax-load-post">';
                        }
                        ?>
                        <?php echo ceris_archive::archive_main_col($archiveLayout, $moduleID, $pagination, $bookmark);?>
                        <?php echo ceris_archive::bk_pagination_render($pagination);?>
                        <?php 
                        if(($pagination == 'ajax-loadmore') || ($pagination == 'infinity')) {
                            echo '</div>';
                        }
                        ?>
                    </div><!-- .atbs-ceris-block -->
                </div><!-- .atbs-ceris-main-col -->
                <?php if($sidebar_option != 'disable'):?>
                <div class="atbs-ceris-sub-col atbs-ceris-sub-col--right sidebar <?php if($sidebarSticky != 0) echo 'js-sticky-sidebar';?>" role="complementary">
                    <?php 
                        dynamic_sidebar( $sidebar );
                    ?>
                </div> <!-- .atbs-ceris-sub-col -->
                <?php endif;?>
            <?php if($sidebar_option != 'disable') echo '</div><!-- .row -->';?>
        </div><!-- .container -->
    </div><!-- .atbs-ceris-block -->
    <?php } elseif( 
              ($archiveLayout == 'listing_grid_no_sidebar')         ||
              ($archiveLayout == 'listing_grid_b_no_sidebar')       ||
              ($archiveLayout == 'listing_grid_small_no_sidebar')   ||
              ($archiveLayout == 'listing_list_no_sidebar')         ||
              ($archiveLayout == 'listing_list_b_no_sidebar')       ||
              ($archiveLayout == 'listing_list_large_a_no_sidebar') ||
              ($archiveLayout == 'listing_list_large_b_no_sidebar') ||
              ($archiveLayout == 'listing_list_alt_a_no_sidebar')   ||
              ($archiveLayout == 'listing_list_alt_b_no_sidebar')   ||
              ($archiveLayout == 'listing_list_alt_c_no_sidebar')
            ) { ?>
    <div id="<?php echo esc_attr($moduleID);?>" class="atbs-ceris-block atbs-ceris-block--fullwidth <?php echo esc_attr($archiveLayoutClass);?>">
        <?php
        if( ($archiveLayout == 'listing_grid_no_sidebar') || ($archiveLayout == 'listing_grid_small_no_sidebar') || ($archiveLayout == 'listing_grid_b_no_sidebar')  ) {
            echo '<div class="container">';
        }else {
            echo '<div class="container container--narrow">';
        }
        if($pagination == 'ajax-loadmore') {
            echo '<div class="js-ajax-load-post">';
        }elseif($pagination == 'infinity'){
             echo '<div class="js-ajax-load-post infinity-ajax-load-post">';
        }
        
        echo ceris_archive::archive_fullwidth($archiveLayout, $moduleID, $pagination, $bookmark);
        echo ceris_archive::bk_pagination_render($pagination);
        if(($pagination == 'ajax-loadmore') || ($pagination == 'infinity')) {
            echo '</div>';
        }
        echo '</div><!-- .container -->';
        ?>
    </div><!-- .atbs-ceris-block -->
    <?php }else {?>
    <div class="atbs-ceris-block atbs-ceris-block--fullwidth">
        <div class="container <?php if($sidebar_option == 'disable') echo 'container--narrow';?>">
            <?php if($sidebar_option != 'disable') echo '<div class="row">';?>
                <div class="<?php if($sidebar_option != 'disable'): echo 'atbs-ceris-main-col'; else: echo 'container--narrow-inner'; endif; ?>" role="main">
                    <div id="<?php echo esc_attr($moduleID);?>" class="atbs-ceris-block <?php echo esc_attr($archiveLayoutClass);?>">
                        <?php echo ceris_archive::archive_main_col('listing_list', $moduleID, 'default', $bookmark);?>
                        <?php echo ceris_archive::bk_pagination_render('default');?>
                    </div><!-- .atbs-ceris-block -->
                </div><!-- .atbs-ceris-main-col -->
                <?php if($sidebar_option != 'disable'):?>
                <div class="atbs-ceris-sub-col atbs-ceris-sub-col--right sidebar js-sticky-sidebar" role="complementary">
                    <?php dynamic_sidebar( $sidebar ); ?>
                </div> <!-- .atbs-ceris-sub-col -->
                <?php endif;?>
            <?php if($sidebar_option != 'disable') echo '</div><!-- .row -->';?>
        </div><!-- .container -->
    </div><!-- .atbs-ceris-block -->
    <?php }?>
</div>

<?php get_footer(); ?>