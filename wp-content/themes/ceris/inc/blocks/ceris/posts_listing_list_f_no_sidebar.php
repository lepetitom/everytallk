<?php
if (!class_exists('ceris_posts_listing_list_f_no_sidebar')) {
    class ceris_posts_listing_list_f_no_sidebar {
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_posts_listing_list_f_no_sidebar-');
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
                'post_reverse'  => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_reverse', true ),
                'post_icon_animation' => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon_animation', true ),
                'iconPosition'  => 'center',
                'bookmark'      => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_bookmark', true ),
                'bookmarkTmp'   => array(),
            );
            $container_narrow = 'container--narrow';
            $moduleConfigs['wide_layout'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_wide_layout', true );
            if($moduleConfigs['wide_layout'] != 'No'):
                $container_narrow = '';
            endif;
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
            $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin posts-listing-list-f-no-sidebar '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
            $block_str .= ceris_core::bk_render_block_heading($page_info, $container_narrow);
            $block_str .= '<div class="container '.$container_narrow.'">';
            
            if($moduleConfigs['ajax_load_more'] == 'loadmore') {
                $block_str .= '<div class="js-ajax-load-post" data-posts-to-load="'.$moduleConfigs['limit'].'">';
            }elseif($moduleConfigs['ajax_load_more'] == 'infinity') {
                $block_str .= '<div class="js-ajax-load-post infinity-ajax-load-post" data-posts-to-load="'.$moduleConfigs['limit'].'">';
            }
            $block_str .= '<div class="atbs-ceris-block__inner">';
            $block_str .= '<ul class="posts-list list-space-lg list-unstyled list-seperated">';
            if ( $the_query->have_posts() ) :
                $block_str .= $this->render_modules($the_query, $moduleInfo);            //render modules
            endif;
            $block_str .= '</ul><!-- .posts-list -->';
            $block_str .= '</div>';
            $cerisMaxPages = ceris_ajax_function::max_num_pages_cal($the_query, $moduleConfigs['offset'], $moduleConfigs['limit']);
            $block_str .= ceris_ajax_function::ajax_load_buttons($moduleConfigs['ajax_load_more'], $cerisMaxPages, $viewallButton);
            if(($moduleConfigs['ajax_load_more'] == 'loadmore') || ($moduleConfigs['ajax_load_more'] == 'infinity')) {
                $block_str .= '</div>';
            }
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
            $postReverse = $moduleInfo['post_reverse'];
            $bypassPostReverseDetech = '';         
            $postReverseAttr = array(); 
            if($postReverse == 'disable') {
                $bypassPostReverseDetech = '';
            }elseif($postReverse == 'alternate'){
                $bypassPostReverseDetech = 'post--horizontal-reverse';
            }
            else {
                $bypassPostReverseDetech = 'post--horizontal-reverse';
            }
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
            if($postIcon == 'disable') {
                $bypassPostIconDetech = 1;
            }else {
                $bypassPostIconDetech = 0;
            }    
            if ( $the_query->have_posts() ) :
                $postHorizontalHTML = new ceris_update_horizontal_6;
                $postHorizontalAttr = array (
                    'cat'                   => $catStyle,
                    'catClass'              => $cat_Class,
                    'thumbSize'             => 'ceris-s-1_1',
                    'additionalClass'       => 'listing--list-large post--horizontal-flex post--horizontal-margin-custom time-opacity '.$bypasspostAnimationDetech.' '.$bypassPostReverseDetech.' '.$bookmarkClass,
                    'additionalTextClass'   => '',
                    'typescale'             => 'typescale-3 custom-typescale-3',
                    'additionalThumbClass'  => 'atbs-thumb-object-fit',
                    'except_length'         => 15,
                    'readmore'              => 1,
                    'bookmark'             => $moduleInfo['bookmark'],
                    'postIcon'              => $postIconAttr,
                );
                
                while ( $the_query->have_posts() ): $the_query->the_post();         
                    $currentPost = $the_query->current_post;           
                    if($bypassPostIconDetech != 1) {
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                        }
                        $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], $iconSize, $iconPosition);
                        $postHorizontalAttr['postIcon'] = $postIconAttr;
                    }
                    $postHorizontalAttr['postID'] = get_the_ID();
                    if( in_array(intval(get_the_ID()), $moduleInfo['bookmarkTmp'])) {
                        $hiddenClass = ' ceris-scale-to-zero';
                    }else {
                        $hiddenClass = '';
                    }
                    if($postReverse == 'alternate'):
                        if($currentPost % 2 == 0):
                            $postHorizontalAttr['additionalClass'] = 'listing--list-large post--horizontal-margin-custom time-opacity '.$bypasspostAnimationDetech.' '.$bookmarkClass;
                        else:
                            $postHorizontalAttr['additionalClass'] = 'listing--list-large post--horizontal-margin-custom time-opacity '.$bypasspostAnimationDetech.' '.$bypassPostReverseDetech.' '.$bookmarkClass;
                        endif;
                    endif;
                    $render_modules .= '<li class="list-item'.$hiddenClass.'">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</li>';
                endwhile;
            endif;
            return $render_modules;
        }
    }
}