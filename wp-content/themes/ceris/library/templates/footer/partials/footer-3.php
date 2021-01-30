<?php 
    $ceris_option = ceris_core::bk_get_global_var('ceris_option');
    if ((isset($ceris_option['bk-footer-inverse'])) && (($ceris_option['bk-footer-inverse']) == 1)){ 
        $inverseClass = 'yes';
    }else {
        $inverseClass = '';
    }
?>	
<footer class="site-footer footer-3 <?php if($inverseClass == "yes") echo " site-footer--inverse inverse-text";?>">
    <div class="site-footer__inner">
        <?php if(isset($ceris_option['footer-mailchimp--shortcode']) && ($ceris_option['footer-mailchimp--shortcode'] != '')) :?>
        <div class="site-footer__section">
			<div class="container">
				<div class="subscribe-form subscribe-form--horizontal text-center max-width-sm">
					<?php echo ceris_footer::bk_footer_mailchimp();?>
				</div>
			</div>
        </div>
        <?php endif;?>
    </div>
    <div class="site-footer__section site-footer__section--bordered-inner site-footer__section--flex">
        <div class="container">
			<div class="site-footer__section-inner">
                <?php if ( has_nav_menu( 'footer-menu' ) ) : ?>
                <div class="site-footer__section-left">
                    <?php 
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer-menu', 
                            'depth' => '1', 
                            'menu_class' => 'navigation navigation--footer navigation--inline',
                            )
                        ); 
                    ?>
                </div>
                <?php endif;?>
                <?php if(isset($ceris_option['footer-copyright-text']) && ($ceris_option['footer-copyright-text'] != '')) :?>
                <div class="site-footer__section-right">
                    <?php
                        $ceris_allow_html = array(
                            'a' => array(
                                'href' => array(),
                                'title' => array()
                            ),
                            'br' => array(),
                            'em' => array(),
                            'strong' => array(),
                        );
                        echo wp_kses($ceris_option['footer-copyright-text'], $ceris_allow_html);
                    ?>
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</footer>
<?php 
    if((isset($ceris_option['bk-sticky-menu-switch'])) && ($ceris_option['bk-sticky-menu-switch'] == 1)):
        get_template_part( 'library/templates/header/ceris-sticky-header' );
    endif;
    
    if ( function_exists('login_with_ajax') ) {
        get_template_part( 'library/templates/ceris-login-modal' );
    }
    
    if ( isset($ceris_option ['bk-offcanvas-desktop-switch']) && ($ceris_option ['bk-offcanvas-desktop-switch'] != 0) ){
        get_template_part( 'library/templates/offcanvas/offcanvas-desktop' );
    }
    
    get_template_part( 'library/templates/offcanvas/offcanvas-mobile' );
    
    if((isset($ceris_option['bk-header-subscribe-switch'])) && ($ceris_option['bk-header-subscribe-switch'] == 1)):
        get_template_part( 'library/templates/ceris-subscribe-modal' );
    endif;
    get_template_part( 'library/templates/header/header-search-popup' );
    
?>
<!-- go top button -->
<a href="#" class="atbs-ceris-go-top btn btn-default hidden-xs js-go-top-el"><i class="mdicon mdicon-arrow_upward"></i></a>