<?php
if (!class_exists('ceris_posts_block_grid_g_no_sidebar')) {
    class ceris_posts_block_grid_g_no_sidebar {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_posts_block_grid_g_no_sidebar-');
            
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
            
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = $moduleConfigs['custom_class'].' ';
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
                'iconPosition_S'  => 'top-righ',
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
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris_posts_block_grid_g_no_sidebar '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
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
            $currentPost = 0;
            $render_modules = '';
            
            $iconPosition = 'top-right';

            // Category

            $cat_Style = 4; //Above Title No BG
            $cat_Class = ceris_core::bk_get_cat_class($cat_Style);
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
            
            $postAnimation = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon_animation', true );
            $bypasspostAnimationDetech = '';
            if($postAnimation == 'disable') {
                $bypasspostAnimationDetech = '';
            }else {
                $bypasspostAnimationDetech = ' icon-has-animation';
            }
            
            if ( $the_query->have_posts() ) :
                $postVerticalHTML = new ceris_post_vertical_3;         
                $postVerticalAttr = array (
                    'cat'                 => $cat_Style,
                    'catClass'            => $cat_Class,
                    'additionalClass'     => 'ceris-post-vertical--cat-overlay post--vertical-text-not-fullwidth '.$bypasspostAnimationDetech,
                    'additionalTextClass' => '',
                    'additionalThumbClass' => 'atbs-thumb-object-fit',
                    'thumbSize'           => 'ceris-xs-4_3',
                    'typescale'           => 'typescale-2',
                    'postIcon'            => $postIconAttr,
                    'except_length'     => 15,
                    'meta'              => array('author_name', 'date'),
                );
                $postHorizontalHTML = new ceris_post_horizontal_1;         
                $postHorizontalAttr = array (
                    'cat'                  => $cat_Style,
                    'catClass'             => $cat_Class,
                    'additionalClass'      => 'post--horizontal-middle post--horizontal-reverse'.$bypasspostAnimationDetech,
                    'additionalThumbClass' => 'atbs-thumb-object-fit',
                    'thumbSize'            => 'ceris-xs-1_1',
                    'typescale'            => 'typescale-1 custom-typescale-1',
                    'except_length'        => 10,
                    'postIcon'             => $postIconAttr,
                    'meta'                 => array('date'),
                );
                $render_modules .= '<div class="post--grid flexbox flexbox-wrap-2i flexbox-wrap flex-space-50">';
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $currentPost = $the_query->current_post;
                    $maxPost = $the_query->post_count;
                    if($currentPost == 0) :
                        $postVerticalAttr['postID'] = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = ceris_core::bk_post_format_detect(get_the_ID());
                            }
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition);
                            $postVerticalAttr['postIcon']    = $postIconAttr;
                        }
                        $render_modules .= '<div class="post--grid-left">';
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                        $render_modules .= '</div><!-- post--grid-left -->';
                    else:
                        $postHorizontalAttr['postID'] = get_the_ID();
                        if($currentPost == 1):
                            $render_modules .= '<div class="post--grid-right ">';
                            $render_modules .= '<div class="posts-list flexbox flexbox-wrap flex-space-50">';
                            $postHorizontalAttr['additionalClass'] = 'post--horizontal-middle';
                        else:
                            $postHorizontalAttr['additionalClass'] = 'post--horizontal-middle post--horizontal-reverse';
                        endif;
                            $render_modules .= '<div class="post--grid-item">';
                            $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                            $render_modules .= '</div><!-- post--grid-item -->';
                    endif;
                endwhile;
                if($currentPost > 0):
                    $render_modules .= '</div><!-- posts-list -->';
                    $render_modules .= '</div><!-- post--grid-right -->';
                endif;
                $render_modules .= '</div><!-- post--grid -->';
            endif;
            
            return $render_modules;
        }
    }
}