<?php
if (!class_exists('ceris_listing_grid_has_slider')) {
    class ceris_listing_grid_has_slider {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_listing_grid_has_slider-');
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            $moduleConfigs['small_heading'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_small_heading', true );
            $moduleConfigs['orderby']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true );
            $moduleConfigs['offset'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );
            $moduleConfigs['limit'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit', true );;
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
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-listing-grid-has-slider atbs-ceris-post--vertical-3i-row '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
                $block_str .= ceris_core::bk_render_block_heading($page_info, 'container-768');
                $block_str .= '<div class="container container-768">';
                $block_str .= '<div class="atbs-ceris-block__inner atbs-ceris-post--vertical-3i-row__inner">';
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
            $postSource = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_source', true );
            $postIcon = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon', true );
            $small_heading  =  get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_small_heading', true );
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
            
            $postVerticalHTML = new ceris_post_vertical_3;         
            $postVerticalAttr = array (
                'cat'                 => $catStyle,
                'catClass'            => $cat_Class,
                'additionalClass'     => 'ceris-post-vertical--cat-overlay '.$bypasspostAnimationDetech.'',
                'additionalTextClass' => '',
                'thumbSize'           => 'ceris-xs-4_3',
                'typescale'           => 'typescale-2',
                'postIcon'            => $postIconAttr,
                'meta'                 => array('author_name', 'date'),
            );
            $postHorizontalHTML = new ceris_post_horizontal_1;         
            $postHorizontalAttr = array (
                'additionalClass'     => 'post--horizontal-middle post--horizontal-xs remove-margin-bottom-lastchild',
                'additionalTextClass' => 'remove-margin-bottom-lastchild',
                'thumbSize'           => 'ceris-xxs-1_1',
                'typescale'           => 'typescale-1 custom-typescale-1',
                'postIcon'            => $postIconAttr,
                'meta'                => array('date'),
            );
            $render_modules = '';
            $currentPost = '';
            
            while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                $maxPosts = $the_query->post_count;
                if( (($currentPost >= 0) && ($currentPost < 3) ) || ($currentPost > ($maxPosts - 4)) || ($maxPosts <= 8 )):
                    if($bypassPostIconDetech != 1) {
                        $addClass = '';
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                        }
                        $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'small', $iconPosition, $addClass);
                        $postVerticalAttr['postIcon'] = $postIconAttr;
                    } 
                    $postVerticalAttr['postID'] = get_the_ID();
                    $render_modules .= '<div class="col-item">'; 
                    $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                    $render_modules .= '</div><!-- .col-item -->';   
                  endif;  
                  if(($currentPost >= 3) && ($currentPost < ($maxPosts - 3)) && ($maxPosts > 8) ):
                        
                        $postHorizontalAttr['postID'] = get_the_ID();
                        if($currentPost == 3):
                            $render_modules .= '<div class="col-item col-item-fullwidth slide-post--horizontal">'; 
                            
                            if($small_heading != ''):
                                $render_modules .= '<div class="block-heading block-heading--center">'; 
                                $render_modules .= '<h4 class="block-heading__title">';
                                $render_modules .= ceris_core::bk_get_gwen_module_small_heading($small_heading);
                                $render_modules .= '</h4>';
        					    $render_modules .= '</div>';
                            endif;
                            $render_modules .= '<div class="owl-carousel dots-circle atbs-ceris-carousel js-carousel-3i30m">';
                        endif;
                        
                        $render_modules .= '<div class="slide-content">';
                        $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                        $render_modules .= '</div><!-- .slide-content -->';
                        if($currentPost == ($maxPosts - 4)):
                            $render_modules .= '</div><!-- .owl-carousel js-carousel-3i30m -->';
                            $render_modules .= '</div><!-- .col-item col-item-fullwidth slide-post--horizontal -->';
                        endif;   
                  endif;
            endwhile;
            if(($currentPost >= 3) && ($currentPost <= ($maxPosts - 3)) && ($maxPosts >= 9 )):
                $render_modules .= '</div><!-- .owl-carousel js-carousel-3i30m -->';
                $render_modules .= '</div><!-- .col-item col-item-fullwidth slide-post--horizontal -->';            
            endif;
            return $render_modules;
        }
    }
}