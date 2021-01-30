<?php
/********************* META BOX DEFINITIONS ***********************/

/**
 * Prefix of meta keys (optional)
 * Use underscore (_) at the beginning to make keys hidden
 * Alt.: You also can make prefix empty to disable it
 */
if(! function_exists('bk_register_meta_boxes')) {
    add_filter( 'rwmb_meta_boxes', 'bk_register_meta_boxes' );
    function bk_register_meta_boxes( $meta_boxes ) {
            
        // Better has an underscore as last sign
        
        global $meta_boxes;
        
        $bk_sidebar = array();
        foreach ( $GLOBALS['wp_registered_sidebars'] as $value => $label ) {
            $bk_sidebar[$value] = ucwords( $label['name'] );
        }
        $bk_sidebar['global_settings']  = esc_html__( 'From Theme Options', 'ceris' );
        
        // Post SubTitle
        $meta_boxes[] = array(
            'id' => 'bk_post_subtitle_section',
            'title' => esc_html__( 'BK SubTitle', 'ceris' ),
            'pages' => array( 'post' ),
            'context' => 'normal',
            'priority' => 'high',
        	'fields' => array(        
                array(
                    'name' => esc_html__( 'SubTitle', 'ceris' ),
                    'desc' => esc_html__('Insert the SubTitle for this post', 'ceris'),
                    'id' => 'bk_post_subtitle',
                    'type' => 'textarea',
                    'placeholder' => esc_html__('SubTitle ...', 'ceris'),
                    'std' => ''
                ),
            )
        );
        
        // Page Descriptipon
        $meta_boxes[] = array(
            'id'        => 'bk_page_description_section',
            'title'     => esc_html__( 'Page Description', 'ceris' ),
            'pages'     => array( 'page' ),
            'context'   => 'normal',
            'priority'  => 'high',
            'hidden'   => array( 'template', 'in', array('page_builder.php')),
        	'fields'    => array( 
                array(
                    'name' => esc_html__( 'Page Description', 'ceris' ),
                    'id' => 'bk_page_description',
                    'type' => 'textarea',
                    'placeholder' => esc_html__('description ...', 'ceris'),
                    'std' => ''
                ),
            ),
        );  
        // Page Settings
        $meta_boxes[] = array(
            'id'        => 'bk_page_settings_section',
            'title'     => esc_html__( 'Page Settings', 'ceris' ),
            'pages'     => array( 'page' ),
            'context'   => 'normal',
            'priority'  => 'high',
            'hidden'   => array( 'template', 'in', array('blog.php', 'page_builder.php', 'authors-list.php')),
        	'fields'    => array(   
                array(
                    'name' => 'Page Heading',
                    'id'   => 'bk_page_header_style',
                    'type' => 'select',
                    'options'   => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
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
                    'std'       => 'global_settings',
                ), 
                // Featured Image Config
                array(
                    'name'      => esc_html__( 'Featured Image', 'ceris' ),
                    'id'        => 'bk_page_feat_img',
                    'type'      => 'button_group', 
        			'options'   => array(
                                    'global_settings' => esc_html__( 'From Theme Options', 'ceris' ),                
                                    1 => esc_html__( 'On', 'ceris' ),
                                    0 => esc_html__( 'Off', 'ceris' ),
            				    ),
        			// Select multiple values, optional. Default is false.
        			'multiple'    => false,
        			'std'         => 'global_settings',
                ),
                // Layout
                array(
                    'name' => esc_html__( 'Layout', 'ceris' ),
                    'id' => 'bk_page_layout',
                    'type' => 'select', 
        			'options'  => array(
                                    'global_settings' => esc_html__( 'From Theme Options', 'ceris' ),
                                    'has_sidebar' => esc_html__( 'Has Sidebar', 'ceris' ),
                                    'no_sidebar'  => esc_html__( 'Full Width -- No sidebar', 'ceris' ),
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
                ),
                
                // Sidebar
                array(
                    'name' => esc_html__( 'Choose a sidebar for this page', 'ceris' ),
                    'id' => 'bk_page_sidebar_select',
                    'type' => 'select',
                    'options'  => $bk_sidebar,
                    'std'  => 'global_settings',
                    'hidden' => array( 'bk_page_layout', 'in', array('no_sidebar')),
                ),
                array(
                    'name' => esc_html__( 'Sidebar Position -- Left/Right', 'ceris' ),
                    'id' => 'bk_page_sidebar_position',
                    'type' => 'image_select',
                    'options'   => array(
                            'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                            'right' => get_template_directory_uri().'/images/admin_panel/archive/sb-right.png',
                            'left'  => get_template_directory_uri().'/images/admin_panel/archive/sb-left.png',
                    ),
                    'std'  => 'global_settings',
                    'hidden' => array( 'bk_page_layout', 'in', array('no_sidebar')),
                ),
                array(
                    'name'      => esc_html__( 'Sticky Sidebar', 'ceris' ),
                    'id'        => 'bk_page_sidebar_sticky',
                    'type'      => 'button_group',
                    'options'   => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                                    1                   => esc_html__( 'Enable', 'ceris' ),
                					0                   => esc_html__( 'Disable', 'ceris' ),
                                ),
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Default Page Template','ceris'),
                    'std'       => 'global_settings',
                    'hidden' => array( 'bk_page_layout', 'in', array('no_sidebar')),
                ),
            )
        );
        // Post Layout Options
        $meta_boxes[] = array(
            'id' => 'bk_post_ops',
            'title' => esc_html__( 'BK Layout Options', 'ceris' ),
            'desc'   =>  esc_html__( 'From Theme Option: Theme Options -> Single Page', 'ceris' ),        
            'pages' => array( 'post' ),
            'context' => 'normal',
            'priority' => 'low',
        
            'fields' => array(
                array(
        			'id' => 'bk_post_layout_standard',
                    'class' => 'post-layout-options',
                    'name' => esc_html__( 'Post Layout Option', 'ceris' ),
                    'type' => 'image_select', 
        			'options'  => array(
                                    'global_settings' => get_template_directory_uri().'/images/admin_panel/default.png',
                                    'single-1' => get_template_directory_uri().'/images/admin_panel/single_page/single-1.png',
                                    'single-2' => get_template_directory_uri().'/images/admin_panel/single_page/single-2.png',
                                    'single-3' => get_template_directory_uri().'/images/admin_panel/single_page/single-3.png',
                                    'single-4' => get_template_directory_uri().'/images/admin_panel/single_page/single-4.png',
                                    'single-5' => get_template_directory_uri().'/images/admin_panel/single_page/single-5.png',
                                    'single-6' => get_template_directory_uri().'/images/admin_panel/single_page/single-6.png',
                                    'single-7' => get_template_directory_uri().'/images/admin_panel/single_page/single-7.png',
                                    'single-8' => get_template_directory_uri().'/images/admin_panel/single_page/single-8.png',
                                    'single-9' => get_template_directory_uri().'/images/admin_panel/single_page/single-9.png',
                                    'single-10' => get_template_directory_uri().'/images/admin_panel/single_page/single-10.png',
                                    'single-11' => get_template_directory_uri().'/images/admin_panel/single_page/single-11.png',
                                    'single-12' => get_template_directory_uri().'/images/admin_panel/single_page/single-12.png',
                                    'single-13' => get_template_directory_uri().'/images/admin_panel/single_page/single-13.png',
                                    'single-14' => get_template_directory_uri().'/images/admin_panel/single_page/single-14.png',
                                    'single-15' => get_template_directory_uri().'/images/admin_panel/single_page/single-15.png',
                                    'single-16' => get_template_directory_uri().'/images/admin_panel/single_page/single-16.png',
                                    'single-18' => get_template_directory_uri().'/images/admin_panel/single_page/single-18.png',
                                    'single-17' => get_template_directory_uri().'/images/admin_panel/single_page/single-17.png',
            				    ),
                    'std'         => 'global_settings',
                ),
                array(
                    'type' => 'divider',
                    'visible' => array(
                             array( 'bk_post_layout_standard', 'in', array('single-7', 'single-8', 'single-9', 'single-10')),
                        ),
                ),
                array(
                    'type' => 'divider',
                    'visible' => array(
                                 array( 'bk_post_layout_standard', 'in', array('single-1', 'single-2', 'single-3', 'single-4',
                                                                               'single-5', 'single-6', 'single-9', 'single-10')),
                            ),
                ),
                // Feature Image Config
                array(
                    'name' => esc_html__( 'Featured Image Config', 'ceris' ),
                    'id' => 'bk-feat-img-status',
                    'type'     => 'button_group',
        			'options'  => array(
                                    'global_settings' => esc_html__( 'From Theme Options', 'ceris' ),                
                                    1 => esc_html__( 'On', 'ceris' ),
                                    0 => esc_html__( 'Off', 'ceris' ),
            				    ),
        			'std'         => 'global_settings',
                    'visible' => array(
                                 array( 'bk_post_layout_standard', 'in', array('single-1', 'single-2', 'single-3', 'single-4',
                                                                               'single-5', 'single-6', 'single-9', 'single-10')),
                            ),
                ),
            )
        );
        $meta_boxes[] = array(
            'id' => 'bk_section_show_hide',
            'title' => esc_html__( 'BK Single Post Section Show/Hide', 'ceris' ),
            'pages' => array( 'post' ),
            'context' => 'normal',
            'priority' => 'low',
            'fields' => array(
                array(
        			'id' => 'bk-authorbox-sw',
                    'class' => 'bk-authorbox-sw',
                    'name' => esc_html__( 'Author Box', 'ceris' ),
                    'type'     => 'button_group',
        			'options'  => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                                    1                   => esc_html__( 'Show', 'ceris' ),
                					0                   => esc_html__( 'Hide', 'ceris' ),
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
                array(
        			'id' => 'bk-postnav-sw',
                    'class' => 'bk-postnav-sw',
                    'name' => esc_html__( 'Post Nav Section', 'ceris' ),
                    'type'     => 'button_group',
        			'options'  => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                                    1                   => esc_html__( 'Show', 'ceris' ),
                					0                   => esc_html__( 'Hide', 'ceris' ),
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
                array(
        			'id' => 'bk-related-sw',
                    'class' => 'bk-related-sw',
                    'name' => esc_html__( 'Related Section', 'ceris' ),
                    'type'     => 'button_group',
        			'options'  => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                                    1                   => esc_html__( 'Show', 'ceris' ),
                					0                   => esc_html__( 'Hide', 'ceris' ),
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
                array(
        			'id' => 'bk-same-cat-sw',
                    'class' => 'bk-same-cat-sw',
                    'name' => esc_html__( 'Same Category Section', 'ceris' ),
                    'type'     => 'button_group',
        			'options'  => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                                    1                   => esc_html__( 'Show', 'ceris' ),
                					0                   => esc_html__( 'Hide', 'ceris' ),
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
            ),
        );
        // Related Post Options
        $meta_boxes[] = array(
            'id' => 'bk_related_post_ops',
            'title' => esc_html__( 'BK Related Post Setting', 'ceris' ),
            'pages' => array( 'post' ),
            'context' => 'normal',
            'priority' => 'low',
            'hidden' => array(
                            'when' => array(
                                 array( 'bk_post_layout_standard', 'in', array('global_settings', 'single-3', 'single-6', 'single-8', 'single-10', 'single-13', 'single-16')),
                                 array( 'bk-related-sw', 0 )
                             ),
                             'relation' => 'or'
                        ),
            'fields' => array(
                array(
        			'id' => 'bk_related_heading_style',
                    'class' => 'related_heading_style',
                    'name' => esc_html__( 'Heading Style', 'ceris' ),
                    'type' => 'select', 
        			'options'  => array(
                                    'global_settings'    => esc_html__( 'From Theme Options', 'ceris' ),
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
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
                array(
        			'id' => 'bk_related_source',
                    'class' => 'related_post_options',
                    'name' => esc_html__( 'Related Posts', 'ceris' ),
                    'type' => 'select', 
        			'options'  => array(
                                    'global_settings' => esc_html__( 'From Theme Options', 'ceris' ),
                                    'category_tag' => esc_html__( 'Same Categories and Tags', 'ceris' ),
                					'tag'          => esc_html__( 'Same Tags', 'ceris' ),
                                    'category'     => esc_html__( 'Same Categories', 'ceris' ),
                                    'author'       => esc_html__( 'Same Author', 'ceris' ),
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
                array(
        			'id' => 'bk_number_related',
                    'class' => 'related_post_options',
                    'name' => esc_html__( 'Number of Related Posts', 'ceris' ),
                    'type' => 'select', 
        			'options'  => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                                    '1'                 => esc_html__( '1', 'ceris' ),
                					'2'                 => esc_html__( '2', 'ceris' ),
                                    '3'                 => esc_html__( '3', 'ceris' ),
                                    '4'                 => esc_html__( '4', 'ceris' ),
                                    '5'                 => esc_html__( '5', 'ceris' ),
                					'6'                 => esc_html__( '6', 'ceris' ),
                                    '7'                 => esc_html__( '7', 'ceris' ),
                                    '8'                 => esc_html__( '8', 'ceris' ),
                                    '9'                 => esc_html__( '9', 'ceris' ),
                					'10'                => esc_html__( '10', 'ceris' ),
                                    '11'                => esc_html__( '11', 'ceris' ),
                                    '12'                => esc_html__( '12', 'ceris' ),
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
                array(
        			'id' => 'bk_related_post_layout',
                    'class' => 'related_post_layout',
                    'name' => esc_html__( 'Layout', 'ceris' ),
                    'type' => 'image_select', 
        			'options'  => array(
                                    'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                                    'listing_list'       => get_template_directory_uri().'/images/admin_panel/related-module/ceris_14.png',
                                    'listing_list_b'       => get_template_directory_uri().'/images/admin_panel/related-module/ceris_15.png',
                                    'listing_list_large_a'       => get_template_directory_uri().'/images/admin_panel/related-module/ceris_16.png',
                                    'listing_list_large_b'       => get_template_directory_uri().'/images/admin_panel/related-module/ceris_17.png',
                                    'listing_grid'       => get_template_directory_uri().'/images/admin_panel/related-module/ceris_18.png',
                                    'listing_grid_b'       => get_template_directory_uri().'/images/admin_panel/related-module/ceris_19.png',
                                    'listing_grid_small' => get_template_directory_uri().'/images/admin_panel/related-module/listing_grid_small.png',
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
                array(
        			'id' => 'bk_related_post_icon',
                    'class' => 'related_post_icon',
                    'name' => esc_html__( 'Post Icon', 'ceris' ),
                    'type' => 'button_group', 
        			'options'  => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                					'disable'           => esc_html__( 'Disable', 'ceris' ),
    		                        'enable'            => esc_html__( 'Enable', 'ceris' ),
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
                array(
        			'id' => 'bk_related_post_icon_animation',
                    'class' => 'related_post_icon_animation',
                    'name' => esc_html__( 'Post Icon Animation', 'ceris' ),
                    'type' => 'button_group', 
        			'options'  => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                					'disable'           => esc_html__( 'Disable', 'ceris' ),
    		                        'enable'            => esc_html__( 'Enable', 'ceris' ),
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
            )
        );
        // Related Post Options
        $meta_boxes[] = array(
            'id' => 'bk_related_post_ops_wide',
            'title' => esc_html__( 'BK Related Post Section - Wide Setting', 'ceris' ),
            'pages' => array( 'post' ),
            'context' => 'normal',
            'priority' => 'low',
            'visible' => array(
                             array( 'bk_post_layout_standard', 'in', array('single-3', 'single-6', 'single-8', 'single-10', 'single-13', 'single-16')),
                             array( 'bk-related-sw', '!=', 0 )
                        ),
            'fields' => array(
                array(
        			'id' => 'bk_related_heading_style_wide',
                    'class' => 'related_heading_style',
                    'name' => esc_html__( 'Heading Style', 'ceris' ),
                    'type' => 'select', 
        			'options'  => array(
                                    'global_settings'    => esc_html__( 'From Theme Options', 'ceris' ),
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
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
                array(
        			'id' => 'bk_related_source_wide',
                    'class' => 'related_post_options',
                    'name' => esc_html__( 'Related Posts', 'ceris' ),
                    'type' => 'select', 
        			'options'  => array(
                                    'global_settings' => esc_html__( 'From Theme Options', 'ceris' ),
                                    'category_tag' => esc_html__( 'Same Categories and Tags', 'ceris' ),
                					'tag'          => esc_html__( 'Same Tags', 'ceris' ),
                                    'category'     => esc_html__( 'Same Categories', 'ceris' ),
                                    'author'       => esc_html__( 'Same Author', 'ceris' ),
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
                array(
        			'id' => 'bk_related_post_layout_wide',
                    'class' => 'related_post_layout',
                    'name' => esc_html__( 'Layout', 'ceris' ),
                    'type' => 'image_select', 
        			'options'  => array(
                                    'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                                    'listing_list_no_sidebar'         => get_template_directory_uri().'/images/admin_panel/archive/ceris_20.png',
                                    'listing_list_b_no_sidebar'       => get_template_directory_uri().'/images/admin_panel/archive/ceris_21.png',
                                    'listing_list_large_a_no_sidebar' => get_template_directory_uri().'/images/admin_panel/archive/ceris_22.png',
                                    'listing_list_large_b_no_sidebar' => get_template_directory_uri().'/images/admin_panel/archive/ceris_23.png',
                                    'listing_grid_no_sidebar'         => get_template_directory_uri().'/images/admin_panel/archive/ceris_24.png',
                                    'listing_grid_b_no_sidebar'       => get_template_directory_uri().'/images/admin_panel/archive/ceris_25.png',
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
                array(
        			'id' => 'bk_related_post_icon_wide',
                    'class' => 'related_post_icon',
                    'name' => esc_html__( 'Post Icon', 'ceris' ),
                    'type' => 'button_group', 
        			'options'  => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                					'disable'           => esc_html__( 'Disable', 'ceris' ),
    		                        'enable'            => esc_html__( 'Enable', 'ceris' ),
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
                array(
        			'id' => 'bk_related_post_icon_animation_wide',
                    'class' => 'related_post_icon_animation',
                    'name' => esc_html__( 'Post Icon Animation', 'ceris' ),
                    'type' => 'button_group', 
        			'options'  => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                					'disable'           => esc_html__( 'Disable', 'ceris' ),
    		                        'enable'            => esc_html__( 'Enable', 'ceris' ),
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
            )
        );  
        // Same Category Posts Options
        $allCategories = get_categories();
        $catArray = array();
        $catArray['current_cat'] = esc_html__('Current Category', 'ceris');
        foreach ( $allCategories as $key => $category ) {
            $catArray[$category->term_id] = $category->name;
        }
        $meta_boxes[] = array(
            'id' => 'bk_same_cat_post_ops',
            'title' => esc_html__( 'BK Same Category Posts Setting', 'ceris' ),
            'pages' => array( 'post' ),
            'context' => 'normal',
            'priority' => 'low',
            'hidden' => array(
                            'when' => array(
                                 array( 'bk_post_layout_standard', 'in', array('global_settings', 'single-3', 'single-6', 'single-8', 'single-10', 'single-13', 'single-16')),
                                 array( 'bk-same-cat-sw', 0 )
                             ),
                             'relation' => 'or'
                        ),
            'fields' => array(
                array(
        			'id'         => 'bk_same_cat_id',
                    'class'      => 'same_cat_id',
                    'name'       => esc_html__( 'Category: ', 'ceris' ),
                    'type'       => 'select', 
        			'options'    => $catArray,
        			'multiple'   => false,
        			'std'        => 'current_cat',
        		),
                array(
        			'id' => 'bk_same_cat_heading_style',
                    'class' => 'same_cat_heading_style',
                    'name' => esc_html__( 'Heading Style', 'ceris' ),
                    'type' => 'select', 
        			'options'  => array(
                                    'global_settings'    => esc_html__( 'From Theme Options', 'ceris' ),
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
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
                array(
        			'id' => 'bk_same_cat_post_layout',
                    'class' => 'same_cat_post_layout',
                    'name' => esc_html__( 'Layout', 'ceris' ),
                    'type' => 'image_select', 
        			'options'  => array(
                                    'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                                    'listing_list'       => get_template_directory_uri().'/images/admin_panel/related-module/ceris_14.png',
                                    'listing_list_b'       => get_template_directory_uri().'/images/admin_panel/related-module/ceris_15.png',
                                    'listing_list_large_a'       => get_template_directory_uri().'/images/admin_panel/related-module/ceris_16.png',
                                    'listing_list_large_b'       => get_template_directory_uri().'/images/admin_panel/related-module/ceris_17.png',
                                    'listing_grid'       => get_template_directory_uri().'/images/admin_panel/related-module/ceris_18.png',
                                    'listing_grid_b'       => get_template_directory_uri().'/images/admin_panel/related-module/ceris_19.png',
                                    'listing_grid_small' => get_template_directory_uri().'/images/admin_panel/related-module/listing_grid_small.png',
                                    
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
                array(
        			'id' => 'bk_same_cat_number_posts',
                    'class' => 'same_cat_number_posts',
                    'name' => esc_html__( 'Number of Posts', 'ceris' ),
                    'type' => 'select', 
        			'options'  => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                                    '1'                 => esc_html__( '1', 'ceris' ),
                					'2'                 => esc_html__( '2', 'ceris' ),
                                    '3'                 => esc_html__( '3', 'ceris' ),
                                    '4'                 => esc_html__( '4', 'ceris' ),
                                    '5'                 => esc_html__( '5', 'ceris' ),
                					'6'                 => esc_html__( '6', 'ceris' ),
                                    '7'                 => esc_html__( '7', 'ceris' ),
                                    '8'                 => esc_html__( '8', 'ceris' ),
                                    '9'                 => esc_html__( '9', 'ceris' ),
                					'10'                => esc_html__( '10', 'ceris' ),
                                    '11'                => esc_html__( '11', 'ceris' ),
                                    '12'                => esc_html__( '12', 'ceris' ),
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
                array(
        			'id' => 'bk_same_cat_post_icon',
                    'class' => 'same_cat_post_icon',
                    'name' => esc_html__( 'Post Icon', 'ceris' ),
                    'type' => 'button_group', 
        			'options'  => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                					'disable'           => esc_html__( 'Disable', 'ceris' ),
    		                        'enable'            => esc_html__( 'Enable', 'ceris' ),
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
                array(
        			'id' => 'bk_same_cat_post_icon_animation',
                    'class' => 'same_cat_post_icon_animation',
                    'name' => esc_html__( 'Post Icon Animation', 'ceris' ),
                    'type' => 'button_group', 
        			'options'  => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                					'disable'           => esc_html__( 'Disable', 'ceris' ),
    		                        'enable'            => esc_html__( 'Enable', 'ceris' ),
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
                array(
        			'id' => 'bk_same_cat_more_link',
                    'class' => 'same_cat_more_link',
                    'name' => esc_html__( 'More Link', 'ceris' ),
                    'type'     => 'button_group',
        			'options'  => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                                    1                   => esc_html__( 'Enable', 'ceris' ),
                					0                   => esc_html__( 'Disable', 'ceris' ),
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
            )
        );
        
        // Related Post Options
        $meta_boxes[] = array(
            'id' => 'bk_same_cat_post_ops_wide',
            'title' => esc_html__( 'BK Same Category Post Section - Wide Setting', 'ceris' ),
            'pages' => array( 'post' ),
            'context' => 'normal',
            'priority' => 'low',
            'visible' => array(
                             array( 'bk_post_layout_standard', 'in', array('single-3', 'single-6', 'single-8', 'single-10', 'single-13', 'single-16')),
                             array( 'bk-same-cat-sw', '!=', 0 )
                        ),
            'fields' => array(
                array(
        			'id'         => 'bk_same_cat_id_wide',
                    'class'      => 'same_cat_id_wide',
                    'name'       => esc_html__( 'Category: ', 'ceris' ),
                    'type'       => 'select', 
        			'options'    => $catArray,
        			'multiple'   => false,
        			'std'        => 'disable',
        		),
                array(
        			'id' => 'bk_same_cat_heading_style_wide',
                    'class' => 'same_cat_heading_style',
                    'name' => esc_html__( 'Heading Style', 'ceris' ),
                    'type' => 'select', 
        			'options'  => array(
                                    'global_settings'    => esc_html__( 'From Theme Options', 'ceris' ),
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
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
                array(
        			'id' => 'bk_same_cat_post_layout_wide',
                    'class' => 'same_cat_post_layout_wide',
                    'name' => esc_html__( 'Layout', 'ceris' ),
                    'type' => 'image_select', 
        			'options'  => array(
                                    'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                                    'listing_list_no_sidebar'         => get_template_directory_uri().'/images/admin_panel/archive/ceris_20.png',
                                    'listing_list_b_no_sidebar'       => get_template_directory_uri().'/images/admin_panel/archive/ceris_21.png',
                                    'listing_list_large_a_no_sidebar' => get_template_directory_uri().'/images/admin_panel/archive/ceris_22.png',
                                    'listing_list_large_b_no_sidebar' => get_template_directory_uri().'/images/admin_panel/archive/ceris_23.png',
                                    'listing_grid_no_sidebar'         => get_template_directory_uri().'/images/admin_panel/archive/ceris_24.png',
                                    'listing_grid_b_no_sidebar'       => get_template_directory_uri().'/images/admin_panel/archive/ceris_25.png',
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
                array(
        			'id' => 'bk_same_cat_post_icon_wide',
                    'class' => 'same_cat_post_icon_wide',
                    'name' => esc_html__( 'Post Icon', 'ceris' ),
                    'type' => 'button_group', 
        			'options'  => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                					'disable'           => esc_html__( 'Disable', 'ceris' ),
    		                        'enable'            => esc_html__( 'Enable', 'ceris' ),
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
                array(
        			'id' => 'bk_same_cat_post_icon_animation_wide',
                    'class' => 'same_cat_post_icon_animation_wide',
                    'name' => esc_html__( 'Post Icon Animation', 'ceris' ),
                    'type' => 'button_group', 
        			'options'  => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                					'disable'           => esc_html__( 'Disable', 'ceris' ),
    		                        'enable'            => esc_html__( 'Enable', 'ceris' ),
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
                array(
        			'id' => 'bk_same_cat_more_link_wide',
                    'class' => 'same_cat_more_link_wide',
                    'name' => esc_html__( 'More Link', 'ceris' ),
                    'type'     => 'button_group',
        			'options'  => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                                    1                   => esc_html__( 'Enable', 'ceris' ),
                					0                   => esc_html__( 'Disable', 'ceris' ),
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
            )
        );  
        $meta_boxes[] = array(
            'id' => 'bk_single_post_sidebar',
            'title' => esc_html__( 'Sidebar Option', 'ceris' ),
            'pages' => array( 'post' ),
            'context' => 'normal',
            'priority' => 'low',
        
            'fields' => array(
                // Sidebar Select
                array(
                    'name' => esc_html__( 'Choose a sidebar for this post', 'ceris' ),
                    'id' => 'bk_post_sb_select',
                    'type' => 'select',
                    'options'  => $bk_sidebar,
                    'desc' => esc_html__( 'Sidebar Select', 'ceris' ),
                    'std'  => 'global_settings',
                ),
                array(
        			'id' => 'bk_post_sb_position',
                    'class' => 'post_sb_position',
                    'name' => esc_html__( 'Sidebar Position', 'ceris' ),
                    'type' => 'image_select', 
        			'options'  => array(
                                    'global_settings'   => get_template_directory_uri().'/images/admin_panel/default.png',
                                    'right'             => get_template_directory_uri().'/images/admin_panel/single_page/sb-right.png',
                					'left'              => get_template_directory_uri().'/images/admin_panel/single_page/sb-left.png',
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
                array(
        			'id' => 'bk_post_sb_sticky',
                    'class' => 'post_sb_sticky',
                    'name' => esc_html__( 'Sidebar Sticky', 'ceris' ),
                    'type'     => 'button_group',
        			'options'  => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                                    1                   => esc_html__( 'Enable', 'ceris' ),
                					0                   => esc_html__( 'Disable', 'ceris' ),
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
        		),
            )
        );
        
        $meta_boxes[] = array(
            'id' => 'bk_video_post_format',
            'title' => esc_html__( 'BK Video Post Format', 'ceris' ),
            'pages' => array( 'post' ),
            'context' => 'normal',
            'priority' => 'high',
            'visible' => array( 'post_format', 'in', array('video')),
        	'fields' => array(        
                //Video
                array(
                    'name' => esc_html__( 'Format Options: Video', 'ceris' ),
                    'desc' => esc_html__('Support Youtube, Vimeo Link', 'ceris'),
                    'id' => 'bk_video_media_link',
                    'type'  => 'oembed',
                    'placeholder' => esc_html__('Link ...', 'ceris'),
                    'std' => ''
                ),
            )
        );
        $meta_boxes[] = array(
            'id' => 'bk_gallery_post_format',
            'title' => esc_html__( 'BK Gallery Post Format', 'ceris' ),
            'pages' => array( 'post' ),
            'context' => 'normal',
            'priority' => 'high',
            'visible' => array( 'post_format', 'in', array('gallery')),
        	'fields' => array(  
                //Gallery
                array(
                    'name' => esc_html__( 'Format Options: Gallery', 'ceris' ),
                    'desc' => esc_html__('Gallery Images', 'ceris'),
                    'id' => 'bk_gallery_content',
                    'type' => 'image_advanced',
                    'std' => ''
                ),
                array(
        			'id' => 'bk_gallery_type',
                    'name' => esc_html__( 'Gallery Type', 'ceris' ),
                    'type' => 'select', 
        			'options'  => array(
                					'gallery-1' => esc_html__( 'Gallery 1', 'ceris' ),
                					'gallery-2' => esc_html__( 'Gallery 2 ', 'ceris' ),
                                    'gallery-3' => esc_html__( 'Gallery 3', 'ceris' ),
            				    ),
        			// Select multiple values, optional. Default is false.
        			'multiple'    => false,
        			'std'         => 'left',
        		),
            )
        );
        // Post Review Options
        $meta_boxes[] = array(
            'id' => 'bk_review',
            'title' => esc_html__( 'BK Review System', 'ceris' ),
            'pages' => array( 'post' ),
            'context' => 'normal',
            'priority' => 'high',
        
            'fields' => array(
                array(
                    'type' => 'heading',
                    'name' => esc_html__('Author Review', 'ceris'),
                    'desc' => esc_html__('This section allow you to give your review, pros, cons', 'ceris'),
                ),
                
                // Enable Review
                array(
                    'name' => esc_html__( 'Review Box', 'ceris' ),
                    'id' => 'bk_review_checkbox',
                    'type' => 'checkbox',
                    'desc' => esc_html__( 'Enable Review On This Post', 'ceris' ),
                    'std'  => 0,
                ),
                array(
                    'visible' => array( 'bk_review_checkbox', '=', 1),
                    'type' => 'divider',
                ),
                array(
        			'id' => 'bk_review_box_position',
                    'name' => esc_html__( 'Review Box Position', 'ceris' ),
                    'type' => 'select', 
        			'options'  => array(
                					'default'      => esc_html__( 'Default -- Under the post content', 'ceris' ),
                					'top'          => esc_html__( 'On top of the post content ', 'ceris' ),
            				    ),
        			// Select multiple values, optional. Default is false.
        			'multiple'    => false,
        			'std'         => 'default',
                    'visible'     => array( 'bk_review_checkbox', '=', 1),
        		),
                array(
                    'visible' => array( 'bk_review_checkbox', '=', 1),
                    'type' => 'divider',
                ),
                array(
                    'name' => 'Product Image',
                    'id'   => 'bk_review_product_img',
                    'type' => 'single_image',
                    'visible'     => array( 'bk_review_checkbox', '=', 1),
                ),  
                array(
                    'name' => esc_html__( 'Product name', 'ceris' ),
                    'id'   => 'bk_review_box_title',
                    'type' => 'textarea',
                    'cols' => 20,
                    'rows' => 2,
                    'visible' => array( 'bk_review_checkbox', '=', 1),
                ),
                array(
                    'name' => esc_html__( 'Description', 'ceris' ),
                    'id'   => 'bk_review_box_sub_title',
                    'type' => 'textarea',
                    'cols' => 20,
                    'rows' => 2,
                    'visible' => array( 'bk_review_checkbox', '=', 1),
                ),
                array(
                    'visible' => array( 'bk_review_checkbox', '=', 1),
                    'type' => 'divider',
                ),
                //Review Score
                array(
                    'name' => esc_html__( 'Review Score', 'ceris' ),
                    'id' => 'bk_review_score',
                    'class' => 'ceris-',
                    'type' => 'slider',
                    'visible' => array( 'bk_review_checkbox', '=', 1),
                    'js_options' => array(
                        'min'   => 0,
                        'max'   => 10.05,
                        'step'  => .1,
                    ),
                ),
                array(
                    'visible' => array( 'bk_review_checkbox', '=', 1),
                    'type' => 'divider',
                ),
                // Summary
                array(
                    'name' => esc_html__( 'Summary', 'ceris' ),
                    'id'   => 'bk_review_summary',
                    'type' => 'textarea',
                    'cols' => 20,
                    'rows' => 4,
                    'visible' => array( 'bk_review_checkbox', '=', 1),
                ),
                
                array(
                    'visible' => array( 'bk_review_checkbox', '=', 1),
                    'type' => 'divider',
                ),
                
                //Pros & Cons
                array(
                    'name' => esc_html__( 'Pros and Cons', 'ceris' ),
                    'id' => 'bk_pros_cons',
                    'type' => 'checkbox',
                    'desc' => esc_html__( 'Enable Pros and Cons On This Post', 'ceris' ),
                    'std'  => 0,
                    'visible' => array( 'bk_review_checkbox', '=', 1),
                ),
                array(
                    'visible' => array( 'bk_pros_cons', '=', 1),
                    'type' => 'divider',
                ),
                array(
                    'name' => esc_html__( 'Pros Title', 'ceris' ),
                    'id'   => 'bk_review_pros_title',
                    'type' => 'textarea',
                    'cols' => 20,
                    'rows' => 2,
                    'visible' => array( 'bk_pros_cons', '=', 1),
                ),
                array(
                    'name' => esc_html__( 'Pros (Advantages)', 'ceris' ),
                    'id'   => 'bk_review_pros',
                    'type' => 'textarea',
                    'cols' => 20,
                    'clone' => true,
                    'rows' => 2,
                    'visible' => array( 'bk_pros_cons', '=', 1),
                ),
                array(
                    'visible' => array( 'bk_pros_cons', '=', 1),
                    'type' => 'divider',
                ),
                array(
                    'name' => esc_html__( 'Cons Title', 'ceris' ),
                    'id'   => 'bk_review_cons_title',
                    'type' => 'textarea',
                    'cols' => 20,
                    'rows' => 2,
                    'visible' => array( 'bk_pros_cons', '=', 1),
                ),
                array(
                    'name' => esc_html__( 'Cons (Disadvantages)', 'ceris' ),
                    'id'   => 'bk_review_cons',
                    'type' => 'textarea',
                    'cols' => 20,
                    'clone' => true,
                    'rows' => 2,
                    'visible' => array( 'bk_pros_cons', '=', 1),
                ),
                
                array(
                    'type' => 'divider',
                ),
                array(
                    'type' => 'heading',
                    'name' => esc_html__('Performance and User Review', 'ceris'),
                    'desc' => esc_html__('This section allow you to have some criterias and allow your reader to share their review', 'ceris'),
                ),
                
                array(
                    'name' => esc_html__( 'Performance and User Review Check Box', 'ceris' ),
                    'id' => 'bk_performance_review_checkbox',
                    'type' => 'checkbox',
                    'desc' => esc_html__( 'Enable This Review', 'ceris' ),
                    'std'  => 0,
                ),
                array(
                    'visible' => array( 'bk_performance_review_checkbox', '=', 1),
                    'type' => 'divider',
                ),
                array(
                    'id'     => 'bk_performance_review_score_criteria_group',
                    // Group field
                    'type'   => 'group',
                    // Clone whole group?
                    'clone'  => true,
                    'visible' => array( 'bk_performance_review_checkbox', '=', 1),
                    // Sub-fields
                    'fields' => array(
                        array(
                            'name' => esc_html__( 'Criteria Title', 'ceris' ),
                            'id'   => 'review_criteria_title',
                            'type' => 'text',
                        ),
                        array(
                            'name' => esc_html__( 'Criteria Score', 'ceris' ),
                            'id' => 'review_criteria_score',
                            'class' => 'ceris-',
                            'type' => 'slider',
                            'js_options' => array(
                                'min'   => 0,
                                'max'   => 10.05,
                                'step'  => .1,
                            ),
                        ),
                    ),
                ),
                
                array(
                    'type' => 'divider',
                ),
                array(
                    'name' => esc_html__( 'Reader Review Form', 'ceris' ),
                    'id' => 'bk_reader_review_checkbox',
                    'visible' => array( 'bk_performance_review_checkbox', '=', 1),
                    'type' => 'checkbox',
                    'desc' => esc_html__( 'Enable Reader Review', 'ceris' ),
                    'std'  => 0,
                ),
            )
        );
        if ( function_exists( 'mb_term_meta_load' ) ) {
            $meta_boxes[] = array(
                'title'      => 'Advance Category Options',
                'taxonomies' => array('category'), // List of taxonomies. Array or string
        
                'fields' => array(
                    array(
            			'id' => 'bk_category_feature_area',
                        'class' => 'bk_archive_feature_area',
                        'name' => esc_html__( 'Feature Area', 'ceris' ),
                        'type' => 'image_select', 
            			'options'  => array(
                                        'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                                        'disable'            => get_template_directory_uri().'/images/admin_panel/disable.png',
                                        'grid_o'           => get_template_directory_uri().'/images/admin_panel/archive/mosaic_a.png',
                                        'grid_p'           => get_template_directory_uri().'/images/admin_panel/archive/mosaic_b.png',
                                        'grid_q'           => get_template_directory_uri().'/images/admin_panel/archive/posts_block_e.png',
                                        'grid_r'           => get_template_directory_uri().'/images/admin_panel/archive/mosaic_c.png',
                				    ),
            			'multiple'    => false,
            			'std'         => 'global_settings',
                        'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Archive','ceris'),
            		),
                    array(
                        'name' => 'Feature Area Post Option',
                        'id'   => 'bk_category_feature_area__post_option',
                        'type' => 'select',
                        'options'   => array(
                                        'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                                        'featured'          => esc_html__( 'Show Featured Posts', 'ceris' ),
            			                'latest'            => esc_html__( 'Show Latest Posts', 'ceris' ),
                                    ),
                        'std'       => 'global_settings',
                        'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','ceris'),
                    ), 
                    array(
                        'name' => 'Show Feature Area only on 1st page',
                        'id'   => 'bk_feature_area__show_hide',
                        'type' => 'button_group',
                        'options'   => array(
                                        'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                                        1                   => esc_html__( 'Yes', 'ceris' ),
            			                0                   => esc_html__( 'No', 'ceris' ),
                                    ),
                        'std'       => 'global_settings',
                        'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','ceris'),
                    ),
                    array(
                        'name' => 'Page Heading',
                        'id'   => 'bk_category_header_style',
                        'type' => 'select',
                        'options'   => array(
                                        'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
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
                        'std'       => 'global_settings',
                        'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','ceris'),
                    ), 
                    array(
        				'name'    => esc_html__('Content Layouts','ceris'),
        				'id'      => 'bk_category_content_layout',
        				'type' => 'image_select', 
            			'options'  => array(
                                        'global_settings'          => get_template_directory_uri().'/images/admin_panel/default.png',
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
                        'std' => 'global_settings',
                        'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','ceris'),
        			),
                    array(
                        'name' => 'Pagination',
                        'id'   => 'bk_category_pagination',
                        'type' => 'select',
                        'options'   => array(
                                        'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                                        'default'           => esc_html__( 'Default Pagination', 'ceris' ),
            			                'ajax-pagination'   => esc_html__( 'Ajax Pagination', 'ceris' ),
                                        'ajax-loadmore'     => esc_html__( 'Ajax Load More', 'ceris' ),
                                        'infinity'          => esc_html__( 'Ajax Infinity Scrolling', 'ceris' ),
                                    ),
                        'std'       => 'global_settings',
                        'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','ceris'),
                    ), 
                    array(
                        'name' => '[Content Section] Exclude Posts',
                        'id'   => 'bk_category_exclude_posts',
                        'type'     => 'button_group',
                        'hidden'    => array( 'bk_category_feature_area', 'in', array('disable')),
                        'options'   => array(
                                        'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                                        1                   => esc_html__( 'Enable', 'ceris' ),
                                        0                   => esc_html__( 'Disable', 'ceris' ),
                                    ),
                        'std'       => 'global_settings',
                        'desc' => esc_html__('Content Section: Exclude Featured Posts that are shown on the Feature Area','ceris')
                    ),
                    array(
                        'name' => esc_html__( 'Choose a sidebar for this page', 'ceris' ),
                        'id' => 'bk_category_sidebar_select',
                        'type' => 'select',
                        'options'  => $bk_sidebar,
                        'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','ceris'),
                        'std'  => 'global_settings',
                        'visible' => array( 'bk_category_content_layout', 'in', array('listing_list', 'listing_list_alt_a',
                                                                                     'listing_list_alt_b', 'listing_list_alt_b',
                                                                                     'listing_list_alt_c', 'listing_grid',
                                                                                     'listing_grid_alt_b',
                                                                                     'listing_grid_small', 'global_settings')),
                    ),
                    array(
                        'name' => esc_html__( 'Sidebar Position -- Left/Right', 'ceris' ),
                        'id' => 'bk_category_sidebar_position',
                        'type' => 'image_select',
                        'options'   => array(
                                'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                                'right' => get_template_directory_uri().'/images/admin_panel/archive/sb-right.png',
                                'left'  => get_template_directory_uri().'/images/admin_panel/archive/sb-left.png',
                        ),
                        'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','ceris'),
                        'std'  => 'global_settings',
                        'visible' => array( 'bk_category_content_layout', 'in', array('listing_list', 'listing_list_alt_a',
                                                                                     'listing_list_alt_b', 'listing_list_alt_b',
                                                                                     'listing_list_alt_c', 'listing_grid',
                                                                                     'listing_grid_alt_b',
                                                                                     'listing_grid_small', 'global_settings')),
                    ),
                    array(
                        'name'      => esc_html__( 'Sticky Sidebar', 'ceris' ),
                        'id'        => 'bk_category_sidebar_sticky',
                        'type'      => 'button_group',
                        'options'   => array(
                                        'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                                        1                   => esc_html__( 'Enable', 'ceris' ),
                    					0                   => esc_html__( 'Disable', 'ceris' ),
                                    ),
                        'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','ceris'),
                        'std'       => 'global_settings',
                        'visible' => array( 'bk_category_content_layout', 'in', array('listing_list', 'listing_list_alt_a',
                                                                                     'listing_list_alt_b', 'listing_list_alt_b',
                                                                                     'listing_list_alt_c', 'listing_grid', 
                                                                                     'listing_grid_alt_b',
                                                                                     'listing_grid_small', 'global_settings')),
                    ),
                    array(
                        'name' => 'Category Color',
                        'id'   => 'bk_category__color',
                        'type' => 'color',
                    ),   
                    array(
                        'name' => 'Featured Image',
                        'id'   => 'bk_category_feat_img',
                        'type' => 'single_image',
                    ),  
                ),
            );
            $meta_boxes[] = array(
                'title'      => ' ',
                'taxonomies' => array('post_tag'), // List of taxonomies. Array or string
        
                'fields' => array(
                    array(
                        'name' => 'Page Heading',
                        'id'   => 'bk_archive_header_style',
                        'type' => 'select',
                        'options'   => array(
                                        'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
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
                        'std'       => 'global_settings',
                        'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Archive','ceris'),
                    ), 
                    array(
        				'name'    => esc_html__('Content Layouts','ceris'),
        				'id'      => 'bk_archive_content_layout',
        				'type' => 'image_select', 
            			'options'  => array(
                                        'global_settings'          => get_template_directory_uri().'/images/admin_panel/default.png',
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
                        'std' => 'global_settings',
                        'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Archive','ceris'),
        			),
                    array(
                        'name' => 'Pagination',
                        'id'   => 'bk_archive_pagination',
                        'type' => 'select',
                        'options'   => array(
                                        'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                                        'default'           => esc_html__( 'Default Pagination', 'ceris' ),
            			                'ajax-pagination'   => esc_html__( 'Ajax Pagination', 'ceris' ),
                                        'ajax-loadmore'     => esc_html__( 'Ajax Load More', 'ceris' ),
                                        'infinity'          => esc_html__( 'Ajax Infinity Scrolling', 'ceris' ),
                                    ),
                        'std'       => 'global_settings',
                        'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','ceris'),
                    ), 
                    array(
                        'name' => esc_html__( 'Choose a sidebar for this page', 'ceris' ),
                        'id' => 'bk_archive_sidebar_select',
                        'type' => 'select',
                        'options'  => $bk_sidebar,
                        'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Archive','ceris'),
                        'std'  => 'global_settings',
                        'visible' => array( 'bk_archive_content_layout', 'in', array('listing_list', 'listing_list_alt_a',
                                                                                     'listing_list_alt_b', 'listing_list_alt_b',
                                                                                     'listing_list_alt_c', 'listing_grid', 
                                                                                     'listing_grid_alt_b',
                                                                                     'listing_grid_small', 'global_settings')),
                    ),
                    array(
                        'name' => esc_html__( 'Sidebar Position -- Left/Right', 'ceris' ),
                        'id' => 'bk_archive_sidebar_position',
                        'type' => 'image_select',
                        'options'   => array(
                                'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                                'right' => get_template_directory_uri().'/images/admin_panel/archive/sb-right.png',
                                'left'  => get_template_directory_uri().'/images/admin_panel/archive/sb-left.png',
                        ),
                        'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Archive','ceris'),
                        'std'  => 'global_settings',
                        'visible' => array( 'bk_archive_content_layout', 'in', array('listing_list', 'listing_list_alt_a',
                                                                                     'listing_list_alt_b', 'listing_list_alt_b',
                                                                                     'listing_list_alt_c', 'listing_grid', 
                                                                                     'listing_grid_alt_b',
                                                                                     'listing_grid_small', 'global_settings')),
                    ),
                    array(
                        'name'      => esc_html__( 'Sticky Sidebar', 'ceris' ),
                        'id'        => 'bk_archive_sidebar_sticky',
                        'type'      => 'button_group',
                        'options'   => array(
                                        'global_settings'   => esc_html__( 'From Theme Options', 'ceris' ),
                                        1                   => esc_html__( 'Enable', 'ceris' ),
                    					0                   => esc_html__( 'Disable', 'ceris' ),
                                    ),
                        'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Archive','ceris'),
                        'std'       => 'global_settings',
                        'visible' => array( 'bk_archive_content_layout', 'in', array('listing_list', 'listing_list_alt_a',
                                                                                     'listing_list_alt_b', 'listing_list_alt_b',
                                                                                     'listing_list_alt_c', 'listing_grid', 
                                                                                     'listing_grid_alt_b',
                                                                                     'listing_grid_small', 'global_settings')),
                    ),
                    array(
                        'name' => 'Featured Image',
                        'id'   => 'bk_archive_feat_img',
                        'type' => 'single_image',
                    ),  
                ),
            );
        }
        return $meta_boxes;
    }
}