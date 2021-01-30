<?php
    $ceris_option = ceris_core::bk_get_global_var('ceris_option');
    
    if(function_exists('bk_set__cookie')) {
        $ceris_cookie = bk_set__cookie();
    }else {
        $ceris_cookie = 1;
    }
    
    get_header('single');
    
    if ( have_posts() ) : while ( have_posts() ) : the_post(); 
    
    $postID = get_the_ID();  
    
    if ($ceris_cookie == 1) {
        ceris_core::bk_setPostViews($postID);
    }
 
    if(function_exists('has_post_format')):
        $postFormat = get_post_format($postID);
    else :
        $postFormat = 'standard';
    endif;
    
    $finalPostLayout = ceris_single::bk_get_single_post_layout($postID);
    if($finalPostLayout == '') {
        $finalPostLayout = 'single-1';
    }       
    
    get_template_part( '/library/templates/single/partials/'.$finalPostLayout ); //single-1        

    endwhile; endif;
    
    get_footer(); 
?>