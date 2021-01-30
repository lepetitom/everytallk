<?php
if (!class_exists('ceris_posts_block_grid_d_no_sidebar')) {
    class ceris_posts_block_grid_d_no_sidebar {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_posts_block_grid_d_no_sidebar-');
            
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;            
            
            //get config
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true );
            $moduleConfigs['limit']     = 4;
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
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris_posts_block_grid_d_no_sidebar '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
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
                $postVerticalAttr_2 = array (
                    'additionalClass'   => 'ceris-post-vertical--cat-overlay big-post--vertical post__thumb-420'.$bypasspostAnimationDetech,
                    'thumbSize'         => 'ceris-m-4_3',
                    'typescale'         => 'typescale-3 custom-typescale-3',
                    'postIcon'          => $postIconAttr,
                    'cat'               => $cat_Style,
                    'catClass'          => $cat_Class,
                    'additionalThumbClass'   => 'atbs-thumb-object-fit',
                    'postIcon'          => $postIconAttr,
                    'meta'                 => array('author_name', 'date'),
                );
                $postVerticalAttr = array (
                    'additionalClass'   => 'ceris-post-vertical--cat-overlay small-post--vertical post__thumb-180'.$bypasspostAnimationDetech,
                    'thumbSize'         => 'ceris-xs-16_9 400x225',
                    'typescale'         => 'typescale-2 custom-typescale-2--xs',
                    'cat'               => $cat_Style,
                    'catClass'          => $cat_Class,
                    'additionalThumbClass'   => 'atbs-thumb-object-fit',
                    'postIcon'          => $postIconAttr,
                    'meta'                 => array('date'),
                );
                $postHorizontalHTML = new ceris_post_horizontal_1;                     
                $postHorizontalAttr = array (
                    'additionalClass'   => 'post--horizontal-middle remove-margin-bottom-lastchild',
                    'cat'               => $cat_Style,
                    'catClass'          => $cat_Class,
                    'thumbSize'         => 'ceris-xs-4_3',
                    'typescale'         => 'typescale-2 custom-typescale-2',
                    'postIcon'          => $postIconAttr,  
                    'meta'              => array('date'),//'author_name', 
                );
                
                $postCardHTML = new atbs_card_1;
                $catStyle_card = 2; //Overlap
                $cat_card_Class = ceris_core::bk_get_cat_class($catStyle_card);
                $postCardAttr = array (
                    'cat'               => $catStyle_card,
                    'catClass'          => $cat_card_Class,
                    'additionalClass'   => 'post--card-sm text-center posts-has-smaller-post-cat '.$bypasspostAnimationDetech,
                    'thumbSize'         => 'ceris-xs-16_9 400x225',
                    'typescale'         => 'typescale-2 custom-typescale-2--xs',
                    'additionalThumbClass'   => 'atbs-thumb-object-fit',
                    'meta'              => ceris_core::bk_get_meta_list(8),    
                    'footerType'        => '1-col',
                    'postIcon'          => $postIconAttr,                        
                );
                $postCardAttr_L = array (
                    'cat'               => $catStyle_card,
                    'catClass'          => $cat_card_Class,
                    'additionalClass'   => 'post--card-lg text-center posts-has-smaller-post-cat '.$bypasspostAnimationDetech,
                    
                    'thumbSize'         => 'ceris-m-4_3',
                    'typescale'         => 'typescale-3 custom-typescale-3',
                    
                    'additionalThumbClass'   => 'atbs-thumb-object-fit',
                    'meta'              => ceris_core::bk_get_meta_list(8),    
                    'footerType'        => '1-col',
                    'postIcon'          => $postIconAttr,                        
                );
                $render_modules .= '<div class="row row--space-between flexbox">';
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $postVerticalAttr['postID'] = get_the_ID();
                
                    $currentPost = $the_query->current_post;
                    if($currentPost == 0) {
                        $postCardAttr_L['postID'] = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = ceris_core::bk_post_format_detect(get_the_ID());
                            }
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $iconPosition);
                            
                            $postCardAttr_L['postIcon']    = $postIconAttr;
                        }
                        
                        $render_modules .= '<div class="col-xs-12 col-sm-12 col-md-6 grid-top-left">';
                        $render_modules .= $postCardHTML->render($postCardAttr_L);
                        $render_modules .= '</div><!-- End The Main Column -->';
                    }elseif(($currentPost == 1) || ($currentPost == 2)) {
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
                        
                        
                        if($currentPost == 1) {
                            $render_modules .= '<div class="col-xs-12 col-sm-12 col-md-6">';
                            $render_modules .= '<div class="row row--space-between">';
                        }
                        $render_modules .= '<div class="col-sm-6">';  
                        $render_modules .= $postCardHTML->render($postCardAttr);
                        $render_modules .= '</div>';
                        if($currentPost == 2) {
                            $render_modules .= '</div>';
                        }
                    }else {
                        $postHorizontalAttr['postID'] = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            $addClass = '';
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                            }
    
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition, $addClass);
                            
                            $postHorizontalAttr['postIcon'] = $postIconAttr;
                        } 
                                                               
                        $render_modules .= '<div class="row row--space-between"><div class="horizontal-item col-xs-12 col-sm-12 col-md-12">';
                        $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                        $render_modules .= '</div></div><!-- .row row--space-between --></div>';
                    }
                endwhile;
                if(($currentPost == 1)) {
                    $render_modules .= '</div></div>';
                }elseif($currentPost == 2){
                    $render_modules .= '</div>';
                }
                
                $render_modules .= '</div><!-- .row row--space-between -->';
            endif;
            
            return $render_modules;
        }
    }
}