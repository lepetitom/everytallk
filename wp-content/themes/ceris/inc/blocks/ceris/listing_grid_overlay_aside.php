<?php
if (!class_exists('ceris_listing_grid_overlay_aside')) {
    class ceris_listing_grid_overlay_aside {
        static $pageInfo=0;
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_listing_grid_overlay_aside-');
            $moduleConfigs = array();
            
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
            
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
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
                'post_icon'     => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true ),
                'iconPosition'  => 'top-right',
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
            // banner button 
            $moduleConfigs['banner_title'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_banner_title', true );
            $moduleConfigs['banner_img'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_banner_img', true );
            $moduleConfigs['banner_button'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_banner_button', true );
            $moduleConfigs['banner_link'] = '';
            $moduleConfigs['banner_text'] = '';
            $moduleConfigs['banner_target'] = '';
            if($moduleConfigs['banner_button'] != 'disable'):
                $moduleConfigs['banner_link'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_banner_link', true );
                $moduleConfigs['banner_text'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_banner_text', true );
                $moduleConfigs['banner_target'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_banner_target', true );
            endif;
            if(!isset($moduleConfigs['banner_link'])&&($moduleConfigs['banner_link'] == '')){
                $moduleConfigs['banner_link'] = '';
            }
            if(!isset($moduleConfigs['banner_text'])&&($moduleConfigs['banner_text'] == '')){
                $moduleConfigs['banner_text'] = '';
            }
            if(isset($moduleConfigs['banner_target'])&&($moduleConfigs['banner_target'] != '_blank')){
                $banner_target = $moduleConfigs['banner_target'];
            }else{
                $banner_target = '_blank';
            }
            // banner button
            $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin listing-grid-overlay-aside '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
            $block_str .= ceris_core::bk_render_block_heading($page_info);
            $block_str .= '<div class="atbs-ceris-block__inner">';
            $block_str .= '<div class="row">';
            $block_str .= '<div class="atbs-ceris-block__aside-left col-md-4 js-sticky-sidebar">';
            $block_str .= '<div class="banner">';
            $block_str .= '<div class="banner__thumb">';
            if(($moduleConfigs['banner_img'] != '') || $moduleConfigs['banner_img'] != null):
            $block_str .= '<img src="'.esc_url($moduleConfigs['banner_img']).'">';
            $block_str .= '</img>';
            endif;
            $block_str .= '</div><!-- .banner__thumb -->';
            $block_str .= '<div class="banner__text">';
            $block_str .= '<h2 class="banner__title">'.esc_attr($moduleConfigs['banner_title']).'</h2><!-- .banner__title -->';
            if($moduleConfigs['banner_text'] != ''):
            $block_str .= '<a class="banner__button" href="'.esc_attr($moduleConfigs['banner_link']).'" target="'.esc_attr($banner_target).'" >'.$moduleConfigs['banner_text'].'</a><!-- .banner__button -->';
            endif;
            $block_str .= '</div><!-- .banner__text -->';
            $block_str .= '</div><!-- .banner -->';
            $block_str .= '</div><!-- .atbs-ceris-block__aside-left -->';
            $block_str .= '<div class="atbs-ceris-block__aside-right col-md-8">';
            if($moduleConfigs['ajax_load_more'] == 'loadmore') {
                $block_str .= '<div class="js-ajax-load-post" data-posts-to-load="'.$moduleConfigs['limit'].'">';
            }elseif($moduleConfigs['ajax_load_more'] == 'infinity') {
                $block_str .= '<div class="js-ajax-load-post infinity-ajax-load-post" data-posts-to-load="'.$moduleConfigs['limit'].'">';
            }
            $block_str .= '<div class="posts-list post-list flexbox-wrap flex-space-40 flexbox-wrap-3i">';
            if ( $the_query->have_posts() ) :
                $block_str .= $this->render_modules($the_query, $moduleInfo);            //render modules
            endif;
            $block_str .= '</div>';
            $cerisMaxPages = ceris_ajax_function::max_num_pages_cal($the_query, $moduleConfigs['offset'], $moduleConfigs['limit']);
            $block_str .= ceris_ajax_function::ajax_load_buttons($moduleConfigs['ajax_load_more'], $cerisMaxPages, $viewallButton);
            if(($moduleConfigs['ajax_load_more'] == 'loadmore') || ($moduleConfigs['ajax_load_more'] == 'infinity')) {
                $block_str .= '</div>';
            }
            $block_str .= '</div><!-- .atbs-ceris-block__aside-right -->';
            $block_str .= '</div><!-- .row -->';
            $block_str .= '</div><!-- .atbs-ceris-block__inner -->';
            $block_str .= '</div><!-- .atbs-ceris-block -->';
                        
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        
        public function render_modules($the_query, $moduleInfo = ''){
            $render_modules = '';
            
            if($moduleInfo['bookmark'] == 'on') {
                $bookmarkClass = 'post-has-bookmark bookmark__notice_align_right';
            }else {
                $bookmarkClass = '';
            }
            
            $currentPost = 0;
            $postSource = $moduleInfo['post_source'];
            $postIcon = $moduleInfo['post_icon'];
            $iconPosition = 'top-right';
            $iconSize = '';
            $postAnimation = $moduleInfo['post_icon_animation'];
            $bypasspostAnimationDetech = '';
            if($postAnimation == 'disable') {
                $bypasspostAnimationDetech = '';
            }else {
                $bypasspostAnimationDetech = 'icon-has-animation';
            }
            // Category
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
                $postOverlayHTML = new ceris_post_overlay_2;         
                $postOverlayAttr = array (
                    'cat'                  => $catStyle,
                    'catClass'             => $cat_Class.' overlay-item--top-left',
                    'additionalClass'      => 'post--overlay-bottom post--overlay-floorfade posts-has-smaller-post-cat post--overlay-md post--overlay-top-bottom '.$bypasspostAnimationDetech.' '.$bookmarkClass,
                    'additionalTextClass'  => 'inverse-text',
                    'additionalThumbClass' => 'post__thumb--overlay atbs-thumb-object-fit',
                    'thumbSize'            => 'ceris-s-1_1',
                    'typescale'            => 'typescale-2',
                    'postIcon'             => $postIconAttr,
                    'bookmark'             => $moduleInfo['bookmark'], 
                    'meta'                 => array('author', 'date'),
                );
                while ( $the_query->have_posts() ): $the_query->the_post();    
                   
                    $postOverlayAttr['postID'] = get_the_ID();
                    if($bypassPostIconDetech != 1) {
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType']   = ceris_core::bk_post_format_detect(get_the_ID());
                        }
                        $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], $iconSize, $iconPosition);
                        $postOverlayAttr['postIcon']    = $postIconAttr;
                    }
                    if( in_array(intval(get_the_ID()), $moduleInfo['bookmarkTmp'])) {
                        $hiddenClass = ' ceris-scale-to-zero';
                    }else {
                        $hiddenClass = '';
                    }
                    $render_modules .= '<div class="list-item'.$hiddenClass.'">';
                    $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                    $render_modules .= '</div>';
                endwhile;
            endif;
            
            return $render_modules;
        }
    }
}