<?php
    if ( ! class_exists( 'Redux' ) ) {
        return;
    }
    $primary_font = array(' .comment-reply-title, .comments-title, .comment-reply-title, .category-tile__name, .block-heading, .block-heading__title, .post-categories__title, .post__title, .entry-title, h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .text-font-primary, .social-tile__title, .widget_recent_comments .recentcomments > a, .widget_recent_entries li > a, .modal-title.modal-title, .author-box .author-name a, .comment-author, .widget_calendar caption, .widget_categories li>a, .widget_meta ul, .widget_recent_comments .recentcomments>a, .widget_recent_entries li>a, .widget_pages li>a, 
                            .ceris-reviews-section .heading-title, .score-item .score-name, .score-item .score-number, .reviews-score-average, .btn-open-form-rating, .btn-open-form-rating label,
                            .scroll-count-percent .percent-number, .scroll-count-percent .btn-bookmark-icon, .open-sub-col, .ceris-about-module .about__title,
                            .post--overlay-hover-effect .post__text-backface .post__title, .atbs-ceris-mega-menu .post__title, .atbs-ceris-mega-menu .post__title a, .widget__title-text');

    $secondary_font = array('.text-font-secondary, .block-heading__subtitle, .widget_nav_menu ul, .typography-copy blockquote, .comment-content blockquote');

    $tertiary_font = array('.mobile-header-btn, .menu, .meta-text, a.meta-text, .meta-font, a.meta-font, .text-font-tertiary, .block-heading-tabs, .block-heading-tabs > li > a, input[type="button"]:not(.btn), input[type="reset"]:not(.btn), input[type="submit"]:not(.btn), .btn, label, .page-nav, .post-score, .post-score-hexagon .post-score-value, .post__cat, a.post__cat, .entry-cat, 
                            a.entry-cat, .read-more-link, .post__meta, .entry-meta, .entry-author__name, a.entry-author__name, .comments-count-box, .atbs-ceris-widget-indexed-posts-a .posts-list > li .post__thumb:after, .atbs-ceris-widget-indexed-posts-b .posts-list > li .post__title:after, .atbs-ceris-widget-indexed-posts-c .list-index, .social-tile__count, .widget_recent_comments .comment-author-link, .atbs-ceris-video-box__playlist .is-playing .post__thumb:after, .atbs-ceris-posts-listing-a .cat-title, 
                            .atbs-ceris-news-ticker__heading, .page-heading__title, .post-sharing__title, .post-sharing--simple .sharing-btn, .entry-action-btn, .entry-tags-title, .comments-title__text, .comments-title .add-comment, .comment-metadata, .comment-metadata a, .comment-reply-link, .countdown__digit, .modal-title, .comment-meta, .comment .reply, .wp-caption, .gallery-caption, .widget-title, 
                            .btn, .logged-in-as, .countdown__digit, .atbs-ceris-widget-indexed-posts-a .posts-list>li .post__thumb:after, .atbs-ceris-widget-indexed-posts-b .posts-list>li .post__title:after, .atbs-ceris-widget-indexed-posts-c .list-index, .atbs-ceris-horizontal-list .index, .atbs-ceris-pagination, .atbs-ceris-pagination--next-n-prev .atbs-ceris-pagination__label,
                            .post__readmore, .single-header .atbs-date-style, a.ceris-btn-view-review, .bookmark-see-more, .entry-author__name, .post-author-vertical span.entry-lable,
                            .post-author-vertical .entry-author__name, .post--overlay-hover-effect .post__text-front .entry-author span.entry-lable,
                            .post--overlay-hover-effect .post__text-front .entry-author .entry-author__name, blockquote cite, .block-editor .wp-block-archives-dropdown select,
                            .block-editor .wp-block-latest-posts__post-date, .block-editor .wp-block-latest-comments__comment-date,
                            .wp-block-image .aligncenter>figcaption, .wp-block-image .alignleft>figcaption, .wp-block-image .alignright>figcaption, .wp-block-image.is-resized>figcaption');
    
    $navigation_font = array('.navigation, .navigation-bar-btn, .navigation--main>li>a');
                
    $sub_navigation_font = array('.navigation--main .sub-menu a');
    
    $off_canvas_sub_navigation_font = array('.navigation--offcanvas>li>.sub-menu>li>a, .navigation--offcanvas>li>.sub-menu>li>.sub-menu>li>a');
    
    $footer_navigation_font = array('.ceris-footer .navigation--footer > li > a, .navigation--footer > li > a');
    
    $offcanvas_navigation_font = array('.navigation--offcanvas>li>a');
    
    Redux::setSection( $opt_name, array(
        'id'    => 'typography-section',
        'icon'  => 'el-icon-font',
		'title' => esc_html__('Typography Setings', 'ceris'),
        'customizer_width' => '500px',
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Body', 'ceris' ),
        'id'               => 'body-typography',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'          => 'body-typography',
                'type'        => 'typography',
                'title'       => esc_html__( 'Body', 'ceris' ),
                'google'      => true,
                // Disable google fonts. Won't work if you haven't defined your google api key
                'font-backup' => true,
                // Select a backup non-google font in addition to a google font
                'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                'font-weight'    => false,
                'subsets'       => true, // Only appears if google is true and subsets not set to false
                'font-size'     => false,
                'line-height'   => false,
                'text-align'    => false,
                //'word-spacing'  => true,  // Defaults to false
                'letter-spacing'=> true,  // Defaults to false
                'color'         => false,
                'preview'       => true, // Disable the previewer
                'all_styles'  => true,
                // Enable all Google Font style/weight variations to be added to the page
                'output'      => 'body',
                // An array of CSS selectors to apply this font style to dynamically
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option for body text.', 'ceris' ),
                'default'     => array(
                    'font-family' => 'Roboto',
                    'font-backup' => 'Arial, Helvetica, sans-serif'
                ),
            ),
        )
    ) );    
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Heading', 'ceris' ),
        'id'               => 'heading-typography',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'          => 'heading-typography',
                'type'        => 'typography',
                'title'       => esc_html__( 'Heading', 'ceris' ),
                'google'      => true,
                // Disable google fonts. Won't work if you haven't defined your google api key
                'font-backup' => true,
                // Select a backup non-google font in addition to a google font
                'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                'font-weight'    => false,
                'subsets'       => true, // Only appears if google is true and subsets not set to false
                'font-size'     => false,
                'line-height'   => false,
                'text-align'    => false,
                'text-transform'    => true,
                //'word-spacing'  => true,  // Defaults to false
                'letter-spacing'=> true,  // Defaults to false
                'color'         => false,
                'preview'       => true, // Disable the previewer
                'all_styles'  => true,
                // Enable all Google Font style/weight variations to be added to the page
                'output'      => $primary_font,
                // An array of CSS selectors to apply this font style to dynamically
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option for title.', 'ceris' ),
                'default'     => array(
                    'font-family' => 'Poppins',
                    'font-backup' => 'Arial, Helvetica, sans-serif'
                ),
            ),
        ),
    ) );    
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Secondary', 'ceris' ),
        'id'               => 'secondary-typography',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'          => 'meta-typography',
                'type'        => 'typography',
                'title'       => esc_html__( 'Secondary', 'ceris' ),
                'google'      => true,
                // Disable google fonts. Won't work if you haven't defined your google api key
                'font-backup' => true,
                // Select a backup non-google font in addition to a google font
                'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                'font-weight'    => false,
                'subsets'       => true, // Only appears if google is true and subsets not set to false
                'font-size'     => false,
                'line-height'   => false,
                'text-align'    => false,
                //'word-spacing'  => true,  // Defaults to false
                'letter-spacing'=> true,  // Defaults to false
                'color'         => false,
                //'preview'       => false, // Disable the previewer
                'all_styles'  => true,
                // Enable all Google Font style/weight variations to be added to the page
                'output'      => $secondary_font,
                // An array of CSS selectors to apply this font style to dynamically
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option for secondary text such as subtitle, sub menu, ...', 'ceris' ),
                'default'     => array(
                    'font-family' => 'Poppins',
                    'font-backup' => 'Arial, Helvetica, sans-serif'
                ),
            ),
        ),
    ) );    
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Tertiary', 'ceris' ),
        'id'               => 'tertiary-typography',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'          => 'tertiary-typography',
                'type'        => 'typography',
                'title'       => esc_html__( 'Tertiary font', 'ceris' ),
                'google'      => true,
                // Disable google fonts. Won't work if you haven't defined your google api key
                'font-backup' => true,
                // Select a backup non-google font in addition to a google font
                'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                'font-weight'    => false,
                'text-align'    => false,
                'subsets'       => true, // Only appears if google is true and subsets not set to false
                'font-size'     => false,
                'line-height'   => false,
                'word-spacing'  => false,  // Defaults to false
                'letter-spacing'=> true,  // Defaults to false
                'color'         => false,
                //'preview'       => false, // Disable the previewer
                'all_styles'  => true,
                // Enable all Google Font style/weight variations to be added to the page
                'output'      => $tertiary_font,
                // An array of CSS selectors to apply this font style to dynamically
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option for tertiary text such as post meta, button, ...', 'ceris' ),
                'default'     => array(
                    'font-family' => 'Poppins',
                    'font-backup' => 'Arial, Helvetica, sans-serif'
                ),
            ),
        ),
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Navigation', 'ceris' ),
        'id'               => 'navigation-typography',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id' => 'section-typography-navigation-start',
                'title' => esc_html__('Navigation', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'          => 'navigation-typography',
                'type'        => 'typography',
                'title'       => esc_html__( 'Header Navigation', 'ceris' ),
                'google'      => true,
                // Disable google fonts. Won't work if you haven't defined your google api key
                'font-backup' => true,
                // Select a backup non-google font in addition to a google font
                'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                'font-weight'    => true,
                'subsets'       => false, // Only appears if google is true and subsets not set to false
                'font-size'     => true,
                'line-height'   => false,
                'text-align'    => false,
                //'word-spacing'  => true,  // Defaults to false
                'text-transform'    => true,
                'letter-spacing'=> true,  // Defaults to false
                'color'         => false,
                'preview'       => true, // Disable the previewer
                'all_styles'  => true,
                // Enable all Google Font style/weight variations to be added to the page
                'output'      => $navigation_font,
                // An array of CSS selectors to apply this font style to dynamically
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option for navigation.', 'ceris' ),
                'default'     => array(
                    'font-family' => 'Rubik',
                    'font-backup' => 'Arial, Helvetica, sans-serif',
                    'font-weight'    => '',
                    'text-transform'    => 'uppercase',
                ),
            ),
            array(
                'id'          => 'sub-navigation-typography',
                'type'        => 'typography',
                'title'       => esc_html__( 'Sub Navigation', 'ceris' ),
                'google'      => true,
                // Disable google fonts. Won't work if you haven't defined your google api key
                'font-backup' => true,
                // Select a backup non-google font in addition to a google font
                'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                'font-weight'    => true,
                'subsets'       => false, // Only appears if google is true and subsets not set to false
                'font-size'     => true,
                'line-height'   => false,
                'text-align'    => false,
                //'word-spacing'  => true,  // Defaults to false
                'text-transform'    => true,
                'letter-spacing'=> true,  // Defaults to false
                'color'         => false,
                'preview'       => true, // Disable the previewer
                'all_styles'  => true,
                // Enable all Google Font style/weight variations to be added to the page
                'output'      => $sub_navigation_font,
                // An array of CSS selectors to apply this font style to dynamically
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option for navigation.', 'ceris' ),
                'default'     => array(
                    'font-family' => 'Rubik',
                    'font-backup' => 'Arial, Helvetica, sans-serif',
                    'font-weight'    => '',
                    'text-transform'    => 'uppercase',
                ),
            ),
            array(
                'id'          => 'offcanvas-navigation-typography',
                'type'        => 'typography',
                'title'       => esc_html__( 'Offcanvas Navigation', 'ceris' ),
                'google'      => true,
                // Disable google fonts. Won't work if you haven't defined your google api key
                'font-backup' => true,
                // Select a backup non-google font in addition to a google font
                'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                'font-weight'    => true,
                'subsets'       => false, // Only appears if google is true and subsets not set to false
                'font-size'     => true,
                'line-height'   => false,
                'text-align'    => false,
                'text-transform'    => true,
                //'word-spacing'  => true,  // Defaults to false
                'letter-spacing'=> true,  // Defaults to false
                'color'         => false,
                'preview'       => true, // Disable the previewer
                'all_styles'  => true,
                // Enable all Google Font style/weight variations to be added to the page
                'output'      => $offcanvas_navigation_font,
                // An array of CSS selectors to apply this font style to dynamically
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option for navigation.', 'ceris' ),
                'default'     => array(
                    'font-family' => 'Rubik',
                    'font-backup' => 'Arial, Helvetica, sans-serif',
                    'font-weight'    => '400',
                    'text-transform'    => 'uppercase',
                ),
            ),
            array(
                'id'          => 'off-canvas-sub-navigation-typography',
                'type'        => 'typography',
                'title'       => esc_html__( 'Off-canvas Sub Navigation', 'ceris' ),
                'google'      => true,
                // Disable google fonts. Won't work if you haven't defined your google api key
                'font-backup' => true,
                // Select a backup non-google font in addition to a google font
                'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                'font-weight'    => true,
                'subsets'       => false, // Only appears if google is true and subsets not set to false
                'font-size'     => true,
                'line-height'   => false,
                'text-align'    => false,
                //'word-spacing'  => true,  // Defaults to false
                'text-transform'    => true,
                'letter-spacing'=> true,  // Defaults to false
                'color'         => false,
                'preview'       => true, // Disable the previewer
                'all_styles'  => true,
                // Enable all Google Font style/weight variations to be added to the page
                'output'      => $off_canvas_sub_navigation_font,
                // An array of CSS selectors to apply this font style to dynamically
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option for navigation.', 'ceris' ),
                'default'     => array(
                    'font-family' => 'Rubik',
                    'font-backup' => 'Arial, Helvetica, sans-serif',
                    'font-weight'    => '',
                    'text-transform'    => 'uppercase',
                ),
            ),
            array(
                'id'          => 'footer-navigation-typography',
                'type'        => 'typography',
                'title'       => esc_html__( 'Footer Navigation', 'ceris' ),
                'google'      => true,
                'font-backup' => true,
                // Select a backup non-google font in addition to a google font
                'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                'font-weight'    => true,
                'subsets'       => false, // Only appears if google is true and subsets not set to false
                'font-size'     => true,
                'line-height'   => false,
                'text-align'    => false,
                //'word-spacing'  => true,  // Defaults to false
                'text-transform'    => true,
                'letter-spacing'=> true,  // Defaults to false
                'color'         => false,
                'preview'       => true, // Disable the previewer
                'all_styles'  => true,
                // Enable all Google Font style/weight variations to be added to the page
                'output'      => $footer_navigation_font,
                // An array of CSS selectors to apply this font style to dynamically
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option for navigation.', 'ceris' ),
                'default'     => array(
                    'font-family' => 'Rubik',
                    'font-backup' => 'Arial, Helvetica, sans-serif',
                    'font-weight'    => '',
                    'text-transform'    => 'uppercase',
                ),
            ),
            array(
                'id' => 'section-typography-navigation-end',
                'type' => 'section',                             
                'indent' => false // Indent all options below until the next 'section' option is set.
            ),
        ),
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Load More Text', 'ceris' ),
        'id'               => 'loadmore-typography',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'      =>'bk-load-more-text',
				'type'    => 'text',
				'title'   => esc_html__('Load More Text', 'ceris'),
                'default' => esc_html__('Load more news', 'ceris'),
			),
            array(
				'id'      =>'bk-no-more-text',
				'type'    => 'text',
				'title'   => esc_html__('No More Text', 'ceris'),
                'default' => esc_html__('No more news', 'ceris'),
			),
        ),
    ) );