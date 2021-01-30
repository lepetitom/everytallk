<?php
/**
 * The template for displaying Author archive pages
 *
 */
 ?> 
<?php
    get_header('author');
    
    if (function_exists('get_queried_object_id')) :
        $authorID = get_queried_object_id();
    else:
        $authorID = $wp_query->get_queried_object_id();
    endif;
    
    $authorLayout   = ceris_core::bk_get_theme_option('bk_author_content_layout');
    $pagination     = ceris_core::bk_get_theme_option('bk_author_pagination');
    $sidebar        = ceris_core::bk_get_theme_option('bk_author_sidebar_select');
    $sidebarPos     = ceris_core::bk_get_theme_option('bk_author_sidebar_position');
    $sidebarSticky  = ceris_core::bk_get_theme_option('bk_author_sidebar_sticky'); 
    
    $bookmark       = ceris_core::bk_get_theme_option('bk_author_page_post_bookmark');
    
    if($authorLayout == 'listing_grid_b') {
        $archiveLayoutClass = 'posts-listing-grid-b';
    }else if($authorLayout == 'listing_grid_b_no_sidebar') {
         $archiveLayoutClass = 'posts-listing-grid-b-no-sidebar';
    }else {
        $archiveLayoutClass = $authorLayout;
    }
    
    $moduleID = uniqid('ceris_posts_'.$archiveLayoutClass.'-');
    $posts_per_page = intval(get_query_var('posts_per_page'));
    $customArgs = array(
        'author'            => $authorID,
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
    <?php if( ($authorLayout == 'listing_list')             ||
              ($authorLayout == 'listing_list_b')           || 
              ($authorLayout == 'listing_list_large_a')     || 
              ($authorLayout == 'listing_list_large_b')     || 
              ($authorLayout == 'listing_list_alt_a')       || 
              ($authorLayout == 'listing_list_alt_b')       ||
              ($authorLayout == 'listing_list_alt_c')       || 
              ($authorLayout == 'listing_grid')             ||
              ($authorLayout == 'listing_grid_b')           ||
              ($authorLayout == 'listing_grid_alt_a')       ||
              ($authorLayout == 'listing_grid_alt_b')       ||
              ($authorLayout == 'listing_grid_small')
            ) {?>
    <div class="atbs-ceris-block atbs-ceris-block--fullwidth">
        <div class="container <?php if($sidebar_option == 'disable') echo 'container--narrow';?>">
            <?php if($sidebar_option != 'disable') echo '<div class="row">';?>
                <div class="<?php if($sidebar_option != 'disable'): echo 'atbs-ceris-main-col'; else: echo 'container--narrow-inner'; endif;?> <?php if($sidebarPos == 'left') echo('has-left-sidebar');?>" role="main">
                    <div id="<?php echo esc_attr($moduleID);?>" class="atbs-ceris-block <?php echo esc_attr($archiveLayoutClass);?>">
                        <?php echo ceris_archive::author_box($authorID);?>
                        
                        <div class="spacer-lg"></div>
                        
                        <?php 
                        if($pagination == 'ajax-loadmore') {
                            echo '<div class="js-ajax-load-post">';
                        }elseif($pagination == 'infinity') {
                            echo '<div class="js-ajax-load-post infinity-ajax-load-post">';
                        }
                        ?>
                        <?php echo ceris_archive::archive_main_col($authorLayout, $moduleID, $pagination, $bookmark);?>
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
          ($authorLayout == 'listing_grid_no_sidebar')         ||
          ($authorLayout == 'listing_grid_b_no_sidebar')       ||
          ($authorLayout == 'listing_grid_small_no_sidebar')   ||
          ($authorLayout == 'listing_list_no_sidebar')         ||
          ($authorLayout == 'listing_list_b_no_sidebar')       ||
          ($authorLayout == 'listing_list_large_a_no_sidebar') ||
          ($authorLayout == 'listing_list_large_b_no_sidebar') ||
          ($authorLayout == 'listing_list_alt_a_no_sidebar')   ||
          ($authorLayout == 'listing_list_alt_b_no_sidebar')   ||
          ($authorLayout == 'listing_list_alt_c_no_sidebar')
        ) { ?>
    <div id="<?php echo esc_attr($moduleID);?>" class="atbs-ceris-block atbs-ceris-block--fullwidth <?php echo esc_attr($archiveLayoutClass);?>">
        <?php
        if( ($authorLayout == 'listing_grid_no_sidebar') || ($authorLayout == 'listing_grid_small_no_sidebar') || ($authorLayout == 'listing_grid_b_no_sidebar')  ) {
            echo '<div class="container">';
        }else {
            echo '<div class="container container--narrow">';
        }
        
        echo ceris_archive::author_box($authorID);
        echo '<div class="spacer-lg"></div>';
        
        if($pagination == 'ajax-loadmore') {
            echo '<div class="js-ajax-load-post">';
        }elseif($pagination == 'infinity') {
            echo '<div class="js-ajax-load-post infinity-ajax-load-post">';
        }
        
        echo ceris_archive::archive_fullwidth($authorLayout, $moduleID, $pagination, $bookmark);
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