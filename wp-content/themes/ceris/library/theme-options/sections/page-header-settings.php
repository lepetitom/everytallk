<?php
    if ( ! class_exists( 'Redux' ) ) {
        return;
    }
    Redux::setSection( $opt_name, array(
        'id'    => 'header-settings-section',
        'icon' => 'el-icon-photo',
    	'title' => esc_html__('Header Settings', 'ceris'),
        'customizer_width' => '500px',
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Header Styles', 'ceris' ),
        'id'               => 'header-style-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'bk-header-type',
				'title' => esc_html__('Default Header Type', 'ceris'),
				'subtitle' => esc_html__('Choose a Header Type', 'ceris'),
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
                    'site-header-12' => get_template_directory_uri().'/images/admin_panel/header/h_ceris_18.png',
                ),
                'default' => 'site-header-1',
			),
            array(
				'id'=>'bk-header-bg-style',                            
				'type' => 'select',
                'required' => array(
                    array ('bk-header-type', 'not' , array( 'site-header-14' )),
                ),
				'title' => esc_html__('Header Background Style', 'ceris'),
				'default'   => 'default',
                'options'   => array(
                    'default'    => esc_html__( 'Default Background', 'ceris' ),
	                'image'      => esc_html__( 'Background Image', 'ceris' ),
                    'gradient'   => esc_html__( 'Background Gradient', 'ceris' ),
                    'color'      => esc_html__( 'Background Color', 'ceris' ),
                ),
			),
            array(
				'id'=>'bk-header-bg-image',
                'required' => array(
                    array ('bk-header-bg-style', 'equals' , array( 'image' )),
                ),
				'type' => 'background',
				'output' => array('.site-header .background-img, .header-4 .navigation-bar, .header-5 .navigation-bar, .header-6 .navigation-bar, .header-10 .navigation-bar,
                                    .header-11 .navigation-bar, .header-13 .navigation-bar, .header-16 .navigation-bar, .header-17 .navigation-bar, .header-18 .navigation-bar'),
				'title' => esc_html__('Header Background Image', 'ceris'), 
				'subtitle' => esc_html__('Choose background image for the site header', 'ceris'),
                'background-position' => true,
                'background-repeat' => true,
                'background-size' => true,
                'background-attachment' => true,
                'preview_media' => true,
                'transparent' => false,
                'background-color' => false,
                'default'  => array(
                    'ackground-repeat' => 'no-repeat',
                    'background-attachment' => 'fixed',
                    'background size'   => 'cover',
                    'background-position'   => 'center center',
                    'background-color' => '#fff',
                ),
			),
            array(
				'id'=>'bk-header-bg-gradient',
                'required' => array(
                    array ('bk-header-bg-style', 'equals' , array( 'gradient' )),
                ),
				'type' => 'color_gradient',
				'title'    => esc_html__('Header Background Gradient', 'ceris'),
                'validate' => 'color',
                'transparent' => false,
                'default'  => array(
                    'from' => '#1e73be',
                    'to'   => '#00897e', 
                ),
			),
            array(
				'id'=>'bk-header-bg-gradient-direction',
                'required' => array(
                    array ('bk-header-bg-style', 'equals' , array( 'gradient' )),
                ),
				'type' => 'text',
				'title'    => esc_html__('Gradient Direction(Degree Number)', 'ceris'),
                'validate' => 'numeric',
			),
            array(
				'id'=>'bk-header-bg-color',
                'required' => array(
                    array ('bk-header-bg-style', 'equals' , array( 'color' )),
                ),
				'type' => 'background',
				'title' => esc_html__('Header Background Color', 'ceris'), 
				'subtitle' => esc_html__('Choose background color for the site header', 'ceris'),
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
                'id'             =>'bk-header-spacing',
                'type'           => 'spacing',
                'output'         => array('.header-main'),
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
            array(
				'id'=>'bk-main-menu-bg-color',
                'required' => array(
                    array ('bk-header-type', 'equals' , array( 'site-header-1', 'site-header-2', 'site-header-3', 'site-header-7', 'site-header-8'
                                                                , 'site-header-9', 'site-header-14', 'site-header-15', 'site-header-12' )),
                ),
				'type' => 'background',
                'output' => array('.site-header .navigation-custom-bg-color, .site-header .navigation-bar .navigation-custom-bg-color'),
				'title' => esc_html__('Main Menu Background Color', 'ceris'), 
				'subtitle' => esc_html__('Choose background color for the site header', 'ceris'),
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
				'id'=>'bk-header-element-inverse',
				'type' => 'button_set',
                'required' => array(
                    array ('bk-header-type', 'equals' , array( 'site-header-1', 'site-header-2', 'site-header-3', 'site-header-7', 'site-header-8'
                                                                , 'site-header-9', 'site-header-14', 'site-header-15', 'site-header-12' )),
                ),
				'title' => esc_html__('Header Text', 'ceris'),
				'default'   => 0,
                'options'   => array(
		                0   => esc_html__( 'Black', 'ceris' ),
                        1   => esc_html__( 'White', 'ceris' ),
                ),
			),
            array(
				'id'=>'bk-header-inverse',
				'type' => 'button_set',
				'title' => esc_html__('Main Menu Bar Text', 'ceris'),
				'default'   => 0,
                'options'   => array(
		                0   => esc_html__( 'Black', 'ceris' ),
                        1   => esc_html__( 'White', 'ceris' ),
                ),
			),
            array(
                'id'=>'section-header-module-start',
                'title' => esc_html__('Header Module Settings', 'ceris'),
                'required' => array(
                    array ('bk-header-type', 'equals' , array( 'site-header-12' )),
                ),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),   
            array(
				'id'=>'bk-header-module-layout',
				'title' => esc_html__('Module Layout', 'ceris'),
				'subtitle' => esc_html__('Choose a module here', 'ceris'),
                'type' => 'image_select', 
                'options'  => array(
                    'feature-module-b' => get_template_directory_uri().'/images/admin_panel/pagebuilder-modules/ceris_26.png',
                    'feature-slider-b' => get_template_directory_uri().'/images/admin_panel/pagebuilder-modules/ce_17.png',
                    'feature-module-c'     => get_template_directory_uri().'/images/admin_panel/pagebuilder-modules/ceris_27.png',
                ),
                'default' => 'feature-module-b',
			),
            array(
				'id'=>'header-module-pick-posts-switch',
				'type' => 'button_set',
				'title' => esc_html__('Editor Picks', 'ceris'),
				'default'   => 1,
                'options'   => array(
                    1   => esc_html__( 'Enable', 'ceris' ),
	                0   => esc_html__( 'Disable', 'ceris' ),
                ),
			),                        
            array(
                'id'    => 'header-module-pick-posts',
                'type'  => 'text',
                'required' => array(
                    array ('header-module-pick-posts-switch', 'equals' , array( 1 )),
                ),
                'title' => esc_html__( 'Manual Pick Posts (by Post IDs)', 'ceris' ), 
                'subtitle'   => esc_html__( 'Insert the post IDs here, separated by a comma. Eg: id1, id2', 'ceris' ), 
                'default'   => '',
            ),
            array(
                'id'    => 'header-module-exclude-posts',
                'type'  => 'text',
                'required' => array(
                    array ('header-module-pick-posts-switch', 'equals' , array( 1 )),
                ),
                'title' => esc_html__( 'Manual Exclude Posts (by Post IDs)', 'ceris' ), 
                'subtitle'   => esc_html__( 'Insert the post IDs here, separated by a comma. Eg: id1, id2', 'ceris' ), 
                'default'   => '',
            ),
            array(
				'id'=>'header-module-featured-post-switch',
                'required' => array(
                    array ('header-module-pick-posts-switch', 'equals' , array( 0 )),
                ),
				'type' => 'button_set',
				'title' => esc_html__('Show featured posts only', 'ceris'),
				'default'   => 'yes',
                'options'   => array(
                    'yes'   => esc_html__( 'Enable', 'ceris' ),
	                'no'    => esc_html__( 'Disable', 'ceris' ),
                ),
			),   
            array(
    			'id'        => 'header-module-post-limit',
                'required' => array(
                    array ('header-module-pick-posts-switch', 'equals' , array( 0 )),
                ),
                'title'     => esc_html__('Number of Posts', 'ceris'),
                'type'      => 'text', 
                'validate'  => 'numeric',
    			'default'   => '8',
    		),
            array(
				'id'=>'header-module-tags-filter',
				'type'     => 'select',
                'required' => array(
                    array ('header-module-pick-posts-switch', 'equals' , array( 0 )),
                ),
				'title'    => esc_html__('Tags', 'ceris'), 
				'subtitle' => esc_html__('Select the Tags to show on this header', 'ceris'),
                'data'     => 'tags',
                'multi'    => true,
                'default'  => 0,
			),
            array(
				'id'=>'header-module-categories-filter',
				'type'     => 'select',
				'title'    => esc_html__('Categories', 'ceris'), 
                'required' => array(
                    array ('header-module-pick-posts-switch', 'equals' , array( 0 )),
                ),
				'subtitle' => esc_html__('Select the Categories to show on this header', 'ceris'),
                'data'     => 'categories',
                'multi'    => true,
                'default'  => array(0),
			),   
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Site Logo', 'ceris' ),
        'id'               => 'site-logo-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'bk-logo',
				'type' => 'media', 
				'url'=> true,
				'title' => esc_html__('Site Logo', 'ceris'),
				'subtitle' => esc_html__('Upload logo of your site that is displayed in header', 'ceris'),
                'placeholder' => esc_html__('No media selected','ceris')
			),
            array(
				'id'=>'bk-site-logo-size-option',
				'type' => 'select',
				'title' => esc_html__('Site Logo Size Option ', 'ceris'),
				'subtitle' => esc_html__('Select between Original Logo Image Size or Customize the Logo Size', 'ceris'),
				'default' => 'original',
                'options'   => array(
	                'original'      => esc_html__( 'Original Logo Image Size', 'ceris' ),
                    'customize'     => esc_html__( 'Customize the Logo Size', 'ceris' ),
                ),
			),
            array(
                'id' => 'site-logo-width',
                'type' => 'slider',
                'required' => array(
                    'bk-site-logo-size-option', 'equals' , array( 'customize' )
                ),
                'title' => esc_html__('Site Logo Width (px)', 'ceris'),
                'default' => 300,
                'min' => 0,
                'step' => 1,
                'max' => 1000,
                'display_value' => 'text'
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Mobile Header', 'ceris' ),
        'id'               => 'mobile-header-settings-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'bk-sticky-header-mobile-switch',
				'type' => 'button_set',
				'title' => esc_html__('Sticky Header on Mobile', 'ceris'),
				'subtitle' => esc_html__('Enable / Disable Sticky Header on Mobile', 'ceris'),
				'default'   => 1,
                'options'   => array(
                    1   => esc_html__( 'Enable', 'ceris' ),
	                0   => esc_html__( 'Disable', 'ceris' ),
                ),
			),
            array(
				'id'=>'bk-mobile-logo',
				'type' => 'media', 
				'url'=> true,
				'title' => esc_html__('Mobile Logo', 'ceris'),
				'subtitle' => esc_html__('Upload logo of your site that is displayed in mobile header', 'ceris'),
                'placeholder' => esc_html__('No media selected','ceris')
			),
            array(
				'id'=>'bk-mobile-logo-size-option',
				'type' => 'select',
				'title' => esc_html__('Mobile Logo Size Option ', 'ceris'),
				'subtitle' => esc_html__('Select between Original Logo Image Size or Customize the Logo Size', 'ceris'),
				'default' => 'original',
                'options'   => array(
	                'original'      => esc_html__( 'Original Logo Image Size', 'ceris' ),
                    'customize'     => esc_html__( 'Customize the Logo Size', 'ceris' ),
                ),
			),
            array(
                'id' => 'site-mobile-logo-width',
                'type' => 'slider',
                'required' => array(
                    'bk-mobile-logo-size-option', 'equals' , array( 'customize' )
                ),
                'title' => esc_html__('Site Logo Width (px)', 'ceris'),
                'default' => 300,
                'min' => 0,
                'step' => 1,
                'max' => 1000,
                'display_value' => 'text'
            ),
            array(
				'id'=>'bk-mobile-menu-bg-style',
				'type' => 'select',
				'title' => esc_html__('Mobile Menu Background Style', 'ceris'),
				'default'   => 'default',
                'options'   => array(
                    'default'    => esc_html__( 'Default Background', 'ceris' ),
                    'gradient'   => esc_html__( 'Background Gradient', 'ceris' ),
                    'color'      => esc_html__( 'Background Color', 'ceris' ),
                ),
			),
            array(
				'id'=>'bk-mobile-menu-bg-gradient',
                'required' => array(
                    array ('bk-mobile-menu-bg-style', 'equals' , array( 'gradient' )),
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
				'id'=>'bk-mobile-menu-bg-gradient-direction',
                'required' => array(
                    array ('bk-mobile-menu-bg-style', 'equals' , array( 'gradient' )),
                ),
				'type' => 'text',
				'title'    => esc_html__('Gradient Direction(Degree Number)', 'ceris'),
                'validate' => 'numeric',
			),
            array(
				'id'=>'bk-mobile-menu-bg-color',
                'required' => array(
                    array ('bk-mobile-menu-bg-style', 'equals' , array( 'color' )),
                ),
				'type' => 'background',
				'title' => esc_html__('Background Color', 'ceris'), 
				'subtitle' => esc_html__('Choose background color for the mobile menu', 'ceris'),
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
				'id'=>'bk-mobile-menu-inverse',
				'type' => 'button_set',
				'title' => esc_html__('Mobile Menu Text', 'ceris'),
				'default'   => 0,
                'options'   => array(
		                0   => esc_html__( 'Black', 'ceris' ),
                        1   => esc_html__( 'White', 'ceris' ),
                ),
			),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Sticky Header', 'ceris' ),
        'id'               => 'sticky-header-settings-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'bk-sticky-menu-switch',
				'type' => 'button_set',
				'title' => esc_html__('Sticky Header', 'ceris'),
				'subtitle' => esc_html__('Enable / Disable Sticky Header Function', 'ceris'),
				'default'   => 1,
                'options'   => array(
                    1   => esc_html__( 'Enable', 'ceris' ),
	                0   => esc_html__( 'Disable', 'ceris' ),
                ),
			),
            array(
				'id'=>'bk-sticky-header-logo',
				'type' => 'media', 
				'url'=> true,
				'title' => esc_html__('Sticky Header Logo', 'ceris'),
				'subtitle' => esc_html__('Upload logo of your site that is displayed in sticky headeer', 'ceris'),
                'placeholder' => esc_html__('No media selected','ceris')
			),
            array(
				'id'=>'bk-sticky-logo-size-option',
				'type' => 'select',
				'title' => esc_html__('Sticky Logo Size Option ', 'ceris'),
				'subtitle' => esc_html__('Select between Original Logo Image Size or Customize the Logo Size', 'ceris'),
				'default' => 'original',
                'options'   => array(
	                'original'      => esc_html__( 'Original Logo Image Size', 'ceris' ),
                    'customize'     => esc_html__( 'Customize the Logo Size', 'ceris' ),
                ),
			),
            array(
                'id' => 'site-sticky-logo-width',
                'type' => 'slider',
                'required' => array(
                    'bk-sticky-logo-size-option', 'equals' , array( 'customize' )
                ),
                'title' => esc_html__('Site Logo Width (px)', 'ceris'),
                'default' => 300,
                'min' => 0,
                'step' => 1,
                'max' => 1000,
                'display_value' => 'text'
            ),
            array(
				'id'=>'bk-sticky-menu-bg-style',
                'required' => array(
                    'bk-sticky-menu-switch','equals', 1
                ),
				'type' => 'select',
				'title' => esc_html__('Sticky Menu Background Style', 'ceris'),
				'default'   => 'default',
                'options'   => array(
                    'default'    => esc_html__( 'Default Background', 'ceris' ),
                    'gradient'   => esc_html__( 'Background Gradient', 'ceris' ),
                    'color'      => esc_html__( 'Background Color', 'ceris' ),
                ),
			),
            array(
				'id'=>'bk-sticky-menu-bg-gradient',
                'required' => array(
                    array ('bk-sticky-menu-switch','equals', 1),
                    array ('bk-sticky-menu-bg-style', 'equals' , array( 'gradient' )),
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
				'id'=>'bk-sticky-menu-bg-gradient-direction',
                'required' => array(
                    array ('bk-sticky-menu-switch','equals', 1),
                    array ('bk-sticky-menu-bg-style', 'equals' , array( 'gradient' )),
                ),
				'type' => 'text',
				'title'    => esc_html__('Gradient Direction(Degree Number)', 'ceris'),
                'validate' => 'numeric',
			),
            array(
				'id'=>'bk-sticky-menu-bg-color',
                'required' => array(
                    array ('bk-sticky-menu-switch','equals', 1),
                    array ('bk-sticky-menu-bg-style', 'equals' , array( 'color' )),
                ),
				'type' => 'background',
				'title' => esc_html__('Background Color', 'ceris'), 
				'subtitle' => esc_html__('Choose background color for the sticky menu', 'ceris'),
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
				'id'=>'bk-sticky-menu-inverse',
				'type' => 'button_set',
				'title' => esc_html__('Sticky Menu Text', 'ceris'),
				'default'   => 0,
                'options'   => array(
		                0   => esc_html__( 'Black', 'ceris' ),
                        1   => esc_html__( 'White', 'ceris' ),
                ),
			),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Off-Canvas Desktop Panel', 'ceris' ),
        'id'               => 'off-canvas-desktop-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'bk-offcanvas-desktop-switch',
				'type' => 'button_set',
				'title' => esc_html__('Off-Canvas Switch ', 'ceris'),
				'subtitle' => esc_html__('Enable/Disable the Offcanvas Menu', 'ceris'),
				'default' => 1,
                'options'   => array(
                    1   => esc_html__( 'Enable', 'ceris' ),
	                0   => esc_html__( 'Disable', 'ceris' ),
                ),
			),	
            array(
				'id'=>'bk-offcanvas-desktop-menu',
                'required' => array('bk-offcanvas-desktop-switch','=',1),
				'type' => 'select',
                'data' => 'menu_location',
				'title' => esc_html__('Select a Menu', 'ceris'),
				'default' => 'offcanvas-menu',
			),
            array(
				'id'=>'bk-offcanvas-desktop-logo',
                'required' => array('bk-offcanvas-desktop-switch','=',1),
				'type' => 'media', 
				'url'=> true,
				'title' => esc_html__('Off-Canvas Logo', 'ceris'),
				'subtitle' => esc_html__('Upload logo of your site that is displayed in Off-Canvas Menu', 'ceris'),
                'placeholder' => esc_html__('No media selected','ceris')
			),
            array(
				'id'       =>'bk-offcanvas-desktop-social',
				'type'     => 'select',
                'required' => array('bk-offcanvas-desktop-switch','=',1),
                'multi'    => true,
				'title' => esc_html__('Off-Canvas Social Media', 'ceris'),
				'subtitle' => esc_html__('Set up social items for site', 'ceris'),
				'options'  => array('fb'=>'Facebook', 'twitter'=>'Twitter', 'gplus'=>'GooglePlus', 'linkedin'=>'Linkedin',
                                   'pinterest'=>'Pinterest', 'instagram'=>'Instagram', 'dribbble'=>'Dribbble', 
                                   'youtube'=>'Youtube', 'vimeo'=>'Vimeo', 'vk'=>'VK', 'vine'=>'Vine',
                                   'snapchat'=>'SnapChat', 'telegram'=>'Telegram', 'rss'=>'RSS'),
				'default' => array('fb'=>'', 'twitter'=>'', 'gplus'=>'', 'linkedin'=>'', 'pinterest'=>'', 'instagram'=>'', 'dribbble'=>'', 
                                    'youtube'=>'', 'vimeo'=>'', 'vk'=>'', 'vine'=>'', 'snapchat'=>'', 'telegram'=>'', 'rss'=>'')
			),
            array(
				'id'=>'bk-offcanvas-desktop-subscribe-switch',
                'required' => array('bk-offcanvas-desktop-switch','=',1),
				'type' => 'switch',
				'title' => esc_html__('Off-Canvas Menu Subscribe Switch', 'ceris'),
				'subtitle'=> esc_html__('On/Off Social Media', 'ceris'),
				'default' => 0
			),
            array(
				'id'=>'bk-offcanvas-desktop-mailchimp-shortcode',
                'required' => array( 
                    array('bk-offcanvas-desktop-subscribe-switch','equals',1), 
                    array('bk-offcanvas-desktop-switch','=',1),
                ),
				'type' => 'text', 
				'title' => esc_html__('Mailchimp Shortcode', 'ceris'),
				'subtitle' => esc_html__('Insert the Mailchimp Shortcode here', 'ceris'),
                'default' => '',
			),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Off-Canvas Mobile Panel', 'ceris' ),
        'id'               => 'off-canvas-mobile-panel-section',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'bk-offcanvas-mobile-menu',
				'type' => 'select',
                'data' => 'menu_location',
				'title' => esc_html__('Select a Menu', 'ceris'),
				'default' => 'main-menu',
			),	
            array(
				'id'=>'bk-offcanvas-mobile-logo',
				'type' => 'media', 
				'url'=> true,
				'title' => esc_html__('Off-Canvas Logo', 'ceris'),
				'subtitle' => esc_html__('Upload logo of your site that is displayed in Off-Canvas Menu', 'ceris'),
                'placeholder' => esc_html__('No media selected','ceris')
			),
            array(
				'id'       =>'bk-offcanvas-mobile-social',
				'type'     => 'select',
                'multi'    => true,
				'title' => esc_html__('Off-Canvas Social Media', 'ceris'),
				'subtitle' => esc_html__('Set up social links for site', 'ceris'),
				'options'  => array('fb'=>'Facebook', 'twitter'=>'Twitter', 'gplus'=>'GooglePlus', 'linkedin'=>'Linkedin',
                                   'pinterest'=>'Pinterest', 'instagram'=>'Instagram', 'dribbble'=>'Dribbble', 
                                   'youtube'=>'Youtube', 'vimeo'=>'Vimeo', 'vk'=>'VK', 'vine'=>'Vine',
                                   'snapchat'=>'SnapChat', 'telegram'=>'Telegram', 'rss'=>'RSS'),
				'default' => array('fb'=>'', 'twitter'=>'', 'gplus'=>'', 'linkedin'=>'', 'pinterest'=>'', 'instagram'=>'', 'dribbble'=>'', 
                                    'youtube'=>'', 'vimeo'=>'', 'vk'=>'', 'vine'=>'', 'snapchat'=>'', 'telegram'=>'', 'rss'=>'')
			),
            array(
				'id'=>'bk-offcanvas-mobile-subscribe-switch',
				'type' => 'switch',
				'title' => esc_html__('Off-Canvas Menu Subscribe Switch', 'ceris'),
				'subtitle'=> esc_html__('On/Off Social Media', 'ceris'),
				'default' => 0
			),
            array(
				'id'=>'bk-offcanvas-mobile-mailchimp-shortcode',
                'required' => array( 
                    array('bk-offcanvas-mobile-subscribe-switch','equals',1), 
                ),
				'type' => 'text', 
				'title' => esc_html__('Mailchimp Shortcode', 'ceris'),
				'subtitle' => esc_html__('Insert the Mailchimp Shortcode here', 'ceris'),
                'default' => '',
			),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Social Header and Ads', 'ceris' ),
        'id'               => 'social-header-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'       =>'bk-social-header',
				'type'     => 'select',
                'multi'    => true,
				'title' => esc_html__('Social Media', 'ceris'),
				'subtitle' => esc_html__('Select social items for the website', 'ceris'),
				'options'  => array('fb'=>'Facebook', 'twitter'=>'Twitter', 'gplus'=>'GooglePlus', 'linkedin'=>'Linkedin',
                                   'pinterest'=>'Pinterest', 'instagram'=>'Instagram', 'dribbble'=>'Dribbble', 
                                   'youtube'=>'Youtube', 'vimeo'=>'Vimeo', 'vk'=>'VK', 'vine'=>'Vine',
                                   'snapchat'=>'SnapChat', 'telegram'=>'Telegram', 'rss'=>'RSS'),
				'default' => array('fb'=>'', 'twitter'=>'', 'gplus'=>'', 'linkedin'=>'', 'pinterest'=>'', 'instagram'=>'', 'dribbble'=>'', 
                                    'youtube'=>'', 'vimeo'=>'', 'vk'=>'', 'vine'=>'', 'snapchat'=>'', 'telegram'=>'', 'rss'=>'')
			),
            array(
                'id' => 'section-ads-header-start',
                'title' => esc_html__('Show Ads on this header instead of the Social Items', 'ceris'),
                'type' => 'section',                             
                'indent' => true, // Indent all options below until the next 'section' option is set.
                'required'  => array (
                    'bk-header-type','equals',array( 'site-header-3', 'site-header-8', 'site-header-9' )
                ),
            ),
            array(
				'id'=>'bk-header-ads',
				'type' => 'switch', 
				'title' => esc_html__('Header Ads', 'ceris'),
                'default' => 0
			), 
            
            array(
				'id'=>'bk-ads-html',
                'required' => array('bk-header-ads','=',1),
				'type' => 'textarea', 
				'title' => esc_html__('HTML Ads Code', 'ceris'),
				'subtitle' => esc_html__('Insert the HTML Ads Code here', 'ceris'),
                'default' => '',
			),
            array(
                'id' => 'section-ads-header-end',
                'type' => 'section',                             
                'indent' => false // Indent all options below until the next 'section' option is set.
            ),
        )
    ) );
    
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Header Mailchimp Form', 'ceris' ),
        'id'               => 'header-mailchimp-form-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'bk-header-subscribe-switch',
				'type' => 'switch',
				'title' => esc_html__('Header Subscribe Switch', 'ceris'),
				'subtitle'=> esc_html__('On/Off Header Subscribe', 'ceris'),
				'default' => 0
			),
            array(
				'id'=>'bk-mailchimp-title',
                'required' => array('bk-header-subscribe-switch','=',1),
				'type' => 'text', 
				'title' => esc_html__('Mailchimp Form Title', 'ceris'),
                'default' => '',
			),
            array(
				'id'=>'bk-mailchimp-shortcode',
                'required' => array('bk-header-subscribe-switch','=',1),
				'type' => 'text', 
				'title' => esc_html__('Mailchimp Shortcode', 'ceris'),
				'subtitle' => esc_html__('Insert the Mailchimp Shortcode here', 'ceris'),
                'default' => '',
			),
        )
    ) );