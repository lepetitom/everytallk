<?php
if ( ! class_exists( 'Redux' ) ) {
    return;
}
Redux::setSection( $opt_name, array(
    'id'    => 'woocommerce-settings-section',
    'icon' => 'el el-wrench',
	'title' => esc_html__('Woocommerce Settings', 'ceris'),
    'customizer_width' => '500px',
) );
Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Woocommerce Page', 'ceris' ),
    'id'               => 'woocommerce-page-subsection',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
			'id'=>'bk_woocommerce_header_style',
			'type' => 'select',
			'title' => esc_html__('Woocomerce Pages Heading', 'ceris'),
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
            'id'          => 'bk_woocommerce_page_heading_typography',
            'type'        => 'typography',
            'title'       => esc_html__( 'Woocommerce Page Heading Font', 'ceris' ),
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
            'output'      => '.archive.woocommerce .block-heading .block-heading__title, .page-template-default.woocommerce-page .block-heading .block-heading__title',
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
			'id'=>'bk_woocommerce_page_heading_color',
			'type'        => 'typography',
            'title'       => esc_html__( 'Woocommerce Page Heading Color', 'ceris' ),
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
            'output'      => '.archive.woocommerce .block-heading .block-heading__title, .page-template-default.woocommerce-page .block-heading .block-heading__title',
            // An array of CSS selectors to apply this font style to dynamically
            'units'       => 'px',
            // Defaults to px
            'subtitle'    => esc_html__( 'Typography option for body text.', 'ceris' ),
            'default'     => array(
                'color' => '#222',
            ),
            'required' => array(
                array ('bk_woocommerce_header_style', 'equals' , array( 'style-4', 'style-5', 'style-6', 'style-8', 'style-10', 'line', 'no-line', 'line-under', 'center', 'line-around' )),
            ),
		),
    )
) );
