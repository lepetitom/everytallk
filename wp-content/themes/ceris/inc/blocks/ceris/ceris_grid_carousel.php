<?php
if (!class_exists('ceris_grid_carousel')) {
    class ceris_grid_carousel {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_grid_carousel-');
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            $contiguousClass = 'atbs-ceris-block--contiguous';
            
            $moduleConfigs['orderby']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true );
            $moduleConfigs['offset'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );
            $moduleConfigs['limit'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit', true );
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
            if ( $the_query->have_posts() ) :
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-grid-carousel atbs-ceris-grid-carousel '.$moduleCustomClass.'">';
                $block_str .= ceris_core::bk_render_block_heading($page_info);
                $block_str .= $this->render_modules($the_query);              //render modules
                $block_str .= '</div><!-- .atbs-ceris-block -->';
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_modules ($the_query){
            $iconPosition = 'top-right';
            $currentPost = 0;
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
            $catStyle = 4;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            
            $postHorizontalHTML = new ceris_post_horizontal_1;         
            $postHorizontalAttr = array (
                'cat'                  => $catStyle,
                'catClass'             => $cat_Class,
                'additionalClass'      => 'post--horizontal-middle posts-has-smaller-post-cat post--horizontal-thumb__top remove-margin-bottom-lastchild '.$bypasspostAnimationDetech.'',
                'additionalTextClass'  => 'remove-margin-bottom-lastchild',
                'additionalThumbClass' => 'atbs-thumb-object-fit',
                'thumbSize'            => 'ceris-xxs-1_1',
                'typescale'            => 'typescale-2 custom-typescale-2',
                'meta'                 => array('author_name', 'date'),
                'postIcon'             => $postIconAttr,
            );
            $render_modules = '';
            $currentPost = '';
            $carouselID = uniqid('carousel-feature-slider-');
            while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                $maxPosts = $the_query->post_count;
                
                if($currentPost == 0): 
                    if($maxPosts > 0 && $maxPosts < 5):
                        $render_modules .= '<div class="atbs-ceris-block__inner atbs-ceris-grid-carousel__inner carousel-slide-content-flex">';
                        $render_modules .= '<div class="grid-carousel--wrap ">';
                        $render_modules .= '<div class="grid-carousel">';
                        $render_modules .= '<div id="'.$carouselID.'" class="atbs-ceris-carousel">';   
                    else:
                        $render_modules .= '<div class="atbs-ceris-block__inner atbs-ceris-grid-carousel__inner">';
                        $render_modules .= '<div class="grid-carousel--wrap ">';
                        $render_modules .= '<div class="grid-carousel">';
                        $render_modules .= '<div id="'.$carouselID.'" class="owl-carousel js-carousel-2i10m atbs-ceris-carousel">';
                    endif;
                endif;
                if($bypassPostIconDetech != 1) {
                    $addClass = 'overlay-item--sm-p';
                    if($postSource != 'all') {
                        $postIconAttr['iconType'] = $postSource;
                    }else {
                        $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                    }
                    $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'small', $iconPosition, $addClass);
                    $postHorizontalAttr['postIcon'] = $postIconAttr;
                } 
                $postHorizontalAttr['postID'] = get_the_ID();
                if($currentPost >= 0):
                    
                    if($currentPost % 2 == 0):
                        $render_modules .= '<div class="slide-content">';
                        $render_modules .= '<div class="post-item">';
                        $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                        $render_modules .= '</div><!-- .post-item -->';
                    else:
                        $render_modules .= '<div class="post-item">';
                        $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                        $render_modules .= '</div><!-- .post-item -->';
                        $render_modules .= '</div><!-- .slide-content -->';
                    endif;
                endif;    
            endwhile;
            if($currentPost >= 0):
                if($currentPost % 2 != 0):
                    $render_modules .= '</div><!-- .atbs-ceris-carousel -->';  
                    $render_modules .= '</div><!-- .grid-carousel -->';
                    $render_modules .= '</div><!-- .grid-carousel--wrap -->';
                    $render_modules .= '</div><!-- .atbs-ceris-block__inner -->';
                else:
                    $render_modules .= '</div><!-- .slide-content -->';
                    $render_modules .= '</div><!-- .atbs-ceris-carousel -->';  
                    $render_modules .= '</div><!-- .grid-carousel -->';
                    $render_modules .= '</div><!-- .grid-carousel--wrap -->';
                    $render_modules .= '</div><!-- .atbs-ceris-block__inner -->';
                endif;
            endif;
            return $render_modules;
        }
    }
}