<?php
if (!class_exists('ceris_posts_block_main_col_a')) {
    class ceris_posts_block_main_col_a {

        static $pageInfo=0;

        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_posts_block_main_col_a-');
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
            $moduleConfigs['post_icon_animation'] =  get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon_animation', true );

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

                $block_str .= '<div id="'.$moduleID.'" class="atbs-ceris-block ceris-block-main-col-a atbs-ceris-block-custom-margin atbs-ceris-post--listing-grid-a-update clearfix '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
                $block_str .= ceris_core::bk_render_block_heading_has_sidebar($page_info);
                
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
            $bypassPostIconDetech = 0;
            $bypasspostAnimationDetech = '';
            if($postAnimation == 'disable') {
                $bypasspostAnimationDetech = '';
            }else {
                $bypasspostAnimationDetech = 'icon-has-animation';
            }
            $postIconAttr = array();
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            if($postIcon == 'disable') {
                $bypassPostIconDetech = 1;
            }else {
                $bypassPostIconDetech = 0;
            }
            
            $catStyle = 3;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);

            $postNothumbHTML = new ceris_post_nothumb_3;
            $postNothumbAttr = array (
                'cat'             => $catStyle,
                'catClass'        => $cat_Class.' post__cat-has-line',
                'additionalClass' => 'post-no-thumb-title-line remove-margin-bottom-lastchild',
                'typescale'       => 'typescale-2',
                'except_length'   => 17,
                'thumbSize'       => '',
                'postIcon'        => $postIconAttr,
            );
            
            $catStyle = 4;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            $postVerticalHTML = new ceris_post_vertical_3;
            $postVerticalAttr = array (
                'cat'             => $catStyle,
                'catClass'        => $cat_Class,
                'additionalClass' => 'ceris-post-vertical--cat-overlay post--vertical-large-70 '.$bypasspostAnimationDetech.'',
                'typescale'       => 'typescale-3 custom-typescale-3',
                'thumbSize'       => 'ceris-s-2_1',
                'postIcon'        => $postIconAttr,
                'meta'              => array('author_name', 'date'),
            );
            
            $postVerticalAttr_2 = array (
                'cat'             => $catStyle,
                'catClass'        => $cat_Class,
                'additionalClass' => 'posts-has-smaller-post-cat ceris-post-vertical--cat-overlay '.$bypasspostAnimationDetech,
                'typescale'       => 'typescale-2 custom-typescale-2--xxs',
                'thumbSize'       => 'ceris-xs-4_3',
                'postIcon'        => $postIconAttr,
                'meta'            => array('author_name', 'date'),
            );
            $render_modules = '';
            $currentPost = '';
            $carouselID = uniqid('carousel-');
            while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                $maxPosts = $the_query->post_count;
                if($currentPost == 0):
                    $render_modules .= '<div class="post--grid--2i_row">';
                    $render_modules .= '<div class="post-list flex-row-reverse">';
                    if($maxPosts == 1):
                        $render_modules .= '<div class="list-item item--fullwidth">';
                    else:
                        $render_modules .= '<div class="list-item">';
                    endif;
                    $postVerticalAttr['postID'] = get_the_ID();
                    if($bypassPostIconDetech != 1) {
                        $addClass = '';
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                        }
                        $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition, $addClass);
                        $postVerticalAttr['postIcon'] = $postIconAttr;
                    }

                    $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                    $render_modules .= '</div><!-- .list-item -->';
                elseif($currentPost >= 1):
                    if($currentPost == 1):
                        $render_modules .= '<div class="list-item">';

                        if((($maxPosts - 5)== 0) || (($maxPosts - 2) == 0) || (($maxPosts - 8) == 0)):

                            $render_modules .= '<div class="atbs-ceris-carousel dots-circle">';
                        else:
                            $render_modules .= '<div class="owl-carousel js-atbs-ceris-carousel-1i_not_nav  atbs-ceris-carousel dots-circle">';
                        endif;
                    endif;
                    if(($maxPosts > 1) && ($maxPosts <= 4)):
                        $render_modules .= '<div class="slide-content">';
                        $postNothumbAttr['postID'] = get_the_ID();
                        $render_modules .= $postNothumbHTML->render($postNothumbAttr);
                        $render_modules .= '</div><!-- .slide-content -->';
                        if($currentPost == ($maxPosts - 1 )):
                            $render_modules .= '</div><!-- .owl-carousel js-atbs-ceris-carousel-1i_not_nav  atbs-ceris-carousel dots-circle -->';
                            $render_modules .= '</div><!-- .list-item -->';
                            $render_modules .= '</div><!-- .post-list -->';
                            $render_modules .= '</div><!-- .post--grid--2i_row -->';
                        endif;

                    elseif($maxPosts > 4):
                        if($currentPost <= ($maxPosts - 4 )) :
                            $render_modules .= '<div class="slide-content">';
                            $postNothumbAttr['postID'] = get_the_ID();
                            $render_modules .= $postNothumbHTML->render($postNothumbAttr);
                            $render_modules .= '</div><!-- .slide-content -->';
                            if($currentPost == ($maxPosts - 4 )):
                                $render_modules .= '</div><!-- .owl-carousel js-atbs-ceris-carousel-1i_not_nav  atbs-ceris-carousel dots-circle -->';
                                $render_modules .= '</div><!-- .list-item -->';
                                $render_modules .= '</div><!-- .post-list -->';
                                $render_modules .= '</div><!-- .post--grid--2i_row -->';
                            endif;
                        elseif(($currentPost > ($maxPosts - 4 ) ) && ($currentPost <= ($maxPosts - 1 ) ) ):
                            if($currentPost == ($maxPosts - 3)):
                                $render_modules .= '<div class="post--vertical-3i_row">';
                                $render_modules .= '<div class="post-list">';
                            endif;
                            $render_modules .= '<div class="list-item">';
                            $postVerticalAttr_2['postID'] = get_the_ID();
                            if($bypassPostIconDetech != 1) {
                                $addClass = 'overlay-item--sm-p';
                                if($postSource != 'all') {
                                    $postIconAttr['iconType'] = $postSource;
                                }else {
                                    $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                                }
                                $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'small', $iconPosition, $addClass);
                                $postVerticalAttr_2['postIcon'] = $postIconAttr;
                            }
                            $render_modules .= $postVerticalHTML->render($postVerticalAttr_2);
                            $render_modules .= '</div><!-- .list-item -->';
                            if($currentPost == ($maxPosts - 1)):
                                $render_modules .= '</div><!-- .post-list -->';
                                $render_modules .= '</div><!-- .post--horizontal-3i_row -->';
                            endif;
                        endif;
                    endif;
                endif;
            endwhile;
            if($maxPosts == 1):
                $render_modules .= '</div><!-- .post-list -->';
                $render_modules .= '</div><!-- .post--grid--2i_row -->';
            endif;
            return $render_modules;
        }
    }
}