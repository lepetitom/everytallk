<?php
add_action('wp_ajax_nopriv_bk_demo_import_start', 'bk_demo_import_start');
add_action('wp_ajax_bk_demo_import_start', 'bk_demo_import_start');
if (!function_exists('bk_demo_import_start')) {
    function bk_demo_import_start()
    {        
        //delete_option( 'bk_import_process_data');
        wp_delete_post( 1, true ); //Delete hello world
        
        if ( function_exists( 'wordpress_importer_init' ) ) {
            deactivate_plugins( ABSPATH . 'wp-content/plugins/wordpress-importer/wordpress-importer.php' );
        }
        
        $import_source  = isset( $_POST['import_source'] ) ? $_POST['import_source'] : null; 
        $demoType  = isset( $_POST['demoType'] ) ? $_POST['demoType'] : null; 
        
        $count = 1;
        
        for($count = 1; $count < BK_DEMO_COUNT; $count ++) {
            update_option('bk_demo_'.$count.'_status', false );
        }
        update_option('bk_'.$demoType.'_status', '' );
        
        if($import_source == null)
            wp_die();
        if ( ! current_user_can( 'manage_options' ) )
    		wp_die();
    	if ( get_magic_quotes_gpc() )
    		$_POST = stripslashes_deep( $_POST );
        
        $data = array( 'error' => 0 );
        
        if ( ! file_exists( $import_source['content'] ) ) {
			$data['error'] = 1;
            $data['message'] = esc_attr('content.xml does not exist', 'bkninja');
            $data['url']    = $import_source['content'] ;
			wp_send_json( $data );
		}
        
		if ( ! class_exists( 'WXR_Parser' ) ) {
			require BK_AD_PLUGIN_DIR . 'includes/parsers.php';
		}
        
        $parser = new WXR_Parser();
        
		$import_data = $parser->parse( $import_source['content'] );
		unset( $parser );
                        
        if ( is_wp_error( $import_data ) ) {
			$data['error'] = 1;
			wp_send_json($data);
		}
		
		$data['common']=array(
			'base_url' => esc_url( $import_data['base_url'] ),
		);
		$data['attachments']=array();
		
		$author = (int) get_current_user_id();
        
        foreach ( $import_data['posts'] as $post ) {

			if( 'attachment' == $post['post_type'] ) {
				
				$post_parent = (int) $post['post_parent'];
				
				$postdata = array(
					'import_id' => $post['post_id'], 'post_author' => $author, 'post_date' => $post['post_date'],
					'post_date_gmt' => $post['post_date_gmt'], 'post_content' => $post['post_content'],
					'post_excerpt' => $post['post_excerpt'], 'post_title' => $post['post_title'],
					'post_status' => $post['status'], 'post_name' => $post['post_name'],
					'comment_status' => $post['comment_status'], 'ping_status' => $post['ping_status'],
					'guid' => $post['guid'], 'post_parent' => $post_parent, 'menu_order' => $post['menu_order'],
					'post_type' => $post['post_type'], 'post_password' => $post['post_password']
				);
				
				$remote_url = ! empty( $post['attachment_url'] ) ? $post['attachment_url'] : $post['guid'];
				
				$postdata['upload_date'] = $post['post_date'];
				if ( isset( $post['postmeta'] ) ) {
					foreach( $post['postmeta'] as $meta ) {
						if ( $meta['key'] == '_wp_attached_file' ) {
							if ( preg_match( '%^[0-9]{4}/[0-9]{2}%', $meta['value'], $matches ) )
								$postdata['upload_date'] = $matches[0];
							break;
						}
					}
				}
				
				$postdata['postmeta']=$post['postmeta'];
				
				$data['attachments'][]=array(
					'data' => $postdata,
					'remote_url' => $remote_url,
				);
				
			}
		}
		
		$data['last_attachment_index'] = -1;
        
        $variables_dump = get_option( 'bk_import_process_data_'.$demoType);
		
		if ( ! empty( $variables_dump ) && is_array( $variables_dump ) ) {
			if ( isset( $variables_dump['last_attachment_index'] ) ) {
				$data['last_attachment_index'] = $variables_dump['last_attachment_index'];
			}
		}
		
		wp_send_json($data);
    }
}
add_action('wp_ajax_nopriv_bk_demo_import_attachments', 'bk_demo_import_attachments');
add_action('wp_ajax_bk_demo_import_attachments', 'bk_demo_import_attachments');
if (!function_exists('bk_demo_import_attachments')) {
    function bk_demo_import_attachments() {  
        $import_source  = isset( $_POST['import_source'] )  ? $_POST['import_source'] : null; 
        $data           = isset( $_POST['data'] )           ? $_POST['data'] : null; 
        $demoType  = isset( $_POST['demoType'] ) ? $_POST['demoType'] : null;
        
        $DataRet = array('error' => 0);
        
    	if ( isset( $data['attachments'] ) ) {
    		
            if ( ! defined('WP_LOAD_IMPORTERS') ) {
    			define('WP_LOAD_IMPORTERS', true);
    		}
            
    		if ( ! class_exists('WP_Import') ) {
    			include(BK_AD_PLUGIN_DIR . 'includes/wordpress-importer.php');
    		}
            
    		if ( class_exists( 'WP_Importer' ) && class_exists( 'WP_Import' ) ) {
    
    			$importer = new WP_Import();
    			$importer->base_url = $data['common']['base_url'];
    			$importer->fetch_attachments = true;
    			
                $variables_dump = get_option( 'bk_import_process_data_'.$demoType);
                
    			if ( ! empty( $variables_dump ) && is_array( $variables_dump ) ) {
    				$importer->post_orphans = $variables_dump['post_orphans'];
    				$importer->processed_posts = $variables_dump['processed_posts'];
    				$importer->url_remap = $variables_dump['url_remap'];
    			}
    			
    			$last_attachment_index=$data['first_attachment_index'];
    
    			foreach ( $data['attachments'] as $attachment ) {
    				
    				$post = $attachment['data'];
    
    				$importer->post_orphans[ intval( $post['import_id'] ) ] = (int) $post['post_parent'];
    				$post['post_parent'] = 0;
    		          
    				$post_id = $importer->process_attachment( $post, $attachment['remote_url'] );
    				
    				if ( is_wp_error( $post_id ) ) {
    				    $DataRet['error'] ++;
    					continue;
    				}
    				
    				$importer->processed_posts[ intval( $post['import_id'] ) ] = (int) $post_id;
    
    				// add/update post meta
    				if ( ! empty( $post['postmeta'] ) ) {
    					foreach ( $post['postmeta'] as $meta ) {
    						$key = $meta['key'];
    						$value = false;
    	
    						if ( '_edit_last' == $key ) {
    							continue;
    						}
    	
    						if ( $key ) {
    							if ( ! $value ){
    								$value = maybe_unserialize( $meta['value'] );
    							}
    							add_post_meta( $post_id, $key, $value );
    						}
    					}
    				}
    										
    				$variables_dump['last_attachment_index'] = $last_attachment_index;
    				$last_attachment_index++;
    				
    			}
    
    			$variables_dump['post_orphans'] = $importer->post_orphans;
    			$variables_dump['processed_posts'] = $importer->processed_posts;
    			$variables_dump['url_remap'] = $importer->url_remap;
                
                update_option( 'bk_import_process_data_'.$demoType, $variables_dump );
    		}
    	}
    	
    	wp_send_json($DataRet);
    }
}
add_action('wp_ajax_nopriv_bk_demo_import_others', 'bk_demo_import_others');
add_action('wp_ajax_bk_demo_import_others', 'bk_demo_import_others');
if (!function_exists('bk_demo_import_others')) {
    function bk_demo_import_others() {  
        wp_delete_nav_menu('Main menu');
        wp_delete_nav_menu('Top Menu');
        wp_delete_nav_menu('Footer');
        wp_delete_nav_menu('Testing Menu');
        $import_source  = isset( $_POST['import_source'] )  ? $_POST['import_source'] : null; 
        $demoType  = isset( $_POST['demoType'] ) ? $_POST['demoType'] : null;
        
        $ret = array( 'error' => 0 );
		
        $count = 0;
        
        for($count = 1; $count < BK_DEMO_COUNT; $count ++) {
            update_option('bk_demo_'.$count.'_status', false );
        }
        update_option('bk_'.$demoType.'_status', '' );
        
		if ( ! file_exists( $import_source['content'] ) ) {
			$ret['error'] = 1;
			wp_send_json( $ret );
		}
		
		if ( ! defined('WP_LOAD_IMPORTERS') ) {
			define('WP_LOAD_IMPORTERS', true);
		}
		
		if ( ! class_exists( 'WP_Import' ) ) {
            include(BK_AD_PLUGIN_DIR . 'includes/wordpress-importer.php');
		}

  		if ( class_exists( 'WP_Importer' ) && class_exists( 'WP_Import' ) ) {

			$importer = new WP_Import();
			$importer->fetch_attachments = false;
            
            $variables_dump = get_option( 'bk_import_process_data_'.$demoType);
            
			if ( ! empty( $variables_dump ) && is_array( $variables_dump ) ) {

				$importer->post_orphans = $variables_dump['post_orphans'];
				$importer->processed_posts = $variables_dump['processed_posts'];
				$importer->url_remap = $variables_dump['url_remap'];

			}
							
			ob_start();

			$importer->import( $import_source['content'] );

			ob_end_clean();
			
            update_option( 'bk_import_process_data_'.$demoType, false );
            
			$locations = get_theme_mod( 'nav_menu_locations' );
			$menus = wp_get_nav_menus();
			if ( $menus ) {
				$theme_menus = array(
					'Main Menu'    => 'main-menu',
                    'Top Menu'     => 'top-menu',
					'Footer Nav'   => 'footer-menu',
				);
				foreach ( $menus as $menu ) {
					if ( isset( $theme_menus[ $menu->name ] ) ) {
						$locations[ $theme_menus[ $menu->name ] ] = $menu->term_id;
					}
				}
			}
      		set_theme_mod( 'nav_menu_locations', $locations );
            
            update_menu_item_meta('main-menu', 'Pages', '_menu_item_bkmegamenu', 1);
            update_menu_item_meta('main-menu', 'Posts', '_menu_item_bkmegamenu', 1);
            update_menu_item_meta('main-menu', 'Lifestyle', '_menu_item_bkmegamenu', 1);
            update_menu_item_meta('main-menu', 'Travel', '_menu_item_bkmegamenu', 1);
            update_menu_item_meta('main-menu', 'Beauty', '_menu_item_bkmegamenu', 1);
            // Theme Options
            
            $optionData = file_get_contents( $import_source['theme_options'] );
            if ( ! empty ( $optionData ) ) {
                $import_options = json_decode( $optionData, true );
            }
            $redux_options = wp_parse_args( $import_options );
            
            update_option( 'ceris_option', $redux_options );
            
            remove_widgets_from_sidebar('home_sidebar');
            remove_widgets_from_sidebar('second_home_sidebar');
            // Widgets
			if ( file_exists( $import_source['widgets'] ) ) {
				
				if ( ! function_exists( 'wie_available_widgets') ) {
					require BK_AD_PLUGIN_DIR . 'includes/widgets-widgets.php';
				}
				if ( ! function_exists( 'wie_import_data' ) ) {
					require BK_AD_PLUGIN_DIR . 'includes/widgets-import.php';
				}
				
				$data = json_decode( file_get_contents( $import_source['widgets'] ) );
				wie_import_data( $data );
			}

			// Set reading options
        
            switch($demoType) {
                case(BK_DEMO_1):
                    $homepage = get_page_by_title( 'Ceris' );
                    break;
                case(BK_DEMO_2):
                    $homepage = get_page_by_title( 'Game' );
                    break;
                case(BK_DEMO_3):
                    $homepage = get_page_by_title( 'Architecture' );
                    break;
                case(BK_DEMO_4):
                    $homepage = get_page_by_title( 'Fitness' );
                    break;
                case(BK_DEMO_5):
                    $homepage = get_page_by_title( 'Technology' );
                    break;
                case(BK_DEMO_6):
                    $homepage = get_page_by_title( 'Minimal' );
                    break;
                case(BK_DEMO_7):
                    $homepage = get_page_by_title( 'Lifestyle' );
                    break;
                case(BK_DEMO_8):
                    $homepage = get_page_by_title( 'Sport' );
                    break;
                case(BK_DEMO_9):
                    $homepage = get_page_by_title( 'Interior' );
                    break;
                case(BK_DEMO_10):
                    $homepage = get_page_by_title( 'Resort' );
                    break;
                case(BK_DEMO_11):
                    $homepage = get_page_by_title( 'Cultures' );
                    break;
                case(BK_DEMO_12):
                    $homepage = get_page_by_title( 'Salon' );
                    break;
                case(BK_DEMO_13):
                    $homepage = get_page_by_title( 'Business' );
                    break;
                case(BK_DEMO_14):
                    $homepage = get_page_by_title( 'Food' );
                    break;
                case(BK_DEMO_15):
                    $homepage = get_page_by_title( 'Newspaper' );
                    break;
                case(BK_DEMO_16):
                    $homepage = get_page_by_title( 'Travel' );
                    break;
                case(BK_DEMO_17):
                    $homepage = get_page_by_title( 'Fashion' );
                    break;
                case(BK_DEMO_18):
                    $homepage = get_page_by_title( 'Music' );
                    break;
                case(BK_DEMO_19):
                    $homepage = get_page_by_title( 'Coffee' );
                    break;
                case(BK_DEMO_20):
                    $homepage = get_page_by_title( 'Art' );
                    break;
                case(BK_DEMO_21):
                    $homepage = get_page_by_title( 'News' );
                    break;
                case(BK_DEMO_22):
                    $homepage = get_page_by_title( 'Portfolio' );
                    break;
                case(BK_DEMO_23):
                    $homepage = get_page_by_title( 'Photography' );
                    break;
                case(BK_DEMO_24):
                    $homepage = get_page_by_title( 'Personal' );
                    break;
                case(BK_DEMO_25):
                    $homepage = get_page_by_title( 'Photography v2' );
                    break;
                case(BK_DEMO_26):
                    $homepage = get_page_by_title( 'Nature' );
                    break;
                case(BK_DEMO_27):
                    $homepage = get_page_by_title( 'Health' );
                    break;
                case(BK_DEMO_28):
                    $homepage = get_page_by_title( 'Garden' );
                    break;
                case(BK_DEMO_29):
                    $homepage = get_page_by_title( 'Entertainment' );
                    break;
                case(BK_DEMO_30):
                    $homepage = get_page_by_title( 'Science' );
                    break;
                case(BK_DEMO_31):
                    $homepage = get_page_by_title( 'Racing' );
                    break;
                case(BK_DEMO_32):
                    $homepage = get_page_by_title( 'Spa' );
                    break;
                case(BK_DEMO_33):
                    $homepage = get_page_by_title( 'Construct' );
                    break;
                case(BK_DEMO_34):
                    $homepage = get_page_by_title( 'Cyberpunk' );
                    break;
                case(BK_DEMO_35):
                    $homepage = get_page_by_title( 'Basketball' );
                    break;
                case(BK_DEMO_36):
                    $homepage = get_page_by_title( 'Inspiration' );
                    break;
                case(BK_DEMO_37):
                    $homepage = get_page_by_title( 'Cafe' );
                    break;
                case(BK_DEMO_38):
                    $homepage = get_page_by_title( 'Baby' );
                    break;
                case(BK_DEMO_39):
                    $homepage = get_page_by_title( 'FBlog' );
                    break;
                case(BK_DEMO_40):
                    $homepage = get_page_by_title( 'Urban Art' );
                    break;
                case(BK_DEMO_41):
                    $homepage = get_page_by_title( 'Boxing' );
                    break;
                case(BK_DEMO_42):
                    $homepage = get_page_by_title( 'Menmag' );
                    break;
                case(BK_DEMO_43):
                    $homepage = get_page_by_title( 'Dailynews' );
                    break;
                default:
                    $homepage = get_page_by_title( 'Ceris' );
                    break;
            }
			
			if ( $homepage ) {
				update_option( 'page_on_front', $homepage->ID );
				update_option( 'show_on_front', 'page' );
			}

			global $wp_rewrite;
			$wp_rewrite -> set_permalink_structure( '/%postname%/' );
			update_option( 'rewrite_rules', false );
			$wp_rewrite->flush_rules( true );
            
            update_option('bk_'.$demoType.'_status', 'imported' );
		}
	
		wp_send_json($ret);
    }
}
if(!function_exists('tnm_remove_duplicate_menu_item')) {
    function tnm_remove_duplicate_menu_item($menu_name) {
		$items = wp_get_nav_menu_items( $menu_name );
		$prev_title = '';
		foreach ($items as $item) {
			if ($prev_title === '') {
				$prev_title = $item->title;
				continue;
			}
			if ($prev_title === $item->title) {
				wp_delete_post($item->ID, true);
			} else {
				$prev_title = $item->title;
			}
		}
	}
}
// remove all old widgets from target sidebar 
if(!function_exists('remove_widgets_from_sidebar')) {
	function remove_widgets_from_sidebar($sidebar_id) {
		$sidebars_widgets = get_option( 'sidebars_widgets' );
		
		if (isset($sidebars_widgets[$sidebar_id])) {
			//empty the default sidebar
			$sidebars_widgets[$sidebar_id] = array();
		} else {
			$sidebars_widgets = wp_parse_args($sidebars_widgets, array(
				$sidebar_id => array()
			));
		}
		update_option('sidebars_widgets', $sidebars_widgets);
	}
}
if(!function_exists('update_menu_item_meta')) {
    function update_menu_item_meta($menu_name, $menu_item_title, $meta_key, $meta_value) {
    	$items = wp_get_nav_menu_items( $menu_name );
    	foreach ( $items as $item ) {
    		if ( $item->title === $menu_item_title ) {
    			update_post_meta( $item->ID, $meta_key, sanitize_key($meta_value) );
    		}
    	}
    }
}
if(!function_exists('update_category_meta_data')) {
    function update_category_meta_data() {

    }
}
if (!function_exists('tnm_name_limit_by_word')) {
    function tnm_name_limit_by_word($string, $word_limit){
        $words = explode(' ', $string, ($word_limit + 1));
        if(count($words) > $word_limit)
        array_pop($words);
        $strout = implode(' ', $words);
        if (strlen($strout) < strlen($string))
            $strout .=" ...";
        return $strout;
    }
}