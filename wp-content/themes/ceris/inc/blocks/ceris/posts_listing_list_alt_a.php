<?php
if (!class_exists('ceris_posts_listing_list_alt_a')) {
    class ceris_posts_listing_list_alt_a {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_posts_listing_list_alt_a-');
            $moduleConfigs = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit', true );
            $moduleConfigs['offset']    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );
            $moduleConfigs['ajax_load_more'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_ajax_load_more', true );
            $viewallButton = array();
            if ($moduleConfigs['ajax_load_more'] == 'viewall') :            
                $viewallButton['view_all_link'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_link', true );
                $viewallButton['view_all_text'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_text', true );
                $viewallButton['view_all_target'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_target', true );
            endif;

            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = ' '.$moduleConfigs['custom_class'];
            }else {
                $moduleCustomClass = '';
            }
            
           //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            $moduleInfo = array(
                'post_source'   => $moduleConfigs['post_source'],
                'post_icon'     => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true ),
                'iconPosition'  => 'center',
                'post_icon_animation' => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon_animation', true ),
                'bookmark'      => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_bookmark', true ),
                'bookmarkTmp'   => array(),

            );
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
            if(($moduleInfo['bookmark'] == 'on') && (is_user_logged_in())) {
                $userID = get_current_user_id();    
                $dismissData = get_user_meta( $userID, 'atbs_dismiss_articles', true );
                if($dismissData != '') {
                    $moduleConfigs['editor_exclude'] = $moduleConfigs['editor_exclude']. ',' .implode(",",$dismissData);
                }
            }
            
            $the_query = bk_get_query::ceris_query($moduleConfigs, $moduleID);              //get query
            //Check Margin
            $moduleConfigs['module_custom_spacing_option'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_module_custom_spacing_option', true );
            if($moduleConfigs['module_custom_spacing_option'] == 'disable'){
                $blockMarginTopClass = '';
            }else{
                //Spacing Between Elements
                $moduleConfigs['module_margin_top'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_module_margin_top', true );
                if($moduleConfigs['module_margin_top'] < 0) :
                    $blockMarginTopClass = 'atbs-custom-margin-top-minus-'.abs($moduleConfigs['module_margin_top']);
                elseif(($moduleConfigs['module_margin_top'] > 0)) :
                    $blockMarginTopClass = 'atbs-custom-margin-top-'.abs($moduleConfigs['module_margin_top']);
                else:
                    $blockMarginTopClass = '';
                endif;
            }
            
            $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block posts-listing-list-alt atbs-ceris-block-custom-margin atbs-ceris-posts-latest-has--smallpost '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
            $block_str .= ceris_core::bk_render_block_heading_has_sidebar($page_info);
            
            if($moduleConfigs['ajax_load_more'] == 'loadmore') {
                $block_str .= '<div class="js-ajax-load-post" data-posts-to-load="'.$moduleConfigs['limit'].'">';
            }elseif($moduleConfigs['ajax_load_more'] == 'infinity') {
                $block_str .= '<div class="js-ajax-load-post infinity-ajax-load-post" data-posts-to-load="'.$moduleConfigs['limit'].'">';
            }
            
            $block_str .= '<div class="posts-list">';
            if ( $the_query->have_posts() ) :
                $block_str .= $this->render_modules($the_query, $moduleInfo);            //render modules
            endif;
            $block_str .= '</div>';
            $cerisMaxPages = ceris_ajax_function::max_num_pages_cal($the_query, $moduleConfigs['offset'], $moduleConfigs['limit']);
            $block_str .= ceris_ajax_function::ajax_load_buttons($moduleConfigs['ajax_load_more'], $cerisMaxPages, $viewallButton);
            if(($moduleConfigs['ajax_load_more'] == 'loadmore') || ($moduleConfigs['ajax_load_more'] == 'infinity')) {
                $block_str .= '</div>';
            }
            $block_str .= '</div><!-- .atbs-ceris-block -->';         
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        
        public function render_modules($the_query, $moduleInfo = ''){
            $render_modules = '';
            $currentPost = 0;
            
            if($moduleInfo['bookmark'] == 'on') {
                $bookmarkClass = 'post-has-bookmark';
            }else {
                $bookmarkClass = '';
            }
            
            $postSource = $moduleInfo['post_source'];
            $postIcon = $moduleInfo['post_icon'];
            $iconPosition = 'top-right';
            $postAnimation = $moduleInfo['post_icon_animation'];
            $bypasspostAnimationDetech = '';
            if($postAnimation == 'disable') {
                $bypasspostAnimationDetech = '';
            }else {
                $bypasspostAnimationDetech = 'icon-has-animation';
            }
            $catStyle = 4;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);


            $bypassPostIconDetech = 0;         
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            if($postIcon == 'disable') {
                $bypassPostIconDetech = 1;
            }else {
                $bypassPostIconDetech = 0;
            }    
            
            if ( $the_query->have_posts() ) :
                $postHorizontalHTML = new ceris_post_horizontal_1;                     
                $postHorizontalAttr = array (
                    'additionalClass'   => 'post--horizontal-middle post--horizontal-reverse remove-margin-bottom-lastchild post__thumb--width-400 post--horizontal-normal '.$bypasspostAnimationDetech.' '.$bookmarkClass,
                    'cat'               => $catStyle,
                    'catClass'          => $cat_Class,
                    'thumbSize'         => 'ceris-s-4_3',
                    'typescale'         => 'typescale-2',
                    'except_length'     => 15,
                    'postIcon'          => $postIconAttr,  
                    'meta'              => array('author_name', 'date'),
                    'bookmark'             => $moduleInfo['bookmark'],
                );
                $catStyle = 3;
                $cat_Class = ceris_core::bk_get_cat_class($catStyle);
                $postNothumbHTML = new  ceris_post_nothumb_1; 
                $postNothumbAttr = array (
                    'additionalClass'     => $bookmarkClass,
                    'cat'                 => $catStyle,
                    'catClass'            => $cat_Class.' post__cat-has-line',
                    'additionalTextClass' => '',
                    'typescale'           => 'typescale-2 custom-typescale-2--xxs',
                    'postIcon'            => $postIconAttr,
                    'bookmark'            => $moduleInfo['bookmark'],
                );
                $smallblockCnt = 0;
                $smallBlockEn = 0;
                $maxPosts = $the_query->post_count;
                
                while ( $the_query->have_posts() ): $the_query->the_post();   
                    $currentPost = $the_query->current_post;
                    $startSmallBlock = 6*$smallblockCnt + 3;
                    $endSmallBlock = $startSmallBlock + 2;
                    $postHorizontalAttr['postID'] = get_the_ID();
                    if($bypassPostIconDetech != 1) {
                        $addClass = 'overlay-item--sm-p';
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                        }
                        $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'small', $iconPosition, $addClass);
                        $postHorizontalAttr['postIcon'] = $postIconAttr;
                    } 
                    
                    if($currentPost == $startSmallBlock) :
                        $render_modules .= '<div class="'.$moduleInfo['bookmark'].' list-small post-list-no-thumb-3i">';
                        $smallBlockEn = 1;
                    endif;
                    
                    if($smallBlockEn == 0) :
                        if( in_array(intval(get_the_ID()), $moduleInfo['bookmarkTmp'])) {
                            $hiddenClass = ' ceris-scale-to-zero';
                        }else {
                            $hiddenClass = '';
                        }
                        $render_modules .= '<div class="'.$moduleInfo['bookmark'].' list-item">';
                        $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                        $render_modules .= '</div>';
                    else:
                        if( in_array(intval(get_the_ID()), $moduleInfo['bookmarkTmp'])) {
                            $hiddenClass = ' ceris-scale-to-zero';
                        }else {
                            $hiddenClass = '';
                        }
                        $postNothumbAttr['postID'] = get_the_ID();
                        $render_modules .= '<div class="'.$moduleInfo['bookmark'].' list-item">';
                        $render_modules .= $postNothumbHTML->render($postNothumbAttr);
                        $render_modules .= '</div>';
                    endif;
                    
                    if($currentPost == $endSmallBlock) :
                        $render_modules .= '</div><!-- list-small -->';  
                        $smallblockCnt ++;
                        $smallBlockEn = 0;
                    endif;
                    
                endwhile;
                
                if($smallBlockEn == 1) :
                    $render_modules .= '</div><!-- list-small -->';  
                endif;
            endif;
            return $render_modules;
        }
    }
}