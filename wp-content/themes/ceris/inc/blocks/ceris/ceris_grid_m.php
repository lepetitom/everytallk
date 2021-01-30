<?php
if (!class_exists('ceris_grid_m')) {
    class ceris_grid_m {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_grid_m-');
            
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            $moduleConfigs['small_title']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_small_title', true );      
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit', true );
            $moduleConfigs['offset']    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );
            $moduleConfigs['background_style'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_style', true );
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = ' '.$moduleConfigs['custom_class'];
            }else {
                $moduleCustomClass = '';
            }
            
            //Post Source & Icon
            $moduleConfigs['post_icon_animation'] = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon_animation', true );
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            $moduleConfigs['post_icon'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true );      
            $the_query = bk_get_query::ceris_query($moduleConfigs);              //get query
            
            $backgroundWhite = '';
            if($moduleConfigs['background_style'] == 'background_white'):
                $backgroundWhite = 'background-version-white';
            elseif($moduleConfigs['background_style'] == 'background_gray'):
                $backgroundWhite = 'background-version-gray';
            endif;
    
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
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-grid-m '.$backgroundWhite.' '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
                $block_str .= ceris_core::bk_render_block_heading($page_info);
                $block_str .= '<div class="container">';
                $block_str .= '<div class="atbs-ceris-block__inner">';
                $block_str .= $this->render_modules($the_query);            //render modules
                $block_str .= '</div><!-- .atbs-ceris-block__inner -->';
                $block_str .= '</div>';
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
            $smallTile = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_small_title', true );
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
            
            $catStyle = 4;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            
            if($postIcon == 'disable') {
                $bypassPostIconDetech = 1;
            }else {
                $bypassPostIconDetech = 0;
            }            
            $postOverlayHTML = new ceris_update_overlay_5;
            $postOverlayAttr = array (
                'additionalClass'        => 'post--overlay-height-460 posts-has-smaller-post-cat inverse-text post-grid-video-space-between time-opacity '.$bypasspostAnimationDetech.'',
                'cat'                    => $catStyle,
                'catClass'               => $cat_Class,
                'thumbSize'              => 'ceris-m-4_3',
                'additionalThumbClass'   => 'post__thumb--overlay atbs-thumb-object-fit background-img background-img--darkened',
                'typescale'              => '',
                'iconPosition'           => 'right-center',
                'postIcon'               => $postIconAttr,  
                'meta'                   => array('author_has_wrap', 'date'),
            );
            $postHorizontalHTML = new ceris_update_horizontal_2;
            $postHorizontalAttr = array (
                'additionalClass'        => 'post--horizontal-video',
                'thumbSize'              => 'ceris-xxs-1_1',
                'additionalThumbClass'   => 'atbs-thumb-object-fit',
                'additionalTextClass'    => 'inverse-text',
                'typescale'              => 'typescale-1 custom-typescale-1',
                'postIcon'               => $postIconAttr,  
            );
            $render_modules = '';
            $currentPost = '';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                $maxPosts = $the_query->post_count;
                if($currentPost == 0):
                    $postOverlayAttr['postID'] = get_the_ID();
                    if($bypassPostIconDetech != 1) {
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                        }
                        //$postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', '', '');
                        if(($postIconAttr['iconType'] == 'gallery') || ($postIconAttr['iconType'] == 'review')):
                            $postIconAttr['iconType'] = '';
                        endif;
                        $postOverlayAttr['postIcon'] = $postIconAttr;
                    }
                    $render_modules .= '<div class="post-main">';
                    $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                    $render_modules .= '</div><!-- .post-main -->';
                elseif($currentPost > 0):
                    
                    if($currentPost == 1):
                        $render_modules .= '<div class="post-sub">';
                        if($smallTile != ''):
                            $render_modules .= '<div class="block-heading block-heading-small">';
                            $render_modules .= '<h4 class="block-heading__title">'.$smallTile.'</h4>';
                            $render_modules .= '</div><!-- .block-heading-->';   
                        endif;
                        $render_modules .= '<div class="post-sub__inner">';  
                        $render_modules .= '<div class="post-list">'; 
                    endif;
                        $postHorizontalAttr['postID'] = get_the_ID();
                        $render_modules .= '<div class="list-item">';
                        $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                        $render_modules .= '</div><!-- .list-item -->';
                    if($currentPost == ($maxPosts -1)):
                        $render_modules .= '</div><!-- .post-list -->';
                        $render_modules .= '</div><!-- .post-sub__inner -->';
                        $render_modules .= '</div><!-- .post-sub -->';
                    endif;
                    
                endif;
                
            endwhile;
            return $render_modules;
        }
    }
}