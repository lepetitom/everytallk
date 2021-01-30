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
$adsCounter = 1;
$toRandomNumber = 0;
$singleInfinityAds = '';

for($adsCounter = 1; $adsCounter < 6; $adsCounter ++) {
    if(isset($ceris_option['ceris-ads-editor-'.$adsCounter]) && ($ceris_option['ceris-ads-editor-'.$adsCounter] != '')) {
        $toRandomNumber += 1;
    }
}
if($toRandomNumber != 0) {
    $randomAdsNumber = rand(1,$toRandomNumber);
    if(isset($ceris_option['ceris-ads-editor-'.$randomAdsNumber]) && ($ceris_option['ceris-ads-editor-'.$randomAdsNumber] != '')) {
        $singleInfinityAds = $ceris_option['ceris-ads-editor-'.$randomAdsNumber];
        $singleInfinityAds = '<div class="ceris-img-infinity-separator">'.$singleInfinityAds.'</div>';
    }else {
        $singleInfinityAds = '';
    }
}else {
    $singleInfinityAds = '';
}
if ((isset($ceris_option['bk-single-header-switch'])) && (($ceris_option['bk-single-header-switch']) == 1)){ 
    $bkHeaderType = ceris_core::bk_get_theme_option('bk-single-header-type');
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
    <div class="site-wrapper ceris-block-heading-loading ceris-dedicated-single-header ceris-tofind-single-separator <?php echo esc_attr(ceris_header::ceris_dedicated_page_header_class($bkHeaderType));?><?php echo esc_attr($mobileStickyHeader);?>" <?php if($singleInfinityAds != '') echo 'data-infinity-ads="'.htmlentities($singleInfinityAds).'"';?>>
        <?php
            ceris_header::ceris_get_header($bkHeaderType);
        ?>