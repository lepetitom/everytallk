<?php
if (!class_exists('ceris_grid_b')) {
    class ceris_grid_b {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_grid_b-');
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
            $moduleConfigs['limit'] = 3;
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            $moduleConfigs['style_reverse']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_style_reverse', true );
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = $moduleConfigs['custom_class'].' ';
            }else {
                $moduleCustomClass = '';
            }
            
            //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            $moduleConfigs['post_icon'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true );      
            $moduleConfigs['post_icon_animation'] = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon_animation', true );

            if(isset($moduleConfigs['style_reverse']) && ($moduleConfigs['style_reverse'] != 'default')) {
                $moduleReverseClass = 'ceris-grid-b-reverse';
            }else {
                $moduleReverseClass = '';
            }
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
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-grid-b atbs-ceris-post--overlay-first-big '.$moduleReverseClass.' '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
                $block_str .= ceris_core::bk_render_block_heading($page_info);
                $block_str .= '<div class="container">';
                $block_str .= '<div class="atbs-ceris-block__inner atbs-ceris-multiple-style--vertical-full__inner clearfix">';
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
            
            $postOverlayHTML = new ceris_post_overlay_2;         
            $postOverlayAttr = array (
                'cat'                 => $catStyle,
                'catClass'            => $cat_Class.' overlay-item--top-left',
                'additionalClass'     => 'post--overlay-bottom post--overlay-floorfade post--overlay-sm posts-has-smaller-post-cat '.$bypasspostAnimationDetech.'',
                'additionalTextClass' => 'inverse-text',
                'thumbSize'           => 'ceris-xs-1_1',
                'additionalThumbClass'=> 'post__thumb--overlay background-img atbs-thumb-object-fit',
                'typescale'           => 'typescale-2 custom-typescale-2--xs',
                'meta'                => array('date'),
                'postIcon'            => $postIconAttr,
            );
            $postOverlayAttr_L = array (
                'cat'                 => $catStyle,
                'catClass'            => $cat_Class.' overlay-item--top-left',
                'additionalClass'     => 'post--overlay-bottom post--overlay-floorfade post--overlay-sm posts-has-smaller-post-cat '.$bypasspostAnimationDetech.'',
                'additionalThumbClass'=> 'post__thumb--overlay background-img atbs-thumb-object-fit',
                'additionalTextClass' => 'inverse-text',
                'thumbSize'           => 'ceris-s-4_3',
                'typescale'           => 'typescale-3 custom-typescale-3',
                'meta'                => array('author_name', 'date'),
                'postIcon'            => $postIconAttr,
            );
            $render_modules = '';
            $currentPost = '';
            $render_modules .= '<div class="post-list flexbox">';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                if($currentPost == 0):
                    if($bypassPostIconDetech != 1) {
                        $addClass = ''; //overlay-item--sm-p
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                        }
                        $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition, $addClass);
                        $postOverlayAttr_L['postIcon'] = $postIconAttr;
                    } 
                    $postOverlayAttr_L['postID'] = get_the_ID();
                    $render_modules .= '<div class="post-item">'; 
                    $render_modules .= $postOverlayHTML->render($postOverlayAttr_L);
                    $render_modules .= '</div><!-- .post-item -->';   
                elseif($currentPost > 0):
                    if($bypassPostIconDetech != 1) {
                        $addClass = '';
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                        }
                        $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'small', $iconPosition, $addClass);
                        $postOverlayAttr['postIcon'] = $postIconAttr;
                    } 
                    $postOverlayAttr['postID'] = get_the_ID();
              
                    $render_modules .= '<div class="post-item flexbox__item">'; 
                    $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                    $render_modules .= '</div><!-- .post-item -->'; 
                endif;
            endwhile;
            $render_modules .= '</div><!-- post-list flexbox -->';
            return $render_modules;            
        }
    }
}