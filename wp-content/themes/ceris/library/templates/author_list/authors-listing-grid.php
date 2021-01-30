<?php
/*
Template Name: Authors Listing Grid
*/
 ?> 
<?php
    get_header('page');
    
    $pageID         = get_the_ID();
    
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    query_posts('post_type=post&post_status=publish&paged=' . $paged);
    
    $sticky = get_option('sticky_posts') ;
    rsort( $sticky );
    
    $headerStyle     = ceris_core::bk_get_theme_option('bk_authors_list_page_header_style');
    $sidebar        = ceris_core::bk_get_theme_option('bk_authors_list_page_sidebar_select');
    $sidebarPos     = ceris_core::bk_get_theme_option('bk_authors_list_page_sidebar_position');
    $sidebarSticky  = ceris_core::bk_get_theme_option('bk_authors_list_page_sidebar_sticky'); 
    
    $user_query = new WP_User_Query( array( 'role' => 'Administrator' ) );
    $users_found = $user_query->get_results();
?>

<div class="site-content ceris-author-grid-page">
    <?php echo ceris_archive::render_page_heading($pageID, $headerStyle);?>
    <div class="atbs-ceris-block atbs-ceris-block--fullwidth">
        <div class="container">
            <div class="row">
                <div class="atbs-ceris-main-col <?php if($sidebarPos == 'left') echo('has-left-sidebar');?>" role="main">
                    <div class="atbs-ceris-block author-listing-grid--layout">    
                        <ul class="list-unstyled list-space-lg">                    
                        <?php
                            foreach($users_found as $user) :
                                $authorID = $user->data->ID;
                                echo '<li class="col-md-6">'.ceris_archive::author_box($authorID).'</li>';
                            endforeach;
                        ?>
                        </ul>
                    </div><!-- .atbs-ceris-block -->
                </div><!-- .atbs-ceris-main-col -->

                <div class="atbs-ceris-sub-col sidebar <?php if($sidebarSticky != 0) echo 'js-sticky-sidebar';?>" role="complementary">
    				<?php 
                        dynamic_sidebar( $sidebar );
                    ?>
    			</div><!-- .atbs-ceris-sub-col -->
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .atbs-ceris-block -->
</div>
<?php get_footer(); ?>