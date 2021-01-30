<?php
if (!class_exists('ceris_ajax_post_list')) {
    class ceris_ajax_post_list {
        //Search Query
        static function ceris_query($args) {    
            $the_query = new WP_Query($args);
            unset($args);
            wp_reset_postdata();                                                            
            return $the_query;
        }
    }
}
add_action('wp_ajax_nopriv_ceris_user_review_pagination', 'ceris_user_review_pagination');
add_action('wp_ajax_ceris_user_review_pagination', 'ceris_user_review_pagination');
if (!function_exists('ceris_user_review_pagination')) {
    function ceris_user_review_pagination()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $currentPageVal = isset( $_POST['currentPageVal'] ) ? $_POST['currentPageVal'] : null; 
        
        $postID = isset( $_POST['postID'] ) ? $_POST['postID'] : null;          
        $reviewPerPage = isset( $_POST['reviewPerPage'] ) ? $_POST['reviewPerPage'] : null;
        
        $reviewOffset = ($currentPageVal - 1) * $reviewPerPage;
        
        $readerReviewIDs = array();
        $readerReviewIDs = get_post_meta( $postID, 'atbs_reader_review_IDs', true );
        
        $returnData = '';
        $readerReviewIDsReverse = array_reverse($readerReviewIDs);
        foreach($readerReviewIDsReverse as $arrayKey => $readerReviewID) :
            if($arrayKey < $reviewOffset) {
                continue;
            }
            $returnData .= ceris_single::bk_get_user_review_on_article($postID, $readerReviewID);
            if($arrayKey == ($reviewOffset + $reviewPerPage - 1)) {
                break;
            }
        endforeach;
        
        die(json_encode($returnData));
    }
}
add_action('wp_ajax_nopriv_ceris_user_delete_review', 'ceris_user_delete_review');
add_action('wp_ajax_ceris_user_delete_review', 'ceris_user_delete_review');
if (!function_exists('ceris_user_delete_review')) {
    function ceris_user_delete_review()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        
        $formVal = isset( $_POST['formVal'] ) ? $_POST['formVal'] : null; 
        
        $postID = $formVal['postID'];
        $userID = $formVal['userID'];     
        
        $readerReviewIDs = get_post_meta( $postID, 'atbs_reader_review_IDs', true );
        if($readerReviewIDs == '') {
            $readerReviewIDs = array();
        }
        if( in_array(intval($userID), $readerReviewIDs)) {
            $key = array_search($userID, $readerReviewIDs);
            unset( $readerReviewIDs[$key] );
            $readerReviewIDs = array_values($readerReviewIDs);
            update_post_meta( $postID, 'atbs_reader_review_IDs', $readerReviewIDs );
            delete_post_meta( $postID, 'atbs_reader_review_DATA-'.$userID );
        }
        die(json_encode());
    }
}
add_action('wp_ajax_nopriv_ceris_user_review', 'ceris_user_review');
add_action('wp_ajax_ceris_user_review', 'ceris_user_review');
if (!function_exists('ceris_user_review')) {
    function ceris_user_review()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $formVal = isset( $_POST['formVal'] ) ? $_POST['formVal'] : null; 
        
        $postID = $formVal['postID'];
        $userID = $formVal['userID'];        
        
        $readerReviewIDs = get_post_meta( $postID, 'atbs_reader_review_IDs', true );
        
        if($readerReviewIDs == '') {
            $readerReviewIDs = array();
        }
        if( !in_array(intval($userID), $readerReviewIDs)) {
            array_push($readerReviewIDs, intval($userID));
            update_post_meta( $postID, 'atbs_reader_review_IDs', $readerReviewIDs );
            update_post_meta( $postID, 'atbs_reader_review_DATA-'.$userID, $formVal );
        }
        $dataReturn = ceris_single::bk_get_user_review_on_article($postID, $userID);
        die(json_encode($dataReturn));
    }
}

