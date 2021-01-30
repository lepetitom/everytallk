<?php
if (!class_exists('ceris_authors_list')) {
    class ceris_authors_list {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_authors_list-');
            $moduleConfigs = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            $moduleConfigs['author_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_author_id', true );
            $moduleConfigs['image'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_image', true );
            $moduleConfigs['load_more'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_load_more', true );
            
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = ' '.$moduleConfigs['custom_class'];
            }else {
                $moduleCustomClass = '';
            }
            $authorIDs = explode(',',$moduleConfigs['author_id']);
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
            
            $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-author-list clearfix '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
            $block_str .= ceris_core::bk_render_block_heading($page_info);
            $block_str .= '<div class="container">';
                
            $block_str .= '<div class="atbs-ceris-block__inner">';
            $block_str .= $this->render_modules($authorIDs);            //render modules
            $block_str .= '</div><!-- .atbs-ceris-block__inner -->';
            $block_str .= '</div><!-- .container -->';
            $block_str .= '</div><!-- .atbs-ceris-block -->';
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        
        public function render_modules ($authorIDs){
            $moduleHTML = new ceris_category_tile;
            $render_modules = '';
            $counter = 0;
            $render_modules .= '<div class="post-list">';
            foreach ($authorIDs as $authorID) {
                $render_modules .= '<div class="list-item">';
                $render_modules .= ceris_archive::author_item($authorID);
                $render_modules .= '</div><!-- .list-item -->';  
            }
            $render_modules .= '</div><!--post-list-->';
            return $render_modules;
        }
    }
}