<?php 
    $ceris_option = ceris_core::bk_get_global_var('ceris_option');
    if ((isset($ceris_option['bk-offcanvas-desktop-logo'])) && (($ceris_option['bk-offcanvas-desktop-logo']) != NULL)){ 
        $logo = $ceris_option['bk-offcanvas-desktop-logo'];
        if (($logo != null) && (array_key_exists('url',$logo))) {
            if ($logo['url'] == '') {
                $logo = ceris_core::bk_get_theme_option('bk-logo');
            }
        }
    }else {
        $logo = ceris_core::bk_get_theme_option('bk-logo');
    }
    
    $ceris_option_show_row = '';
    
    if((is_active_sidebar('offcanvas-expand-col-1-area'))  && (is_active_sidebar('offcanvas-expand-col-2-area'))  ):
        $ceris_option_show_row = 'animation_2_row';
    elseif((is_active_sidebar('offcanvas-expand-col-1-area')) || (is_active_sidebar('offcanvas-expand-col-2-area'))):
        $ceris_option_show_row = 'animation_1_row';
    else:
        $ceris_option_show_row = 'animation_0_row';
    endif;
?>

<div id="atbs-ceris-offcanvas-primary" class="menu-wrap atbs-ceris-offcanvas animation_0_row js-atbs-ceris-offcanvas"> <!-- js-perfect-scrollbar-->
    <div class="atbs-ceris-offcanvas--inner js-perfect-scrollbar">
        <div class="atbs-ceris-offcanvas__section atbs-ceris-offcanvas__title border-right">
            <h2 class="site-logo">
                <a href="<?php echo esc_url(get_home_url('/'));?>">
    				<!-- logo open -->
                    <?php if (($logo != null) && (array_key_exists('url',$logo))) {
                            if ($logo['url'] != '') {
                        ?>
                        <img src="<?php echo esc_url($logo['url']);?>" alt="<?php esc_attr_e('logo', 'ceris');?>"/>
        			<!-- logo close -->
                    <?php }
                    } ?>
    			</a>
            </h2>
             <?php if ( isset($ceris_option ['bk-offcanvas-desktop-social']) && ($ceris_option ['bk-offcanvas-desktop-social'] != '') ){ ?>
        		<ul class="social-list list-horizontal">
        			<?php echo ceris_core::bk_get_social_media_links($ceris_option['bk-offcanvas-desktop-social']);?>
        		</ul>
            <?php }?>
            <a href="#atbs-ceris-offcanvas-primary" class="close-button atbs-ceris-offcanvas-close js-atbs-ceris-offcanvas-close" aria-label="Close">
                <div class="atbs-ceris-offcanvas-close--wrap">
                    <span aria-hidden="true">&#10005;</span>
                    <span class="label-icon"><?php esc_html_e('Close', 'ceris');?></span>
                </div>
            </a>
        </div>
        <div class="atbs-ceris-offcanvas__section atbs-ceris-offcanvas__section-navigation border-right">
            <div class="atbs-ceris-offcanvas__section-navigation--wrap">
                <?php 
                    if ( isset($ceris_option ['bk-offcanvas-desktop-menu']) && ($ceris_option ['bk-offcanvas-desktop-menu'] != '') ){
                        if ( has_nav_menu( $ceris_option ['bk-offcanvas-desktop-menu'] ) ) : 
                            $menuSettings = array( 
                                'theme_location' => $ceris_option ['bk-offcanvas-desktop-menu'],
                                'container_id' => 'offcanvas-menu-desktop',
                                'menu_class'    => 'navigation navigation--offcanvas',
                                'depth' => '5' 
                            );
                            wp_nav_menu($menuSettings);
                        elseif ( has_nav_menu( 'main-menu' ) ) : 
                            $menuSettings = array( 
                                'theme_location' => 'main-menu',
                                'container_id' => 'offcanvas-menu-desktop',
                                'menu_class'    => 'navigation navigation--offcanvas',
                                'depth' => '5' 
                            );
                            wp_nav_menu($menuSettings);
                        endif;   
                    }
                ?>
            </div>
        </div>
    </div>
</div>