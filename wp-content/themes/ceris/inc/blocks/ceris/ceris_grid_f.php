<?php
if (!class_exists('ceris_grid_f')) {
    class ceris_grid_f {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_grid_f-');
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
            $moduleConfigs['limit'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit', true );
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = $moduleConfigs['custom_class'].' ';
            }else {
                $moduleCustomClass = '';
            }
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
                $moduleConfigs['heading_margin_bottom'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_margin_bottom', true );
                
                if($moduleConfigs['module_margin_top'] < 0) :
                    $blockMarginTopClass = 'atbs-custom-margin-top-minus-'.abs($moduleConfigs['module_margin_top']);
                elseif(($moduleConfigs['module_margin_top'] > 0)) :
                    $blockMarginTopClass = 'atbs-custom-margin-top-'.abs($moduleConfigs['module_margin_top']);
                else:
                    $blockMarginTopClass = '';
                endif;
                
                if($moduleConfigs['heading_margin_bottom'] != '') {
                    $headingClass .= ' atbs-custom-margin-bottom-'.abs($moduleConfigs['heading_margin_bottom']);
                }
            }
            if ( $the_query->have_posts() ) :
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-grid-f atbs-ceris-post--grid-d-update clearfix '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
                $block_str .= ceris_core::bk_render_block_heading($page_info);
                $block_str .= '<div class="container">';
                $block_str .= '<div class="atbs-ceris-block__inner">';
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
            $catStyle = 3;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            $postMainHTML = new ceris_post_main_2;         
            $postMainAttr = array (
                'cat'                    => $catStyle,
                'catClass'               => $cat_Class.' post__cat-has-line',
                'additionalClass'        => 'post-no-thumb-title-line remove-margin-bottom-lastchild',
                'additionalTextClass'    => '',
                'typescale'              => 'typescale-2 custom-typescale-2',
                'except_length'          => 23,
                'postIcon'               => $postIconAttr,
                'readmore'               => 1,
                'additionalTextReadMore' => 'readmore-normal',
                'thumbSize'              => '',
            );
            $catStyle = 4;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            $postVerticalHTML = new ceris_post_vertical_3;         
            $postVerticalAttr = array (
                'cat'             => $catStyle,
                'additionalClass' => ' '.$bypasspostAnimationDetech.'',
                'catClass'        => $cat_Class,
                'typescale'       => 'typescale-3 custom-typescale-3',
                'thumbSize'       => 'ceris-s-2_1',
                'additionalThumbClass' => 'atbs-thumb-object-fit',
                'postIcon'        => $postIconAttr,
                'meta'            => array('author_name', 'date'),

            );
            $postHorizontalHTML = new ceris_post_horizontal_1;         
            $postHorizontalAttr = array (
                'additionalClass'     => 'post--horizontal-middle post--horizontal-xs post--horizontal-90 remove-margin-bottom-lastchild post--horizontal-cat-no-line',
                'additionalTextClass' => 'remove-margin-bottom-lastchild',
                'typescale'           => 'typescale-1',
                'thumbSize'           => 'ceris-xxs-1_1',
                'postIcon'            => $postIconAttr,
                'meta'                => array('date'),
            );
            $render_modules = '';
            $currentPost = '';
            $render_modules .= '<div class="post-list">';
             while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                $maxPosts = $the_query->post_count;
                if($maxPosts > 5 ):
                    if(($currentPost >= 0) && ($currentPost < ($maxPosts - 4))):
                        if($currentPost == 0):
                            $render_modules .= '<div class="list-col">';
                            $render_modules .= '<div class="owl-carousel js-atbs-ceris-carousel-1i_not_nav  atbs-ceris-carousel dots-circle">';
                        endif;
                            $postMainAttr['postID'] = get_the_ID();
                            $render_modules .= '<div class="slide-content">';
                            $render_modules .= $postMainHTML->render($postMainAttr);
                            $render_modules .= '</div><!-- .slide-content -->';     
                        if($currentPost == ($maxPosts - 5)):
                            $render_modules .= '</div><!-- .owl-carousel -->';
                        endif;
                    elseif($currentPost >= ($maxPosts - 4)):
                        if($currentPost == ($maxPosts - 4)):
                            $render_modules .= '<div class="list-col">';
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
                        elseif(($currentPost > ($maxPosts - 4)) && ($currentPost <= ($maxPosts - 1))):
                            if($currentPost == ($maxPosts - 3)):
                                $render_modules .= '<div class="list-col posts-list-horizontal-90">';
                            endif;
                                $postHorizontalAttr['postID'] = get_the_ID();
                                $render_modules .= '<div class="list-item">';
                                $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                                $render_modules .= '</div><!-- .list-item -->';
                        endif;
                    endif;
                     if(($currentPost == ($maxPosts - 4)) || ($currentPost == ($maxPosts - 1)) || ($currentPost == ($maxPosts - 5))):
                         $render_modules .= '</div><!-- .list-col -->';
                    endif;
                else:
                    if($currentPost == 0):
                        $render_modules .= '<div class="list-col">';
                        $render_modules .= '<div class="owl-carousel js-atbs-ceris-carousel-1i_not_nav  atbs-ceris-carousel dots-circle">';
                        $postMainAttr['postID'] = get_the_ID();
                        $render_modules .= '<div class="slide-content">';
                        $render_modules .= $postMainHTML->render($postMainAttr);
                        $render_modules .= '</div><!-- .slide-content -->';     
                        $render_modules .= '</div><!-- .owl-carousel -->';
                    elseif($currentPost >= 1):
                        if($currentPost == 1):
                            $render_modules .= '<div class="list-col">';
                            $postVerticalAttr['postID'] = get_the_ID();
                            if($bypassPostIconDetech != 1) {
                                $addClass = '';
                                if($postSource != 'all') {
                                    $postIconAttr['iconType'] = $postSource;
                                }else {
                                    $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                                }
                                if($postIconAttr['iconType'] == 'review'):
                                    $iconSize = '';
                                else:
                                    $iconSize = 'medium';                                                                
                                endif;  
                                $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], $iconSize, $iconPosition, $addClass);
                                $postVerticalAttr['postIcon'] = $postIconAttr;
                            }
                            $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                        elseif(($currentPost > 1) && ($currentPost <= 4)):
                            if($currentPost == 2):
                                $render_modules .= '<div class="list-col posts-list-horizontal-90">';
                            endif;
                                $postHorizontalAttr['postID'] = get_the_ID();
                                $render_modules .= '<div class="list-item">';
                                $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                                $render_modules .= '</div><!-- .list-item -->';
                        endif;
                    endif;
                     if(($currentPost == 0) || ($currentPost == 1) || ($currentPost == 4)):
                        $render_modules .= '</div><!-- .list-col -->';
                     endif;
                endif;
            endwhile;
             if($maxPosts < 6 ) :
                if(($currentPost != 0) && ($currentPost != 1) && ($currentPost != 4)):
                    $render_modules .= '</div><!-- .list-col -->';
                endif;
             endif;
            $render_modules .= '</div><!-- .post-list -->';
            return $render_modules;    
        }
    }
}