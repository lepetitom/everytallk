<?php
if (!class_exists('ceris_grid_w')) {
    class ceris_grid_w {
        static $pageInfo=0;
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_grid_w-');
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
            
            $moduleConfigs['ajax_load_more'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_ajax_load_more', true );
            $viewallButton = array();
            if ($moduleConfigs['ajax_load_more'] == 'viewall') :            
                $viewallButton['view_all_link'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_link', true );
                $viewallButton['view_all_text'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_text', true );
                $viewallButton['view_all_target'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_target', true );
            endif;
            
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = ' '.$moduleConfigs['custom_class'];
            }else {
                $moduleCustomClass = '';
            }
            
            $moduleConfigs['post_icon_animation'] = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon_animation', true );
            //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            $moduleInfo = array(
                'post_source'         => $moduleConfigs['post_source'],
                'post_icon'           => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true ),
                'iconPosition'        => 'center',
                'post_icon_animation' => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon_animation', true ),
            );
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);   
            $the_query = bk_get_query::ceris_query($moduleConfigs, $moduleID);              //get query
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
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-grid-w '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
               	$block_str .= ceris_core::bk_render_block_heading($page_info);
                $block_str .= '<div class="container">';
                $block_str .= '<div class="atbs-ceris-block__inner">';
                $block_str .= $this->render_slider($the_query, $moduleInfo);            //render Slider
                $block_str .= '</div><!-- .atbs-ceris-block__inner -->';
                $block_str .= '</div><!-- container -->';
                $block_str .= '</div><!-- .atbs-ceris-block -->';
            endif;
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_slider($the_query, $moduleInfo=''){
            $iconPosition = 'top-right';
            $iconPosition = 'top-right';
            $postSource = $moduleInfo['post_source'];
            $postIcon = $moduleInfo['post_icon'];
            
            $bypassPostIconDetech = 0;         
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postAnimation = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon_animation', true );
            
            $bypasspostAnimationDetech = '';
            if($postAnimation == 'disable') {
                $bypasspostAnimationDetech = '';
            }else {
                $bypasspostAnimationDetech = 'icon-has-animation';
            }
            $catStyle = 3;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            
            if($postIcon == 'disable') {
                $bypassPostIconDetech = 1;
            }else {
                $bypassPostIconDetech = 0;
            }
            $postVerticalHTML = new ceris_update_vertical_5;
            $postVerticalAttr = array (
                'additionalClass'   => 'post--vertical-slide-no-thumb time-opacity '.$bypasspostAnimationDetech,
                'cat'               => $catStyle,
                'catClass'          => $cat_Class.' cat-color-logo post__cat-has-line',
                'thumbSize'         => 'ceris-l-2_1',
                'additionalThumbClass'   => 'atbs-thumb-object-fit',
                'typescale'         => 'typescale-2',
                'except_length'     => 17,
                'postIcon'          => $postIconAttr,  
            );
            $render_slider = '';
            $currentPost = '';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                $maxPosts = $the_query->post_count;
                if(($currentPost >= 0)):
                    if($currentPost == 0):
                        $render_slider .= '<div class="post-slide post-main">';
                        $render_slider .= '<div class="owl-background">';
                        $render_slider .= '<a href="'.get_permalink(get_the_ID()).'">
                                <img src="'.get_the_post_thumbnail_url(get_the_ID(), 'ceris-l-2_1').'" alt="owl-bg" srcset="" class="owl-background-img active">
                            </a>';
                        $render_slider .= '<a href="'.get_permalink(get_the_ID()).'">
                                <img src="'.get_the_post_thumbnail_url(get_the_ID(), 'ceris-l-2_1').'" alt="owl-bg" srcset="" class="owl-background-img">
                            </a>';
                        $render_slider .= '</div>';
                        $render_slider .= '<div class="owl-carousel js-atbs-ceris-carousel-1i-dot-number-effect atbs-ceris-carousel dots-circle">';  
                    endif;
                    $postVerticalAttr['postID'] = get_the_ID();
                    $render_slider .= '<div class="slide-content">';
                    $render_slider .= $postVerticalHTML->render($postVerticalAttr);
                    $render_slider .= '</div><!--.slide-content-->';
                endif; 
            endwhile;
            $render_slider .= '</div><!--.owl-carousel-->';
            $render_slider .= '</div><!--.post-slide post-main -->';
            return $render_slider;
        }
        public function render_posts_grid($the_query, $moduleInfo= ''){
            $render_modules = '';
            if ($the_query->have_posts() ): 
                $render_modules .= '<div class="post-sub">';
                $render_modules .= '<div class="post-list posts-list">';
                $render_modules .= $this->render_grid_items($the_query, $moduleInfo);            //render modules
                $render_modules .= '</div><!--.post-list-->';
                $render_modules .= '</div><!--.post-sub-->';
            endif;
            return $render_modules;    
        }
        public function render_grid_items($the_query, $moduleInfo= ''){
            $iconPosition = 'top-right';
            $postSource = $moduleInfo['post_source'];
            $postIcon = $moduleInfo['post_icon'];
            $bypassPostIconDetech = 0;         
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            $postAnimation = $moduleInfo['post_icon_animation'];
            
            $bypasspostAnimationDetech = '';
            if($postAnimation == 'disable') {
                $bypasspostAnimationDetech = '';
            }else {
                $bypasspostAnimationDetech = 'icon-has-animation';
            }
            $catStyle = 3;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            if($postIcon == 'disable') {
                $bypassPostIconDetech = 1;
            }else {
                $bypassPostIconDetech = 0;
            }            
            $postVerticalHTML = new ceris_update_vertical_1;
            $postVerticalAttr_2 = array (
                'additionalClass'         => ''.$bypasspostAnimationDetech,
                'thumbSize'         => 'ceris-xs-1_1',
                'typescale'         => 'typescale-1',
                'postIcon'          => $postIconAttr,
                'cat'               => $catStyle,
                'catClass'          => $cat_Class.' cat-color-logo post__cat-has-line',
                'additionalThumbClass'   => 'atbs-thumb-object-fit',
                'postIcon'          => $postIconAttr,
            );

            $render_modules = '';
            $currentPost = '';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                $maxPosts = $the_query->post_count;
                if($bypassPostIconDetech != 1) {
                    if($postSource != 'all') {
                        $postIconAttr['iconType'] = $postSource;
                    }else {
                        $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                    }
                    $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'small', $iconPosition, '');
                    $postVerticalAttr_2['postIcon'] = $postIconAttr;
                }     
                $render_modules .= '<div class="list-item">';
                $postVerticalAttr_2['postID'] = get_the_ID();
                $render_modules .= $postVerticalHTML->render($postVerticalAttr_2);
                $render_modules .= '</div><!--.list-item-->';  
            endwhile;     
            return $render_modules;
        }
    }
}