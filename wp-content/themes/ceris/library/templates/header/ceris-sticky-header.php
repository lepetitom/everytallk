<?php 
    $ceris_option = ceris_core::bk_get_global_var('ceris_option');
    if ((isset($ceris_option['bk-sticky-header-logo'])) && (($ceris_option['bk-sticky-header-logo']) != NULL)){ 
        $stickyLogo = $ceris_option['bk-sticky-header-logo'];
        if (($stickyLogo != null) && (array_key_exists('url',$stickyLogo))) {
            if ($stickyLogo['url'] == '') {
                $stickyLogo = ceris_core::bk_get_theme_option('bk-logo');
            }
        }
    }else {
        $stickyLogo = ceris_core::bk_get_theme_option('bk-logo');
    }
    
    $stickyLogoOption  = ceris_core::bk_get_theme_option('bk-sticky-logo-size-option');
    if($stickyLogoOption == 'customize') {
        $stickyLogoW   = ceris_core::bk_get_theme_option('site-sticky-logo-width');
    }else {
        $stickyLogoW = '';
    }
        
    if ((isset($ceris_option['bk-sticky-menu-inverse'])) && (($ceris_option['bk-sticky-menu-inverse']) == 1)){ 
        $inverseClass = 'navigation-bar--inverse';
        $socialInverseClass = 'social-list--inverse';
    }else {
        $inverseClass = '';
        $socialInverseClass = '';
    }
    
    $bkHeaderType = '';
    $bkStickyNavClass = '';
    if ((isset($ceris_option['bk-header-type'])) && (($ceris_option['bk-header-type']) != NULL)){ 
        $bkHeaderType = $ceris_option['bk-header-type'];
    }else {
        $bkHeaderType == 'site-header-1';
    }
    
    $bkStickyNavClass = 'navigation-bar navigation-bar--fullwidth hidden-xs hidden-sm '.$inverseClass;
    
    //Scroll Single Percent SW
    $scrollSinglePercentSW = $ceris_option['bk-scroll-percent-sw'];
    if($scrollSinglePercentSW == 'On') :
        $scrollSinglePercentSW = 1;
    endif;
    if(is_single()) {
        $currentPostID = get_the_ID();
        $article_wcount = ceris_single::article_wcount($currentPostID);
    }else {
        $currentPostID = '';
        $article_wcount = '';
    }
    $cerisWcnt = isset($ceris_option['bk-wcount-per-min']) ? $ceris_option['bk-wcount-per-min'] : 130;
