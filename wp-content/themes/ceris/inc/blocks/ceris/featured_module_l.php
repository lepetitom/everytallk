<?php
if (!class_exists('ceris_featured_module_l')) {
    class ceris_featured_module_l {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_featured_module_l-');
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
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-feature-l '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
                $block_str .= ceris_core::bk_render_block_heading($page_info);
                $block_str .= '<div class="container">';
                $block_str .= '<div class="atbs-ceris-block__inner flexbox-wrap flex-space-40">';
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
                $bypasspostAnimationDetech = ' icon-has-animation';
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
            
            $postVerticalHTML = new ceris_post_vertical_2;        
            $postVerticalAttr = array (
                'cat'                    => $catStyle,
                'catClass'               => $cat_Class,
                'additionalClass'        => 'post-meta--large post--vertical-reverse post--vertical-reverse-feature'.$bypasspostAnimationDetech, 
                'additionalTextClass'    => '',
                'typescale'           => '',
                'thumbSize'              => 'ceris-m-4_3',
                'additionalThumbClass'    => 'atbs-thumb-object-fit',
                'postIcon'            => $postIconAttr,
                'meta'                    => array('author', 'date'),
            );

            $postVerticalHTML_2 = new ceris_post_vertical_8;        
            $postVerticalAttr_2 = array (
                'cat'                    => $catStyle,
                'catClass'               => $cat_Class,
                'additionalClass'        => 'post--vertical-reverse post--vertical-reverse-thumb-middle'.$bypasspostAnimationDetech, 
                'additionalTextClass'    => '',
                'additionalExcerptClass' => 'post__excerpt-style-2',
                'except_length'          => 15,
                'additionalTextReadMore' => 'post__readmore--line-before',
                'readmore'               => 1,
                'typescale'              => '',
                'thumbSize'              => 'ceris-xs-1_1',
                'additionalThumbClass'    => 'atbs-thumb-object-fit',
                'postIcon'               => $postIconAttr,
                'meta'                    => array('date'),
            );

            $postHorizontalHTML = new ceris_post_horizontal_1;        
            $postHorizontalAttr = array (
                'additionalClass'         => 'post--horizontal-thumb-90 post--horizontal-small-normal',
                'additionalTextClass'     => 'remove-margin-bottom-lastchild',
                'additionalThumbClass'    => 'atbs-thumb-object-fit',
                'thumbSize'               => 'ceris-xxs-1_1',
                'typescale'               => 'typescale-1',
                'meta'                    => array('date'),
            );     
            $carouselID = uniqid('carousel-feature-slider-');
            while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                $maxPosts = $the_query->post_count;

                if($currentPost == 0):                   
                    $render_modules .= '<div class="main-post">';
                    $postVerticalAttr['postID'] = get_the_ID();
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
                            $postVerticalAttr['postIcon'] = $postIconAttr;
                        }
                    $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                    $render_modules .= '</div><!-- .main-post -->';
                elseif($currentPost == 1):
                    $render_modules .= '<div class="aside-post">';
                    $postVerticalAttr_2['postID'] = get_the_ID();
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
                            $postVerticalAttr_2['postIcon'] = $postIconAttr;
                        }
                    $render_modules .= $postVerticalHTML_2->render($postVerticalAttr_2);
                    $render_modules .= '</div><!-- .aside-post -->';
                else:
                    if($currentPost == 2):
                        $render_modules .= '<div class="sub-posts">';
                        $render_modules .= '<div class="posts-list flexbox-wrap flexbox-wrap-2i flex-space-40">';
                    endif;
                    $postHorizontalAttr['postID'] = get_the_ID();
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                endif;
                
            endwhile;
            if($currentPost > 1){
                $render_modules .= '</div><!-- .posts-list -->';
                $render_modules .= '</div><!-- .sub-posts -->';
            }

            return $render_modules;   
        }
    }
}