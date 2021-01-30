<?php
    if ( ! class_exists( 'Redux' ) ) {
        return;
    }
    Redux::setSection( $opt_name, array(
        'id'    => 'spacing-section',
        'icon' => 'el el-th-large',
		'title' => esc_html__('Spacing Setings', 'ceris'),
        'customizer_width' => '500px',
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Module Spacing', 'ceris' ),
        'id'               => 'top-module-spacing',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'             => 'bk-margin-block',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'left'           => 'false',
                'right'          => 'false',
                'top'          => 'false',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => esc_html__('The Margin bottom of each module', 'ceris'),
                'default'            => array(
                    'margin-bottom'     => '', 
                    'units'          => 'px', 
                )
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Bottom Module Heading Spacing', 'ceris' ),
        'id'               => 'bottom-module-heading-spacing',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'             => 'bk-block-heading-margin',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'left'           => 'false',
                'right'          => 'false',
                'top'          => 'false',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => esc_html__('The Bottom Spacing of Module Heading', 'ceris'),
                'default'            => array(
                    'margin-bottom'  => '', 
                    'units'          => 'px', 
                )
            ),
        )
    ) );