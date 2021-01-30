<?php
if (!class_exists('ceris_posts_block_grid_b_no_sidebar')) {
    class ceris_posts_block_grid_b_no_sidebar {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_posts_block_grid_b_no_sidebar-');
            
            $moduleConfigs_1 = array();
            $moduleConfigs_2 = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            
            $moduleTitle_1 = array(
                'title'     => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title_1', true ),
            );  
            $moduleConfigs_1['heading_color'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_color_1', true );
            $moduleConfigs_1['orderby']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby_1', true );
            $moduleConfigs_1['tags']        = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags_1', true ); 
            $moduleConfigs_1['limit']       = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit_1', true );
            $moduleConfigs_1['offset']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset_1', true );
            $moduleConfigs_1['feature']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature_1', true );
            $moduleConfigs_1['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category_1', true );
            $moduleConfigs_1['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick_1', true );
            $moduleConfigs_1['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude_1', true );
            $moduleConfigs_1['heading_style'] = 'line-under';
            $moduleConfigs_1['heading_inverse'] = 'no';
            $moduleConfigs_1['viewmore'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_viewmore_1', true );
            
            if(isset($moduleConfigs_1['heading_style'])) {
                $headingClass_1 = ceris_core::bk_get_block_heading_class($moduleConfigs_1['heading_style'], $moduleConfigs_1['heading_inverse']);
            }
            $moduleTitle_2 = array(
                'title'     => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title_2', true ),
            );  
            $moduleConfigs_2['heading_color'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_color_2', true );
            $moduleConfigs_2['orderby']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby_2', true );
            $moduleConfigs_2['tags']        = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags_2', true );
            $moduleConfigs_2['limit']       = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit_2', true );
            $moduleConfigs_2['offset']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset_2', true );
            $moduleConfigs_2['feature']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature_2', true );
            $moduleConfigs_2['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category_2', true );
            $moduleConfigs_2['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick_2', true );
            $moduleConfigs_2['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude_2', true );
            $moduleConfigs_2['heading_style'] = 'line-under';
            $moduleConfigs_2['heading_inverse'] = 'no';
            $moduleConfigs_2['viewmore'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_viewmore_2', true );
            
            if(isset($moduleConfigs_2['heading_style'])) {
                $headingClass_2 = ceris_core::bk_get_block_heading_class($moduleConfigs_2['heading_style'], $moduleConfigs_2['heading_inverse']);
            }
            $moduleTitle_3 = array(
                'title'     => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title_3', true ),
            );  
            $moduleConfigs_3['heading_color'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_color_3', true );
            $moduleConfigs_3['orderby']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby_3', true );
            $moduleConfigs_3['tags']        = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags_3', true ); 
            $moduleConfigs_3['limit']       = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit_3', true );
            $moduleConfigs_3['offset']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset_3', true );
            $moduleConfigs_3['feature']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature_3', true );
            $moduleConfigs_3['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category_3', true );
            $moduleConfigs_3['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick_3', true );
            $moduleConfigs_3['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude_3', true );
            $moduleConfigs_3['heading_style'] = 'line-under';
            $moduleConfigs_3['heading_inverse'] = 'no';
            $moduleConfigs_3['viewmore'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_viewmore_3', true );
            
            if(isset($moduleConfigs_3['heading_style'])) {
                $headingClass_3 = ceris_core::bk_get_block_heading_class($moduleConfigs_3['heading_style'], $moduleConfigs_3['heading_inverse']);
            }
            
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = ' '.$moduleConfigs['custom_class'];
            }else {
                $moduleCustomClass = '';
            }
            
            $the_query_1 = bk_get_query::query($moduleConfigs_1);              //get query
            $the_query_2 = bk_get_query::query($moduleConfigs_2);
            $the_query_3 = bk_get_query::query($moduleConfigs_3);
            
            //Check Margin
            $moduleConfigs['module_custom_spacing_option'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_module_custom_spacing_option', true );
            if($moduleConfigs['module_custom_spacing_option'] == 'disable'){
                $blockMarginTopClass = '';
            }else{
                //Spacing Between Elements
                $moduleConfigs['module_margin_top'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_module_margin_top', true );
                $moduleConfigs['heading_margin_bottom'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_margin_bottom', true );
                
                if($moduleConfigs['module_margin_top'] < 0) :
                    $blockMarginTopClass = 'atbs-custom-margin-top-minus-'.abs($moduleConfigs['module_margin_top']);
                elseif(($moduleConfigs['module_margin_top'] > 0)) :
                    $blockMarginTopClass = 'atbs-custom-margin-top-'.abs($moduleConfigs['module_margin_top']);
                else:
                    $blockMarginTopClass = '';
                endif;
                
                if($moduleConfigs['heading_margin_bottom'] != '') {
                    $headingClass_1 .= ' atbs-custom-margin-bottom-'.abs($moduleConfigs['heading_margin_bottom']);
                    $headingClass_2 .= ' atbs-custom-margin-bottom-'.abs($moduleConfigs['heading_margin_bottom']);
                    $headingClass_3 .= ' atbs-custom-margin-bottom-'.abs($moduleConfigs['heading_margin_bottom']);
                }
            }
            
            if (( $the_query_1->have_posts() ) || ( $the_query_2->have_posts() ) || ( $the_query_3->have_posts() )) :
            
            $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-posts-block-grid-b-no-sidebar '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
            $block_str .= '<div class="container">';
           	$block_str .= '<div class="row row--space-between">';
            //Column 1
            $block_str .= '<div class="col-xs-12 col-sm-4">';
            $block_str .= ceris_core::bk_get_block_heading($moduleTitle_1, $headingClass_1, $moduleConfigs_1['heading_color']);
            if ( $the_query_1->have_posts() ) :
                $block_str .= $this->render_modules($the_query_1);            //render modules
            endif;
            if($moduleConfigs_1['viewmore'] == 'yes') {
                $block_str .= '<div class="spacer-sm"></div>';
                $vmArray = array(
                    'class' => 'text-center',
                    'button_class' => 'btn btn-default btn-sm',
                    'text'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_text_1', true ),
                    'link'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_link_1', true ),
                    'target' => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_target_1', true ),
                );
                $block_str .= ceris_ajax_function::get_viewmore_button($vmArray);
            }
            $block_str .= '</div><!-- end Column 1 -->';
            
            //Column 2
            $block_str .= '<div class="col-xs-12 col-sm-4">';
            $block_str .= ceris_core::bk_get_block_heading($moduleTitle_2, $headingClass_2, $moduleConfigs_2['heading_color']);
            if ( $the_query_2->have_posts() ) :
                $block_str .= $this->render_modules($the_query_2);            //render modules
            endif;
            if($moduleConfigs_2['viewmore'] == 'yes') {
                $block_str .= '<div class="spacer-sm"></div>';
                $vmArray = array(
                    'class' => 'text-center',
                    'button_class' => 'btn btn-default btn-sm',
                    'text'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_text_2', true ),
                    'link'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_link_2', true ),
                    'target' => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_target_2', true ),
                );
                $block_str .= ceris_ajax_function::get_viewmore_button($vmArray);
            }
            $block_str .= '</div><!-- end Column 2 -->';
            
            //Column 3
            $block_str .= '<div class="col-xs-12 col-sm-4">';   
            $block_str .= ceris_core::bk_get_block_heading($moduleTitle_3, $headingClass_3, $moduleConfigs_3['heading_color']);
            if ( $the_query_3->have_posts() ) :
                $block_str .= $this->render_modules($the_query_3);            //render modules
            endif;
            if($moduleConfigs_3['viewmore'] == 'yes') {
                $block_str .= '<div class="spacer-sm"></div>';
                $vmArray = array(
                    'class' => 'text-center',
                    'button_class' => 'btn btn-default btn-sm',
                    'text'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_text_3', true ),
                    'link'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_link_3', true ),
                    'target' => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_target_3', true ),
                );
                $block_str .= ceris_ajax_function::get_viewmore_button($vmArray);
            }
            $block_str .= '</div><!-- end Column 3 -->';
            
            $block_str .= '</div>';
            $block_str .= '</div> <!-- .container -->';
            $block_str .= '</div><!-- .atbs-ceris-block -->';
            
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_modules ($the_query){
            $render_modules = '';
            $iconPosition = 'top-right';
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
            
            // cat
            $cat_Overlay_Style = 1;
            $cat_Overlay_Class = ceris_core::bk_get_cat_class($cat_Overlay_Style);
            
            $postHorizontalHTML = new ceris_update_horizontal_1;
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-xs',
                'thumbSize'         => 'ceris-xxs-1_1',
                'additionalTextClass'   => '',
                'typescale'         => 'typescale-1 custom-typescale-1',
                'meta'                => array('date'),
            );
            if ( $the_query->have_posts() ) : $the_query->the_post();
                
                $postOverlayHTML = new ceris_update_overlay_4;
                $postOverlayAttr = array (
                    'additionalClass'   => 'post--overlay-bottom post--overlay-floorfade posts-has-smaller-post-cat post--overlay-sm post--overlay-height-300 post--overlay-padding-sm post--overlay-title-small '.$bypasspostAnimationDetech.'',
                    'cat'               => $cat_Overlay_Style,
                    'catClass'          => $cat_Overlay_Class,
                    'thumbSize'         => 'ceris-xs-1_1',
                    'typescale'         => 'typescale-2',
                    'additionalThumbClass'   => 'post__thumb--overlay atbs-thumb-object-fit',
                    'additionalTextClass'  => 'inverse-text',
                    'postIcon'          => $postIconAttr,  
                    'meta'                 => array('author_name', 'date'),
                );
                $postOverlayAttr['postID'] = get_the_ID();
                
                if($bypassPostIconDetech != 1) {
                    $addClass = '';
                    if($postSource != 'all') {
                        $postIconAttr['iconType'] = $postSource;
                    }else {
                        $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                    }
                    $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition, $addClass);
                    $postOverlayAttr['postIcon'] = $postIconAttr;
                }
                $render_modules .= '<div class="big-post--overlay">';
                $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                $render_modules .= '</div>';
            endif;
            if ( $the_query->have_posts() ) :
                while ( $the_query->have_posts() ): $the_query->the_post();
                
                    if ($the_query->current_post == 1) :
                        $render_modules .= '<ul class="list-space-md-s list-space-thumb-text list-unstyled">';
                    endif;
                    $postHorizontalAttr['postID'] = get_the_ID();
                    $render_modules .= '<li>';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</li>';
                    
                    if ($the_query->current_post == ($the_query->post_count - 1)) :
                        $render_modules .= '</ul>';
                    endif;

                endwhile;
            endif;
            return $render_modules;
        }
    }
}