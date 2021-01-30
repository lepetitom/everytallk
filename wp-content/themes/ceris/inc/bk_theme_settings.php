<?php
if ( ! function_exists( 'ceris_enqueue_editor' ) ) {
	function ceris_enqueue_editor() {
		wp_enqueue_style( 'ceris-google-font-editor', esc_url_raw( ceris_editor_font_urls() ), array(), false, 'all' );
		wp_enqueue_style( 'ceris-editor-style', get_theme_file_uri( 'css/backend/assets/editor.css' ), array(), false, 'all' );
	}
}
add_action( 'enqueue_block_editor_assets', 'ceris_enqueue_editor', 990 );
add_action( 'enqueue_block_editor_assets', 'ceris_editor_dynamic', 999 );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function ceris_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', get_bloginfo( 'pingback_url'), '">';
	}
}
add_action( 'wp_head', 'ceris_pingback_header' );

if ( ! function_exists( 'ceris_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ceris_theme_setup() {
	   
	   /*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Twenty Nineteen, use a find and replace
		 * to change 'twentynineteen' to the name of your theme in all the template files.
		 */
        load_theme_textdomain( 'ceris', get_template_directory() .'/languages' );
        
        // Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );
        
        add_theme_support( 'post-formats', array( 'gallery', 'video' ) );
        
        /*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
        
        add_image_size( 'ceris-xxxs-1_1', 70, 70, true );
        add_image_size( 'ceris-xxs-4_3', 180, 135, true );
        add_image_size( 'ceris-xxs-1_1', 180, 180, true );
        add_image_size( 'ceris-xs-16_9 400x225', 400, 225, true );
        add_image_size( 'ceris-xs-4_3', 400, 300, true );
        add_image_size( 'ceris-xs-2_1', 400, 200, true );
        add_image_size( 'ceris-xs-1_1', 400, 400, true );        
        add_image_size( 'ceris-xs-16_9', 600, 338, true ); 
        add_image_size( 'ceris-s-4_3', 600, 450, true );
        add_image_size( 'ceris-s-2_1', 600, 300, true );
        add_image_size( 'ceris-s-1_1', 600, 600, true );
        add_image_size( 'ceris-m-16_9', 800, 450, true );
        add_image_size( 'ceris-m-4_3', 800, 600, true );
        add_image_size( 'ceris-m-2_1', 800, 400, true );
        add_image_size( 'ceris-m-auto', 800, 9999, false );
        add_image_size( 'ceris-l-16_9', 1200, 675, true );
        add_image_size( 'ceris-l-4_3', 1200, 900, true );
        add_image_size( 'ceris-l-2_1', 1200, 600, true );
        add_image_size( 'ceris-xl-16_9', 1600, 900, true );
        add_image_size( 'ceris-xl-4_3', 1600, 1200, true );        
        add_image_size( 'ceris-xl-2_1', 1600, 800, true ); 
        add_image_size( 'ceris-xxl', 2000, 1125, true );
        
        // This theme uses wp_nav_menu().
        register_nav_menu('top-menu', esc_html__( 'Top Menu', 'ceris' ));
        register_nav_menu('main-menu', esc_html__( 'Main Menu', 'ceris' ));
        register_nav_menu('footer-menu', esc_html__( 'Footer Menu', 'ceris' )); 
        register_nav_menu('offcanvas-menu', esc_html__( 'Offcanvas Menu', 'ceris' )); 
        
        // Add support for editor styles.
		add_theme_support( 'editor-styles' );
		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );
    }
	   
endif;
add_action( 'after_setup_theme', 'ceris_theme_setup' );

function ceris_modify_main_query( $query ) {
    global $ceris_option;
    if($ceris_option == '') {
        return;
    }    
    if($query->is_main_query() AND !is_admin() ) {
        if ( is_category() ){
            $excludeIDs = array();
            $posts_per_page = 0;
            
            $term_id = get_queried_object_id();
            
            $featAreaOption  = ceris_archive::bk_get_archive_option($term_id, 'bk_category_feature_area__post_option');
            if(function_exists('rwmb_meta')) {
                $is_exclude = rwmb_meta( 'bk_category_exclude_posts', array( 'object_type' => 'term' ), $term_id );
            }else {
                $is_exclude = '';
            }
            if (isset($is_exclude) && (($is_exclude == 'global_settings') || ($is_exclude == ''))): 
                $is_exclude = $ceris_option['bk_category_exclude_posts'];
            endif;
            if(($is_exclude == 1) || ($featAreaOption == 'latest')) {                     

                $sticky = get_option('sticky_posts') ;
                rsort( $sticky );
                
                if(function_exists('rwmb_meta')) {
                    $featLayout = rwmb_meta( 'bk_category_feature_area', array( 'object_type' => 'term' ), $term_id );
                }else {
                    $featLayout = 'global_settings';
                }
                if (isset($is_exclude) && (($featLayout == 'global_settings') || ($featLayout == ''))): 
                    $featLayout = $ceris_option['bk_category_feature_area'];
                endif;
                            
                $args = array (
                    'post_type'     => 'post',
                    'cat'           => $term_id, // Get current category only
                    'order'         => 'DESC',
                );
                
                switch($featLayout){
                    case 'grid_o' :
                        $posts_per_page = 5;
                        break;
                    case 'grid_p' :
                        $posts_per_page = 4;
                        break;
                    case 'grid_q' :
                        $posts_per_page = 3;
                        break;
                    case 'grid_r' :
                        $posts_per_page = 3;
                        break;
                    default:
                        $posts_per_page = 0;
                        break;
                }
                if($posts_per_page == 0) :
                    wp_reset_postdata();
                    return;
                endif;
                $args['posts_per_page'] = $posts_per_page;
                if($featAreaOption == 'featured') {
                    $args['post__in'] = $sticky; // Get stickied posts
                }
                
                $sticky_query = new WP_Query( $args );
                while ( $sticky_query->have_posts() ): $sticky_query->the_post();
                    $excludeIDs[] = get_the_ID();
                endwhile;
                wp_reset_postdata();
                            
                $query->set( 'post__not_in', $excludeIDs );
            }else {
                return;
            }
        }
    }
}
add_action( 'pre_get_posts', 'ceris_modify_main_query' );

require_once (get_template_directory() . '/library/meta_box_config.php');

/**
 * http://codex.wordpress.org/Content_Width
 */
if ( ! isset($content_width)) {
	$content_width = 1200;
}

/**
 * Remove Comment Default Style
 */
add_filter( 'show_recent_comments_widget_style', '__return_false' );


/**
 * Add Image Column To Posts Page
 */
function ceris_featured_image_column_image( $image ) {
    if ( !ceris_core::bk_check_has_post_thumbnail(get_the_ID()) )
        return trailingslashit( get_stylesheet_directory_uri() ) . 'images/no-featured-image';
}
add_filter( 'featured_image_column_default_image', 'ceris_featured_image_column_image' );


function ceris_category_nav_class( $classes, $item ){
    /*
    if(isset($item->bkmegamenu[0])) :
        if ($item->bkmegamenu[0]) {
            $classes[] = 'menu-category-megamenu';
        }
        if( 'category' == $item->object ){
            $classes[] = 'menu-item-cat-' . $item->object_id;
        }
    endif;
    */
    if( 'category' == $item->object ){
        $classes[] = 'menu-item-cat-' . $item->object_id;
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'ceris_category_nav_class', 10, 4 );

function ceris_custom_excerpt_length( $length ) {
	return 100;
}
add_filter( 'excerpt_length', 'ceris_custom_excerpt_length', 999 );

/**
 * ReduxFramework
 */
/**-------------------------------------------------------------------------------------------------------------------------
 * remove redux admin page
 */
if ( ! function_exists( 'ceris_remove_redux_page' ) ) {
	function ceris_remove_redux_page() {
		remove_submenu_page( 'tools.php', 'redux-about' );
	}
	add_action( 'admin_menu', 'ceris_remove_redux_page', 12 );
}
/**-------------------------------------------------------------------------------------------------------------------------
 * Init
 */
if ( !isset( $ceris_option ) && file_exists( CERIS_LIBS.'theme-options/theme-option.php' ) ) {
    require_once( CERIS_THEMEOPTONS.'theme-option.php' );
    require_once( CERIS_THEMEOPTONS_SECTIONS.'all-sections.php' );
}
/**
 * Register sidebars and widgetized areas.
 *---------------------------------------------------
 */
 if ( ! function_exists( 'ceris_widgets_init' ) ) {
    function ceris_widgets_init() {
        $ceris_option = ceris_core::bk_get_global_var('ceris_option');
        $headingStyle = isset($ceris_option['bk-default-widget-heading']) ? $ceris_option['bk-default-widget-heading'] : '';
        if($headingStyle) {
            $headingClass = ceris_core::bk_get_widget_heading_class($headingStyle);
        }else {
            $headingClass = 'block-heading--line';
        }
        register_sidebar( array(
    		'name' => esc_html__('Sidebar', 'ceris'),
    		'id' => 'home_sidebar',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget' => '</div>',
    		'before_title' => '<div class="widget__title block-heading '.$headingClass.'"><h4 class="widget__title-text">',
    		'after_title' => '</h4></div>',
    	) );
        
        register_sidebar( array(
    		'name' => esc_html__('Footer Sidebar 1', 'ceris'),
    		'id' => 'footer_sidebar_1',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget' => '</div>',
    		'before_title' => '<div class="widget__title block-heading block-heading--center"><h4 class="widget__title-text">',
    		'after_title' => '</h4></div>',
    	) );
        
        register_sidebar( array(
    		'name' => esc_html__('Footer Sidebar 2', 'ceris'),
    		'id' => 'footer_sidebar_2',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget' => '</div>',
    		'before_title' => '<div class="widget__title block-heading block-heading--center"><h4 class="widget__title-text">',
    		'after_title' => '</h4></div>',
    	) );
        
        register_sidebar( array(
    		'name' => esc_html__('Footer Sidebar 3', 'ceris'),
    		'id' => 'footer_sidebar_3',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget' => '</div>',
    		'before_title' => '<div class="widget__title block-heading block-heading--center"><h4 class="widget__title-text">',
    		'after_title' => '</h4></div>',
    	) );
    }
}
add_action( 'widgets_init', 'ceris_widgets_init' );

/**
 * Save Post Content Word Count
 *---------------------------------------------------
 */
function ceris_post_content__word_count($postID){
    $content = get_post_field( 'post_content', $postID );
    $word_count = str_word_count( strip_tags( $content ) );
    $lastLength = get_post_meta($postID, 'ceris_post_content__word_count');
    if(!empty($lastLength)) :
        if(($lastLength[0] != '') && ($lastLength[0] != $word_count)) :
            update_post_meta($postID, 'ceris_post_content__word_count', $word_count);
        elseif($lastLength[0] == '') :
            add_post_meta($postID, 'ceris_post_content__word_count', $word_count, true);
        endif;
    endif;
}

add_action( 'post_updated', 'ceris_post_content__word_count', 10, 1 ); //don't forget the last argument to allow all three arguments of the function

function remove_pages_from_search() {
    $ceris_option = ceris_core::bk_get_global_var('ceris_option');
    if(isset($ceris_option['bk_search_exclude_page_result']) && ($ceris_option['bk_search_exclude_page_result'] == 'enable')) {
        global $wp_post_types;
        $wp_post_types['page']->exclude_from_search = true;
    }
}
add_action('init', 'remove_pages_from_search');

/**
 * Add responsive container to embeds video
 */
if ( !function_exists('ceris_embed_html') ){
	function ceris_embed_html( $embed, $url = '', $attr = '' ) {
		$accepted_providers = array(
			'youtube',
			'vimeo',
			'slideshare',
			'dailymotion',
			'viddler.com',
			'hulu.com',
			'blip.tv',
			'revision3.com',
			'funnyordie.com',
			'wordpress.tv',
		);
		$resize = false;

		// Check each provider
		foreach ( $accepted_providers as $provider ) {
			if ( strstr( $url, $provider ) ) {
				$resize = true;
				break;
			}
		}
		if ( $resize ) {
	    	return '<div class="atbs-ceris-responsive-video">' . $embed . '</div>';
	    } else {
	    	return $embed;
	    }
	}
}
add_filter( 'embed_oembed_html', 'ceris_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'ceris_embed_html' ); // Jetpack

/**
 * Limit number of tags in widget tag cloud
 */
if ( !function_exists('ceris_tag_widget_limit') ) {
  function ceris_tag_widget_limit($args){

    //Check if taxonomy option inside widget is set to tags
    if(isset($args['taxonomy']) && $args['taxonomy'] == 'post_tag'){
      $args['number'] = 16; //Limit number of tags
      $args['smallest'] = 12; //Size of lowest count tags
      $args['largest'] = 12; //Size of largest count tags
      $args['unit'] = 'px'; //Unit of font size
      $args['orderby'] = 'count'; //Order by counts
      $args['order'] = 'DESC';
    }

    return $args;
  }
}
add_filter('widget_tag_cloud_args', 'ceris_tag_widget_limit');

add_action('amp_post_template_css','ampforwp_add_custom_css', 11);
function ampforwp_add_custom_css() {
	require_once (get_template_directory().'/ampforwp/custom_style.php');
}

/**
 * Add Post Class 
 * */
if( !function_exists('ceris_add_post_class')) {
    function ceris_add_post_class( $classes, $class, $post_id ) {
        $classes[] = 'post--single';
        return $classes;
    }
    add_filter( 'post_class', 'ceris_add_post_class', 10, 3 );
}

?>