add_action('wp_ajax_nopriv_ceris_add_bookmark', 'ceris_add_bookmark');
add_action('wp_ajax_ceris_add_bookmark', 'ceris_add_bookmark');
if (!function_exists('ceris_add_bookmark')) {
    function ceris_add_bookmark()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $userID = isset( $_POST['userID'] ) ? $_POST['userID'] : null; 
        $postID = isset( $_POST['postID'] ) ? $_POST['postID'] : null; 
        
        $bookmarkData = get_user_meta( $userID, 'atbs_posts_bookmarked', true );
        
        if($bookmarkData == '') {
            $bookmarkData = array();
        }
        
        if( !in_array(intval($postID), $bookmarkData)) {
            array_push($bookmarkData, intval($postID));
            update_user_meta( $userID, 'atbs_posts_bookmarked', $bookmarkData );
        }
        
        die(json_encode($bookmarkData));
    }
}

add_action('wp_ajax_nopriv_ceris_grid_w', 'ceris_grid_w');
add_action('wp_ajax_ceris_grid_w', 'ceris_grid_w');
if (!function_exists('ceris_grid_w')) {
    function ceris_grid_w()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args       = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset + 3;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_grid_w;
            $dataReturn = $thismodule->render_grid_items($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_remove_bookmark', 'ceris_remove_bookmark');
add_action('wp_ajax_ceris_remove_bookmark', 'ceris_remove_bookmark');
if (!function_exists('ceris_remove_bookmark')) {
    function ceris_remove_bookmark()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $userID = isset( $_POST['userID'] ) ? $_POST['userID'] : null; 
        $postID = isset( $_POST['postID'] ) ? $_POST['postID'] : null; 
        
        $bookmarkData = get_user_meta( $userID, 'atbs_posts_bookmarked', true );
        
        if($bookmarkData == '') {
            $bookmarkData = array();
        }
        
        if( in_array(intval($postID), $bookmarkData)) {
            if (($key = array_search($postID, $bookmarkData)) !== false) {
                unset($bookmarkData[$key]);
            }

            update_user_meta( $userID, 'atbs_posts_bookmarked', $bookmarkData );
        }
        
        die(json_encode($bookmarkData));
    }
}

add_action('wp_ajax_nopriv_ceris_dismiss_article', 'ceris_dismiss_article');
add_action('wp_ajax_ceris_dismiss_article', 'ceris_dismiss_article');
if (!function_exists('ceris_dismiss_article')) {
    function ceris_dismiss_article()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $userID = isset( $_POST['userID'] ) ? $_POST['userID'] : null; 
        $postID = isset( $_POST['postID'] ) ? $_POST['postID'] : null; 
        
        $dismissData = get_user_meta( $userID, 'atbs_dismiss_articles', true );
        
        if($dismissData == '') {
            $dismissData = array();
        }
        
        if( !in_array(intval($postID), $dismissData)) {
            array_push($dismissData, intval($postID));
            update_user_meta( $userID, 'atbs_dismiss_articles', $dismissData );
        }
        
        die(json_encode($dismissData));
    }
}
add_action('wp_ajax_nopriv_ceris_remove_dismiss_article', 'ceris_remove_dismiss_article');
add_action('wp_ajax_ceris_remove_dismiss_article', 'ceris_remove_dismiss_article');
if (!function_exists('ceris_remove_dismiss_article')) {
    function ceris_remove_dismiss_article()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $userID = isset( $_POST['userID'] ) ? $_POST['userID'] : null; 
        $postID = isset( $_POST['postID'] ) ? $_POST['postID'] : null; 
        
        $dismissData = get_user_meta( $userID, 'atbs_dismiss_articles', true );
        
        if($dismissData == '') {
            $dismissData = array();
        }
        
        if( in_array(intval($postID), $dismissData)) {         
            $key = array_search($postID, $dismissData); // $key = 2;
            array_splice($dismissData, $key, 1);
            update_user_meta( $userID, 'atbs_dismiss_articles', $dismissData );
        }
        
        die(json_encode($dismissData));
    }
}
add_action('wp_ajax_nopriv_ceris_ajax_reaction', 'ceris_ajax_reaction');
add_action('wp_ajax_ceris_ajax_reaction', 'ceris_ajax_reaction');
if (!function_exists('ceris_ajax_reaction')) {
    function ceris_ajax_reaction()
    {
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $postID      = isset( $_POST['postID'] ) ? $_POST['postID'] : null;
        $reactionType = isset( $_POST['reactionType'] ) ? $_POST['reactionType'] : null;
        $reactionStatus = isset( $_POST['reactionStatus'] ) ? $_POST['reactionStatus'] : null;
        $dataKey = 'post-'.$postID.'-'.$reactionType;
        $dataVal = get_post_meta($postID, $dataKey, true);
        if(($reactionStatus == 'active') || ($reactionStatus == 'active-minus')):
            $dataVal -= 1;
        else:
            $dataVal += 1;
        endif;
        update_post_meta( $postID, $dataKey, $dataVal );
        die(json_encode($dataVal));
    }
}

