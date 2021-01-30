<?php
if (!class_exists('ceris_single')) {
    class ceris_single {
        
        static $related_query = '';
        static $samecat_query = '';
    /**
     * ************* Get Single Post Content Word Count *****************
     *---------------------------------------------------
     */
    static function ceris_get_num_of_words($string) {
        $string = preg_replace('/\s+/', ' ', trim($string));
        $words = explode(" ", $string);
        return count($words);
    }
     static function article_wcount($postID){
        $content = apply_filters( 'the_content', get_the_content('', '', intval($postID)));
        return self::ceris_get_num_of_words($content);
    }
    /**
     * ************* Get Single Post Layout *****************
     *---------------------------------------------------
     */
        static function bk_get_single_post_layout($postID) {
            $ceris_option = ceris_core::bk_get_global_var('ceris_option');
            $bkPostLayout = get_post_meta($postID,'bk_post_layout_standard',true);
            
            if (isset($ceris_option) && ($ceris_option != '')): 
                $bk_single_template = $ceris_option['bk-single-template'];
            else :
                $bk_single_template = '';
            endif;
            
            if(function_exists('has_post_format')):
                $postFormat = get_post_format($postID);
            else :
                $postFormat = 'standard';
            endif;
            
            $sidebar_option = '';
            $sidebar        =  ceris_single::bk_get_post_option($postID, 'bk_post_sb_select'); 
            if((!is_active_sidebar($sidebar)) || ($sidebar == '')) {
                $sidebar_option = 'disable';
            }
            
            if(($bkPostLayout == 'global_settings') || ($bkPostLayout == '')) {
                $finalPostLayout = $bk_single_template;
            }else {
                $finalPostLayout = $bkPostLayout;
            }
            if($finalPostLayout == '') {
                $finalPostLayout = 'single-1';
            }
        
            if($finalPostLayout == 'single-1') {
                if($sidebar_option != 'disable') {
                    return $finalPostLayout;
                }else {
                    $finalPostLayout = 'single-no-sidebar-1';
                }
            }else if($finalPostLayout == 'single-2') {
                if($sidebar_option != 'disable') {
                    return $finalPostLayout;
                }else {
                    $finalPostLayout = 'single-no-sidebar-1';
                }
            }else if($finalPostLayout == 'single-3') {
                return $finalPostLayout;
            }else if($finalPostLayout == 'single-4') {
                if($sidebar_option != 'disable') {
                    return $finalPostLayout;
                }else {
                    $finalPostLayout = 'single-no-sidebar-2';
                }
            }else if($finalPostLayout == 'single-5') {
                if($sidebar_option != 'disable') {
                    return $finalPostLayout;
                }else {
                    $finalPostLayout = 'single-6';
                }
            }else if($finalPostLayout == 'single-6') {
                return $finalPostLayout;
            }else if($finalPostLayout == 'single-7') {
                if($sidebar_option != 'disable') {
                    return $finalPostLayout;
                }else {
                    $finalPostLayout = 'single-8';
                }
            }else if($finalPostLayout == 'single-8') {
                return $finalPostLayout;
            }else if($finalPostLayout == 'single-9') {
                if($sidebar_option != 'disable') {
                    return $finalPostLayout;
                }else {
                    $finalPostLayout = 'single-10';
                }
            }else if($finalPostLayout == 'single-10') {
                return $finalPostLayout;
            }else if($finalPostLayout == 'single-11') {
                if($sidebar_option != 'disable') {
                    return $finalPostLayout;
                }else {
                    $finalPostLayout = 'single-13';
                }
            }else if($finalPostLayout == 'single-12') {
                if($sidebar_option != 'disable') {
                    return $finalPostLayout;
                }else {
                    $finalPostLayout = 'single-13';
                }
            }else if($finalPostLayout == 'single-13') {
                return $finalPostLayout;
            }else if($finalPostLayout == 'single-14') {
                if($sidebar_option != 'disable') {
                    return $finalPostLayout;
                }else {
                    $finalPostLayout = 'single-16';
                }
            }else if($finalPostLayout == 'single-15') {
                if($sidebar_option != 'disable') {
                    return $finalPostLayout;
                }else {
                    $finalPostLayout = 'single-16';
                }
            }else if($finalPostLayout == 'single-16') {
                return $finalPostLayout;
            }else if($finalPostLayout == 'single-18') {
                if($sidebar_option != 'disable') {
                    return $finalPostLayout;
                }else {
                    $finalPostLayout = 'single-no-sidebar-3';
                }
            }else if($finalPostLayout == 'single-17') {
                if($postFormat != 'video') :
                    if($sidebar_option != 'disable') {
                        $finalPostLayout = 'single-1';
                    }else {
                        $finalPostLayout = 'single-no-sidebar-1';
                    }
                else :
                    if($sidebar_option != 'disable') {
                        return $finalPostLayout; //single-7 - Video
                    }else {
                        $finalPostLayout = 'single-no-sidebar-4';
                    }
                endif;        
            }else {
                $finalPostLayout = $bk_single_template;
            }
            
            return $finalPostLayout;
        }
        
        static function bk_entry_media($postID){
            if(function_exists('has_post_format')){
                $postFormat = get_post_format($postID);
            }else {
                $postFormat = 'standard';
            }
            $htmlOutput = '';
            if($postFormat == 'video'){
                $bkURL = get_post_meta($postID, 'bk_video_media_link', true);
                $htmlOutput .= ceris_core::bk_get_video_media($bkURL);                
            }else if($postFormat == 'gallery'){
                $galleryType = get_post_meta($postID, 'bk_gallery_type', true);
                if($galleryType == 'gallery-1') {
                    $htmlOutput .= ceris_core::bk_get_gallery_1($postID);
                }else if($galleryType == 'gallery-2') {
                    $htmlOutput .= ceris_core::bk_get_gallery_2($postID);
                }else if($galleryType == 'gallery-3') {
                    $htmlOutput .= ceris_core::bk_get_gallery_3($postID);
                }else if($galleryType == 'gallery-4') {
                    $htmlOutput .= ceris_core::bk_get_gallery_4($postID);
                }else {
                    $htmlOutput .= ceris_core::bk_get_gallery_1($postID);
                }
            }else {
                $htmlOutput = '';
            }
            return $htmlOutput;
        }
        static function bk_author_box($authorID){
            $bk_author_email = get_the_author_meta('publicemail', $authorID);
            $bk_author_name = get_the_author_meta('display_name', $authorID);
            $bk_author_tw = get_the_author_meta('twitter', $authorID);
            $bk_author_fb = get_the_author_meta('facebook', $authorID);
            $bk_author_yo = get_the_author_meta('youtube', $authorID);
            $bk_author_instagram = get_the_author_meta('instagram', $authorID);
            $bk_author_linkedin = get_the_author_meta('linkedin', $authorID);
            $bk_author_pinterest = get_the_author_meta('pinterest', $authorID);
            $bk_author_dribbble = get_the_author_meta('dribbble', $authorID);
            $bk_author_www = get_the_author_meta('url', $authorID);
            $bk_author_desc = get_the_author_meta('description', $authorID);
            $bk_author_posts = count_user_posts( $authorID ); 
    
            $authorImgALT = $bk_author_name;
            $authorArgs = array(
                'class' => 'avatar photo',
            );
            
            $htmlOutput = '';
            if (($bk_author_desc != NULL) || ($bk_author_email != NULL) || ($bk_author_tw != NULL) || ($bk_author_fb != NULL) ||($bk_author_yo != NULL) ||($bk_author_instagram != NULL) ||($bk_author_linkedin != NULL) ||($bk_author_dribbble != NULL) ||($bk_author_dribbble != NULL)) :
                $htmlOutput .= '<div class="author-box">';
                $htmlOutput .= '<div class="author-avatar">';
                $htmlOutput .= get_avatar($authorID, '180', '', esc_attr($authorImgALT), $authorArgs);
                $htmlOutput .= '</div>';
                $htmlOutput .= '<div class="author-box__text">';
                $htmlOutput .= '<div class="author-name">';
                $htmlOutput .= '<a href="'.get_author_posts_url($authorID).'" class="entry-author__name" title="Posts by '.esc_attr($bk_author_name).'" rel="author">'.esc_attr($bk_author_name).'</a>';
                $htmlOutput .= '</div>';
                if($bk_author_desc != ''):
                    $htmlOutput .= '<div class="author-bio">';
                    $htmlOutput .= $bk_author_desc;
                    $htmlOutput .= '</div>';
                endif;
                $htmlOutput .= '<ul class="author-social list-horizontal">';
                if (($bk_author_email != NULL) || ($bk_author_tw != NULL) || ($bk_author_fb != NULL) ||($bk_author_yo != NULL) ||($bk_author_instagram != NULL) ||($bk_author_linkedin != NULL) ||($bk_author_pinterest != NULL) ||($bk_author_dribbble != NULL)) {
                    if ($bk_author_email != NULL) { $htmlOutput .= '<li><a href="mailto:'. esc_attr($bk_author_email) .'"><i class="mdicon mdicon-mail_outline"></i><span class="sr-only">e-mail</span></a></li>'; } 
                    if ($bk_author_www != NULL) { $htmlOutput .= ' <li><a href="'. esc_url($bk_author_www) .'" target="_blank"><i class="mdicon mdicon-public"></i><span class="sr-only">Website</span></a></li>'; } 
                    if ($bk_author_tw != NULL) { $htmlOutput .= ' <li><a href="'. esc_url($bk_author_tw).'" target="_blank" ><i class="mdicon mdicon-twitter"></i><span class="sr-only">Twitter</span></a></li>'; } 
                    if ($bk_author_fb != NULL) { $htmlOutput .= ' <li><a href="'. esc_url($bk_author_fb) . '" target="_blank" ><i class="mdicon mdicon-facebook"></i><span class="sr-only">Facebook</span></a></li>'; }
                    if ($bk_author_yo != NULL) { $htmlOutput .= ' <li><a href="'. esc_url($bk_author_yo) . '" target="_blank" ><i class="mdicon mdicon-youtube"></i><span class="sr-only">Youtube</span></a></li>'; }
                    if ($bk_author_instagram != NULL) { $htmlOutput .= ' <li><a href="'. esc_url($bk_author_instagram) . '" target="_blank" ><i class="mdicon mdicon-instagram"></i><span class="sr-only">Instagram</span></a></li>'; }
                    if ($bk_author_linkedin != NULL) { $htmlOutput .= ' <li><a href="'. esc_url($bk_author_linkedin) . '" target="_blank" ><i class="mdicon mdicon-linkedin"></i><span class="sr-only">Linkedin</span></a></li>'; }
                    if ($bk_author_pinterest != NULL) { $htmlOutput .= ' <li><a href="'. esc_url($bk_author_pinterest) . '" target="_blank" ><i class="mdicon mdicon-pinterest-p"></i><span class="sr-only">Pinterest</span></a></li>'; }
                    if ($bk_author_dribbble != NULL) { $htmlOutput .= ' <li><a href="'. esc_url($bk_author_dribbble) . '" target="_blank" ><i class="mdicon mdicon-dribbble"></i><span class="sr-only">Dribbble</span></a></li>'; }
                }                       
                $htmlOutput .= '</ul>';
                $htmlOutput .= '</div>';
                $htmlOutput .= '</div>';
            endif;
            
            return $htmlOutput;
        }
        static function bk_post_navigation($navStyle = ''){
            $next_post = get_next_post();
            $prev_post = get_previous_post();
            
            $postNothumbHTML = new  ceris_post_nothumb_1; 
            $postNothumbAttr_L = array (
                'additionalTextClass' => 'text-right',
                'typescale'           => '',
                
            );
            $postNothumbAttr_R = array (
                'additionalTextClass' => 'text-left',
                'typescale'           => '',
                
            );
            
            
            
            $htmlOutput = '';
            if ((!empty($prev_post)) || (!empty($next_post))):
                $htmlOutput .= '<!-- Posts navigation -->';
                $htmlOutput .= '<div class="posts-navigation">';
                if (!empty($prev_post)):
                    $htmlOutput .= '<div class="posts-navigation__prev clearfix">';
                    $htmlOutput .= '<a class="posts-navigation__label text-right" href="'.get_permalink( $prev_post->ID ).'">
                                    <span>'.esc_html__('Previous', 'ceris').'</span>
                                    </a>';
                    $postNothumbAttr_L['postID'] = $prev_post->ID;
                    $htmlOutput .= $postNothumbHTML->render($postNothumbAttr_L);                          
                    $htmlOutput .= '</div><!-- posts-navigation__prev-->';
                endif;
                if (!empty($next_post)):
                    $htmlOutput .= '<div class="posts-navigation__next clearfix">';
                    $htmlOutput .= '<a class="posts-navigation__label text-left" href="'.get_permalink( $next_post->ID ).'"><span>'.esc_html__('Next', 'ceris').'</span></a>';
                    $postNothumbAttr_R['postID'] = $next_post->ID;
                    $htmlOutput .= $postNothumbHTML->render($postNothumbAttr_R);
                    $htmlOutput .= '</div><!-- posts-navigation__next -->';
                endif;
                $htmlOutput .= '</div>';
                $htmlOutput .= '<!-- Posts navigation -->';
            endif;
            return $htmlOutput;
        }
    /**
     * ************* Get Post Option *****************
     *---------------------------------------------------
     */
        static function bk_get_post_option($postID, $theoption = '') {
            $ceris_option = ceris_core::bk_get_global_var('ceris_option');
            $output = '';
            
            if($theoption != '') :
                $output = get_post_meta($postID, $theoption, true);
                if(($output == 'global_settings') || ($output == '')):
                    if(isset($ceris_option[$theoption])) {
                        $output = $ceris_option[$theoption];
                    }else {
                        $output = '';
                    }
                endif;
            endif;
            
            return $output;
        }
     /**
     * ************* Get Post Option *****************
     *---------------------------------------------------
     */
        static function bk_get_post_wide_option($postID, $theoption = '') {
            $ceris_option = ceris_core::bk_get_global_var('ceris_option');
            $output = '';
            
            if($theoption != '') :
                $output = get_post_meta($postID, $theoption, true);
                if(($output == 'global_settings') || ($output == '')):
                    if(isset($ceris_option[$theoption.'-wide'])) {
                        $output = $ceris_option[$theoption.'-wide'];
                    }else {
                        $output = '';
                    }
                endif;
            endif;
            
            return $output;
        }        
     /**
     * ************* Get Previous Post *****************
     *---------------------------------------------------
     */
        static function bk_get_previous_post($postID) {
            $returnPost = null;
            $ceris_option = ceris_core::bk_get_global_var('ceris_option');
            $output = '';
            
            $theTerm = isset($ceris_option['bk-infinity-scrolling-term']) ? $ceris_option['bk-infinity-scrolling-term'] : 'next';
            $excludeTermIDs = isset($ceris_option['infinity_scrolling_exclude']) ? $ceris_option['infinity_scrolling_exclude'] : '';
            
            if($theTerm == 'next_same_categories') :
                $returnPost = get_previous_post(true, $excludeTermIDs, 'category');
            else:
                $returnPost = get_previous_post();
            endif;
            
            return $returnPost;
        }
    /**
     * ************* Related Post *****************
     *---------------------------------------------------
     */            
        static function bk_related_post($post) {
            $postID = $post->ID;
            $ceris_option = ceris_core::bk_get_global_var('ceris_option');
            
            $excludeid = array();
            $samecat_post_ids = array();
            
            if(self::$samecat_query != '') {
                $samecat_post_ids = wp_list_pluck( self::$samecat_query->posts, 'ID' );
            }
            
            array_push($excludeid, $postID);
            
            if(count($samecat_post_ids) > 0) {
                foreach($samecat_post_ids as $samecat_post_id):
                    array_push($excludeid, $samecat_post_id);
                endforeach;
            }
            
            $bkSingleLayout = get_post_meta($postID,'bk_post_layout_standard',true);
            
            if($bkSingleLayout != 'global_settings') :
                $bkRelatedSource    =  self::bk_get_post_option($postID, 'bk_related_source');
                $bk_number_related  =  self::bk_get_post_option($postID, 'bk_number_related');
                $headingStyle       =  self::bk_get_post_option($postID, 'bk_related_heading_style');
                $postLayout         =  self::bk_get_post_option($postID, 'bk_related_post_layout');
                $postIcon           =  self::bk_get_post_option($postID, 'bk_related_post_icon');
                $postIconAnimation           =  self::bk_get_post_option($postID, 'bk_related_post_icon_animation');
            else:
                $bkRelatedSource    =  $ceris_option['bk_related_source'];
                $bk_number_related  =  $ceris_option['bk_number_related'];
                $headingStyle       =  $ceris_option['bk_related_heading_style'];
                $postLayout         =  $ceris_option['bk_related_post_layout'];
                $postIcon           =  $ceris_option['bk_related_post_icon'];
                $postIconAnimation  =  $ceris_option['bk_related_post_icon_animation'];
            endif;
            
            if (is_attachment() && ($post->post_parent)) { $postID = $post->post_parent; };
            
            $bk_tags = wp_get_post_tags($postID);
            $tag_length = sizeof($bk_tags);                               
            $bk_tag_check = $bk_all_cats = array();
            foreach ( $bk_tags as $tag_key => $bk_tag ) { $bk_tag_check[$tag_key] = $bk_tag->term_id; }    
            
            $bk_categories = get_the_category($postID);  
            $category_length = sizeof($bk_categories);
            if ($category_length > 0){       
                foreach ( $bk_categories as $category_key => $bk_category ) { $bk_all_cats[$category_key] = $bk_category->term_id; }
            }
            
            if($bkRelatedSource == 'category_tag') {
                $args = array(  
                    'posts_per_page' => intval($bk_number_related),
                    'post__not_in' => $excludeid,
                    'post_status' => 'publish',
                    'post_type' => 'post',
        			'ignore_sticky_posts' => 1,
                    'tax_query' => array(
                        'relation' => 'OR',
                        array(
                            'taxonomy' => 'category',
                            'field' => 'term_id',
                            'terms' => $bk_all_cats,
                            'include_children' => false,
                        ),
                        array(
                            'taxonomy' => 'post_tag',
                            'field' => 'term_id',
                            'terms' => $bk_tag_check,
                        )
                    )
                );
            }elseif($bkRelatedSource == 'tag') {
                $args = array(  
                    'posts_per_page' => intval($bk_number_related),
                    'tag_in' => $bk_tag_check, 
                    'post__not_in' => $excludeid,
                    'post_status' => 'publish',
                    'orderby' => 'rand',
                    'ignore_sticky_posts' => 1,
                );
            }elseif($bkRelatedSource == 'category') {
                $args = array(  
                    'posts_per_page' => intval($bk_number_related),
                    'post__not_in'   => $excludeid,
                    'post_status'    => 'publish',
                    'post_type'      => 'post',
        			'ignore_sticky_posts' => 1,
                    'category__in'        => $bk_all_cats,
                );
            }elseif($bkRelatedSource == 'author') {
                $args = array(  
                    'posts_per_page'    => intval($bk_number_related),
                    'post__not_in'      => $excludeid,
                    'post_status'       => 'publish',
                    'post_type'         => 'post',
        			'ignore_sticky_posts' => 1,
                    'author'              => $post->post_author
                );
            }
            
            $moduleInfo = array(
                'align'         => '',
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'post_icon_animation'   => $postIconAnimation,
                'bookmark'      => array(),
                'bookmarkTmp'   => array(),
            );
            
            if(isset($headingStyle)) {
                $headingClass = ceris_core::bk_get_block_heading_class($headingStyle);
            }
            if(isset($ceris_option['single-section-heading-font']['font-size']) && ($ceris_option['single-section-heading-font']['font-size'] != '')) {
                $headingFontSize = intval($ceris_option['single-section-heading-font']['font-size'], 10);
                $headingFontSizeClass = ' '.ceris_core::bk_detect_heading_size($headingFontSize);
            }else {
                $headingFontSizeClass = '';
            }
            
            $the_query = new WP_Query( $args );
            
            if (empty($the_query) || ($the_query->post_count == 0)) {
                return '';
            }
            
            self::$related_query = $the_query;
            
            $bk_related_output = '';
            
            $bk_related_output .= '<div class="related-posts single-entry-section'.$headingFontSizeClass.'">';
            $bk_related_output .= '<div class="block-heading '.$headingClass.'">';
        	$bk_related_output .= '<h4 class="block-heading__title">'.esc_html__('You may also like', 'ceris').'</h4>';
        	$bk_related_output .= '</div>';
            
            if ( $the_query != NULL ) {
                $bk_related_output .= self::bk_get_blog_posts($the_query, $moduleInfo, $postLayout);
            }    
            $bk_related_output .= '</div>';
            
            wp_reset_postdata();    
            return $bk_related_output;
        }
    /**
     * ************* Related Post *****************
     *---------------------------------------------------
     */            
        static function bk_related_post_wide($post) {
            $postID = $post->ID;
            $ceris_option = ceris_core::bk_get_global_var('ceris_option');
            
            $excludeid = array();
            $samecat_post_ids = array();
            
            if(self::$samecat_query != '') {
                $samecat_post_ids = wp_list_pluck( self::$samecat_query->posts, 'ID' );
            }
            
            array_push($excludeid, $postID);
            
            if(count($samecat_post_ids) > 0) {
                foreach($samecat_post_ids as $samecat_post_id):
                    array_push($excludeid, $samecat_post_id);
                endforeach;
            }
            
            $bkSingleLayout = get_post_meta($postID,'bk_post_layout_standard',true);
            
            if($bkSingleLayout != 'global_settings') :
                $bkRelatedSource    =  self::bk_get_post_option($postID, 'bk_related_source_wide');
                $headingStyle       =  self::bk_get_post_option($postID, 'bk_related_heading_style_wide');
                $postLayout         =  self::bk_get_post_option($postID, 'bk_related_post_layout_wide');
                $postIcon           =  self::bk_get_post_option($postID, 'bk_related_post_icon_wide');
                $postIconAnimation  =  self::bk_get_post_option($postID, 'bk_related_post_icon_animation_wide');
            else:
                $bkRelatedSource    =  $ceris_option['bk_related_source_wide'];
                $headingStyle       =  $ceris_option['bk_related_heading_style_wide'];
                $postLayout         =  $ceris_option['bk_related_post_layout_wide'];
                $postIcon           =  $ceris_option['bk_related_post_icon_wide'];
                $postIconAnimation  =  $ceris_option['bk_related_post_icon_animation_wide'];
            endif;
            
            $postEntries        = 3;
            if (is_attachment() && ($post->post_parent)) { $postID = $post->post_parent; };
            
            $bk_tags = wp_get_post_tags($postID);
            $tag_length = sizeof($bk_tags);                               
            $bk_tag_check = $bk_all_cats = array();
            
            if ($tag_length > 0){       
                foreach ( $bk_tags as $tag_key => $bk_tag ) { $bk_tag_check[$tag_key] = $bk_tag->term_id; }    
            }
            
            $bk_categories = get_the_category($postID);  
            $category_length = sizeof($bk_categories);
            if ($category_length > 0){       
                foreach ( $bk_categories as $category_key => $bk_category ) { $bk_all_cats[$category_key] = $bk_category->term_id; }
            }
            
            switch($postLayout){
                case 'listing_grid_no_sidebar':
                    $postEntries = 6;
                    break;
                default:
                    $postEntries = 3;
                    break;
            }
            if($bkRelatedSource == 'category_tag') {
                $args = array(  
                    'posts_per_page' => intval($postEntries),
                    'post__not_in' => $excludeid,
                    'post_status' => 'publish',
                    'post_type' => 'post',
        			'ignore_sticky_posts' => 1,
                    'tax_query' => array(
                        'relation' => 'OR',
                        array(
                            'taxonomy' => 'category',
                            'field' => 'term_id',
                            'terms' => $bk_all_cats,
                            'include_children' => false,
                        ),
                        array(
                            'taxonomy' => 'post_tag',
                            'field' => 'term_id',
                            'terms' => $bk_tag_check,
                        )
                    )
                );
            }elseif($bkRelatedSource == 'tag') {
                $args = array(  
                    'posts_per_page' => intval($postEntries),
                    'tag_in' => $bk_tag_check, 
                    'post__not_in' => $excludeid,
                    'post_status' => 'publish',
                    'orderby' => 'rand',
                    'ignore_sticky_posts' => 1,
                );
            }elseif($bkRelatedSource == 'category') {
                $args = array(  
                    'posts_per_page' => intval($postEntries),
                    'post__not_in'   => $excludeid,
                    'post_status'    => 'publish',
                    'post_type'      => 'post',
        			'ignore_sticky_posts' => 1,
                    'category__in'        => $bk_all_cats,
                );
            }elseif($bkRelatedSource == 'author') {
                $args = array(  
                    'posts_per_page'    => intval($postEntries),
                    'post__not_in'      => $excludeid,
                    'post_status'       => 'publish',
                    'post_type'         => 'post',
        			'ignore_sticky_posts' => 1,
                    'author'              => $post->post_author
                );
            }
            $moduleInfo = array(
                'align'         => '',
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'post_icon_animation' => $postIconAnimation,
                'iconPosition'  => '',
                'meta'          => '',
                'cat'           => '',
                'excerpt'       => '',
                'bookmark'      => array(),
                'bookmarkTmp'   => array(),
            );

            if(isset($headingStyle)) {
                $headingClass = ceris_core::bk_get_block_heading_class($headingStyle);
            }
            
            if(isset($ceris_option['single-section-heading-font']['font-size']) && ($ceris_option['single-section-heading-font']['font-size'] != '')) {
                $headingFontSize = intval($ceris_option['single-section-heading-font']['font-size'], 10);
                $headingFontSizeClass = ' '.ceris_core::bk_detect_heading_size($headingFontSize);
            }else {
                $headingFontSizeClass = '';
            }
            
            $the_query = new WP_Query( $args );
            
            if (empty($the_query) || ($the_query->post_count == 0)) {
                return '';
            }
            
            self::$related_query = $the_query;
            
            $bk_related_output = '';
            
            $bk_related_output .= '<div class="atbs-ceris-block atbs-ceris-block--fullwidth related-posts has-background lightgray-bg">';
            
            
            if ( $the_query != NULL ) {
                
                if((($postLayout) != 'listing_grid' ) && (($postLayout) != 'listing_grid_no_sidebar') && (($postLayout) != 'listing_grid_small') && (($postLayout) != 'listing_grid_b_no_sidebar') ):
                    $bk_related_output .= '<div class="container container--narrow'.$headingFontSizeClass.'">';
                    $bk_related_output .= '<div class="block-heading '.$headingClass.'">';
                	$bk_related_output .= '<h4 class="block-heading__title">'.esc_html__('You may also like', 'ceris').'</h4>';
                    $bk_related_output .= '</div>';
                    $bk_related_output .= self::bk_get_blog_posts($the_query, $moduleInfo, $postLayout);
                    $bk_related_output .= '</div><!--.container-->';
                else:
                    $bk_related_output .= '<div class="container'.$headingFontSizeClass.'">';
                    $bk_related_output .= '<div class="block-heading '.$headingClass.'">';
                	$bk_related_output .= '<h4 class="block-heading__title">'.esc_html__('You may also like', 'ceris').'</h4>';
                    $bk_related_output .= '</div>';
                    $bk_related_output .= self::bk_get_blog_posts($the_query, $moduleInfo, $postLayout);
                    $bk_related_output .= '</div><!--.container-->';
                endif;
            }    
            $bk_related_output .= '</div><!-- .atbs-ceris-block -->';
            
            wp_reset_postdata();    
            return $bk_related_output;
        }
        static function bk_same_category_posts($post) {
            $postID = $post->ID;
            $excludeid = array();
            $related_post_ids = array();
            
            if(self::$related_query != ''):
                $related_post_ids = wp_list_pluck( self::$related_query->posts, 'ID' );
            endif;
            
            array_push($excludeid, $postID);
            
            if(count($related_post_ids) > 0) {
                foreach($related_post_ids as $related_post_id):
                    array_push($excludeid, $related_post_id);
                endforeach;
            }
            
            $catID       = self::bk_get_post_option($postID, 'bk_same_cat_id');
            if($catID == '') {
                $catID = 'current_cat';
            }
            if($catID == 'disable') {
                return '';
            }
            if($catID == 'current_cat') {
                $category = get_the_category($postID); 
                if(isset($category[0]) && $category[0]){
                    $catID = $category[0]->term_id;  
                }
                else {
                    return '';
                }
            }      
            
            $ceris_option = ceris_core::bk_get_global_var('ceris_option');
            $bkSingleLayout = get_post_meta($postID,'bk_post_layout_standard',true);
            
            if($bkSingleLayout != 'global_settings') :
                $headingStyle       =  self::bk_get_post_option($postID, 'bk_same_cat_heading_style');    
                $postLayout         =  self::bk_get_post_option($postID, 'bk_same_cat_post_layout');
                $postEntries        =  self::bk_get_post_option($postID, 'bk_same_cat_number_posts');            
                $postIcon           =  self::bk_get_post_option($postID, 'bk_same_cat_post_icon');
                $postIconAnimation  =  self::bk_get_post_option($postID, 'bk_same_cat_post_icon_animation');
                $moreLink           =  self::bk_get_post_option($postID, 'bk_same_cat_more_link');
            else:
                $headingStyle       =  $ceris_option['bk_same_cat_heading_style'];    
                $postLayout         =  $ceris_option['bk_same_cat_post_layout'];
                $postEntries        =  $ceris_option['bk_same_cat_number_posts'];            
                $postIcon           =  $ceris_option['bk_same_cat_post_icon'];
                $postIconAnimation  =  $ceris_option['bk_same_cat_post_icon_animation'];
                $moreLink           =  $ceris_option['bk_same_cat_more_link'];
            endif;
            
            if(isset($headingStyle)) {
                $headingClass = ceris_core::bk_get_block_heading_class($headingStyle);
            }
            
            if(isset($ceris_option['single-section-heading-font']['font-size']) && ($ceris_option['single-section-heading-font']['font-size'] != '')) {
                $headingFontSize = intval($ceris_option['single-section-heading-font']['font-size'], 10);
                $headingFontSizeClass = ' '.ceris_core::bk_detect_heading_size($headingFontSize);
            }else {
                $headingFontSizeClass = '';
            }
            
            $bk_all_cats = array();
            $bk_categories = get_the_category($postID);  
            $category_length = sizeof($bk_categories);
            if ($category_length > 0){       
                foreach ( $bk_categories as $category_key => $bk_category ) { $bk_all_cats[$category_key] = $bk_category->term_id; }
            }
            
            $moduleInfo = array(
                'align'         => '',
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'post_icon_animation'     => $postIconAnimation,
                'bookmark'      => array(),
                'bookmarkTmp'   => array(),
            );
                        
            $args = array(  
                'posts_per_page' => $postEntries,
                'post__not_in'   => $excludeid,
                'post_status'    => 'publish',
                'post_type'      => 'post',
    			'ignore_sticky_posts' => 1,
                'category__in'        => $catID,
            );
            
            $the_query = new WP_Query( $args );
            
            self::$samecat_query = $the_query;
            
            if (empty($the_query) || ($the_query->post_count == 0)) {
                return '';
            }
            
            $dataOutput = '';
            $dataOutput .= '<div class="same-category-posts single-entry-section'.$headingFontSizeClass.'">';
            $dataOutput .= '<div class="block-heading '.$headingClass.'">';
        	$dataOutput .= '<h4 class="block-heading__title">'.esc_html__('More in:', 'ceris').'<a href="'.get_category_link($catID).'" class="cat-'.$catID.' cat-theme">'. get_cat_name($catID).'</a></h4>';
        	$dataOutput .= '</div>';
            
            $dataOutput .= self::bk_get_blog_posts($the_query, $moduleInfo, $postLayout);
            
            if($moreLink == 1) {
                $dataOutput .= '<nav class="atbs-ceris-pagination text-center">';
            	$dataOutput .= '<a href="'.get_category_link($catID).'" class="btn btn-default">'.esc_html__('View all ', 'ceris'). get_cat_name($catID).'<i class="mdicon mdicon-arrow_forward mdicon--last"></i></a>';
            	$dataOutput .= '</nav>';
            }
            
            $dataOutput .= '</div>';
            
            wp_reset_postdata();    
            return $dataOutput;
        }
        static function bk_same_category_posts_wide($post) {
            $postID = $post->ID;
            $excludeid = array();
            
            $related_post_ids = array();
            
            if(self::$related_query != ''):
                $related_post_ids = wp_list_pluck( self::$related_query->posts, 'ID' );
            endif;
            
            array_push($excludeid, $postID);
            
            if(count($related_post_ids) > 0) {
                foreach($related_post_ids as $related_post_id):
                    array_push($excludeid, $related_post_id);
                endforeach;
            }
            
            $catID              = self::bk_get_post_option($postID, 'bk_same_cat_id_wide');
            
            if($catID == '') {
                $catID = 'current_cat';
            }
            if($catID == 'disable') {
                return '';
            }
            if($catID == 'current_cat') {
                $category = get_the_category($postID); 
                if(isset($category[0]) && $category[0]){
                    $catID = $category[0]->term_id;  
                }
                else {
                    return '';
                }
            }      
            
            $ceris_option = ceris_core::bk_get_global_var('ceris_option');
            $bkSingleLayout = get_post_meta($postID,'bk_post_layout_standard',true);
            
            if($bkSingleLayout != 'global_settings') :
                $headingStyle       =  self::bk_get_post_option($postID, 'bk_same_cat_heading_style_wide');    
                $postLayout         =  self::bk_get_post_option($postID, 'bk_same_cat_post_layout_wide');
                $postEntries        =  3;
                $postIcon           =  self::bk_get_post_option($postID, 'bk_same_cat_post_icon_wide');
                $postIconAnimation  =  self::bk_get_post_option($postID, 'bk_same_cat_post_icon_animation_wide');
                $moreLink           =  self::bk_get_post_option($postID, 'bk_same_cat_more_link_wide');
            else:
                $headingStyle       =  $ceris_option['bk_same_cat_heading_style_wide'];    
                $postLayout         =  $ceris_option['bk_same_cat_post_layout_wide'];
                $postEntries        =  3;
                $postIcon           =  $ceris_option['bk_same_cat_post_icon_wide'];
                $postIconAnimation  =  $ceris_option['bk_same_cat_post_icon_animation_wide'];
                $moreLink           =  $ceris_option['bk_same_cat_more_link_wide'];
            endif;
            
            if(isset($headingStyle)) {
                $headingClass = ceris_core::bk_get_block_heading_class($headingStyle);
            }
            
            if(isset($ceris_option['single-section-heading-font']['font-size']) && ($ceris_option['single-section-heading-font']['font-size'] != '')) {
                $headingFontSize = intval($ceris_option['single-section-heading-font']['font-size'], 10);
                $headingFontSizeClass = ' '.ceris_core::bk_detect_heading_size($headingFontSize);
            }else {
                $headingFontSizeClass = '';
            }
            
            $bk_all_cats = array();
            $bk_categories = get_the_category($postID);  
            $category_length = sizeof($bk_categories);
            if ($category_length > 0){       
                foreach ( $bk_categories as $category_key => $bk_category ) { $bk_all_cats[$category_key] = $bk_category->term_id; }
            }
            
            $moduleInfo = array(
                'align'               => '',
                'post_source'         => 'all',
                'post_icon'           => $postIcon,
                'post_icon_animation' => $postIconAnimation,
                'iconPosition'        => '',
                'meta'                => '',
                'cat'                 => '',
                'excerpt'             => '',
                'bookmark'      => array(),
                'bookmarkTmp'   => array(),
            );
            
            switch($postLayout){
                case 'listing_grid_no_sidebar':
                    $postEntries = 6;
                    break;
                default:
                    $postEntries = 3;
                    break;
            }
                
            $args = array(  
                'posts_per_page' => $postEntries,
                'post__not_in'   => $excludeid,
                'post_status'    => 'publish',
                'post_type'      => 'post',
    			'ignore_sticky_posts' => 1,
                'category__in'        => $catID,
            );

            $the_query = new WP_Query( $args );
            
            self::$samecat_query = $the_query;
            
            if (empty($the_query) || ($the_query->post_count == 0)) {
                return '';
            }
            
            $dataOutput = '';
            $dataOutput .= '<div class="atbs-ceris-block atbs-ceris-block--fullwidth same-category-posts has-background lightgray-bg">';
            
             if((($postLayout) != 'listing_grid' ) && (($postLayout) != 'listing_grid_no_sidebar') && (($postLayout) != 'listing_grid_small') && (($postLayout) != 'listing_grid_b_no_sidebar') ):
                    $dataOutput .= '<div class="container container--narrow'.$headingFontSizeClass.'">';
                    $dataOutput .= '<div class="block-heading '.$headingClass.'">';
                	$dataOutput .= '<h4 class="block-heading__title">'.esc_html__('More in:', 'ceris').'<a href="'.get_category_link($catID).'" class="cat-'.$catID.' cat-theme">'. get_cat_name($catID).'</a></h4>';
                    $dataOutput .= '</div>';
                    $dataOutput .= self::bk_get_blog_posts($the_query, $moduleInfo, $postLayout);
                    $dataOutput .= '</div><!--.container-->';
                else:
                    $dataOutput .= '<div class="container'.$headingFontSizeClass.'">';
                    $dataOutput .= '<div class="block-heading '.$headingClass.'">';
                	$dataOutput .= '<h4 class="block-heading__title">'.esc_html__('More in:', 'ceris').'<a href="'.get_category_link($catID).'" class="cat-'.$catID.' cat-theme">'. get_cat_name($catID).'</a></h4>';
                    $dataOutput .= '</div>';
                    $dataOutput .= self::bk_get_blog_posts($the_query, $moduleInfo, $postLayout);
                    $dataOutput .= '</div><!--.container-->';
                endif;

            if($moreLink == 1) {
                $dataOutput .= '<nav class="atbs-ceris-pagination text-center">';
            	$dataOutput .= '<a href="'.get_category_link($catID).'" class="btn btn-default">'.esc_html__('View all ', 'ceris'). get_cat_name($catID).'<i class="mdicon mdicon-arrow_forward mdicon--last"></i></a>';
            	$dataOutput .= '</nav>';
            }
            $dataOutput .= '</div>';
            
            wp_reset_postdata();    
            return $dataOutput;
        }
        /**
         * ************* Post Share *****************
         *---------------------------------------------------
         */   
         static function bk_entry_share($postID) {
            $ceris_option = ceris_core::bk_get_global_var('ceris_option');
            $htmlOutput = '';
            $titleget = get_the_title($postID);
            $bk_url = get_permalink($postID);
            $fb_oc = "window.open('http://www.facebook.com/sharer.php?u=".urlencode(get_permalink())."','Facebook','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;";
            $tw_oc = "window.open('http://twitter.com/share?url=".urlencode(get_permalink())."&amp;text=".str_replace(" ", "%20", $titleget)."','Twitter share','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;";
            $li_oc = "window.open('http://www.linkedin.com/shareArticle?mini=true&amp;url=".urlencode(get_permalink())."','Linkedin','width=863,height=500,left='+(screen.availWidth/2-431)+',top='+(screen.availHeight/2-250)+''); return false;";
            
            $share_box = $ceris_option['bk-sharebox-sw'];
            if ($share_box){
                $social_share['fb'] = $ceris_option['bk-fb-sw'];
                $social_share['tw'] = $ceris_option['bk-tw-sw'];
                $social_share['pi'] = $ceris_option['bk-pi-sw'];
                $social_share['li'] = $ceris_option['bk-li-sw'];
            }

            if ($social_share['fb']):
                $htmlOutput .= '<li><a class="sharing-btn sharing-btn-primary facebook-btn" data-toggle="tooltip" data-placement="top" title="'.esc_attr__('Share on Facebook', 'ceris').'" onClick="'.$fb_oc.'" href="//www.facebook.com/sharer.php?u='.urlencode($bk_url).'"><i class="mdicon mdicon-facebook"></i></a></li>';
            endif;
            if ($social_share['tw']):
                $htmlOutput .= '<li><a class="sharing-btn sharing-btn-primary twitter-btn" data-toggle="tooltip" data-placement="top" title="'.esc_attr__('Share on Twitter', 'ceris').'" onClick="'.$tw_oc.'" href="//twitter.com/share?url='.urlencode(get_permalink()).'&amp;text='.str_replace(" ", "%20", $titleget).'"><i class="mdicon mdicon-twitter"></i></a></li>';
            endif;
            if ($social_share['pi']):
                $htmlOutput .= '<li><a class="sharing-btn pinterest-btn" data-toggle="tooltip" data-placement="top" title="'.esc_attr__('Share on Pinterest', 'ceris').'" href="javascript:void((function()%7Bvar%20e=document.createElement(&apos;script&apos;);e.setAttribute(&apos;type&apos;,&apos;text/javascript&apos;);e.setAttribute(&apos;charset&apos;,&apos;UTF-8&apos;);e.setAttribute(&apos;src&apos;,&apos;//assets.pinterest.com/js/pinmarklet.js?r=&apos;+Math.random()*99999999);document.body.appendChild(e)%7D)());"><i class="mdicon mdicon-pinterest-p"></i></a></li>';
            endif;
            if ($social_share['li']):
                $htmlOutput .= '<li><a class="sharing-btn linkedin-btn" data-toggle="tooltip" data-placement="top" title="'.esc_attr__('Share on Linkedin', 'ceris').'" onClick="'.$li_oc.'" href="//www.linkedin.com/shareArticle?mini=true&amp;url='.urlencode($bk_url).'"><i class="mdicon mdicon-linkedin"></i></a></li>';
            endif;
            
            return $htmlOutput;
        }
        
        static function bk_entry_interaction_share($postID) {
            $ceris_option = ceris_core::bk_get_global_var('ceris_option');
            $htmlOutput = '';
            $titleget = get_the_title($postID);
            $bk_url = get_permalink($postID);
            $fb_oc = "window.open('http://www.facebook.com/sharer.php?u=".urlencode(get_permalink())."','Facebook','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;";
            $tw_oc = "window.open('http://twitter.com/share?url=".urlencode(get_permalink())."&amp;text=".str_replace(" ", "%20", $titleget)."','Twitter share','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;";
            $gp_oc = "window.open('https://plus.google.com/share?url=".urlencode(get_permalink())."','Google plus','width=585,height=666,left='+(screen.availWidth/2-292)+',top='+(screen.availHeight/2-333)+''); return false;";
            $li_oc = "window.open('http://www.linkedin.com/shareArticle?mini=true&amp;url=".urlencode(get_permalink())."','Linkedin','width=863,height=500,left='+(screen.availWidth/2-431)+',top='+(screen.availHeight/2-250)+''); return false;";
            
            $share_box = $ceris_option['bk-sharebox-sw'];
            if ($share_box){
                $social_share['fb'] = $ceris_option['bk-fb-sw'];
                $social_share['tw'] = $ceris_option['bk-tw-sw'];
                $social_share['gp'] = $ceris_option['bk-gp-sw'];
                $social_share['pi'] = $ceris_option['bk-pi-sw'];
                $social_share['li'] = $ceris_option['bk-li-sw'];
                
                $social_share['fb_text'] = $ceris_option['bk-fb-text'];
                $social_share['tw_text'] = $ceris_option['bk-tw-text'];
                $social_share['gp_text'] = $ceris_option['bk-gp-text'];
                $social_share['pi_text'] = $ceris_option['bk-pi-text'];
                $social_share['li_text'] = $ceris_option['bk-li-text'];
                
                $fbText = $twText = $gpText = $piText = $stuText = $liText = '';
                
                if($social_share['fb_text'] != '') {
                    $fbText = '<span class="sharing-btn__text">'.esc_attr($social_share['fb_text']).'</span>';
                }
                if($social_share['tw_text'] != '') {
                    $twText = '<span class="sharing-btn__text">'.esc_attr($social_share['tw_text']).'</span>';
                }
                if($social_share['gp_text'] != '') {
                    $gpText = '<span class="sharing-btn__text">'.esc_attr($social_share['gp_text']).'</span>';
                }
                if($social_share['pi_text'] != '') {
                    $piText = '<span class="sharing-btn__text">'.esc_attr($social_share['pi_text']).'</span>';
                }
                if($social_share['li_text'] != '') {
                    $liText = '<span class="sharing-btn__text">'.esc_attr($social_share['li_text']).'</span>';
                }
            }
    
            if ($social_share['fb']):
                $htmlOutput .= '<li><a class="sharing-btn sharing-btn-primary facebook-btn facebook-theme-bg" data-toggle="tooltip" data-placement="top" title="'.esc_attr__('Share on Facebook', 'ceris').'" onClick="'.$fb_oc.'" href="//www.facebook.com/sharer.php?u='.urlencode($bk_url).'"><i class="mdicon mdicon-facebook"></i>'.$fbText.'</a></li>';
            endif;
            if ($social_share['tw']):
                $htmlOutput .= '<li><a class="sharing-btn sharing-btn-primary twitter-btn twitter-theme-bg" data-toggle="tooltip" data-placement="top" title="'.esc_attr__('Share on Twitter', 'ceris').'" onClick="'.$tw_oc.'" href="//twitter.com/share?url='.urlencode(get_permalink()).'&amp;text='.str_replace(" ", "%20", $titleget).'"><i class="mdicon mdicon-twitter"></i>'.$twText.'</a></li>';
            endif;
            if ($social_share['gp']):
                $htmlOutput .= '<li><a class="sharing-btn googleplus-btn googleplus-theme-bg" data-toggle="tooltip" data-placement="top" title="'.esc_attr__('Share on Google+', 'ceris').'" onClick="'.$gp_oc.'" href="//plus.google.com/share?url='.urlencode($bk_url).'"><i class="mdicon mdicon-google-plus"></i>'.$gpText.'</a></li>';
            endif;
            if ($social_share['pi']):
                $htmlOutput .= '<li><a class="sharing-btn pinterest-btn pinterest-theme-bg" data-toggle="tooltip" data-placement="top" title="'.esc_attr__('Share on Pinterest', 'ceris').'" href="javascript:void((function()%7Bvar%20e=document.createElement(&apos;script&apos;);e.setAttribute(&apos;type&apos;,&apos;text/javascript&apos;);e.setAttribute(&apos;charset&apos;,&apos;UTF-8&apos;);e.setAttribute(&apos;src&apos;,&apos;//assets.pinterest.com/js/pinmarklet.js?r=&apos;+Math.random()*99999999);document.body.appendChild(e)%7D)());"><i class="mdicon mdicon-pinterest-p"></i>'.$piText.'</a></li>';
            endif;
            if ($social_share['li']):
                $htmlOutput .= '<li><a class="sharing-btn linkedin-btn linkedin-theme-bg" data-toggle="tooltip" data-placement="top" title="'.esc_attr__('Share on Linkedin', 'ceris').'" onClick="'.$li_oc.'" href="//www.linkedin.com/shareArticle?mini=true&amp;url='.urlencode($bk_url).'"><i class="mdicon mdicon-linkedin"></i>'.$liText.'</a></li>';
            endif;
            
            return $htmlOutput;
        }
        static function bk_entry_mobile_share($postID) {
            ob_start();
            if ( function_exists( 'ceris_extension_single_share' ) ) {
                $ceris_option = ceris_core::bk_get_global_var('ceris_option');
                $share_box = $ceris_option['bk-sharebox-sw'];
                if($share_box) {
                    if(isset($ceris_option['bk-mobile-share-heading']) && ($ceris_option['bk-mobile-share-heading'] != '')) {
                        $theHeading = $ceris_option['bk-mobile-share-heading'];
                    }else {
                        $theHeading = '';
                    }
                    ?>
                    <div class="ceris-mobile-share-socials">
                        <?php if($theHeading != ''):?>
                        <h3><?php echo esc_html($theHeading); ?></h3>
                        <?php endif;?>
                        <?php echo ceris_extension_single_share(get_the_ID()); ?>
                    </div><!-- ceris-share-socials -->
                <?php
                }
            }
            return ob_get_clean();
        }
        static function bk_entry_interaction_share_svg($postID, $class = '') {
            $ceris_option = ceris_core::bk_get_global_var('ceris_option');
            $share_box = $ceris_option['bk-sharebox-sw'];
            if ($share_box){
                $social_share['fb'] = $ceris_option['bk-fb-sw'];
                $social_share['tw'] = $ceris_option['bk-tw-sw'];
                $social_share['pi'] = $ceris_option['bk-pi-sw'];
                $social_share['li'] = $ceris_option['bk-li-sw'];
            }
            if (($social_share['fb'] == '') && ($social_share['tw'] == '') && ($social_share['pi'] == '') && ($social_share['li'] == '')):
                return '';
            endif;

            $htmlOutput = '';
            $titleget = get_the_title($postID);
            $bk_url = get_permalink($postID);
            $fb_oc = "window.open('http://www.facebook.com/sharer.php?u=".urlencode(get_permalink())."','Facebook','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;";
            $tw_oc = "window.open('http://twitter.com/share?url=".urlencode(get_permalink())."&amp;text=".str_replace(" ", "%20", $titleget)."','Twitter share','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;";
            $li_oc = "window.open('http://www.linkedin.com/shareArticle?mini=true&amp;url=".urlencode(get_permalink())."','Linkedin','width=863,height=500,left='+(screen.availWidth/2-431)+',top='+(screen.availHeight/2-250)+''); return false;";

            $svgFacebook = '<svg fill="#888" preserveAspectRatio="xMidYMid meet" height="1.3em" width="1.3em" viewBox="0 0 40 40">
                              <g>
                                <path d="m21.7 16.7h5v5h-5v11.6h-5v-11.6h-5v-5h5v-2.1c0-2 0.6-4.5 1.8-5.9 1.3-1.3 2.8-2 4.7-2h3.5v5h-3.5c-0.9 0-1.5 0.6-1.5 1.5v3.5z"></path>
                              </g>
                            </svg>';
            $svgTwitter = '<svg fill="#888" preserveAspectRatio="xMidYMid meet" height="1.3em" width="1.3em" viewBox="0 0 40 40">
                              <g>
                                <path d="m31.5 11.7c1.3-0.8 2.2-2 2.7-3.4-1.4 0.7-2.7 1.2-4 1.4-1.1-1.2-2.6-1.9-4.4-1.9-1.7 0-3.2 0.6-4.4 1.8-1.2 1.2-1.8 2.7-1.8 4.4 0 0.5 0.1 0.9 0.2 1.3-5.1-0.1-9.4-2.3-12.7-6.4-0.6 1-0.9 2.1-0.9 3.1 0 2.2 1 3.9 2.8 5.2-1.1-0.1-2-0.4-2.8-0.8 0 1.5 0.5 2.8 1.4 4 0.9 1.1 2.1 1.8 3.5 2.1-0.5 0.1-1 0.2-1.6 0.2-0.5 0-0.9 0-1.1-0.1 0.4 1.2 1.1 2.3 2.1 3 1.1 0.8 2.3 1.2 3.6 1.3-2.2 1.7-4.7 2.6-7.6 2.6-0.7 0-1.2 0-1.5-0.1 2.8 1.9 6 2.8 9.5 2.8 3.5 0 6.7-0.9 9.4-2.7 2.8-1.8 4.8-4.1 6.1-6.7 1.3-2.6 1.9-5.3 1.9-8.1v-0.8c1.3-0.9 2.3-2 3.1-3.2-1.1 0.5-2.3 0.8-3.5 1z"></path>
                              </g>
                            </svg>';       
            $svgPi = '<svg fill="#888" preserveAspectRatio="xMidYMid meet" height="1.3em" width="1.3em" viewBox="0 0 40 40">
                          <g>
                            <path d="m37.3 20q0 4.7-2.3 8.6t-6.3 6.2-8.6 2.3q-2.4 0-4.8-0.7 1.3-2 1.7-3.6 0.2-0.8 1.2-4.7 0.5 0.8 1.7 1.5t2.5 0.6q2.7 0 4.8-1.5t3.3-4.2 1.2-6.1q0-2.5-1.4-4.7t-3.8-3.7-5.7-1.4q-2.4 0-4.4 0.7t-3.4 1.7-2.5 2.4-1.5 2.9-0.4 3q0 2.4 0.8 4.1t2.7 2.5q0.6 0.3 0.8-0.5 0.1-0.1 0.2-0.6t0.2-0.7q0.1-0.5-0.3-1-1.1-1.3-1.1-3.3 0-3.4 2.3-5.8t6.1-2.5q3.4 0 5.3 1.9t1.9 4.7q0 3.8-1.6 6.5t-3.9 2.6q-1.3 0-2.2-0.9t-0.5-2.4q0.2-0.8 0.6-2.1t0.7-2.3 0.2-1.6q0-1.2-0.6-1.9t-1.7-0.7q-1.4 0-2.3 1.2t-1 3.2q0 1.6 0.6 2.7l-2.2 9.4q-0.4 1.5-0.3 3.9-4.6-2-7.5-6.3t-2.8-9.4q0-4.7 2.3-8.6t6.2-6.2 8.6-2.3 8.6 2.3 6.3 6.2 2.3 8.6z"></path>
                          </g>
                        </svg>';     
            $svgLi = '<svg fill="#888" preserveAspectRatio="xMidYMid meet" height="1.3em" width="1.3em" viewBox="0 0 40 40">
                          <g>
                            <path d="m13.3 31.7h-5v-16.7h5v16.7z m18.4 0h-5v-8.9c0-2.4-0.9-3.5-2.5-3.5-1.3 0-2.1 0.6-2.5 1.9v10.5h-5s0-15 0-16.7h3.9l0.3 3.3h0.1c1-1.6 2.7-2.8 4.9-2.8 1.7 0 3.1 0.5 4.2 1.7 1 1.2 1.6 2.8 1.6 5.1v9.4z m-18.3-20.9c0 1.4-1.1 2.5-2.6 2.5s-2.5-1.1-2.5-2.5 1.1-2.5 2.5-2.5 2.6 1.2 2.6 2.5z"></path>
                          </g>
                        </svg>';
            
            $htmlOutput .= '<div class="single-body--sharing-bar js-sticky-sidebar">';
            $htmlOutput .= '<div class="single-content-left '.esc_attr($class).'">';
            $htmlOutput .= '<div class="social-share">';
            $htmlOutput .= '<span class="social-share-label">'.esc_html__('Share', 'ceris').'</span>';
            $htmlOutput .= '<ul class="social-list social-list--md">';

            if ($social_share['fb']):
                $htmlOutput .= '<li class="facebook-share" ><a class="sharing-btn sharing-btn-primary facebook-btn" data-placement="top" title="'.esc_attr__('Share on Facebook', 'ceris').'" onClick="'.$fb_oc.'" href="//www.facebook.com/sharer.php?u='.urlencode($bk_url).'"><div class="share-item__icon">'.$svgFacebook.'</div></a></li>';
            endif;
            if ($social_share['tw']):
                $htmlOutput .= '<li class="twitter-share" ><a class="sharing-btn sharing-btn-primary twitter-btn" data-placement="top" title="'.esc_attr__('Share on Twitter', 'ceris').'" onClick="'.$tw_oc.'" href="//twitter.com/share?url='.urlencode(get_permalink()).'&amp;text='.str_replace(" ", "%20", $titleget).'"><div class="share-item__icon">'.$svgTwitter.'</div></a></li>';
            endif;
            if ($social_share['pi']):
                $htmlOutput .= '<li class="pinterest-share" ><a class="sharing-btn pinterest-btn" data-placement="top" title="'.esc_attr__('Share on Pinterest', 'ceris').'" href="javascript:void((function()%7Bvar%20e=document.createElement(&apos;script&apos;);e.setAttribute(&apos;type&apos;,&apos;text/javascript&apos;);e.setAttribute(&apos;charset&apos;,&apos;UTF-8&apos;);e.setAttribute(&apos;src&apos;,&apos;//assets.pinterest.com/js/pinmarklet.js?r=&apos;+Math.random()*99999999);document.body.appendChild(e)%7D)());"><div class="share-item__icon">'.$svgPi.'</div></a></li>';
            endif;
            if ($social_share['li']):
                $htmlOutput .= '<li class="linkedin-share" ><a class="sharing-btn linkedin-btn" data-placement="top" title="'.esc_attr__('Share on Linkedin', 'ceris').'" onClick="'.$li_oc.'" href="//www.linkedin.com/shareArticle?mini=true&amp;url='.urlencode($bk_url).'"><div class="share-item__icon">'.$svgLi.'</div></a></li>';
            endif;

            $htmlOutput .= '</ul>';
            $htmlOutput .= '</div>';
            $htmlOutput .= '</div>';
            $htmlOutput .= '</div><!-- single-body--sharing-bar -->';
            
            return $htmlOutput;
        }
        /**
         * ************* Post Share *****************
         *---------------------------------------------------
         */   
        static function bk_entry_comments($postID) {
            $htmlOutput = '<a href="#comments" class="comments-count" data-toggle="tooltip" data-placement="top" title="'.get_comments_number($postID).' '.esc_attr__('Comments', 'ceris').'"><i class="mdicon mdicon-comment-o"></i><span>'.get_comments_number($postID).'</span></a>';
            return $htmlOutput;
        }
        static function bk_entry_views($postID) {
            $count_key = 'post_views_count';
            $count = get_post_meta($postID, $count_key, true);
            $htmlOutput = '<a href="#views" class="view-count" data-toggle="tooltip" data-placement="top" title="'.$count.' '.esc_attr__('Views', 'ceris').'"><i class="mdicon mdicon-visibility"></i><span>'.$count.'</span></a>';
            return $htmlOutput;
        }
        static function bk_entry_interaction_comments($postID) {
            $htmlOutput = '<a href="#comments" class="comments-count entry-action-btn" data-toggle="tooltip" data-placement="top" title="'.get_comments_number($postID).' '.esc_attr__('Comments', 'ceris').'"><i class="mdicon mdicon-chat_bubble"></i><span>'.get_comments_number($postID).'</span></a>';
            return $htmlOutput;
        }
        static function bk_get_blog_posts($the_query, $moduleInfo, $postLayout = 'listing_list') {
            $dataOutput = '';
            if ( $the_query->have_posts() ) :
                switch($postLayout){
                    case 'listing_list':
                        $sectionHTML = new ceris_posts_listing_list;
                        $dataOutput .= '<div class="atbs-ceris-posts-latest-has--smallpost">';    
                        $dataOutput .= '<div class="posts-list">';
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo);            //render modules
                        $dataOutput .= '</div>';
                        $dataOutput .= '</div><!-- .atbs-ceris-posts-latest-has--smallpost -->';
                        break;
                    case 'listing_list_b':
                        $sectionHTML = new ceris_posts_listing_list_b;
                        $dataOutput .= '<div class="atbs-ceris-posts-latest-has--smallpost-2">';    
                        $dataOutput .= '<div class="posts-list">';
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo);            //render modules
                        $dataOutput .= '</div>';
                        $dataOutput .= '</div><!-- .atbs-ceris-posts-latest-has--smallpost-2 -->';
                        break;
                    case 'listing_list_large_a':
                        $sectionHTML = new ceris_posts_listing_list_large_a;
                        $dataOutput .= '<div class="atbs-ceris-posts-latest--text-right">';    
                        $dataOutput .= '<div class="posts-list">';
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo);            //render modules
                        $dataOutput .= '</div>';
                        $dataOutput .= '</div><!-- .atbs-ceris-posts-latest--text-right -->';
                        break;
                    case 'listing_list_large_b':
                        $sectionHTML = new ceris_posts_listing_list_large_b;
                        $dataOutput .= '<div class="atbs-ceris-posts-latest--text-left">';    
                        $dataOutput .= '<div class="posts-list">';
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo);            //render modules
                        $dataOutput .= '</div>';
                        $dataOutput .= '</div><!-- .atbs-ceris-posts-latest--text-left -->';
                        break;
                    case 'listing_grid':
                        $dataOutput .= '<div class="atbs-ceris-posts--vertical-text-not-fullwidth">';    
                        $dataOutput .= '<div class="posts-list post-list row row--space-between grid-gutter-40 items-clear-both-2">';
                        $sectionHTML = new ceris_posts_listing_grid;
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo);            //render modules
                        $dataOutput .= '</div>';
                        $dataOutput .= '</div><!-- .atbs-ceris-posts--vertical-text-not-fullwidth -->';
                        break;
                    case 'listing_grid_b':
                        $dataOutput .= '<div class="atbs-ceris-posts-latest--overlay">';    
                        $dataOutput .= '<div class="posts-list post-list row row--space-between grid-gutter-40 items-clear-both-2">';
                        $sectionHTML = new ceris_posts_listing_grid_b;
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo);            //render modules
                        $dataOutput .= '</div>';
                        $dataOutput .= '</div><!-- .atbs-ceris-posts--vertical-text-not-fullwidth -->';
                        break;
                    case 'listing_list_alt_b':
                        $dataOutput .= '<div class="posts-listing-list-alt-b">';    
                        $dataOutput .= '<div class="posts-list list-unstyled list-space-xl">';
                        $sectionHTML = new ceris_posts_listing_list_alt_b;
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo);            //render modules
                        $dataOutput .= '</div>';
                        $dataOutput .= '</div><!-- .posts-listing-list-alt-b -->';
                        break;
                    case 'listing_grid_alt_b':
                        $dataOutput .= '<div class="posts-listing-grid-alt-b">';    
                        $dataOutput .= '<div class="posts-list">';
                        $sectionHTML = new ceris_posts_listing_grid_alt_b;
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo);            //render modules
                        $dataOutput .= '</div>';
                        $dataOutput .= '</div><!-- .posts-listing-grid-alt-b -->';
                        break;
                    case 'listing_grid_small':
                        $dataOutput .= '<div class="posts-listing-grid-small atbs-ceris-post--listing-list-a-update">';    
                        $dataOutput .= '<div class="post-list posts-list">';
                        $sectionHTML = new ceris_posts_listing_grid_small;
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo);            //render modules
                        $dataOutput .= '</div>';
                        $dataOutput .= '</div><!-- .posts-listing-grid-alt-b -->';
                        break;
                    //no_side_bar
                    case 'listing_list_no_sidebar':
                        $sectionHTML = new ceris_posts_listing_list_no_sidebar;
                        $dataOutput .= '<div class="atbs-ceris-posts-latest-has--smallpost">';    
                        $dataOutput .= '<div class="posts-list">';
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo);            //render modules
                        $dataOutput .= '</div>';
                        $dataOutput .= '</div><!-- .atbs-ceris-posts-latest-has--smallpost -->';
                        break;
                    case 'listing_list_b_no_sidebar':
                        $sectionHTML = new ceris_posts_listing_list_b_no_sidebar;
                        $dataOutput .= '<div class="atbs-ceris-posts-latest-has--smallpost-2">';    
                        $dataOutput .= '<div class="posts-list">';
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo);            //render modules
                        $dataOutput .= '</div>';
                        $dataOutput .= '</div><!-- .atbs-ceris-posts-latest-has--smallpost-2 -->';
                        break;
                    case 'listing_list_large_a_no_sidebar':
                        $sectionHTML = new ceris_posts_listing_list_large_a_no_sidebar;
                        $dataOutput .= '<div class="atbs-ceris-posts-latest--text-right">';    
                        $dataOutput .= '<div class="posts-list">';
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo);            //render modules
                        $dataOutput .= '</div>';
                        $dataOutput .= '</div><!-- .atbs-ceris-posts-latest--text-right -->';
                        break;
                    case 'listing_list_large_b_no_sidebar':
                        $sectionHTML = new ceris_posts_listing_list_large_b_no_sidebar;
                        $dataOutput .= '<div class="atbs-ceris-posts-latest--text-left">';    
                        $dataOutput .= '<div class="posts-list">';
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo);            //render modules
                        $dataOutput .= '</div>';
                        $dataOutput .= '</div><!-- .atbs-ceris-posts-latest--text-left -->';
                        break;
                    case 'listing_grid_no_sidebar':
                        $dataOutput .= '<div class="atbs-ceris-posts--vertical-text-not-fullwidth">';    
                        $dataOutput .= '<div class="posts-list post-list row row--space-between grid-gutter-40 items-clear-both-3">';
                        $sectionHTML = new ceris_posts_listing_grid_no_sidebar;
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo);            //render modules
                        $dataOutput .= '</div><!-- .posts-list -->';
                        $dataOutput .= '</div><!-- .atbs-ceris-posts--vertical-text-not-fullwidth -->';
                        break;
                    case 'listing_grid_b_no_sidebar':
                        $dataOutput .= '<div class="atbs-ceris-posts-latest--overlay">';    
                        $dataOutput .= '<div class="posts-list post-list row row--space-between grid-gutter-40 items-clear-both-3">';
                        $sectionHTML = new ceris_posts_listing_grid_b_no_sidebar;
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo);            //render modules
                        $dataOutput .= '</div>';
                        $dataOutput .= '</div><!-- .atbs-ceris-posts--vertical-text-not-fullwidth -->';
                        break;
                    
                    default:
                        $sectionHTML = new ceris_posts_listing_list;
                        $dataOutput .= '<div class="atbs-ceris-posts-latest-has--smallpost">';    
                        $dataOutput .= '<div class="posts-list">';
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo);            //render modules
                        $dataOutput .= '</div>';
                        $dataOutput .= '</div><!-- .atbs-ceris-posts-latest-has--smallpost -->';
                        break;
                }
            endif;
            
            return $dataOutput;
        }
        static function bk_post_pagination(){
            global $page, $pages;
            if(count($pages) > 1):
            ?>
            <nav class="atbs-ceris-pagination atbs-ceris-pagination--next-n-prev">
				<div class="atbs-ceris-pagination__inner">
					<div class="atbs-ceris-pagination__label"><?php esc_html_e('Page ', 'ceris'); echo( '<span class="current_page_number">'.esc_html($page).'</span>'.esc_html__(' of ','ceris').count($pages) );?></div>
					<div class="atbs-ceris-pagination__links <?php if($page == count($pages)){echo ('atbs-ceris-pagination-last-page-link');}?>">
                        <?php
                            wp_link_pages( array( 
                                'before' => '', 
                                'after' => '', 
                                'previouspagelink' => esc_html__('Previous', 'ceris'), 
                                'nextpagelink' => esc_html__('Next', 'ceris'), 
                                'next_or_number' => 'next',   
                                'link_before' => '<span class="atbs-ceris-pagination__item">',
	                            'link_after' => '</span>',                                                                                           
                            ) ); 
                        ?>                                                                                                                                                                                                       
					</div>
				</div>
			</nav>
            <?php
            endif;
        }
        
    /**
     * ************* Review Box *****************
     *---------------------------------------------------
     */   
        static function bk_post_review_box_default($postID){
            
            $reviewCheck = get_post_meta($postID,'bk_review_checkbox',true);
            if($reviewCheck != 1) :
                return '';
            endif;
            
            $dataOutput = '';
            $productMediaLeft = '';
            $productMediaBody = '';
            
            $reviewScore = get_post_meta($postID,'bk_review_score',true);
            $the_pros_cons = get_post_meta($postID,'bk_pros_cons',true);
            
            
            $dataOutput .= '<div class="atbs-ceris-review">';
            $dataOutput .= '<div class="atbs-ceris-review__inner">';
            
            $dataOutput .= '<div class="atbs-ceris-review__top">';        
            $dataOutput .= self::bk_post_review_media($postID);            
            $dataOutput .= self::bk_post_review_overall_score($postID);
            $dataOutput .= '</div><!--atbs-ceris-review__top-->';
            
            $dataOutput .= self::bk_post_review_summary($postID);
            
            if($the_pros_cons == 1) :
                $dataOutput .= self::bk_post_review_pros_cons($postID);
            endif;
            
            $dataOutput .= '</div><!--atbs-ceris-review__inner-->';
            $dataOutput .= '</div>';
            
            return $dataOutput;
        }
        
        static function bk_get_user_review_on_article($postID, $userID){
            
            $performanceReview  = get_post_meta($postID,'bk_performance_review_checkbox',true);
            if($performanceReview != 1) :
                return '';
            endif;
                            
            ob_start();
            
            $userReviewData = get_post_meta( $postID, 'atbs_reader_review_DATA-'.$userID, true );
            $userAvatarURL = get_avatar_url($userID, ['size' => '150']);
            $user_info = get_userdata($userID);
            $userStars = round($userReviewData['user_star_rating'], 1);
            ?>
            <div class="list-item">
                <div class="user-review-item">
                    <div class="user__info">
                        <div class="user__info-avatar">
                            <img src="<?php echo esc_url($userAvatarURL);?>" alt="File not found">
                        </div>
                        <div class="user__info-context">
                            <div class="user__info-name">
                                <span><?php echo esc_html($user_info->display_name);?></span>
                            </div>
                            <div class="user__info-meta">
                                <time class="time"><?php echo esc_html($userReviewData['reviewTime']);?></time>
                            </div>
                        </div>
                    </div>
                    <div class="user__description">
                        <div class="user__description-title">
                            <h3><?php echo esc_html($userReviewData['user_review_title']);?></h3>
                        </div>
                        <div class="user__description-star">
                            <span class="stars-list star-score-background">
                                <?php
                                    $starCounting = 1;
                                    for($starCounting = 1; $starCounting <= 5; $starCounting++) {
                                        if($starCounting <= $userStars) {
                                            echo '<span class="star-item star-full"><i class="mdicon mdicon-star"></i></span>';
                                        }else {
                                            $deltaStar =  $userStars - (int) $userStars;  // .7
                                            if(($deltaStar > 0) && ($deltaStar < 1)) {
                                                echo '<span class="star-item star-half"><i class="mdicon mdicon-star"></i></span>';
                                                $userStars = 0;
                                            }else {
                                                 echo '<span class="star-item"><i class="mdicon mdicon-star"></i></span>';
                                            }
                                        }
                                    }
                                ?>
                            </span>
                        </div>
                        <div class="user__description-excerpt-wrap ceris-user-review-content review-content-loading">
                            <div class="user__description-excerpt">
                                <p><?php echo esc_html($userReviewData['user_review_content']);?></p>
                                <div class="user__description-btn-more">
                                    <span class="review-text-fadeout"></span>
                                </div>
                            </div>
                            <div class="review-readmore"><?php esc_html_e('More', 'ceris');?></div>
                        </div>
                    </div>
                    <?php
                        if( current_user_can( 'administrator' ) ){
                            echo '<div class="ceris-admin-delete-review" data-userid="'.$userID.'" data-postid="'.$postID.'">'.esc_html__('Delete', 'ceris').'</div>';
                        }
                    ?>
                </div>
            </div>
            
            <?php
            return ob_get_clean();
        }
        
        static function bk_post_review_box_aside($postID, $position){
            global $page, $pages;
            
            $reviewCheck = get_post_meta($postID,'bk_review_checkbox',true);
            if($reviewCheck != 1) :
                return '';
            endif;
            
            if($page > 1) {
                return '';
            }
            $dataOutput = '';
            $productMediaLeft = '';
            $productMediaBody = '';
            
            $the_pros_cons = get_post_meta($postID,'bk_pros_cons',true);
            
            if($position == 'aside-left') {
                $dataOutput .= '<div class="atbs-ceris-review atbs-ceris-review--aside alignleft">';
            }else {
                $dataOutput .= '<div class="atbs-ceris-review atbs-ceris-review--aside alignright">';
            }
            $dataOutput .= '<div class="atbs-ceris-review__inner">';
            
            $dataOutput .= self::bk_post_review_overall_score($postID);
            $dataOutput .= self::bk_post_review_media($postID, $position);            
            
            $dataOutput .= self::bk_post_review_summary($postID);
            
            if($the_pros_cons == 1) :
                $dataOutput .= self::bk_post_review_pros_cons_aside($postID);
            endif;
            
            $dataOutput .= '</div><!--atbs-ceris-review__inner-->';
            $dataOutput .= '</div>';
            
            return $dataOutput;
        }
        static function bk_performance_post_review($postID){
            global $page, $pages;
            
            if($page > 1) {
                return '';
            }
            get_template_part( 'library/templates/review/atbs-user-review');
        }
        static function bk_post_review_summary($postID){
            $summaryText = get_post_meta($postID,'bk_review_summary',true);
            
            $reviewSummary = '';
            $reviewSummary .= '<div class="atbs-ceris-review__summary">';
            $reviewSummary .= '<p>';
            $reviewSummary .= $summaryText;
            $reviewSummary .= '</p>';
            $reviewSummary .= '</div><!--atbs-ceris-review__summary-->';
            
            return $reviewSummary;
        }
        static function bk_post_review_media($postID, $position = 'default'){
            $boxTitle = get_post_meta($postID,'bk_review_box_title',true);
            $boxSubTitle = get_post_meta($postID,'bk_review_box_sub_title',true);
            
            $productMedia = '';
            $productMedia .= '<div class="atbs-ceris-review__product media">';
            $imageID = get_post_meta( $postID, 'bk_review_product_img', false );
            if((ceris_core::bk_check_array($imageID)) && ($imageID[0] != '')) {
                $productIMGURL = wp_get_attachment_image_src( $imageID[0], 'ceris-xxs-1_1' );
            }else {
                $productIMGURL = '';
            }
            if (!empty($productIMGURL) && ($productIMGURL[0] != NULL)) {
                $productMedia .= '<div class="media-left media-middle">';
                $productMedia .= '<div class="atbs-ceris-review__product-image"><img src="'.$productIMGURL[0].'" alt="'.esc_attr__('product-image', 'ceris').'"></div>';
                $productMedia .= '</div>';
            }
            
            if($position == 'default') {
                $titleTypeScale = 'typescale-2';
            }else {
                $titleTypeScale = 'typescale-1';
            }
            $productMedia .= '<div class="media-body media-middle">';
            $productMedia .= '<h3 class="atbs-ceris-review__product-name '.$titleTypeScale.'">'.$boxTitle.'</h3>';
            $productMedia .= '<span class="atbs-ceris-review__product-byline">'.$boxSubTitle.'</span>';
            $productMedia .= '</div>';
            $productMedia .= '</div><!--atbs-ceris-review__product media-->';
            
            return $productMedia;
        }
        static function bk_post_review_overall_score($postID){
            $reviewScore = get_post_meta($postID,'bk_review_score',true);
            
            $scoreBox = '';
            $scoreBox .= '<div class="atbs-ceris-review__overall-score">';
            $scoreBox .= '<div class="post-score-hexagon post-score-hexagon--xl">';
            $scoreBox .= '<svg class="hexagon-svg" version="1.1" xmlns="http://www.w3.org/2000/svg" viewbox="-5 -5 184 210">';
            $scoreBox .= '<g>';
            $scoreBox .= '<path fill="#FC3C2D" stroke="#fff" stroke-width="10px" d="M81.40638795573723 2.9999999999999996Q86.60254037844386 0 91.7986928011505 2.9999999999999996L168.0089283341811 47Q173.20508075688772 50 173.20508075688772 56L173.20508075688772 144Q173.20508075688772 150 168.0089283341811 153L91.7986928011505 197Q86.60254037844386 200 81.40638795573723 197L5.196152422706632 153Q0 150 0 144L0 56Q0 50 5.196152422706632 47Z"></path>';
            $scoreBox .= '</g>';
            $scoreBox .= '</svg>';
            $scoreBox .= '<span class="post-score-value">'.$reviewScore.'</span>';
            $scoreBox .= '</div>';
            $scoreBox .= '</div><!--atbs-ceris-review__overall-score-->';
            
            return $scoreBox;
        }
        static function bk_post_review_pros_cons_aside($postID){

            $prosTitle   = get_post_meta($postID,'bk_review_pros_title',true);
            $consTitle   = get_post_meta($postID,'bk_review_cons_title',true);
            $the_pros    = get_post_meta($postID,'bk_review_pros',true);
            $the_cons    = get_post_meta($postID,'bk_review_cons',true);
            
            $pros_cons = '';
            
            $pros_cons .= '<div class="atbs-ceris-review__pros-and-cons">';
            $pros_cons .= '<div class="row row--space-between grid-gutter-20">';
            
            $pros_cons .= '<div class="col-xs-12">';
            $pros_cons .= '<div class="atbs-ceris-review__pros">';
            $pros_cons .= '<h5 class="atbs-ceris-review__list-title">'.$prosTitle.'</h5>';
            $pros_cons .= '<ul>';
            if(count($the_pros) > 0) {
                foreach($the_pros as $val) :
                    $pros_cons .= '<li><i class="mdicon mdicon-add_circle"></i><span>'.$val.'</span></li>';
                endforeach;
            }
            $pros_cons .= '</ul>';
            $pros_cons .= '</div>';
            $pros_cons .= '</div>';
            
            $pros_cons .= '<div class="col-xs-12">';
            $pros_cons .= '<div class="atbs-ceris-review__cons">';
            $pros_cons .= '<h5 class="atbs-ceris-review__list-title">'.$consTitle.'</h5>';
            $pros_cons .= '<ul>';
            if(count($the_cons) > 0) {
                foreach($the_cons as $val) :
                    $pros_cons .= '<li><i class="mdicon mdicon-remove_circle"></i><span>'.$val.'</span></li>';
                endforeach;
            }
            $pros_cons .= '</ul>';
            $pros_cons .= '</div>';
            $pros_cons .= '</div>';
            
            $pros_cons .= '</div>';
            $pros_cons .= '</div><!--atbs-ceris-review__pros-and-cons-->';
            
            return $pros_cons;
        }
        static function bk_post_review_pros_cons($postID){

            $prosTitle   = get_post_meta($postID,'bk_review_pros_title',true);
            $consTitle   = get_post_meta($postID,'bk_review_cons_title',true);
            $the_pros    = get_post_meta($postID,'bk_review_pros',true);
            $the_cons    = get_post_meta($postID,'bk_review_cons',true);
            
            $pros_cons = '';
            
            $pros_cons .= '<div class="atbs-ceris-review__pros-and-cons">';
            $pros_cons .= '<div class="row row--space-between grid-gutter-20">';
            
            $pros_cons .= '<div class="col-xs-12 col-sm-6">';
            $pros_cons .= '<div class="atbs-ceris-review__pros">';
            $pros_cons .= '<h5 class="atbs-ceris-review__list-title">'.$prosTitle.'</h5>';
            $pros_cons .= '<ul>';
            if(($the_pros !='') || ($the_pros !=null)):  
                if(count($the_pros) > 0) {
                    foreach($the_pros as $val) :
                        $pros_cons .= '<li><i class="mdicon mdicon-add_circle"></i><span>'.$val.'</span></li>';
                    endforeach;
                }
            endif;
            $pros_cons .= '</ul>';
            $pros_cons .= '</div>';
            $pros_cons .= '</div>';
            
            $pros_cons .= '<div class="col-xs-12 col-sm-6">';
            $pros_cons .= '<div class="atbs-ceris-review__cons">';
            $pros_cons .= '<h5 class="atbs-ceris-review__list-title">'.$consTitle.'</h5>';
            $pros_cons .= '<ul>';
            if(($the_cons !='') || ($the_cons !=null)):  
                if(count($the_cons) > 0) {
                    foreach($the_cons as $val) :
                        $pros_cons .= '<li><i class="mdicon mdicon-remove_circle"></i><span>'.$val.'</span></li>';
                    endforeach;
                }
            endif;
            $pros_cons .= '</ul>';
            $pros_cons .= '</div>';
            $pros_cons .= '</div>';
            
            $pros_cons .= '</div>';
            $pros_cons .= '</div><!--atbs-ceris-review__pros-and-cons-->';
            
            return $pros_cons;
        }
    } // Close ceris_single
    
}