?>
<!-- Sticky header -->
<div id="atbs-ceris-sticky-header" class="sticky-header js-sticky-header <?php if(is_single()) {echo 'article-header-nav-hide';}?>">
	<!-- Navigation bar -->
	<nav class="<?php echo esc_html($bkStickyNavClass);?>">
		<div class="navigation-bar__inner">
			<div class="navigation-bar__section">
                <div class="flexbox">
                    <?php if (is_active_sidebar('offcanvas-widget-area') || has_nav_menu( 'main-menu' ) || has_nav_menu( 'offcanvas-menu' )):?> 
                        <?php if ( isset($ceris_option ['bk-offcanvas-desktop-switch']) && ($ceris_option ['bk-offcanvas-desktop-switch'] != 0) ):?>
                            <?php if ($bkHeaderType != 'site-header-4') :?>
                            <div class="menu-icon">
                                <a href="#atbs-ceris-offcanvas-primary" class="offcanvas-menu-toggle navigation-bar-btn js-atbs-ceris-offcanvas-toggle">
                                    <span></span>
                                </a>
                            </div>
                            <?php endif;?>
                        <?php endif;?>
                    <?php endif;?>
                    <?php if (($stickyLogo != null) && (array_key_exists('url',$stickyLogo))) {
                            if ($stickyLogo['url'] != '') {
                    ?>
    				<div class="site-logo header-logo">
    					<a href="<?php echo esc_url(get_home_url('/'));?>">                    
                            <img src="<?php echo esc_url($stickyLogo['url']);?>" alt="<?php esc_attr_e('logo', 'ceris');?>" <?php if($stickyLogoW != '') {echo 'width="'.esc_attr($stickyLogoW).'"';}?>/>
                        </a>
    				</div>
                    <?php 
                            }
                        } 
                    ?> 
                </div>
			</div>
            <?php if(is_single()) {?>
            <div class="header-current-reading-article flexbox-wrap flexbox-center-xy">
                <div class="current-reading-article-label flexbox-wrap flexbox-center-xy">
                    <span><?php esc_html_e('Now Reading', 'ceris');?></span>
                </div>
                <div class="current-reading-title">
                    <h5><?php echo get_the_title($currentPostID);?></h5>
                </div>
                <div class="ceris-article-wpm--wrap flexbox-wrap flexbox-center-y">
                    <span class="ceris-article-wpm"><?php echo (intval($article_wcount/$cerisWcnt) + 1);?></span><?php esc_html_e('min read', 'ceris');?>
                </div>
            </div>
            <?php }?>
			<div class="navigation-wrapper navigation-bar__section js-priority-nav">
				<?php 
                    $sticky_header = true; $fw_navbar = true;
                    if ( has_nav_menu( 'main-menu' ) ) : 
                        $menuSettings = array( 
                            'theme_location' => 'main-menu',
                            'container_id' => 'sticky-main-menu',
                            'menu_class'    => 'navigation navigation--main navigation--inline',
                            'walker' => new BK_Walker,
                            'depth' => '5' 
                        );
                        wp_nav_menu($menuSettings);
                    endif;
                ?>
			</div>
            
            <?php if (($bkHeaderType == 'site-header-5') || ($bkHeaderType == 'site-header-6')) {?>
            <div class="navigation-bar__section">
                <?php if ( isset($ceris_option ['bk-social-header']) && !empty($ceris_option ['bk-social-header']) ){ ?>
    					<ul class="social-list list-horizontal <?php if($socialInverseClass != '') echo esc_attr($socialInverseClass);?>">
    						<?php echo ceris_core::bk_get_social_media_links($ceris_option['bk-social-header']);?>            						
    					</ul>
                <?php }?> 
			</div>
            <?php }?>
            <div class="navigation-bar__section lwa lwa-template-modal has-bookmark-list flexbox-wrap flexbox-center-y">
                <?php if(is_single()) {?>
                <div class="header-article-nav-icon flexbox-wrap flexbox-center-y" title="<?php esc_attr_e('Navigation Switcher', 'ceris');?>">
                    <svg xmlns="http://www.w3.org/2000/svg" height="490pt" viewBox="0 -10 490.66667 490" width="490pt">
                        <path d="m474.667969 251h-309.335938c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h309.335938c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"/>
                        <path d="m250.667969 336.332031c-4.097657 0-8.191407-1.554687-11.308594-4.691406l-85.332031-85.332031c-6.25-6.253906-6.25-16.386719 0-22.636719l85.332031-85.332031c6.25-6.25 16.382813-6.25 22.636719 0 6.25 6.25 6.25 16.382812 0 22.632812l-74.027344 74.027344 74.027344 74.027344c6.25 6.25 6.25 16.382812 0 22.632812-3.136719 3.117188-7.234375 4.671875-11.328125 4.671875zm0 0"/><path d="m234.667969 469.667969c-129.386719 0-234.667969-105.28125-234.667969-234.667969s105.28125-234.667969 234.667969-234.667969c97.085937 0 182.804687 58.410157 218.410156 148.824219 3.242187 8.210938-.8125 17.492188-9.023437 20.753906-8.214844 3.203125-17.496094-.789062-20.757813-9.042968-30.742187-78.082032-104.789063-128.535157-188.628906-128.535157-111.746094 0-202.667969 90.925781-202.667969 202.667969s90.921875 202.667969 202.667969 202.667969c83.839843 0 157.886719-50.453125 188.628906-128.511719 3.242187-8.257812 12.523437-12.246094 20.757813-9.046875 8.210937 3.242187 12.265624 12.542969 9.023437 20.757813-35.605469 90.390624-121.324219 148.800781-218.410156 148.800781zm0 0"/>
                    </svg>
                </div>
                <?php }?>
                <?php get_template_part( 'library/templates/bookmark/bookmark' ); ?>
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
                            if ($bkHeaderType == 'site-header-4') {
                                echo '<a href="#login-modal" class="navigation-bar__login-btn navigation-bar-btn" data-toggle="modal" data-target="#login-modal"><i class="mdicon mdicon-person"></i><span>'.esc_html__('Login', 'ceris').'</span></a>';
                            }else {
                                echo '<a href="#login-modal" class="navigation-bar__login-btn navigation-bar-btn" data-toggle="modal" data-target="#login-modal"><i class="mdicon mdicon-person"></i></a>';
                            }
                        }
                }?>
                <?php 
                if ($bkHeaderType == 'site-header-4') {
                    echo '<button type="submit" class="navigation-bar-btn js-search-popup p-l-xs"><i class="mdicon mdicon-search"></i>'.esc_html__('Search', 'ceris').'</button>';
                }else {
                    echo '<button type="submit" class="navigation-bar-btn js-search-popup p-l-xs"><i class="mdicon mdicon-search"></i></button>';
                }
				?>
            </div>
		</div><!-- .navigation-bar__inner -->
	</nav><!-- Navigation-bar -->
    <?php 
        if(is_user_logged_in()):
            if(is_single() && ($scrollSinglePercentSW != '') && ($scrollSinglePercentSW == 1)) :
                $scrollSinglePercentStyle = $ceris_option['bk-scroll-percent-style'];
                if($scrollSinglePercentStyle == 'bookmark') :
                    get_template_part( 'library/templates/header/atbs-scroll-single-percent-style-2');
                else:
                    get_template_part( 'library/templates/header/atbs-scroll-single-percent-style-1');
                endif;
            endif;
        else:
            get_template_part( 'library/templates/header/atbs-scroll-single-percent-style-1');
        endif;
    ?>
</div><!-- Sticky header -->