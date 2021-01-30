<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
    
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    
    <link rel="profile" href="/gmpg.org/xfn/11" />
    
    <?php get_template_part( 'library/templates/single/single-schema-meta');?>
    
    <?php wp_head(); ?>
</head>
<?php
$ceris_option = ceris_core::bk_get_global_var('ceris_option');
if ((isset($ceris_option['bk-category-header-switch'])) && (($ceris_option['bk-category-header-switch']) == 1)){ 
    $bkHeaderType = ceris_core::bk_get_theme_option('bk-category-header-type');
}else {
    if ((isset($ceris_option['bk-header-type'])) && (($ceris_option['bk-header-type']) != NULL)){ 
        $bkHeaderType = $ceris_option['bk-header-type'];
        if($bkHeaderType == 'site-header-12') {
            $bkHeaderType = 'site-header-15';
        }
    }else {
        $bkHeaderType = 'site-header-1';
    }
}
if ((isset($ceris_option['bk-sticky-header-mobile-switch'])) && (($ceris_option['bk-sticky-header-mobile-switch']) != 0)){ 
    $mobileStickyHeader = ' ceris-mobile-header-sticky';
}else {
    $mobileStickyHeader = '';
}
?>
<body <?php body_class();?>>
    <?php
        if ( function_exists( 'wp_body_open' ) ) {
        	wp_body_open();
        }
    ?>
    <div class="site-wrapper ceris-dedicated-category-header ceris-block-heading-loading <?php echo esc_attr(ceris_header::ceris_dedicated_page_header_class($bkHeaderType));?><?php echo esc_attr($mobileStickyHeader);?>">
        <?php
            ceris_header::ceris_get_header($bkHeaderType);
        ?>