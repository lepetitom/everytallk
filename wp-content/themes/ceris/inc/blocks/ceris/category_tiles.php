<?php
if (!class_exists('ceris_category_tiles')) {
    class ceris_category_tiles {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_category_tiles-');
            $moduleConfigs = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['category_description'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category_description', true );
            $moduleConfigs['image'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_image', true );
            $moduleConfigs['load_more'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_load_more', true );
            
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = ' '.$moduleConfigs['custom_class'];
            }else {
                $moduleCustomClass = '';
            }

            $categoryIDs = explode(',',$moduleConfigs['category_id']);
            $categoryCount = ceris_core::bk_count_post_in_category($categoryIDs);
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
            $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin category-tiles ceris-category-tiles '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
            $block_str .= ceris_core::bk_render_block_heading($page_info);
                
            $block_str .= '<div class="atbs-ceris-block__inner">';
            $block_str .= '<div class="container">';
            $block_str .= $this->render_modules($categoryCount);            //render modules
            $block_str .= '</div><!-- .container -->';
            $block_str .= '</div><!-- .atbs-ceris-block__inner -->';
            $block_str .= '</div><!-- .atbs-ceris-block -->';
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_modules ($categoryCount){
            $catDescription = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_category_description', true );
            $moduleHTML = new ceris_category_tile;
            $render_modules = '';
            $counter = 0;
           
            $render_modules .= '<div class="owl-carousel js-carousel-3i30m atbs-ceris-carousel dots-circle">';
            foreach ($categoryCount as $catID => $postCount) {
                $categoryAttr = array(
                    'catID'           => $catID,
                    'additionalClass' => 'category-nothumb-cat-large',
                    'thumbSize'       => '',
                    'description'     => '',
                );
                if($catDescription == 'description') {
                    $categoryAttr['description'] = category_description( $catID ); 
                }else if($catDescription == 'post-count') {
                    $categoryInfo = get_category($catID); 
                    $categoryAttr['description'] = $categoryInfo->category_count . esc_html__(' Articles', 'ceris');
                }else {
                    $categoryAttr['description'] = '';
                }
                $render_modules .= '<div class="slide-content">';
                $render_modules .= $moduleHTML->render($categoryAttr);
                $render_modules .= '</div><!-- .slide-content -->';
                
            }
            $render_modules .= '</div><!-- .owl-carousel -->';
            return $render_modules;
        }
    }
}