<?php
if (!class_exists('ceris_grid_d')) {
    class ceris_grid_d {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_grid_d-');
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config            $moduleConfigs['orderby']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
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
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-grid-d atbs-ceris-post--grid-b-update clearfix '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
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
            $iconPosition = '';
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
            $catStyle_L = 4;
            $cat_Class_L = ceris_core::bk_get_cat_class($catStyle_L);

            $catStyle = 3;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            
            $postMainHTML = new ceris_post_main;         
            $postMainAttr = array (
                'cat'                  => $catStyle_L,
                'catClass'             => $cat_Class_L,
                'additionalClass'      => 'post-meta--large post-fullwidth-text-center-top post__thumb-640 remove-margin-bottom-lastchild icon-right-center '.$bypasspostAnimationDetech.'',
                'additionalTextClass'  => 'remove-margin-bottom-lastchild',
                'additionalThumbClass' => 'post__img--overlay background-img atbs-thumb-object-fit',
                'thumbSize'            => 'ceris-xl-2_1',
                'iconPosition'         => 'right-center',
                'typescale'            => '',
                'meta'                 => array('author', 'date'),
//                'except_length'        => '15',
                'postIcon'             => $postIconAttr,
            );
            $postHorizontalHTML = new ceris_post_horizontal_1;         
            $postHorizontalAttr = array (
                'additionalClass'      => 'post--horizontal-thumb-radius post--horizontal-middle remove-margin-bottom-lastchild',
                'additionalTextClass'  => '',
                'additionalThumbClass' => 'atbs-thumb-object-fit',
                'typescale'            => 'typescale-1',
                'thumbSize'            => 'ceris-xxs-1_1',
                'postIcon'             => $postIconAttr,
                'meta'                 => array('date'),
            );
            $render_modules = '';
            $currentPost = '';
            $carouselID = uniqid('carousel-feature-slider-');
            
             while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                $maxPosts = $the_query->post_count;
                
                if($currentPost == 0):
                    $render_modules .= '<div class="post-main">';
                    $postMainAttr['postID'] = get_the_ID();
                    if($bypassPostIconDetech != 1) {
                        $addClass = '';
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                        }
                        $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $iconPosition, $addClass);
                        if(($postIconAttr['iconType'] == 'gallery') || ($postIconAttr['iconType'] == 'review')):
                            $postIconAttr['iconType'] = '';
                        endif;
                        $postMainAttr['postIcon'] = $postIconAttr;
                    }
                    $render_modules .= $postMainHTML->render($postMainAttr);
                    $render_modules .= '</div><!-- .post-main -->';
                elseif($currentPost > 0):
                    $postHorizontalAttr['postID'] = get_the_ID();
                    if($currentPost == 1):
                        $render_modules .= '<div class="post-sub">';
                        if(($maxPosts >= 1) && ($maxPosts < 5) ):
                            $render_modules .= '<div class="atbs-ceris-carousel dots-circle carousel-flex carousel-flex-space-20 ">';
                        else: 
                            $render_modules .= '<div class="owl-carousel js-carousel-3i30m5 atbs-ceris-carousel dots-circle">';
                        endif;
                    endif;
                    $render_modules .= '<div class="slide-content">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</div><!-- .slide-content -->';
                    if($currentPost == ($maxPosts - 1)):
                        $render_modules .= '</div><!-- .owl-carousel -->';
                        $render_modules .= '</div><!-- .post-sub -->';
                    endif;
                endif;
            endwhile;
            if(($currentPost > 0) && ($currentPost!= ($maxPosts - 1) )):
               $render_modules .= '</div><!-- .owl-carousel -->';
               $render_modules .= '</div><!-- .post-sub -->';
            endif;
            return $render_modules;
        }
    }
}