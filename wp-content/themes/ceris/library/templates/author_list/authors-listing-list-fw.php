<?php
/*
Template Name: Authors List
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
    
    $user_query = new WP_User_Query( array( 'role' => 'Administrator' ) );
    $users_found = $user_query->get_results();
?>

<div class="site-content ceris-author-list-page">
    <?php echo ceris_archive::render_page_heading($pageID, $headerStyle);?>
    <div class="atbs-ceris-block atbs-ceris-block--fullwidth">
        <div class="container container--narrow">
            <div class="row">
                <div class="atbs-ceris-main" role="main">
                    <div class="atbs-ceris-block author-listing-list--fw-layout">    
                        <ul class="list-unstyled list-space-xxl">                    
                        <?php
                            foreach($users_found as $user) :
                                $authorID = $user->data->ID;
                                echo '<li>'.ceris_archive::author_box($authorID).'</li>';
                            endforeach;
                        ?>
                        </ul>
                    </div><!-- .atbs-ceris-block -->
                </div><!-- .atbs-ceris-main -->
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .atbs-ceris-block -->
</div>
<?php get_footer(); ?>