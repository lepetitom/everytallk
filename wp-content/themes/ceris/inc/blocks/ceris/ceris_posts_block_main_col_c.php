<?php
if (!class_exists('ceris_posts_block_main_col_c')) {
    class ceris_posts_block_main_col_c {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_posts_block_main_col_c-');
            $moduleConfigs = array();
            
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
            $moduleConfigs['ajax_load_more'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_ajax_load_more', true );
     
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = ' '.$moduleConfigs['custom_class'];
            }else {
                $moduleCustomClass = '';
            }
            
           //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            $moduleInfo = array(
                'post_source'   => $moduleConfigs['post_source'],
                'post_icon'     => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true ),
                'iconPosition'  => 'top-right',
                'post_icon_animation' => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon_animation', true ),
                'reverse_column' => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_reverse_column', true ),
                
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
            
            $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-main-col-c atbs-ceris-post-latest-block atbs-ceris-post-latest-a '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
            $block_str .= ceris_core::bk_render_block_heading_has_sidebar($page_info);
            $block_str .= '<div class="atbs-ceris-block__inner">';
            if ( $the_query->have_posts() ) :
                $block_str .= $this->render_modules($the_query, $moduleInfo);            //render modules
            endif;
            
            $block_str .= '</div>';
            $block_str .= '</div><!-- .atbs-ceris-block -->';
                        
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        
        public function render_modules($the_query, $moduleInfo = ''){
            $currentPost = 0;
            $render_modules = '';
            
            $reverse_column = $moduleInfo['reverse_column'];
            if($reverse_column == 'enable'){
                $reverseClass = ' row-reverse';
            }else{
                $reverseClass = '';
            }
            $postSource = $moduleInfo['post_source'];
            $postIcon = $moduleInfo['post_icon'];
            $iconPosition = 'top-right';
            $postAnimation = $moduleInfo['post_icon_animation'];
            $bypasspostAnimationDetech = '';
            if($postAnimation == 'disable') {
                $bypasspostAnimationDetech = '';
            }else {
                $bypasspostAnimationDetech = 'icon-has-animation';
            }
            $catStyle = 4;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            
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
                $postVerticalHTML = new ceris_update_vertical_1;
                $postVerticalAttr = array (
                    'additionalClass'   => 'post--vertical-thumb-reverse post__thumb-180 '.$bypasspostAnimationDetech.' ',
                    'cat'               => $catStyle,
                    'catClass'          => $cat_Class,
                    'thumbSize'         => 'ceris-xs-2_1',
                    'typescale'         => 'typescale-2',
                    'additionalThumbClass'   => 'atbs-thumb-object-fit',
                    'postIcon'          => $postIconAttr,  
                    'meta'                => array('author_name', 'date'),
                    'except_length'     => 12,
                );
                $postOverlayHTML = new ceris_post_overlay_2;
                $postOverlayAttr = array (
                    'cat'                 => $catStyle,
                    'catClass'            => $cat_Class.' overlay-item--top-left',
                    'additionalClass'     => 'post--overlay-bottom post--overlay-sm post--overlay-padding-lg '.$bypasspostAnimationDetech.' ',
                    'additionalTextClass' => 'inverse-text',
                    'thumbSize'           => 'ceris-xs-1_1',
                    'additionalThumbClass'=> 'post__thumb--overlay background-img atbs-thumb-object-fit',
                    'typescale'           => 'typescale-3 custom-typescale-3',
                    'meta'                => array('author', 'date'),
                    'postIcon'            => $postIconAttr,
                );
                
                $catStyle = 3;
                $cat_Class = ceris_core::bk_get_cat_class($catStyle);
                
                $postHorizontalHTML = new ceris_update_horizontal_2;
                $postHorizontalAttr = array (
                    'additionalClass'   => 'post--horizontal-xs post__thumb-70',
                    'thumbSize'         => 'ceris-xxs-1_1',
                    'additionalThumbClass' => 'margin-right-30',
                    'additionalThumbClass'   => 'atbs-thumb-object-fit',
                    'typescale'         => 'typescale-2 custom-typescale-2--xxs',
                    'meta'                 => array('date')
                );
                        
                while ( $the_query->have_posts() ): $the_query->the_post();                    
                    $currentPost = $the_query->current_post;
                    if($currentPost == 0):
                        if($bypassPostIconDetech != 1) {
                            $addClass = 'overlay-item--sm-p';
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                            }
    
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'small', $iconPosition, $addClass);
                            
                            $postVerticalAttr['postIcon'] = $postIconAttr;
                        }
                        $render_modules .= '<div class="atbs-ceris-post-latest-a--top">';
                        $render_modules .= '<div class="post-list'.$reverseClass.'">';
                        
                        
                        $postVerticalAttr['postID'] = get_the_ID();
                        $postVerticalAttr['catClass'] .= ' cat-color-logo';
                        
                        $render_modules .= '<div class="list-item">';
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                        $render_modules .= '</div><!-- .list-item -->';
                        
                    elseif($currentPost == 1):
                        $render_modules .= '<div class="list-item">';
                        $postOverlayAttr['postID']          = get_the_ID();
                        
                        if($bypassPostIconDetech != 1) :
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = ceris_core::bk_post_format_detect(get_the_ID());
                            }
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition);
                            $postOverlayAttr['postIcon'] = $postIconAttr;
                            
                        endif;
                        $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                        $render_modules .= '</div><!-- .list-item -->';
                        
                        $render_modules .= '</div><!-- .post-list -->';
                        $render_modules .= '</div><!-- .atbs-ceris-post-latest-a--top -->';
                        
                    elseif($currentPost > 1):
                        if($currentPost == 2):
                            $render_modules .= '<div class="atbs-ceris-post-latest-a--body">';
                            $render_modules .= '<div class="post-list">';
                        endif;
                        
                        $render_modules .= '<div class="list-item">';
                        $postHorizontalAttr['postID'] = get_the_ID();
                        $render_modules .= $postHorizontalHTML -> render($postHorizontalAttr);
                        $render_modules .= '</div><!-- .list-item -->'; 
                        
                        if($currentPost == 3):
                            $render_modules .= '</div><!-- .post-list -->';
                            $render_modules .= '</div><!-- .atbs-ceris-post-latest-a--body -->';
                        endif;
                        
                    endif;

                endwhile;
                
                if($currentPost == 0):
                    $render_modules .= '</div><!-- .post-list -->';
                    $render_modules .= '</div><!-- .atbs-ceris-post-latest-a--top -->';
                elseif($currentPost == 2):
                    $render_modules .= '</div><!-- .post-list -->';
                    $render_modules .= '</div><!-- .atbs-ceris-post-latest-a--body -->';
                endif;
                
            endif;
            
            return $render_modules;
        }
    }
}