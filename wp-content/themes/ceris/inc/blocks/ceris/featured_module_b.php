<?php
if (!class_exists('ceris_featured_module_b')) {
    class ceris_featured_module_b {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_featured_module_b-');
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            $contiguousClass = 'atbs-ceris-block--contiguous';
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
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth feature-module-b atbs-ceris-block-custom-margin atbs-ceris-posts-feature-d-update '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
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
            $iconPosition = 'center';
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
            
            $catStyle = 4;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            
            $postVerticalHTML = new ceris_post_vertical_4;         
            $postVerticalAttr = array (
                'cat'                  => $catStyle,
                'catClass'             => $cat_Class,
                'additionalClass'      => 'post--vertical-text-index',
                'additionalTextClass'  => 'clearfix',
                'additionalThumbClass' => 'atbs-thumb-object-fit',
                'thumbSize'            => 'ceris-xl-4_3',
                'except_length'        => 15,
                'typescale'            => 'typescale-1',
                'postIcon'             => $postIconAttr,
                'readmore'             => 1,
                'additionalTextReadMore' => 'ceris-readmore-style-1',
                'meta'                 => array('author_name', 'date'),
            );
            $catStyle = 3;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            $postHorizontalHTML = new ceris_post_horizontal_1;         
            $postHorizontalAttr = array (
                'cat'                  => $catStyle,
                'catClass'             => $cat_Class,
                'additionalClass'      => 'post--horizontal-middle post--horizontal-xs post--horizontal-80 remove-margin-bottom-lastchild post--horizontal-cat-no-line',
                'additionalTextClass'  => 'remove-margin-bottom-lastchild',
                'additionalThumbClass' => '',
                'typescale'            => 'typescale-1 custom-typescale-1',
                'thumbSize'            => 'ceris-xxs-1_1',
                'postIcon'             => $postIconAttr,

            );
            $render_modules = '';
            $currentPost = '';
            $carouselID = uniqid('carousel-');
            $currentPost = '';
            $maxPosts = $the_query->post_count;
            while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                $maxPosts = $the_query->post_count;
                if( (($currentPost >= 0) && ($maxPosts < 4)) || (($currentPost >= 0) && ( $currentPost < ($maxPosts - 3) )) ):
                        
                    if($currentPost == 0):
                        $render_modules .= '<div class="owl-background">';
                        $render_modules .= '<a href="'.get_permalink(get_the_ID()).'">
                                <img src="'.get_the_post_thumbnail_url(get_the_ID(), 'ceris-xl-4_3').'" alt="owl-bg" class="owl-background-img active">
                            </a>';
                        $render_modules .= '<a href="'.get_permalink(get_the_ID()).'">
                            <img src="'.get_the_post_thumbnail_url(get_the_ID(), 'ceris-xl-4_3').'" alt="owl-bg" class="owl-background-img">
                        </a>';
                        $render_modules .= '</div><!-- .owl-background -->';
                        $render_modules .= '<div class="block__inner--wrap">';
                        $render_modules .= '<div class="post-main">';
                        $render_modules .= '<div id="'.$carouselID.'" class="owl-carousel js-atbs-ceris-carousel-1i-dot-number-get-background atbs-ceris-carousel dots-circle">';
                    endif;
                    $render_modules .= '<div class="slide-content">';
                    $postVerticalAttr['postID'] = get_the_ID();
                    $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                    $render_modules .= '</div><!-- .slide-content -->';
                    if($currentPost == ($maxPosts - 4)):
                        $render_modules .= '</div><!-- .atbs-ceris-carousel -->';
                        $render_modules .= '<div class="atbs-ceris-carousel-nav-custom-holder nav-row-circle" data-carouselid="'.$carouselID.'">';
                        $render_modules .= '<div class="owl-prev js-carousel-prev"><i class="mdicon mdicon-navigate_before"></i></div>';
                        $render_modules .= '<div class="owl-number"></div>';
                        $render_modules .= '<div class="owl-next js-carousel-next"><i class="mdicon mdicon-navigate_next"></i></div>';
                        $render_modules .= '</div>';
                        $render_modules .= '</div><!-- .post-main -->';
                    endif;
                elseif(($currentPost >= ($maxPosts - 3))):
                    
                    if($currentPost == ($maxPosts - 3)):
                        $render_modules .= '<div class="post-sub">';
                            $render_modules .= '<div class="post-list">';
                    endif;
                        $postHorizontalAttr['postID'] = get_the_ID();
                        $render_modules .= '<div class="list-item">';
                        $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                        $render_modules .= '</div><!-- .list-item -->';
                    if($currentPost == ($maxPosts - 1)):
                        $render_modules .= '</div><!-- .post-list -->';
                        $render_modules .= '</div><!-- .post-sub -->';
                        $render_modules .= '</div><!-- .block__inner--wrap -->';
                    endif;
                endif;            
            endwhile;
            
            if(($currentPost >= 0) && ($maxPosts < 4)):
                $render_modules .= '</div><!-- .atbs-ceris-carousel -->';
                $render_modules .= '<div class="atbs-ceris-carousel-nav-custom-holder nav-row-circle" data-carouselid="'.$carouselID.'">';
                $render_modules .= '<div class="owl-prev js-carousel-prev"><i class="mdicon mdicon-navigate_before"></i></div>';
                $render_modules .= '<div class="owl-number"></div>';
                $render_modules .= '<div class="owl-next js-carousel-next"><i class="mdicon mdicon-navigate_next"></i></div>';
                $render_modules .= '</div>';
                $render_modules .= '</div><!-- .post-main -->';
                $render_modules .= '</div><!-- .block__inner--wrap -->';  
                
            endif;
            return $render_modules;
        }
    }
}