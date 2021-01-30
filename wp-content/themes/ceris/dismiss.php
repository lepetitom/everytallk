<?php
/*
Template Name: Dismiss Articles
*/
 ?> 
<?php
    global $ceris_DismissPage;
    $ceris_DismissPage = 1;
    
    get_header('page');
    $pageID         = get_the_ID();
        
    $headerStyle    = ceris_core::bk_get_theme_option('bk_bookmark_header_style');
    $archiveLayout     = ceris_core::bk_get_theme_option('bk_bookmark_content_layout');
    $pagination     = ceris_core::bk_get_theme_option('bk_bookmark_pagination');
    $sidebar        = ceris_core::bk_get_theme_option('bk_bookmark_sidebar_select');
    $sidebarPos     = ceris_core::bk_get_theme_option('bk_bookmark_sidebar_position');
    $sidebarSticky  = ceris_core::bk_get_theme_option('bk_bookmark_sidebar_sticky'); 
    
    $bookmark = 'on';
    
    if($archiveLayout == 'listing_grid_b') {
        $archiveLayoutClass = 'posts-listing-grid-b';
    }else if($archiveLayout == 'listing_grid_b_no_sidebar') {
         $archiveLayoutClass = 'posts-listing-grid-b-no-sidebar';
    }else {
        $archiveLayoutClass = $archiveLayout;
    }
    
    $moduleID = uniqid('ceris_posts_'.$archiveLayoutClass.'-');
    
    if((is_user_logged_in())) {
        $userID = get_current_user_id();  
        $bookmarkData = get_user_meta( $userID, 'atbs_dismiss_articles', true );
    }else {
        $bookmarkData = array();
        return;
    }
    
    $posts_per_page = intval(get_query_var('posts_per_page'));
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
        'post__not_in'      => '',
		'post_type'         => 'post',
        'ignore_sticky_posts' => 1,
		'posts_per_page'    => $posts_per_page,
        'post__in'          =>  $bookmarkData,
        'orderby'           => 'date',
        'order'             => 'DESC',
        'paged'             => $paged,
	);
    query_posts($args);
    ceris_core::bk_add_buff('query', $moduleID, 'args', $args);
    $sidebar_option = '';
    if(!is_active_sidebar($sidebar)) {
        $sidebar_option = 'disable';
    }
?>
<?php if(($bookmarkData == '') || !is_array($bookmarkData) || (is_array($bookmarkData) && (count($bookmarkData) == 0))) :?>
    <div class="site-content ceris-dismiss-page-template">
        <div class="container container--narrow">
            <div class="ceris-bookmark-page-notification">
                <?php esc_html_e('You have no dismissed articles', 'ceris');?>
            </div>
        </div>
    </div>
<?php else :?>
    <div class="site-content ceris-dismiss-page-template">
        <?php echo ceris_archive::render_page_heading($pageID, $headerStyle);?>
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
        <div id="<?php echo esc_attr($moduleID);?>" class="atbs-ceris-block atbs-ceris-block--fullwidth ceris_latest_blog_posts <?php echo esc_attr($archiveLayoutClass);?>">
            <?php
            if( ($archiveLayout == 'listing_grid_no_sidebar') || ($archiveLayout == 'listing_grid_small_no_sidebar') || ($archiveLayout == 'listing_grid_b_no_sidebar')  ) {
                echo '<div class="container"><div class="row">';
            }else {
                echo '<div class="container container--narrow">';
            }
                    
            if($pagination == 'ajax-loadmore') {
                echo '<div class="js-ajax-load-post">';
            }elseif($pagination == 'infinity') {
                echo '<div class="js-ajax-load-post infinity-ajax-load-post">';
            }
            
            echo ceris_archive::archive_fullwidth($archiveLayout, $moduleID, $pagination, $bookmark);
            echo ceris_archive::bk_pagination_render($pagination);
            
            if(($pagination == 'ajax-loadmore') || ($pagination == 'infinity')) {
                echo '</div>';
            }
            if( ($archiveLayout == 'listing_grid_no_sidebar') || ($archiveLayout == 'listing_grid_small_no_sidebar') || ($archiveLayout == 'listing_grid_b_no_sidebar')  ) {
                echo '</div></div><!-- .container -->';
            }else {
                echo '</div><!-- .container -->';
            }
            ?>
        </div><!-- .atbs-ceris-block -->
    <?php }?>
    </div>
<?php endif;?>

<?php get_footer(); ?>