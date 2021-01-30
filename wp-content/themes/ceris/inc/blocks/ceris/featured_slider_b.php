<?php
if (!class_exists('ceris_featured_slider_b')) {
    class ceris_featured_slider_b {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_featured_slider_b-');
            
            $moduleConfigs = array();
            $moduleData = array();
            
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
            
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = ' '.$moduleConfigs['custom_class'];
            }else {
                $moduleCustomClass = '';
            }
            
            //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            $moduleConfigs['post_icon'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true );      
            $the_query = bk_get_query::ceris_query($moduleConfigs);              //get query
            
            if($moduleConfigs['limit'] > 1) :
                $carouselEn__Class = 'owl-carousel js-carousel-1i30m';
            else :
                $carouselEn__Class = '';                            
            endif;
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
            if ( $the_query->have_posts() ) :
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-feature-slider-b '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
                $block_str .= ceris_core::bk_render_block_heading($page_info);
                $block_str .= '<div class="atbs-ceris-block__inner clearfix">';
                $block_str .= '<div class="post-slider-text-align-center">';
                $block_str .= $this->render_modules($the_query);    //render modules
                $block_str .= '</div><!-- .post-slider-text-align-center -->';
                $block_str .= '</div><!-- .atbs-ceris-block__inner -->';
                $block_str .= '</div><!-- .atbs-ceris-block -->';
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_modules ($the_query){
            
            $iconPosition = 'top-right';          
            $catStyle = 4;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);

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
            
            $postOverlayHTML = new ceris_update_overlay_7;
            $postOverlayAttr = array (
                'additionalClass'       => 'post--overlay-text-align-center post--overlay-height-795',
                'cat'                   => $catStyle,
                'catClass'              => $cat_Class,
                'additionalTextClass'  => 'inverse-text',
                'thumbSize'             => 'ceris-xl-16_9',
                'additionalThumbClass'  => 'post__thumb--overlay atbs-thumb-object-fit background-img',
                'additionalTextClass'   => 'inverse-text',
                'typescale'             => '',
                'meta'                  => array('author'),
                'postIcon'              => $postIconAttr,  
            );
            $render_modules = '';
            $currentPost = '';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                $maxPosts = $the_query->post_count;
               
                if($currentPost >= 0):
                    if($currentPost == 0):
                        if($maxPosts == 1):
                            $render_modules .= '<div class="atbs-ceris-carousel dots-circle">';    
                        else: 
                            $render_modules .= '<div class="owl-carousel js-atbs-ceris-carousel-only-1i-loopdot atbs-ceris-carousel dots-circle">';    
                        endif;
                    endif;
                    $postOverlayAttr['postID'] = get_the_ID();
                    $render_modules .= '<div class="slide-content">';
                    $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                    $render_modules .= '</div>';
                endif;            
            endwhile;
            if($currentPost >= 0):
                $render_modules .= '</div><!-- .owl-carousel -->';
            endif;
            return $render_modules;
        }
    }
}