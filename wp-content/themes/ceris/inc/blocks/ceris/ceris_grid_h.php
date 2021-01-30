<?php
if (!class_exists('ceris_grid_h')) {
    class ceris_grid_h {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_grid_h-');
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
            
            $moduleConfigs['top_block'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_top_block', true );
            
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
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-grid-h atbs-ceris-post--grid-g-update clearfix '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
                $block_str .= ceris_core::bk_render_block_heading($page_info);
                $block_str .= '<div class="container">';
                $block_str .= '<div class="atbs-ceris-block__inner">';
                if ( $the_query->have_posts() ) :
                    if($moduleConfigs['top_block'] == 'no') :
                        $block_str .= $this->render_bottom_block($the_query);            //render bottom block
                    else :
                        $block_str .= $this->render_top_block($the_query);              //render top block
                        if ( $the_query->have_posts() ) :
                            $block_str .= $this->render_bottom_block($the_query);            //render bottom block
                        endif;
                    endif;
                endif;
                $block_str .= '</div><!-- .atbs-ceris-block__inner -->';
                $block_str .= '</div><!-- .container -->';
                $block_str .= '</div><!-- .atbs-ceris-block -->';
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_top_block($the_query){
            $iconPosition = 'top-right';
            $currentPost = 0;
            $postSource = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_source', true );
            $postIcon = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon', true );
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
            $postHorizontalHTML = new ceris_post_horizontal_1;         
            $postHorizontalAttr = array (
                'additionalClass'        => 'post--horizontal-thumb-radius post--horizontal-middle remove-margin-bottom-lastchild',
                'additionalTextClass'    => '',
                'additionalThumbClass'   => 'atbs-thumb-object-fit',
                'typescale'              => 'typescale-2 custom-typescale-2--xxs',
                'thumbSize'              => 'ceris-xxs-1_1',
                'postIcon'               => $postIconAttr,
                'readmore'               => 1,
                'additionalTextReadMore' => 'readmore-normal',
                'meta'                   => array('date'),
            );
            $render_modules = '';
            $currentPost = '';
             while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                $maxPosts = $the_query->post_count;
                if(($currentPost >= 0) && ($currentPost < 3)):
                    if($currentPost == 0):
                        
                        if($maxPosts >= 3){
                            $render_modules .= '<div class="post-list three-item">';
                        }else{
                            $render_modules .= '<div class="post-list">';
                        }
                    endif;
                    $postHorizontalAttr['postID'] = get_the_ID();
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</div><!-- .list-item -->';
                    if($currentPost == 2):
                        $render_modules .= '</div><!-- .post-list -->';
                        break;
                    endif;
                endif;
            endwhile;
            if(($maxPosts > 0) && ($maxPosts < 3)):
                $render_modules .= '</div><!-- .post-list -->';
            endif;
            return $render_modules;
        }
        public function render_bottom_block($the_query){
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
            $postVerticalHTML = new ceris_post_vertical_1;         
            $postVerticalAttr = array (
                'cat'           => $catStyle,
                'catClass'      => $cat_Class,
                'additionalClass' => 'post--vertical-reverse-text-wrap post-background-white '.$bypasspostAnimationDetech.'',
                'additionalTextWrapClass' => 'clearfix',
                'additionalTextClass' => '',
                'additionalThumbClass' => 'atbs-thumb-object-fit',
                'typescale'     => 'typescale-3',
                'thumbSize'     => 'ceris-m-2_1',
                'postIcon'      => $postIconAttr,
                'meta'          => array('author', 'date'),
            );
            $postVerticalHTML_2 = new ceris_post_vertical_2;   
            $postVerticalAttr_2 = array (
                'cat'           => $catStyle,
                'catClass'      => $cat_Class,
                'additionalClass' => 'post-meta--large post--vertical-thumb-default post-background-white '.$bypasspostAnimationDetech.'',
                'additionalTextClass' => '',
                'typescale'     => 'typescale-2 custom-typescale-2',
                'thumbSize'     => 'ceris-xs-1_1',
                'postIcon'      => $postIconAttr,
                'meta'            => array('author', 'date'),
            );
            $postVerticalAttr_3 = array (
                'cat'           => $catStyle,
                'catClass'      => $cat_Class,
                'additionalClass' => 'posts-has-smaller-post-cat post--vertical-reverse-thumb-not-full post-background-white',
                'additionalTextClass' => '',
                'typescale'     => 'typescale-2 custom-typescale-2--xxs',
                'thumbSize'     => 'ceris-xs-4_3',
                'postIcon'      => $postIconAttr,
            );
            $render_modules = '';
            $currentPostIndex = '';
            
            $topBlock = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_top_block', true );
            
            if($topBlock == 'no') :
                $postMinus = 0;
            else :
                $postMinus = 3;
            endif;
            
            $maxPosts = $the_query->post_count - $postMinus;
            
             while ( $the_query->have_posts() ): $the_query->the_post();
                
                $currentPostIndex = $the_query->current_post - $postMinus;
                
                if($currentPostIndex < 0): return ''; endif;
                
                if($maxPosts > 2):
                    if(($maxPosts > 2) && ($maxPosts < 6)): 
                        if(($currentPostIndex >= 0) && ($currentPostIndex <= ($maxPosts - 2))):
                            if($currentPostIndex == 0):
                                $render_modules .= '<div class="post-grid">';
                                $render_modules .= '<div class="post-grid-carousel">';
                                $render_modules .= '<div class="owl-carousel js-atbs-ceris-carousel-1i_not_nav_2  atbs-ceris-carousel dots-circle">';
                            endif;
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
                            
                            $render_modules .= '<div class="slide-content">';
                            $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                            $render_modules .= '</div><!-- .slide-content -->';
                            if($currentPostIndex == ($maxPosts - 2)):
                                $render_modules .= '</div><!-- .owl-carousel-->';
                                $render_modules .= '</div><!-- .post-grid-carousel -->';
                            endif;
                        elseif($currentPostIndex == ($maxPosts - 1)):
                            $postVerticalAttr_2['postID'] = get_the_ID();
                            if($bypassPostIconDetech != 1) {
                                $addClass = '';
                                if($postSource != 'all') {
                                    $postIconAttr['iconType'] = $postSource;
                                }else {
                                    $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                                }
                                $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition, $addClass);
                                $postVerticalAttr_2['postIcon'] = $postIconAttr;
                            }
                            
                            $render_modules .= '<div class="grid-item">';
                            $render_modules .= $postVerticalHTML_2->render($postVerticalAttr_2);
                            $render_modules .= '</div><!-- .grid-item -->';
                            $render_modules .= '</div><!-- .post-grid -->';
                        endif; 
                    elseif ($maxPosts >= 6):  
                        if(($currentPostIndex >= 0) && ($currentPostIndex <= ($maxPosts - 6))):
                            if($currentPostIndex == 0):
                                $render_modules .= '<div class="post-grid">';
                                $render_modules .= '<div class="post-grid-carousel">';
                                
                                if($maxPosts == 6):
                                    $render_modules .= '<div class="atbs-ceris-carousel">';
                                else:
                                    $render_modules .= '<div class="owl-carousel js-atbs-ceris-carousel-1i_not_nav_2  atbs-ceris-carousel dots-circle">';
                                endif;

                            endif;
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
                            $render_modules .= '<div class="slide-content">';
                            $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                            $render_modules .= '</div><!-- .slide-content -->';
                            
                            if($currentPostIndex == ($maxPosts - 6)):
                                $render_modules .= '</div><!-- .owl-carousel-->';
                                $render_modules .= '</div><!-- .post-grid-carousel -->';
                            endif;
                        else:
                            $postVerticalAttr_2['postID'] = get_the_ID();
                            $postVerticalAttr_3['postID'] = get_the_ID();
                            
                            if($currentPostIndex == ($maxPosts - 5)):
                                if($bypassPostIconDetech != 1) {
                                    $addClass = '';
                                    if($postSource != 'all') {
                                        $postIconAttr['iconType'] = $postSource;
                                    }else {
                                        $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                                    }
                                    $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition, $addClass);
                                    $postVerticalAttr_2['postIcon'] = $postIconAttr;
                                }
                                $render_modules .= '<div class="grid-item">';
                                $render_modules .= $postVerticalHTML_2->render($postVerticalAttr_2);
                                $render_modules .= '</div><!-- .grid-item -->';
                            else:
                                $render_modules .= '<div class="grid-item">';
                                $render_modules .= $postVerticalHTML_2->render($postVerticalAttr_3);
                                $render_modules .= '</div><!-- .grid-item -->';
                            endif;
                            if($currentPostIndex == ($maxPosts - 1)):
                                $render_modules .= '</div><!-- .post-grid -->';
                            endif;
                        endif; 
                    endif;
                else:
                    if($currentPostIndex == 0):
                        $render_modules .= '<div class="post-grid">';
                        if($maxPosts == 1):
                            $render_modules .= '<div class="post-grid-carousel carousel-item-fullwidth">';
                        else:
                            $render_modules .= '<div class="post-grid-carousel">';
                        endif;
                        $render_modules .= '<div class="atbs-ceris-carousel">';
                        $postVerticalAttr['postID'] = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            $addClass = '';
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                            }
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $iconPosition, $addClass);
                            $postVerticalAttr['postIcon'] = $postIconAttr;
                        }
                        $render_modules .= '<div class="slide-content">';
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                        $render_modules .= '</div><!-- .slide-content -->';
                        $render_modules .= '</div><!-- .owl-carousel-->';
                        $render_modules .= '</div><!-- .post-grid-carousel -->';
                    else:
                        $postVerticalAttr_2['postID'] = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            $addClass = '';
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                            }
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'small', $iconPosition, $addClass);
                            $postVerticalAttr_2['postIcon'] = $postIconAttr;
                        }
                        $render_modules .= '<div class="grid-item">';
                        $render_modules .= $postVerticalHTML_2->render($postVerticalAttr_2);
                        $render_modules .= '</div><!-- .grid-item -->'; 
                    endif;
                endif;
            endwhile;
            if(($maxPosts == 1) || ($maxPosts == 2)):
                $render_modules .= '</div><!-- .post-grid -->';
            endif;
            return $render_modules;
        }
    }
}