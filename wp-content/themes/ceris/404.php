<?php
/**
 * The template for 404 page (Not Found).
 *
 */
?>
<?php
    get_header();
    $ceris_option = ceris_core::bk_get_global_var('ceris_option');
    $logo   = ceris_core::bk_get_theme_option('404-logo');
    $logoW   = ceris_core::bk_get_theme_option('404-logo-width');
    $mainImage = ceris_core::bk_get_theme_option('bk-404-image');
    $mainText = ceris_core::bk_get_theme_option('404--main-text');
    $subText = ceris_core::bk_get_theme_option('404--sub-text');
    $search = ceris_core::bk_get_theme_option('404-search');
    
    $ceris_allow_html = array(
        'a' => array(
            'href' => array(),
            'title' => array()
        ),
        'b'  => array(
            'class' => array(),
        ),
        'br' => array(),
        'em' => array(),
        'strong' => array(),
    );
?>
<div class="site-content">
    <div class="container">
        <div class="page-404-logo site-logo text-center">
            <a href="<?php echo esc_url( home_url('/') ); ?>">
                <?php if (($logo != null) && (array_key_exists('url',$logo))) {
                        if ($logo['url'] != '') {
                    ?>
                    <img src="<?php echo esc_url($logo['url']);?>" alt="<?php esc_attr_e('logo', 'ceris');?>"  width="<?php echo esc_attr($logoW);?>"/>
        		<!-- logo close -->
                <?php } else {?>
                    <?php bloginfo( 'name' );?>
                <?php }
                } else {?>
                    <?php bloginfo( 'name' );?>
                <?php } ?>
            </a>
        </div>
        <div class="page-404-image">
            <?php if (($mainImage != null) && (array_key_exists('url',$mainImage)) && ($mainImage['url'] != '')) {?>
                <img src="<?php echo esc_url($mainImage['url']);?>" alt="<?php esc_attr_e('404', 'ceris');?>"/>
            <?php }else {?>
                <div class="page-404-title"><?php esc_html_e('404', 'ceris');?></div>
            <?php } ?>
		</div>
        <div class="page-404-text text-center">
			<p>
				<?php echo wp_kses($mainText, $ceris_allow_html);?>
			</p>
			<p>
				<?php echo wp_kses($subText, $ceris_allow_html);?>
			</p>
		</div>
        <div class="page-404-search">
            <form class="search-form search-form--inline" action="<?php echo esc_url(home_url('/')); ?>" method="get">
                <input type="text" name="s" class="search-form__input" placeholder="<?php esc_attr_e('Type here to search', 'ceris');?>" value="">
                <button type="submit" class="search-form__submit btn btn-primary"><?php esc_html_e('Search', 'ceris');?></button>
            </form>
		</div>
    </div>
</div>
<?php get_footer(); ?>