add_action('wp_ajax_nopriv_ceris_author_results', 'ceris_author_results');
add_action('wp_ajax_ceris_author_results', 'ceris_author_results');
if (!function_exists('ceris_author_results')) {
    function ceris_author_results()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null; 
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null; 
        $args['offset'] = $postOffset;
        $dataReturn = 'no-result';
        
        $users = new WP_User_Query( $args );
        $users_found = $users->get_results();
        $user_count = count($users_found);
        
        if ( $user_count > 0 ) :
            $dataReturn = ceris_archive::bk_render_authors($users_found);
        else :
            $dataReturn = 'no-result';        
        endif;
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_listing_grid_overlay_aside', 'ceris_listing_grid_overlay_aside');
add_action('wp_ajax_ceris_listing_grid_overlay_aside', 'ceris_listing_grid_overlay_aside');
if (!function_exists('ceris_listing_grid_overlay_aside')) {
    function ceris_listing_grid_overlay_aside()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null; 
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) :
            $thismodule = new ceris_listing_grid_overlay_aside;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);

        else :
            $dataReturn = 'no-result';        
        endif;
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_listing_grid_vertical_aside', 'ceris_listing_grid_vertical_aside');
add_action('wp_ajax_ceris_listing_grid_vertical_aside', 'ceris_listing_grid_vertical_aside');
if (!function_exists('ceris_listing_grid_vertical_aside')) {
    function ceris_listing_grid_vertical_aside()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null; 
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) :
            $thismodule = new ceris_listing_grid_vertical_aside;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);

        else :
            $dataReturn = 'no-result';        
        endif;
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_block_fullwidth_two_sidebar_listing_list', 'ceris_block_fullwidth_two_sidebar_listing_list');
add_action('wp_ajax_ceris_block_fullwidth_two_sidebar_listing_list', 'ceris_block_fullwidth_two_sidebar_listing_list');
if (!function_exists('ceris_block_fullwidth_two_sidebar_listing_list')) {
    function ceris_block_fullwidth_two_sidebar_listing_list()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null; 
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) :
            $thismodule = new ceris_block_fullwidth_two_sidebar_listing_list;
            if($type == 'loadmore') :
                $dataReturn = $thismodule->render_modules($the_query, $the__lastPost, $moduleInfo);
            else :
                $dataReturn = $thismodule->render_modules($the_query, 0, $moduleInfo);
            endif;
        else :
            $dataReturn = 'no-result';        
        endif;
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_block_fullwidth_two_sidebar_listing_grid', 'ceris_block_fullwidth_two_sidebar_listing_grid');
add_action('wp_ajax_ceris_block_fullwidth_two_sidebar_listing_grid', 'ceris_block_fullwidth_two_sidebar_listing_grid');
if (!function_exists('ceris_block_fullwidth_two_sidebar_listing_grid')) {
    function ceris_block_fullwidth_two_sidebar_listing_grid()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null; 
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) :
            $thismodule = new ceris_block_fullwidth_two_sidebar_listing_grid;
            if($type == 'loadmore') :
                $dataReturn = $thismodule->render_modules($the_query, $the__lastPost, $moduleInfo);
            else :
                $dataReturn = $thismodule->render_modules($the_query, 0, $moduleInfo);
            endif;
        else :
            $dataReturn = 'no-result';        
        endif;
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_block_fullwidth_two_sidebar_listing_grid_b', 'ceris_block_fullwidth_two_sidebar_listing_grid_b');
add_action('wp_ajax_ceris_block_fullwidth_two_sidebar_listing_grid_b', 'ceris_block_fullwidth_two_sidebar_listing_grid_b');
if (!function_exists('ceris_block_fullwidth_two_sidebar_listing_grid_b')) {
    function ceris_block_fullwidth_two_sidebar_listing_grid_b()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null; 
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) :
            $thismodule = new ceris_block_fullwidth_two_sidebar_listing_grid_b;
            if($type == 'loadmore') :
                $dataReturn = $thismodule->render_modules($the_query, $the__lastPost, $moduleInfo);
            else :
                $dataReturn = $thismodule->render_modules($the_query, 0, $moduleInfo);
            endif;
        else :
            $dataReturn = 'no-result';        
        endif;
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_list_alt_a', 'ceris_posts_listing_list_alt_a');
add_action('wp_ajax_ceris_posts_listing_list_alt_a', 'ceris_posts_listing_list_alt_a');
if (!function_exists('ceris_posts_listing_list_alt_a')) {
    function ceris_posts_listing_list_alt_a()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null; 
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;    
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) :
            $thismodule = new ceris_posts_listing_list_alt_a;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        else :
            $dataReturn = 'no-result';        
        endif;
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_list_alt_a_no_sidebar', 'ceris_posts_listing_list_alt_a_no_sidebar');
add_action('wp_ajax_ceris_posts_listing_list_alt_a_no_sidebar', 'ceris_posts_listing_list_alt_a_no_sidebar');
if (!function_exists('ceris_posts_listing_list_alt_a_no_sidebar')) {
    function ceris_posts_listing_list_alt_a_no_sidebar()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null; 
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) :
            $thismodule = new ceris_posts_listing_list_alt_a_no_sidebar;
            if($type == 'loadmore') :
                $dataReturn = $thismodule->render_modules($the_query, $the__lastPost, $moduleInfo);
            else :
                $dataReturn = $thismodule->render_modules($the_query, 0, $moduleInfo);
            endif;
        else :
            $dataReturn = 'no-result';        
        endif;
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_list_alt_b_no_sidebar', 'ceris_posts_listing_list_alt_b_no_sidebar');
add_action('wp_ajax_ceris_posts_listing_list_alt_b_no_sidebar', 'ceris_posts_listing_list_alt_b_no_sidebar');
if (!function_exists('ceris_posts_listing_list_alt_b_no_sidebar')) {
    function ceris_posts_listing_list_alt_b_no_sidebar()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;    
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
    
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) :
            $thismodule = new ceris_posts_listing_list_alt_b_no_sidebar;
            if($type == 'loadmore') :
                $dataReturn = $thismodule->render_modules($the_query, $the__lastPost, $moduleInfo);
            else :
                $dataReturn = $thismodule->render_modules($the_query, 0, $moduleInfo);
            endif;
        else :
            $dataReturn = 'no-result';        
        endif;
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_list_alt_c_no_sidebar', 'ceris_posts_listing_list_alt_c_no_sidebar');
add_action('wp_ajax_ceris_posts_listing_list_alt_c_no_sidebar', 'ceris_posts_listing_list_alt_c_no_sidebar');
if (!function_exists('ceris_posts_listing_list_alt_c_no_sidebar')) {
    function ceris_posts_listing_list_alt_c_no_sidebar()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;    
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
    
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) :
            $thismodule = new ceris_posts_listing_list_alt_c_no_sidebar;
            if($type == 'loadmore') :
                $dataReturn = $thismodule->render_modules($the_query, $the__lastPost, $moduleInfo);
            else :
                $dataReturn = $thismodule->render_modules($the_query, 0, $moduleInfo);
            endif;
        else :
            $dataReturn = 'no-result';        
        endif;
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_list_alt_b', 'ceris_posts_listing_list_alt_b');
add_action('wp_ajax_ceris_posts_listing_list_alt_b', 'ceris_posts_listing_list_alt_b');
if (!function_exists('ceris_posts_listing_list_alt_b')) {
    function ceris_posts_listing_list_alt_b()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;    
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;      
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) :
            $thismodule = new ceris_posts_listing_list_alt_b;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        else :
            $dataReturn = 'no-result';        
        endif;
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_list_alt_c', 'ceris_posts_listing_list_alt_c');
add_action('wp_ajax_ceris_posts_listing_list_alt_c', 'ceris_posts_listing_list_alt_c');
if (!function_exists('ceris_posts_listing_list_alt_c')) {
    function ceris_posts_listing_list_alt_c()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;    
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) :
            $thismodule = new ceris_posts_listing_list_alt_c;
            if($type == 'loadmore') :
                $dataReturn = $thismodule->render_modules($the_query, $the__lastPost, $moduleInfo);
            else :
                $dataReturn = $thismodule->render_modules($the_query, 0, $moduleInfo);
            endif;
        else :
            $dataReturn = 'no-result';        
        endif;
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_list', 'ceris_posts_listing_list');
add_action('wp_ajax_ceris_posts_listing_list', 'ceris_posts_listing_list');
if (!function_exists('ceris_posts_listing_list')) {
    function ceris_posts_listing_list()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args       = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_list;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_list_b', 'ceris_posts_listing_list_b');
add_action('wp_ajax_ceris_posts_listing_list_b', 'ceris_posts_listing_list_b');
if (!function_exists('ceris_posts_listing_list_b')) {
    function ceris_posts_listing_list_b()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args       = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_list_b;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_list_large_a', 'ceris_posts_listing_list_large_a');
add_action('wp_ajax_ceris_posts_listing_list_large_a', 'ceris_posts_listing_list_large_a');
if (!function_exists('ceris_posts_listing_list_large_a')) {
    function ceris_posts_listing_list_large_a()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args       = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_list_large_a;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_list_large_a_no_sidebar', 'ceris_posts_listing_list_large_a_no_sidebar');
add_action('wp_ajax_ceris_posts_listing_list_large_a_no_sidebar', 'ceris_posts_listing_list_large_a_no_sidebar');
if (!function_exists('ceris_posts_listing_list_large_a_no_sidebar')) {
    function ceris_posts_listing_list_large_a_no_sidebar()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args       = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_list_large_a_no_sidebar;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_list_large_b', 'ceris_posts_listing_list_large_b');
add_action('wp_ajax_ceris_posts_listing_list_large_b', 'ceris_posts_listing_list_large_b');
if (!function_exists('ceris_posts_listing_list_large_b')) {
    function ceris_posts_listing_list_large_b()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args       = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_list_large_b;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_list_large_b_no_sidebar', 'ceris_posts_listing_list_large_b_no_sidebar');
add_action('wp_ajax_ceris_posts_listing_list_large_b_no_sidebar', 'ceris_posts_listing_list_large_b_no_sidebar');
if (!function_exists('ceris_posts_listing_list_large_b_no_sidebar')) {
    function ceris_posts_listing_list_large_b_no_sidebar()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args       = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_list_large_b_no_sidebar;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_list_large_c_no_sidebar', 'ceris_posts_listing_list_large_c_no_sidebar');
add_action('wp_ajax_ceris_posts_listing_list_large_c_no_sidebar', 'ceris_posts_listing_list_large_c_no_sidebar');
if (!function_exists('ceris_posts_listing_list_large_c_no_sidebar')) {
    function ceris_posts_listing_list_large_c_no_sidebar()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args       = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_list_large_c_no_sidebar;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_list_no_sidebar', 'ceris_posts_listing_list_no_sidebar');
add_action('wp_ajax_ceris_posts_listing_list_no_sidebar', 'ceris_posts_listing_list_no_sidebar');
if (!function_exists('ceris_posts_listing_list_no_sidebar')) {
    function ceris_posts_listing_list_no_sidebar()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args       = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_list_no_sidebar;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_list_b_no_sidebar', 'ceris_posts_listing_list_b_no_sidebar');
add_action('wp_ajax_ceris_posts_listing_list_b_no_sidebar', 'ceris_posts_listing_list_b_no_sidebar');
if (!function_exists('ceris_posts_listing_list_b_no_sidebar')) {
    function ceris_posts_listing_list_b_no_sidebar()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args       = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_list_b_no_sidebar;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_list_c_no_sidebar', 'ceris_posts_listing_list_c_no_sidebar');
add_action('wp_ajax_ceris_posts_listing_list_c_no_sidebar', 'ceris_posts_listing_list_c_no_sidebar');
if (!function_exists('ceris_posts_listing_list_c_no_sidebar')) {
    function ceris_posts_listing_list_c_no_sidebar()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args       = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_list_c_no_sidebar;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_list_d_no_sidebar', 'ceris_posts_listing_list_d_no_sidebar');
add_action('wp_ajax_ceris_posts_listing_list_d_no_sidebar', 'ceris_posts_listing_list_d_no_sidebar');
if (!function_exists('ceris_posts_listing_list_d_no_sidebar')) {
    function ceris_posts_listing_list_d_no_sidebar()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args       = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_list_d_no_sidebar;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_list_e_no_sidebar', 'ceris_posts_listing_list_e_no_sidebar');
add_action('wp_ajax_ceris_posts_listing_list_e_no_sidebar', 'ceris_posts_listing_list_e_no_sidebar');
if (!function_exists('ceris_posts_listing_list_e_no_sidebar')) {
    function ceris_posts_listing_list_e_no_sidebar()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args       = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_list_e_no_sidebar;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_list_f_no_sidebar', 'ceris_posts_listing_list_f_no_sidebar');
add_action('wp_ajax_ceris_posts_listing_list_f_no_sidebar', 'ceris_posts_listing_list_f_no_sidebar');
if (!function_exists('ceris_posts_listing_list_f_no_sidebar')) {
    function ceris_posts_listing_list_f_no_sidebar()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args       = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_list_f_no_sidebar;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_list_g_no_sidebar', 'ceris_posts_listing_list_g_no_sidebar');
add_action('wp_ajax_ceris_posts_listing_list_g_no_sidebar', 'ceris_posts_listing_list_g_no_sidebar');
if (!function_exists('ceris_posts_listing_list_g_no_sidebar')) {
    function ceris_posts_listing_list_g_no_sidebar()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args       = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_list_g_no_sidebar;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_grid', 'ceris_posts_listing_grid');
add_action('wp_ajax_ceris_posts_listing_grid', 'ceris_posts_listing_grid');
if (!function_exists('ceris_posts_listing_grid')) {
    function ceris_posts_listing_grid()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args       = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $type       = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_grid;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
           
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_grid_b', 'ceris_posts_listing_grid_b');
add_action('wp_ajax_ceris_posts_listing_grid_b', 'ceris_posts_listing_grid_b');
if (!function_exists('ceris_posts_listing_grid_b')) {
    function ceris_posts_listing_grid_b()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args       = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $type       = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_grid_b;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
           
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_grid_alt_a', 'ceris_posts_listing_grid_alt_a');
add_action('wp_ajax_ceris_posts_listing_grid_alt_a', 'ceris_posts_listing_grid_alt_a');
if (!function_exists('ceris_posts_listing_grid_alt_a')) {
    function ceris_posts_listing_grid_alt_a()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null; 
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_grid_alt_a;
            $dataReturn = $thismodule->render_modules($the_query, 0, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_grid_alt_b', 'ceris_posts_listing_grid_alt_b');
add_action('wp_ajax_ceris_posts_listing_grid_alt_b', 'ceris_posts_listing_grid_alt_b');
if (!function_exists('ceris_posts_listing_grid_alt_b')) {
    function ceris_posts_listing_grid_alt_b()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null; 
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_grid_alt_b;
            $dataReturn = $thismodule->render_modules($the_query, 0, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_grid_no_sidebar', 'ceris_posts_listing_grid_no_sidebar');
add_action('wp_ajax_ceris_posts_listing_grid_no_sidebar', 'ceris_posts_listing_grid_no_sidebar');
if (!function_exists('ceris_posts_listing_grid_no_sidebar')) {
    function ceris_posts_listing_grid_no_sidebar()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;    
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;    
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_grid_no_sidebar;
     
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);

        }else {
            $dataReturn = 'no-result';        
        }
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_grid_b_no_sidebar', 'ceris_posts_listing_grid_b_no_sidebar');
add_action('wp_ajax_ceris_posts_listing_grid_b_no_sidebar', 'ceris_posts_listing_grid_b_no_sidebar');
if (!function_exists('ceris_posts_listing_grid_b_no_sidebar')) {
    function ceris_posts_listing_grid_b_no_sidebar()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;    
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;    
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_grid_b_no_sidebar;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_grid_overlay_no_sidebar', 'ceris_posts_listing_grid_overlay_no_sidebar');
add_action('wp_ajax_ceris_posts_listing_grid_overlay_no_sidebar', 'ceris_posts_listing_grid_overlay_no_sidebar');
if (!function_exists('ceris_posts_listing_grid_overlay_no_sidebar')) {
    function ceris_posts_listing_grid_overlay_no_sidebar()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;    
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;    
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_grid_overlay_no_sidebar;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_grid_c_no_sidebar', 'ceris_posts_listing_grid_c_no_sidebar');
add_action('wp_ajax_ceris_posts_listing_grid_c_no_sidebar', 'ceris_posts_listing_grid_c_no_sidebar');
if (!function_exists('ceris_posts_listing_grid_c_no_sidebar')) {
    function ceris_posts_listing_grid_c_no_sidebar()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;    
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_grid_c_no_sidebar;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_grid_d_no_sidebar', 'ceris_posts_listing_grid_d_no_sidebar');
add_action('wp_ajax_ceris_posts_listing_grid_d_no_sidebar', 'ceris_posts_listing_grid_d_no_sidebar');
if (!function_exists('ceris_posts_listing_grid_d_no_sidebar')) {
    function ceris_posts_listing_grid_d_no_sidebar()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;    
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_grid_d_no_sidebar;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_grid_e_no_sidebar', 'ceris_posts_listing_grid_e_no_sidebar');
add_action('wp_ajax_ceris_posts_listing_grid_e_no_sidebar', 'ceris_posts_listing_grid_e_no_sidebar');
if (!function_exists('ceris_posts_listing_grid_e_no_sidebar')) {
    function ceris_posts_listing_grid_e_no_sidebar()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;    
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_grid_e_no_sidebar;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_grid_f_no_sidebar', 'ceris_posts_listing_grid_f_no_sidebar');
add_action('wp_ajax_ceris_posts_listing_grid_f_no_sidebar', 'ceris_posts_listing_grid_f_no_sidebar');
if (!function_exists('ceris_posts_listing_grid_f_no_sidebar')) {
    function ceris_posts_listing_grid_f_no_sidebar()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;    
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_grid_f_no_sidebar;
            $dataReturn = $thismodule->render_modules($the_query, 0, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_grid_small', 'ceris_posts_listing_grid_small');
add_action('wp_ajax_ceris_posts_listing_grid_small', 'ceris_posts_listing_grid_small');
if (!function_exists('ceris_posts_listing_grid_small')) {
    function ceris_posts_listing_grid_small()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;    
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_grid_small;
            $dataReturn = $thismodule->render_modules($the_query, 0, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_grid_small_b', 'ceris_posts_listing_grid_small_b');
add_action('wp_ajax_ceris_posts_listing_grid_small_b', 'ceris_posts_listing_grid_small_b');
if (!function_exists('ceris_posts_listing_grid_small_b')) {
    function ceris_posts_listing_grid_small_b()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;    
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_grid_small_b;
            $dataReturn = $thismodule->render_modules($the_query, 0, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_ceris_posts_listing_grid_small_no_sidebar', 'ceris_posts_listing_grid_small_no_sidebar');
add_action('wp_ajax_ceris_posts_listing_grid_small_no_sidebar', 'ceris_posts_listing_grid_small_no_sidebar');
if (!function_exists('ceris_posts_listing_grid_small_no_sidebar')) {
    function ceris_posts_listing_grid_small_no_sidebar()
    {        
        check_ajax_referer( 'ceris_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;    
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = ceris_ajax_post_list::ceris_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new ceris_posts_listing_grid_small_no_sidebar;
            $dataReturn = $thismodule->render_modules($the_query, 0, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
        
    }
}