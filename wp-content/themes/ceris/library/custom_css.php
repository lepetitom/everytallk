<?php
if ( ! function_exists( 'ceris_custom_css' ) ) {  
    function hex2rgb($hex) {
    $hex = str_replace("#", "", $hex);
    
    if(strlen($hex) == 3) {
    $r = hexdec(substr($hex,0,1).substr($hex,0,1));
    $g = hexdec(substr($hex,1,1).substr($hex,1,1));
    $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
    $r = hexdec(substr($hex,0,2));
    $g = hexdec(substr($hex,2,2));
    $b = hexdec(substr($hex,4,2));
    }
    $rgb = array($r, $g, $b);
    
    return $rgb; // returns an array with the rgb values
    }
    function ceris_custom_css() {
        $ceris_option = ceris_core::bk_get_global_var('ceris_option');
        $ceris_css_output = '';
        
        $cat_opt = get_option('bk_cat_opt');
        
        if ( isset($ceris_option)):
            $primary_color = $ceris_option['bk-primary-color'];
            
            if(isset($ceris_option['bk-header-bg-style']) && ($ceris_option['bk-header-bg-style'] == 'gradient')) {
                if(isset($ceris_option['bk-header-bg-gradient']) && !empty($ceris_option['bk-header-bg-gradient'])) {
                    $ceris_gradient_bg = $ceris_option['bk-header-bg-gradient'];
                    $ceris_gradient_deg = $ceris_option['bk-header-bg-gradient-direction'];
                    if($ceris_gradient_deg == '') {
                        $ceris_gradient_deg = 90;
                    }
                    $ceris_css_output .= ".header-1 .header-main, 
                                        .header-2 .header-main, 
                                        .header-3 .site-header,
                                        .header-4 .navigation-bar,
                                        .header-5 .navigation-bar,
                                        .header-6 .navigation-bar,
                                        .header-7 .header-main,
                                        .header-8 .header-main,
                                        .header-9 .site-header,
                                        .header-10 .navigation-bar,
                                        .header-11 .navigation-bar,
                                        .header-13 .navigation-bar,
                                        .header-15 .header-main,
                                        .header-16 .navigation-bar,
                                        .header-17 .navigation-bar,
                                        .header-18 .navigation-bar,
                                        .header-12 .header-main
                                        {background: ".$ceris_gradient_bg['from'].";
                                        background: -webkit-linear-gradient(".$ceris_gradient_deg."deg, ".$ceris_gradient_bg['from']." 0, ".$ceris_gradient_bg['to']." 100%);
                                        background: linear-gradient(".$ceris_gradient_deg."deg, ".$ceris_gradient_bg['from']." 0, ".$ceris_gradient_bg['to']." 100%);}";   
                }
            }else if(isset($ceris_option['bk-header-bg-style']) && ($ceris_option['bk-header-bg-style'] == 'color')) {
                if(isset($ceris_option['bk-header-bg-color']) && !empty($ceris_option['bk-header-bg-color'])) {
                    $ceris_bg_color = $ceris_option['bk-header-bg-color'];
                    $ceris_css_output .= ".header-1 .header-main, 
                                        .header-2 .header-main, 
                                        .header-3 .site-header, 
                                        .header-4 .navigation-bar,
                                        .header-5 .navigation-bar,
                                        .header-6 .navigation-bar,
                                        .header-7 .header-main,
                                        .header-8 .header-main,
                                        .header-9 .site-header, 
                                        .header-10 .navigation-bar,
                                        .header-11 .navigation-bar,
                                        .header-13 .navigation-bar,
                                        .header-14 .header-main, 
                                        .header-14 .header-bg-main-color, 
                                        .header-15 .header-main,
                                        .header-16 .navigation-bar,
                                        .header-17 .navigation-bar,
                                        .header-18 .navigation-bar,
                                        .header-12 .header-main
                                        {background: ".$ceris_bg_color['background-color'].";}";
                }
            }
            if (isset($ceris_option['bk-sticky-menu-bg-style']) && ($ceris_option['bk-sticky-menu-bg-style'] == 'gradient')) {
                if(isset($ceris_option['bk-sticky-menu-bg-gradient']) && !empty($ceris_option['bk-sticky-menu-bg-gradient'])) {
                    $ceris_sticky_menu_gradient_bg = $ceris_option['bk-sticky-menu-bg-gradient'];
                    $ceris_sticky_menu_gradient_deg = $ceris_option['bk-sticky-menu-bg-gradient-direction'];
                    if($ceris_sticky_menu_gradient_deg == '') {
                        $ceris_sticky_menu_gradient_deg = 90;
                    }
                    $ceris_css_output .= ".sticky-header.is-fixed > .navigation-bar
                                        {background: ".$ceris_sticky_menu_gradient_bg['from'].";
                                        background: -webkit-linear-gradient(".$ceris_sticky_menu_gradient_deg."deg, ".$ceris_sticky_menu_gradient_bg['from']." 0, ".$ceris_sticky_menu_gradient_bg['to']." 100%);
                                        background: linear-gradient(".$ceris_sticky_menu_gradient_deg."deg, ".$ceris_sticky_menu_gradient_bg['from']." 0, ".$ceris_sticky_menu_gradient_bg['to']." 100%);}";   
                }
            }else if (isset($ceris_option['bk-sticky-menu-bg-style']) && ($ceris_option['bk-sticky-menu-bg-style'] == 'color')) {
                if(isset($ceris_option['bk-sticky-menu-bg-color']) && !empty($ceris_option['bk-sticky-menu-bg-color'])) {
                    $ceris_sticky_menu_bg_color = $ceris_option['bk-sticky-menu-bg-color'];
                    $ceris_css_output .= ".sticky-header.is-fixed > .navigation-bar
                                        {background: ".$ceris_sticky_menu_bg_color['background-color'].";}";
                }
            }
            if (isset($ceris_option['bk-mobile-menu-bg-style']) && ($ceris_option['bk-mobile-menu-bg-style'] == 'gradient')) {
                if(isset($ceris_option['bk-mobile-menu-bg-gradient']) && !empty($ceris_option['bk-mobile-menu-bg-gradient'])) {
                    $ceris_mobile_menu_gradient_bg = $ceris_option['bk-mobile-menu-bg-gradient'];
                    $ceris_mobile_menu_gradient_deg = $ceris_option['bk-mobile-menu-bg-gradient-direction'];
                    if($ceris_mobile_menu_gradient_deg == '') {
                        $ceris_mobile_menu_gradient_deg = 90;
                    }
                    $ceris_css_output .= "#atbs-ceris-mobile-header
                                        {background: ".$ceris_mobile_menu_gradient_bg['from'].";
                                        background: -webkit-linear-gradient(".$ceris_mobile_menu_gradient_deg."deg, ".$ceris_mobile_menu_gradient_bg['from']." 0, ".$ceris_mobile_menu_gradient_bg['to']." 100%);
                                        background: linear-gradient(".$ceris_mobile_menu_gradient_deg."deg, ".$ceris_mobile_menu_gradient_bg['from']." 0, ".$ceris_mobile_menu_gradient_bg['to']." 100%);}";   
                }
            }else if (isset($ceris_option['bk-mobile-menu-bg-style']) && ($ceris_option['bk-mobile-menu-bg-style'] == 'color')) {
                if(isset($ceris_option['bk-mobile-menu-bg-color']) && !empty($ceris_option['bk-mobile-menu-bg-color'])) {
                    $ceris_mobile_menu_bg_color = $ceris_option['bk-mobile-menu-bg-color'];
                    $ceris_css_output .= "#atbs-ceris-mobile-header
                                        {background: ".$ceris_mobile_menu_bg_color['background-color'].";}";
                }
            }
            if (isset($ceris_option['bk-footer-bg-style']) && ($ceris_option['bk-footer-bg-style'] == 'gradient')) {
                if(isset($ceris_option['bk-footer-bg-gradient']) && !empty($ceris_option['bk-footer-bg-gradient'])) {
                    $ceris_footer_gradient_bg = $ceris_option['bk-footer-bg-gradient'];
                    $ceris_footer_gradient_deg = $ceris_option['bk-footer-bg-gradient-direction'];
                    if($ceris_footer_gradient_deg == '') {
                        $ceris_footer_gradient_deg = 90;
                    }
                    $ceris_css_output .= ".site-footer, .footer-3.site-footer, .footer-5.site-footer
                                        {background: ".$ceris_footer_gradient_bg['from'].";
                                        background: -webkit-linear-gradient(".$ceris_footer_gradient_deg."deg, ".$ceris_footer_gradient_bg['from']." 0, ".$ceris_footer_gradient_bg['to']." 100%);
                                        background: linear-gradient(".$ceris_footer_gradient_deg."deg, ".$ceris_footer_gradient_bg['from']." 0, ".$ceris_footer_gradient_bg['to']." 100%);}";   
                }
            }else if (isset($ceris_option['bk-footer-bg-style']) && ($ceris_option['bk-footer-bg-style'] == 'color')) {
                if(isset($ceris_option['bk-footer-bg-color']) && !empty($ceris_option['bk-footer-bg-color'])) {
                    $ceris_footer_bg_color = $ceris_option['bk-footer-bg-color'];
                    $ceris_css_output .= ".site-footer, .footer-3.site-footer, .footer-5.site-footer, .footer-6.site-footer , .site-footer.footer-7 .site-footer__section:first-child, .site-footer.footer-8 .site-footer__section:first-child
                                        {background: ".$ceris_footer_bg_color['background-color'].";}";
                }
            }
            if (isset($ceris_option['bk-coming-soon-bg-style']) && ($ceris_option['bk-coming-soon-bg-style'] == 'gradient')) {
                if(isset($ceris_option['bk-coming-soon-bg-gradient']) && !empty($ceris_option['bk-coming-soon-bg-gradient'])) {
                    $ceris_cs_gradient_bg = $ceris_option['bk-coming-soon-bg-gradient'];
                    $ceris_cs_gradient_deg = $ceris_option['bk-coming-soon-bg-gradient-direction'];
                    if($ceris_cs_gradient_deg == '') {
                        $ceris_cs_gradient_deg = 90;
                    }
                    $ceris_css_output .= ".page-coming-soon .background-img>.background-overlay
                                        {background: ".$ceris_cs_gradient_bg['from'].";
                                        background: -webkit-linear-gradient(".$ceris_cs_gradient_deg."deg, ".$ceris_cs_gradient_bg['from']." 0, ".$ceris_cs_gradient_bg['to']." 100%);
                                        background: linear-gradient(".$ceris_cs_gradient_deg."deg, ".$ceris_cs_gradient_bg['from']." 0, ".$ceris_cs_gradient_bg['to']." 100%);}";   
                }
            }else if (isset($ceris_option['bk-coming-soon-bg-style']) && ($ceris_option['bk-coming-soon-bg-style'] == 'color')) {
                if(isset($ceris_option['bk-coming-soon-bg-color']) && !empty($ceris_option['bk-coming-soon-bg-color'])) {
                    $ceris_cs_bg_color = $ceris_option['bk-coming-soon-bg-color'];
                    $ceris_css_output .= ".page-coming-soon .background-img
                                        {background: ".$ceris_cs_bg_color['background-color'].";}";
                }
            }
            
            //option margin 
            if ((isset($ceris_option['bk-margin-block']['margin-bottom'])) && ($ceris_option['bk-margin-block']['margin-bottom'] != '')) {
                $ceris_css_output .= '.atbs-ceris-block:not(:last-child) {margin-bottom: '.$ceris_option['bk-margin-block']['margin-bottom'].';}';
            }
            
            if ((isset($ceris_option['bk-block-heading-margin']['margin-bottom'])) && ($ceris_option['bk-block-heading-margin']['margin-bottom'] != '')) {
                $ceris_css_output .= '@media(min-width: 576px){.atbs-ceris-block-custom-margin .block-heading:not(.widget__title){margin-bottom: '.$ceris_option['bk-block-heading-margin']['margin-bottom'].';} }';
            }
            
        endif;
        
        $ceris_css_output .= "::selection {color: #FFF; background: $primary_color;}";
        $ceris_css_output .= "::-webkit-selection {color: #FFF; background: $primary_color;}";
        $ceris_css_output .= '';
        $ceris_css_output .= ".scroll-count-percent .progress__value {stroke: $primary_color;}";

        $RGB_color = hex2rgb($primary_color);
        $Final_Rgb_color = implode(", ", $RGB_color);
        
        if ( ($primary_color) != null) :
            $ceris_css_output .= "  .ceris-feature-i .sub-posts .block-heading__view-all a, .atbs-ceris-carousel.atbs-ceris-carousel-post-vertical .owl-prev, .atbs-ceris-carousel.atbs-ceris-carousel-post-vertical .owl-next, .post--overlay-back-face .button__readmore:hover i, .post--vertical-has-media .list-index, .navigation--main .sub-menu li:hover>a, .infinity-single-trigger:before, .ceris-icon-load-infinity-single:before, .atbs-article-reactions .atbs-reactions-content.active .atbs-reaction-count, .atbs-article-reactions .atbs-reactions-content:active .atbs-reaction-count, .post-slider-text-align-center .owl-carousel .owl-prev, .post-slider-text-align-center .owl-carousel .owl-next, .ceris-category-tiles .owl-carousel .owl-prev, .ceris-category-tiles .owl-carousel .owl-next, 
                                    a.block-heading__secondary, .atbs-ceris-pagination a.btn-default, 
                                    .atbs-ceris-pagination a.btn-default:active, 
                                    .atbs-ceris-pagination a.btn-default:hover, 
                                    .atbs-ceris-pagination a.btn-default:focus, 
                                    .atbs-ceris-search-full .result-default, 
                                    .atbs-ceris-search-full .result-default .search-module-heading, 
                                    .search-module-heading, .atbs-ceris-post--grid-c-update .atbs-ceris-carousel.nav-circle .owl-prev, .single .entry-meta .entry-author__name, .pagination-circle .atbs-ceris-pagination__item.atbs-ceris-pagination__item-next:hover,
                                    .pagination-circle .atbs-ceris-pagination__item.atbs-ceris-pagination__item-prev:hover, 
                                    .atbs-ceris-video-has-post-list .main-post .post-type-icon, .widget-subscribe .subscribe-form__fields button, 
                                    .list-index, a, a:hover, a:focus, a:active, .color-primary, .site-title, 
                                    .entry-tags ul > li > a:hover, .social-share-label, .ceris-single .single-header--top .entry-author__name, .atbs-ceris-widget-indexed-posts-b .posts-list > li .post__title:after, .posts-navigation .post:hover .posts-navigation__label,
                                    .posts-navigation .post:hover .post__title, .sticky-ceris-post .cerisStickyMark i, .typography-copy blockquote:before, .comment-content blockquote:before, .listing--list-large .post__readmore:hover .readmore__text,
                                    .post--horizontal-reverse-big.post--horizontal-reverse-big__style-3 .post__readmore .readmore__text:hover, .reviews-score-average, .star-item.star-full i:before,
                                    .wc-block-grid__product-rating .star-rating span:before, .wc-block-grid__product-rating .wc-block-grid__product-rating__stars span:before,
                                    .woocommerce-message::before, .woocommerce-info::before, .woocommerce-error::before, .woocommerce-downloads .woocommerce-info:before
            {color: $primary_color;}";
            
            $ceris_css_output .= ".ceris-grid-j .icon-has-animation .btn-play-left-not-center.post-type-icon:after, div.wpforms-container-full .wpforms-form button[type=submit], div.wpforms-container-full .wpforms-form button[type=submit]:hover{background-color: $primary_color;} ";
            $ceris_css_output .= ".ceris-grid-j .btn-play-left-not-center .circle, .scroll-count-percent .btn-bookmark-icon .bookmark-status-saved path {fill: $primary_color;} ";
            $ceris_css_output .= ".infinity-single-trigger:before, .ceris-grid-j .btn-play-left-not-center .g-path path{fill: #fff;}";
            
            $ceris_css_output .= "@media(max-width: 768px) {.ceris-grid-j .icon-has-animation .btn-play-left-not-center.post-type-icon:after{background-color: #fff;} }";
            $ceris_css_output .= "@media(max-width: 768px) {.ceris-grid-j .btn-play-left-not-center .circle{fill: #fff;} } ";
            $ceris_css_output .= "@media(max-width: 768px) {.ceris-grid-j .btn-play-left-not-center .g-path path{fill: #000;} }";
            
            
            $ceris_css_output .= "@media(max-width: 768px) {.ceris-module-video .post-list-no-thumb-3i .posts-no-thumb .post-type-icon:after{background-color: $primary_color;} }";
            $ceris_css_output .= "@media(max-width: 768px) {.ceris-module-video .post-list-no-thumb-3i .list-item .posts-no-thumb:hover .post-type-icon:after{background-color: #fff;} }";
            $ceris_css_output .= "@media(max-width: 768px) {.ceris-module-video .post-list-no-thumb-3i .list-item:first-child .posts-no-thumb:hover .post-type-icon:after{background-color: #fff;} }";
            $ceris_css_output .= "@media(max-width: 768px) {.ceris-module-video .post-list-no-thumb-3i:hover .list-item:first-child .posts-no-thumb .post-type-icon:after{background-color: $primary_color;} }";
            $ceris_css_output .= "@media(max-width: 768px) {.ceris-module-video .post-list-no-thumb-3i .list-item:first-child .posts-no-thumb:hover .post-type-icon:after{background-color: #fff;} }";

            $ceris_css_output .= "@media (max-width: 380px){.featured-slider-d .owl-carousel .owl-dot.active span{background-color: $primary_color;}}";
            $ceris_css_output .= ".g-path path {fill: #000;} ";
            $ceris_css_output .= ".circle{fill: #fff;}";
            //color rgba ltp
            
            $ceris_css_output .= "@media(max-width: 576px) {.atbs-ceris-post--vertical-3i-row .post--vertical .post__cat{background-color: $primary_color;} }";
            
            $ceris_css_output .= ".atbs-article-reactions .atbs-reactions-content:hover{
                border-color: rgba($Final_Rgb_color,0.3);
            } ";
            $ceris_css_output .= ".post-no-thumb-height-default:hover{
                box-shadow: 0 45px 25px -20px rgba($Final_Rgb_color,0.27);
            } ";
            //
            $ceris_css_output .= ".ceris-feature-h .owl-item.active .post--overlay-height-275 .post__thumb--overlay.post__thumb:after{
                background-color: rgba($Final_Rgb_color,0.8);
            } ";


            $ceris_css_output .= ".post-list-no-thumb-3i .list-item:first-child:hover:before, .post-list-no-thumb-3i .list-item:hover:before{
                background-color: rgba($Final_Rgb_color, 0.4);
            } ";
            $ceris_css_output .= ".ceris-grid-carousel-d .owl-stage .post--card-overlay-middle-has-hidden-content:hover .post__thumb--overlay.post__thumb:after, .ceris-grid-carousel-d .owl-stage .owl-item.active.center .post--card-overlay-middle-has-hidden-content:hover .post__thumb--overlay.post__thumb:after{
                -webkit-box-shadow: 0px 20px 27px 0 rgba($Final_Rgb_color,0.2);
                box-shadow: 0px 20px 27px 0 rgba($Final_Rgb_color,0.2);
            } ";


            

            $ceris_css_output .= "@media(min-width:992px){
                                .post--overlay-hover-effect .post__thumb--overlay.post__thumb:after{
                                    background-color: $primary_color;
                                }
            }";

            $ceris_css_output .= ".atbs-ceris-block__aside-left .banner__button, .ceris-feature-k .atbs-ceris-carousel-nav-custom-holder .owl-prev:hover, .ceris-feature-k .atbs-ceris-carousel-nav-custom-holder .owl-next:hover, .ceris-feature-k .atbs-ceris-block__inner::before, .ceris-feature-i .atbs-ceris-carousel-nav-custom-holder .owl-prev:hover, .ceris-feature-i .atbs-ceris-carousel-nav-custom-holder .owl-next:hover, .ceris-feature-j .sub-posts .atbs-ceris-carousel-nav-custom-holder .owl-prev:hover, .ceris-feature-j .sub-posts .atbs-ceris-carousel-nav-custom-holder .owl-next:hover, .ceris-feature-h .owl-item.active + .owl-item.active .post--overlay-height-275 .post__cat-has-line:before, .atbs-ceris-carousel.atbs-ceris-carousel-post-vertical .owl-prev:hover, .atbs-ceris-carousel.atbs-ceris-carousel-post-vertical .owl-next:hover, .ceris-feature-f .button__readmore--round:hover i, .post--overlay-hover-effect .post__text-backface .post__readmore .button__readmore:hover,
             
             .post--overlay-hover-effect.post--overlay-bottom,
              .post--overlay-back-face,
              .pagination-circle .atbs-ceris-pagination__item:not(.atbs-ceris-pagination__dots):hover, .open-sub-col, .atbs-ceris-posts-feature-a-update .atbs-ceris-carousel.nav-circle .owl-prev:hover,
            .atbs-ceris-posts-feature-a-update .atbs-ceris-carousel.nav-circle .owl-next:hover, .owl-carousel.button--dots-center-nav .owl-prev:hover, .owl-carousel.button--dots-center-nav .owl-next:hover, .section-has-subscribe-no-border > .btn:focus, .section-has-subscribe-no-border > .btn:active, .section-has-subscribe-no-border > *:hover, .widget-slide .atbs-ceris-carousel .owl-dot.active span, .featured-slider-e .owl-carousel .owl-prev:hover, .featured-slider-e .owl-carousel .owl-next:hover, .post--horizontal-hasbackground.post:hover, .post-slider-text-align-center .owl-carousel .owl-prev:hover, .post-slider-text-align-center .owl-carousel .owl-next:hover, .atbs-ceris-pagination [class*='js-ajax-load-']:active, .atbs-ceris-pagination [class*='js-ajax-load-']:hover, .atbs-ceris-pagination [class*='js-ajax-load-']:focus, .atbs-ceris-widget-indexed-posts-a .posts-list>li .post__thumb:after, .post-list-no-thumb-3i:hover .list-item:first-child .post__cat:before, .header-17 .btn-subscribe-theme, .header-13 .btn-subscribe-theme, .header-16 .offcanvas-menu-toggle.navigation-bar-btn, .atbs-ceris-widget-posts-list.atbs-ceris-widget-posts-list-overlay-first ul:hover li.active .post--overlay .post__cat:before, .dots-circle .owl-dot.active span, .atbs-ceris-search-full .popular-tags .entry-tags ul > li > a, .atbs-ceris-search-full .form-control, .atbs-ceris-post--grid-g-update .post-grid-carousel .owl-dot.active span, .nav-row-circle .owl-prev:hover, .nav-row-circle .owl-next:hover, .post--grid--2i_row .post-no-thumb-title-line, .atbs-ceris-post--grid-d-update .post-no-thumb-title-line, .atbs-ceris-posts-feature .post-sub .list-item:hover .post__cat:before, .atbs-ceris-post--grid-c-update .post-main .owl-item.active + .owl-item.active .post__cat:before, .atbs-ceris-post--grid-c-update .atbs-ceris-carousel.nav-circle .owl-next, .atbs-ceris-post--grid-c-update .post-main .owl-item.active .post-no-thumb-title-line, .post-no-thumb-height-default:hover, .carousel-dots-count-number .owl-dot.active span, .header-16 .btn-subscribe-theme, .header-14 .btn-subscribe-theme, .header-11 .btn-subscribe-theme, .atbs-ceris-pagination [class*='js-ajax-load-'], .atbs-ceris-post--overlay-first-big .post--overlay:hover .background-img:after, .post-list-no-thumb-3i .list-item:hover, .post__cat-has-line:before, .category-tile__name, .cat-0.cat-theme-bg.cat-theme-bg, .primary-bg-color, .navigation--main > li > a:before, .atbs-ceris-pagination__item-current, .atbs-ceris-pagination__item-current:hover, 
            .atbs-ceris-pagination__item-current:focus, .atbs-ceris-pagination__item-current:active, .atbs-ceris-pagination--next-n-prev .atbs-ceris-pagination__links a:last-child .atbs-ceris-pagination__item,
            .subscribe-form__fields input[type='submit'], .has-overlap-bg:before, .post__cat--bg, a.post__cat--bg, .entry-cat--bg, a.entry-cat--bg, 
            .comments-count-box, .atbs-ceris-widget--box .widget__title, 
            .widget_calendar td a:before, .widget_calendar #today, .widget_calendar #today a, .entry-action-btn, .posts-navigation__label:before, 
            .comment-form .form-submit input[type='submit'], .atbs-ceris-carousel-dots-b .swiper-pagination-bullet-active,
             .site-header--side-logo .header-logo:not(.header-logo--mobile), .list-square-bullet > li > *:before, .list-square-bullet-exclude-first > li:not(:first-child) > *:before,
             .btn-primary, .btn-primary:active, .btn-primary:focus, .btn-primary:hover, 
             .btn-primary.active.focus, .btn-primary.active:focus, .btn-primary.active:hover, .btn-primary:active.focus, .btn-primary:active:focus, .btn-primary:active:hover, .header-10 .navigation--main > li > a:before, 
             .atbs-ceris-feature-slider .post__readmore, .atbs-ceris-grid-carousel .atbs-ceris-carousel .owl-dot:last-child.active span, .atbs-ceris-grid-carousel .atbs-ceris-carousel .owl-dot.active span,  
             .atbs-ceris-post-slide-has-list .atbs-ceris-post-slide-text-center .atbs-ceris-carousel .owl-dot.active span, 
             .pagination-circle .atbs-ceris-pagination__item:hover, .pagination-circle .atbs-ceris-pagination__item.atbs-ceris-pagination__item-current, .social-share-label:before, .social-share ul li a svg:hover, 
             .comment-form .form-submit input[type='submit'], input[type='button']:not(.btn), input[type='reset']:not(.btn), input[type='submit']:not(.btn), .form-submit input, 
             .comment-form .form-submit input[type='submit']:active, .comment-form .form-submit input[type='submit']:focus, .comment-form .form-submit input[type='submit']:hover,
             .reviews-rating .rating-form .rating-submit, .reviews-rating .rating-form .rating-submit:hover, .ceris-bookmark-page-notification,
             .rating-star, .score-item .score-percent, .ceris-grid-w .post-slide .owl-carousel, .widget-subscribe .widget-subscribe__inner,
             .ceris-grid-carousel-d .owl-stage .post--card-overlay-middle-has-hidden-content:hover .post__thumb--overlay.post__thumb:after, .ceris-grid-carousel-d .owl-stage .owl-item.active.center .post--card-overlay-middle-has-hidden-content:hover .post__thumb--overlay.post__thumb:after,
             .post--vertical-thumb-70-background .button__readmore--outline:hover i, .atbs-ceris-search-full--result .atbs-ceris-pagination .btn,
             .atbs-ceris-posts-feature-c-update.ceris-light-mode .owl-carousel .owl-prev:hover, .atbs-ceris-posts-feature-c-update.ceris-light-mode .owl-carousel .owl-next:hover,
             .editor-styles-wrapper .wc-block-grid__products .wc-block-grid__product .wc-block-grid__product-onsale, .wc-block-grid__product-onsale,
             .woocommerce .wc-block-grid__product .wp-block-button__link:hover, .woocommerce ul.products li.product .onsale, 
             .woocommerce .editor-styles-wrapper .wc-block-grid__products .wc-block-grid__product .wc-block-grid__product-onsale, .woocommerce .wc-block-grid__product-onsale,
             .woocommerce #respond input#submit, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover,
             .woocommerce .wp-block-button__link, .woocommerce .wp-block-button:not(.wc-block-grid__product-add-to-cart) .wp-block-button__link,
             .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current,
             .woocommerce div.product form.cart .button, .woocommerce div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-Tabs-panel .comment-reply-title:before,
             .woocommerce button.button, .woocommerce a.button.wc-backward, .woocommerce a.button.alt, .woocommerce a.button.alt:hover,
             .woocommerce-message a.button, .woocommerce-downloads .woocommerce-Message a.button,
             .woocommerce button.button.alt, .woocommerce button.button.alt:hover, .woocommerce.widget_product_search .woocommerce-product-search button,
             .woocommerce .widget_price_filter .ui-slider .ui-slider-range, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .header-current-reading-article .current-reading-article-label,
             #cookie-notice .cn-button, .atbs-ceris-widget-posts-list.atbs-ceris-widget-posts-list-overlay-first .posts-list:hover li.active  .post__cat:before,
             .ceris-mobile-share-socials ul li:hover a, .ceris-admin-delete-review
            {background-color: $primary_color;}";
            
            $ceris_css_output .= ".site-header--skin-4 .navigation--main > li > a:before
            {background-color: $primary_color !important;}";
            
            $ceris_css_output .= "@media(max-width: 767px){
                .atbs-ceris-post--grid-c-update .atbs-ceris-carousel.nav-circle .owl-prev,
                .atbs-ceris-post--grid-c-update .atbs-ceris-carousel.nav-circle .owl-next{
                        color: $primary_color !important;
                    }
                }";
                
            $ceris_css_output .= ".post-score-hexagon .hexagon-svg g path
            {fill: $primary_color;}";
            
            $ceris_css_output .= ".ceris-feature-k .atbs-ceris-carousel-nav-custom-holder .owl-prev:hover, .ceris-feature-k .atbs-ceris-carousel-nav-custom-holder .owl-next:hover, .ceris-feature-i .atbs-ceris-carousel-nav-custom-holder .owl-prev:hover, .ceris-feature-i .atbs-ceris-carousel-nav-custom-holder .owl-next:hover, .ceris-feature-j .sub-posts .atbs-ceris-carousel-nav-custom-holder .owl-prev:hover, .ceris-feature-j .sub-posts .atbs-ceris-carousel-nav-custom-holder .owl-next:hover, .post--overlay-line-top-hover:hover::after, .ceris-feature-f .button__readmore--round:hover i, .post--overlay-hover-effect .post__text-backface .post__readmore .button__readmore:hover, .ceris-about-module .about__content, .atbs-ceris-posts-feature-a-update .atbs-ceris-carousel.nav-circle .owl-prev:hover,
