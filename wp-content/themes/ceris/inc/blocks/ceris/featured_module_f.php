<?php
if (!class_exists('ceris_featured_module_f')) {
    class ceris_featured_module_f {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_featured_module_f-');
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
            $moduleConfigs['limit'] = 4;
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
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-feature-f '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
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
            if($bypassPostIconDetech == 0){
                $classIconRightCenter = ' icon-video-right-center';
            }else{
                $classIconRightCenter = '';
            }
            $postMainHTML = new ceris_post_overlay_container_text;         
            $postMainAttr = array (
                'cat'                  => $catStyle,
                'catClass'             => $cat_Class,
                'additionalClass'      => 'post-meta--large post--overlay-md post--overlay-height-735 post--overlay-feature-fullwidth '.$bypasspostAnimationDetech.$classIconRightCenter,
                'additionalTextClass'  => 'inverse-text',
                'additionalThumbClass' => 'post__thumb--overlay background-img atbs-thumb-object-fit',
                'thumbSize'            => 'ceris-xl-16_9',
                'typescale'            => 'typescale-4',
                'iconPosition'         => 'right-center',
                'meta'                 => array('author', 'date'),
                'postIcon'             => $postIconAttr,
            );
            $postOverlayHTML = new ceris_post_overlay_6;         
            $postOverlayAttr = array (
                'cat'                    => $catStyle,
                'catClass'               => $cat_Class,
                'additionalClass'        => 'post--overlay-padding-lg post--overlay-height-300 post--overlay-radius posts-has-smaller-post-cat',
                'additionalTextClass'    => 'inverse-text',
                'additionalThumbClass'   => 'post__thumb--overlay background-img atbs-thumb-object-fit',
                'typescale'              => 'typescale-2',
                'thumbSize'              => 'ceris-xs-16_9',
                'readmore'               => 1,
                'meta'                   => array('author'),
                'postIcon'               => $postIconAttr,

            );
            $postOverlayAttr_2 = array (
                'cat'                    => $catStyle,
                'catClass'               => $cat_Class,
                'additionalClass'        => 'post--overlay-bottom post--overlay-height-300 post--overlay-radius posts-has-smaller-post-cat',
                'additionalThumbClass'   => 'post__thumb--overlay background-img atbs-thumb-object-fit',
                'additionalTextClass'    => 'inverse-text',
                'typescale'              => 'typescale-2 custom-typescale-2--xs',
                'thumbSize'              => 'ceris-xs-1_1',
                'postIcon'               => $postIconAttr,

            );
            $render_modules = '';
            $currentPost = '';
            $carouselID = uniqid('carousel-feature-slider-');
            
            while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                
                if($currentPost == 0):
                    $render_modules .= '<div class="main-post">';
                    $postMainAttr['postID'] = get_the_ID();
                    if($bypassPostIconDetech != 1) {
                        $addClass = '';
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                        }
                        if(($postIconAttr['iconType'] == 'gallery') || ($postIconAttr['iconType'] == 'review')):
                            $postIconAttr['iconType'] = '';
                        endif;
                        $postMainAttr['postIcon'] = $postIconAttr;
                    }
                    $render_modules .= $postMainHTML->render($postMainAttr);
                    $render_modules .= '</div><!-- .main-post -->';
                elseif($currentPost > 0):
                    $postOverlayAttr['postID'] = get_the_ID();
                   
                    if($currentPost == 1):
                        $render_modules .= '<div class="sub-posts">';
                        $render_modules .= '<div class="container">';
                        $render_modules .= '<div class="posts-list flexbox-wrap flex-space-30">';
                        $render_modules .= '<div class="list-item">';
                        $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                        $render_modules .= '</div><!-- .list-item -->';
                    else:
                        $postOverlayAttr_2['postID'] = get_the_ID();
                        $render_modules .= '<div class="list-item">';
                        $render_modules .= $postOverlayHTML->render($postOverlayAttr_2);
                        $render_modules .= '</div><!-- .list-item -->';
                    endif;
                    if($currentPost == 3):
                        $render_modules .= '</div><!-- .post-list -->';
                        $render_modules .= '</div><!-- .container -->';
                        $render_modules .= '</div><!-- .sub-posts -->';
                    endif;
                endif;
            endwhile;
            if(($currentPost > 0) && ($currentPost!= 3 )):
               $render_modules .= '</div><!-- .post-list -->';
               $render_modules .= '</div><!-- .container -->';
               $render_modules .= '</div><!-- .sub-posts -->';
            endif;
            return $render_modules;    
            
                                                                        
        }
    }
}