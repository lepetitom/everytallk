<?php 
    $ceris_option = ceris_core::bk_get_global_var('ceris_option');
    $logo   = ceris_core::bk_get_theme_option('bk-logo');
    $mobileLogo   = ceris_core::bk_get_theme_option('bk-mobile-logo');
    $logoSOption  = ceris_core::bk_get_theme_option('bk-site-logo-size-option');
    if($logoSOption == 'customize') {
        $logoW   = ceris_core::bk_get_theme_option('site-logo-width');
    }else {
        $logoW = '';
    }
    $mLogoSOption  = ceris_core::bk_get_theme_option('bk-mobile-logo-size-option');
    if($mLogoSOption == 'customize') {
        $mLogoW   = ceris_core::bk_get_theme_option('site-mobile-logo-width');
    }else {
        $mLogoW = '';
    }
    if ((isset($ceris_option['bk-header-inverse'])) && (($ceris_option['bk-header-inverse']) == 1)){ 
        $inverseClass = 'yes';
    }else {
        $inverseClass = '';
    }
    
    if ((isset($ceris_option['bk-mobile-menu-inverse'])) && (($ceris_option['bk-mobile-menu-inverse']) == 1)){ 
        $inverseClass_Mobile = 'yes';
    }else {
        $inverseClass_Mobile = '';
    }
    $cerisAds = 'enable';
    if((isset($ceris_option['bk-header-ads'])) && ($ceris_option['bk-header-ads'] == 1)) {
        $cerisAds = 'enable';
    }else {
        $cerisAds = 'disable';
    }
    
    if ((isset($ceris_option['bk-header-element-inverse'])) && (($ceris_option['bk-header-element-inverse']) == 1)){ 
        $inverseHeaderElements = 'yes';
    }else {
        $inverseHeaderElements = '';
    }
