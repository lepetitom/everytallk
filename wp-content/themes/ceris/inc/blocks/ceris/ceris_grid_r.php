<?php
if (!class_exists('ceris_grid_r')) {
    class ceris_grid_r {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_grid_r-');
            
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            $moduleConfigs['orderby']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true );
            $moduleConfigs['offset'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );
            $moduleConfigs['limit'] = 3;
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = $moduleConfigs['custom_class'].' ';
            }else {
                $moduleCustomClass = '';
            }
            
            //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            $moduleConfigs['post_icon'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true );      
            $moduleConfigs['post_icon_animation'] = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon_animation', true );
            
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
            $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-grid-r atbs-ceris-mosaic atbs-ceris-mosaic--gutter-10 '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
            $block_str .= ceris_core::bk_render_block_heading($page_info);
            $block_str .= '<div class="container">';
            //
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
            $render_modules = '';
            $iconPosition = 'top-right';
            $currentPost = 0;
            $postSource = self::$pageInfo ? get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_source', true ) : 'all';
            $postIcon = self::$pageInfo ? get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon', true ) : 'enable';
            $postAnimation = self::$pageInfo ? get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon_animation', true ): 'disable';
            
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
            $catStyle = 4;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            
            $postOverlayHTML = new ceris_post_overlay_2;         
            
            if ( $the_query->have_posts() ) :
                $catStyle = 4;
                $cat_Class = ceris_core::bk_get_cat_class($catStyle);
                
                $postOverlayHTML = new ceris_post_overlay_2;         
                $postOverlayAttr = array (
                    'cat'                 => $catStyle,
                    'catClass'            => $cat_Class.' overlay-item--top-left',
                    'additionalClass'     => 'post--overlay-bottom post--overlay-floorfade posts-has-smaller-post-cat '.$bypasspostAnimationDetech.'',
                    'additionalTextClass' => 'inverse-text',
                    'thumbSize'           => 'ceris-xs-1_1',
                    'additionalThumbClass'=> 'post__thumb--overlay atbs-thumb-object-fit',
                    'typescale'           => 'typescale-2 custom-typescale-2--xs',
                    'postIcon'            => $postIconAttr,
                    'meta'                => array('date'),
                );
                $postOverlayAttr_L = array (
                    'cat'                 => $catStyle,
                    'catClass'            => $cat_Class.' overlay-item--top-left',
                    'additionalClass'     => 'post--overlay-bottom post--overlay-floorfade posts-has-smaller-post-cat '.$bypasspostAnimationDetech.'',
                    'additionalThumbClass'=> 'post__thumb--overlay atbs-thumb-object-fit',
                    'additionalTextClass' => 'inverse-text',
                    'thumbSize'           => 'ceris-s-4_3',
                    'typescale'           => 'typescale-3',
                    'postIcon'            => $postIconAttr,
                    'meta'                => array('author_has_wrap', 'date'),
                );
                $render_modules .= '<div class="row row--space-between">';
                while ( $the_query->have_posts() ): $the_query->the_post();     
                    if($the_query->current_post == 0) : 
                        if($bypassPostIconDetech != 1) {
                            $addClass = ''; //overlay-item--sm-p
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                            }
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition, $addClass);
                            $postOverlayAttr_L['postIcon'] = $postIconAttr;
                        }      
                        $postOverlayAttr_L['postID'] = get_the_ID();  
                        $render_modules .= '<div class="mosaic-item col-xs-12 col-md-8">';
                        $render_modules .= $postOverlayHTML->render($postOverlayAttr_L);
                        $render_modules .= '</div>';
                    else:    
                        $addClass = '';
                        if($bypassPostIconDetech != 1) {
                            $addClass = ''; //overlay-item--sm-p
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                            }
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition, $addClass);
                            $postOverlayAttr['postIcon'] = $postIconAttr;
                        }
                        $postOverlayAttr['postID'] = get_the_ID();  
                        $render_modules .= '<div class="mosaic-item mosaic-item--half col-xs-12 col-sm-6 col-md-4">';
                        $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                        $render_modules .= '</div>';
                    endif;
                endwhile;
                $render_modules .= '</div>';
            endif;
            return $render_modules;
        }
    }
}