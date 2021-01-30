<?php
if (!class_exists('ceris_ajax_megamenu')) {
    class ceris_ajax_megamenu {
        //Search Query
        static function ceris_query($CatID, $megaMenuStyle = 1) {
            $args = array(
                'cat' => $CatID,  
                'post_type' => 'post',  
                'post_status' => 'publish', 
                'ignore_sticky_posts' => 1,  
                'posts_per_page' => 4
            );
            if($megaMenuStyle == 3) {
                $args['posts_per_page'] = 8;
            }
    
            $the_query = new WP_Query($args);
            return $the_query;
        }
        static function ceris_ajax_content( $the_query, $megaMenuStyle ) {
            $contentReturn = '';
            if($megaMenuStyle == 2) {
                $contentReturn .= ceris_header::bk_get_megamenu_1stlarge_posts($the_query); 
            }else if($megaMenuStyle == 3) {
                $contentReturn .= ceris_header::bk_get_megamenu_4large_posts($the_query); 
            }else {
                $contentReturn .= ceris_header::bk_get_megamenu_posts($the_query); 
            }
            return $contentReturn;
        }
    }
}
add_action('wp_ajax_nopriv_ceris_ajax_megamenu', 'ceris_ajax_megamenu');
add_action('wp_ajax_ceris_ajax_megamenu', 'ceris_ajax_megamenu');
if (!function_exists('ceris_ajax_megamenu')) {
    function ceris_ajax_megamenu()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        
        $CatID      = isset( $_POST['thisCatID'] ) ? $_POST['thisCatID'] : null; 
        $megaMenuStyle = isset( $_POST['megaMenuStyle'] ) ? $_POST['megaMenuStyle'] : null; 
        
        $dataReturn = 'no-result';
        
        $the_query = ceris_ajax_megamenu::ceris_query($CatID, $megaMenuStyle);
        
        if ( $the_query->have_posts() ) {
            $dataReturn = ceris_ajax_megamenu::ceris_ajax_content($the_query, intval($megaMenuStyle));
        }else {
            $dataReturn = 'no-result';        
        }
        
        die(json_encode($dataReturn));
    }
}