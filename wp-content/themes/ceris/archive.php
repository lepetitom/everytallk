<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */
?>
<?php
    get_header('archive');
    
    $archiveLayout  = ceris_core::bk_get_theme_option('bk_archive_content_layout');
    $headingStyle    = ceris_core::bk_get_theme_option('bk_archive_header_style');
    $sidebar        = ceris_core::bk_get_theme_option('bk_archive_sidebar_select');
    $sidebarPos     = ceris_core::bk_get_theme_option('bk_archive_sidebar_position');
    $sidebarSticky  = ceris_core::bk_get_theme_option('bk_archive_sidebar_sticky'); 
    
    $bookmark       = ceris_core::bk_get_theme_option('bk_archive_page_post_bookmark');
    
    $headingInverse = 'no';
    $headingClass = ceris_core::bk_get_block_heading_class($headingStyle, $headingInverse);
    
    $sidebar_option = '';
    if(!is_active_sidebar($sidebar)) {
        $sidebar_option = 'disable';
    }
?>
<div class="site-content <?php if($bookmark=='on') echo 'bookmark-without-dismiss';?>">       
    <div class="container">   
        <div class="block-heading <?php echo esc_html($headingClass);?>">
			<h2 class="page-heading__title block-heading__title">
                <?php
                    if ( is_day() ) :
                		printf( esc_html__( 'Daily Archives: %s', 'ceris' ), get_the_date() );
                	elseif ( is_month() ) :
                		printf( esc_html__( 'Monthly Archives: %s', 'ceris' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'ceris' ) ) );
                	elseif ( is_year() ) :
                		printf( esc_html__( 'Yearly Archives: %s', 'ceris' ), get_the_date( _x( 'Y', 'yearly archives date format', 'ceris' ) ) );
                    else :
                		esc_html_e( 'Archives', 'ceris' );
                	endif;
                ?>                                
            </h2>
        </div>
	</div>
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
        <div class="container <?php if($sidebar_option == 'disable') echo 'container--narrow';?>">
            <?php if($sidebar_option != 'disable') echo '<div class="row">';?>
                <div class="<?php if($sidebar_option != 'disable'): echo 'atbs-ceris-main-col'; else: echo 'container--narrow-inner'; endif;?> <?php if($sidebarPos == 'left') echo('has-left-sidebar');?>" role="main">
                <?php echo ceris_archive::archive_main_col($archiveLayout, '', '', $bookmark);?>
                <?php
                    if (function_exists('ceris_paginate')) {
                        echo ceris_core::ceris_get_pagination();
                    }
                ?>
                </div><!-- .atbs-ceris-main-col -->
                <?php if($sidebar_option != 'disable'):?>
                <div class="atbs-ceris-sub-col atbs-ceris-sub-col--right sidebar <?php if($sidebarSticky != 0) echo 'js-sticky-sidebar';?>" role="complementary">
                    <?php dynamic_sidebar( $sidebar );?>
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
    <div class="atbs-ceris-block atbs-ceris-block--fullwidth">
        <?php
            if( ($archiveLayout == 'listing_grid_no_sidebar') || ($archiveLayout == 'listing_grid_small_no_sidebar') || ($archiveLayout == 'listing_grid_b_no_sidebar')  ) {
                echo '<div class="container">';
            }else {
                echo '<div class="container container--narrow">';
            }
            echo ceris_archive::archive_fullwidth($archiveLayout, '', '', $bookmark);
            if (function_exists('ceris_paginate')) {
                echo ceris_core::ceris_get_pagination();
            }
            echo '</div><!-- .container -->';
        ?>
    </div><!-- .atbs-ceris-block -->
    <?php }?>
        
</div>

<?php get_footer(); ?>