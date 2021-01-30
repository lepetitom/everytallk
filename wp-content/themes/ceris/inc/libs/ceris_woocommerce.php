<?php
if (!class_exists('ceris_woocommerce')) {
    class ceris_woocommerce {
        static function render_page_heading($pageID, $headingStyle, $headingColor = '') {
            $headingInverse = 'no';
            $headingClass = ceris_core::bk_get_block_heading_class($headingStyle, $headingInverse);
            
            $styleInline = '';
            if($headingColor != '') :
                $styleInline = 'style="color:'.$headingColor.';"';
            endif;
            
            $page_description  = get_post_meta($pageID,'bk_page_description',true);
            
            $archiveHeader = '';
            
            $archiveHeader .= '<div class="container"><div class="block-heading '.$headingClass.'">';
            $archiveHeader .= '<h1 class="page-heading__title block-heading__title" '.$styleInline.'>'. woocommerce_page_title(false) .'</h1>';
            if ( $page_description != '' ) :
                $archiveHeader .= '<div class="page-heading__subtitle">'.esc_attr($page_description).'</div>';
            endif;
            
            $archiveHeader .= '</div></div><!-- block-heading -->';
            
            return $archiveHeader;                        
                    
        }     
    } // Close ceris_archive class
}
if ( ! function_exists( 'woocommerce_product_archive_description' ) ) {

	/**
	 * Show a shop page description on product archives.
	 */
	function woocommerce_product_archive_description() {
		// Don't display the description on search results page.
		if ( is_search() ) {
			return;
		}

		if ( is_post_type_archive( 'product' ) && in_array( absint( get_query_var( 'paged' ) ), array( 0, 1 ), true ) ) {
			$shop_page = get_post( wc_get_page_id( 'shop' ) );
			if ( $shop_page ) {
				$description = wc_format_content( $shop_page->post_content );
				if ( $description ) {
					echo '<div class="page-description">' . $description . '</div>'; // WPCS: XSS ok.
				}
			}
		}
	}
}