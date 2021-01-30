<?php
    if ( ! class_exists( 'Redux' ) ) {
        return;
    }
    Redux::setSection( $opt_name, array(
        'id'    => 'bookmark-settings-section',
        'icon' => 'el el-wrench',
		'title' => esc_html__('Bookmark Settings', 'ceris'),
        'customizer_width' => '500px',
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Bookmark Page Setting', 'ceris' ),
        'id'               => 'bookmark-page-settings-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'=>'section-bookmark-notification-start',
                'title' => esc_html__('These settings also be used for the Dismiss Page', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'=>'section-bookmark-notification-end',
                'type' => 'section', 
                'indent' => false // Indent all options below until the next 'section' option is set.
            ), 
            array(
				'id'=>'bk_bookmark_header_style',
				'type' => 'select',
				'title' => esc_html__('Page Heading', 'ceris'),
                'options'  => array(
                    'style-1'           => esc_html__( 'Heading Style 1', 'ceris' ),
                    'style-2'           => esc_html__( 'Heading Style 2', 'ceris' ),
                    'style-3'           => esc_html__( 'Heading Style 3', 'ceris' ),
                    'style-4'           => esc_html__( 'Heading Style 4', 'ceris' ),
                    'style-5'           => esc_html__( 'Heading Style 5', 'ceris' ),
                    'style-6'           => esc_html__( 'Heading Style 6', 'ceris' ),
                    'style-7'           => esc_html__( 'Heading Style 7', 'ceris' ),
                    'style-8'           => esc_html__( 'Heading Style 8', 'ceris' ),
                    'style-9'           => esc_html__( 'Heading Style 9', 'ceris' ),
                    'style-10'          => esc_html__( 'Heading Style 10', 'ceris' ),
                    'line'              => esc_html__( 'Heading Style 11', 'ceris' ),
                    'no-line'           => esc_html__( 'Heading Style 12', 'ceris' ),
                    'line-under'        => esc_html__( 'Heading Style 13', 'ceris' ),
                    'center'            => esc_html__( 'Heading Style 14', 'ceris' ),
                    'line-around'       => esc_html__( 'Heading Style 15', 'ceris' ),
                ),
                'default' => 'center',
			),
            array(
                'id'          => 'bk_bookmark_page_heading_typography',
                'type'        => 'typography',
                'title'       => esc_html__( 'Bookmark Page Heading Font', 'ceris' ),
                'google'      => true,
                // Disable google fonts. Won't work if you haven't defined your google api key
                'font-backup' => true,
                // Select a backup non-google font in addition to a google font
                'font-style'    => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                'font-weight'    => true,
                'subsets'       => false, // Only appears if google is true and subsets not set to false
                'font-size'     => true,
                'line-height'   => false,
                'text-align'    => false,
                //'word-spacing'  => true,  // Defaults to false
                'letter-spacing'=> true,  // Defaults to false
                'color'         => false,
                'preview'       => true, // Disable the previewer
                'all_styles'  => true,
                // Enable all Google Font style/weight variations to be added to the page
                'output'      => '.page-template-bookmark .block-heading .block-heading__title, .page-template-dismiss .block-heading .block-heading__title',
                // An array of CSS selectors to apply this font style to dynamically
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option for body text.', 'ceris' ),
                'default'     => array(
                    'font-family' => 'Rubik',
                    'font-backup' => 'Arial, Helvetica, sans-serif',
                    'font-size'     => '36px',
                    'font-weight'    => '700',
                ),
            ),
            array(
				'id'=>'bk_bookmark_page_heading_color',
				'type'        => 'typography',
                'title'       => esc_html__( 'Bookmark Page Heading Color', 'ceris' ),
                'google'      => false,
                // Disable google fonts. Won't work if you haven't defined your google api key
                'font-backup' => false,
                // Select a backup non-google font in addition to a google font
                'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                'font-weight'    => false,
                'font-family'    => false,
                'subsets'       => false, // Only appears if google is true and subsets not set to false
                'font-size'     => false,
                'line-height'   => false,
                'text-align'    => false,
                //'word-spacing'  => false,  // Defaults to false
                'letter-spacing'=> false,  // Defaults to false
                'color'         => true,
                'preview'       => false, // Disable the previewer
                'all_styles'  => false,
                // Enable all Google Font style/weight variations to be added to the page
                'output'      => '.page-template-bookmark .block-heading .block-heading__title, .page-template-dismiss .block-heading .block-heading__title',
                // An array of CSS selectors to apply this font style to dynamically
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option for body text.', 'ceris' ),
                'default'     => array(
                    'color' => '#222',
                ),
                'required' => array(
                    array ('bk_bookmark_header_style', 'equals' , array( 'style-4', 'style-5', 'style-6', 'style-7', 'style-8', 'style-10', 'line', 'no-line', 'line-under', 'center', 'line-around' )),
                ),
			),
            array(
				'id'=>'bk_bookmark_content_layout',
				'type' => 'image_select', 
				'title' => esc_html__('Content Layout', 'ceris'),
                'options'  => array(
                    'listing_list'             => get_template_directory_uri().'/images/admin_panel/archive/ceris_14.png',
                    'listing_list_b'           => get_template_directory_uri().'/images/admin_panel/archive/ceris_15.png',
                    'listing_list_large_a'     => get_template_directory_uri().'/images/admin_panel/archive/ceris_16.png',
                    'listing_list_large_b'     => get_template_directory_uri().'/images/admin_panel/archive/ceris_17.png',
                    'listing_list_alt_b'       => get_template_directory_uri().'/images/admin_panel/archive/listing_list_alt_b.png',
					'listing_grid'             => get_template_directory_uri().'/images/admin_panel/archive/ceris_18.png',
                    'listing_grid_b'           => get_template_directory_uri().'/images/admin_panel/archive/ceris_19.png',
                    'listing_grid_alt_b'       => get_template_directory_uri().'/images/admin_panel/archive/listing_grid_alt_b.png',
                    //no_sidebar 
                    'listing_list_no_sidebar'         => get_template_directory_uri().'/images/admin_panel/archive/ceris_20.png',
                    'listing_list_b_no_sidebar'       => get_template_directory_uri().'/images/admin_panel/archive/ceris_21.png',
                    'listing_list_large_a_no_sidebar' => get_template_directory_uri().'/images/admin_panel/archive/ceris_22.png',
                    'listing_list_large_b_no_sidebar' => get_template_directory_uri().'/images/admin_panel/archive/ceris_23.png',
                    'listing_grid_no_sidebar'         => get_template_directory_uri().'/images/admin_panel/archive/ceris_24.png',
                    'listing_grid_b_no_sidebar'       => get_template_directory_uri().'/images/admin_panel/archive/ceris_25.png',
                    
			    ),
                'default' => 'listing_list',
			),
            array(
                'id'        => 'bk_bookmark_post_icon',  
                'type'      => 'button_set',
                'multi'     => false,
                'title'     => esc_html__('Post Icon', 'ceris'),
                'desc'      => '',
                'options'   => array(
                    'enable'    => esc_html__( 'Enable', 'ceris' ),
                    'disable'   => esc_html__( 'Disable', 'ceris' ),
                ),
                'default' => 'enable',
            ),
            array(
                'id'        => 'bk_bookmark_post_icon_animation',  
                'type'      => 'button_set',
                'multi'     => false,
                'title'     => esc_html__('Post Icon Animation', 'ceris'),
                'desc'      => '',
                'options'   => array(
                    'enable'    => esc_html__( 'Enable', 'ceris' ),
                    'disable'   => esc_html__( 'Disable', 'ceris' ),
                ),
                'default' => 'enable',
            ),
            array(
                'id'        => 'bk_bookmark_pagination',  
                'type'      => 'select',
                'multi'     => false,
                'title'     => esc_html__('Pagination', 'ceris'),
                'subtitle'  => esc_html__('Select an option for the pagination', 'ceris'),
                'options'   => array(
                    'default'           => esc_html__( 'Default Pagination', 'ceris' ),
                    'ajax-loadmore'     => esc_html__( 'Ajax Load More', 'ceris' ),
                    'infinity'          => esc_html__( 'Ajax Infinity Scrolling', 'ceris' ),
                ),
                'default' => 'default',
            ),
            array(
                'id'=>'section-bookmark-sidebar-start',
                'title' => esc_html__('Sidebar', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'        => 'bk_bookmark_sidebar_select',  
                'type'      => 'select',
                'data'      => 'sidebars', 
                'multi'     => false,
                'title'     => esc_html__('Bookmark Page Sidebar', 'ceris'),
                'subtitle'  => esc_html__('Choose a sidebar for the bookmark page', 'ceris'),
                'default'   => 'home_sidebar',
            ),
            array(
                'id'        => 'bk_bookmark_sidebar_position',  
                'type'      => 'image_select',
                'multi'     => false,
                'title'     => esc_html__('Sidebar Postion', 'ceris'),
                'desc'      => '',
                'options'   => array(
                                    'right' => array(
                                        'alt' => 'Sidebar Right',
                                        'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-right.png',
                                    ),
                                    'left' => array(
                                        'alt' => 'Sidebar Left',
                                        'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-left.png',
                                    ),
                            ),
                'default' => 'right',
            ),
            array(
                'id'        => 'bk_bookmark_sidebar_sticky',  
                'type'      => 'button_set',
                'multi'     => false,
                'title'     => esc_html__('Stick Sidebar', 'ceris'),
                'subtitle'  => esc_html__('Enable Stick Sidebar / Disable Stick Sidebar', 'ceris'),
                'desc'      => '',
                'options'   => array(
                    1   => esc_html__( 'Enable', 'ceris' ),
	                0   => esc_html__( 'Disable', 'ceris' ),
                ),
                'default' => 1,
            ),
            array(
                'id'=>'section-bookmark-sidebar-end',
                'type' => 'section', 
                'indent' => false // Indent all options below until the next 'section' option is set.
            ), 
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Bookmark Dropdown Menu', 'ceris' ),
        'id'               => 'bookmark-dropdown-menu-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
    			'id'        => 'bookmark_dropdown_latest_news',
                'title'     => esc_html__('Show Latest News', 'ceris'),
                'desc'      => esc_html__('Put the latest news URL here', 'ceris'),
                'type'      => 'text',
    		),
            array(
    			'id'        => 'bookmark_dropdown_bookmark_news',
                'title'     => esc_html__('Show User Bookmark Articles', 'ceris'),
                'desc'      => esc_html__('Put the bookmark URL here', 'ceris'),
                'type'      => 'text',
    		),
            array(
    			'id'        => 'bookmark_dropdown_dismiss_news',
                'title'     => esc_html__('Show User Dismiss Articles', 'ceris'),
                'desc'      => esc_html__('Put the dismiss URL here', 'ceris'),
                'type'      => 'text',
    		),
        )
    ) );