<?php
    if ( ! class_exists( 'Redux' ) ) {
        return;
    }
    Redux::setSection( $opt_name, array(
        'id'    => 'footer-settings-section',
        'icon' => 'el el-wrench',
		'title' => esc_html__('Footer Settings', 'ceris'),
        'customizer_width' => '500px',
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Footer Layouts', 'ceris' ),
        'id'               => 'footer-layouts-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'bk-footer-template',
                'class' => 'bk-footer-layout--global-option',
				'title' => esc_html__('Footer Layout', 'ceris'),
                'type' => 'image_select', 
                'options'  => array(
                    'default' => get_template_directory_uri().'/images/admin_panel/footer/ceris_1.png',
                    'footer-1' => get_template_directory_uri().'/images/admin_panel/footer/ceris_2.png',
                    'footer-2' => get_template_directory_uri().'/images/admin_panel/footer/ceris_3.png',
                    'footer-3' => get_template_directory_uri().'/images/admin_panel/footer/ceris_4.png',
                    'footer-4' => get_template_directory_uri().'/images/admin_panel/footer/ceris_5.png',
					'footer-5' => get_template_directory_uri().'/images/admin_panel/footer/ceris_6.png',
                    //'footer-6' => get_template_directory_uri().'/images/admin_panel/footer/6.png',
                    'footer-7' => get_template_directory_uri().'/images/admin_panel/footer/ceris_7.png',
                    'footer-8' => get_template_directory_uri().'/images/admin_panel/footer/ceris_8.png',
                ),
                'default' => 'default',
			),
            array(
                'id'       => 'footer-col-scale',
                'required' => array(
                    'bk-footer-template','equals',array( 'footer-7', 'footer-8' )
                ),
                'type'     => 'select',
                'multi'    => false,
                'title'    => esc_html__('Footer Column Width', 'ceris'),
                'options'   => array(
                                1   => esc_html__( '1/3 1/3 1/3', 'ceris' ),
					            2   => esc_html__( '1/2 1/4 1/4', 'ceris' ),
                 ),
                 'default'  => 1,
            ),
            array(
                'id'       => 'footer-col-1',
                'required' => array(
                    'bk-footer-template','equals',array( 'footer-7', 'footer-8' )
                ),
                'type'     => 'select',
                'data'     => 'sidebars',
                'multi'    => false,
                'title'    => esc_html__('Footer Column 1', 'ceris'),
                'default'  => 'footer_sidebar_1',
            ),
            array(
                'id'       => 'footer-col-2',
                'required' => array(
                    'bk-footer-template','equals',array( 'footer-7', 'footer-8' )
                ),
                'type'     => 'select',
                'data'     => 'sidebars',
                'multi'    => false,
                'title'    => esc_html__('Footer Column 2', 'ceris'),
                'default'  => 'footer_sidebar_2',
            ),
            array(
                'id'       => 'footer-col-3',
                'required' => array(
                    'bk-footer-template','equals',array( 'footer-7', 'footer-8' )
                ),
                'type'     => 'select',
                'data'     => 'sidebars',
                'multi'    => false,
                'title'    => esc_html__('Footer Column 3', 'ceris'),
                'default'  => 'footer_sidebar_3',
            ),
            array(
                'id' => 'section-footer-mailchimp-start',
                'required' => array(
                    'bk-footer-template','equals',array( 'footer-1', 'footer-3', 'footer-5' )
                ),
                'title' => esc_html__('Mailchimp Subscribe Form Setting', 'ceris'),
                'subtitle' => '',
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),  
            array(
				'id'=>'bk-footer--mailchimp-bg',
				'type' => 'background',
                'required' => array(
                    'bk-footer-template','equals',array( 'footer-1' )
                ),
				'title' => esc_html__('Mailchimp background', 'ceris'), 
                'transparent' => false,
                'background-color' => false,
                'background-repeat' => false,
                'background-position' => false,
                'background-attachment' => false,
                'background-size'   => false,
                'preview'   => false,
				'subtitle' => esc_html__('Leave empty if you wish to use the default background', 'ceris'),
			),
            array(
                'id'       => 'footer-mailchimp--shortcode',
                'type'     => 'textarea',
                'rows'     => 3,
                'title'    => esc_html__('Mailchimp Subscribe Form Shortcode', 'ceris'),
                'default'  => ''
            ),
            array(
                'id' => 'section-footer-mailchimp-end',
                'type' => 'section',                             
                'indent' => false // Indent all options below until the next 'section' option is set.
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Footer background', 'ceris' ),
        'id'               => 'footer-background-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'bk-footer-bg-style',
				'type' => 'select',
				'title' => esc_html__('Footer Background Style', 'ceris'),
				'default'   => 'default',
                'options'   => array(
                    'default'    => esc_html__( 'Default Background', 'ceris' ),
                    'gradient'   => esc_html__( 'Background Gradient', 'ceris' ),
                    'color'      => esc_html__( 'Background Color', 'ceris' ),
                ),
			),
            array(
				'id'=>'bk-footer-bg-gradient',
                'required' => array(
                    array ('bk-footer-bg-style', 'equals' , array( 'gradient' )),
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
				'id'=>'bk-footer-bg-gradient-direction',
                'required' => array(
                    array ('bk-footer-bg-style', 'equals' , array( 'gradient' )),
                ),
				'type' => 'text',
				'title'    => esc_html__('Gradient Direction(Degree Number)', 'ceris'),
                'validate' => 'numeric',
			),
            array(
				'id'=>'bk-footer-bg-color',
                'required' => array(
                    array ('bk-footer-bg-style', 'equals' , array( 'color' )),
                ),
				'type' => 'background',
				'title' => esc_html__('Background Color', 'ceris'), 
				'subtitle' => esc_html__('Choose background color for the Footer', 'ceris'),
                'background-position' => false,
                'background-repeat' => false,
                'background-size' => false,
                'background-attachment' => false,
                'preview_media' => false,
                'background-image' => false,
                'transparent' => false,
                'default'  => array(
                    'background-color' => '#333',
                ),
			),
            array(
				'id'=>'bk-footer-inverse',
				'type' => 'button_set',
				'title' => esc_html__('Footer Text', 'ceris'),
				'default'   => 0,
                'options'   => array(
	                0   => esc_html__( 'Black', 'ceris' ),
                    1   => esc_html__( 'White', 'ceris' ),
                ),
			),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Footer Logo', 'ceris' ),
        'id'               => 'footer-logo-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
    			'id'=>'bk-footer-logo',
    			'type' => 'media', 
    			'url'=> true,
    			'title' => esc_html__('Footer Logo', 'ceris'),
    			'subtitle' => esc_html__('Upload the logo image that will be displayed in footer', 'ceris'),
                'placeholder' => esc_html__('No media selected','ceris')
    		),
            array(
                'id' => 'footer-logo-width',
                'type' => 'slider',
                'title' => esc_html__('Footer Logo Width (px)', 'ceris'),
                'default' => 200,
                'min' => 0,
                'step' => 10,
                'max' => 1000,
                'display_value' => 'text'
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Footer Bottom', 'ceris' ),
        'id'               => 'footer-bottom-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'       => 'footer-social',
                'required' => array(
                    'bk-footer-template','equals',array( 'footer-1', 'footer-2', 'footer-4', 'footer-5', 'footer-6' ,'default')
                ),
                'type'     => 'select',
                'multi'    => true,
                'title'    => esc_html__('Footer Social', 'ceris'),
                'options'  => array('fb'=>'Facebook', 'twitter'=>'Twitter', 'gplus'=>'GooglePlus', 'linkedin'=>'Linkedin',
                                   'pinterest'=>'Pinterest', 'instagram'=>'Instagram', 'dribbble'=>'Dribbble', 
                                   'youtube'=>'Youtube', 'vimeo'=>'Vimeo', 'vk'=>'VK', 'vine'=>'Vine',
                                   'snapchat'=>'SnapChat', 'telegram'=>'Telegram', 'rss'=>'RSS'),
            ),
            array(
                'id'       => 'footer-copyright-text',
                'type'     => 'textarea',
                'required' => array(
                    'bk-footer-template','equals',array( 'footer-1', 'footer-2', 'footer-3', 'footer-4', 'footer-5', 'footer-6','footer-7', 'footer-8', 'default' )
                ),
                'rows'     => 3,
                'title'    => esc_html__('Footer Copyright Text', 'ceris'),
                'default'  => 'By <a href="https://themeforest.net/user/bkninja/portfolio">BKNinja</a>'
            ),
        )
    ) );