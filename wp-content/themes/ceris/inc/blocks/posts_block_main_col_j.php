<?php
if (!class_exists('ceris_posts_block_main_col_j')) {
    class ceris_posts_block_main_col_j {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_posts_block_main_col_j-');
            $moduleConfigs = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit']     = 4;
            $moduleConfigs['offset']    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );
            $moduleConfigs['load_more'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_load_more', true );
            
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = ' '.$moduleConfigs['custom_class'];
            }else {
                $moduleCustomClass = '';
            }

            $viewallButton = array();
            if (($moduleConfigs['load_more'] == 'viewall') && ($moduleConfigs['heading_style'] != 'center') && ($moduleConfigs['heading_style'] != 'large-center') && ($moduleConfigs['heading_style'] != 'line-around') && ($moduleConfigs['heading_style'] != 'large-line-around')) :           
                $viewallButton['view_all_link'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_link', true );
                $viewallButton['view_all_text'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_text', true );
                $viewallButton['view_all_target'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_target', true );
            endif;

            //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            $moduleConfigs['post_icon_animation'] =  get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon_animation', true );
            $the_query = bk_get_query::ceris_query($moduleConfigs);              //get query
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
            $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block-custom-margin posts-block-main-col-j '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
            $block_str .= ceris_core::bk_render_block_heading_has_sidebar($page_info);
            
            $block_str .= '<div class="row row--space-between">';
            
            if ( $the_query->have_posts() ) :
                $block_str .= $this->render_modules($the_query);            //render modules
            endif;
            
            $block_str .= '</div>';
            $block_str .= '</div><!-- .atbs-ceris-block -->';
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        
        public function render_modules ($the_query){
            
            $postOverlayHTML = new ceris_overlay_1;
            $postVerticalHTML = new ceris_post_vertical_3;
            $render_modules = '';

            $iconPosition_L = 'top-right';
            $iconPosition_S = 'top-right';
            $iconSize_L = '';
            $iconSize_S = 'small';
 
            // Category
            $cat_L_Style = 1;
            $cat_L_Class = ceris_core::bk_get_cat_class($cat_L_Style);
            $cat_S_Style = 4;
            $cat_S_Class = ceris_core::bk_get_cat_class($cat_S_Style);

            $excerpt_L = 23;
            //Footer Style
            $footerArgs = array();
            $footerStyle = '2-cols-border';
            $footerArgs = ceris_core::bk_overlay_footer_style($footerStyle);
                                    
            $postSource = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_source', true );
            $postIcon = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon', true );
            $postAnimation = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon_animation', true );
            $bypasspostAnimationDetech = '';
            if($postAnimation == 'disable') {
                $bypasspostAnimationDetech = '';
            }else {
                $bypasspostAnimationDetech = 'icon-has-animation';
            }       
            $bypassPostIconDetech = 0;         
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            if($postIcon == 'disable') {
                $bypassPostIconDetech = 1;
            }else {
                $bypassPostIconDetech = 0;
            }
                                    
            //Column 1
            if ( $the_query->have_posts() ) : $the_query->the_post();                                        
                $postOverlayAttr = array (
                    'additionalClass'       => 'post--overlay-bottom post--overlay-floorfade post--overlay-md '.$bypasspostAnimationDetech.'',
                    'cat'                   => $cat_L_Style,
                    'catClass'              => $cat_L_Class,
                    'thumbSize'             => 'ceris-m-2_1',
                    'typescale'             => 'typescale-3',
                    'additionalTextClass'   => 'inverse-text',
                    'additionalThumbClass'  => 'post__thumb--overlay atbs-thumb-object-fit',
                    'except_length'         => $excerpt_L,
                    'footerType'            => $footerArgs['footerType'],
                    'additionalMetaClass'   => $footerArgs['footerClass'],                    
                    'meta'                  => array('author_name', 'date'),                    
                    'postIcon'              => $postIconAttr,
                );
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
                    }else if($iconPosition_L == 'right-bottom') {
                        $postOverlayHTML = new ceris_overlay_icon_side_right;
                        if($postIconAttr['iconType'] != 'gallery') { 
                            $postIconAttr['postIconClass']  = 'post-type-icon--md';
                        }else {
                            $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                        }
                        $postOverlayAttr['additionalTextClass'] = 'inverse-text';
                    }else {
                        $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], $iconSize_L, $iconPosition_L);
                    }
                    
                    $postOverlayAttr['postIcon']    = $postIconAttr;
                }
                $render_modules .= '<div class="col-xs-12">';
                $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                $render_modules .= '</div>';
            endif;
            
            if ( $the_query->have_posts() ) :
                $postVerticalAttr = array (
                    'cat'           => $cat_S_Style,
                    'catClass'      => $cat_S_Class,
                    'thumbSize'     => 'ceris-xs-2_1',
                    'typescale'     => 'typescale-2 custom-typescale-2--xxs',
                    'additionalClass'     => 'posts-has-smaller-post-cat post--vertical-text-not-fullwidth '.$bypasspostAnimationDetech,
                    'postIcon'      => $postIconAttr,
                    'meta'              => array('date'),
                );
                $postVerticalAttr['postID'] = get_the_ID();
                $render_modules .= '<div class="col-xs-12 small-post-grid-vertical">';
                $render_modules .= '<div class="row row--space-between">';
                while ( $the_query->have_posts() ): $the_query->the_post();               
                        $postVerticalAttr['postID'] = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            $addClass = 'overlay-item--sm-p';
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = ceris_core::bk_post_format_detect(get_the_ID());
                            }
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], $iconSize_S, $iconPosition_S, $addClass);
                            $postVerticalAttr['postIcon']   = $postIconAttr;
                        }
                        $render_modules .= '<div class="col-xs-12 col-sm-4">';
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                        $render_modules .= '</div>';
                endwhile;
                $render_modules .= '</div>';
                $render_modules .= '</div>';
            endif;
            return $render_modules;
        }
    }
}