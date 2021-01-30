<?php
if (!class_exists('ceris_posts_listing_grid_overlay_no_sidebar')) {
    class ceris_posts_listing_grid_overlay_no_sidebar {
        static $pageInfo=0;
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_posts_listing_grid_overlay_no_sidebar-');
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
            );
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
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

            $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin listing-grid-overlay posts-listing-grid-overlay-no-sidebar '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
            $block_str .= ceris_core::bk_render_block_heading($page_info);
            $block_str .= '<div class="container">';
            
            if($moduleConfigs['ajax_load_more'] == 'loadmore') {
                $block_str .= '<div class="js-ajax-load-post" data-posts-to-load="'.$moduleConfigs['limit'].'">';
            }elseif($moduleConfigs['ajax_load_more'] == 'infinity') {
                $block_str .= '<div class="js-ajax-load-post infinity-ajax-load-post" data-posts-to-load="'.$moduleConfigs['limit'].'">';
            }
            $block_str .= '<div class="atbs-ceris-block__inner">';
            $block_str .= '<div class="posts-list flexbox-wrap flexbox-wrap-3i-overlay flex-space-30">';
            
            if ( $the_query->have_posts() ) :
                $block_str .= $this->render_modules($the_query, $moduleInfo);            //render modules
            endif;
            
            $block_str .= '</div>';
            $block_str .= '</div><!-- .atbs-ceris-block__inner -->';
            
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
            
            $catStyle_B = 3; 
            $cat_Class_B = ceris_core::bk_get_cat_class($catStyle_B);
            
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
                $postOverlayHTML = new ceris_post_overlay_flip;         
                $postOverlayAttr = array (
                    'cat'                  => $catStyle,
                    'catClass'             => $cat_Class.' overlay-item--top-left',
                    'cat_back'             => $catStyle_B,
                    'catClass_back'        => $cat_Class_B.' cat-theme post__cat-has-line inverse-cat',                                        
                    'additionalClass'      => 'post--overlay-bottom post--overlay-floorfade post--overlay-height-370 post--overlay-flip-content flip-vertical-right '.$bypasspostAnimationDetech,
                    'additionalTextClass'  => 'inverse-text',
                    'additionalThumbClass' => 'post__thumb--overlay atbs-thumb-object-fit',
                    'thumbSize'            => 'ceris-s-1_1',
                    'typescale'            => 'typescale-2',
                    'typescale_2'          => 'typescale-2 post__title-has-underline-decoration',
                    'readmore'             => 1,
                    'meta_front'           => array('author_name', 'date'),
                    'meta_back'            => array('author'),
                    'except_length'        => 15,
                    'additional_meta_back_Class'    => 'entry-author--horizontal',
                    'postIcon'             => $postIconAttr,
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
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                    $render_modules .= '</div>';
                endwhile;
            endif;
            
            return $render_modules;
        }
    }
}