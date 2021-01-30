<?php
    if ( ! class_exists( 'Redux' ) ) {
        return;
    }
    Redux::setSection( $opt_name, array(
        'id'    => 'dedicated-header-section',
        'icon'  => 'el-icon-photo',
		'title' => esc_html__('Dedicated Header For Pages', 'ceris'),
        'customizer_width' => '500px',
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Single Page Header', 'ceris' ),
        'id'               => 'single-page-header-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'bk-single-header-switch',
				'type' => 'button_set',
				'title' => esc_html__('Single Page Header Switch', 'ceris'),
				'default'   => 0,
                'options'   => array(
                    1   => esc_html__( 'Enable', 'ceris' ),
	                0   => esc_html__( 'Disable', 'ceris' ),
                ),
			), 
            array(
				'id'=>'bk-single-header-type',
				'title' => esc_html__('Single Header Type', 'ceris'),
				'subtitle' => esc_html__('Choose a Header Type', 'ceris'),
                'required' => array(
                    array ('bk-single-header-switch', 'equals' , array( 1 )),
                ),
                'type' => 'image_select', 
                'options'  => array(
                    'site-header-1' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_1.png',
                    'site-header-2' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_2.png',
                    'site-header-3' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_3.png',
                    'site-header-4' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_4.png',
					'site-header-5' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_5.png',
                    'site-header-6' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_6.png',
                    'site-header-7' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_7.png',
                    'site-header-8' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_8.png',
                    'site-header-9' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_9.png',
                    'site-header-10' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_10.png',
                    'site-header-11' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_11.png',
                    'site-header-15' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_12.png',
                    'site-header-13' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_13.png',
                    'site-header-14' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_14.png',
                    'site-header-16' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_15.png',
                    'site-header-17' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_16.png',
                    'site-header-18' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_17.png',
                ),
                'default' => 'site-header-1',
			),
            array(
                'id'             =>'bk-single-header-spacing',
                'type'           => 'spacing',
                'required' => array(
                    array ('bk-single-header-switch', 'equals' , array( 1 )),
                ),
                'output'         => array('.ceris-dedicated-single-header .header-main'),
                'mode'           => 'padding',
                'left'           => 'false',
                'right'          => 'false',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => esc_html__('Header Padding', 'ceris'),
                'default'            => array(
                    'padding-top'     => '40px', 
                    'padding-bottom'  => '40px', 
                    'units'          => 'px', 
                )
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Category Page Header', 'ceris' ),
        'id'               => 'category-page-header-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'bk-category-header-switch',
				'type' => 'button_set',
				'title' => esc_html__('Category Page Header Switch', 'ceris'),
				'default'   => 0,
                'options'   => array(
                    1   => esc_html__( 'Enable', 'ceris' ),
	                0   => esc_html__( 'Disable', 'ceris' ),
                ),
			), 
            array(
				'id'=>'bk-category-header-type',
				'title' => esc_html__('Category Header Type', 'ceris'),
				'subtitle' => esc_html__('Choose a Header Type', 'ceris'),
                'required' => array(
                    array ('bk-category-header-switch', 'equals' , array( 1 )),
                ),
                'type' => 'image_select', 
                'options'  => array(
                    'site-header-1' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_1.png',
                    'site-header-2' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_2.png',
                    'site-header-3' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_3.png',
                    'site-header-4' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_4.png',
					'site-header-5' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_5.png',
                    'site-header-6' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_6.png',
                    'site-header-7' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_7.png',
                    'site-header-8' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_8.png',
                    'site-header-9' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_9.png',
                    'site-header-10' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_10.png',
                    'site-header-11' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_11.png',
                    'site-header-15' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_12.png',
                    'site-header-13' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_13.png',
                    'site-header-14' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_14.png',
                    'site-header-16' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_15.png',
                    'site-header-17' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_16.png',
                    'site-header-18' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_17.png',
                ),
                'default' => 'site-header-1',
			),
            array(
                'id'             =>'bk-category-header-spacing',
                'type'           => 'spacing',
                'required' => array(
                    array ('bk-category-header-switch', 'equals' , array( 1 )),
                ),
                'output'         => array('.ceris-dedicated-category-header .header-main'),
                'mode'           => 'padding',
                'left'           => 'false',
                'right'          => 'false',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => esc_html__('Header Padding', 'ceris'),
                'default'            => array(
                    'padding-top'     => '40px', 
                    'padding-bottom'  => '40px', 
                    'units'          => 'px', 
                )
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Archive Page Header', 'ceris' ),
        'id'               => 'archive-page-header-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'bk-archive-header-switch',
				'type' => 'button_set',
				'title' => esc_html__('Archive Page Header Switch', 'ceris'),
				'default'   => 0,
                'options'   => array(
                    1   => esc_html__( 'Enable', 'ceris' ),
	                0   => esc_html__( 'Disable', 'ceris' ),
                ),
			), 
            array(
				'id'=>'bk-archive-header-type',
				'title' => esc_html__('Archive Header Type', 'ceris'),
				'subtitle' => esc_html__('Choose a Header Type', 'ceris'),
                'required' => array(
                    array ('bk-archive-header-switch', 'equals' , array( 1 )),
                ),
                'type' => 'image_select', 
                'options'  => array(
                    'site-header-1' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_1.png',
                    'site-header-2' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_2.png',
                    'site-header-3' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_3.png',
                    'site-header-4' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_4.png',
					'site-header-5' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_5.png',
                    'site-header-6' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_6.png',
                    'site-header-7' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_7.png',
                    'site-header-8' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_8.png',
                    'site-header-9' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_9.png',
                    'site-header-10' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_10.png',
                    'site-header-11' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_11.png',
                    'site-header-15' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_12.png',
                    'site-header-13' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_13.png',
                    'site-header-14' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_14.png',
                    'site-header-16' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_15.png',
                    'site-header-17' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_16.png',
                    'site-header-18' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_17.png',
                ),
                'default' => 'site-header-1',
			),
            array(
                'id'             =>'bk-archive-header-spacing',
                'type'           => 'spacing',
                'required' => array(
                    array ('bk-archive-header-switch', 'equals' , array( 1 )),
                ),
                'output'         => array('.ceris-dedicated-archive-header .header-main'),
                'mode'           => 'padding',
                'left'           => 'false',
                'right'          => 'false',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => esc_html__('Header Padding', 'ceris'),
                'default'            => array(
                    'padding-top'     => '40px', 
                    'padding-bottom'  => '40px', 
                    'units'          => 'px', 
                )
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Author Page Header', 'ceris' ),
        'id'               => 'author-page-header-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'bk-author-header-switch',
				'type' => 'button_set',
				'title' => esc_html__('Author Page Header Switch', 'ceris'),
				'default'   => 0,
                'options'   => array(
                    1   => esc_html__( 'Enable', 'ceris' ),
	                0   => esc_html__( 'Disable', 'ceris' ),
                ),
			), 
            array(
				'id'=>'bk-author-header-type',
				'title' => esc_html__('Author Header Type', 'ceris'),
				'subtitle' => esc_html__('Choose a Header Type', 'ceris'),
                'required' => array(
                    array ('bk-author-header-switch', 'equals' , array( 1 )),
                ),
                'type' => 'image_select', 
                'options'  => array(
                    'site-header-1' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_1.png',
                    'site-header-2' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_2.png',
                    'site-header-3' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_3.png',
                    'site-header-4' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_4.png',
					'site-header-5' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_5.png',
                    'site-header-6' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_6.png',
                    'site-header-7' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_7.png',
                    'site-header-8' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_8.png',
                    'site-header-9' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_9.png',
                    'site-header-10' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_10.png',
                    'site-header-11' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_11.png',
                    'site-header-15' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_12.png',
                    'site-header-13' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_13.png',
                    'site-header-14' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_14.png',
                    'site-header-16' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_15.png',
                    'site-header-17' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_16.png',
                    'site-header-18' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_17.png',
                ),
                'default' => 'site-header-1',
			),
            array(
                'id'             =>'bk-author-header-spacing',
                'type'           => 'spacing',
                'required' => array(
                    array ('bk-author-header-switch', 'equals' , array( 1 )),
                ),
                'output'         => array('.ceris-dedicated-author-header .header-main'),
                'mode'           => 'padding',
                'left'           => 'false',
                'right'          => 'false',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => esc_html__('Header Padding', 'ceris'),
                'default'            => array(
                    'padding-top'     => '40px', 
                    'padding-bottom'  => '40px', 
                    'units'          => 'px', 
                )
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Search Page Header', 'ceris' ),
        'id'               => 'search-page-header-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'bk-search-header-switch',
				'type' => 'button_set',
				'title' => esc_html__('Search Page Header Switch', 'ceris'),
				'default'   => 0,
                'options'   => array(
                    1   => esc_html__( 'Enable', 'ceris' ),
	                0   => esc_html__( 'Disable', 'ceris' ),
                ),
			), 
            array(
				'id'=>'bk-search-header-type',
				'title' => esc_html__('Search Header Type', 'ceris'),
				'subtitle' => esc_html__('Choose a Header Type', 'ceris'),
                'required' => array(
                    array ('bk-search-header-switch', 'equals' , array( 1 )),
                ),
                'type' => 'image_select', 
                'options'  => array(
                    'site-header-1' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_1.png',
                    'site-header-2' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_2.png',
                    'site-header-3' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_3.png',
                    'site-header-4' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_4.png',
					'site-header-5' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_5.png',
                    'site-header-6' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_6.png',
                    'site-header-7' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_7.png',
                    'site-header-8' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_8.png',
                    'site-header-9' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_9.png',
                    'site-header-10' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_10.png',
                    'site-header-11' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_11.png',
                    'site-header-15' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_12.png',
                    'site-header-13' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_13.png',
                    'site-header-14' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_14.png',
                    'site-header-16' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_15.png',
                    'site-header-17' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_16.png',
                    'site-header-18' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_17.png',
                ),
                'default' => 'site-header-1',
			),
            array(
                'id'        => 'bk_search_page_post_bookmark',  
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
                'id'             =>'bk-search-header-spacing',
                'type'           => 'spacing',
                'required' => array(
                    array ('bk-search-header-switch', 'equals' , array( 1 )),
                ),
                'output'         => array('.ceris-dedicated-search-header .header-main'),
                'mode'           => 'padding',
                'left'           => 'false',
                'right'          => 'false',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => esc_html__('Header Padding', 'ceris'),
                'default'            => array(
                    'padding-top'     => '40px', 
                    'padding-bottom'  => '40px', 
                    'units'          => 'px', 
                )
            ),
        )
    ) );