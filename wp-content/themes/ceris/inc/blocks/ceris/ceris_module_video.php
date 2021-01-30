<?php
if (!class_exists('ceris_module_video')) {
    class ceris_module_video {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_module_video-');
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
            $moduleConfigs['post_source'] = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_source', true );
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
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-module-video atbs-ceris-video-has-post-list '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
                $block_str .= ceris_core::bk_render_block_heading($page_info, 'container-768');
                $block_str .= '<div class="container container-768">';
                $block_str .= '<div class="atbs-ceris-block__inner atbs-ceris-video-has-post-list__inner clearfix">';
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
            $iconPosition_L = 'center';
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
            if($bypassPostIconDetech == 1):
                $classNoIcon = ' post-not-exist-icon-video';
            else:
                $classNoIcon = ' post-exist-icon-video';
            endif;
            $catStyle = 4;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            
            $postVerticalHTML = new ceris_post_vertical_2;         
            $postVerticalAttr = array (
                'cat'                 => $catStyle,
                'catClass'            => $cat_Class,
                'additionalClass'     => ' main-post posts-has-smaller-post-cat'.$bypasspostAnimationDetech.$classNoIcon,
                'additionalTextClass' => 'inverse-text',
                'additionalThumbClass'=> 'background-img',
                'thumbSize'           => 'ceris-l-2_1',
                'typescale'           => '',
                'meta'                 => array('author_has_wrap', 'date_without_icon'),
//                'except_length'       => '7',
                'postIcon'            => $postIconAttr,
            );
            
            $catStyle = 3;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            $postNothumbHTML = new  ceris_post_nothumb_1; 
            $postNothumbAttr = array (
                'cat'                 => $catStyle,
                'catClass'            => $cat_Class.' post__cat-has-line',
                'additionalTextClass' => '',
                'typescale'           => 'typescale-2 custom-typescale-2--xxs',
                'additionalClass'     => ''.$bypasspostAnimationDetech.$classNoIcon,
                'meta'                 => array('date_without_icon'),
                'postIcon'            => $postIconAttr,
            );
            $render_modules = '';
            $currentPost = '';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                
                if($currentPost == 0):
                    if($bypassPostIconDetech != 1) {
                        $addClass = '';
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                        }
                        $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $iconPosition_L, $addClass);
                        if(($postIconAttr['iconType'] == 'gallery') || ($postIconAttr['iconType'] == 'review')):
                            $postIconAttr['iconType'] = '';
                        endif;
                        $postVerticalAttr['postIcon'] = $postIconAttr;
                    } 
                    $postVerticalAttr['postID'] = get_the_ID();
                    $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                elseif($currentPost > 0):
                    if($bypassPostIconDetech != 1) {
                        $addClass = '';
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                        }
                        $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'small', $iconPosition, $addClass);
                        if(($postIconAttr['iconType'] == 'gallery') || ($postIconAttr['iconType'] == 'review')):
                            $postIconAttr['iconType'] = '';
                        endif;
                        $postNothumbAttr['postIcon'] = $postIconAttr;
                    } 
                    $postNothumbAttr['postID'] = get_the_ID(); 
                    if($currentPost == 1):
                        $render_modules .= '<div class="sub-posts post-list-no-thumb-3i">';
                        $render_modules .= '<ul class="post-list">';
                        
                    endif;     
                    $render_modules .= '<li class="list-item">';
                    $render_modules .= $postNothumbHTML->render($postNothumbAttr);
                    $render_modules .= '</li><!-- .list-item -->';
                endif;
            endwhile;
                if($currentPost > 0){
                    $render_modules .= '</ul><!-- .post-list -->';
                    $render_modules .= '</div><!-- .sub-posts -->';
                }
            return $render_modules;              
        }
    }
}