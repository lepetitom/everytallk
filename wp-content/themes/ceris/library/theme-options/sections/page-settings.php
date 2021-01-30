<?php
    if ( ! class_exists( 'Redux' ) ) {
        return;
    }
    Redux::setSection( $opt_name, array(
        'id'    => 'page-settings-section',
        'icon' => 'el el-wrench',
		'title' => esc_html__('Page Settings', 'ceris'),
        'customizer_width' => '500px',
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Category Page', 'ceris' ),
        'id'               => 'cagegory-page-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'bk_category_header_style',
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
                'id'          => 'bk_category_page_heading_typography',
                'type'        => 'typography',
                'title'       => esc_html__( 'Category Page Heading Font', 'ceris' ),
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
                'text-transform' => true,
                //'word-spacing'  => true,  // Defaults to false
                'letter-spacing'=> true,  // Defaults to false
                'color'         => false,
                'preview'       => true, // Disable the previewer
                'all_styles'  => true,
                // Enable all Google Font style/weight variations to be added to the page
                'output'      => '.archive.category .block-heading .block-heading__title',
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
				'id'=>'bk_category_page_heading_color',
				'type'        => 'typography',
                'title'       => esc_html__( 'Category Page Heading Color', 'ceris' ),
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
                'output'      => '.archive.category .block-heading .block-heading__title',
                // An array of CSS selectors to apply this font style to dynamically
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option for body text.', 'ceris' ),
                'default'     => array(
                    'color' => '#222',
                ),
                'required' => array(
                    array ('bk_category_header_style', 'equals' , array( 'style-4', 'style-5', 'style-6', 'style-8', 'style-10', 'line', 'no-line', 'line-under', 'center', 'line-around' )),
                ),
			),
            array(
				'id'=>'bk_category_feature_area',
				'type' => 'image_select', 
				'title' => esc_html__('Feature Area Layout', 'ceris'),
                'options'  => array(
                    'disable'            => get_template_directory_uri().'/images/admin_panel/disable.png',
                    'grid_o'           => get_template_directory_uri().'/images/admin_panel/archive/mosaic_a.png',
                    'grid_p'           => get_template_directory_uri().'/images/admin_panel/archive/mosaic_b.png',
                    'grid_q'           => get_template_directory_uri().'/images/admin_panel/archive/posts_block_e.png',
                    'grid_r'           => get_template_directory_uri().'/images/admin_panel/archive/mosaic_c.png',
			    ),
                'default' => 'disable',
			),
            array(
                'id'        => 'bk_category_feature_area__post_option',  
                'type'      => 'select',
                'multi'     => false,
                'title'     => esc_html__('Show Feature Area on only first page', 'ceris'),
                'desc'      => '',
                'options'   => array(
                    'featured'          => esc_html__( 'Show Featured Posts', 'ceris' ),
                    'latest'            => esc_html__( 'Show Latest Posts', 'ceris' ),
                ),
                'default' => 'latest',
            ),
            array(
                'id'        => 'bk_feature_area__show_hide',  
                'type'      => 'button_set',
                'multi'     => false,
                'title'     => esc_html__('Show Feature Area on only first page', 'ceris'),
                'desc'      => '',
                'options'   => array(
                    1    => esc_html__( 'Yes', 'ceris' ),
	                0    => esc_html__( 'No', 'ceris' ),
                ),
                'default' => 0,
            ),
            array(
				'id'=>'bk_category_content_layout',
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
                    'listing_grid_small'       => get_template_directory_uri().'/images/admin_panel/archive/listing_grid_small.png',
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
                'id'        => 'bk_category_page_post_bookmark',  
                'type'      => 'button_set',
                'multi'     => false,
                'title'     => esc_html__('Bookmark option', 'ceris'),
                'desc'      => '',
                'options'   => array(
                    'on'    => esc_html__( 'On', 'ceris' ),
	                'off'   => esc_html__( 'Off', 'ceris' ),
                ),
                'default' => 'off',
            ),
            array(
                'id'        => 'bk_category_post_icon',  
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
                'id'        => 'bk_category_post_icon_animation',  
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
                'id'        => 'bk_category_pagination',  
                'type'      => 'select',
                'multi'     => false,
                'title'     => esc_html__('Pagination', 'ceris'),
                'subtitle'  => esc_html__('Select an option for the pagination', 'ceris'),
                'desc'      => '',
                'options'   => array(
                                    'default'           => esc_html__( 'Default Pagination', 'ceris' ),
					                'ajax-pagination'   => esc_html__( 'Ajax Pagination', 'ceris' ),
                                    'ajax-loadmore'     => esc_html__( 'Ajax Load More', 'ceris' ),
                                    'infinity'          => esc_html__( 'Ajax Infinity Scrolling', 'ceris' ),
                            ),
                'default' => 'default',
            ),
            array(
				'id'=>'bk_category_exclude_posts',
				'type' => 'button_set', 
                'required' => array('bk_category_feature_area','!=','disable'),
				'title' => esc_html__('[Content Section] Exclude Posts', 'ceris'),
                'options'   => array(
                    1   => esc_html__( 'Enable', 'ceris' ),
                    0   => esc_html__( 'Disable', 'ceris' ),
                ),
                'default' => 1,
			),
            array(
                'id'=>'section-category-sidebar-start',
                'title' => esc_html__('Sidebar', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'        => 'bk_category_sidebar_select',  
                'type'      => 'select',
                'data'      => 'sidebars', 
                'multi'     => false,
                'title'     => esc_html__('Category Page Sidebar', 'ceris'),
                'subtitle'  => esc_html__('Choose a sidebar for the category page', 'ceris'),
                'default'   => 'home_sidebar',
            ),
            array(
                'id'        => 'bk_category_sidebar_position',  
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
                'id'        => 'bk_category_sidebar_sticky',  
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
                'id'=>'section-archive-sidebar-end',
                'type' => 'section', 
                'indent' => false // Indent all options below until the next 'section' option is set.
            ), 
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Archive Page', 'ceris' ),
        'id'               => 'archive-page-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'bk_archive_header_style',
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
                'id'          => 'bk_archive_page_heading_typography',
                'type'        => 'typography',
                'title'       => esc_html__( 'Archive Page Heading Font', 'ceris' ),
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
                'text-transform' => true,
                //'word-spacing'  => true,  // Defaults to false
                'letter-spacing'=> true,  // Defaults to false
                'color'         => false,
                'preview'       => true, // Disable the previewer
                'all_styles'  => true,
                // Enable all Google Font style/weight variations to be added to the page
                'output'      => '.archive .block-heading .block-heading__title',
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
				'id'=>'bk_archive_page_heading_color',
				'type'        => 'typography',
                'title'       => esc_html__( 'Archive Page Heading Color', 'ceris' ),
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
                'output'      => '.archive .block-heading .block-heading__title',
                // An array of CSS selectors to apply this font style to dynamically
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option for body text.', 'ceris' ),
                'default'     => array(
                    'color' => '#222',
                ),
                'required' => array(
                    array ('bk_archive_header_style', 'equals' , array( 'style-4', 'style-5', 'style-6', 'style-8', 'style-10', 'line', 'no-line', 'line-under', 'center', 'line-around' )),
                ),
			),
            array(
				'id'=>'bk_archive_content_layout',
				'type' => 'image_select', 
				'title' => esc_html__('Content Layout', 'ceris'),
                'options'  => array(
                    'listing_list'             => get_template_directory_uri().'/images/admin_panel/archive/ceris_14.png',
                    'listing_list_b'           => get_template_directory_uri().'/images/admin_panel/archive/ceris_15.png',
                    'listing_list_large_a'     => get_template_directory_uri().'/images/admin_panel/archive/ceris_16.png',
                    'listing_list_large_b'     => get_template_directory_uri().'/images/admin_panel/archive/ceris_17.png',
                    'listing_list_alt_b' => get_template_directory_uri().'/images/admin_panel/archive/listing_list_alt_b.png',
					'listing_grid'       => get_template_directory_uri().'/images/admin_panel/archive/ceris_18.png',
                    'listing_grid_b'       => get_template_directory_uri().'/images/admin_panel/archive/ceris_19.png',
                    'listing_grid_alt_b' => get_template_directory_uri().'/images/admin_panel/archive/listing_grid_alt_b.png',
                    'listing_grid_small' => get_template_directory_uri().'/images/admin_panel/archive/listing_grid_small.png',
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
                'id'        => 'bk_archive_page_post_bookmark',  
                'type'      => 'button_set',
                'multi'     => false,
                'title'     => esc_html__('Bookmark option', 'ceris'),
                'desc'      => '',
                'options'   => array(
                    'on'    => esc_html__( 'On', 'ceris' ),
	                'off'   => esc_html__( 'Off', 'ceris' ),
                ),
                'default' => 'off',
            ),
            array(
                'id'        => 'bk_archive_post_icon',  
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
                'id'        => 'bk_archive_post_icon_animation',  
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
                'id'        => 'bk_archive_pagination',  
                'type'      => 'select',
                'multi'     => false,
                'title'     => esc_html__('Pagination', 'ceris'),
                'subtitle'  => esc_html__('Select an option for the pagination', 'ceris'),
                'desc'      => esc_html__('This option is only valid on Tag Pages', 'ceris'),
                'options'   => array(
                                    'default'           => esc_html__( 'Default Pagination', 'ceris' ),
					                'ajax-pagination'   => esc_html__( 'Ajax Pagination', 'ceris' ),
                                    'ajax-loadmore'     => esc_html__( 'Ajax Load More', 'ceris' ),
                                    'infinity'          => esc_html__( 'Ajax Infinity Scrolling', 'ceris' ),
                            ),
                'default' => 'default',
            ),
            array(
                'id'=>'section-archive-sidebar-start',
                'title' => esc_html__('Sidebar', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'        => 'bk_archive_sidebar_select',  
                'type'      => 'select',
                'data'      => 'sidebars', 
                'multi'     => false,
                'title'     => esc_html__('Archive Page Sidebar', 'ceris'),
                'subtitle'  => esc_html__('Choose a sidebar for the archive page', 'ceris'),
                'default'   => 'home_sidebar',
            ),
            array(
                'id'        => 'bk_archive_sidebar_position',  
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
                'id'        => 'bk_archive_sidebar_sticky',  
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
                'id'=>'section-archive-sidebar-end',
                'type' => 'section', 
                'indent' => false // Indent all options below until the next 'section' option is set.
            ), 
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Author Page', 'ceris' ),
        'id'               => 'author-page-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'bk_author_content_layout',
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
                    'listing_grid_small'       => get_template_directory_uri().'/images/admin_panel/archive/listing_grid_small.png',
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
                'id'        => 'bk_author_page_post_bookmark',  
                'type'      => 'button_set',
                'multi'     => false,
                'title'     => esc_html__('Bookmark option', 'ceris'),
                'desc'      => '',
                'options'   => array(
                    'on'    => esc_html__( 'On', 'ceris' ),
	                'off'   => esc_html__( 'Off', 'ceris' ),
                ),
                'default' => 'off',
            ),
            array(
                'id'        => 'bk_author_post_icon',  
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
                'id'        => 'bk_author_post_icon_animation',  
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
                'id'        => 'bk_author_pagination',  
                'type'      => 'select',
                'multi'     => false,
                'title'     => esc_html__('Pagination', 'ceris'),
                'subtitle'  => esc_html__('Select an option for the pagination', 'ceris'),
                'options'   => array(
                                'default'           => esc_html__( 'Default Pagination', 'ceris' ),
				                'ajax-pagination'   => esc_html__( 'Ajax Pagination', 'ceris' ),
                                'ajax-loadmore'     => esc_html__( 'Ajax Load More', 'ceris' ),
                                'infinity'          => esc_html__( 'Ajax Infinity Scrolling', 'ceris' ),
                            ),
                'default' => 'default',
            ),
            array(
                'id'=>'section-author-sidebar-start',
                'title' => esc_html__('Sidebar', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'        => 'bk_author_sidebar_select',  
                'type'      => 'select',
                'data'      => 'sidebars', 
                'multi'     => false,
                'title'     => esc_html__('Author Page Sidebar', 'ceris'),
                'subtitle'  => esc_html__('Choose a sidebar for the author page', 'ceris'),
                'default'   => 'home_sidebar',
            ),
            array(
                'id'        => 'bk_author_sidebar_position',  
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
                'id'        => 'bk_author_sidebar_sticky',  
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
                'id'=>'section-author-sidebar-end',
                'type' => 'section', 
                'indent' => false // Indent all options below until the next 'section' option is set.
            ), 
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Search Page', 'ceris' ),
        'id'               => 'search-page-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'bk_search_header_style',
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
                'id'          => 'bk_search_page_heading_typography',
                'type'        => 'typography',
                'title'       => esc_html__( 'Search Page Heading Font', 'ceris' ),
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
                'text-transform' => true,
                //'word-spacing'  => true,  // Defaults to false
                'letter-spacing'=> true,  // Defaults to false
                'color'         => false,
                'preview'       => true, // Disable the previewer
                'all_styles'  => true,
                // Enable all Google Font style/weight variations to be added to the page
                'output'      => '.search.search-results .block-heading .block-heading__title, .search.search-no-results .block-heading .block-heading__title',
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
				'id'=>'bk_search_page_heading_color',
				'type'        => 'typography',
                'title'       => esc_html__( 'Search Page Heading Color', 'ceris' ),
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
                'output'      => '.search.search-results .block-heading .block-heading__title',
                // An array of CSS selectors to apply this font style to dynamically
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option for body text.', 'ceris' ),
                'default'     => array(
                    'color' => '#222',
                ),
                'required' => array(
                    array ('bk_search_header_style', 'equals' , array( 'style-4', 'style-5', 'style-6', 'style-8', 'style-10', 'line', 'no-line', 'line-under', 'center', 'line-around' )),
                ),
			),
            array(
				'id'=>'bk_search_content_layout',
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
                    'listing_grid_small'       => get_template_directory_uri().'/images/admin_panel/archive/listing_grid_small.png',
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
                'id'        => 'bk_search_post_icon',  
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
                'id'        => 'bk_search_post_icon_animation',  
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
                'id'        => 'bk_search_exclude_page_result',  
                'type'      => 'button_set',
                'multi'     => false,
                'title'     => esc_html__('Exclude Pages from the search results', 'ceris'),
                'desc'      => '',
                'options'   => array(
                    'enable'    => esc_html__( 'Enable', 'ceris' ),
                    'disable'   => esc_html__( 'Disable', 'ceris' ),
                ),
                'default' => 'disable',
            ),
            array(
                'id'        => 'bk_search_pagination',  
                'type'      => 'select',
                'multi'     => false,
                'title'     => esc_html__('Pagination', 'ceris'),
                'subtitle'  => esc_html__('Select an option for the pagination', 'ceris'),
                'desc'      => '',
                'options'   => array(
                                    'default'           => esc_html__( 'Default Pagination', 'ceris' ),
					                'ajax-pagination'   => esc_html__( 'Ajax Pagination', 'ceris' ),
                                    'ajax-loadmore'     => esc_html__( 'Ajax Load More', 'ceris' ),
                                    'infinity'          => esc_html__( 'Ajax Infinity Scrolling', 'ceris' ),
                            ),
                'default' => 'default',
            ),                      
            array(
                'id'=>'section-search-sidebar-start',
                'title' => esc_html__('Sidebar', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'        => 'bk_search_sidebar_select',  
                'type'      => 'select',
                'data'      => 'sidebars', 
                'multi'     => false,
                'title'     => esc_html__('Search Page Sidebar', 'ceris'),
                'subtitle'  => esc_html__('Choose a sidebar for the search page', 'ceris'),
                'default'   => 'home_sidebar',
            ),
            array(
                'id'        => 'bk_search_sidebar_position',  
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
                'id'        => 'bk_search_sidebar_sticky',  
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
                'id'=>'section-search-sidebar-end',
                'type' => 'section', 
                'indent' => false // Indent all options below until the next 'section' option is set.
            ), 
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Ajax Search Panel', 'ceris' ),
        'id'               => 'ajax-search-panel-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'=>'search-panel-recommend-post-section',
                'title' => esc_html__('Recommend Posts', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),
            array(
    			'id'        => 'search_recommend_heading',
                'title'     => esc_html__('Heading Text', 'ceris'),
                'type'      => 'text',
                'default'   => esc_html__('Latest Posts', 'ceris'),
    		),
            array(
				'id'=>'search_recommend_query_option',
				'type' => 'select', 
				'title' => esc_html__('Sort By', 'ceris'),
                'options' => array(
                    'date'              => esc_html__( 'Latest Posts', 'ceris' ),
                    'comment_count'     => esc_html__( 'Popular Post by Comments', 'ceris' ),
                    'view_count'        => esc_html__( 'Popular Post by Views', 'ceris' ),
                    'top_review'        => esc_html__( 'Best Review', 'ceris' ),
                    'modified'          => esc_html__( 'Modified', 'ceris' ),
                    'alphabetical_asc'  => esc_html__( 'Alphabetical A->Z', 'ceris' ),
                    'alphabetical_decs' => esc_html__( 'Alphabetical Z->A', 'ceris' ),
				),
                'default' => 'date',
			),
            array(
                'id'=>'search-panel-recommend-post-section-end',
                'type' => 'section', 
                'indent' => false // Indent all options below until the next 'section' option is set.
            ), 
            array(
                'id'=>'search-panel-tag-section',
                'title' => esc_html__('Tags Section', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),
            array(
    			'id'        => 'search_panel_tags_headline',
                'title'     => esc_html__('Heading Text', 'ceris'),
                'type'      => 'text',
                'default'   => esc_html__('Popular Tags', 'ceris'),
    		),
            array(
                'id'    =>'section_search_panel_tag_option',
                'type'  => 'select',
                'title' => esc_html__('Tags Select', 'ceris'),
                'data'  => 'tags',
                'multi' => 1,
                'default'   => '',
            ),
            array(
                'id'=>'search-panel-tag-section-end',
                'type' => 'section', 
                'indent' => false // Indent all options below until the next 'section' option is set.
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Blog Page', 'ceris' ),
        'id'               => 'blog-page-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'bk_blog_header_style',
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
                'id'          => 'bk_blog_page_heading_typography',
                'type'        => 'typography',
                'title'       => esc_html__( 'Blog Page Heading Font', 'ceris' ),
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
                'text-transform' => true,
                //'word-spacing'  => true,  // Defaults to false
                'letter-spacing'=> true,  // Defaults to false
                'color'         => false,
                'preview'       => true, // Disable the previewer
                'all_styles'  => true,
                // Enable all Google Font style/weight variations to be added to the page
                'output'      => '.page-template-blog .block-heading .block-heading__title',
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
				'id'=>'bk_blog_page_heading_color',
				'type'        => 'typography',
                'title'       => esc_html__( 'Blog Page Heading Color', 'ceris' ),
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
                'output'      => '.page-template-blog .block-heading .block-heading__title',
                // An array of CSS selectors to apply this font style to dynamically
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option for body text.', 'ceris' ),
                'default'     => array(
                    'color' => '#222',
                ),
                'required' => array(
                    array ('bk_blog_header_style', 'equals' , array( 'style-4', 'style-5', 'style-6', 'style-8', 'style-10', 'line', 'no-line', 'line-under', 'center', 'line-around' )),
                ),
			),
            array(
				'id'=>'bk_blog_content_layout',
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
                    'listing_grid_small'       => get_template_directory_uri().'/images/admin_panel/archive/listing_grid_small.png',
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
                'id'        => 'bk_blog_page_post_bookmark',  
                'type'      => 'button_set',
                'multi'     => false,
                'title'     => esc_html__('Bookmark option', 'ceris'),
                'desc'      => '',
                'options'   => array(
                    'on'    => esc_html__( 'On', 'ceris' ),
	                'off'   => esc_html__( 'Off', 'ceris' ),
                ),
                'default' => 'off',
            ),
            array(
                'id'        => 'bk_blog_post_icon',  
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
                'id'        => 'bk_blog_post_icon_animation',  
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
                'id'        => 'bk_blog_pagination',  
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
                'id'=>'section-blog-sidebar-start',
                'title' => esc_html__('Sidebar', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'        => 'bk_blog_sidebar_select',  
                'type'      => 'select',
                'data'      => 'sidebars', 
                'multi'     => false,
                'title'     => esc_html__('Blog Page Sidebar', 'ceris'),
                'subtitle'  => esc_html__('Choose a sidebar for the blog page', 'ceris'),
                'default'   => 'home_sidebar',
            ),
            array(
                'id'        => 'bk_blog_sidebar_position',  
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
                'id'        => 'bk_blog_sidebar_sticky',  
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
                'id'=>'section-blog-sidebar-end',
                'type' => 'section', 
                'indent' => false // Indent all options below until the next 'section' option is set.
            ), 
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( '404 Page', 'ceris' ),
        'id'               => '404-page-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'=>'section-404-logo-start',
                'title' => esc_html__('404 Logo', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),
            array(
				'id'=>'404-logo',
				'type' => 'media', 
				'url'=> true,
				'title' => esc_html__('Logo', 'ceris'),
				'subtitle' => esc_html__('Upload the logo that should be displayed in 404 page', 'ceris'),
                'placeholder' => esc_html__('No media selected','ceris')
			),
            array(
                'id' => '404-logo-width',
                'type' => 'slider',
                'title' => esc_html__('Site Logo Width (px)', 'ceris'),
                'default' => 200,
                'min' => 0,
                'step' => 10,
                'max' => 1000,
                'display_value' => 'text'
            ),
            array(
                'id'=>'section-404-logo-end',
                'type' => 'section', 
                'indent' => false // Indent all options below until the next 'section' option is set.
            ), 
            array(
                'id'=>'section-404-image-start',
                'title' => esc_html__('404 Image', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),
            array(
				'id'=>'bk-404-image',
				'type' => 'media', 
				'url'=> true,
				'title' => esc_html__('404 Image', 'ceris'),
				'subtitle' => esc_html__('Leave this field empty if you would like to use the default option', 'ceris'),
                'placeholder' => esc_html__('No media selected','ceris')
			),
            array(
                'id'=>'section-404-image-end',
                'type' => 'section', 
                'indent' => false // Indent all options below until the next 'section' option is set.
            ), 
            array(
                'id'=>'section-404-text-start',
                'title' => esc_html__('404 Text', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => '404--main-text',
                'type'     => 'textarea',
                'rows'     => 3,
                'title'    => esc_html__('Main Text', 'ceris'),
                'default'  => ''
            ),   
            array(
                'id'       => '404--sub-text',
                'type'     => 'textarea',
                'rows'     => 3,
                'title'    => esc_html__('Sub Text', 'ceris'),
                'default'  => ''
            ),
            array(
                'id'=>'section-404-text-end',
                'type' => 'section', 
                'indent' => false // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'        => '404-search',  
                'type'      => 'button_set',
                'multi'     => false,
                'title'     => esc_html__('Search Field', 'ceris'),
                'subtitle'  => esc_html__('Enable / Disable Search Field', 'ceris'),
                'desc'      => '',
                'options'   => array(
                    1   => esc_html__( 'Enable', 'ceris' ),
	                0   => esc_html__( 'Disable', 'ceris' ),
                ),
                'default' => 1,
            ),   
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Coming Soon Page', 'ceris' ),
        'id'               => 'coming-soon-page-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'=>'section-coming-soon-background-start',
                'title' => esc_html__('Coming Soon Background', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),
            array(
				'id'=>'bk-coming-soon-bg-style',                            
				'type' => 'select',
				'title' => esc_html__('Background Style', 'ceris'),
				'default'   => 'default',
                'options'   => array(
                    'default'    => esc_html__( 'Default Background', 'ceris' ),                            
	                'image'      => esc_html__( 'Background Image', 'ceris' ),
                    'gradient'   => esc_html__( 'Background Image + Gradient Overlay', 'ceris' ),
                    'color'      => esc_html__( 'Background Color', 'ceris' ),
                ),
			),
            array(
				'id'=>'bk-coming-soon-bg-image',
                'required' => array(
                    array ('bk-coming-soon-bg-style', 'equals' , array( 'image', 'gradient' )),
                ),
				'type' => 'background',
				'output' => array('.page-coming-soon .background-img>.background-img'),
				'title' => esc_html__('Background Image', 'ceris'), 
				'subtitle' => esc_html__('Choose background image for the site header', 'ceris'),
                'background-position' => false,
                'background-repeat' => false,
                'background-size' => false,
                'background-attachment' => false,
                'preview_media' => false,
                'transparent' => false,
                'background-color' => false,
                'default'  => array(
                    'background-color' => '#fff',
                ),
			),
            array(
				'id'=>'bk-coming-soon-bg-gradient',
                'required' => array(
                    array ('bk-coming-soon-bg-style', 'equals' , array( 'gradient' )),
                ),
				'type' => 'color_gradient',
				'title'    => esc_html__('Background Gradient', 'ceris'),
                'validate' => 'color',
                'transparent' => false,
                'default'  => array(
                    'from' => '#1e73be',
                    'to'   => '#00897e', 
                ),
			),
            array(
				'id'=>'bk-coming-soon-bg-gradient-direction',
                'required' => array(
                    array ('bk-coming-soon-bg-style', 'equals' , array( 'gradient' )),
                ),
				'type' => 'text',
				'title'    => esc_html__('Gradient Direction(Degree Number)', 'ceris'),
                'validate' => 'numeric',
			),
            array(
				'id'=>'bk-coming-soon-bg-color',
                'required' => array(
                    array ('bk-coming-soon-bg-style', 'equals' , array( 'color' )),
                ),
				'type' => 'background',                            
				'title' => esc_html__('Background Color', 'ceris'), 
				'subtitle' => esc_html__('Choose background color', 'ceris'),
                'background-position' => false,
                'background-repeat' => false,
                'background-size' => false,
                'background-attachment' => false,
                'preview_media' => false,
                'background-image' => false,
                'transparent' => false,
                'default'  => array(
                    'background-color' => '#fff',
                ),
			),
            array(
				'id'=>'bk-coming-soon-bg-blur-switch',
				'type' => 'button_set',
				'title' => esc_html__('Background Blur', 'ceris'),
				'default'   => 1,
                'options'   => array(
                    1   => esc_html__( 'Enable', 'ceris' ),
	                0   => esc_html__( 'Disable', 'ceris' ),
                ),
			),
            array(
                'id'=>'section-coming-soon-background-end',
                'type' => 'section', 
                'indent' => false // Indent all options below until the next 'section' option is set.
            ),                      
            array(
                'id'=>'section-coming-soon-logo-start',
                'title' => esc_html__('Coming Soon Logo', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),
            array(
				'id'=>'coming-soon-logo',
				'type' => 'media', 
				'url'=> true,
				'title' => esc_html__('Logo', 'ceris'),
				'subtitle' => esc_html__('Upload the logo that should be displayed in coming soon page', 'ceris'),
                'placeholder' => esc_html__('No media selected','ceris')
			),
            array(
                'id' => 'coming-soon-logo-width',
                'type' => 'slider',
                'title' => esc_html__('Site Logo Width (px)', 'ceris'),
                'default' => 400,
                'min' => 0,
                'step' => 10,
                'max' => 1000,
                'display_value' => 'text'
            ),
            array(
                'id'=>'section-coming-soon-logo-end',
                'type' => 'section', 
                'indent' => false // Indent all options below until the next 'section' option is set.
            ), 
            array(
                'id'=>'section-coming-soon-introduction-start',
                'title' => esc_html__('Coming Soon Introduction', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'coming-soon-introduction--main-text',
                'type'     => 'textarea',
                'rows'     => 3,
                'title'    => esc_html__('Introduction Text', 'ceris'),
                'default'  => esc_html__('Be ready, we are launching soon.', 'ceris'),
            ),  
            array(
                'id'=>'section-coming-soon-introduction-text-end',
                'type' => 'section', 
                'indent' => false // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'=>'section-coming-soon-social-start',
                'title' => esc_html__('Coming Soon Social', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),
            array(
				'id'       =>'bk-coming-soon--social',
				'type'     => 'select',
                'multi'    => true,
				'title' => esc_html__('Coming Soon Social Media', 'ceris'),
				'subtitle' => esc_html__('Set up social items for the page', 'ceris'),
				'options'  => array('fb'=>'Facebook', 'twitter'=>'Twitter', 'gplus'=>'GooglePlus', 'linkedin'=>'Linkedin',
                                   'pinterest'=>'Pinterest', 'instagram'=>'Instagram', 'dribbble'=>'Dribbble', 
                                   'youtube'=>'Youtube', 'vimeo'=>'Vimeo', 'vk'=>'VK', 'vine'=>'Vine',
                                   'snapchat'=>'SnapChat', 'telegram'=>'Telegram', 'rss'=>'RSS'),
				'default' => array('fb'=>'', 'twitter'=>'', 'gplus'=>'', 'linkedin'=>'', 'pinterest'=>'', 'instagram'=>'', 'dribbble'=>'', 
                                    'youtube'=>'', 'vimeo'=>'', 'vk'=>'', 'vine'=>'', 'snapchat'=>'', 'telegram'=>'', 'rss'=>'')
			),  
            array(
                'id'=>'section-coming-soon-social-end',
                'type' => 'section', 
                'indent' => false // Indent all options below until the next 'section' option is set.
            ),     
            array(
                'id'=>'section-coming-soon-date-start',
                'title' => esc_html__('Coming Soon Date', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'coming-soon--date',
                'type'     => 'text',
                'title'    => esc_html__('Date (yyyy-mm-dd)', 'ceris'),
                'default'  => ''
            ),  
            array(
                'id'=>'section-coming-soon-date-end',
                'type' => 'section', 
                'indent' => false // Indent all options below until the next 'section' option is set.
            ),    
            array(
                'id'=>'section-coming-soon-mailchimp-start',
                'title' => esc_html__('Mailchimp Form', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ), 
            array(
				'id'=>'bk-coming-soon-mailchimp-shortcode',
				'type' => 'text', 
				'title' => esc_html__('Mailchimp Shortcode', 'ceris'),
				'subtitle' => esc_html__('Insert the Mailchimp Shortcode here', 'ceris'),
                'default' => '',
			),    
            array(
                'id'=>'section-coming-soon-mailchimp-end',
                'type' => 'section', 
                'indent' => false // Indent all options below until the next 'section' option is set.
            ),  
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Default Page Template', 'ceris' ),
        'id'               => 'default-page-template-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'    => 'bk_page_header_style',
                'title' => 'Page Heading',
                'type'  => 'select',
                'options'   => array(
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
                'default'       => 'center',
            ), 
            array(
                'id'          => 'bk_default_page_heading_typography',
                'type'        => 'typography',
                'title'       => esc_html__( 'Default Page Template Heading Font', 'ceris' ),
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
                'text-transform' => true,
                //'word-spacing'  => true,  // Defaults to false
                'letter-spacing'=> true,  // Defaults to false
                'color'         => false,
                'preview'       => true, // Disable the previewer
                'all_styles'  => true,
                // Enable all Google Font style/weight variations to be added to the page
                'output'      => '.page-template-default .block-heading .block-heading__title',
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
				'id'=>'bk_default_page_heading_color',
				'type'        => 'typography',
                'title'       => esc_html__( 'Default Page Template Heading Color', 'ceris' ),
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
                'output'      => '.page-template-default .block-heading .block-heading__title',
                // An array of CSS selectors to apply this font style to dynamically
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option for body text.', 'ceris' ),
                'default'     => array(
                    'color' => '#222',
                ),
                'required' => array(
                    array ('bk_page_header_style', 'equals' , array( 'style-4', 'style-5', 'style-6', 'style-8', 'style-10', 'line', 'no-line', 'line-under', 'center', 'line-around' )),
                ),
			),
            array(
                'id'        => 'bk_page_feat_img',
                'title'     => esc_html__( 'Feature Image Show/Hide', 'ceris' ),
                'type'      => 'switch', 
    			'options'   => array(          
                                1 => esc_html__( 'Show', 'ceris' ),
                                0 => esc_html__( 'Hide', 'ceris' ),
        				    ),
    			'default'    => 1,
            ),
            array(
				'id'=>'bk_page_layout',
				'type' => 'select', 
				'title' => esc_html__('Layout', 'ceris'),
                'options'  => array(
                    'has_sidebar' => esc_html__( 'Has Sidebar', 'ceris' ),
                    'no_sidebar'  => esc_html__( 'Full Width -- No sidebar', 'ceris' ),
			    ),
                'default' => 'has_sidebar',
			),
            array(
                'id'=>'section-default-page--sidebar-start',
                'title' => esc_html__('Sidebar', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'        => 'bk_page_sidebar_select',  
                'type'      => 'select',
                'data'      => 'sidebars', 
                'multi'     => false,
                'title'     => esc_html__('Page Sidebar', 'ceris'),
                'subtitle'  => esc_html__('Choose a sidebar for the page', 'ceris'),
                'default'   => 'home_sidebar',
            ),
            array(
                'id'        => 'bk_page_sidebar_position',  
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
                'id'        => 'bk_page_sidebar_sticky',  
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
                'id'=>'section-default-page--sidebar-end',
                'type' => 'section', 
                'indent' => false // Indent all options below until the next 'section' option is set.
            ), 
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Author List Page', 'ceris' ),
        'id'               => 'author-list-page-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'    => 'bk_authors_list_page_header_style',
                'title' => esc_html__('Page Heading', 'ceris'),
                'type'  => 'select',
                'options'   => array(
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
                'default'       => 'center',
            ), 
            array(
                'id'          => 'bk_author_list_page_heading_typography',
                'type'        => 'typography',
                'title'       => esc_html__( 'Author List Page Heading Font', 'ceris' ),
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
                'text-transform' => true,
                //'word-spacing'  => true,  // Defaults to false
                'letter-spacing'=> true,  // Defaults to false
                'color'         => false,
                'preview'       => true, // Disable the previewer
                'all_styles'  => true,
                // Enable all Google Font style/weight variations to be added to the page
                'output'      => '.page-template-authors-list .block-heading .block-heading__title',
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
				'id'=>'bk_author_list_page_heading_color',
				'type'        => 'typography',
                'title'       => esc_html__( 'Author List Page Heading Color', 'ceris' ),
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
                'output'      => '.page-template-authors-list .block-heading .block-heading__title',
                // An array of CSS selectors to apply this font style to dynamically
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option for body text.', 'ceris' ),
                'default'     => array(
                    'color' => '#222',
                ),
                'required' => array(
                    array ('bk_authors_list_page_header_style', 'equals' , array( 'style-4', 'style-5', 'style-6', 'style-8', 'style-10', 'line', 'no-line', 'line-under', 'center', 'line-around' )),
                ),
			),
            array(
                'id'    => 'bk_authors_list_page_layout',
                'title' => esc_html__('Authors List Page Layout', 'ceris'),
                'type'  => 'select',
                'options'   => array(
                                'listing-list'    => esc_html__( 'Listing List', 'ceris' ),
                                'listing-grid'    => esc_html__( 'Listing Grid', 'ceris' ),
                            ),
                'default'       => 'listing-list',
            ),
            array(
                'id'        => 'bk_authors_list_page_sidebar',
                'title'     => esc_html__( 'Authors List Page Sidebar', 'ceris' ),
                'type'      => 'switch', 
    			'options'   => array(          
                                1 => esc_html__( 'Enable', 'ceris' ),
                                0 => esc_html__( 'Disable', 'ceris' ),
        				    ),
    			'default'    => 1,
            ),
            array(
                'id'=>'section-authors-list-page--start',
                'title' => esc_html__('Authors List Sidebar Setting', 'ceris'),
                'required' => array('bk_authors_list_page_sidebar','=',1),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'        => 'bk_authors_list_page_sidebar_select',  
                'type'      => 'select',
                'data'      => 'sidebars', 
                'multi'     => false,
                'title'     => esc_html__('Page Sidebar', 'ceris'),
                'subtitle'  => esc_html__('Choose a sidebar for the page', 'ceris'),
                'default'   => 'home_sidebar',
            ),
            array(
                'id'        => 'bk_authors_list_page_sidebar_position',  
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
                'id'        => 'bk_authors_list_page_sidebar_sticky',  
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
                'id'=>'section-authors-list-page--end',
                'type' => 'section', 
                'indent' => false // Indent all options below until the next 'section' option is set.
            ), 
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Pagebuilder Template', 'ceris' ),
        'id'               => 'pagebuilder-template-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'=>'section-pagebuilder--sidebar-start',
                'title' => esc_html__('Sidebar', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'        => 'bk_pagebuilder_sidebar_sticky',  
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
                'id'=>'section-pagebuilder--sidebar-end',
                'type' => 'section', 
                'indent' => false // Indent all options below until the next 'section' option is set.
            ), 
        )
    ) );