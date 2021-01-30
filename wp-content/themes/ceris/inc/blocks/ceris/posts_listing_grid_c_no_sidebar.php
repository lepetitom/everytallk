<?php
if (!class_exists('ceris_posts_listing_grid_c_no_sidebar')) {
    class ceris_posts_listing_grid_c_no_sidebar {
        static $pageInfo=0;
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_posts_listing_grid_c_no_sidebar-');
            $moduleConfigs = array();
            
            //get config
            $ceris_option = ceris_core::bk_get_global_var('ceris_option');
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit', true );
            $moduleConfigs['offset']    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );
            $moduleConfigs['ajax_load_more'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_ajax_load_more', true );
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            $moduleConfigs['content_show_hide']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_content_show_hide', true );
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = ' '.$moduleConfigs['custom_class'];
            }else {
                $moduleCustomClass = '';
            }
            $viewallButton = array();
            if ($moduleConfigs['ajax_load_more'] == 'viewall') :            
                $viewallButton['view_all_link'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_link', true );
                $viewallButton['view_all_text'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_text', true );
                $viewallButton['view_all_target'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_target', true );
            endif;
            
            //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            
            $moduleInfo = array(
                'post_source'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true ),
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

            if(($moduleConfigs['content_show_hide'] != null) && ($moduleConfigs['content_show_hide'] == 'show_on_hover')):
                $theModuleStyle = 'module_content_show_on_hover';
            else:
                $theModuleStyle = '';
            endif;

            $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin atbs-ceris-posts-listing-grid-c posts-listing-grid-c-no-sidebar clearfix '.$moduleCustomClass.' '.$blockMarginTopClass.' '.$theModuleStyle.'">';
            $block_str .= ceris_core::bk_render_block_heading($page_info);
            
            if($moduleConfigs['ajax_load_more'] == 'loadmore') {
                $block_str .= '<div class="js-ajax-load-post" data-posts-to-load="'.$moduleConfigs['limit'].'">';
            }elseif($moduleConfigs['ajax_load_more'] == 'infinity') {
                $block_str .= '<div class="js-ajax-load-post infinity-ajax-load-post" data-posts-to-load="'.$moduleConfigs['limit'].'">';
            }
            $block_str .= '<div class="atbs-ceris-block__inner">';
            if ( $the_query->have_posts() ) :
                $block_str .= '<div class="posts-list">';
                $block_str .= $this->render_modules($the_query, $moduleInfo);            //render modules
                $block_str .= '</div><!-- .posts-list -->';
            endif;
            $block_str .= '</div><!-- .atbs-ceris-block__inner -->';
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
            
            if($moduleInfo['bookmark'] == 'on') {
                $bookmarkClass = 'post-has-bookmark';
            }else {
                $bookmarkClass = '';
            }
                        
            $currentPost = 0;
            $postSource = $moduleInfo['post_source'];
            // Category
            $catStyle = 4; 
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            if ( $the_query->have_posts() ) :
                
                $postOverlayHTML = new ceris_post_overlay_5;         
                $postOverlayAttr = array (
                    'cat'                  => $catStyle,
                    'catClass'             => $cat_Class,
                    'additionalClass'      => 'post post--overlay-text-center '.$bookmarkClass,
                    'additionalTextClass'  => 'inverse-text',
                    'additionalThumbClass' => 'post__thumb--overlay background-img atbs-thumb-object-fit',
                    'thumbSize'            => 'ceris-s-1_1',
                    'typescale'            => 'typescale-3',
                    'meta'                  => array('date'),
                    'bookmark'          => $moduleInfo['bookmark'],
                );
                
                $render_modules .= '<div class="posts-list-inner">';
                while ( $the_query->have_posts() ): $the_query->the_post();    
                   $currentPost = $the_query->current_post;     
                    $postOverlayAttr['postID'] = get_the_ID();
                    if( in_array(intval(get_the_ID()), $moduleInfo['bookmarkTmp'])) {
                        $hiddenClass = ' ceris-scale-to-zero';
                    }else {
                        $hiddenClass = '';
                    }
                    if(is_sticky(get_the_ID())):
                        $render_modules .= '<div class="list-item flexbox-item-50'.$hiddenClass.'">';
                        $postOverlayAttr['typescale'] = 'typescale-4';
                    else:
                        $render_modules .= '<div class="list-item flexbox-item-25'.$hiddenClass.'">';
                        $postOverlayAttr['typescale'] = 'typescale-3';
                    endif;
                    $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                    $render_modules .= '</div>';
                endwhile;
                $render_modules .= '</div><!-- .posts-list-inner -->';
                
            endif;
            
            return $render_modules;
        }
    }
}