.atbs-ceris-posts-feature-a-update .atbs-ceris-carousel.nav-circle .owl-next:hover, .owl-carousel.button--dots-center-nav .owl-prev:hover, .owl-carousel.button--dots-center-nav .owl-next:hover, .atbs-article-reactions .atbs-reactions-content.active, .atbs-ceris-pagination [class*='js-ajax-load-']:active, .atbs-ceris-pagination [class*='js-ajax-load-']:hover, .atbs-ceris-pagination [class*='js-ajax-load-']:focus, .atbs-ceris-search-full--result .atbs-ceris-pagination .btn, .atbs-ceris-pagination [class*='js-ajax-load-'], .comment-form .form-submit input[type='submit'], .form-submit input:hover, .comment-form .form-submit input[type='submit']:active, .comment-form .form-submit input[type='submit']:focus, .comment-form .form-submit input[type='submit']:hover, .has-overlap-frame:before, .atbs-ceris-gallery-slider .fotorama__thumb-border, .bypostauthor > .comment-body .comment-author > img,
.post--vertical-thumb-70-background .button__readmore--outline:hover i, .block-heading.block-heading--style-7,
.atbs-ceris-posts-feature-c-update.ceris-light-mode .owl-carousel .owl-prev:hover,
.atbs-ceris-posts-feature-c-update.ceris-light-mode .owl-carousel .owl-next:hover,
.ceris-mobile-share-socials ul li:hover a,
.wc-block-grid__product .wp-block-button__link:hover, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover
            {border-color: $primary_color;}";
            
            $ceris_css_output .= ".atbs-ceris-pagination--next-n-prev .atbs-ceris-pagination__links a:last-child .atbs-ceris-pagination__item:after, .typography-copy blockquote, .comment-content blockquote
            {border-left-color: $primary_color;}";
            
            $ceris_css_output .= ".comments-count-box:before, .bk-preload-wrapper:after, .woocommerce-error, .woocommerce-message, .woocommerce-info
            {border-top-color: $primary_color;}";
            
            $ceris_css_output .= ".bk-preload-wrapper:after
            {border-bottom-color: $primary_color;}";
            
            $ceris_css_output .= ".navigation--offcanvas li > a:after
            {border-right-color: $primary_color;}";
            
            $ceris_css_output .= ".post--single-cover-gradient .single-header
            {
                background-image: -webkit-linear-gradient( bottom , $primary_color 0%, rgba(252, 60, 45, 0.7) 50%, rgba(252, 60, 45, 0) 100%);
                background-image: linear-gradient(to top, $primary_color 0%, rgba(252, 60, 45, 0.7) 50%, rgba(252, 60, 45, 0) 100%);
            }";
            $ceris_css_output .= "@media (max-width: 576px){
                .atbs-ceris-posts-feature .post-sub .list-item:nth-child(2), .atbs-ceris-posts-feature .post-sub .list-item:not(:nth-child(2)) .post__cat-has-line:before {
                    background-color: $primary_color;
                }
            }";

            $ceris_css_output .= "
                .ceris-feature-k .atbs-ceris-block__inner::before{
                    box-shadow: 
                    -210px 0 1px $primary_color, -180px 0 1px $primary_color, -150px 0 1px $primary_color, -120px 0 1px $primary_color, -90px 0 1px $primary_color, -60px 0 1px $primary_color, -30px 0 1px $primary_color, 30px 0 1px $primary_color, 60px 0 1px $primary_color,
                -210px 30px 1px $primary_color, -180px 30px 1px $primary_color, -150px 30px 1px $primary_color, -120px 30px 1px $primary_color, -90px 30px 1px $primary_color, -60px 30px 1px $primary_color, -30px 30px 1px $primary_color, 0 30px 1px $primary_color, 30px 30px 1px $primary_color, 60px 30px 1px $primary_color,
                -210px 60px 1px $primary_color, -180px 60px 1px $primary_color, -150px 60px 1px $primary_color, -120px 60px 1px $primary_color, -90px 60px 1px $primary_color, -60px 60px 1px $primary_color, -30px 60px 1px $primary_color, 0 60px 1px $primary_color, 30px 60px 1px $primary_color, 60px 60px 1px $primary_color,
                -210px 90px 1px $primary_color, -180px 90px 1px $primary_color, -150px 90px 1px $primary_color, -120px 90px 1px $primary_color, -90px 90px 1px $primary_color, -60px 90px 1px $primary_color, -30px 90px 1px $primary_color, 0 90px 1px $primary_color, 30px 90px 1px $primary_color, 60px 90px 1px $primary_color,
                -210px 120px 1px $primary_color, -180px 120px 1px $primary_color, -150px 120px 1px $primary_color, -120px 120px 1px $primary_color, -90px 120px 1px $primary_color, -60px 120px 1px $primary_color, -30px 120px 1px $primary_color, 0 120px 1px $primary_color, 30px 120px 1px $primary_color, 60px 120px 1px $primary_color,
                -210px 150px 1px $primary_color, -180px 150px 1px $primary_color, -150px 150px 1px $primary_color, -120px 150px 1px $primary_color, -90px 150px 1px $primary_color, -60px 150px 1px $primary_color, -30px 150px 1px $primary_color, 0 150px 1px $primary_color, 30px 150px 1px $primary_color, 60px 150px 1px $primary_color,
                -210px 180px 1px $primary_color, -180px 180px 1px $primary_color, -150px 180px 1px $primary_color, -120px 180px 1px $primary_color, -90px 180px 1px $primary_color, -60px 180px 1px $primary_color, -30px 180px 1px $primary_color, 0 180px 1px $primary_color, 30px 180px 1px $primary_color, 60px 180px 1px $primary_color,
                -210px 210px 1px $primary_color, -180px 210px 1px $primary_color, -150px 210px 1px $primary_color, -120px 210px 1px $primary_color, -90px 210px 1px $primary_color, -60px 210px 1px $primary_color, -30px 210px 1px $primary_color, 0 210px 1px $primary_color, 30px 210px 1px $primary_color, 60px 210px 1px $primary_color,
                -210px 240px 1px $primary_color, -180px 240px 1px $primary_color, -150px 240px 1px $primary_color, -120px 240px 1px $primary_color, -90px 240px 1px $primary_color, -60px 240px 1px $primary_color, -30px 240px 1px $primary_color, 0 240px 1px $primary_color, 30px 240px 1px $primary_color, 60px 240px 1px $primary_color,
                -210px 270px 1px $primary_color, -180px 270px 1px $primary_color, -150px 270px 1px $primary_color, -120px 270px 1px $primary_color, -90px 270px 1px $primary_color, -60px 270px 1px $primary_color, -30px 270px 1px $primary_color, 0 270px 1px $primary_color, 30px 270px 1px $primary_color, 60px 270px 1px $primary_color
                
                }
            ";
            
        endif;
        
        $ceris_css_output .= "atbs-ceris-video-box__playlist .is-playing .post__thumb:after { content: '".esc_html__( 'Now playing', 'ceris' )."'; }";
        
        $cat__terms = get_terms( array(
            'taxonomy' => 'category',
            'hide_empty' => true,
        ) );    
        if ((is_array($cat__terms))) :
            
            foreach ($cat__terms as $key => $cat__term) :
                $catColorVal  = ceris_core::ceris_rwmb_meta( 'bk_category__color', array( 'object_type' => 'term' ), $cat__term->term_id );  
                if($catColorVal != '') :
                    $ceris_css_output .= '.cat-'.$cat__term->term_id.' .cat-theme, 
                                        .cat-'.$cat__term->term_id.'.cat-theme.cat-theme, 
                                        .cat-'.$cat__term->term_id.' a:hover .cat-icon,
                                        .archive.category-'.$cat__term->term_id.' .block-heading .block-heading__title
                    {color: '.$catColorVal.' !important;}'; 
                    
                    $ceris_css_output .= '.cat-'.$cat__term->term_id.' .cat-theme-bg,
                                        .cat-'.$cat__term->term_id.'.cat-theme-bg.cat-theme-bg,
                                        .navigation--main > li.menu-item-cat-'.$cat__term->term_id.' > a:before,
                                        .cat-'.$cat__term->term_id.'.post--featured-a .post__text:before,
                                        .atbs-ceris-carousel-b .cat-'.$cat__term->term_id.' .post__text:before,
                                        .cat-'.$cat__term->term_id.' .has-overlap-bg:before,
                                        .cat-'.$cat__term->term_id.'.post--content-overlap .overlay-content__inner:before,
                                        .cat-'.$cat__term->term_id.'.post__cat-has-line:before,
                                        .cat-'.$cat__term->term_id.' .category-tile__name,
                                        .archive.category-'.$cat__term->term_id.' .block-heading.block-heading--style-1 .block-heading__title,
                                        .archive.category-'.$cat__term->term_id.' .block-heading.block-heading--style-2 .block-heading__title,
                                        .archive.category-'.$cat__term->term_id.' .block-heading.block-heading--style-3 .block-heading__title,
                                        .archive.category-'.$cat__term->term_id.' .block-heading.block-heading--style-9 .block-heading__title,
                                        .archive.category-'.$cat__term->term_id.' .block-heading.block-heading--style-9 .block-heading__title,
                                        .atbs-ceris-posts-feature .post-sub .list-item:hover a.post__cat.cat-'.$cat__term->term_id.':before, 
                                        .atbs-ceris-widget-posts-list.atbs-ceris-widget-posts-list-overlay-first .posts-list:hover li.active  .post__cat.cat-'.$cat__term->term_id.':before
                    {background-color: '.$catColorVal.' !important;}'; 
                    $ceris_css_output .= '@media(max-width: 576px ){
                                            .atbs-ceris-posts-feature .post-sub .list-item:not(:nth-child(2)) a.post__cat.cat-'.$cat__term->term_id.':before
                                            {
                                                background-color: '.$catColorVal.' !important;
                                            } 
                                        }
                    '; 
                    
                    $ceris_css_output .= '.cat-'.$cat__term->term_id.' .cat-theme-border,
                                        .cat-'.$cat__term->term_id.'.cat-theme-border.cat-theme-border,
                                        .atbs-ceris-featured-block-a .main-post.cat-'.$cat__term->term_id.':before,
                                        .cat-'.$cat__term->term_id.' .category-tile__inner:before,
                                        .cat-'.$cat__term->term_id.' .has-overlap-frame:before,
                                        .navigation--offcanvas li.menu-item-cat-'.$cat__term->term_id.' > a:after,
                                        .atbs-ceris-featured-block-a .main-post:before,
                                        .archive.category-'.$cat__term->term_id.' .block-heading.block-heading--style-1:after,
                                        .archive.category-'.$cat__term->term_id.' .block-heading.block-heading--style-2:after,
                                        .archive.category-'.$cat__term->term_id.' .block-heading.block-heading--style-3:after,
                                        .archive.category-'.$cat__term->term_id.' .block-heading.block-heading--style-7 .block-heading__title:before,
                                        .archive.category-'.$cat__term->term_id.' .block-heading.block-heading--style-11
                    {border-color: '.$catColorVal.' !important;}';
                    
                    $ceris_css_output .= '.archive.category-'.$cat__term->term_id.' .block-heading.block-heading--style-9 .block-heading__title:after
                    {border-top-color: '.$catColorVal.' !important;}';
                    
                    $ceris_css_output .= '.post--single-cover-gradient.cat-'.$cat__term->term_id.' .single-header
                    {
                    background-image: -webkit-linear-gradient( bottom , '.$catColorVal.' 0%, rgba(25, 79, 176, 0.7) 50%, rgba(25, 79, 176, 0) 100%);
                    background-image: linear-gradient(to top, '.$catColorVal.' 0%, rgba(25, 79, 176, 0.7) 50%, rgba(25, 79, 176, 0) 100%);
                    }';
                endif;
            endforeach;
            
        endif; 
        wp_add_inline_style( 'ceris-style', $ceris_css_output );
    }
    add_action( 'wp_enqueue_scripts', 'ceris_custom_css' );
}
