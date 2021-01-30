<?php
    if ( ! class_exists( 'Redux' ) ) {
        return;
    }
    Redux::setSection( $opt_name, array(
        'id'    => 'single-page-settings-section',
        'icon'  => 'el-icon-indent-left',
		'title' => esc_html__('Single Page Settings', 'ceris'),
        'customizer_width'  => '500px',
        'fields'            => array(
            array(
    			'id'        => 'bk-post-view--cache-time',
                'title'     => esc_html__('Post View Cache Time (in second)', 'ceris'),
                'desc'      => esc_html__('Default: 300 means 5 minutes', 'ceris'),
                'type'      => 'slider',
                'default'   => 300,
                'min'       => 0,
                'step'      => 5,
                'max'       => 3600,
                'display_value' => 'text'
    		),
            array(
    			'id'        => 'bk-wcount-per-min',
                'title'     => esc_html__('Speed Reading', 'ceris'),
                'desc'      => esc_html__('Words per minute', 'ceris'),
                'type'      => 'slider',
                'default'   => 130,
                'min'       => 0,
                'step'      => 5,
                'max'       => 300,
                'display_value' => 'text'
    		),
            array(
                'title' => esc_html__( 'WP schema meta', 'ceris' ),
                'id' => 'bk-wp-schema-meta',
                'type'     => 'button_set',
    			'options'  => array(              
                    1 => esc_html__( 'On', 'ceris' ),
                    0 => esc_html__( 'Off', 'ceris' ),
			    ),
    			'default'   => 1,
            ),
            array(
				'id'=>'bk-single-template',
				'type' => 'image_select', 
                'class' => 'bk-single-post-layout--global-option',
				'title' => esc_html__('Post Layout', 'ceris'),
                'options' => array(
                    'single-1' => array(
                        'alt' => 'Single Template 1',
                        'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-1.png',
                    ),
                    'single-2' => array(
                        'alt' => 'Single Template 2',
                        'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-2.png',
                    ),
                    'single-3' => array(
                        'alt' => 'Single Template 3',
                        'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-3.png',
                    ),
                    'single-4' => array(
                        'alt' => 'Single Template 4',
                        'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-4.png',
                    ),
                    'single-5' => array(
                        'alt' => 'Single Template 5',
                        'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-5.png',
                    ),
                    'single-6' => array(
                        'alt' => 'Single Template 6',
                        'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-6.png',
                    ),
                    'single-7' => array(
                        'alt' => 'Single Template 7',
                        'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-7.png',
                    ),
                    'single-8' => array(
                        'alt' => 'Single Template 8',
                        'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-8.png',
                    ),
                    'single-9' => array(
                        'alt' => 'Single Template 9',
                        'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-9.png',
                    ),
                    'single-10' => array(
                        'alt' => 'Single Template 10',
                        'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-10.png',
                    ),
                    'single-11' => array(
                        'alt' => 'Single Template 11',
                        'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-11.png',
                    ),
                    'single-12' => array(
                        'alt' => 'Single Template 12',
                        'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-12.png',
                    ),
                    'single-13' => array(
                        'alt' => 'Single Template 13',
                        'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-13.png',
                    ),
                    'single-14' => array(
                        'alt' => 'Single Template 14',
                        'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-14.png',
                    ),
                    'single-15' => array(
                        'alt' => 'Single Template 15',
                        'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-15.png',
                    ),
                    'single-16' => array(
                        'alt' => 'Single Template 16',
                        'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-16.png',
                    ),
                    'single-18' => array(
                        'alt' => 'Single Template 17',
                        'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-18.png',
                    ),
                ),
                'default' => 'single-1',
			),
            array(
                'title' => esc_html__( 'Featured Image Config', 'ceris' ),
                'id' => 'bk-feat-img-status',
                'type'     => 'button_set',
    			'options'  => array(              
                    1 => esc_html__( 'On', 'ceris' ),
                    0 => esc_html__( 'Off', 'ceris' ),
			    ),
    			'default'   => 1,
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Current Reading Popup', 'ceris' ),
        'id'               => 'single-current-reading-popup',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'=>'bk-current-reading-popup-sw',
                'type' => 'switch',
                'title' => esc_html__('Artile Current Reading Popup', 'ceris'),
                'default' => 1,
				'On' => esc_html__('Enabled', 'ceris'),
				'Off' => esc_html__('Disabled', 'ceris'),
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Infinity Scrolling', 'ceris' ),
        'id'               => 'single-infinity-scrolling-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'      => 'single-sections-infinity-scrolling',
                'type'      => 'switch',
                'multi'     => false,
                'title'     => esc_html__('Infinity Scrolling', 'ceris'),
                'subtitle'  => esc_html__('Enable / Disable this feature in the single post page', 'ceris'),
                'desc'      => '',
                'options'   => array(
                    1   => esc_html__( 'Enable', 'ceris' ),
	                0   => esc_html__( 'Disable', 'ceris' ),
                ),
                'default' => 0,
            ),
            array(
                'id'=>'bk-infinity-scrolling-term',
                'required' => array('single-sections-infinity-scrolling','=','1'),
                'type' => 'select',
                'title' => esc_html__('Infinity Scrolling Term', 'ceris'),
                'default' => 'next',
				'options'   => array(
                    'next'                  => esc_html__( 'Next Article', 'ceris' ),
	                'next_same_categories'  => esc_html__( 'Next Article in same categories', 'ceris' ),
                ),
            ),
            array(
    			'id'        => 'infinity_scrolling_exclude',
                'required' => array('single-sections-infinity-scrolling','=','1'),
                'title'     => esc_html__('Exclude Term by ID', 'ceris'),
                'subtitle'  => esc_html__('Separated by the comma. Example: 1, 2, 3', 'ceris'),
                'type'      => 'text', 
    			'default'   => '',
    		),
            array(
                'id' => 'section-infinity-ads-start',
                'title' => esc_html__('Ads displays RANDOM between the articles', 'ceris'),
                'type' => 'section',                             
                'indent' => true // Indent all options below until the next 'section' option is set.
            ),  
            array(
                'id'        => 'ceris-ads-editor-1',
                'title'     => esc_html__('Ads Code 1', 'ceris'),
                'type'      => 'ace_editor',
                'mode'      => 'html',
                'theme'     => 'monokai',
            ),
            array(
                'id'        => 'ceris-ads-editor-2',
                'title'     => esc_html__('Ads Code 2', 'ceris'),
                'type'      => 'ace_editor',
                'mode'      => 'html',
                'theme'     => 'monokai',
            ),
            array(
                'id'        => 'ceris-ads-editor-3',
                'title'     => esc_html__('Ads Code 3', 'ceris'),
                'type'      => 'ace_editor',
                'mode'      => 'html',
                'theme'     => 'monokai',
            ),
            array(
                'id'        => 'ceris-ads-editor-4',
                'title'     => esc_html__('Ads Code 4', 'ceris'),
                'type'      => 'ace_editor',
                'mode'      => 'html',
                'theme'     => 'monokai',
            ),
            array(
                'id'        => 'ceris-ads-editor-5',
                'title'     => esc_html__('Ads Code 5', 'ceris'),
                'type'      => 'ace_editor',
                'mode'      => 'html',
                'theme'     => 'monokai',
            ),
            array(
                'id' => 'section-infinity-ads-end',
                'type' => 'section',                             
                'indent' => false // Indent all options below until the next 'section' option is set.
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Single Page Scrolling Percentage Process', 'ceris' ),
        'id'               => 'single-scroll-scrolling-percent-process-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'=>'bk-scroll-percent-sw',
                'type' => 'switch',
                'title' => esc_html__('Single Scroll Percent', 'ceris'),
                'default' => 1,
				'On' => esc_html__('Enabled', 'ceris'),
				'Off' => esc_html__('Disabled', 'ceris'),
            ),
            array(
                'id'      => 'bk-scroll-percent-style',
                'type'    => 'select',
                'required' => array('bk-scroll-percent-sw','=', '1'),
                'title'   => 'Single Scroll Percent Style',
                'default' => 'bookmark',
                'options' => array(
                    'percentage'  => esc_html__('Percentage Inside', 'ceris'),
                    'bookmark'  => esc_html__('Bookmark Inside', 'ceris'),
                ),
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Section Layout Sorter', 'ceris' ),
        'id'               => 'section-layout-sorter-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'      => 'single-sections-sorter',
                'type'    => 'sorter',
                'title'   => 'Manage Layouts',
                'desc'    => 'Organize the layout of Singe Page',
                'options' => array(
                    'enabled'  => array(
                        'related'  => esc_html__('Related Section', 'ceris'),
                        'comment'  => esc_html__('Comment Section', 'ceris'),
                        'same-cat' => esc_html__('Same Category Section', 'ceris'),
                    ),
                ),
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Single Page Sidebar', 'ceris' ),
        'id'               => 'singe-page-sidebar-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'        => 'bk_post_sb_select',  
                'type'      => 'select',
                'data'      => 'sidebars', 
                'multi'     => false,
                'title'     => esc_html__('Single Page Sidebar', 'ceris'),
                'subtitle'  => esc_html__('Choose sidebar for single page', 'ceris'),
                'default'   => 'home_sidebar',
            ),
            array(
                'id'        => 'bk_post_sb_position',  
                'type'      => 'image_select',
                'multi'     => false,
                'title'     => esc_html__('Sidebar Postion', 'ceris'),
                'desc'      => '',
                'options'   => array(
                                    'right' => array(
                                        'alt' => 'Sidebar Right',
                                        'img' => get_template_directory_uri().'/images/admin_panel/single_page/sb-right.png',
                                    ),
                                    'left' => array(
                                        'alt' => 'Sidebar Left',
                                        'img' => get_template_directory_uri().'/images/admin_panel/single_page/sb-left.png',
                                    ),
                            ),
                'default' => 'right',
            ),
            array(
                'id'        => 'bk_post_sb_sticky',  
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
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Reaction Section', 'ceris' ),
        'id'               => 'reaction-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
             array(
				'id'=>'bk-reaction-sw',
				'type' => 'switch', 
				'title' => esc_html__('Enable Reaction Section', 'ceris'),
				'default' => 1,
				'on' => esc_html__('Enabled', 'ceris'),
				'off' => esc_html__('Disabled', 'ceris'),
                'indent' => true
			),
            array(
                'id'=>'bk-reaction-heading',
                'required' => array('bk-reaction-sw','=','1'),
                'type' => 'text',
                'title' => esc_html__('Reaction Heading', 'ceris'),
                'subtitle'  => esc_html__('Insert your text', 'ceris'),
                'default' => esc_html__('What is your reaction?', 'ceris'),
            ),
            //item 1
            array(
                'id'=>'bk-reaction-item-1-sw',
                'required' => array('bk-reaction-sw','=','1'),
                'type' => 'switch',
                'title' => esc_html__('Reaction Item 1', 'ceris'),
                'default' => 1,
				'on' => esc_html__('Enabled', 'ceris'),
				'off' => esc_html__('Disabled', 'ceris'),
            ),
            array(
                'id'=>'bk-reaction-item-1-svg',
                'required' => array('bk-reaction-item-1-sw','=','1'),
                'type' => 'text',
                'title' => esc_html__('Reaction SVG Image code', 'ceris'),
                'subtitle'  => esc_html__('Leave empty to use the default one', 'ceris'),
                'default' => '',
            ),
            array(
                'id'=>'bk-reaction-item-1-text',
                'required' => array('bk-reaction-item-1-sw','=','1'),
                'type' => 'text',
                'title' => esc_html__('Reaction Text', 'ceris'),
                'default' => esc_html__('Excited', 'ceris'),
            ),
            //item 2
            
            array(
                'id'=>'bk-reaction-item-2-sw',
                'required' => array('bk-reaction-sw','=','1'),
                'type' => 'switch',
                'title' => esc_html__('Reaction Item 2', 'ceris'),
                'default' => 1,
				'on' => esc_html__('Enabled', 'ceris'),
				'off' => esc_html__('Disabled', 'ceris'),
            ),
            array(
                'id'=>'bk-reaction-item-2-svg',
                'required' => array('bk-reaction-item-2-sw','=','1'),
                'type' => 'text',
                'title' => esc_html__('Reaction SVG Image code', 'ceris'),
                'subtitle'  => esc_html__('Leave empty to use the default one', 'ceris'),
                'default' => '',
            ),
            array(
                'id'=>'bk-reaction-item-2-text',
                'required' => array('bk-reaction-item-2-sw','=','1'),
                'type' => 'text',
                'title' => esc_html__('Reaction Text', 'ceris'),
                'default' => esc_html__('Happy', 'ceris'),
            ),
            //item 3
            
            array(
                'id'=>'bk-reaction-item-3-sw',
                'required' => array('bk-reaction-sw','=','1'),
                'type' => 'switch',
                'title' => esc_html__('Reaction Item 3', 'ceris'),
                'default' => 1,
				'on' => esc_html__('Enabled', 'ceris'),
				'off' => esc_html__('Disabled', 'ceris'),
            ),
            array(
                'id'=>'bk-reaction-item-3-svg',
                'required' => array('bk-reaction-item-3-sw','=','1'),
                'type' => 'text',
                'title' => esc_html__('Reaction SVG Image code', 'ceris'),
                'subtitle'  => esc_html__('Leave empty to use the default one', 'ceris'),
                'default' => '',
            ),
            array(
                'id'=>'bk-reaction-item-3-text',
                'required' => array('bk-reaction-item-3-sw','=','1'),
                'type' => 'text',
                'title' => esc_html__('Reaction Text', 'ceris'),
                'default' => esc_html__('In Love', 'ceris'),
            ),
            
            //item 4
            
            
            array(
                'id'=>'bk-reaction-item-4-sw',
                'required' => array('bk-reaction-sw','=','1'),
                'type' => 'switch',
                'title' => esc_html__('Reaction Item 4', 'ceris'),
                'default' => 1,
				'on' => esc_html__('Enabled', 'ceris'),
				'off' => esc_html__('Disabled', 'ceris'),
            ),
            array(
                'id'=>'bk-reaction-item-4-svg',
                'required' => array('bk-reaction-item-4-sw','=','1'),
                'type' => 'text',
                'title' => esc_html__('Reaction SVG Image code', 'ceris'),
                'subtitle'  => esc_html__('Leave empty to use the default one', 'ceris'),
                'default' => '',
            ),
            array(
                'id'=>'bk-reaction-item-4-text',
                'required' => array('bk-reaction-item-4-sw','=','1'),
                'type' => 'text',
                'title' => esc_html__('Reaction Text', 'ceris'),
                'default' => esc_html__('Not Sure', 'ceris'),
            ),
            //item 5
            array(
                'id'=>'bk-reaction-item-5-sw',
                'required' => array('bk-reaction-sw','=','1'),
                'type' => 'switch',
                'title' => esc_html__('Reaction Item 5', 'ceris'),
                'default' => 1,
				'on' => esc_html__('Enabled', 'ceris'),
				'off' => esc_html__('Disabled', 'ceris'),
            ),
            array(
                'id'=>'bk-reaction-item-5-svg',
                'required' => array('bk-reaction-item-5-sw','=','1'),
                'type' => 'text',
                'title' => esc_html__('Reaction SVG Image code', 'ceris'),
                'subtitle'  => esc_html__('Leave empty to use the default one', 'ceris'),
                'default' => '',
            ),
            array(
                'id'=>'bk-reaction-item-5-text',
                'required' => array('bk-reaction-item-5-sw','=','1'),
                'type' => 'text',
                'title' => esc_html__('Reaction Text', 'ceris'),
                'default' => esc_html__('Silly', 'ceris'),
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Social Share', 'ceris' ),
        'id'               => 'social-share-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'bk-sharebox-sw',
				'type' => 'switch', 
				'title' => esc_html__('Enable share box', 'ceris'),
				'subtitle' => esc_html__('Enable share links below single post', 'ceris'),
				'default' => 1,
				'on' => esc_html__('Enabled', 'ceris'),
				'off' => esc_html__('Disabled', 'ceris'),
                'indent' => true
			),
            array(
                'id'=>'bk-fb-sw',
                'required' => array('bk-sharebox-sw','=','1'),
                'type' => 'switch',
                'title' => esc_html__('Enable Facebook share link', 'ceris'),
                'default' => 1,
				'on' => esc_html__('Enabled', 'ceris'),
				'off' => esc_html__('Disabled', 'ceris'),
            ),
            array(
                'id'=>'bk-tw-sw',
                'required' => array('bk-sharebox-sw','=','1'),
                'type' => 'switch',
                'title' => esc_html__('Enable Twitter share link', 'ceris'),
                'default' => 1,
				'on' => esc_html__('Enabled', 'ceris'),
				'off' => esc_html__('Disabled', 'ceris'),
            ),
            array(
                'id'=>'bk-pi-sw',
                'required' => array('bk-sharebox-sw','=','1'),
                'type' => 'switch',
                'title' => esc_html__('Enable Pinterest share link', 'ceris'),
                'default' => 1,
				'on' => esc_html__('Enabled', 'ceris'),
				'off' => esc_html__('Disabled', 'ceris'),
            ),
            array(
                'id'=>'bk-li-sw',
                'required' => array('bk-sharebox-sw','=','1'),
                'type' => 'switch',
                'title' => esc_html__('Enable Linkedin share link', 'ceris'),
                'default' => 1,
				'on' => esc_html__('Enabled', 'ceris'),
				'off' => esc_html__('Disabled', 'ceris'),
            ),
            array(
                'id'   =>'social-share-divide',
                'required' => array('bk-sharebox-sw','=','1'),
                'type' => 'divide',
            ),
            array(
                'id'=>'bk-sticky-share-bar',
                'required' => array('bk-sharebox-sw','=','1'),
                'type' => 'switch',
                'title' => esc_html__('Sticky Social Share Bar', 'ceris'),
                'default' => 1,
				'on' => esc_html__('Enabled', 'ceris'),
				'off' => esc_html__('Disabled', 'ceris'),
            ),
            array(
                'id'   =>'social-share-divide-2',
                'required' => array('bk-sharebox-sw','=','1'),
                'type' => 'divide',
            ),
             array(
                'id'=>'bk-mobile-share-heading',
                'required' => array('bk-sharebox-sw','=','1'),
                'type' => 'text',
                'title' => esc_html__('Mobile Share Heading', 'ceris'),
                'default' => esc_html__('Share', 'ceris'),
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Author Box', 'ceris' ),
        'id'               => 'author-box-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'bk-authorbox-sw',
				'type' => 'switch', 
				'title' => esc_html__('Enable author box', 'ceris'),
				'subtitle' => esc_html__('Enable author information below single post', 'ceris'),
				'default' => 1,
				'on' => esc_html__('Enabled', 'ceris'),
				'off' => esc_html__('Disabled', 'ceris'),
			),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Post Nav', 'ceris' ),
        'id'               => 'post-nav-subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'bk-postnav-sw',
				'type' => 'switch', 
				'title' => esc_html__('Enable post navigation', 'ceris'),
				'subtitle' => esc_html__('Enable post navigation below single post', 'ceris'),
				'default' => 1,
				'on' => esc_html__('Enabled', 'ceris'),
				'off' => esc_html__('Disabled', 'ceris'),
			),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Performance/Reader Review Box', 'ceris' ),
        'id'               => 'reader_box_subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'reader_review_box_title',
				'type' => 'text', 
				'title' => esc_html__('Review Box Title', 'ceris'),
				'default' => esc_html__('Product Review', 'ceris'),
			),
            array(
				'id'=>'reader_review_heading',
				'type' => 'text', 
				'title' => esc_html__('Reader Review Heading', 'ceris'),
				'default' => esc_html__('Your Review', 'ceris'),
			),
            array(
				'id'=>'reader_review_sub_heading',
				'type' => 'text', 
				'title' => esc_html__('Reader Review Sub Heading', 'ceris'),
			),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'User Review Confirmation Box', 'ceris' ),
        'id'               => 'user_review_confirmation_box_subsection',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
				'id'=>'confirmation_box_title',
				'type' => 'text', 
				'title' => esc_html__('Confirmation Box Title', 'ceris'),
				'default' => esc_html__('Thank you', 'ceris'),
			),
            array(
				'id'=>'confirmation_box_text',
				'type' => 'text', 
				'title' => esc_html__('Confirmation Box Text', 'ceris'),
				'default' => esc_html__('Your Review is appreciated', 'ceris'),
			),
        )
    ) );