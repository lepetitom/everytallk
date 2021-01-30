<?php
if (!class_exists('ceris_featured_module_e')) {
    class ceris_featured_module_e {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_featured_module_e-');
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
                if($moduleConfigs['module_margin_top'] < 0) :
                    $blockMarginTopClass = 'atbs-custom-margin-top-minus-'.abs($moduleConfigs['module_margin_top']);
                elseif(($moduleConfigs['module_margin_top'] > 0)) :
                    $blockMarginTopClass = 'atbs-custom-margin-top-'.abs($moduleConfigs['module_margin_top']);
                else:
                    $blockMarginTopClass = '';
                endif;
            }
            if ( $the_query->have_posts() ) :
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin feature-module-e atbs-ceris-posts-feature-a-update '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
                $block_str .= ceris_core::bk_render_block_heading($page_info);
                $block_str .= '<div class="atbs-ceris-block__inner">';
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
                'cat'                 => $catStyle,
                'catClass'            => $cat_Class,
                'additionalClass'     => 'post-meta--large post--horizontal-fullwidth-thumb-large post__thumb-800 remove-margin-bottom-lastchild '.$bypasspostAnimationDetech.'',
                'additionalTextClass' => 'remove-margin-bottom-lastchild',
                'typescale'           => 'typescale-2',
                'thumbSize'           => 'ceris-l-16_9',
                'meta'                 => array('author', 'date'),
                'postIcon'            => $postIconAttr,
            );
            
            $catStyle = 3;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            $postNothumbHTML = new ceris_post_nothumb_2;         
            $postNothumbAttr = array (
                'cat'                    => $catStyle,
                'catClass'               => $cat_Class.' post__cat-has-line',
                'additionalClass'        => 'post--no-thumb-text-white remove-margin-bottom-lastchild',
                'readmore'               => 1,
                'additionalTextReadMore' => 'readmore-normal',
                'additionalThumbClass'   => 'atbs-thumb-object-fit',
                'typescale'              => 'typescale-2 custom-typescale-2',
                'postIcon'               => $postIconAttr,
            );
            $render_modules = '';
            $currentPost = '';
            $carouselID = uniqid('carousel-');
            
            while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                $maxPosts = $the_query->post_count;
                if($currentPost == 0):
                    $render_modules .= '<div class="post-main">';
                    $render_modules .= '<div class="owl-carousel js-carousel-1i30m-effect atbs-ceris-carousel nav-circle dots-circle">';
                endif;
                
                if($maxPosts < 4):
                    if($bypassPostIconDetech != 1) {
                        $addClass = '';
                        if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                            }
                            $iconSize = '';
                            if($postIconAttr['iconType'] == 'review'):
                                $iconSize = 'large';
                            else:
                                $iconSize = '';                                                                
                            endif;                                                            
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], $iconSize, $iconPosition, $addClass);
                            $postHorizontalAttr['postIcon'] = $postIconAttr;
                        }
                    $render_modules .= '<div class="slide-content">';
                    $postHorizontalAttr['postID'] = get_the_ID();
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</div><!-- .slide-content -->';
                    if(($currentPost == ($maxPosts - 1 ))):
                        $render_modules .= '</div><!-- .atbs-ceris-carousel -->';
                        $render_modules .= '</div><!-- .post-main -->';
                    endif;
                elseif($maxPosts >= 4):
                    if(($currentPost >= 0) && ($currentPost <= ($maxPosts - 4 ))):
                        
                    if($bypassPostIconDetech != 1) {
                        $addClass = '';
                        if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                            }
                            $iconSize = '';
                            if($postIconAttr['iconType'] == 'review'):
                                $iconSize = 'large';
                            else:
                                $iconSize = '';                                                                
                            endif;                                                            
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], $iconSize, $iconPosition, $addClass);
                            $postHorizontalAttr['postIcon'] = $postIconAttr;
                        }
                        $render_modules .= '<div class="slide-content">';
                        $postHorizontalAttr['postID'] = get_the_ID();
                        $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                        $render_modules .= '</div><!-- .slide-content -->';
                        if(($currentPost == ($maxPosts - 4 ))):
                            $render_modules .= '</div><!-- .atbs-ceris-carousel -->';
                            $render_modules .= '</div><!-- .post-main -->';
                        endif;
                    elseif(($currentPost >= ($maxPosts - 3)) && ($currentPost <= ($maxPosts - 1))):
                        if($currentPost == ($maxPosts - 3)):
                            $render_modules .= '<div class="post-sub">';
                            $render_modules .= '<div class="post-list">';
                        endif;                 
                        $render_modules .= '<div class="list-item">';
                        $postNothumbAttr['postID'] = get_the_ID();
                        $render_modules .= $postNothumbHTML->render($postNothumbAttr);
                        $render_modules .= '</div><!-- .list-item -->';
                        if($currentPost == ($maxPosts - 1)):
                            $render_modules .= '</div><!-- .post-list -->';
                            $render_modules .= '</div><!-- .post-sub -->';
                        endif;    
                    endif;
                endif; 
            endwhile;
            return $render_modules;
        }
    }
}