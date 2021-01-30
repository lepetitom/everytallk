<?php
if (!class_exists('ceris_featured_slider_c')) {
    class ceris_featured_slider_c {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_featured_slider_c-');
            
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
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin featured-slider-c '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
                $block_str .= ceris_core::bk_render_block_heading($page_info);    
                $block_str .= '<div class="atbs-ceris-block__inner">';
                $block_str .= $this->render_modules($the_query);    //render modules
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
            
            $postHorizontalHTML = new ceris_update_horizontal_4;
            $postHorizontalAttr = array (
                'additionalClass'         => 'post--horizontal-50-percent post__thumb-970',
                'cat'                     => $catStyle,
                'catClass'                => $cat_Class,
                'thumbSize'               => 'ceris-xl-4_3',
                'additionalThumbClass'    => 'atbs-thumb-object-fit',
                'typescale'               => 'typescale-1',
                'postIcon'                => $postIconAttr,  
                'meta'                    => array('author_has_wrap', 'date'),
            );
            $render_modules = '';
            $currentPost = '';
            $preBackground = '';
            $preBackground .= '<div class="owl-background">';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                $maxPosts = $the_query->post_count;
                
                if($currentPost >= 0):
                    
                    if($currentPost == 0):
                        $preBackground .= '<a class="owl-background-img active" href="'.get_permalink(get_the_ID()).'">
                                <img src="'.get_the_post_thumbnail_url(get_the_ID(), 'ceris-xl-4_3').'" alt="owl-bg">
                            </a>';
                    elseif($currentPost == 1):
                        $preBackground .= '<a class="owl-background-img" href="'.get_permalink(get_the_ID()).'">
                                <img src="'.get_the_post_thumbnail_url(get_the_ID(), 'ceris-xl-4_3').'" alt="owl-bg">
                            </a>';
                    endif;
                    
                    if($currentPost == 0):
                        $render_modules .= '<div class="block__inner--wrap">';
                        $render_modules .= '<div class="owl-carousel js-atbs-ceris-carousel-1i-get-background atbs-ceris-carousel dots-circle button--dots-center-nav">';
                    endif;
                    $postHorizontalAttr['postID'] = get_the_ID();
                    $render_modules .= '<div class="slide-content">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</div>';
                endif;            
            endwhile;
            $preBackground .= '</div><!-- .owl-background -->';
            if($currentPost >= 0):
                $render_modules .= '</div><!-- .owl-carousel -->';
                $render_modules .= '</div><!-- .block__inner--wrap -->';
                $render_modules .= $preBackground;
            endif;
            return $render_modules;
        }
    }
}