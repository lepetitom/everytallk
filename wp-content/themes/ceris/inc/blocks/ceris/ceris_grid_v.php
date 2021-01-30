<?php
if (!class_exists('ceris_grid_v')) {
    class ceris_grid_v {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_grid_v-');
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit']     = 3;
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
                'iconPosition'  => 'top-right',
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
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-grid-v posts--vertical-first-big atbs-ceris-grid-v '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
                $block_str .= '<div class="atbs-ceris-block__inner">';
                $block_str .= ceris_core::bk_render_block_heading($page_info); 
               	$block_str .= '<div class="container">';
                $block_str .= '<div class="post-list">';
                $block_str .= $this->render_modules($the_query, $moduleInfo);            //render modules
                $block_str .= '</div><!-- .post-list -->';
                $block_str .= '</div><!-- .container -->';
                $block_str .= '</div><!-- .atbs-ceris-block__inner -->';
                $block_str .= '</div><!-- .atbs-ceris-block -->';
            endif;
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_modules ($the_query, $moduleInfo = ''){
            $currentPost = 0;
            $render_modules = '';
            
            $iconPosition= $moduleInfo['iconPosition'];
            $iconSize = 'medium';
            // Category
            
            $cat_Style = 4; //Top-left
            $cat_Class = ceris_core::bk_get_cat_class($cat_Style);
            
            $postAnimation = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon_animation', true );
            
            $bypasspostAnimationDetech = '';
            if($postAnimation == 'disable') {
                $bypasspostAnimationDetech = '';
            }else {
                $bypasspostAnimationDetech = 'icon-has-animation';
            }
            
            $excerptLength = 20;
            
            //Footer Style
            $footerArgs = array();
            $footerStyle = $moduleInfo['footerStyle'];
            $footerArgs = ceris_core::bk_overlay_footer_style($footerStyle);
            
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
                $postVerticalHTML = new ceris_post_vertical_3;
                $postVerticalAttr = array (
                    'cat'               => $cat_Style,
                    'catClass'          => $cat_Class,
                    'thumbSize'         => 'ceris-s-4_3',
                    'typescale'         => 'typescale-3 custom-typescale-3',
                    'additionalThumbClass'   => 'atbs-thumb-object-fit ceris-post-vertical--cat-overlay',
                    'postIcon'          => $postIconAttr,
                    'meta'                 => array('author_name', 'date'),
                );
                
                $postVerticalAttr_S = array (
                    'cat'               => $cat_Style,
                    'catClass'          => $cat_Class,
                    'thumbSize'         => 'ceris-s-4_3',
                    'typescale'         => 'typescale-2 custom-typescale-2',
                    'additionalThumbClass'   => 'atbs-thumb-object-fit ceris-post-vertical--cat-overlay',
                    'postIcon'          => $postIconAttr,
                    'meta'                 => array('author_name', 'date'),
                );
                
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $currentPost = $the_query->current_post;
                    
                    $render_modules .= '<div class="list-item">';
                    if($currentPost == 0):
                        if($bypassPostIconDetech != 1) {
                            $addClass = 'overlay-item--sm-p';
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = ceris_core::bk_post_format_detect(get_the_ID());
                            }
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], $iconSize, $iconPosition, $addClass);
                            $postVerticalAttr['postIcon']    = $postIconAttr;
                        }
                        $postVerticalAttr['additionalClass'] = 'post--vertical-first-big post--vertical-of-post-first-big post__thumb-360 '.$bypasspostAnimationDetech;
                        $postVerticalAttr['postID'] = get_the_ID();
                        
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                    elseif ($currentPost > 0 ):
                        $iconSize = '';
                        if($bypassPostIconDetech != 1) {
                            $addClass = 'overlay-item--sm-p';
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = ceris_core::bk_post_format_detect(get_the_ID());
                            }
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], $iconSize, $iconPosition, $addClass);
                            $postVerticalAttr_S['postIcon']    = $postIconAttr;
                        }
                        $postVerticalAttr_S['thumbSize'] = 'ceris-xs-1_1';
                        $postVerticalAttr_S['additionalClass'] = 'post--vertical-of-post-first-big post__thumb-360 '.$bypasspostAnimationDetech;
                        $postVerticalAttr_S['postID'] = get_the_ID();
                        
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr_S);
                    endif;
                    $render_modules .= '</div>';
                endwhile;
            endif;
            return $render_modules;
            
        }
    }
}