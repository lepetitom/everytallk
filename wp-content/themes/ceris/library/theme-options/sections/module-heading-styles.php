<?php
    if ( ! class_exists( 'Redux' ) ) {
        return;
    }
    Redux::setSection( $opt_name, array(
        'id'    => 'module-heading-styles-section',
        'icon' => 'el el-wrench',
		'title' => esc_html__('Module Heading Styles', 'ceris'),
        'customizer_width' => '500px',
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Default Module Heading', 'ceris' ),
        'id'               => 'default-module-heading-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'bk-default-module-heading',
				'type' => 'select',
				'title' => esc_html__('Default Module Heading', 'ceris'), 
				'subtitle' => esc_html__('Default setting of all module heading style.', 'ceris'),
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
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Heading Font', 'ceris' ),
        'id'               => 'module-heading-typography',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'          => 'module-heading-font',
                'type'        => 'typography',
                'title'       => esc_html__( 'Heading Font Setup', 'ceris' ),
                'google'      => true,
                // Disable google fonts. Won't work if you haven't defined your google api key
                'font-backup' => true,
                // Select a backup non-google font in addition to a google font
                'font-style'    => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                'font-weight'    => true,
                'subsets'       => true, // Only appears if google is true and subsets not set to false
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
                'output'      => array('.block-heading .block-heading__title'),
                // An array of CSS selectors to apply this font style to dynamically
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option for title.', 'ceris' ),
                'default'     => array(
                    'font-family' => 'Poppins',
                    'font-backup' => 'Arial, Helvetica, sans-serif',
                    'font-weight' => '700',
                ),
            ),
            
            array(
                'id'          => 'single-section-heading-font',
                'type'        => 'typography',
                'title'       => esc_html__( 'Single Post Section Heading Font Setup', 'ceris' ),
                'google'      => true,
                // Disable google fonts. Won't work if you haven't defined your google api key
                'font-backup' => true,
                // Select a backup non-google font in addition to a google font
                'font-style'    => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                'font-weight'    => true,
                'subsets'       => true, // Only appears if google is true and subsets not set to false
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
                'output'      => array('.single .single-entry-section .block-heading .block-heading__title, .single .comment-reply-title, .page .comment-reply-title,
                                        .single .same-category-posts .block-heading .block-heading__title, .single .related-posts .block-heading .block-heading__title,
                                        .single .comments-title, .page .comments-title'),
                // An array of CSS selectors to apply this font style to dynamically
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option for title.', 'ceris' ),
                'default'     => array(
                    'font-family' => 'Poppins',
                    'font-backup' => 'Arial, Helvetica, sans-serif',
                    'font-weight' => '700',
                ),
            ),
        ),
    ) );   
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Sub Heading Font', 'ceris' ),
        'id'               => 'module-sub-heading-typography',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'          => 'module-sub-heading-font',
                'type'        => 'typography',
                'title'       => esc_html__( 'Sub Heading Font Setup', 'ceris' ),
                'google'      => true,
                // Disable google fonts. Won't work if you haven't defined your google api key
                'font-backup' => true,
                // Select a backup non-google font in addition to a google font
                'font-style'    => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                'font-weight'    => true,
                'subsets'       => true, // Only appears if google is true and subsets not set to false
                'font-size'     => true,
                'line-height'   => false,
                'text-align'    => false,
                'text-transform'    => true,
                //'word-spacing'  => true,  // Defaults to false
                'letter-spacing'=> true,  // Defaults to false
                'color'         => true,
                'preview'       => true, // Disable the previewer
                'all_styles'  => true,
                // Enable all Google Font style/weight variations to be added to the page
                'output'      => array('.block-heading .page-heading__subtitle'),
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
        'title'            => esc_html__( 'Default Widget Heading', 'ceris' ),
        'id'               => 'default-widget-heading-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'bk-default-widget-heading',
				'type' => 'select',
				'title' => esc_html__('Default Widget Heading', 'ceris'), 
				'subtitle' => esc_html__('Default setting of all widget heading style.', 'ceris'),
                'options'   => array(
                    'line'              => esc_html__( 'Heading Line', 'ceris' ),
                    'no-line'           => esc_html__( 'Heading No Line', 'ceris' ),
                    'line-under'        => esc_html__( 'Heading Line Under', 'ceris' ),
                    'center'            => esc_html__( 'Heading Center', 'ceris' ),
                    'line-around'       => esc_html__( 'Heading Line Around', 'ceris' ),
			    ),
    			'default'    => 'line',
			),
        )
    ) );