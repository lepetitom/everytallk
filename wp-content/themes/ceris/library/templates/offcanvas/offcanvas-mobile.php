<?php 
    $ceris_option = ceris_core::bk_get_global_var('ceris_option');
    if ((isset($ceris_option['bk-offcanvas-mobile-logo'])) && (($ceris_option['bk-offcanvas-mobile-logo']) != NULL)){ 
        $logo = $ceris_option['bk-offcanvas-mobile-logo'];
        if (($logo != null) && (array_key_exists('url',$logo))) {
            if ($logo['url'] == '') {
                $logo = ceris_core::bk_get_theme_option('bk-logo');
            }
        }
    }else {
        $logo = ceris_core::bk_get_theme_option('bk-logo');
    }
?>
<!-- Off-canvas menu -->
<div id="atbs-ceris-offcanvas-mobile" class="atbs-ceris-offcanvas js-atbs-ceris-offcanvas js-perfect-scrollbar">
	<div class="atbs-ceris-offcanvas__title">
		<h2 class="site-logo">
            <a href="<?php echo esc_url(get_home_url('/'));?>">
				<!-- logo open -->
                <?php if (($logo != null) && (array_key_exists('url',$logo))) {
                        if ($logo['url'] != '') {
                    ?>
                    <img src="<?php echo esc_url($logo['url']);?>" alt="<?php esc_attr_e('logo', 'ceris');?>"/>
    			<!-- logo close -->
                <?php } else {?>
                    <?php echo (bloginfo( 'name' ));?>
                <?php }
                } else {?>
                    <?php echo (bloginfo( 'name' ));?>
                <?php } ?>
			</a>
        </h2>
        <?php if ( isset($ceris_option ['bk-offcanvas-mobile-social']) && ($ceris_option ['bk-offcanvas-mobile-social'] != '') ){ ?>
		<ul class="social-list list-horizontal">
			<?php echo ceris_core::bk_get_social_media_links($ceris_option['bk-offcanvas-mobile-social']);?>
		</ul>
        <?php }?>
		<a href="#atbs-ceris-offcanvas-mobile" class="atbs-ceris-offcanvas-close js-atbs-ceris-offcanvas-close" aria-label="Close"><span aria-hidden="true">&#10005;</span></a>
	</div>

	<div class="atbs-ceris-offcanvas__section atbs-ceris-offcanvas__section-navigation">
		<?php 
            if ( isset($ceris_option ['bk-offcanvas-mobile-menu']) && ($ceris_option ['bk-offcanvas-mobile-menu'] != '') ){
                if ( has_nav_menu( $ceris_option ['bk-offcanvas-mobile-menu'] ) ) : 
                    $menuSettings = array( 
                        'theme_location' => $ceris_option ['bk-offcanvas-mobile-menu'],
                        'container_id' => 'offcanvas-menu-mobile',
                        'menu_class'    => 'navigation navigation--offcanvas',
                        'depth' => '5' 
                    );
                    wp_nav_menu($menuSettings);
                elseif ( has_nav_menu( 'main-menu' ) ) : 
                    $menuSettings = array( 
                        'theme_location' => 'main-menu',
                        'container_id' => 'offcanvas-menu-mobile',
                        'menu_class'    => 'navigation navigation--offcanvas',
                        'depth' => '5' 
                    );
                    wp_nav_menu($menuSettings);
                endif;
            }
        ?>
	</div>
    
    <?php if(isset($ceris_option['bk-offcanvas-mobile-mailchimp-shortcode']) && ($ceris_option['bk-offcanvas-mobile-mailchimp-shortcode'] != '')) :?>
	<div class="atbs-ceris-offcanvas__section">
		<div class="subscribe-form subscribe-form--horizontal text-center">
            <?php echo do_shortcode($ceris_option['bk-offcanvas-mobile-mailchimp-shortcode']);?>
		</div>
	</div>
    <?php endif;?>

</div><!-- Off-canvas menu -->