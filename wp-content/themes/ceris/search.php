<?php
/**
 * The template for displaying Search Results pages.
 *
 */
 ?> 
<?php
    get_header('search');
    
    $searchLayout   = ceris_core::bk_get_theme_option('bk_search_content_layout');
    $pagination     = ceris_core::bk_get_theme_option('bk_search_pagination');
    $sidebar        = ceris_core::bk_get_theme_option('bk_search_sidebar_select');
    $sidebarPos     = ceris_core::bk_get_theme_option('bk_search_sidebar_position');
    $sidebarSticky  = ceris_core::bk_get_theme_option('bk_search_sidebar_sticky');
    
    if($searchLayout == 'listing_grid_b') {
        $archiveLayoutClass = 'posts-listing-grid-b';
    }else if($searchLayout == 'listing_grid_b_no_sidebar') {
         $archiveLayoutClass = 'posts-listing-grid-b-no-sidebar';
    }else {
        $archiveLayoutClass = $searchLayout;
    }
    
    $moduleID = uniqid('ceris_posts_'.$archiveLayoutClass.'-');
    
    $bookmark       = ceris_core::bk_get_theme_option('bk_search_page_post_bookmark');
    
    $headingStyle  = ceris_core::bk_get_theme_option('bk_search_header_style');
    $headingInverse = 'no';
    $headingClass = ceris_core::bk_get_block_heading_class($headingStyle, $headingInverse);
    
    $sidebar_option = '';
    if(!is_active_sidebar($sidebar)) {
        $sidebar_option = 'disable';
    }
    /* Search Count */ 
    $allsearch = new WP_Query("s=$s&showposts=0");
    $searchCount = $allsearch->found_posts;     

    $posts_per_page = intval(get_query_var('posts_per_page'));
    
    $customArgs = array(
        's'                 => esc_attr($s),
		'post_type'         => array( 'post', 'page' ),
		'posts_per_page'    => $posts_per_page,
        'post_status'       => 'publish',
        'offset'            => 0,
        'orderby'           => 'date',
	);
    ceris_core::bk_add_buff('query', $moduleID, 'args', $customArgs);
?>
<div class="site-content <?php if($bookmark=='on') echo 'bookmark-without-dismiss';?>">
    <div class="container">
        <div class="block-heading <?php echo esc_html($headingClass);?>">
    		<h2 class="page-heading__title block-heading__title"><?php printf( esc_html__( 'Search for: %s', 'ceris' ), get_search_query() ); ?></h2>
    		<div class="page-heading__subtitle"><?php echo (esc_html__('There are', 'ceris') . ' ' . esc_attr($searchCount) . ' ' . esc_html__('results', 'ceris'));?></div>
        </div>
	</div>
    <?php if( ($searchLayout == 'listing_list')             ||
              ($searchLayout == 'listing_list_b')           || 
              ($searchLayout == 'listing_list_large_a')     || 
              ($searchLayout == 'listing_list_large_b')     || 
              ($searchLayout == 'listing_list_alt_a')       || 
              ($searchLayout == 'listing_list_alt_b')       ||
              ($searchLayout == 'listing_list_alt_c')       || 
              ($searchLayout == 'listing_grid')             ||
              ($searchLayout == 'listing_grid_b')           ||
              ($searchLayout == 'listing_grid_alt_a')       ||
              ($searchLayout == 'listing_grid_alt_b')       ||
              ($searchLayout == 'listing_grid_small')
            ) {?> 
    <div class="atbs-ceris-block atbs-ceris-block--fullwidth">
        <div class="container <?php if($sidebar_option == 'disable') echo 'container--narrow'; ?>">
            <?php if($sidebar_option != 'disable') echo '<div class="row">';?>
                <div class="<?php if($sidebar_option != 'disable'): echo 'atbs-ceris-main-col'; else: echo 'container--narrow-inner'; endif;?> <?php if($sidebarPos == 'left') echo('has-left-sidebar');?>" role="main">
                    <div id="<?php echo esc_attr($moduleID);?>" class="atbs-ceris-block <?php echo esc_attr($archiveLayoutClass);?>">
                        <?php 
                        if($pagination == 'ajax-loadmore') {
                            echo '<div class="js-ajax-load-post">';
                        }elseif($pagination == 'infinity') {
                            echo '<div class="js-ajax-load-post infinity-ajax-load-post">';
                        }
                        ?>
                        <?php echo ceris_archive::archive_main_col($searchLayout, $moduleID, $pagination, $bookmark);?>
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
              ($searchLayout == 'listing_grid_no_sidebar')         ||
              ($searchLayout == 'listing_grid_b_no_sidebar')       ||
              ($searchLayout == 'listing_grid_small_no_sidebar')   ||
              ($searchLayout == 'listing_list_no_sidebar')         ||
              ($searchLayout == 'listing_list_b_no_sidebar')       ||
              ($searchLayout == 'listing_list_large_a_no_sidebar') ||
              ($searchLayout == 'listing_list_large_b_no_sidebar') ||
              ($searchLayout == 'listing_list_alt_a_no_sidebar')   ||
              ($searchLayout == 'listing_list_alt_b_no_sidebar')   ||
              ($searchLayout == 'listing_list_alt_c_no_sidebar')
            ) { ?>
    <div id="<?php echo esc_attr($moduleID);?>" class="atbs-ceris-block atbs-ceris-block--fullwidth <?php echo esc_attr($archiveLayoutClass);?>">
        <?php
        if( ($searchLayout == 'listing_grid_no_sidebar') || ($searchLayout == 'listing_grid_small_no_sidebar') || ($searchLayout == 'listing_grid_b_no_sidebar')  ) {
            echo '<div class="container">';
        }else {
            echo '<div class="container container--narrow">';
        }
        if($pagination == 'ajax-loadmore') {
            echo '<div class="js-ajax-load-post">';
        }elseif($pagination == 'infinity') {
            echo '<div class="js-ajax-load-post infinity-ajax-load-post">';
        }
        
        echo ceris_archive::archive_fullwidth($searchLayout, $moduleID, $pagination, $bookmark);
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