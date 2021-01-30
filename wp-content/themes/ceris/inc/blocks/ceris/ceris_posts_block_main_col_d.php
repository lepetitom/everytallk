<?php
if (!class_exists('ceris_posts_block_main_col_d')) {
    class ceris_posts_block_main_col_d {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_posts_block_main_col_d-');
            $moduleConfigs = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit', true );
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
            
            $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-post-latest-block atbs-ceris-main-col-d '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
            $block_str .= ceris_core::bk_render_block_heading_has_sidebar($page_info);
            $block_str .= '<div class="atbs-ceris-block__inner atbs-ceris-post-latest-c">';
            if ( $the_query->have_posts() ) :
                $block_str .= $this->render_modules($the_query, $moduleInfo);            //render modules
            endif;
            
            $block_str .= '</div><!-- .atbs-ceris-block__inner -->';
            $block_str .= '</div><!-- .atbs-ceris-block -->';
                        
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        
        public function render_modules($the_query, $moduleInfo = ''){
            $currentPost = 0;
            $render_modules = '';
            
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
            
            $cat_Overlay_Style = 4;
            $cat_Overlay_Class = ceris_core::bk_get_cat_class($cat_Overlay_Style);
            
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

                $postOverlayHTML = new ceris_update_overlay_3;
                $postOverlayAttr = array (
                    'additionalClass'   => 'post--overlay-height-370 has-score-badge-bottom post--grid-overlay-slide  '.$bypasspostAnimationDetech.' ',
                    'additionalBGClass'   => 'background-img background-img--darkened',
                    'additionalThumbClass'   => 'post__thumb--overlay atbs-thumb-object-fit',
                    'cat'               => $cat_Overlay_Style,
                    'catClass'          => $cat_Overlay_Class,
                    'thumbSize'         => 'ceris-s-4_3',
                    'typescale'         => '',
                    'typescale'         => 'typescale-3 custom-typescale-3',
                    //'except_length'    => 15,
                    'meta'              => array('author'),                    
                    'additionalTextClass'  => 'inverse-text',
                    'postIcon'          => $postIconAttr,  
                );
                $postHorizontalHTML = new ceris_update_horizontal_1;
                $postHorizontalAttr = array (
                    'additionalClass'   => 'posts-has-smaller-post-cat  post--horizontal-not-middle post--horizontal-reverse post__thumb-180 post__thumb-width-220 clearfix',
                    'cat'               => $catStyle,
                    'catClass'          => $cat_Class,
                    'thumbSize'         => 'ceris-xs-4_3',
                    'typescale'         => 'typescale-2 custom-typescale-2--xxs',
                    'additionalThumbClass'   => 'atbs-thumb-object-fit',
                    'postIcon'          => $postIconAttr,  
                    'meta'              => array('date'),
                    
                );
                $postHorizontalHTML_2 = new ceris_update_horizontal_3;
                $postHorizontalAttr_2 = array (
                    'additionalClass'   => 'posts-has-smaller-post-cat  post--horizontal-thumb-margin-top post--horizontal-reverse post__thumb-80 post__thumb-width-80 clearfix',
                    'additionalThumbClass' => 'atbs-thumb-object-fit post__thumb-small hidden-md hidden-sm hidden-xs',
                    'additionalThumb2Class' => 'atbs-thumb-object-fit post__thumb-large hidden-lg',
                    'cat'               => $catStyle,
                    'catClass'          => $cat_Class,
                    'thumbSize'         => 'ceris-xxs-1_1',
                    'thumbSize_mobile'  => 'ceris-xs-1_1',
                    'typescale'         => 'typescale-2 custom-typescale-2--xs',
                    'postIcon'          => $postIconAttr, 
                    'except_length'         => 10, 
                    'meta'              => array('author'),
                    'additionalAuthorClass' => '',
                    
                );
                
                while ( $the_query->have_posts() ): $the_query->the_post();                    
                    $currentPost = $the_query->current_post;
                    $maxPosts = $the_query->post_count;

                    if($currentPost == 0){
                        if(($maxPosts > 0) && ($maxPosts < 4)) :
                            $render_modules .= '<div class="atbs-ceris-post-latest-c--post-grid atbs-ceris-post-latest-c--post-grid-fw">';
                        else: 
                            $render_modules .= '<div class="atbs-ceris-post-latest-c--post-grid">';
                        endif;
                        
                        $render_modules .= '<div class="atbs-ceris-post-latest-c--post-grid-top">';
                        
                        if(($maxPosts == 1) || ($maxPosts == 4)) :
                            $render_modules .= '<div class="atbs-ceris-carousel">';  
                        else:
                            $render_modules .= '<div class="owl-carousel js-atbs-ceris-carousel-only-1i-loopdot atbs-ceris-carousel">';
                        endif;
                    }
                    
                    //begin if >= 4
                    if(($maxPosts >= 4)){    
                        if($currentPost < ($maxPosts - 3)){
                            if($bypassPostIconDetech != 1) {
                                $addClass = '';
                                if($postSource != 'all') {
                                    $postIconAttr['iconType'] = $postSource;
                                }else {
                                    $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                                }
                                $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition, $addClass);
                                $postOverlayAttr['postIcon'] = $postIconAttr;
                            } 
                            $postOverlayAttr['postID'] = get_the_ID();
                            $render_modules .= '<div class="slide-content">';
                            $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                            $render_modules .= '</div><!-- .slide-content -->';
                            if($currentPost == ($maxPosts - 4)){
                                $render_modules .= '</div><!-- .owl-carousel -->';
                                $render_modules .= '</div><!-- .atbs-ceris-post-latest-c--post-grid-top -->';
                            }
                        }else if($currentPost == ($maxPosts - 3)){
                            $render_modules .= '<div class="atbs-ceris-post-latest-c--post-grid-body">';
                            $render_modules .= '<div class="post-item">';
                            $postHorizontalAttr['postID'] = get_the_ID();
                            $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                            $render_modules .= '</div><!-- .post-item -->';
                            $render_modules .= '</div><!-- .atbs-ceris-post-latest-c--post-grid-body -->';
                            $render_modules .= '</div><!-- .atbs-ceris-post-latest-c--post-grid -->';
                        }else {
                            if($currentPost == ($maxPosts - 2)){
                                $render_modules .= '<div class="atbs-ceris-post-latest-c--post-list">';
                                $render_modules .= '<div class="post-list">';
                            }
                            $render_modules .= '<div class="list-item">';
                            $postHorizontalAttr_2['postID'] = get_the_ID();
                            $render_modules .= $postHorizontalHTML_2->render($postHorizontalAttr_2);
                            $render_modules .= '</div><!-- .list-item -->';
                            if($currentPost == ($maxPosts - 1) ){
                                $render_modules .= '</div><!-- .post-list -->';
                                $render_modules .= '</div><!-- .atbs-ceris-post-latest-c--post-list -->';
                            }  
                        }
                    }else {
                        $postOverlayAttr['postID'] = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            $addClass = '';
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                            }
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition, $addClass);
                            $postOverlayAttr['postIcon'] = $postIconAttr;
                        }
                        $render_modules .= '<div class="slide-content">';
                        $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                        $render_modules .= '</div><!-- .slide-content -->';
                        if($currentPost == ($maxPosts -1)){
                            $render_modules .= '</div><!-- .owl-carousel -->';
                            $render_modules .= '</div><!-- .atbs-ceris-post-latest-c--post-grid-top -->';
                            $render_modules .= '</div><!-- .atbs-ceris-post-latest-c--post-grid -->';
                        }
                    }
                    
                endwhile;
  
            endif;
            
            return $render_modules;
        }
    }
}