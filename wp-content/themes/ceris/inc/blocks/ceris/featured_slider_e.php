<?php
if (!class_exists('ceris_featured_slider_e')) {
    class ceris_featured_slider_e {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_featured_slider_e-');
            
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
            $moduleConfigs['post_icon_animation'] = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon_animation', true );
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
            
            if($moduleConfigs['limit'] > 1) :
                $carouselEn__Class = 'owl-carousel js-carousel-1i30m';
            else :
                $carouselEn__Class = '';                            
            endif;

            if ( $the_query->have_posts() ) :
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin featured-slider-e '.$moduleCustomClass.' '.$blockMarginTopClass.'">';                        
                $block_str .= ceris_core::bk_render_block_heading($page_info);
                $block_str .= '<div class="container">';                 
                $block_str .= '<div class="atbs-ceris-block__inner">';
                $block_str .= $this->render_modules($the_query);    //render modules
                $block_str .= '</div><!-- .atbs-ceris-block__inner -->';
                $block_str .= '</div><!-- .container -->';
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
            
            $postVerticalHTML = new ceris_update_vertical_6;
            $postVerticalAttr = array (
                'additionalClass'         => 'post--vertical-text-wrap post__thumb-580 '.$bypasspostAnimationDetech.'',
                'cat'                     => $catStyle,
                'catClass'                => $cat_Class,
                'thumbSize'               => 'ceris-l-16_9',
                'additionalThumbClass'    => 'atbs-thumb-object-fit',
                'additionalTextWrapClass' => 'flexbox clearfix',
                'typescale'               => 'typescale-2',
                'additionalExcerptClass'  => 'flexbox__item',
                'except_length'           => 15,
                'postIcon'                => $postIconAttr,  
                'meta'                    => array('author_has_wrap', 'date'),
                'readmore'                => 1,
                'additionalTextReadMore'  => 'ceris-readmore-style-1',
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
                    $postVerticalAttr['postID'] = get_the_ID();
                    
                    if($bypassPostIconDetech != 1) {
                        $addClass = '';
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                        }
                        $iconSize = '';
                        if($postIconAttr['iconType'] == 'review'):
                            $iconSize = 'large';
                        else:
                            $iconSize = 'medium';                                                                
                        endif;                                                            
                        $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], $iconSize, $iconPosition, $addClass);
                        $postVerticalAttr['postIcon'] = $postIconAttr;
                    }
                
                    $render_modules .= '<div class="slide-content">';
                    $render_modules .= $postVerticalHTML->render($postVerticalAttr);
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