<?php
if (!class_exists('ceris_featured_module_h')) {
    class ceris_featured_module_h {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_featured_module_h-');
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
            $moduleConfigs['limit'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit', true );
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = $moduleConfigs['custom_class'].' ';
            }else {
                $moduleCustomClass = '';
            }
            //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            
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
            //end Spacing Between Elements
            if ( $the_query->have_posts() ) :
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-feature-h '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
                $block_str .= ceris_core::bk_render_block_heading($page_info);
                $block_str .= '<div class="atbs-ceris-block__inner">';
                $block_str .= $this->render_modules($the_query);              //render modules
                $block_str .= '</div><!-- .atbs-ceris-block__inner -->';
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
            
            $catStyle = 4;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            $postOverlayHTML = new ceris_post_overlay_container_text;        
            $postOverlayAttr = array (
                'cat'                    => $catStyle,
                'catClass'               => $cat_Class,
                'additionalClass'        => 'post-meta--large post--overlay-md post--overlay-height-790 post--overlay-feature-fullwidth post--overlay-feature-fullwidth-middle',
                'additionalTextClass'    => 'inverse-text',
                'additionalThumbClass'   => 'background-img post__thumb--overlay atbs-thumb-object-fit',
                'typescale'              => 'typescale-4',
                'meta'                   => array('author', 'date'),
                'except_length'          => 15,
                'thumbSize'              => 'ceris-xl-16_9',
            );
           
            $catStyle = 3;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            $postOverlayHTML_2 = new ceris_post_overlay_7;         
            $postOverlayAttr_2 = array (
                'cat'                    => $catStyle,
                'catClass'               => $cat_Class.' post__cat-has-line',
                'additionalClass'        => 'post--overlay-bottom post--overlay-height-275 post--card-overlay-no-background',
                'additionalThumbClass'   => 'post__thumb--overlay atbs-thumb-object-fit',
                'typescale'              => 'typescale-2 custom-typescale-2--xs',
                'thumbSize'              => 'ceris-xs-4_3',
                'meta'                   => array('author_horizontal'),
                'readmore'               => 1,
            );
            $render_modules = '';
            $currentPost = '';
            $carouselID = uniqid('carousel-feature-slider-');
            while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                $maxPosts = $the_query->post_count;
                if($currentPost == 0):
                    $render_modules .= '<div class="main-post">';
                    $postOverlayAttr['postID'] = get_the_ID();  
                    $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                    $render_modules .= '</div><!-- .main-post -->';
                else:
                    if($currentPost > 0):
                        if($currentPost == 1):
                            $render_modules .= '<div class="atbs-ceris-carousel-wrapper">';
                            if($maxPosts == 2):
                                $render_modules .= '<div class="atbs-ceris-carousel-post-overlay dots-circle nav-circle nav-border">';
                            else:
                                $render_modules .= '<div id="'.$carouselID.'" class="owl-carousel js-carousel-2i30m-number-effect atbs-ceris-carousel atbs-ceris-carousel-post-overlay dots-circle nav-circle nav-border">';
                            endif;
                        endif;
                        $render_modules .= '<div class="slide-content">';
                        $postOverlayAttr_2['postID'] = get_the_ID();
                        $render_modules .= $postOverlayHTML_2->render($postOverlayAttr_2);
                        $render_modules .= '</div><!-- .slide-content -->'; 
                    endif;
                endif;
            endwhile;
            if($currentPost > 0):
                $render_modules .= '</div><!-- .atbs-ceris-carousel -->';
                if($maxPosts != 2):
                $render_modules .= '<div class="atbs-ceris-carousel-nav-custom-holder nav-circle nav-border flexbox-wrap flexbox-center-y" data-carouselid="'.$carouselID.'">
                    <div class="owl-prev js-carousel-prev"><i class="mdicon mdicon-navigate_before"></i></div>
                    <div id="numberSlide" class="owl-number">1 <span class="slide-seperated">/</span> 5</div>
                    <div class="owl-next js-carousel-next"><i class="mdicon mdicon-navigate_next"></i></div>
                </div> <!-- atbs-ceris-carousel-nav-custom--->';
                endif;
                $render_modules .= '</div> <!-- atbs-ceris-carousel-wrapper--->';
            endif;
            return $render_modules;   
        }
    }
}