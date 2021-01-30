<?php
    if ( ! class_exists( 'Redux' ) ) {
        return;
    }
    Redux::setSection( $opt_name, array(
        'icon' => 'el el-home',
		'title' => esc_html__('General Setting', 'ceris'),
		'fields' => array(
            array(
				'id'=>'bk-primary-color',
				'type' => 'color',
				'title' => esc_html__('Primary color', 'ceris'), 
				'subtitle' => esc_html__('Pick a primary color for the theme.', 'ceris'),
				'default' => '#3545ee',
                'transparent' => false,
				'validate' => 'color',
			),
            array(
                'id'          => 'html-font-size',
                'type'        => 'typography',
                'title'       => esc_html__( 'HTML Font Size', 'ceris' ),
                'desc'        => esc_html__( 'This will change the font size of overal element in the theme', 'ceris' ),
                'google'      => true,
                // Disable google fonts. Won't work if you haven't defined your google api key
                'font-backup' => true,
                'font-family'   => false,
                // Select a backup non-google font in addition to a google font
                'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                'font-weight'    => false,
                'subsets'       => false, // Only appears if google is true and subsets not set to false
                'font-size'     => true,
                'line-height'   => false,
                'text-align'    => false,
                //'word-spacing'  => false,  // Defaults to false
                'letter-spacing'=> false,  // Defaults to false
                'color'         => false,
                'preview'       => false, // Disable the previewer
                'all_styles'  => false,
                // Enable all Google Font style/weight variations to be added to the page
                'output'      => 'html',
                // An array of CSS selectors to apply this font style to dynamically
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Default is 14px.', 'ceris' ),
                'default'     => array(
                    'font-size'     => '14px',
                ),
            ),
		)
    ) );