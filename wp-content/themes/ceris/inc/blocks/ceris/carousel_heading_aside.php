<?php
if (!class_exists('ceris_carousel_heading_aside')) {
    class ceris_carousel_heading_aside {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_carousel_heading_aside-');
            $carouselID = uniqid('carousel-');
            $moduleConfigs = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            $moduleConfigs['carouselID']    = $carouselID;
            $moduleConfigs['title']         = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );     
            $moduleConfigs['heading_color'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_color', true );
            $moduleConfigs['subtitle']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_subtitle', true );      
            $moduleConfigs['carousel_loop'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_carousel_loop', true ); 
            $moduleConfigs['orderby']       = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']          = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit']         = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit', true );
            $moduleConfigs['offset']        = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature']       = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['heading_background'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_background', true );            
            $moduleConfigs['editor_pick']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );
            
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = ' '.$moduleConfigs['custom_class'];
            }else {
                $moduleCustomClass = '';
            }
            $moduleConfigs['post_icon_animation'] = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon_animation', true );
            //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            $moduleConfigs['post_icon'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true );      
            $the_query = bk_get_query::ceris_query($moduleConfigs);              //get query
            
            //Check Margin
            $headingClass = '';
            $moduleConfigs['module_custom_spacing_option'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_module_custom_spacing_option', true );
            if($moduleConfigs['module_custom_spacing_option'] == 'disable'){
                $blockMarginTopClass = '';
            }else{
                //Spacing Between Elements
                $moduleConfigs['module_margin_top'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_module_margin_top', true );
                $moduleConfigs['heading_margin_bottom'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_margin_bottom', true );
                
                if($moduleConfigs['module_margin_top'] < 0) :
                    $blockMarginTopClass = 'atbs-custom-margin-top-minus-'.abs($moduleConfigs['module_margin_top']);
                elseif(($moduleConfigs['module_margin_top'] > 0)) :
                    $blockMarginTopClass = 'atbs-custom-margin-top-'.abs($moduleConfigs['module_margin_top']);
                else:
                    $blockMarginTopClass = '';
                endif;
                
                if($moduleConfigs['heading_margin_bottom'] != '') {
                    $headingClass .= ' atbs-custom-margin-bottom-'.abs($moduleConfigs['heading_margin_bottom']);
                }else {
                    $headingClass = '';
                }
            }
            
            $moduleConfigs['heading_class'] = $headingClass;
            //end Spacing Between Elements
            
            if($the_query->post_count < 4):
                $moduleConfigs['carousel_loop'] = 0;
            endif;
            
            if ( $the_query->have_posts() ) :
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin atbs-ceris-carousel-heading-aside '.$moduleCustomClass.'  '.$blockMarginTopClass.'">';
               	$block_str .= '<div class="container">';
                $block_str .= '<div class="row row--flex grid-gutter-20">';
                $block_str .= '<div class="col-xs-12 col-sm-3 col-md-3">';
                $block_str .= $this->heading($moduleConfigs);
    			$block_str .= '</div><!-- end column -->';
                
                $block_str .= '<div class="carousel-wrap col-xs-12 col-sm-9 col-md-9">';
                $block_str .= '<div id="'.$carouselID.'" class="owl-carousel js-carousel-3i20m" data-carousel-loop="'.$moduleConfigs['carousel_loop'].'">';
                $block_str .= $this->render_modules($the_query);            //render modules
                $block_str .= '</div>';
                $block_str .= '</div>';
                
                $block_str .= '</div>';
                $block_str .= '</div><!-- .container -->';
                $block_str .= '</div><!-- .atbs-ceris-block -->';
                        
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function heading( $moduleConfigs ) {
            if($moduleConfigs['heading_color'] != '') {
                $headingColorStyle = 'style="color: '.$moduleConfigs['heading_color'].'"';
            }else {
                $headingColorStyle = '';
            }
            $heading = '';
            $heading .= '<div class="carousel-heading carousel-heading--has-bg" style="background-color: '.$moduleConfigs['heading_background'].'">';
			$heading .= '<div class="block-carousel-heading block-heading--vertical '.$moduleConfigs['heading_class'].'">';
			$heading .= '<h4 class="block-carousel-heading__title" '.$headingColorStyle.'>'.$moduleConfigs['title'].'</h4>';
			$heading .= '<span class="block-heading__subtitle">'.$moduleConfigs['subtitle'].'</span>';
			$heading .= '</div>';
			$heading .= '<div class="atbs-ceris-carousel-nav-custom-holder" data-carouselID="'.$moduleConfigs['carouselID'].'">';
			$heading .= '<div class="owl-prev js-carousel-prev"><i class="mdicon mdicon-arrow_back"></i></div>';
			$heading .= '<div class="owl-next js-carousel-next"><i class="mdicon mdicon-arrow_forward"></i></div>';
			$heading .= '</div>';
			$heading .= '</div>';
            return $heading;
        }
        public function render_modules ($the_query){
            $render_modules = '';
            $postCardHTML = new atbs_card_1;
            $footerStyle = '1-col';
            $iconPosition = 'top-right';
            // Meta
            $meta = 8;
            $metaArray = ceris_core::bk_get_meta_list($meta);
            // Category Style ($cat)
            $catStyle = 2; //Overlap
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
                  
            $postAnimation = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon_animation', true );
            $bypasspostAnimationDetech = '';
            if($postAnimation == 'disable') {
                $bypasspostAnimationDetech = '';
            }else {
                $bypasspostAnimationDetech = ' icon-has-animation';
            }
                                          
            if ( $the_query->have_posts() ) :
                $postCardAttr = array (
                    'cat'               => $catStyle,
                    'catClass'          => $cat_Class,
                    'additionalClass'   => 'post--card-sm text-center posts-has-smaller-post-cat '.$bypasspostAnimationDetech,
                    'thumbSize'         => 'ceris-xs-16_9 400x225',
                    'typescale'         => 'typescale-2 custom-typescale-2--xs',
                    'additionalThumbClass'   => 'atbs-thumb-object-fit',
                    'meta'              => $metaArray,    
                    'footerType'        => $footerStyle,
                    'postIcon'          => $postIconAttr,                        
                );
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $postCardAttr['postID'] = get_the_ID();
                    if($bypassPostIconDetech != 1) {
                        $addClass = 'overlay-item--sm-p';
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType']   = ceris_core::bk_post_format_detect(get_the_ID());
                        }

                        $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'small', $iconPosition, $addClass);
                        
                        $postCardAttr['postIcon']    = $postIconAttr;
                    }
                    $render_modules .= '<div class="slide-content">';
                    $render_modules .= $postCardHTML->render($postCardAttr);
                    $render_modules .= '</div>';
                endwhile;
            endif;
            
            return $render_modules;
        }
    }
}