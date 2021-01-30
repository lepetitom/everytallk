<?php
if (!class_exists('ceris_carousel_overlay_post_3i')) {
    class ceris_carousel_overlay_post_3i {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_carousel_overlay_post_3i-');
            $carouselID = uniqid('carousel-');
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            $moduleConfigs['title']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );     
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
            
            $moduleConfigs['heading_style'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_style', true );
            $moduleConfigs['heading_inverse'] = 'no';
            
            $viewallButton = array();
            if (($moduleConfigs['load_more'] == 'viewall') && ($moduleConfigs['heading_style'] != 'center') && ($moduleConfigs['heading_style'] != 'large-center') && ($moduleConfigs['heading_style'] != 'line-around') && ($moduleConfigs['heading_style'] != 'large-line-around')) :           
                $viewallButton['view_all_link'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_link', true );
                $viewallButton['view_all_text'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_text', true );
                $viewallButton['view_all_target'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_target', true );
            endif;
            
            if(isset($moduleConfigs['heading_style'])) {
                $headingClass = ceris_core::bk_get_block_heading_class($moduleConfigs['heading_style'], $moduleConfigs['heading_inverse']);
            }
            
            //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            $moduleConfigs['post_icon'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true );      
            $the_query = bk_get_query::ceris_query($moduleConfigs);              //get query
            
            if($the_query->post_count < 4):
                $moduleConfigs['carousel_loop'] = 0;
            endif;
            
            if($moduleConfigs['carousel_dot_nav'] != 1) {
                $dotNavClass = 'atbs-ceris-carousel-dots-none atbs-ceris-carousel-nav-c';
            }else {
                $dotNavClass = '';
            }
            if ( $the_query->have_posts() ) :
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin atbs-ceris-carousel '.$moduleCustomClass.$dotNavClass.'">';
               	$block_str .= '<div class="container">';
                $block_str .= ceris_core::bk_get_block_heading($moduleConfigs['title'], $headingClass, $viewallButton);
                $block_str .= '<div id="'.$carouselID.'" class="atbs-ceris-carousel__inner owl-carousel js-carousel-3i4m" data-carousel-loop="'.$moduleConfigs['carousel_loop'].'">';
                $block_str .= $this->render_modules($the_query);            //render modules
                $block_str .= '</div>';
                $block_str .= '</div><!-- .container -->';
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
            $meta = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_meta', true );
            if($meta != 0) {
                $metaArray = ceris_core::bk_get_meta_list($meta);
            }else {
                $metaArray = '';
            }
            // Category Style ($cat)
            $cat = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_cat_style', true );
            if($cat != 0){
                $catStyle = 4; // Category Above Title (Has Background)
                $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            }else {
                $catStyle = '';
                $cat_Class = '';
            }
            $postSource = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_source', true );
            $postIcon = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon', true );
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
                    'additionalClass'       => 'post--overlay-bottom posts-has-smaller-post-cat post--overlay-floorfade post--overlay-sm',
                    'thumbSize'             => 'ceris-xs-1_1',
                    'cat'                   => $catStyle,
                    'catClass'              => $cat_Class,
                    'meta'                  => $metaArray,
                    'typescale'             => 'typescale-2',
                    'additionalTextClass'   => 'inverse-text text-center',
                    'additionalThumbClass'  => 'post__thumb--overlay atbs-thumb-object-fit',
                    'postIcon'              => $postIconAttr,                        
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