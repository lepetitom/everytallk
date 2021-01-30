<?php
if (!class_exists('ceris_featured_module')) {
    class ceris_featured_module {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_featured_module-');
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
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin feature-module atbs-ceris-posts-feature '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
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
            
            $postMainHTML = new ceris_post_main;         
            $postMainAttr = array (
                'cat'                  => $catStyle,
                'catClass'             => $cat_Class,
                'additionalClass'      => 'post-feature-text-top post__thumb-675 remove-margin-bottom-lastchild icon-right-center '.$bypasspostAnimationDetech.'',
                'additionalTextClass'  => 'remove-margin-bottom-lastchild inverse-text',
                'additionalThumbClass' => 'post__img--overlay background-img atbs-thumb-object-fit',
                'iconPosition'         => 'right-center',
                'typescale'            => 'typescale-2',
                'thumbSize'            => 'ceris-xl-2_1',
                'meta'                 => array('author_horizontal'),
                'postIcon'             => $postIconAttr,
            );
            
            $catStyle = 3;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            
            $postNothumbHTML = new ceris_post_nothumb_1;         
            $postNothumbAttr = array (
                'cat'                    => $catStyle,
                'catClass'               => $cat_Class.' post__cat-has-line',
                'additionalClass'        => 'post-no-thumb-feature-small remove-margin-bottom-lastchild',
                'additionalTextClass'    => '',
                'typescale'              => 'typescale-2 custom-typescale-2',
                'thumbSize'              => '',
                'readmore'               => 1,
                'additionalTextReadMore' => 'readmore-normal',
                'postIcon'               => $postIconAttr,

            );
            $render_modules = '';
            $currentPost = '';
            $carouselID = uniqid('carousel-feature-slider-');
            
            while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                
                if($currentPost == 0):
                    $render_modules .= '<div class="post-main">';
                    $postMainAttr['postID'] = get_the_ID();
                    if($bypassPostIconDetech != 1) {
                        $addClass = '';
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                        }
                        $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $iconPosition, $addClass);
                        if(($postIconAttr['iconType'] == 'gallery') || ($postIconAttr['iconType'] == 'review')):
                            $postIconAttr['iconType'] = '';
                        endif;
                        $postMainAttr['postIcon'] = $postIconAttr;
                    }
                    $render_modules .= $postMainHTML->render($postMainAttr);
                    $render_modules .= '</div><!-- .post-main -->';
                elseif($currentPost > 0):
                    $postNothumbAttr['postID'] = get_the_ID();
                    if($currentPost == 1):
                        $render_modules .= '<div class="post-sub">';
                        $render_modules .= '<div class="post-list">';
                    endif;
                    
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postNothumbHTML->render($postNothumbAttr);
                    $render_modules .= '</div><!-- .list-item -->';
                    
                    if($currentPost == 3):
                        $render_modules .= '</div><!-- .post-list -->';
                        $render_modules .= '</div><!-- .post-sub -->';
                    endif;
                endif;
            endwhile;
            if(($currentPost > 0) && ($currentPost!= 3 )):
               $render_modules .= '</div><!-- .post-list -->';
               $render_modules .= '</div><!-- .post-sub -->';
            endif;
            return $render_modules;    
        }
    }
}