<?php
if (!class_exists('ceris_grid_e')) {
    class ceris_grid_e {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_grid_e-');
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
                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-grid-e atbs-ceris-post--grid-c-update clearfix '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
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
            $postMainHTML = new ceris_post_main_2;         
            $postMainAttr = array (
                'cat'                    => $catStyle,
                'catClass'               => $cat_Class,
                'additionalClass'        => 'post-no-thumb-title-line remove-margin-bottom-lastchild',
                'additionalTextClass'    => '',
                'typescale'              => 'typescale-2',
                'thumbSize'              => 'ceris-xl-2_1',
                'except_length'          => 15,
                'postIcon'               => $postIconAttr,
                'readmore'               => 1,
                'additionalTextReadMore' => 'readmore-normal',
            );
            $render_modules = '';
            $currentPost = '';
            $carouselID = uniqid('carousel-feature-slider-');
             while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                $maxPosts = $the_query->post_count;
                if($currentPost >= 0):
                    if($currentPost == 0):
                        $render_modules .= '<div class="post-main">';
                        $render_modules .= '<div class="owl-background-item">';
                        $render_modules .= '<div class="owl-background-item-left owl-item-img" style="background-image: url(&quot;'.get_the_post_thumbnail_url(get_the_ID(), 'ceris-xl-2_1').'&quot;);"></div>';
                        $render_modules .= '<div class="owl-background-item-front owl-item-img" style="background-image: url(&quot;'.get_the_post_thumbnail_url(get_the_ID(), 'ceris-xl-2_1').'&quot;);"></div>';
                        $render_modules .= '<div class="owl-background-item-right owl-item-img" style="background-image: url(&quot;'.get_the_post_thumbnail_url(get_the_ID(), 'ceris-xl-2_1').'&quot;);"></div>';
                        $render_modules .= '</div> <!-- .owl-background-item -->';
                        
                        $render_modules .= '<div class="owl-carousel js-carousel-2i30m atbs-ceris-carousel dots-circle nav-circle">';
                    endif;
                    $postMainAttr['postID'] = get_the_ID();
                    $render_modules .= '<div class="slide-content">';
                    $render_modules .= $postMainHTML->render($postMainAttr);
                    $render_modules .= '</div><!-- .slide-content -->';
                    if($currentPost == ($maxPosts - 1)):
                        $render_modules .= '</div><!-- .owl-carousel -->';
                        $render_modules .= '</div><!-- .post-main -->';
                    endif;
                endif;
            endwhile;
            if(($currentPost > 0) && ($currentPost!= ($maxPosts - 1) )):
               $render_modules .= '</div><!-- .owl-carousel -->';
               $render_modules .= '</div><!-- .post-main -->';
            endif;
            return $render_modules;
        }
    }
}