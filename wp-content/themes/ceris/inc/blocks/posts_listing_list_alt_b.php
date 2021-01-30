<?php
if (!class_exists('ceris_posts_listing_list_alt_b')) {
    class ceris_posts_listing_list_alt_b {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $moduleID = uniqid('ceris_posts_listing_list_alt_b-');
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
                'iconPosition_l'  => 'top-right',
                'iconPosition_s'  => 'top-right',
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
            $block_str = '';
            
            $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block-custom-margin posts-listing-list-alt-b '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
            $block_str .= ceris_core::bk_render_block_heading_has_sidebar($page_info);
            
            if($moduleConfigs['ajax_load_more'] == 'loadmore') {
                $block_str .= '<div class="js-ajax-load-post" data-posts-to-load="'.$moduleConfigs['limit'].'">';
            }elseif($moduleConfigs['ajax_load_more'] == 'infinity') {
                $block_str .= '<div class="js-ajax-load-post infinity-ajax-load-post" data-posts-to-load="'.$moduleConfigs['limit'].'">';
            }
            $block_str .= '<div class="posts-list list-unstyled list-space-xl">';
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
            $iconPosition_L = 'top-right';
            $iconPosition_S = 'top-right';
            $postAnimation = $moduleInfo['post_icon_animation'];
            $bypasspostAnimationDetech = '';
            if($postAnimation == 'disable') {
                $bypasspostAnimationDetech = '';
            }else {
                $bypasspostAnimationDetech = 'icon-has-animation';
            } 
            
            // Category
   
            $cat_L_Style = 1;
            $cat_L_Class = ceris_core::bk_get_cat_class($cat_L_Style);

            $catStyle = 4;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);

            $excerptLength_L = 23;
            $excerptLength_S = 23;
            
            
            //Footer Style
            $footerArgs = array();
            $footerStyle = '1-cols';
            $footerArgs = ceris_core::bk_overlay_footer_style($footerStyle);
            
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
                
                $postOverlayHTML = new ceris_overlay_1;
                $postOverlayAttr = array (
                    'additionalClass'      => 'post--overlay-floorfade posts-has-smaller-post-cat post--overlay-bottom post--overlay-md post--overlay-padding-lg custom_post--overlay '.$bypasspostAnimationDetech.' '.$bookmarkClass,
                    'cat'                  => $cat_L_Style,
                    'catClass'             => $cat_L_Class,
                    'thumbSize'            => 'ceris-m-16_9',
                    'additionalThumbClass' => 'post__thumb--overlay atbs-thumb-object-fit',
                    'typescale'            => 'typescale-3',
                    'except_length'        => 22,
                    'meta'                 => array('author_name', 'date'),
                    'postIcon'             => $postIconAttr,  
                    'bookmark'          => $moduleInfo['bookmark'],
                );
                $postHorizontalHTML = new ceris_post_horizontal_1;                     
                $postHorizontalAttr = array (
                    'additionalClass'   => 'post--horizontal-middle remove-margin-bottom-lastchild post__thumb--width-400 post--horizontal-no-excerpt '.$bypasspostAnimationDetech.' '.$bookmarkClass,
                    'cat'               => $catStyle,
                    'catClass'          => $cat_Class,
                    'thumbSize'         => 'ceris-xs-4_3',
                    'typescale'         => 'typescale-2',
                    'except_length'     => 15,
                    'postIcon'          => $postIconAttr,  
                    'meta'              => array('author_name', 'date'),
                    'bookmark'             => $moduleInfo['bookmark'],
                );
                
                while ( $the_query->have_posts() ): $the_query->the_post();     
                    $currentPost = $the_query->current_post;
                    if($currentPost % 5) : //Small Posts
                        $postHorizontalAttr['postID'] = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            $addClass = '';
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                            }
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition_S, $addClass);
                            $postHorizontalAttr['postIcon'] = $postIconAttr;
                        }
                        if( in_array(intval(get_the_ID()), $moduleInfo['bookmarkTmp'])) {
                            $hiddenClass = ' ceris-scale-to-zero';
                        }else {
                            $hiddenClass = '';
                        }
                        $render_modules .= '<div class="list-item">';
                        $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                        $render_modules .= '</div>';
                    else: //Large Posts
                        $postOverlayAttr['postID'] = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = ceris_core::bk_post_format_detect(get_the_ID());
                            }
                            if($iconPosition_L == 'left-bottom') {
                                $postOverlayHTML = new ceris_overlay_icon_side_left;
                                if($postIconAttr['iconType'] != 'gallery') { 
                                    $postIconAttr['postIconClass']  = 'post-type-icon--md';
                                }else {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }
                                $postOverlayAttr['additionalTextClass'] = 'inverse-text';
                            }else if($iconPosition_L == 'right-bottom') {
                                $postOverlayHTML = new ceris_overlay_icon_side_right;
                                if($postIconAttr['iconType'] != 'gallery') { 
                                    $postIconAttr['postIconClass']  = 'post-type-icon--md';
                                }else {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }
                                $postOverlayAttr['additionalTextClass'] = 'inverse-text';
                            }else {
                                if($postIconAttr['iconType'] == 'gallery') {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }else {
                                    $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition_L);
                                }
                            }
                            $postOverlayAttr['postIcon']    = $postIconAttr;
                        } 
                        if( in_array(intval(get_the_ID()), $moduleInfo['bookmarkTmp'])) {
                            $hiddenClass = ' ceris-scale-to-zero';
                        }else {
                            $hiddenClass = '';
                        }
                        $render_modules .= '<div class="list-item">';
                        $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                        $render_modules .= '</div>';
                    endif;
                endwhile;
            endif;
            return $render_modules;
        }
    }
}