<?php
if (!class_exists('ceris_featured_module_m')) {
    class ceris_featured_module_m {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_featured_module_m-');
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
            $moduleConfigs['limit'] = 7;
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
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-feature-m '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
                $block_str .= ceris_core::bk_render_block_heading($page_info);
                $block_str .= '<div class="container">';
                $block_str .= '<div class="atbs-ceris-block__inner flexbox-wrap flex-space-40">';
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
                $bypasspostAnimationDetech = ' icon-has-animation';
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
                'cat'                    => $catStyle,
                'catClass'               => $cat_Class,
                'additionalClass'        => 'ceris-post-vertical--cat-overlay post--vertical-large-70',
                'additionalTextClass'    => $bypasspostAnimationDetech,
                'thumbSize'              => 'ceris-xs-16_9',
                'typescale'              => 'typescale-3 custom-typescale-3',
                'meta'                   => array('author_name', 'date'),
            );
            $postVerticalAttr_2 = array (
                'cat'                    => $catStyle,
                'catClass'               => $cat_Class,
                'additionalClass'        => 'posts-has-smaller-post-cat ceris-post-vertical--cat-overlay post--vertical-small-normal',
                'additionalTextClass'    => $bypasspostAnimationDetech,
                'typescale'              => 'typescale-1',
                'thumbSize'              => 'ceris-xs-4_3',
                'meta'                   => array('date'),
            );
           
            $postOverlayHTML = new ceris_post_overlay_2;         
            $postOverlayAttr = array (
                'cat'                    => $catStyle,
                'catClass'               => $cat_Class.' overlay-item--top-left',
                'additionalClass'        => 'post--overlay-small-text-normal post--overlay-bottom post--overlay-floorfade posts-has-smaller-post-cat post--overlay-height-360 post--overlay-top-bottom',
                'additionalThumbClass'   => 'post__thumb--overlay atbs-thumb-object-fit',
                'additionalTextClass'   => 'inverse-text'.$bypasspostAnimationDetech,
                'typescale'              => 'typescale-2 custom-typescale-2',
                'thumbSize'              => 'ceris-xs-1_1',
                'meta'                   => array('date'),
            );
            $render_modules = '';
            $currentPost = '';
            $carouselID = uniqid('carousel-feature-slider-');
            while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                $maxPosts = $the_query->post_count;
                if($currentPost < 3):
                    if($currentPost == 0):
                        $render_modules .= '<div class="post-main flexbox-wrap flex-space-30">';
                        $render_modules .= '<div class="post-main-center">';
                        $postVerticalAttr['postID'] = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            $addClass = '';
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                            }
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition, $addClass);
                            $postVerticalAttr['postIcon'] = $postIconAttr;
                        } 
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                        $render_modules .= '</div><!-- .post-main-center -->';
                    else: 
                        $postOverlayAttr['postID'] = get_the_ID();
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
                        if($currentPost == 1):
                            $render_modules .= '<div class="post-main-left">';
                            
                            $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                            $render_modules .= '</div><!-- .post-main-left -->'; 
                        else:
                            $render_modules .= '<div class="post-main-right">';
                            $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                            $render_modules .= '</div><!-- .post-main-right -->'; 
                            $render_modules .= '</div><!-- .post-main -->'; 
                        endif;
                    endif;
                else:
                    if($currentPost == 3) :
                        $render_modules .= '<div class="post-sub">';
                        $render_modules .= '<div class="posts-list flexbox-wrap flexbox-wrap-4i flex-space-30">';
                    endif;
                        $postVerticalAttr_2['postID'] = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            $addClass = '';
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                            }
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'small', $iconPosition, $addClass);
                            $postVerticalAttr_2['postIcon'] = $postIconAttr;
                        } 
                        $render_modules .= '<div class="list-item">';
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr_2);
                        $render_modules .= '</div><!-- .list-item -->'; 
                endif;
            endwhile;
            if($maxPosts < 3):
                $render_modules .= '</div><!-- .post-main -->'; 
            endif;
            if($currentPost > 2):
                $render_modules .= '</div><!-- .post-list -->'; 
                $render_modules .= '</div><!-- .post-sub -->'; 
            endif;
            return $render_modules;
        }
    }
}