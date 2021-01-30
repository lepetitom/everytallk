<?php
if (!class_exists('ceris_grid_t')) {
    class ceris_grid_t {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_grid_t-');
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit']     = 5;
            $moduleConfigs['offset']    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );
            $moduleConfigs['load_more'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_load_more', true );
            
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = ' '.$moduleConfigs['custom_class'];
            }else {
                $moduleCustomClass = '';
            }
            $moduleConfigs['post_icon_animation'] = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon_animation', true );
            
            //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true ); 
            
            $moduleInfo = array(
                'post_source'   => $moduleConfigs['post_source'],
                'post_icon'     => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true ),
                'iconPosition_L'  => 'top-right',
                'iconPosition_S'  => 'top-right',
                'footerStyle'   => '1-col',
            );
              
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
            
            if ( $the_query->have_posts()) :
            $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-grid-t '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
           	$block_str .= ceris_core::bk_render_block_heading($page_info); 
            $block_str .= '<div class="container">';
            $block_str .= $this->render_modules($the_query, $moduleInfo);            //render modules
            $block_str .= '</div><!-- .container -->';
            $block_str .= '</div><!-- .atbs-ceris-block -->';
            
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_modules ($the_query, $moduleInfo = ''){
            //$postOverlayHTML = new ceris_update_overlay_1;
            $postOverlayHTML = new ceris_post_overlay_2;
            $postVerticalHTML = new ceris_update_vertical_1;
            $postHorizontalHTML = new ceris_update_horizontal_1;
            $currentPost = 0;
            $render_modules = '';
            
            $iconPosition_L = $moduleInfo['iconPosition_L'];
            $iconPosition_S = $moduleInfo['iconPosition_S'];
            $iconSize_L = 'medium';
            $iconSize_S = '';
            
            $postAnimation = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon_animation', true );
            
            $bypasspostAnimationDetech = '';
            if($postAnimation == 'disable') {
                $bypasspostAnimationDetech = '';
            }else {
                $bypasspostAnimationDetech = 'icon-has-animation';
            }
            
            // Category
            $cat_S_Style = 3;
            $cat_S_Class = ceris_core::bk_get_cat_class($cat_S_Style);
            
            $cat_L_Style = 4;
            $cat_L_Class = ceris_core::bk_get_cat_class($cat_L_Style);
            
            $postSource = $moduleInfo['post_source'];
            $postIcon = $moduleInfo['post_icon'];
            
            $bypassPostIconDetech = 0;         
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            if($postIcon == 'disable') {
                $bypassPostIconDetech = 1;
            }else {
                $bypassPostIconDetech = 0;
            }
            
            if ( $the_query->have_posts() ) :
                $postOverlayAttr = array (
                    'cat'                 => $cat_L_Style,
                    'catClass'            => $cat_L_Class.' overlay-item--top-left',
                    'additionalClass'     => 'post--overlay-bottom post--overlay-floorfade posts-has-smaller-post-cat '.$bypasspostAnimationDetech.'',
                    'additionalThumbClass'=> 'post__thumb--overlay atbs-thumb-object-fit',
                    'additionalTextClass' => 'inverse-text',
                    'thumbSize'           => 'ceris-s-4_3',
                    'typescale'           => 'typescale-2',
                    'postIcon'            => $postIconAttr,
                    'meta'                => array('author', 'date'),
                );
                $postVerticalAttr = array (
                    'cat'               => $cat_L_Style,
                    'catClass'          => $cat_L_Class,
                    'thumbSize'         => 'ceris-xs-4_3',
                    'additionalClass'   => 'posts-has-smaller-post-cat m-b-md '.$bypasspostAnimationDetech,
                    'additionalThumbClass'   => 'atbs-thumb-object-fit',
                    'typescale'         => 'typescale-2 custom-typescale-2',
                    'meta'              => array('date'),
                    'postIcon'          => $postIconAttr,
                );
                $postHorizontalAttr = array (
                    'additionalClass'   => 'post--horizontal-xs post--horizontal-reverse',
                    'thumbSize'         => 'ceris-xxs-1_1',
                    'additionalThumbClass'   => 'atbs-thumb-object-fit',
                    'typescale'         => 'typescale-1 custom-typescale-1',
                    'meta'              => array('date'),                    
                );
                $render_modules .= '<div class="row row--space-between">';
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $currentPost = $the_query->current_post;
                    if($currentPost == 0){
                        $colClass = "col-xs-12 col-sm-6 col-md-5";
                    }else if($currentPost == 1){
                        $colClass = "col-xs-12 col-sm-6 col-md-3";
                    }else{
                        $colClass = "col-xs-12 col-sm-12 col-md-4";
                    }
                    if($currentPost == 2){
                        $render_modules .= '<div class="'.$colClass.'">';
                        $render_modules .= '<ul class="posts-list list-space-sm list-unstyled list-seperated">';
                    }
                    if($currentPost == 0){
                        $postOverlayAttr['postID'] = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = ceris_core::bk_post_format_detect(get_the_ID());
                            }
                                                                                    
                            if($iconPosition_L == 'left-bottom') {
                                $postOverlayHTML = new ceris_overlay_icon_side_left;
                                if($postIconAttr['iconType'] != 'gallery') { 
                                    $postIconAttr['postIconClass']  = 'post-type-icon--md';
                                }else {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }
                                $postOverlayAttr['additionalTextClass'] = 'inverse-text';
                            }else if($iconPosition_L == 'right-bottom') {
                                $postOverlayHTML = new ceris_overlay_icon_side_right;
                                if($postIconAttr['iconType'] != 'gallery') { 
                                    $postIconAttr['postIconClass']  = 'post-type-icon--md';
                                }else {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }
                                $postOverlayAttr['additionalTextClass'] = 'inverse-text';
                            }else {
                                if($postIconAttr['iconType'] == 'gallery') {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }else {
                                    $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], $iconSize_L, $iconPosition_L);
                                }
                            }
                            
                            $postOverlayAttr['postIcon']    = $postIconAttr;
                        } 
                        $render_modules .= '<div class="'.$colClass.'">';
                        $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                        $render_modules .= '</div>';
                    }else if($currentPost == 1){
                        $postVerticalAttr['postID']         = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            $addClass = 'overlay-item--sm-p';
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = ceris_core::bk_post_format_detect(get_the_ID());
                            }
  
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], $iconSize_S, $iconPosition_S, $addClass);
                            
                            $postVerticalAttr['postIcon']    = $postIconAttr;
                            
                        }
                        $render_modules .= '<div class="'.$colClass.'">';
                        $postVerticalAttr['additionalClass']  = 'posts-has-smaller-post-cat post__thumb-200 '.$bypasspostAnimationDetech;
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                        $render_modules .= '</div>';
                    }else {
                        $postHorizontalAttr['postID'] = get_the_ID();
                        
                        $render_modules .= '<li>';
                        $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                        $render_modules .= '</li> <!-- end small item -->';
                    }
                endwhile;
                if($currentPost >= 2){
                    $render_modules .= '</ul></div>';
                }
                $render_modules .= '</div>';
            endif;
            
            return $render_modules;
        }
    }
}