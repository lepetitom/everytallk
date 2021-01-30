<?php
if (class_exists('Woocommerce')) {
    /**
     * Woocommerce Setup
     */
    if ( ! function_exists( 'bk_woocommerce_setup' ) ) {
    	function bk_woocommerce_setup() {
    		add_theme_support( 'woocommerce' );
    		add_filter( 'woocommerce_show_page_title', '__return_false' );
    	}
    	add_action( 'after_setup_theme', 'bk_woocommerce_setup' );
    }
    if ( ! function_exists( 'bk_setup_woocommerce_image_dimensions' ) ) {
    	function bk_setup_woocommerce_image_dimensions() {
    		$bk_woo_catalog = array( // square_medium size
    			'width' 	=> '550',	// px
    			'height'	=> '550',	// px
    			'crop'		=> 1 		// true
    		);
    	 
    		$bk_woo_single = array(
    			'width' 	=> '550',	// px
    			'height'	=> '550',	// px
    			'crop'		=> 1 		// true
    		);
    	 
    		$bk_woo_thumbnail = array(
    			'width' 	=> '360',	// px
    			'height'	=> '360',	// px
    			'crop'		=> 0 		// false
    		);
    	 
    		// Image sizes
    		update_option( 'shop_catalog_image_size', $bk_woo_catalog ); 		// Product category thumbs
    		update_option( 'shop_single_image_size', $bk_woo_single ); 		// Single product image
    		update_option( 'shop_thumbnail_image_size', $bk_woo_thumbnail ); 	// Image gallery thumbs
    	}
    	add_action( 'after_switch_theme', 'bk_setup_woocommerce_image_dimensions' );
    }
    add_filter( 'single_product_small_thumbnail_size', 'bk_single_product_small_thumbnail_size', 25, 1 );
    function bk_single_product_small_thumbnail_size( $size ) {
        $size = 'full';
        return $size;
    }
}