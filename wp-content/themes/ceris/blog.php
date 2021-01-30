<?php
/*
Template Name: Blog
*/
 ?> 
<?php
    get_header('page');
    
    $pageID         = get_the_ID();
        
    if(is_front_page()) {
        $paged = (get_query_var('page')) ? get_query_var('page') : 1;
    }else {
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    }
    
    query_posts('post_type=post&post_status=publish&paged=' . $paged);
    
    $sticky = get_option('sticky_posts') ;
    rsort( $sticky );
    
    $headerStyle    = ceris_core::bk_get_theme_option('bk_blog_header_style');
    $blogLayout     = ceris_core::bk_get_theme_option('bk_blog_content_layout');
    $pagination     = ceris_core::bk_get_theme_option('bk_blog_pagination');
    $sidebar        = ceris_core::bk_get_theme_option('bk_blog_sidebar_select');
    $sidebarPos     = ceris_core::bk_get_theme_option('bk_blog_sidebar_position');
    $sidebarSticky  = ceris_core::bk_get_theme_option('bk_blog_sidebar_sticky'); 
    
    $bookmark       = ceris_core::bk_get_theme_option('bk_blog_page_post_bookmark');
    
    if($blogLayout == 'listing_grid_b') {
        $archiveLayoutClass = 'posts-listing-grid-b';
    }else if($blogLayout == 'listing_grid_b_no_sidebar') {
         $archiveLayoutClass = 'posts-listing-grid-b-no-sidebar';
    }else {
        $archiveLayoutClass = $blogLayout;
    }
    
    $moduleID = uniqid('ceris_posts_'.$archiveLayoutClass.'-');
    $posts_per_page = intval(get_query_var('posts_per_page'));
    $customArgs = array(
        'post__not_in'      => $sticky,
    	'post_type'         => array( 'post' ),
    	'posts_per_page'    => $posts_per_page,
        'post_status'       => 'publish',
        'offset'            => 0,
        'orderby'           => 'date',
    );
    ceris_core::bk_add_buff('query', $moduleID, 'args', $customArgs);
    $sidebar_option = '';
    if(!is_active_sidebar($sidebar)) {
        $sidebar_option = 'disable';
    }
?>
<div class="site-content <?php if($bookmark=='on') echo 'bookmark-without-dismiss';?>">
    <?php echo ceris_archive::render_page_heading($pageID, $headerStyle);?>
    <?php if( ($blogLayout == 'listing_list')             ||
              ($blogLayout == 'listing_list_b')           || 
              ($blogLayout == 'listing_list_large_a')     || 
              ($blogLayout == 'listing_list_large_b')     || 
              ($blogLayout == 'listing_list_alt_a')       || 
              ($blogLayout == 'listing_list_alt_b')       ||
              ($blogLayout == 'listing_list_alt_c')       || 
              ($blogLayout == 'listing_grid')             ||
              ($blogLayout == 'listing_grid_b')           ||
              ($blogLayout == 'listing_grid_alt_a')       ||
              ($blogLayout == 'listing_grid_alt_b')       ||
              ($blogLayout == 'listing_grid_small')
            ) {?>
    <div class="atbs-ceris-block atbs-ceris-block--fullwidth">
        <div class="container <?php if($sidebar_option == 'disable') echo 'container--narrow'; ?>">
            <?php if($sidebar_option != 'disable') echo '<div class="row">';?>
                <div class="<?php if($sidebar_option != 'disable'): echo 'atbs-ceris-main-col'; else: echo 'container--narrow-inner'; endif;?> <?php if($sidebarPos == 'left') echo('has-left-sidebar');?>" role="main">
                    <div id="<?php echo esc_attr($moduleID);?>" class="atbs-ceris-block ceris_latest_blog_posts <?php echo esc_attr($archiveLayoutClass);?>">                        
                        <?php 
                        if($pagination == 'ajax-loadmore') {
                            echo '<div class="js-ajax-load-post">';
                        }elseif($pagination == 'infinity') {
                            echo '<div class="js-ajax-load-post infinity-ajax-load-post">';
                        }
                        ?>
                        <?php echo ceris_archive::archive_main_col($blogLayout, $moduleID, $pagination, $bookmark);?>
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
          ($blogLayout == 'listing_grid_no_sidebar')         ||
          ($blogLayout == 'listing_grid_b_no_sidebar')       ||
          ($blogLayout == 'listing_grid_small_no_sidebar')   ||
          ($blogLayout == 'listing_list_no_sidebar')         ||
          ($blogLayout == 'listing_list_b_no_sidebar')       ||
          ($blogLayout == 'listing_list_large_a_no_sidebar') ||
          ($blogLayout == 'listing_list_large_b_no_sidebar') ||
          ($blogLayout == 'listing_list_alt_a_no_sidebar')   ||
          ($blogLayout == 'listing_list_alt_b_no_sidebar')   ||
          ($blogLayout == 'listing_list_alt_c_no_sidebar')
        ) { ?>
    <div id="<?php echo esc_attr($moduleID);?>" class="atbs-ceris-block atbs-ceris-block--fullwidth ceris_latest_blog_posts <?php echo esc_attr($archiveLayoutClass);?>">
        <?php
        if( ($blogLayout == 'listing_grid_no_sidebar') || ($blogLayout == 'listing_grid_small_no_sidebar') || ($blogLayout == 'listing_grid_b_no_sidebar')  ) {
            echo '<div class="container">';
        }else {
            echo '<div class="container container--narrow">';
        }
                
        if($pagination == 'ajax-loadmore') {
            echo '<div class="js-ajax-load-post">';
        }elseif($pagination == 'infinity') {
            echo '<div class="js-ajax-load-post infinity-ajax-load-post">';
        }
        
        echo ceris_archive::archive_fullwidth($blogLayout, $moduleID, $pagination, $bookmark);
        echo ceris_archive::bk_pagination_render($pagination);
        
        if(($pagination == 'ajax-loadmore') || ($pagination == 'infinity')) {
            echo '</div>';
        }
        echo '</div><!-- .container -->';
        ?>
    </div><!-- .atbs-ceris-block -->
<?php }?>
</div>
<?php get_footer(); ?>