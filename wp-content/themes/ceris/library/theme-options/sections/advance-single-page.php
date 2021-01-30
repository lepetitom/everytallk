<?php
    if ( ! class_exists( 'Redux' ) ) {
        return;
    }
    Redux::setSection( $opt_name, array(
        'id'    => 'advance-single-page-section',
        'icon' => 'el el-wrench',
		'title' => esc_html__('Advance Single Page', 'ceris'),
        'customizer_width' => '500px',
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Layouts with Sidebar', 'ceris' ),
        'id'               => 'single-layouts-with-sidebar-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id' => 'section-related-start',
                'title' => esc_html__('Related Posts Section Setting - Has Sidebar Layout', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),  
             array(
				'id'=>'bk-related-sw',
				'type' => 'switch',
				'title' => esc_html__('Enable related posts', 'ceris'),
				'subtitle' => esc_html__('Enable related posts below single post', 'ceris'),
				'default' => 1,
				'on' => esc_html__('Enabled', 'ceris'),
				'off' => esc_html__('Disabled', 'ceris'),
			),
            array(
    			'id'        => 'bk_related_post_layout',
                'required' => array('bk-related-sw','=','1'),
                'title'     => esc_html__('Layout', 'ceris'),
                'type'      => 'image_select', 
    			'options'  => array(
                    'listing_list'         => get_template_directory_uri().'/images/admin_panel/related-module/ceris_14.png',
                    'listing_list_b'       => get_template_directory_uri().'/images/admin_panel/related-module/ceris_15.png',
                    'listing_list_large_a' => get_template_directory_uri().'/images/admin_panel/related-module/ceris_16.png',
                    'listing_list_large_b' => get_template_directory_uri().'/images/admin_panel/related-module/ceris_17.png',
                    'listing_grid'         => get_template_directory_uri().'/images/admin_panel/related-module/ceris_18.png',
                    'listing_grid_b'       => get_template_directory_uri().'/images/admin_panel/related-module/ceris_19.png',
                    'listing_grid_small'   => get_template_directory_uri().'/images/admin_panel/archive/listing_grid_small.png',
                    
			    ),
    			'default'   => 'listing_list',
    		),
            array(
    			'id'        => 'bk_related_heading_style',
                'required' => array('bk-related-sw','=','1'),
                'title'     => esc_html__('Heading Style', 'ceris'),
                'type'      => 'select', 
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
    			'default'    => 'no-line',
    		),
            array(
    			'id'        => 'bk_related_source',
                'required' => array('bk-related-sw','=','1'),
                'title'     => esc_html__('Related Posts', 'ceris'),
                'type'      => 'select', 
    			'options'   => array(
                                'category_tag' => esc_html__( 'Same Categories and Tags', 'ceris' ),
            					'tag'          => esc_html__( 'Same Tags', 'ceris' ),
                                'category'     => esc_html__( 'Same Categories', 'ceris' ),
                                'author'       => esc_html__( 'Same Author', 'ceris' ),
        				    ),
    			'default'    => 'category_tag',
    		),
            array(
    			'id'        => 'bk_number_related',
                'required' => array('bk-related-sw','=','1'),
                'title'     => esc_html__('Number of Related Posts', 'ceris'),
                'type'      => 'text', 
                'validate'  => 'numeric',
    			'default'   => '3',
    		),
            array(
    			'id'        => 'bk_related_post_icon',
                'required' => array('bk-related-sw','=','1'),
                'title'     => esc_html__('Post Icon', 'ceris'),
                'type'      => 'button_set', 
    			'options'   => array(
                    'enable'    => esc_html__( 'Enable', 'ceris' ),
                    'disable'   => esc_html__( 'Disable', 'ceris' ),
			    ),
    			'default'   => 'disable',
    		),
            array(
    			'id'        => 'bk_related_post_icon_animation',
                'required' => array('bk-related-sw','=','1'),
                'title'     => esc_html__('Post Icon Animation', 'ceris'),
                'type'      => 'button_set', 
    			'options'   => array(
                    'enable'    => esc_html__( 'Enable', 'ceris' ),
                    'disable'   => esc_html__( 'Disable', 'ceris' ),
			    ),
    			'default'   => 'disable',
    		),
            array(
                'id' => 'section-related-end',
                'type' => 'section',                             
                'indent' => false // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id' => 'section-same-cat-start',
                'title' => esc_html__('More From Category Section Setting - Has Sidebar Layout', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),
            array(
				'id'=>'bk-same-cat-sw',
				'type' => 'switch',
				'title' => esc_html__('Enable More From Category Section', 'ceris'),
				'default' => 1,
				'on' => esc_html__('Enabled', 'ceris'),
				'off' => esc_html__('Disabled', 'ceris'),
			),
            array(
    			'id'        => 'bk_same_cat_post_layout',
                'required' => array('bk-same-cat-sw','=','1'),
                'title'     => esc_html__('Layout', 'ceris'),
                'type'      => 'image_select', 
    			'options'  => array(
                    'listing_list'         => get_template_directory_uri().'/images/admin_panel/related-module/ceris_14.png',
                    'listing_list_b'       => get_template_directory_uri().'/images/admin_panel/related-module/ceris_15.png',
                    'listing_list_large_a' => get_template_directory_uri().'/images/admin_panel/related-module/ceris_16.png',
                    'listing_list_large_b' => get_template_directory_uri().'/images/admin_panel/related-module/ceris_17.png',
                    'listing_grid'         => get_template_directory_uri().'/images/admin_panel/related-module/ceris_18.png',
                    'listing_grid_b'       => get_template_directory_uri().'/images/admin_panel/related-module/ceris_19.png',
                    'listing_grid_small'   => get_template_directory_uri().'/images/admin_panel/archive/listing_grid_small.png',
                   
			    ),
    			'default'   => 'listing_list',
    		),
            array(
    			'id'        => 'bk_same_cat_heading_style',
                'required' => array('bk-same-cat-sw','=','1'),
                'title'     => esc_html__('Heading Style', 'ceris'),
                'type'      => 'select', 
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
    			'default'    => 'no-line',
    		),
            array(
    			'id'        => 'bk_same_cat_number_posts',
                'required' => array('bk-same-cat-sw','=','1'),
                'title'     => esc_html__('Number of Posts', 'ceris'),
                'type'      => 'text', 
                'validate'  => 'numeric',
    			'default'   => '3',
    		),
            array(
    			'id'        => 'bk_same_cat_post_icon',
                'required' => array('bk-same-cat-sw','=','1'),
                'title'     => esc_html__('Post Icon', 'ceris'),
                'type'      => 'button_set', 
    			'options'   => array(
                    'enable'    => esc_html__( 'Enable', 'ceris' ),
                    'disable'   => esc_html__( 'Disable', 'ceris' ),
			    ),
    			'default'   => 'disable',
    		),
            array(
    			'id'        => 'bk_same_cat_post_icon_animation',
                'required' => array('bk-same-cat-sw','=','1'),
                'title'     => esc_html__('Post Icon Animation', 'ceris'),
                'type'      => 'button_set', 
    			'options'   => array(
                    'enable'    => esc_html__( 'Enable', 'ceris' ),
                    'disable'   => esc_html__( 'Disable', 'ceris' ),
			    ),
    			'default'   => 'disable',
    		),
            array(
    			'id'        => 'bk_same_cat_more_link',
                'required' => array('bk-same-cat-sw','=','1'),
                'title'     => esc_html__('More Link', 'ceris'),
                'type'      => 'button_set', 
    			'options'   => array(
                    1    => esc_html__( 'Enable', 'ceris' ),
                    0    => esc_html__( 'Disable', 'ceris' ),
			    ),
    			'default'   => 0,
    		),
            array(
                'id' => 'section-same-cat-end',
                'type' => 'section',                             
                'indent' => false // Indent all options below until the next 'section' option is set.
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Layouts Full Width', 'ceris' ),
        'id'               => 'single-layouts-full-width-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id' => 'section-related-wide-start',
                'title' => esc_html__('Related Posts Section Setting - Full Width Post Layout', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),  
            array(
				'id'=>'bk-related-sw-wide',
				'type' => 'switch',
				'title' => esc_html__('Enable related posts - Wide', 'ceris'),
				'subtitle' => esc_html__('Enable related posts below single post', 'ceris'),
				'default' => 1,
				'on' => esc_html__('Enabled', 'ceris'),
				'off' => esc_html__('Disabled', 'ceris'),
			),
            array(
    			'id'        => 'bk_related_post_layout_wide',
                'required' => array('bk-related-sw-wide','=','1'),
                'title'     => esc_html__('Layout - Wide', 'ceris'),
                'type'      => 'image_select', 
    			'options'  => array(
                    
                    'listing_list_no_sidebar'         => get_template_directory_uri().'/images/admin_panel/archive/ceris_20.png',
                    'listing_list_b_no_sidebar'       => get_template_directory_uri().'/images/admin_panel/archive/ceris_21.png',
                    'listing_list_large_a_no_sidebar' => get_template_directory_uri().'/images/admin_panel/archive/ceris_22.png',
                    'listing_list_large_b_no_sidebar' => get_template_directory_uri().'/images/admin_panel/archive/ceris_23.png',
                    'listing_grid_no_sidebar'         => get_template_directory_uri().'/images/admin_panel/archive/ceris_24.png',
                    'listing_grid_b_no_sidebar'       => get_template_directory_uri().'/images/admin_panel/archive/ceris_25.png',
			    ),
    			'default'   => 'listing_grid_no_sidebar',
    		),
            array(
    			'id'        => 'bk_related_heading_style_wide',
                'required' => array('bk-related-sw-wide','=','1'),
                'title'     => esc_html__('Heading Style - Wide', 'ceris'),
                'type'      => 'select', 
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
    			'default'    => 'no-line',
    		),
            array(
    			'id'        => 'bk_related_source_wide',
                'required' => array('bk-related-sw-wide','=','1'),
                'title'     => esc_html__('Related Posts - Wide', 'ceris'),
                'type'      => 'select', 
    			'options'   => array(
                                'category_tag' => esc_html__( 'Same Categories and Tags', 'ceris' ),
            					'tag'          => esc_html__( 'Same Tags', 'ceris' ),
                                'category'     => esc_html__( 'Same Categories', 'ceris' ),
                                'author'       => esc_html__( 'Same Author', 'ceris' ),
        				    ),
    			'default'    => 'category_tag',
    		),
            array(
    			'id'        => 'bk_related_post_icon_wide',
                'required' => array('bk-related-sw-wide','=','1'),
                'title'     => esc_html__('Post Icon', 'ceris'),
                'type'      => 'button_set', 
                'options'   => array(
                    'enable'    => esc_html__( 'Enable', 'ceris' ),
                    'disable'   => esc_html__( 'Disable', 'ceris' ),
			    ),
    			'default'   => 'disable',
    		),
            array(
    			'id'        => 'bk_related_post_icon_animation_wide',
                'required' => array('bk-related-sw-wide','=','1'),
                'title'     => esc_html__('Post Icon Animation', 'ceris'),
                'type'      => 'button_set', 
                'options'   => array(
                    'enable'    => esc_html__( 'Enable', 'ceris' ),
                    'disable'   => esc_html__( 'Disable', 'ceris' ),
			    ),
    			'default'   => 'disable',
    		),
            array(
                'id' => 'section-related-wide-end',
                'type' => 'section',                             
                'indent' => false // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id' => 'section-same-cat-wide-start',
                'title' => esc_html__('More From Category Section Setting - Full Width Post Layout', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),
            array(
				'id'=>'bk-same-cat-sw-wide',
				'type' => 'switch',
				'title' => esc_html__('Enable More From Category Section - Wide', 'ceris'),
				'default' => 1,
				'on' => esc_html__('Enabled', 'ceris'),
				'off' => esc_html__('Disabled', 'ceris'),
			),
            array(
    			'id'        => 'bk_same_cat_post_layout_wide',
                'required' => array('bk-same-cat-sw-wide','=','1'),
                'title'     => esc_html__('Layout - Wide', 'ceris'),
                'type'      => 'image_select', 
    			'options'  => array(
                    'listing_list_no_sidebar'         => get_template_directory_uri().'/images/admin_panel/archive/ceris_20.png',
                    'listing_list_b_no_sidebar'       => get_template_directory_uri().'/images/admin_panel/archive/ceris_21.png',
                    'listing_list_large_a_no_sidebar' => get_template_directory_uri().'/images/admin_panel/archive/ceris_22.png',
                    'listing_list_large_b_no_sidebar' => get_template_directory_uri().'/images/admin_panel/archive/ceris_23.png',
                    'listing_grid_no_sidebar'         => get_template_directory_uri().'/images/admin_panel/archive/ceris_24.png',
                    'listing_grid_b_no_sidebar'       => get_template_directory_uri().'/images/admin_panel/archive/ceris_25.png',
			    ),
    			'default'   => 'listing_list_no_sidebar',
    		),
            array(
    			'id'        => 'bk_same_cat_heading_style_wide',
                'required' => array('bk-same-cat-sw-wide','=','1'),
                'title'     => esc_html__('Heading Style - Wide', 'ceris'),
                'type'      => 'select', 
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
    			'default'    => 'no-line',
    		),
            array(
    			'id'        => 'bk_same_cat_post_icon_wide',
                'required' => array('bk-same-cat-sw-wide','=','1'),
                'title'     => esc_html__('Post Icon', 'ceris'),
                'type'      => 'button_set', 
    			'options'   => array(
                    'enable'    => esc_html__( 'Enable', 'ceris' ),
                    'disable'   => esc_html__( 'Disable', 'ceris' ),
			    ),
    			'default'   => 'disable',
    		),
            array(
    			'id'        => 'bk_same_cat_post_icon_animation_wide',
                'required' => array('bk-same-cat-sw-wide','=','1'),
                'title'     => esc_html__('Post Icon Animation', 'ceris'),
                'type'      => 'button_set', 
    			'options'   => array(
                    'enable'    => esc_html__( 'Enable', 'ceris' ),
                    'disable'   => esc_html__( 'Disable', 'ceris' ),
			    ),
    			'default'   => 'disable',
    		),
            array(
    			'id'        => 'bk_same_cat_more_link_wide',
                'required' => array('bk-same-cat-sw-wide','=','1'),
                'title'     => esc_html__('More Link', 'ceris'),
                'type'      => 'button_set', 
    			'options'   => array(
                    1   => esc_html__( 'Enable', 'ceris' ),
                    0   => esc_html__( 'Disable', 'ceris' ),
			    ),
    			'default'   => 1,
    		),
            array(
                'id' => 'section-same-cat-wide-end',
                'type' => 'section',                             
                'indent' => false // Indent all options below until the next 'section' option is set.
            ),
        )
    ) );