?>
<header class="site-header site-header--skin-3">
    <!-- Header content -->
	<div class="header-main hidden-xs hidden-sm <?php if($inverseClass == "yes") echo " header-main--inverse";?>">
        <?php if (isset($ceris_option['bk-header-bg-style']) && ($ceris_option['bk-header-bg-style'] == 'image')) :?>
		<div class="background-img-wrapper">
			<div class="background-img"></div>
		</div>
        <?php endif;?>
		<div class="container">
			<div class="row row--flex row--vertical-center">
				<div class="col-xs-4">
					<div class="site-logo header-logo text-left">
						<a href="<?php echo esc_url(get_home_url('/'));?>">
    						<!-- logo open -->
                            <?php if (($logo != null) && (array_key_exists('url',$logo))) {
                                    if ($logo['url'] != '') {
                                ?>
                                <img src="<?php echo esc_url($logo['url']);?>" alt="<?php esc_attr_e('logo', 'ceris');?>" <?php if($logoW != '') {echo 'width="'.esc_attr($logoW).'"';}?>/>
                            <?php } else {?>
                                <span class="logo-text">
                                <?php bloginfo('name');?>
                                </span>
                            <?php }
                            } else {?>
                                <span class="logo-text">
                                <?php bloginfo('name');?>
                                </span>
                            <?php } ?>
                            <!-- logo close -->
    					</a>
					</div>
				</div>

				<div class="col-xs-8">
                    <?php if($cerisAds == 'enable') {?>
                        <div class="site-header__img">
                            <?php if ( isset($ceris_option ['bk-ads-html']) && !empty($ceris_option ['bk-ads-html']) ){ ?>
            					<?php echo ceris_core::ceris_html_render($ceris_option['bk-ads-html']);?>            						
                            <?php }?>
    					</div>
                    <?php }else {?>
    					<div class="site-header__social">
                            <?php if ( isset($ceris_option ['bk-social-header']) && !empty($ceris_option ['bk-social-header']) ){ ?>
            					<ul class="<?php if($inverseHeaderElements == "yes") echo " social-list--inverse";?> social-list list-horizontal text-right">
            						<?php echo ceris_core::bk_get_social_media_links($ceris_option['bk-social-header']);?>            						
            					</ul>
                            <?php }?>
    					</div>
                    <?php }?>
				</div>
			</div>
		</div>
	</div><!-- Header content -->
    <!-- Mobile header -->
    <div id="atbs-ceris-mobile-header" class="mobile-header visible-xs visible-sm <?php if($inverseClass_Mobile == "yes") echo " mobile-header--inverse";?>">
    	<div class="mobile-header__inner mobile-header__inner--flex">
            <!-- mobile logo open -->
    		<div class="header-branding header-branding--mobile mobile-header__section text-left">
    			<div class="header-logo header-logo--mobile flexbox__item text-left">
                    <a href="<?php echo esc_url(get_home_url('/'));?>">
                        <?php if (($mobileLogo != null) && (array_key_exists('url',$mobileLogo))) {
                            if ($mobileLogo['url'] != '') {
                        ?>                    
                        <img src="<?php echo esc_url($mobileLogo['url']);?>" alt="<?php esc_attr_e('logo', 'ceris');?>" <?php if($mLogoW != '') {echo 'width="'.esc_attr($mLogoW).'"';}?>/>
                        <?php 
                        } else {?>
                                <span class="logo-text">
                                <?php bloginfo('name');?>
                                </span>
                        <?php }
                        } else {?>
                            <span class="logo-text">
                            <?php bloginfo('name');?>
                            </span>
                        <?php } ?>                        
                    </a>               
    			</div>
    		</div>
            <!-- logo close -->
    		<div class="mobile-header__section text-right">
    			<div class="flexbox <?php if(is_user_logged_in()) echo 'has-bookmark-list';?>">
                    <?php
                        if(is_user_logged_in()) : 
                            get_template_part( 'library/templates/bookmark/header-bookmark-mobile' ); 
                        endif;        
                    ?>
                    <button type="submit" class="mobile-header-btn js-search-popup">
        				<span class="hidden-xs"></span><i class="mdicon mdicon-search mdicon--last hidden-xs"></i><i class="mdicon mdicon-search visible-xs-inline-block"></i>
        			</button>
                    <?php if (is_active_sidebar('mobile-offcanvas-widget-area') || has_nav_menu( 'main-menu' ) || has_nav_menu( 'offcanvas-menu' )):?>
                    <div class="menu-icon">
                        <a href="#atbs-ceris-offcanvas-mobile" class="offcanvas-menu-toggle mobile-header-btn js-atbs-ceris-offcanvas-toggle">
                            <span class="mdicon--last hidden-xs"></span>
                            <span class="visible-xs-inline-block"></span>
                        </a>
                    </div>
                    <?php endif;?>
                </div>
    		</div>
    	</div>
    </div><!-- Mobile header -->
    <!-- Navigation bar -->
	<nav class="navigation-bar <?php if($inverseClass == "yes") echo " navigation-bar--inverse"; ?> navigation-bar--fullwidth navigation-custom-bg-color hidden-xs hidden-sm js-sticky-header-holder">
		<div class="container">
			<div class="navigation-bar__inner">
                <?php if (is_active_sidebar('offcanvas-widget-area') || has_nav_menu( 'main-menu' ) || has_nav_menu( 'offcanvas-menu' )):?>
                    <?php if ( isset($ceris_option ['bk-offcanvas-desktop-switch']) && ($ceris_option ['bk-offcanvas-desktop-switch'] != 0) ){ ?>
    				<div class="navigation-bar__section">
    					<div class="menu-icon">
                            <a href="#atbs-ceris-offcanvas-primary" class="offcanvas-menu-toggle navigation-bar-btn js-atbs-ceris-offcanvas-toggle">
                                <span></span>
                            </a>
                        </div>
    				</div>
                    <?php }?>
                <?php endif;?>

				<div class="navigation-wrapper navigation-bar__section js-priority-nav">
					<?php 
                        if ( has_nav_menu( 'main-menu' ) ) : 
                            $menuSettings = array( 
                                'theme_location' => 'main-menu',
                                'container_id' => 'main-menu',
                                'menu_class'    => 'navigation navigation--main navigation--inline',
                                'walker' => new BK_Walker,
                            );
                            wp_nav_menu($menuSettings);
                        endif;
                    ?>
				</div>

				<div class="navigation-bar__section lwa lwa-template-modal flexbox-wrap flexbox-center-y <?php if(is_user_logged_in()) echo 'has-bookmark-list';?>">
                    <?php
                        if(is_user_logged_in()) : 
                            get_template_part( 'library/templates/bookmark/header-bookmark' ); 
                        endif;        
                    ?>
                    <?php 
                        if ( function_exists('login_with_ajax') ) {  
                            $bk_home_url = esc_url(get_home_url('/'));
                            $ajaxArgs = array(
                                'profile_link' => true,
                                'template' => 'modal',
                                'registration' => true,
                                'remember' => true,
                                'redirect'  => $bk_home_url
                            );
                            login_with_ajax($ajaxArgs);  
                            if(!is_user_logged_in()) {
                                echo '<a href="#login-modal" class="navigation-bar__login-btn navigation-bar-btn" data-toggle="modal" data-target="#login-modal"><i class="mdicon mdicon-person"></i></a>';
                            }
                    }?>
    				<button type="submit" class="navigation-bar-btn js-search-popup"><i class="mdicon mdicon-search"></i></button>
                </div>
			</div><!-- .navigation-bar__inner -->
		</div><!-- .container -->
	</nav><!-- Navigation-bar -->
</header><!-- Site header -->