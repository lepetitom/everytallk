<?php
if (!class_exists('ceris_featured_module_k')) {
    class ceris_featured_module_k {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_featured_module_k-');
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            
            $moduleConfigs['title'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );
            $moduleConfigs['heading_color'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_color', true );
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
            $moduleConfigs['heading_style'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_style', true );
            $moduleConfigs['heading_inverse'] = 'no';
            if(isset($moduleConfigs['heading_style'])) {
                $headingClass = ceris_core::bk_get_block_heading_class($moduleConfigs['heading_style'], $moduleConfigs['heading_inverse']);
            }
            $heading_str = ceris_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
            $the_query = bk_get_query::ceris_query($moduleConfigs);              //get query
            //Spacing Between Elements
            $moduleConfigs['module_margin_top'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_module_margin_top', true );
            $moduleConfigs['heading_margin_bottom'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_margin_bottom', true );
            //Check Margin
            if($moduleConfigs['module_margin_top'] < 0) :
                $blockMarginTopClass = 'atbs-custom-margin-top-minus-'.abs($moduleConfigs['module_margin_top']);
            elseif(($moduleConfigs['module_margin_top'] > 0)) :
                $blockMarginTopClass = 'atbs-custom-margin-top-'.abs($moduleConfigs['module_margin_top']);
            else:
                $blockMarginTopClass = '';
            endif;
            $moduleConfigs['module_custom_spacing_option'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_module_custom_spacing_option', true );
            if($moduleConfigs['module_custom_spacing_option'] == 'disable'){
                $blockMarginTopClass = '';
            }else{
                if($moduleConfigs['heading_margin_bottom'] != 50) {
                    $headingClass .= ' atbs-custom-margin-bottom-'.abs($moduleConfigs['heading_margin_bottom']);
                }
            }
            //end Spacing Between Elements
            if ( $the_query->have_posts() ) :
                
                if($moduleConfigs['title'] != null){
                    if( $moduleConfigs['heading_style'] == 'default'     ||
                        $moduleConfigs['heading_style'] == 'line'        || 
                        $moduleConfigs['heading_style'] == 'no-line'     || 
                        $moduleConfigs['heading_style'] == 'line-under'  || 
                        $moduleConfigs['heading_style'] == 'center'      || 
                        $moduleConfigs['heading_style'] == 'line-around'
                    ):
                        $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-feature-k '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
                        $block_str .= '<div class="container">';
                        $block_str .= ceris_core::bk_get_block_heading($moduleConfigs['title'], $headingClass, $moduleConfigs['heading_color']);

                    else:
                        $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-feature-k '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
                        $block_str .= '<div class="container">';
                        $block_str .= ceris_core::bk_get_block_heading($moduleConfigs['title'], $headingClass, $moduleConfigs['heading_color']);   
                    endif;
                }else{
                    $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-feature-k '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
                    $block_str .= '<div class="container">';
                }
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
            $smalltitle = '';
            $linkViewAll = '';
            $postSource = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_source', true );
            $postIcon = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon', true );
            $iconPosition = 'top-right';
            $postAnimation = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon_animation', true );
            $bypasspostAnimationDetech = '';
            if($postAnimation == 'disable') {
                $bypasspostAnimationDetech = '';
            }else {
                $bypasspostAnimationDetech = 'icon-has-animation';
            }

            $render_modules = '';
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
                'cat'                     => $catStyle,
                'catClass'                => $cat_Class,
                'additionalClass'         => 'post--horizontal-feature-large',
                'additionalTextClass'     => '',
                'additionalTextInnerClass'=> 'remove-margin-bottom-lastchild',
                'additionalThumbClass'    => 'atbs-thumb-object-fit',
                'typescale'               => 'typescale-4',
                'meta'                    => array('author_has_wrap', 'date'),
                'additionalExcerptClass'  => 'post__excerpt-style-2',
                'thumbSize'               => 'ceris-l-16_9',
            );     
            
            $postNothumbHTML = new ceris_post_nothumb_1;        
            $postNothumbAttr = array (
                'cat'                    => $catStyle,
                'catClass'               => $cat_Class,
                'additionalClass'        => 'post--no-thumb-small',
                'additionalTextClass'    => 'remove-margin-bottom-lastchild',
                'typescale'              => 'typescale-1',
            );
            $carouselID = uniqid('carousel-feature-slider-');
            while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                $maxPosts = $the_query->post_count;

                    if($currentPost < ($maxPosts - 2) || (($maxPosts < 4) && ($currentPost == 0))):
                        if($currentPost == 0):                   
                            $render_modules .= '<div class="main-posts">';
                            if($maxPosts > 3):
                                $render_modules .= '<div id="'.$carouselID.'" class="owl-carousel js-atbs-ceris-carousel-1i-fade-dot-number-effect atbs-ceris-carousel dots-circle nav-circle nav-border owl-drag owl-loaded">';
                            else:
                                $render_modules .= '<div id="'.$carouselID.'" class="carousel-visible dots-circle nav-circle nav-border owl-drag owl-loaded">';
                            endif;
                        endif;

                        $render_modules .= '<div class="slide-content">';
                        $postHorizontalAttr['postID'] = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            $addClass = '';
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                            }

                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $iconPosition, $addClass);
                            
                            $postHorizontalAttr['postIcon'] = $postIconAttr;
                        } 
                        $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                        $render_modules .= '</div><!-- .slide-content -->'; 

                        if(($currentPost == ($maxPosts - 3)) || ($maxPosts < 3) ):
                            $render_modules .= '</div><!-- .owl-carousel -->'; 
                            if($maxPosts > 3):
                                $render_modules .= '<div class="atbs-ceris-carousel-nav-custom-holder nav-circle nav-border flexbox-wrap flexbox-center-y" data-carouselid="'.$carouselID.'">'; 
                                $render_modules .= '<div class="owl-prev js-carousel-prev"><i class="mdicon mdicon-navigate_before"></i></div>';
                                $render_modules .= '<div id="numberSlide" class="owl-number">1 <span class="slide-seperated">/</span> 5</div>'; 
                                $render_modules .= '<div class="owl-next js-carousel-next"><i class="mdicon mdicon-navigate_next"></i></div>'; 
                                $render_modules .= '</div>'; 
                            endif;
                            $render_modules .= '</div><!-- .main-post -->';
                        endif;
                    else:
                        if(($currentPost == ($maxPosts - 2)) || (($maxPosts < 4) && ($currentPost == 1))):
                            $render_modules .= '<div class="sub-posts">';
                            $render_modules .= '<div class="posts-list list-space-xl flexbox-wrap flexbox-wrap-2i">';
                        endif;
                        $render_modules .= '<div class="list-item">';
                        $postNothumbAttr['postID'] = get_the_ID();
                        $render_modules .= $postNothumbHTML->render($postNothumbAttr);
                        $render_modules .= '</div><!-- .list-item -->'; 
                        if($currentPost == ($maxPosts - 1) || (($maxPosts < 4) && ($currentPost == 2))):
                            $render_modules .= '</div><!-- .posts-list -->';
                            $render_modules .= '</div><!-- .sub-posts -->';
                        endif;
                    endif;












                    
                
            endwhile;

            return $render_modules;   
        }
    }
}