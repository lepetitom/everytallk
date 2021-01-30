<?php
/**-------------------------------------------------------------------------------------------------------------------------
 * register ajax
 */
if ( ! function_exists( 'ceris_enqueue_ajax_url' ) ) {
	function ceris_enqueue_ajax_url() {
        echo '<script type="application/javascript">var ajaxurl = "' . esc_url(admin_url( 'admin-ajax.php' )) . '"</script>';
	}
	add_action( 'wp_enqueue_scripts', 'ceris_enqueue_ajax_url' );
}
/**-------------------------------------------------------------------------------------------------------------------------
 * Enqueue All Scripts
 */
if ( ! function_exists( 'ceris_scripts_method' ) ) {
    function ceris_scripts_method() {

        wp_enqueue_script('jquery-ui-widget');
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('jquery-ui-accordion');
        wp_enqueue_script('imagesloaded');
        wp_enqueue_script('jquery-masonry', array( 'imagesloaded' ),'', true);
        
        add_editor_style('editor-style.css');
        wp_enqueue_style( 'ceris-vendors', get_template_directory_uri().'/css/vendors.css', array(), '' );
        
        if (preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false)) {
            if (class_exists('Woocommerce')) {
                wp_enqueue_style('ceris-woocommerce', get_template_directory_uri() . '/css/woocommerce_css/woocommerce_IE.css', array('ceris-vendors'), '' );
            }
            wp_enqueue_style( 'ceris-style', get_template_directory_uri().'/css/style_IE.css', array('ceris-vendors'), '' );
        }else {
            if (class_exists('Woocommerce')) {
                wp_enqueue_style('ceris-woocommerce', get_template_directory_uri() . '/css/woocommerce_css/woocommerce.css', array('ceris-vendors'), '' );
            }
            wp_enqueue_style( 'ceris-style', get_template_directory_uri().'/css/style.css', array('ceris-vendors'), '' );
        }
        //vendors
        wp_enqueue_script('throttle-debounce', get_template_directory_uri() . '/js/vendors/throttle-debounce.min.js', array('jquery'),false, true);
        wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/vendors/bootstrap.min.js', array('throttle-debounce'),false, true);
        wp_enqueue_script('final-countdown', get_template_directory_uri() . '/js/vendors/countdown.min.js', array('bootstrap'),false, true);
        wp_enqueue_script('flickity', get_template_directory_uri() . '/js/vendors/flickity.min.js', array('final-countdown'),false, true);
        wp_enqueue_script('fotorama', get_template_directory_uri() . '/js/vendors/fotorama.min.js', array('flickity'),false, true);
        wp_enqueue_script('magnific-popup', get_template_directory_uri() . '/js/vendors/magnific-popup.min.js', array('fotorama'),false, true);
        wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/js/vendors/owl-carousel.min.js', array('magnific-popup'),false, true);
        wp_enqueue_script('perfect-scrollbar', get_template_directory_uri() . '/js/vendors/perfect-scrollbar.min.js', array('owl-carousel'),false, true);
        wp_enqueue_script('theiaStickySidebar', get_template_directory_uri() . '/js/vendors/theiaStickySidebar.min.js', array('perfect-scrollbar'),false, true);
        wp_enqueue_script('vticker', get_template_directory_uri() . '/js/vendors/vticker.min.js', array('theiaStickySidebar'),false, true);
        wp_enqueue_script('fitvids', get_template_directory_uri() . '/js/vendors/fitvids.js', array('vticker'),false, true);
        
        //theme scripts
        wp_enqueue_script('ceris-scripts', get_template_directory_uri() . '/js/scripts.js', array('fitvids'),false, true);              
        
        if ( is_singular() ) {wp_enqueue_script('comment-reply');}
     }
}

add_action('wp_enqueue_scripts', 'ceris_scripts_method');

/**-------------------------------------------------------------------------------------------------------------------------
 * Enqueue Admin Scripts
 */
if ( ! function_exists( 'ceris_post_admin_scripts_and_styles' ) ) {
    function ceris_post_admin_scripts_and_styles($hook) {        
        global $wp_version;
    	if( $hook == 'post.php' || $hook == 'post-new.php' ) {
            wp_enqueue_script( 'bootstrap-admin', get_template_directory_uri().'/framework/bootstrap-admin/bootstrap.js', array(), '', true );
            wp_enqueue_style( 'bootstrap-admin', get_template_directory_uri().'/framework/bootstrap-admin/bootstrap.css', array(), '' );
   		}
        
        wp_enqueue_style( 'bootstrap-datepicker', get_template_directory_uri().'/css/admin/bootstrap-datepicker3.min.css', array(), '' );
        
        wp_enqueue_style( 'bootstrap-colorpicker', get_template_directory_uri().'/css/admin/bootstrap-colorpicker.min.css', array(), '' );
        
        wp_enqueue_style( 'ceris-admin', get_template_directory_uri().'/css/admin/admin.css', array(), '' );
        
        add_editor_style('css/admin/editorstyle.css');
        
        wp_enqueue_script('throttle-debounce', get_template_directory_uri() . '/js/vendors/throttle-debounce.min.js', array('jquery'),false, true);
        
        wp_enqueue_script( 'bootstrap-datepicker', get_template_directory_uri().'/js/admin/bootstrap-datepicker.min.js', array(), '', true );
        
        wp_enqueue_script( 'bootstrap-colorpicker', get_template_directory_uri().'/js/admin/bootstrap-colorpicker.min.js', array(), '', true );
        
        wp_enqueue_script( 'jquery-autosize', get_template_directory_uri().'/js/admin/jquery.autosize.min.js', array(), '', true );
        
        if(is_admin()) {
            if ( version_compare( $wp_version, '5.0', '>=' ) ) {
                if ( !class_exists( 'Classic_Editor' ) ) {
                    wp_enqueue_script( 'ceris-admin', get_template_directory_uri().'/js/admin/admin-gutenberg.js', array('jquery-ui-sortable'), '', true );
                }else {
                    wp_enqueue_script( 'ceris-admin', get_template_directory_uri().'/js/admin/admin.js', array('jquery-ui-sortable'), '', true );
                }
            }else {
                if(!function_exists('gutenberg_pre_init')) {
                    wp_enqueue_script( 'ceris-admin', get_template_directory_uri().'/js/admin/admin.js', array('jquery-ui-sortable'), '', true );
                }else {
                    wp_enqueue_script( 'ceris-admin', get_template_directory_uri().'/js/admin/admin-gutenberg.js', array('jquery-ui-sortable'), '', true );
                }
            }
        }
    }
}
add_action('admin_enqueue_scripts', 'ceris_post_admin_scripts_and_styles');
