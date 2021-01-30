<?php
if (!class_exists('ceris_block_fullwidth_two_sidebar_listing_list')) {
    class ceris_block_fullwidth_two_sidebar_listing_list {
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_block_fullwidth_two_sidebar_listing_list-');
            $moduleConfigs = array();
            $moduleData = array();
            
            //get config
            
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit', true );
            $moduleConfigs['offset'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );
            $moduleConfigs['ajax_load_more'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_ajax_load_more', true );
            $moduleConfigs['left_sidebar'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_left_sidebar', true );
            $moduleConfigs['right_sidebar'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_right_sidebar', true );
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
            $container_narrow = 'container--narrow';

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
            
            $block_str .= '<div class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin atbs-ceris-block--fullwidth-two-sidebar posts-listing-list '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
            $block_str .= ceris_core::bk_render_block_heading($page_info);                        
            $block_str .= '<div class="container container-1535 has-two-sidebar">';
            $block_str .= '<div class="row">';
            $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-main-col atbs-ceris-block atbs-ceris-posts-latest-has--smallpost" role="main">';
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
            $block_str .= '</div><!-- .atbs-ceris-main-col -->';  
            //sidebar 1
            $sidebarHTML = new atbs_ceris_sidebar;    
            $block_str .= '<div class="atbs-ceris-sub-col atbs-ceris-sub-col-right js-sticky-sidebar">';                                
            $block_str .= $sidebarHTML->render($moduleConfigs['left_sidebar']);
            $block_str .= '</div>';
            //sidebar 2                                
            $block_str .= '<div class="atbs-ceris-sub-col atbs-ceris-sub-col-left atbs-ceris-sub-col--mobile-fixed js-sticky-sidebar">';
            $block_str .= '<div class="atbs-ceris-sub-col-left-wrap">';                
            $block_str .= $sidebarHTML->render($moduleConfigs['right_sidebar']);
            $block_str .= '</div>';
            $block_str .= '</div>';                
            $block_str .= '</div><!-- .row -->';
            $block_str .= '</div><!-- .container -->';
            $block_str .= '</div><!-- .atbs-ceris-block -->';
                        
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_modules($the_query, $moduleInfo = ''){
            $render_modules = '';
            
            if($moduleInfo['bookmark'] == 'on') {
                $bookmarkClass = 'post-has-bookmark';
            }else {
                $bookmarkClass = '';
            }
            
            $postSource = $moduleInfo['post_source'];
            $postIcon = $moduleInfo['post_icon'];
            $postAnimation = $moduleInfo['post_icon_animation'];
            $bypasspostAnimationDetech = '';
            if($postAnimation == 'disable') {
                $bypasspostAnimationDetech = '';
            }else {
                $bypasspostAnimationDetech = 'icon-has-animation';
            }
            $iconPosition = 'top-right';
            $iconSize = '';
            $catStyle = 4;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            $bypassPostIconDetech = 0;         
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postIconAttr['post_icon_animation'] = '';
            
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
                    'thumbSize'         => 'ceris-xs-4_3',
                    'typescale'         => 'typescale-2',
                    'except_length'     => 15,
                    'postIcon'          => $postIconAttr,  
                    'meta'              => array('author_name', 'date'),
                    'bookmark'          => $moduleInfo['bookmark'],              
                );
                while ( $the_query->have_posts() ): $the_query->the_post();                    
                    $postHorizontalAttr['postID'] = get_the_ID();
                    if($bypassPostIconDetech != 1) {
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                        }
                        $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], $iconSize, $iconPosition);
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
                endwhile;
            endif;
            return $render_modules;
        }
    }
}