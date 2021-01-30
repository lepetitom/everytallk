<?php
if (!class_exists('ceris_featured_module_i')) {
    class ceris_featured_module_i {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_featured_module_i-');
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
            
            if ( $the_query->have_posts() ) :
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-feature-i '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
                $block_str .= ceris_core::bk_render_block_heading($page_info);
                $block_str .= '<div class="container">';
                $block_str .= '<div class="atbs-ceris-block__inner">';
                $block_str .= $this->render_modules($the_query);              //render modules
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
            $currentPost = 0;
            $smalltitle = '';
            $postSource = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_source', true );
            $smalltitle = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_small_title', true );
            $render_modules = '';
            $catStyle = 4;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            $postOverlayHTML = new ceris_post_overlay_7;        
            $postOverlayAttr = array (
                'cat'                    => $catStyle,
                'catClass'               => $cat_Class,
                'additionalClass'        => 'post--overlap-top-right post--overlap-height-650',
                'additionalThumbClass'   => 'post__thumb--overlap atbs-thumb-object-fit',
                'typescale'              => 'typescale-3 custom-typescale-3',
                'thumbSize'              => 'ceris-xl-16_9',
                'meta'                    => array('author_has_wrap', 'date'),
            );
            $postHorizontalHTML = new ceris_post_horizontal_1;         
            $postHorizontalAttr = array (
                'additionalClass'        => 'post--horizontal-md post--horizontal-md-thumb-160 post--horizontal-border',
                'additionalThumbClass'   => 'atbs-thumb-object-fit',
                'typescale'              => 'typescale-2 custom-typescale-2',
                'thumbSize'              => 'ceris-xxs-1_1',
                'meta'                    => array('date'),
            );
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
                    if($currentPost == 1):
                        $render_modules .= '<div class="sub-posts">';
                        if($smalltitle != ''):
                            $render_modules .= '<div class="block-heading">';
                            $render_modules .= '<h4 class="block-heading__title">'.$smalltitle.'  </h4>';
                            $render_modules .= '</div>';
                        endif;
                        $render_modules .= '<div class="sub-posts__inner">';
                        if($maxPosts > 3):
                            $render_modules .= '<div id="'.$carouselID.'" class="owl-carousel js-carousel-2i50m-number-effect atbs-ceris-carousel atbs-ceris-carousel-post-horizontal dots-circle nav-circle nav-border owl-drag">';
                        else:
                            $render_modules .= '<div id="'.$carouselID.'" class="carousel-visible flexbox-wrap flexbox-wrap-2i flex-space-50 atbs-ceris-carousel-post-horizontal dots-circle nav-circle nav-border owl-drag">';
                        endif;
                        
                    endif;
                    $render_modules .= '<div class="slide-content">';
                    $postHorizontalAttr['postID'] = get_the_ID();
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</div><!-- .slide-content -->'; 

                endif;
            endwhile;
            if($currentPost > 0):
                $render_modules .= '</div><!-- .owl-carousel -->'; 
                if($maxPosts > 3):
                    $render_modules .= '<div class="atbs-ceris-carousel-nav-custom-holder nav-circle nav-border flexbox-wrap flexbox-center-y" data-carouselid="'.$carouselID.'">'; 
                    $render_modules .= '<div class="owl-prev js-carousel-prev"><i class="mdicon mdicon-navigate_before"></i></div>';
                    $render_modules .= '<div id="numberSlide" class="owl-number">1 <span class="slide-seperated">/</span> 5</div>'; 
                    $render_modules .= '<div class="owl-next js-carousel-next"><i class="mdicon mdicon-navigate_next"></i></div>'; 
                    $render_modules .= '</div>'; 
                endif;
                $render_modules .= '</div><!-- .sub-posts__inner -->'; 
                $render_modules .= '</div><!-- .sub-posts -->'; 
            endif;
            return $render_modules;   
        }
    }
}