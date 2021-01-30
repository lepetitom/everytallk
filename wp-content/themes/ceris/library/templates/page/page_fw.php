<?php
/**
 * The Default Page Template -- With Sidebar page template
 *
 */
 ?>
<?php
    $pageID  = get_the_ID();
    
    $headerStyle    = ceris_single::bk_get_post_option($pageID, 'bk_page_header_style');
    $sidebar        = ceris_single::bk_get_post_option($pageID, 'bk_page_sidebar_select');
    $sidebarPos     = ceris_single::bk_get_post_option($pageID, 'bk_page_sidebar_position');
    $sidebarSticky  = ceris_single::bk_get_post_option($pageID, 'bk_page_sidebar_sticky'); 
    $featuredImage  = ceris_single::bk_get_post_option($pageID, 'bk_page_feat_img');       
?>
<?php echo ceris_archive::render_page_heading($pageID, $headerStyle);?>
<div class="atbs-ceris-block atbs-ceris-block--fullwidth">
	<div class="container">
        <article <?php post_class();?>>
            <div class="single-content">
                <?php
                    if ( ($featuredImage != 0) && ceris_core::bk_check_has_post_thumbnail($pageID)) {
                        echo '<div class="entry-thumb single-entry-thumb">';
                        echo get_the_post_thumbnail($pageID, 'ceris-m-2_1');
        				echo '</div>';
                    }
                ?>
				<div class="entry-content typography-copy">
                    <?php the_content();?>
                </div>
                <?php echo ceris_single::bk_post_pagination();?>
            </div>
        </article>
        <?php if(comments_open()) {?>
            <div class="comments-section single-entry-section">
                <?php comments_template(); ?>
            </div> <!-- End Comment Box -->
        <?php }?>
    </div> <!-- .container -->
</div><!-- .atbs-ceris-block -->