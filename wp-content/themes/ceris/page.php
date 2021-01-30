<?php
/**
 * The Default Page Template
 *
 */
 ?>
<?php
    $pageID  = get_the_ID();
    get_header();
    if ( have_posts() ) : while ( have_posts() ) : the_post();
    $pageLayout     = ceris_single::bk_get_post_option($pageID, 'bk_page_layout');     
?>
<div class="site-content atbs-style-page-content-store">
    <?php 
        if ( is_page() && ! is_front_page() ) : 
            if($pageLayout == 'has_sidebar') {
                $sidebar    = ceris_single::bk_get_post_option($pageID, 'bk_page_sidebar_select');
                if($sidebar == '') {
                    $sidebar = 'home_sidebar';
                }
                if(is_active_sidebar($sidebar)) {
                    get_template_part( '/library/templates/page/page_with__sidebar'); //with-sidebar
                }else {
                    get_template_part( '/library/templates/page/page_fw' ); //full-width
                }
            }else if($pageLayout == 'no_sidebar') {
                get_template_part( '/library/templates/page/page_fw' ); //full-width
            }
        endif;
    ?>
</div>

<?php endwhile; endif;?>
 <?php get_footer(); ?>