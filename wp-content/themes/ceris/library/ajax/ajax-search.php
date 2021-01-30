<?php
if (!class_exists('ceris_ajax_search')) {
    class ceris_ajax_search {
        //Search Query
        static function ceris_query($searchTerm) {
            $args = array(
                's' => esc_sql($searchTerm),
                'post_type' => array('post'),
                'post_status' => 'publish',
                'posts_per_page' => 5,
            );
    
            $the_query = new WP_Query($args);
            return $the_query;
        }
        static function ceris_ajax_content( $the_query, $users_found ) {
            $searchTerm      = isset( $_POST['searchTerm'] ) ? $_POST['searchTerm'] : null;    
            
            // Category
            $cat_L_Style = 4; //Category Top Left
            $cat_L_Class = ceris_core::bk_get_cat_class($cat_L_Style);
            
            $catStyle = 4; 
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            
            $postOverlayHTML = new ceris_post_overlay_4;
            $postOverlayAttr = array (
                'additionalClass'       => 'post--overlay post--overlay-height-320 post-grid-video-space-between',
                'additionalThumbClass' => 'post__thumb--overlay atbs-thumb-object-fit background-img',
                'additionalTextClass' => 'inverse-text',
                'cat'                   => $cat_L_Style,
                'catClass'              => $cat_L_Class . ' color-white',
                'thumbSize'             => 'ceris-m-2_1',
                'typescale'             => 'typescale-3 custom-typescale-3 m-t-md',
                'meta_normal'           => array('author_has_wrap', 'date'),
                'postIcon'              => $postIconAttr,
            );
            
            $postVerticalHTML = new ceris_post_vertical_3;         
            $postVerticalAttr = array (
                'cat'                 => $catStyle,
                'catClass'            => $cat_Class,
                'additionalClass'     => 'ceris-post-vertical--cat-overlay post--vertical-text-not-fullwidth',
                'additionalTextClass' => '',
                'thumbSize'           => 'ceris-xs-16_9',
                'typescale'           => 'typescale-2',
                'postIcon'            => $postIconAttr,
                'meta'                  => array('author_name', 'date'),
            );
            
            $postHorizontalHTML = new ceris_post_horizontal_1;
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-search post--horizontal-xxs post__thumb-70',
                'thumbSize'         => 'ceris-xxs-1_1',
                'typescale'         => 'typescale-1',
                'postIcon'          => $postIconAttr,  
                'meta'              => array('date'),
            );
                                    
            $search_data = '';
            $search_data .= '<div class="atbs-ceris-search-full--result-inner">';                        
            $search_data .= '<div class="show-content">';
            
            $maxPosts = $the_query->post_count;
            
            $postCount = 1;                                    
            if ( $the_query->have_posts() ): $the_query->the_post();
                $postOverlayAttr['postID'] = get_the_ID();
                $search_data .= $postOverlayHTML->render($postOverlayAttr);
                $postCount ++;                
            endif;
            $search_data .= '<div class="post-grid-result post-list">';
            
            while ( $the_query->have_posts() ): $the_query->the_post();
                if($postCount == 2):
                    $search_data .= '<div class="post-grid-result--left">';
                    $search_data .= '<div class="list-item">';
                    $postVerticalAttr['postID'] = get_the_ID();                    
                    $search_data .= $postVerticalHTML->render($postVerticalAttr);
                    $search_data .= '</div> <!-- list-item -->';
                    $search_data .= '</div> <!-- post-grid-result--left -->';
                endif;
                
                if($postCount > 2) :
                    if($postCount == 3) :                
                        $search_data .= '<div class="post-grid-result--body">';
                    endif;
                                                            
                    $search_data .= '<div class="list-item">';
                    $postHorizontalAttr['postID'] = get_the_ID();
                    $search_data .= $postHorizontalHTML->render($postHorizontalAttr);
                    $search_data .= '</div> <!-- list-item -->';
                    
                    if($postCount == $maxPosts) :                                                
                        $search_data .= '</div> <!-- post-grid-result--body -->';
                    endif;                                                            
                endif;                                                
                $postCount ++;
            endwhile;
            if($postCount > 1) :            
                $search_data .= '</div> <!-- post-grid-result -->';
                $search_data .= '<nav class="atbs-ceris-pagination text-center">';
                $search_data .= '<button class="btn btn-default js-ajax-load-post-trigger"><a href="' . get_search_link($searchTerm) . '">' .esc_html__('Show all results', 'ceris'). '</a></button>';
                $search_data .= '</nav>';
            endif;
                                                
            $search_data .= '</div> <!-- Show Content -->';
            $search_data .= '</div> <!-- atbs-ceris-search-full--result-inner -->';
                                                                        
            return $search_data;
        }
    }
}
add_action('wp_ajax_nopriv_ceris_ajax_search', 'ceris_ajax_search');
add_action('wp_ajax_ceris_ajax_search', 'ceris_ajax_search');
if (!function_exists('ceris_ajax_search')) {
    function ceris_ajax_search()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        
        $searchTerm      = isset( $_POST['searchTerm'] ) ? $_POST['searchTerm'] : null;    
        
        $dataReturn = '<div class="ceris-ajax-no-result">' . esc_html__('No results', 'ceris') . '</div>';
    
        $the_query = ceris_ajax_search::ceris_query($searchTerm);
        
        $users = new WP_User_Query( array(
            'search'         => '*'.esc_attr( $searchTerm ).'*',
            'search_columns' => array(
                'user_login',
                'user_nicename',
                'user_email',
                'user_url',
            ),
        ) );
        
        $users_found = $users->get_results();
        
        if (( $the_query->have_posts() ) || count($users_found)) {
            $dataReturn = ceris_ajax_search::ceris_ajax_content($the_query, $users_found);
        }else {
            $dataReturn = '<div class="ceris-ajax-no-result">' . esc_html__('No results', 'ceris') . '</div>';
        }
        die(json_encode($dataReturn));
    }
}