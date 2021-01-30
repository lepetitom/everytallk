<?php
if (!class_exists('ceris_carousel_overlay_post_main_col_3i')) {
    class ceris_carousel_overlay_post_main_col_3i {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_carousel_overlay_post_main_col_3i-');
            $carouselID = uniqid('carousel-');
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            $moduleConfigs['carousel_loop'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_carousel_loop', true );
            $moduleConfigs['carousel_dot_nav'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_carousel_dot_nav', true );
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit', true );
            $moduleConfigs['offset']    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );
            $moduleConfigs['load_more'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_load_more', true );
            
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = $moduleConfigs['custom_class'].' ';
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
            $moduleConfigs['post_icon'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true );      
            $moduleConfigs['post_icon_animation'] =  get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon_animation', true );
            $the_query = bk_get_query::ceris_query($moduleConfigs);              //get query
            //Spacing Between Elements
            $moduleConfigs['module_margin_top'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_module_margin_top', true );
            $moduleConfigs['heading_margin_bottom'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_margin_bottom', true );
            
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
            //end Spacing Between Elements
            
            if($the_query->post_count < 4):
                $moduleConfigs['carousel_loop'] = 0;
            endif;
            if($moduleConfigs['carousel_dot_nav'] != 1) {
                $dotNavClass = 'atbs-ceris-carousel-dots-none atbs-ceris-carousel-nav-c';
            }else {
                $dotNavClass = '';
            }
            if ( $the_query->have_posts() ) :
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-carousel atbs-ceris-block-custom-margin carousel-overlay-post-main-col-3i '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
                $block_str .= ceris_core::bk_render_block_heading_has_sidebar($page_info);
                $block_str .= '<div id="'.$carouselID.'" class="atbs-ceris-carousel__inner owl-carousel js-carousel-3i4m dots-circle" data-carousel-loop="'.$moduleConfigs['carousel_loop'].'">';
                $block_str .= $this->render_modules($the_query);            //render modules
                $block_str .= '</div>';
                $block_str .= '</div><!-- .atbs-ceris-block -->'; 
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_modules ($the_query){
            $postOverlayHTML = new ceris_overlay_1;
            $render_modules = '';
            $iconPosition = 'top-right';
            // Meta
            $meta = 8;
            $metaArray = ceris_core::bk_get_meta_list($meta);
            // Category Style ($cat)
            $catStyle = 4; // Category Above Title (Has Background)
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
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
            if ( $the_query->have_posts() ) :
                $postOverlayAttr = array (
                    'additionalClass'       => 'post--overlay-bottom posts-has-smaller-post-cat post--overlay-floorfade post--overlay-sm '.$bypasspostAnimationDetech.'',
                    'thumbSize'             => 'ceris-xs-1_1',
                    'cat'                   => $catStyle,
                    'catClass'              => $cat_Class,
                    'typescale'             => 'typescale-2 custom-typescale-2',
                    'additionalTextClass'   => 'inverse-text text-center',
                    'additionalThumbClass'  => 'post__thumb--overlay atbs-thumb-object-fit',
                    'postIcon'              => $postIconAttr,
                    'meta'                => array('date'),           
                );
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $postOverlayAttr['postID'] = get_the_ID();
                    if($bypassPostIconDetech != 1) {
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType']   = ceris_core::bk_post_format_detect(get_the_ID());
                        }
                        if($iconPosition == 'left-bottom') {
                            $postOverlayHTML = new ceris_overlay_icon_side_left;
                            if($postIconAttr['iconType'] != 'gallery') { 
                                $postIconAttr['postIconClass']  = '';
                            }else {
                                $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                            }
                            $postOverlayAttr['additionalTextClass'] = 'inverse-text';
                        }else if($iconPosition == 'right-bottom') {
                            $postOverlayHTML = new ceris_overlay_icon_side_right;
                            if($postIconAttr['iconType'] != 'gallery') { 
                                $postIconAttr['postIconClass']  = '';
                            }else {
                                $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                            }
                            $postOverlayAttr['additionalTextClass'] = 'inverse-text';
                        }else {
                            if($postIconAttr['iconType'] == 'gallery') {
                                $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                            }else {
                                $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'small', $iconPosition);
                            }
                        }
                        $postOverlayAttr['postIcon']    = $postIconAttr;
                    }
                    $render_modules .= '<div class="slide-content">';
                    $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                    $render_modules .= '</div>';
                endwhile;
            endif;
            return $render_modules;
        }
    }
}