<?php
if (!class_exists('ceris_featured_with_list_horizontal')) {
    class ceris_featured_with_list_horizontal {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            global $cerisModuleSpacing;
            $moduleID = uniqid('ceris_featured_with_list_horizontal-');
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
           
            //Post Source
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );            
            
            $the_query = bk_get_query::ceris_query($moduleConfigs);              //get query
            $moduleData['the_query'] = $the_query;
            $moduleData['moduleConfigs'] = $moduleConfigs;
            
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
            
            $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-featured-with-list atbs-ceris-block-custom-margin atbs-ceris-featured-with-list--horizontal-list '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
            
            $block_str .= ceris_core::bk_render_block_heading($page_info);
            
           	$block_str .= '<div class="atbs-ceris-featured-with-list__wrapper atbs-ceris-block__inner js-overlay-bg">';
            $block_str .= $this->render_modules($moduleData);            //render modules
            $block_str .= '</div><!-- .atbs-ceris-block__inner -->';
            $block_str .= '</div><!-- .atbs-ceris-block -->';
            
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function postText($postID){
            $bk_permalink = esc_url(get_permalink($postID));
            $bk_post_title = get_the_title($postID);
            $postText = '';            
            $postText .= '<div class="post__text inverse-text text-center">';
            $postText .= '<div class="post__text-inner">';
            
            $catClass = 'post__cat post__cat--bg cat-theme-bg';
            $postText .= ceris_core::bk_get_post_cat_link($postID, $catClass);
            
    		$postText .= '<h3 class="post__title typescale-6"><a href="'.$bk_permalink.'">'.$bk_post_title.'</a></h3>';
            $postText .= '<div class="entry-author entry-author--horizontal item-justify-center">';
            $postText .= ceris_core::bk_get_post_meta(array('author'));
            $postText .= '</div>';
            
            $postText .= '</div>';
			$postText .= '</div>';
            
            return $postText;
        }
        public function main_post($postID){
            $customArgs = array (
                'postID'        => $postID,
                'thumbSize'     => 'ceris-s-4_3',                                              
            );
            $ImgBGLink  = ceris_core::bk_get_post_thumbnail_bg_link($customArgs);       
            $BGImg      = "background-image: url('".$ImgBGLink."')";
            
            $mainPost = '';
            $mainPost .= '<article class="main-post post post--overlay-text-align-center">';
			$mainPost .= '<div class="main-post__inner">';
            $mainPost .= '<div class="background-img background-img--darkened hidden-md hidden-lg" style="'.$BGImg.'"></div>';
			$mainPost .= $this->postText($postID);
			$mainPost .= '</div>';
			$mainPost .= '</article>';
            return $mainPost;                        
        }
        public function render_modules ($moduleData){
            $the_query = $moduleData['the_query'];
            $moduleConfigs = $moduleData['moduleConfigs'];
            $render_modules = '';
            if ( $the_query->have_posts() ) :
                $the_query->the_post();
                $postID = get_the_ID();
                                        
                $customArgs = array (
                    'postID'        => $postID,
                    'thumbSize'     => 'ceris-xxl',                                
                );
                $firstBGLink     = ceris_core::bk_get_post_thumbnail_bg_link($customArgs);       
                $firstBGImg   = "background-image: url('".$firstBGLink."')";
                $render_modules .= '<div class="main-background background-img hidden-xs hidden-sm" style="'.$firstBGImg.'"></div>';
                $render_modules .= '<div class="atbs-ceris-featured-with-list__inner">';
                $render_modules .= $this->main_post($postID);
            endif;
            $postHorizontalHTML = new ceris_horizontal_1;
            $cat_S = 4;
                $postHorizontalAttr = array (
                    'additionalClass'       => 'post--horizontal-middle post--horizontal-xs posts-has-smaller-post-cat',
                    'additionalTextClass'   => 'inverse-text',
                    'catClass'              => 'post__cat post__cat--bg cat-theme-bg',
                    'cat'                   => $cat_S?4:0,
                    'thumbSize'             => 'ceris-xxs-1_1',
                    'additionalThumbClass'  => 'post__thumb--circle',
                    'typescale'             => 'typescale-1',
                );
            if ( $the_query->have_posts() ) :
                $render_modules .= '<div class="sub-posts js-overlay-bg-sub-area">';
                $render_modules .= '<div class="js-overlay-bg-sub sub-background background-img blurred hidden-xs hidden-sm" style="'.$firstBGImg.'"></div>';
                $render_modules .= '<div class="sub-posts__inner">';
                $render_modules .= '<ul class="posts-list list-space-md list-seperated list-unstyled">';
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $postHorizontalAttr['postID'] = get_the_ID();
                    $render_modules .= '<li>';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</li> <!-- end small item -->';
                endwhile;                    
                $render_modules .= '</ul><!-- end small item list-->';
                $render_modules .= '</div>';
                $render_modules .= '</div><!-- .sub-posts -->';
            endif;
            
            $render_modules .= '</div><!-- .atbs-ceris-featured-with-list__inner -->';
            
            return $render_modules;
        }
        
    }
}