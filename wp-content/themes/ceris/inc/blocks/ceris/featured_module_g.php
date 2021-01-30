<?php
if (!class_exists('ceris_featured_module_g')) {
    class ceris_featured_module_g {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_featured_module_g-');
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
            //end Spacing Between Elements
            if ( $the_query->have_posts() ) :
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-feature-g '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
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
            $catStyle = 4;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            $postVerticalHTML = new ceris_post_vertical_6;         
            $postVerticalAttr = array (
                'cat'                    => $catStyle,
                'catClass'               => $cat_Class,
                'additionalClass'        => 'post-meta--large post--vertical-thumb-640 post--vertical-feature-normal'.$bypasspostAnimationDetech,
                'additionalThumbClass'   => 'atbs-thumb-object-fit',
                'typescale'              => 'typescale-3 custom-typescale-3',
                'postIcon'               => $postIconAttr,
                'meta'                   => array('author', 'date'),
                'thumbSize'              => 'ceris-m-4_3',
            );
            $postVerticalAttr_2 = array (
                'cat'                    => $catStyle,
                'catClass'               => $cat_Class,
                'additionalClass'        => 'post--vertical-thumb-radius-large',
                'additionalThumbClass'   => 'post__thumb--radius atbs-thumb-object-fit',
                'additionalTextClass'    => 'text-center',
                'typescale'              => 'typescale-2 custom-typescale-2',
                'postIcon'               => $postIconAttr,
                'thumbSize'              => 'ceris-s-1_1',
                'meta'                   => array('author_name', 'date'),
            );
            $catStyle = 3;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            $postHorizontalHTML = new ceris_post_horizontal_1;         
            $postHorizontalAttr = array (
                'additionalClass'        => 'post--horizontal-sm post--horizontal-thumb-100',
                'additionalThumbClass'   => 'atbs-thumb-object-fit',
                'additionalTextClass'    => 'remove-margin-bottom-lastchild',
                'typescale'              => 'typescale-1',
                'postIcon'               => $postIconAttr,
                'thumbSize'              => 'ceris-xxs-1_1',
                'meta'                   => array('date'),
            );
            $render_modules = '';
            $currentPost = '';
            
            while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                $maxPosts = $the_query->post_count;
                if($currentPost == 0):
                    $render_modules .= '<div class="left-col">';
                    $postVerticalAttr['postID'] = get_the_ID();
                     if($bypassPostIconDetech != 1) {
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType']   = ceris_core::bk_post_format_detect(get_the_ID());
                        }
                        $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $iconPosition);
                        $postVerticalAttr['postIcon']    = $postIconAttr;
                    }    
                    $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                    $render_modules .= '</div><!-- .left-col -->';
                else:
                    if( (($currentPost > 0) && ($currentPost < ($maxPosts - 2)) && ($maxPosts > 3) )  ||  (($currentPost > 0)&& ($maxPosts < 4)) ):
                        if($currentPost == 1):
                            $render_modules .= '<div class="right-col">';
                            if(($maxPosts == 2) || ($maxPosts == 4)):
                                $render_modules .= '<div class="atbs-ceris-carousel-post-vertical atbs-ceris-carousel-thumb-radius dots-circle nav-circle nav-border">';
                            else:
                                $render_modules .= '<div class="owl-carousel js-atbs-ceris-carousel-1i30m-thumb-round atbs-ceris-carousel atbs-ceris-carousel-post-vertical atbs-ceris-carousel-thumb-radius dots-circle nav-circle nav-border">';
                            endif;
                        endif;
                        $render_modules .= '<div class="slide-content">';
                        $postVerticalAttr_2['postID'] = get_the_ID();
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr_2);
                        $render_modules .= '</div><!-- .slide-content -->';
                        if(($currentPost == ($maxPosts - 3)) || (($currentPost == ($maxPosts - 1)) && ($maxPosts < 4))):
                            $render_modules .= '</div><!-- .owl-carousel -->';
                        endif;
                    else:
                        if($currentPost == ($maxPosts - 2)):
                            $render_modules .= '<div class="posts-list list-space-xl">';
                        endif;
                        $render_modules .= '<div class="list-item">';
                        $postHorizontalAttr['postID'] = get_the_ID();
                        $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                        $render_modules .= '</div><!-- .list-item -->';
                        if($currentPost == ($maxPosts - 1)):
                            $render_modules .= '</div><!-- .posts-list -->';
                            $render_modules .= '</div><!-- .right-col -->';
                        endif;
                    endif;
                endif;
            endwhile;
            if(($currentPost > 0) && ($currentPost < 3)):
                $render_modules .= '</div><!-- .right-col -->';
            endif;
            return $render_modules;    
        }
    }
}