<?php
/**
 * The main template file.
 */

get_header(); 
$pageID         = get_the_ID();
$ceris_option = ceris_core::bk_get_global_var('ceris_option');
$headingStyle = (isset($ceris_option['bk_woocommerce_header_style']) && ($ceris_option['bk_woocommerce_header_style'] != '')) ? $ceris_option['bk_woocommerce_header_style'] : 'center';
?>

<div class="site-content atbs-style-page-content-store">
    <div class="atbs-ceris-block atbs-ceris-block--fullwidth">
        <?php if ( ! is_singular( 'product' ) ) : ?>
        <?php echo ceris_woocommerce::render_page_heading($pageID, $headingStyle);?>
        <?php endif; ?>
        <div class="container">
            <div class="ceris-shop-page atbs-ceris-block-custom-margin">
                <div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>            			
        			<?php woocommerce_content(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
		
<?php get_footer(); ?>