<?php
if (!class_exists('ceris_grid_j')) {
    class ceris_grid_j {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_grid_j-');
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
            $moduleConfigs['top_block'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_top_block', true );
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = $moduleConfigs['custom_class'].' ';
            }else {
                $moduleCustomClass = '';
            }
            $moduleConfigs['top_block'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_top_block', true );
            $bypassTopPost = 4;
            $marginPostHorizontal = '';
            if($moduleConfigs['top_block'] == 'no'):
                $bypassTopPost = 1;
                $marginPostHorizontal = 'delete-margin';
            else:
                $bypassTopPost = 4;
                $marginPostHorizontal = '';
            endif;
            
            $moduleConfigs['limit'] = $bypassTopPost;
            //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
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
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-grid-j atbs-ceris-post--grid-e-update clearfix '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
                $block_str .= ceris_core::bk_render_block_heading($page_info);
                $block_str .= '<div class="atbs-ceris-block__inner flex-column-reverse '.$marginPostHorizontal.'">';
                $block_str .= $this->render_modules($the_query);              //render modules
                $block_str .= '</div><!-- .atbs-ceris-block__inner -->';
                
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

            $postHorizontalHTML = new ceris_post_horizontal_1;         
            $postHorizontalAttr = array (
                'cat'                  => $catStyle,
                'catClass'             => $cat_Class,
                'additionalClass'      => 'post--horizontal-middle post--horizontal-reverse remove-margin-bottom-lastchild post__thumb-560  post--horizontal-video-thumb_fullwidth '.$bypasspostAnimationDetech.'',
                'additionalTextClass'  => '',
                'additionalThumbClass' => 'atbs-thumb-object-fit',
                'typescale'            => 'typescale-3',
                'except_length'        => 15,
                'iconPosition'         => 'right-center',
                'thumbSize'            => 'ceris-xl-2_1',
                'postIcon'             => $postIconAttr,
                'meta'            => array('author_name', 'date'),
            );  
            $catStyle = 3;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            $postHorizontalAttr_2 = array (
                'additionalClass'      => 'post--horizontal-middle post--horizontal-xs post--horizontal-90 remove-margin-bottom-lastchild post--horizontal-cat-no-line',
                'additionalTextClass'  => 'remove-margin-bottom-lastchild',
                'additionalThumbClass' => 'atbs-thumb-object-fit',
                'typescale'            => 'typescale-2 custom-typescale-2--xxs',
                'thumbSize'            => 'ceris-xxs-1_1',
                'postIcon'             => $postIconAttr,
                'meta'                 => array('date'),
            );
            $render_modules = '';
            $currentPost = '';
             while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                $maxPosts = $the_query->post_count;
                    if($currentPost == 0):
                        $render_modules .= '<div class="post--horizontal-video-fullwidth">';
                        $postHorizontalAttr['postID'] = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                                
                                                                                    
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                            }
                            $addClass = 'btn-play-left-not-center'; 
                            $iconSize = '';
                            if($postIconAttr['iconType'] == 'review'):
                                $iconSize = 'large';
                            else:
                                $iconSize = 'medium';                                                                
                            endif;                                                            
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], $iconSize, $iconPosition, $addClass);
                            
                            if($postIconAttr['iconType'] == 'gallery'):
                                $postIconAttr['iconType'] = '';                              
                            endif;           
                            $postHorizontalAttr['postIcon'] = $postIconAttr;
                        }
                        
                                                                        
                        $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);     
                        $render_modules .= '</div><!-- .post--horizontal-video-fullwidth  -->';
                    else:
                        if($currentPost == 1):
                            $render_modules .= '<div class="container">';
                            $render_modules .= '<div class="post--horizontal-3i_row has-border-line-padding-30">';
                            $render_modules .= '<div class="post-list ">';
                        endif;
                        $postHorizontalAttr_2['postID'] = get_the_ID();
                        $render_modules .= '<div class="list-item ">';
                        $render_modules .= $postHorizontalHTML->render($postHorizontalAttr_2); 
                        $render_modules .= '</div><!-- .list-item  -->';
                    endif;
            endwhile;
            if($currentPost != 0):
                $render_modules .= '</div><!-- .post-list  -->';
                $render_modules .= '</div><!-- .post--horizontal-3i_row -->';
                $render_modules .= '</div><!-- .container -->';
            endif;
            return $render_modules;    
        }
    }
}