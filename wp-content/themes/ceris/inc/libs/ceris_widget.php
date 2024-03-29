<?php
if (!class_exists('ceris_widget')) {
    class ceris_widget {
        static function bk_widget_query($widget_opts){
            $widget_opts = shortcode_atts (
    		         array(
    			         'category_ids'   => '',
    			         'category_id'    => '',
    			         'author_id'      => '',
    			         'tags'           => '',
    			         'entries'        => '',
    			         'offset'         => '',
    			         'orderby'        => '',
    			         'post_types'     => '',
    			         'meta_key'       => '',
    			         'post__not_in'    => '',
                         'widget_type'    => '',
    		         ), $widget_opts
    	         );
            //get Query Args
			$query_args  = array(
                'post_status'           => 'publish',
                'ignore_sticky_posts'   => 1,
                'post_type'             => 'post',
                'orderby'               => 'date',
                'posts_per_page'        => $widget_opts['entries'],
            );
            
            $widget_type = $widget_opts['widget_type'];
            if($widget_type == 'review') {
                $query_args['meta_query'] = array(
    				array(
    					'key' => 'bk_review_checkbox',
    					'value' => '1',
    				)
                 );
            }else if($widget_type == 'comment') {
                
            }
            
			if ($widget_opts['post__not_in'] != '') {
				$query_args['post__not_in'] = array_map('intval', explode(',',$widget_opts['post__not_in']));
			}

			//post per page
			if ( $widget_opts['entries'] != '' ) {
                $query_args['posts_per_page'] = $widget_opts['entries'];
			} else {
				$query_args['posts_per_page'] = 4;
			}

			//categories query
			if ( $widget_opts['category_ids'] != '') {
				$query_args['category__in'] = array_map('intval', explode(',',$widget_opts['category_ids']));
			} else {
				if ( ! empty( $widget_opts['category_id'] ) ) {
					$query_args['cat'] = $widget_opts['category_id'];
				}
			}

			//tag in query
			if ( $widget_opts['tags'] != '' ) {
				//$query_args['tag__in'] = $widget_opts['tags'];
                $query_args['tag__in'] = array_map('intval', explode(',',$widget_opts['tags']));
			}

			//offset query
			if ( $widget_opts['offset'] ) {
				$query_args['offset'] = intval( $widget_opts['offset'] );
			}

			switch ( $widget_opts['orderby'] ) {

				//Date post
				case 'date' :
					$query_args['orderby'] = 'date';
					break;

				//Popular comment
				case 'comment_count' :
					$query_args['orderby'] = 'comment_count';
					break;
                
                //Popular Views
				case 'view_count' :
                    $query_args['meta_key'] = 'post_views_count';
					$query_args['orderby']  = 'meta_value_num';
					$query_args['order']    = 'DESC';
					break;

				//Modified
				case 'modified' :
					$query_args['orderby'] = 'modified';
					break;
                    
                // Review
				case 'top_review' :
					$query_args['meta_key'] = 'bk_review_score';
					$query_args['orderby']  = 'meta_value_num';
					$query_args['order']    = 'DESC';
					break;
                //Speed Reads
                case 'speed_reads' :
                    $query_args['meta_key'] = 'bk_post_content__word_count';
					$query_args['orderby']  = 'meta_value_num';
					$query_args['order']    = 'DESC';
                    break;
				//Random
				case 'rand':
					$query_args['orderby'] = 'rand';
					break;

				//Alphabet decs
				case 'alphabetical_decs':
					$query_args['orderby'] = 'title';
					$query_args['order']   = 'DECS';
					break;

				//Alphabet asc
				case 'alphabetical_asc':
					$query_args['orderby'] = 'title';
					$query_args['order']   = 'ASC';
					break;
                
                // Default
                default:
                    $query_args['orderby'] = 'date';
					break;
			}
            $the_query = new WP_Query( $query_args );
            return $the_query;
        }
        static function bk_get_widget_heading($bk_heading, $headingClass = ''){
            $block_heading = '';
            if($bk_heading != null) {
                $heading_allow_html = array(
                    'span' => array(),
                );
                $block_heading .= '<div class="widget__title block-heading '.$headingClass.'">';
    			$block_heading .= '<h4 class="widget__title-text">'.wp_kses($bk_heading, $heading_allow_html).'</h4>';
    			$block_heading .= '</div>';
            }
            return $block_heading;
        }
        static function bk_get_widget_module_class($widgetModule = ''){
            $widgetClass = '';
            switch ( $widgetModule ) {
				case 'indexed-posts-a' :
					$widgetClass = 'atbs-ceris-widget-indexed-posts-a';
					break;
                
                case 'indexed-posts-b':
                    $widgetClass = 'atbs-ceris-widget-indexed-posts-b';
                    break;
                
                case 'indexed-posts-c':
                    $widgetClass = 'atbs-ceris-widget-indexed-posts-c';
                    break;
                
                case 'posts-listing-a':
                    $widgetClass = '';
                    break;
                
                case 'posts-listing-b':
                    $widgetClass = 'atbs-ceris-widget-posts-list';
                    break;
                    
                case 'posts-listing-c':
                    $widgetClass = '';
                    break;
                    
                case 'posts-listing-d':
                    $widgetClass = 'atbs-ceris-widget-posts-list';
                    break;
                
                case 'posts-listing-e':
                    $widgetClass = 'atbs-ceris-widget-posts-list';
                    break;
                    
                default:
                    $widgetClass = 'atbs-ceris-widget-indexed-posts-a';
                    break;
            }
            
            return $widgetClass;
        }
        static function bk_widget_meta($orderby){
            $widgetMeta = array();
            switch($orderby) {
                case 'view_count':
                    $widgetMeta = array('date');
                    break;
                case 'comment_count':
                    $widgetMeta = array('date');
                    break;
                default:
                    $widgetMeta = array('date');
                    break;
            }
            return $widgetMeta;
        }
        
        static function bk_posts_slider_render($the_query, $widgetMeta){
            $render_widget = '';
            $postVerticalHTML = new ceris_vertical_1;                         
            $postVerticalAttr = array (
                'thumbSize'     => 'ceris-xs-16_9 400x225',
                'additionalClass' => 'post__thumb-160',
                'typescale'     => ' typescale-0 custom-typescale-0',
                'additionalThumbClass'   => 'atbs-thumb-object-fit',
            );

            while ( $the_query->have_posts() ): $the_query->the_post();
                $postVerticalAttr['postID'] = get_the_ID();
                $render_widget .= '<div class="slide-content">';
                $render_widget .= $postVerticalHTML->render($postVerticalAttr);
                $render_widget .= '</div>';
            endwhile;
            
            return $render_widget;
        }
        static function bk_listing_posts_a_render($the_query, $widgetMeta){
            $render_widget = '';
            $postHorizontalHTML = new ceris_horizontal_1;
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-xxs',
                'thumbSize'         => 'ceris-xxs-1_1',
                //'meta'              => $widgetMeta,
                'typescale'         => 'typescale-0',
            );
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postHorizontalAttr['postID'] = get_the_ID();
                $render_widget .= '<li>';
                $render_widget .= $postHorizontalHTML->render($postHorizontalAttr);
                $render_widget .= '</li>';
            endwhile;
            
            return $render_widget;
        }
        static function bk_listing_posts_b_render($the_query, $widgetMeta){
            $render_widget = '';
            $postVerticalHTML = new ceris_vertical_1;
                                        
            $postVerticalAttr = array (
                'cat'           => 3,
                'catClass'      => 'post__cat cat-theme post__cat-has-line',
                'thumbSize'     => 'ceris-xs-16_9 400x225',
                'typescale'     => 'typescale-1',
                'meta'          => $widgetMeta,
            );

            while ( $the_query->have_posts() ): $the_query->the_post();
                $postVerticalAttr['postID'] = get_the_ID();
                $render_widget .= '<li>';
                $render_widget .= $postVerticalHTML->render($postVerticalAttr);
                $render_widget .= '</li>';
            endwhile;
            
            return $render_widget;
        }
        static function bk_indexed_posts_c_render($the_query, $widgetMeta){
            $render_widget = '';
            $render_widget .= '<ol class="posts-list list-space-md list-seperated-exclude-first list-unstyled">';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postID = get_the_ID();
                $postIndex = $the_query->current_post + 1;
                if($the_query->current_post == 0) :
                    $thumbAttr = array (
                        'postID'        => $postID,
                        'thumbSize'     => 'ceris-xs-16_9 400x225',                                
                    );
                    $theBGLink = ceris_core::bk_get_post_thumbnail_bg_link($thumbAttr);
                    $theBGLinkInline = "background-image: url('".$theBGLink."')";
                    
                    $postIndexSideAttr = array (
                        'cat'               => 1,
                        'catClass'          => 'post__cat post__cat--bg cat-theme-bg',
                        'postID'            => $postID,
                        'mediaLeft'         => '<span class="list-index">'.$postIndex.'</span>',
                        'typescale'         => 'typescale-2 custom-typescale-2',
                        'meta'              => $widgetMeta,
                    );
                          
                    $render_widget .= '<li>';
                    $render_widget .= '<article class="post post--overlay post--overlay-bottom posts-has-smaller-post-cat">';
                    $render_widget .= '<div class="background-img background-img--darkened" style="'.$theBGLinkInline.'"></div>';
                    $render_widget .= '<div class="post__text inverse-text">';
					$render_widget .= '<div class="post__text-inner">';
                    $render_widget .= self::bk_indexed_side_content($postIndexSideAttr);
                    $render_widget .= '</div>';
                    $render_widget .= '</div>';
                    $render_widget .= '</article>';
                    $render_widget .= '</li>';
                else:
                    $postIndexSideAttr = array (
                        'postID'            => $postID,
                        'mediaLeft'         => '<span class="list-index">'.$postIndex.'</span>',
                        'typescale'         => 'typescale-0',
                        'meta'              => $widgetMeta,
                    );
                    $render_widget .= '<li>';
                    $render_widget .= '<article class="post posts-has-smaller-post-cat">';
                    $render_widget .= self::bk_indexed_side_content($postIndexSideAttr);
                    $render_widget .= '</article>';
                    $render_widget .= '</li>';
                endif;
            endwhile;
            $render_widget .= '</ol>';
            
            return $render_widget;
        }
        static function bk_listing_posts_c_render($the_query, $widgetMeta){
            $render_widget = '';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postID = get_the_ID();
                
                $postOverlayHTML = new ceris_overlay_1;
                $postHorizontalHTML = new ceris_horizontal_1;
                                        
                $postOverlayAttr = array (
                    'thumbSize'         => 'ceris-xs-4_3',
                    'typescale'         => 'typescale-1',
                    'cat'               => 4,
                    'catClass'          => 'post__cat post__cat--bg cat-theme-bg',
                    'meta'              => $widgetMeta,
                    'additionalClass'   => 'post--overlay-bottom post--overlay-floorfade post--overlay-xs',
                    'additionalThumbClass' => 'post__thumb--overlay atbs-thumb-object-fit',
                );
                
                $postHorizontalAttr = array (
                    'additionalClass'   => 'post--horizontal-xxs',
                    'thumbSize'         => 'ceris-xxs-1_1',
                    'meta'              => array('date'),
                    'typescale'         => 'typescale-0',
                );

                if($the_query->current_post == 0) :
                    $postOverlayAttr['postID'] = get_the_ID();
                    $render_widget .= '<li>';
                    $render_widget .= $postOverlayHTML->render($postOverlayAttr);
                    $render_widget .= '</li>';
                else:
                    $postHorizontalAttr['postID'] = get_the_ID();
                    $render_widget .= '<li>';
                    $render_widget .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_widget .= '</li>';
                endif;
            endwhile;
            
            return $render_widget;
        }
        static function bk_listing_posts_d_render($the_query, $widgetMeta){
            $render_widget = '';
            $postHorizontalHTML = new ceris_horizontal_1;
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-reverse post--horizontal-xxs',
                'thumbSize'         => 'ceris-xxs-1_1',
                'meta'              => $widgetMeta,
                'typescale'         => 'typescale-0',
            );
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postHorizontalAttr['postID'] = get_the_ID();
                $render_widget .= '<li>';
                $render_widget .= $postHorizontalHTML->render($postHorizontalAttr);
                $render_widget .= '</li>';
            endwhile;
            
            return $render_widget;
        }
        static function bk_listing_posts_e_render($the_query, $widgetMeta){
            $render_widget = '';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postID = get_the_ID();
                
                $postOverlayHTML = new ceris_overlay_1;
                                        
                $postOverlayAttr = array (
                    'thumbSize'         => 'ceris-xs-16_9 400x225',
                    'typescale'         => 'typescale-1',
                    'cat'               => 4,
                    'meta'              => $widgetMeta,
                    'catClass'          => 'post__cat post__cat--bg cat-theme-bg',
                    'additionalClass'   => 'post--overlay-bottom post--overlay-floorfade posts-has-smaller-post-cat',
                    'additionalIMGClass' => 'background-img--darkened',
                    'additionalThumbClass' => 'post__thumb--overlay atbs-thumb-object-fit',
                );

                $postOverlayAttr['postID'] = get_the_ID();
                $render_widget .= '<li>';
                $render_widget .= $postOverlayHTML->render($postOverlayAttr);
                $render_widget .= '</li>';
                
            endwhile;
            
            return $render_widget;
        }
        static function bk_listing_posts_f_render($the_query, $widgetMeta){
            $render_widget = '';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postID = get_the_ID();
                $currentPost = $the_query->current_post;
                $postOverlayHTML = new ceris_post_overlay_sidebar;                    
                $postOverlayAttr = array (
                    'thumbSize'         => 'ceris-xs-2_1',
                    'typescale'         => 'typescale-0 custom-typescale-0',
                    'cat'               => 3,
                    'catClass'          => 'post__cat post__cat-has-line',
                    'additionalClass'   => 'post--overlay-bottom post--overlay-height-150',
                );

                $postOverlayAttr['postID'] = get_the_ID();
                
                if($currentPost == 0){
                    $render_widget .= '<li class="active">';
                }else{
                    $render_widget .= '<li>';
                }
                $render_widget .= $postOverlayHTML->render($postOverlayAttr);
                $render_widget .= '</li>';
                
            endwhile;
            
            return $render_widget;
        }
        static function bk_listing_posts_g_render($the_query, $widgetMeta){
            $render_widget = '';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postID = get_the_ID();
                $index = $the_query->current_post + 1 ;
                $postOverlayHTML = new ceris_post_nothumb_sidebar;                    
                $postOverlayAttr = array (
                    'typescale'         => 'typescale-0',
                );
                $postOverlayAttr['index'] = $index;

                $postOverlayAttr['postID'] = get_the_ID();
                $render_widget .= '<li>';
                $render_widget .= $postOverlayHTML->render($postOverlayAttr);
                $render_widget .= '</li>';
                
            endwhile;
            
            return $render_widget;
        }
        static function bk_most_commented($the_query){
            $render_widget = '';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postID = get_the_ID();
                $postIndex = $the_query->current_post + 1;
                
                $postIndexSideAttr = array (
                    'postID'            => $postID,
                    'mediaLeft'         => '<a href="'.get_permalink($postID).'" title="'.ceris_core::bk_get_comment_number_and_text($postID).'" class="comments-count-box">'.get_comments_number($postID).'</a>',
                    'typescale'         => 'typescale-0',
                    'meta'              => array('date'),
                );
                $render_widget .= '<li>';
                $render_widget .= '<article class="post posts-has-smaller-post-cat">';
                $render_widget .= self::bk_indexed_side_content($postIndexSideAttr);
                $render_widget .= '</article>';
                $render_widget .= '</li>';
            endwhile;
            
            return $render_widget;
        }
        
        //Review A
        static function bk_review_posts_a($the_query){
            $render_widget = '';
            $postHorizontalHTML = new ceris_horizontal_1;
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal post--horizontal-xxs',
                'thumbSize'         => 'ceris-xxs-1_1',
                'typescale'         => 'typescale-0',
            );
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postHorizontalAttr['postID'] = get_the_ID();
                $reviewScore = get_post_meta($postHorizontalAttr['postID'] ,'bk_review_score',true);
                $postHorizontalAttr['scoreStar'] = $reviewScore;
                
                $render_widget .= '<li>';
                $render_widget .= $postHorizontalHTML->render($postHorizontalAttr);
                $render_widget .= '</li>';
            endwhile;
            
            return $render_widget;
        }
        //Review B
        static function bk_review_posts_b($the_query){
            $render_widget = '';
            $postVerticalHTML = new ceris_vertical_icon_side_right_ratio_2by1;
            $postIconAttr = array (
                'iconType'      => 'review',
                'postIconClass' => 'post-type-icon--sm',
            );
            $postVerticalAttr = array (
                'thumbSize'         => 'ceris-xs-16_9 400x225',
                'typescale'         => 'typescale-0',
                'postIcon'          => $postIconAttr,
            );
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postVerticalAttr['postID'] = get_the_ID();
                $reviewScore = get_post_meta($postVerticalAttr['postID'] ,'bk_review_score',true);
                
                $render_widget .= '<li>';
                $render_widget .= $postVerticalHTML->render($postVerticalAttr);
                $render_widget .= '</li>';
            endwhile;
            
            return $render_widget;
        }
        //Review C
        static function bk_review_posts_c($the_query){
            $render_widget = '';
            $postVerticalHTML = new ceris_vertical_1_ratio_2by1;
            $postIconAttr = array (
                'iconType'      => 'review',
                'postIconClass' => 'post-type-icon--sm overlay-item--center-xy post-type-icon',
            );
            $postVerticalAttr = array (
                'thumbSize'         => 'ceris-xs-16_9 400x225',
                'typescale'         => 'typescale-0',
                'postIcon'          => $postIconAttr,
                'additionalClass'   => 'text-center',        
            );
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postVerticalAttr['postID'] = get_the_ID();
                $reviewScore = get_post_meta($postVerticalAttr['postID'] ,'bk_review_score',true);
                
                $render_widget .= '<li>';
                $render_widget .= $postVerticalHTML->render($postVerticalAttr);
                $render_widget .= '</li>';
            endwhile;
            
            return $render_widget;
        }
        //Review D
        static function bk_review_posts_d($the_query){
            $render_widget = '';
            $postOverlayHTML = new ceris_overlay_icon_side_right;
            $postIconAttr = array (
                'iconType'      => 'review',
                'postIconClass' => 'post-type-icon--sm',
            );
                                        
            $postOverlayAttr = array (
                'thumbSize'         => 'ceris-xs-16_9 400x225',
                'typescale'         => 'typescale-1',
                'postIcon'          => $postIconAttr,
                'additionalClass'   => 'post--overlay-bottom post--overlay-floorfade',
            );
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postOverlayAttr['postID'] = get_the_ID();
                
                $render_widget .= '<li>';
                $render_widget .= $postOverlayHTML->render($postOverlayAttr);
                $render_widget .= '</li>';
            endwhile;
            
            return $render_widget;
        }
        static function bk_indexed_side_content($postIndexSideAttr){
            $renderPostContent = '';
            $renderPostContent .= '<div class="media">';
            
            $renderPostContent .= '<div class="media-left media-middle p-r-sm">';
            $renderPostContent .= $postIndexSideAttr['mediaLeft'];
            $renderPostContent .= '</div>';
            
            $renderPostContent .= '<div class="media-body media-middle">';
            if(isset($postIndexSideAttr['cat']) && ($postIndexSideAttr['cat'] == '1')) :
                $renderPostContent .= ceris_core::bk_get_post_cat_link($postIndexSideAttr['postID'], $postIndexSideAttr['catClass']);
            endif;
            $renderPostContent .= '<h3 class="post__title '.$postIndexSideAttr['typescale'].'">'. ceris_core::bk_get_post_title_link($postIndexSideAttr['postID']) .'</h3>';
            if (isset($postIndexSideAttr['meta']) && ($postIndexSideAttr['meta'] != '')) :
                $renderPostContent .= '<div class="post__meta">';
                $renderPostContent .= ceris_core::bk_get_post_meta($postIndexSideAttr['meta']);
                $renderPostContent .= '</div>';         
            endif;
            
            $renderPostContent .= '</div><!--End media-body-->';
            $renderPostContent .= '</div><!--End media-->';
            
            return $renderPostContent;
        }
        static function bk_update_social_json($socialItems){
            $hours = 2;
            foreach ($socialItems as $socialType => $socialVal) :
                $transient__name = 'ceris_social_json_transient_' . $socialType;
                $cache           = get_transient( $transient__name );
                if ( $cache === false || $cache == '' ) {
                    if($socialType == 'facebook') {
                        $followers = self::bk_read_count_social(esc_url($socialVal['url']), 'facebook');
            			if ( ! empty( $followers ) ) {
            				update_option('bk_facebook_followers', $followers);
        					update_option('bk_facebook_link', esc_url($socialVal['url']));                     
            			}
                        set_transient( $transient__name, $followers, 60 * 60 * $hours );
                    }else if($socialType == 'twitter') {
            			$followers = self::bk_read_count_social($socialVal['url'], 'twitter');
            			if ( ! empty( $followers ) ) {
            				update_option('bk_twitter_followers', $followers);
                            update_option('bk_twitter_link', esc_url($socialVal['url']));            
            			}
                        set_transient( $transient__name, $followers, 60 * 60 * $hours );
            		}else if($socialType == 'youtube') {
                        if($socialVal['api'] != ''):
                            $followers = self::bk_read_count_social($socialVal['url'], 'youtube', $socialVal['api']);
                        else:
                            $followers = 0;
                        endif;
                        if ( ! empty( $followers ) ) {
                            update_option('bk_youtube_followers', $followers);
                            update_option('bk_youtube_link', esc_url('https://www.youtube.com/channel/'.$socialVal['url']));            
            			}
                        set_transient( $transient__name, $followers, 60 * 60 * $hours );
            		}else if($socialType == 'gplus') {
                        $followers = self::bk_read_count_social(esc_url($socialVal['url']), 'gplus');
                        if ( ! empty( $followers ) ) {
                            update_option('bk_gplus_followers', $followers);
                            update_option('bk_gplus_link', esc_url($socialVal['url']));            
            			}
                        set_transient( $transient__name, $followers, 60 * 60 * $hours );
            		}else if($socialType == 'instagram') {
                        $instagramArgs = self::bk_read_count_social($socialVal['accesstoken'], 'instagram');
                        if ( ! empty( $instagramArgs ) ) {
                            update_option('bk_instagram_followers', $instagramArgs['followers']);
                            update_option('bk_instagram_link', 'http://instagram.com/'.esc_attr($instagramArgs['username']));            
                        }
                        set_transient( $transient__name, $instagramArgs['followers'], 60 * 60 * $hours );
            		}else if($socialType == 'dribbble') {
                        $followers = self::bk_read_count_social(esc_url($socialVal['url']), 'dribbble');
                        if ( ! empty( $followers ) ) {
                            update_option('bk_dribbble_followers', $followers);
                            update_option('bk_dribbble_link', esc_url($socialVal['url']));            
            			}
                        set_transient( $transient__name, $followers, 60 * 60 * $hours );
            		}else if($socialType == 'pinterest') {
                        $followers = self::bk_read_count_social(esc_url($socialVal['url']), 'pinterest');
                        if ( ! empty( $followers ) ) {
                            update_option('bk_pinterest_followers', $followers);
                            update_option('bk_pinterest_link', esc_url($socialVal['url']));            
            			}
                        set_transient( $transient__name, $followers, 60 * 60 * $hours );
            		}   
                }
            endforeach;
        }
        
        static function bk_socialItem__counters_render($socialItem){
            $socialHTML = '';
            switch ($socialItem) {
                case 'facebook':
                    $followers = self::number_format_short(get_option('bk_facebook_followers'));
                    $socialHTML .= '<li>';
                    $socialHTML .= '<a href="'.get_option('bk_facebook_link').'" class="social-tile social-facebook facebook-theme-bg">';
                    $socialHTML .= '<div class="social-tile__icon"><i class="mdicon mdicon-facebook"></i></div>';
                    $socialHTML .= '<div class="social-tile__inner flexbox">';
                    $socialHTML .= '<div class="social-tile__left flexbox__item">';
                    $socialHTML .= '<h5 class="social-tile__title meta-font">'.esc_html__('Facebook', 'ceris').'</h5>';
                    $socialHTML .= '<span class="social-tile__count">'.$followers.esc_html__(' likes', 'ceris').'</span>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '<div class="social-tile__right">';
                    $socialHTML .= '<i class="mdicon mdicon-arrow_forward"></i>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</a>';
                    $socialHTML .= '</li>';
                    break;
                case 'twitter':
                    $followers = self::number_format_short(get_option('bk_twitter_followers'));
                    $socialHTML .= '<li>';
                    $socialHTML .= '<a href="'.get_option('bk_twitter_link').'" class="social-tile social-twitter twitter-theme-bg">';
                    $socialHTML .= '<div class="social-tile__icon"><i class="mdicon mdicon-twitter"></i></div>';
                    $socialHTML .= '<div class="social-tile__inner flexbox">';
                    $socialHTML .= '<div class="social-tile__left flexbox__item">';
                    $socialHTML .= '<h5 class="social-tile__title meta-font">'.esc_html__('Twitter', 'ceris').'</h5>';
                    $socialHTML .= '<span class="social-tile__count">'.$followers.esc_html__(' followers', 'ceris').'</span>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '<div class="social-tile__right">';
                    $socialHTML .= '<i class="mdicon mdicon-arrow_forward"></i>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</a>';
                    $socialHTML .= '</li>';
                    break;
                case 'youtube':
                    $followers = self::number_format_short(get_option('bk_youtube_followers'));
                    $socialHTML .= '<li>';
                    $socialHTML .= '<a href="'.get_option('bk_youtube_link').'" class="social-tile social-youtube youtube-theme-bg">';
                    $socialHTML .= '<div class="social-tile__icon"><i class="mdicon mdicon-youtube"></i></div>';
                    $socialHTML .= '<div class="social-tile__inner flexbox">';
                    $socialHTML .= '<div class="social-tile__left flexbox__item">';
                    $socialHTML .= '<h5 class="social-tile__title meta-font">'.esc_html__('Youtube', 'ceris').'</h5>';
                    $socialHTML .= '<span class="social-tile__count">'.$followers.esc_html__(' subscribers', 'ceris').'</span>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '<div class="social-tile__right">';
                    $socialHTML .= '<i class="mdicon mdicon-arrow_forward"></i>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</a>';
                    $socialHTML .= '</li>';
                    break;
                case 'gplus':
                    $followers = self::number_format_short(get_option('bk_gplus_followers'));
                    $socialHTML .= '<li>';
                    $socialHTML .= '<a href="'.get_option('bk_gplus_link').'" class="social-tile social-googleplus googleplus-theme-bg">';
                    $socialHTML .= '<div class="social-tile__icon"><i class="mdicon mdicon-google-plus"></i></div>';
                    $socialHTML .= '<div class="social-tile__inner flexbox">';
                    $socialHTML .= '<div class="social-tile__left flexbox__item">';
                    $socialHTML .= '<h5 class="social-tile__title meta-font">'.esc_html__('Google +', 'ceris').'</h5>';
                    $socialHTML .= '<span class="social-tile__count">'.$followers.esc_html__(' followers ', 'ceris').'</span>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '<div class="social-tile__right">';
                    $socialHTML .= '<i class="mdicon mdicon-arrow_forward"></i>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</a>';
                    $socialHTML .= '</li>';
                    break;
                case 'instagram':
                    $followers = self::number_format_short(get_option('bk_instagram_followers'));
                    $socialHTML .= '<li>';
                    $socialHTML .= '<a href="'.get_option('bk_instagram_link').'" class="social-tile social-instagram instagram-theme-bg">';
                    $socialHTML .= '<div class="social-tile__icon"><i class="mdicon mdicon-instagram"></i></div>';
                    $socialHTML .= '<div class="social-tile__inner flexbox">';
                    $socialHTML .= '<div class="social-tile__left flexbox__item">';
                    $socialHTML .= '<h5 class="social-tile__title meta-font">'.esc_html__('Instagram', 'ceris').'</h5>';
                    $socialHTML .= '<span class="social-tile__count">'.$followers.esc_html__(' followers ', 'ceris').'</span>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '<div class="social-tile__right">';
                    $socialHTML .= '<i class="mdicon mdicon-arrow_forward"></i>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</a>';
                    $socialHTML .= '</li>';
                    break;
                case 'dribbble':
                    $followers = self::number_format_short(get_option('bk_dribbble_followers'));
                    $socialHTML .= '<li>';
                    $socialHTML .= '<a href="'.get_option('bk_dribbble_link').'" class="social-tile social-dribbble dribbble-theme-bg">';
                    $socialHTML .= '<div class="social-tile__icon"><i class="mdicon mdicon-dribbble"></i></div>';
                    $socialHTML .= '<div class="social-tile__inner flexbox">';
                    $socialHTML .= '<div class="social-tile__left flexbox__item">';
                    $socialHTML .= '<h5 class="social-tile__title meta-font">'.esc_html__('Dribbble', 'ceris').'</h5>';
                    $socialHTML .= '<span class="social-tile__count">'.$followers.esc_html__(' followers ', 'ceris').'</span>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '<div class="social-tile__right">';
                    $socialHTML .= '<i class="mdicon mdicon-arrow_forward"></i>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</a>';
                    $socialHTML .= '</li>';
                    break;
                case 'pinterest':
                    $followers = self::number_format_short(get_option('bk_pinterest_followers'));
                    $socialHTML .= '<li>';
                    $socialHTML .= '<a href="'.get_option('bk_pinterest_link').'" class="social-tile social-pinterest pinterest-theme-bg">';
                    $socialHTML .= '<div class="social-tile__icon"><i class="mdicon mdicon-pinterest-p"></i></div>';
                    $socialHTML .= '<div class="social-tile__inner flexbox">';
                    $socialHTML .= '<div class="social-tile__left flexbox__item">';
                    $socialHTML .= '<h5 class="social-tile__title meta-font">'.esc_html__('Pinterest', 'ceris').'</h5>';
                    $socialHTML .= '<span class="social-tile__count">'.$followers.esc_html__(' followers ', 'ceris').'</span>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '<div class="social-tile__right">';
                    $socialHTML .= '<i class="mdicon mdicon-arrow_forward"></i>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</a>';
                    $socialHTML .= '</li>';
                    break;
                default:
                    return '';
            }
            return $socialHTML;
        }
        
        static function bk_fetch_social_count($response, $filter){
            $response = wp_remote_retrieve_body( $response );
            //print_r($response);
    		if ( ! empty( $response ) && $response !== false ) {
    			foreach ( $filter as $key => $value ) {
    
    				$key = explode( '_', $key );
    				$key = $key[0];
    
    				if ( $key == 'start' ) {
    					$key = false;
    				} else if ( $key == 'end' ) {
    					$key = true;
    				}
                    
    				$key = (bool) $key;
    
    				$index = strpos( $response, $value );
    				if ( $index === false ) {
    					return false;
    				}
                    
    				if ( $key ) {
    					$response = substr( $response, 0, $index );
    				} else {
    					$response = substr( $response, $index + strlen( $value ) );
    				}
    			}
                
    			if ( strlen( $response ) > 100 ) {
    				return false;
    			}
    
    			$count = self::bk_extract_one_number( $response );
    
    			if ( ! is_numeric( $count ) || strlen( number_format( $count ) ) > 15 ) {
    				return false;
    			}
    
    			$count = intval( $count );
    
    			return $count;
    		} else {
    			return false;
    		}
        }
        static function bk_read_count_social( $data, $social_type, $apiKey = '' ) {
    		//check options
    		if ( empty( $data ) ) {
    			return false;
    		}
    		$params = array(
    			'timeout'   => 120,
    			'sslverify' => false
    		);
            if($social_type == 'facebook') {
                $filter1   = array(
        			'start_1' => 'PagesLikesCountDOMID',
        			'start_2' => '<span',
					'start_3' => '>',
					'end_4'   => '<span',
        		);
                $filter2   = array(
        			'start_1' => 'PagesLikesCountDOMID',
        			'start_2' => '</span',
					'start_3' => '>',
					'end_4'   => '</span',
        		);
        		$response = wp_remote_get( $data, $params );
                //print_r($response);
                $filter = $filter1;
                $count = self::bk_fetch_social_count($response, $filter);
                if($count == false) {
                    $filter = $filter2;
                }
            }else if($social_type == 'twitter') {
        		$filter   = array(
        			'start_1' => '/followers',
        			'end'     => '</div>'
        		);
                $twitterArray = (explode('/', $data));
                $twitterUsername = $twitterArray[count($twitterArray) - 1];
        		$response = wp_remote_get('https://mobile.twitter.com/'.$twitterUsername);
            }else if($social_type == 'youtube') {
                $filter   = array(
        			'start_1' => 'subscriberCount',
					'end_4'   => '}',
        		);
                
                $channel_id = $data;
                $api_key = $apiKey;
                $response = wp_remote_get('https://www.googleapis.com/youtube/v3/channels?part=statistics&id='.$channel_id.'&fields=items/statistics/subscriberCount&key='.$api_key, $params);
            }else if($social_type == 'gplus') {
                $filter   = array(
        			'start_1' => '"IGqcid"',
        			'start_2' => 'GseqId',
                    'start_3' => '>',
                    'end'     => '<div'
        		);
                
        		$response = wp_remote_get( $data, $params );  
            }else if($social_type == 'instagram') {
                $url = 'https://api.instagram.com/v1/users/self/?access_token='.$data;
                $api = wp_remote_get( $url ) ;
                if (!is_wp_error($api)) {
                    $request = json_decode(wp_remote_retrieve_body ($api), true);
                    $instagramArgs['followers'] = $request['data']['counts']['followed_by'];   
                    $instagramArgs['username']  =  $request['data']['username'];
                }else {
                    $instagramArgs['followers'] = '';
                    $instagramArgs['username']  =  '';
                }
                return $instagramArgs;
            }else if($social_type == 'dribbble') {
                $filter   = array(
        			'start_1' => 'full-tabs-links',
        			'start_2' => 'followers',
                    'start_3' => 'count',
        			'end'     => '</span>'
        		);
        		$response = wp_remote_get( $data, $params );   
            }else if($social_type == 'pinterest') {
                $filter   = array(
        			'start_1' => 'pinterestapp:followers',
        			'start_2' => 'content',
                    'end' => '>',
        		);
        		$response = wp_remote_get( $data, $params );
            }
    		//check & return
    		if ( is_wp_error( $response ) || empty( $response['response']['code'] ) || '200' != $response['response']['code'] ) {
    			return false;
    		}
    		//get content
    		$count = self::bk_fetch_social_count($response, $filter);
            return $count;
    	}
        static function bk_extract_one_number( $str ) {
        	return intval( preg_replace( '/[^0-9]+/', '', $str ), 10 );
        }
        
        static function number_format_short( $n ) {
        	if ($n > 0 && $n < 1000) {
        		// 1 - 999
        		$n_format = floor($n);
        		$suffix = '';
        	} else if ($n >= 1000 && $n < 1000000) {
        		// 1k-999k
        		$n_format = floor($n / 1000).'.'.round(($n % 1000)/100);
        		$suffix = 'K+';
        	} else if ($n >= 1000000 && $n < 1000000000) {
        		// 1m-999m
        		$n_format = floor($n / 1000000).'.'.round(($n % 1000000)/100000);
        		$suffix = 'M+';
        	} else if ($n >= 1000000000 && $n < 1000000000000) {
        		// 1b-999b
        		$n_format = floor($n / 1000000000).'.'.round(($n % 1000000000)/100000000);
        		$suffix = 'B+';
        	} else if ($n >= 1000000000000) {
        		// 1t+
        		$n_format = floor($n / 1000000000000).'.'.round(($n % 1000000000000)/1000000000000);
        		$suffix = 'T+';
        	}else {
        	   $n_format = '';
               $suffix = '';
        	}
            $fn = $n_format . $suffix;
            
        	return !empty($fn) ? $fn : '';
        }
        static function get_category_tiles($category_ids, $catDescription = 'disable'){
            $categoryTiles = '';
            $moduleHTML = new atbs_ceris_category_tile;
    		foreach ($category_ids as $catID ) {
                $categoryAttr = array(
                    'additionalClass' => 'category-tile--sm',
                    'thumbSize'     => 'ceris-xs-2_1',
                    'catID'         => $catID,
                    'description'   => '',
                );
                if($catDescription == 'description') {
                    $categoryAttr['description'] = category_description( $catID ); 
                }else if($catDescription == 'post-count') {
                    $categoryInfo = get_category($catID); 
                    $categoryAttr['description'] = $categoryInfo->category_count . esc_html__(' Articles', 'ceris');
                }else {
                    $categoryAttr['description'] = '';
                }
                $categoryTiles .= '<li>';
                $categoryTiles .= $moduleHTML->render($categoryAttr);
                $categoryTiles .= '</li>';
            }
            return $categoryTiles;
        }
    } // Close ceris_widget class
    
}
