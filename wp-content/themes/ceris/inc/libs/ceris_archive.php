<?php
if (!class_exists('ceris_archive')) {
    class ceris_archive {
        static function the_query__sticky($catID, $posts_per_page){
            $feat_tag = '';                            
            $feat_area_option  = ceris_archive::bk_get_archive_option($catID, 'bk_category_feature_area__post_option');
                
            $args = array(
                'cat' => $catID,
				'post_status' => 'publish',
				'ignore_sticky_posts' => 1,
				'posts_per_page' => $posts_per_page,
            );
                                    
            if($feat_area_option !== 'latest') {
                $args['post__in'] = get_option( 'sticky_posts' );
            }
                        
            $the_query = new WP_Query( $args );
            wp_reset_postdata();
            return $the_query;
        }
    /**
     * ************* Get Option *****************
     *---------------------------------------------------
     */
        static function bk_get_archive_option($termID, $theoption = '') {
            $ceris_option = ceris_core::bk_get_global_var('ceris_option');
            $output = '';
            
            if($theoption != '') :
                $output  = ceris_core::ceris_rwmb_meta( $theoption, array( 'object_type' => 'term' ), $termID );  
                if (isset($output) && (($output == 'global_settings') || ($output == ''))): 
                    $output = $ceris_option[$theoption];
                endif;
            endif;
            
            return $output;
        }
        static function bk_pagination_render($pagination){
            global $wp_query;
            $max_page = $wp_query->max_num_pages;
            $render = '';
            if($max_page <= 1) {
                return '';
            }
            if($pagination == 'default') {
                $render = ceris_core::ceris_get_pagination();
            }else if($pagination == 'ajax-pagination') {
                $render = ceris_ajax_function::ajax_load_buttons('pagination', $max_page);
            }else if(($pagination == 'ajax-loadmore') || ($pagination == 'infinity')) {
                $render = ceris_ajax_function::ajax_load_buttons('loadmore', $max_page);
            }
            return $render;
        }
        static function bk_author_pagination_render($pagination, $userMaxPages){
            $render = '';
            if($pagination == 'ajax-pagination') {
                $render = ceris_ajax_function::ajax_load_buttons('pagination', $userMaxPages);
            }else if($pagination == 'ajax-loadmore') {
                $render .= '<nav class="atbs-ceris-pagination text-center">';
                $render .= '<button class="btn btn-default js-ajax-load-post-trigger">'.esc_html__('Load more authors', 'ceris').'<i class="mdicon mdicon-cached mdicon--last"></i></button>';
    			$render .= '</nav>';
            }
            return $render;
        }
        static function bk_archive_pages_post_icon(){
            global $post;
            $ceris_option = ceris_core::bk_get_global_var('ceris_option');
            $postIcon = '';
            
            if(is_category()) {
                $postIcon = isset($ceris_option['bk_category_post_icon']) ? $ceris_option['bk_category_post_icon'] : 'disable';
            }elseif(is_author()) {
                $postIcon = isset($ceris_option['bk_author_post_icon']) ? $ceris_option['bk_author_post_icon'] : 'disable';
            }elseif(is_search()) {
                $postIcon = isset($ceris_option['bk_search_post_icon']) ? $ceris_option['bk_search_post_icon'] : 'disable';
            }elseif(is_archive()){
                $postIcon = isset($ceris_option['bk_archive_post_icon']) ? $ceris_option['bk_archive_post_icon'] : 'disable';
            }else {
                $pageTemplate =  get_post_meta($post->ID,'_wp_page_template',true);
                if($pageTemplate == 'blog.php') {
                    $postIcon = isset($ceris_option['bk_blog_post_icon']) ? $ceris_option['bk_blog_post_icon'] : 'disable';
                }
            }
            return $postIcon;
        }
        static function bk_archive_pages_post_icon_animation(){
            global $post;
            $ceris_option = ceris_core::bk_get_global_var('ceris_option');
            $postIcon = '';
            
            if(is_category()) {
                $postIcon = isset($ceris_option['bk_category_post_icon_animation']) ? $ceris_option['bk_category_post_icon_animation'] : 'disable';
            }elseif(is_author()) {
                $postIcon = isset($ceris_option['bk_author_post_icon_animation']) ? $ceris_option['bk_author_post_icon_animation'] : 'disable';
            }elseif(is_search()) {
                $postIcon = isset($ceris_option['bk_search_post_icon_animation']) ? $ceris_option['bk_search_post_icon_animation'] : 'disable';
            }elseif(is_archive()){
                $postIcon = isset($ceris_option['bk_archive_post_icon_animation']) ? $ceris_option['bk_archive_post_icon_animation'] : 'disable';
            }else {
                $pageTemplate =  get_post_meta($post->ID,'_wp_page_template',true);
                if($pageTemplate == 'blog.php') {
                    $postIcon = isset($ceris_option['bk_blog_post_icon_animation']) ? $ceris_option['bk_blog_post_icon_animation'] : 'disable';
                }
            }
            return $postIcon;
        }
        static function bk_render_authors($users_found) {
            $render = '';
            if(count($users_found) > 0):
                $render .= '<ul class="authors-list list-unstyled list-space-xxl">';
                foreach($users_found as $user) :
                    $render .= '<li>';
                    $render .= ceris_archive::author_box($user->data->ID);
                    $render .= '</li>';
                endforeach;
                $render .= '</ul> <!-- End Author Results -->';
            endif;            
            return $render;
        }
        static function get_sticky_ids__category_feature_area($catID, $featLayout){
            $featAreaOption  = self::bk_get_archive_option($catID, 'bk_category_feature_area__post_option');
            $excludeIDs = array();
            $posts_per_page = 0;
            $sticky = get_option('sticky_posts') ;
            rsort( $sticky );
            
            $args = array (
                'post_type'     => 'post',
                'cat'           => $catID, // Get current category only
                'order'         => 'DESC',
            );
            
            switch($featLayout){
                case 'grid_o' :
                    $posts_per_page = 5;
                    break;
                case 'grid_p' :
                    $posts_per_page = 4;
                    break;
                case 'grid_q' :
                    $posts_per_page = 3;
                    break;
                case 'grid_r' :
                    $posts_per_page = 3;
                    break;
                default:
                    $posts_per_page = 0;                
                    break;
            }
            if($posts_per_page == 0) :
                wp_reset_postdata();
                return '';
            endif;
            $args['posts_per_page'] = $posts_per_page;
            if($featAreaOption == 'featured') {
                $args['post__in'] = $sticky; // Get stickied posts
            }
            $sticky_query = new WP_Query( $args );
            while ( $sticky_query->have_posts() ): $sticky_query->the_post();
                $excludeIDs[] = get_the_ID();
            endwhile;
            wp_reset_postdata();
            return $excludeIDs;
        }
        static function archive_feature_area($term_id, $featLayout){  
            $featArea = '';
            switch( $featLayout ) {
                default:
                    break;
                case 'grid_o':
                    $featArea .= self::grid_o__render($term_id);
                    break;
                case 'grid_p':
                    $featArea .= self::grid_p__render($term_id);
                    break;
                case 'grid_q':
                    $featArea .= self::grid_q__render($term_id);
                    break;
                 case 'grid_r':
                    $featArea .= self::grid_r__render($term_id);
                    break;
                
            }
            return $featArea;
        }
        static function ceris_archive_header($term_id){
            $archiveHeader = '';
            
            if(is_category()) :
                $headingStyle = ceris_archive::bk_get_archive_option($term_id, 'bk_category_header_style');  
            else :
                $headingStyle = ceris_archive::bk_get_archive_option($term_id, 'bk_archive_header_style');
            endif;
            
            $headingInverse = 'no';
            
            $headingClass = ceris_core::bk_get_block_heading_class($headingStyle, $headingInverse);

            $archiveHeader .= '<div class="container atbs-ceris-block-custom-margin">';
            
            if(is_category()) :
                $archiveHeader .= '<div class="block-heading '.$headingClass.'">';
                $archiveHeader .= '<h2 class="page-heading__title block-heading__title">'.get_cat_name($term_id).'</h2>';
                if ( category_description($term_id) ) :
                    $archiveHeader .= '<div class="page-heading__subtitle">'.category_description($term_id).'</div>';
                endif;
                $archiveHeader .= '</div><!-- block-heading -->';
            elseif(is_tag()) :
                $tag = get_tag($term_id);            
                $archiveHeader .= '<div class="block-heading '.$headingClass.'">';
                $archiveHeader .= '<h2 class="page-heading__title block-heading__title">'.esc_html__('Tag: ', 'ceris'). $tag->name.'</h2>';
                if ( $tag->description ) :
                    $archiveHeader .= '<div class="page-heading__subtitle"><p>'.$tag->description.'</p></div>';
                endif;
                $archiveHeader .= '</div><!-- block-heading -->';
            endif;                        
            
            $archiveHeader .= '</div><!-- container -->';
            return $archiveHeader;
        }
        
        static function render_page_heading($pageID, $headingStyle, $headingColor = '') {
            $headingInverse = 'no';
            $headingClass = ceris_core::bk_get_block_heading_class($headingStyle, $headingInverse);
            
            $styleInline = '';
            if($headingColor != '') :
                $styleInline = 'style="color:'.$headingColor.';"';
            endif;
            
            $page_description  = get_post_meta($pageID,'bk_page_description',true);
            
            $archiveHeader = '';
            
            $archiveHeader .= '<div class="container"><div class="block-heading '.$headingClass.'">';
            $archiveHeader .= '<h1 class="page-heading__title block-heading__title" '.$styleInline.'>'. get_the_title($pageID) .'</h1>';
            if ( $page_description != '' ) :
                $archiveHeader .= '<div class="page-heading__subtitle">'.esc_attr($page_description).'</div>';
            endif;
            
            $archiveHeader .= '</div></div><!-- block-heading -->';
            
            return $archiveHeader;                        
                    
        }      
        static function grid_o__render($term_id){  
            $dataOutput = '';
            $moduleHTML = new ceris_grid_o;
            $postIcon = self::bk_archive_pages_post_icon();
            $postAnimation = self::bk_archive_pages_post_icon_animation();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'post_icon_animation' => $postAnimation,
        
            );
            $posts_per_page = 5;
            $the_query = self::the_query__sticky($term_id, $posts_per_page);
            if ( $the_query->have_posts() ) :
                $dataOutput .= '<div class="atbs-ceris-block atbs-feature-area atbs-ceris-block--fullwidth ceris-grid-o atbs-ceris-mosaic atbs-ceris-mosaic--gutter-10">';
                $dataOutput .= '<div class="container">';
                $dataOutput .= $moduleHTML->render_modules($the_query, $moduleInfo);            //render modules
                $dataOutput .= '</div><!-- .container -->';
                $dataOutput .= '</div>';
            endif;
            return $dataOutput;
        }
        static function grid_p__render($term_id){  
            $dataOutput = '';
            $moduleHTML = new ceris_grid_p;
            $postIcon = self::bk_archive_pages_post_icon();
            $postAnimation = self::bk_archive_pages_post_icon_animation();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'post_icon_animation' => $postAnimation,
        
            );
            $posts_per_page = 4;
            $the_query = self::the_query__sticky($term_id, $posts_per_page);
            if ( $the_query->have_posts() ) :
                $dataOutput .= '<div class="atbs-ceris-block atbs-feature-area atbs-ceris-block--fullwidth ceris-grid-p atbs-ceris-mosaic atbs-ceris-mosaic--gutter-10">';
                $dataOutput .= '<div class="container">';
                $dataOutput .= $moduleHTML->render_modules($the_query, $moduleInfo);            //render modules
                $dataOutput .= '</div><!-- .container -->';
                $dataOutput .= '</div>';
            endif;
            
            return $dataOutput;
        }
        static function grid_q__render($term_id){  
            $dataOutput = '';
            $moduleHTML = new ceris_grid_q;
            $postIcon = self::bk_archive_pages_post_icon();
            $postAnimation = self::bk_archive_pages_post_icon_animation();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'post_icon_animation' => $postAnimation,
        
            );
            $posts_per_page = 3;
            $the_query = self::the_query__sticky($term_id, $posts_per_page);
            if ( $the_query->have_posts() ) :
                $dataOutput .= '<div class="atbs-ceris-block atbs-feature-area atbs-ceris-block--fullwidth ceris-grid-q atbs-ceris-mosaic atbs-ceris-mosaic--gutter-10">';
                $dataOutput .= '<div class="container">';
                $dataOutput .= $moduleHTML->render_modules($the_query, $moduleInfo);            //render modules
                $dataOutput .= '</div><!-- .container -->';
                $dataOutput .= '</div>';
            endif;
            
            return $dataOutput;
        }
        static function grid_r__render($term_id){  
            $dataOutput = '';
            $moduleHTML = new ceris_grid_r;
            $postIcon = self::bk_archive_pages_post_icon();
            $postAnimation = self::bk_archive_pages_post_icon_animation();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'post_icon_animation' => $postAnimation,
        
            );
            $posts_per_page = 3;
            $the_query = self::the_query__sticky($term_id, $posts_per_page);
            if ( $the_query->have_posts() ) :
                $dataOutput .= '<div class="atbs-ceris-block atbs-feature-area atbs-ceris-block--fullwidth ceris-grid-r atbs-ceris-mosaic atbs-ceris-mosaic--gutter-10">';
                $dataOutput .= '<div class="container">';
                $dataOutput .= $moduleHTML->render_modules($the_query, $moduleInfo);            //render modules
                $dataOutput .= '</div><!-- .container -->';
                $dataOutput .= '</div>';
            endif;
            return $dataOutput;
        }
        static function mosaic_a__render($term_id){  
            $dataOutput = '';
            $mosaicHTML = new ceris_mosaic_a;
            $postIcon = self::bk_archive_pages_post_icon();
            $moduleInfo_Array = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'meta_L'          => 2, // Author + Date
                'meta_S'          => 8, // Date
                'cat_L'           => '', 
                'cat_S'           => '',
                'excerpt_L'       => '',
                'textAlign'     => '',
                'footerStyle'   => '1-col',
            );
            
            $posts_per_page = 5;
            $the_query = self::the_query__sticky($term_id, $posts_per_page);
            
            $dataOutput .= self::ceris_archive_header($term_id);
            
            $dataOutput .= '<div class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-mosaic atbs-ceris-mosaic--gutter-10">';
            $dataOutput .= '<div class="container">';
            $dataOutput .= $mosaicHTML->render_modules($the_query, $moduleInfo_Array);            //render modules
            $dataOutput .= '</div><!-- .container -->';
            $dataOutput .= '</div>';
            
            return $dataOutput;
        }
        static function mosaic_a_bg__render($term_id){  
            $dataOutput = '';
            $postIcon = self::bk_archive_pages_post_icon();
            $mosaicHTML = new ceris_mosaic_a_bg;
            $moduleInfo_Array = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'meta_L'          => 2, // Author + Date
                'meta_S'          => 8, // Date
                'cat_L'           => '', 
                'cat_S'           => '',
                'excerpt_L'       => '',
                'textAlign'     => '',
                'footerStyle'   => '1-col',
            );
            
            $posts_per_page = 5;
            $the_query = self::the_query__sticky($term_id, $posts_per_page);
                     
            $dataOutput .= '<div class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block--contiguous atbs-ceris-mosaic atbs-ceris-mosaic--has-shadow mnmd-mosaic--gutter-10 has-overlap-background">';
            
            $dataOutput .= '<div class="overlap-background background-svg-pattern background-svg-pattern--solid-color">';
    		$dataOutput .= '<div class="background-overlay cat-theme-bg cat-'.$term_id.'"></div>';
    		$dataOutput .= '</div>';
            
            $dataOutput .= '<div class="container container--wide">';
            
            $dataOutput .= '<div class="page-heading page-heading--center page-heading--inverse">';
			$dataOutput .= '<h2 class="page-heading__title">'.get_cat_name($term_id).'</h2>';
            if ( category_description() ) :
			 $dataOutput .= '<div class="page-heading__subtitle">'.category_description().'</div>';
            endif;
			$dataOutput .= '</div>';
            
            $dataOutput .= '<div class="row row--space-between">';
            $dataOutput .= $mosaicHTML->render_modules($the_query, $moduleInfo_Array);            //render modules
            $dataOutput .= '</div>';
            $dataOutput .= '</div><!-- .container -->';
            $dataOutput .= '</div>';
            
            return $dataOutput;
        }
       // ltp //
        static function archive_fullwidth($archiveLayout, $moduleID = '', $pagination = '', $bookmark = ''){ 

            $dataOutput = '';
			
            switch($archiveLayout) {
                case 'listing_list_no_sidebar':
                    $dataOutput .= self::listing_list_no_sidebar__render($moduleID, $bookmark);
                    break;
                case 'listing_list_b_no_sidebar':
                    $dataOutput .= self::listing_list_b_no_sidebar__render($moduleID, $bookmark);
                    break;
                case 'listing_list_large_a_no_sidebar':
                    $dataOutput .= self::listing_list_large_a_no_sidebar__render($moduleID, $bookmark);
                    break;
                case 'listing_list_large_b_no_sidebar':
                    $dataOutput .= self::listing_list_large_b_no_sidebar__render($moduleID, $bookmark);
                    break;
                case 'listing_grid_no_sidebar':
                    $dataOutput .= self::listing_grid_no_sidebar__render($moduleID, $bookmark);
                    break;
                case 'listing_grid_b_no_sidebar':
                    $dataOutput .= self::listing_grid_b_no_sidebar__render($moduleID, $bookmark);
                    break;
                case 'listing_grid_small_no_sidebar':
                    $dataOutput .= self::listing_grid_small_no_sidebar__render($moduleID, $pagination, $bookmark);
                    break;
                case 'listing_list_alt_a_no_sidebar':
                    $dataOutput .= self::listing_list_alt_a_no_sidebar__render($moduleID, $bookmark);
                    break;
                case 'listing_list_alt_b_no_sidebar':
                    $dataOutput .= self::listing_list_alt_b_no_sidebar__render($moduleID, $bookmark);
                    break;
                case 'listing_list_alt_c_no_sidebar':
                    $dataOutput .= self::listing_list_alt_c_no_sidebar__render($moduleID, $bookmark);
                    break;
                default: 
                    $dataOutput .= self::listing_grid_no_sidebar__render($moduleID, $bookmark);
                    break;                                                        
            } 
            return $dataOutput;
        }
        static function archive_main_col($archiveLayout, $moduleID = '', $pagination = '', $bookmark = ''){ 

            $dataOutput = '';
			
            switch($archiveLayout) {
                case 'listing_list':
                    $dataOutput .= self::listing_list__render($moduleID, $bookmark);
                    break;
                case 'listing_list_b':
                    $dataOutput .= self::listing_list_b__render($moduleID, $bookmark);
                    break;
                case 'listing_list_large_a':
                    $dataOutput .= self::listing_list_large_a__render($moduleID, $bookmark);
                    break;
                case 'listing_list_large_b':
                    $dataOutput .= self::listing_list_large_b__render($moduleID, $bookmark);
                    break;
                case 'listing_list_alt_b':
                    $dataOutput .= self::listing_list_alt_b__render($moduleID, $bookmark);
                    break;
                case 'listing_grid':
                    $dataOutput .= self::listing_grid__render($moduleID, $pagination, $bookmark);
                    break;
                case 'listing_grid_b':
                    $dataOutput .= self::listing_grid_b__render($moduleID, $pagination, $bookmark);
                    break;
                case 'listing_grid_alt_b':
                    $dataOutput .= self::listing_grid_alt_b__render($moduleID, $pagination, $bookmark);
                    break;
                case 'listing_grid_small':
                    $dataOutput .= self::listing_grid_small__render($moduleID, $pagination, $bookmark);
                    break;
                case 'listing_list_alt_a':
                    $dataOutput .= self::listing_list_alt_a__render($moduleID, $bookmark);
                    break;
                case 'listing_list_alt_c':
                    $dataOutput .= self::listing_list_alt_c__render($moduleID, $bookmark);
                    break;
                case 'listing_grid_alt_a':
                    $dataOutput .= self::listing_grid_alt_a__render($moduleID, $pagination, $bookmark);
                    break;
                default:
                    $dataOutput .= self::listing_list__render($moduleID, $bookmark);
                    break;                                    
            } 
            return $dataOutput;
        }
/** Full Width Modules ( No sidebar)**/
        static function listing_grid_no_sidebar__render($moduleID, $bookmark) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postAnimation = self::bk_archive_pages_post_icon_animation();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';

            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'post_icon_animation' => $postAnimation,
                'bookmark'      => $bookmark,
            );
            
            if($moduleInfo['bookmark'] == 'on') {
                $bookmarkClass = 'post-has-bookmark bookmark__notice_align_right';
            }else {
                $bookmarkClass = '';
            }
                        
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);    
                    
            $catStyle = 4; //Top - Left
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            
            $postVerticalHTML = new ceris_post_vertical_3;         
            $postVerticalAttr = array (
                'cat'                 => $catStyle,
                'catClass'            => $cat_Class,
                'additionalClass'     => 'ceris-post-vertical--cat-overlay post--vertical-text-not-fullwidth '.$bookmarkClass,
                'additionalTextClass' => '',
                'thumbSize'           => 'ceris-xs-4_3',
                'typescale'           => 'typescale-2',
                'postIcon'            => $postIconAttr,
                'bookmark'          => $moduleInfo['bookmark'], 
                'except_length'     => 15,
                'meta'              => array('author_name', 'date'),
            );
            
			$render_modules .= '<div class="atbs-ceris-posts--vertical-text-not-fullwidth">';
            
            $render_modules .= '<div class="posts-list post-list row row--space-between grid-gutter-40 items-clear-both-3">';
            
            while (have_posts()): the_post();  
                $currentPost = $wp_query->current_post;
                $postVerticalAttr['postID'] = get_the_ID();
                
                if($postIcon != 'disable') {
                    $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition']);
                    $postVerticalAttr['postIcon'] = $postIconAttr;
                }
                if($postAnimation !== 'disable'):
                    $postVerticalAttr['additionalClass'] .= ' icon-has-animation';
                endif;
                $render_modules .= '<div class="col-md-4 col-sm-6 list-item">';
                $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                $render_modules .= '</div>';
            endwhile;
            $render_modules .= '</div><!-- .posts-list -->';
            $render_modules .= '</div><!-- .atbs-ceris-posts--vertical-text-not-fullwidth -->';
            
            return $render_modules;
        }
        static function listing_grid_b_no_sidebar__render($moduleID, $bookmark = '') {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postAnimation = self::bk_archive_pages_post_icon_animation();

            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';

            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'post_icon_animation' => $postAnimation,
                'bookmark'      => $bookmark,
            );
            
            if($moduleInfo['bookmark'] == 'on') {
                $bookmarkClass = 'post-has-bookmark bookmark__notice_align_right';
            }else {
                $bookmarkClass = '';
            }
            
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);    
                    
            $catStyle = 4; //Top - Left
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            
            $postOverlayHTML = new ceris_post_overlay_2;         
            $postOverlayAttr = array (
                'cat'                  => $catStyle,
                'catClass'             => $cat_Class.' overlay-item--top-left',
                'additionalClass'      => 'post--overlay-bottom post--overlay-floorfade posts-has-smaller-post-cat post--overlay-md post--overlay-padding-lg post--overlay-top-bottom '.$bookmarkClass,
                'additionalTextClass'  => 'inverse-text',
                'additionalThumbClass' => 'post__thumb--overlay atbs-thumb-object-fit',
                'thumbSize'            => 'ceris-s-1_1',
                'typescale'            => 'typescale-2',
                'postIcon'             => $postIconAttr,
                'bookmark'             => $moduleInfo['bookmark'], 
                'meta'                 => array('author', 'date'),
            );
            
			$render_modules .= '<div class="atbs-ceris-posts-latest--overlay">';
            
            $render_modules .= '<div class="posts-list post-list row row--space-between grid-gutter-40 items-clear-both-3">';
            
            while (have_posts()): the_post();  
                $currentPost = $wp_query->current_post;
                $postOverlayAttr['postID'] = get_the_ID();
                
                if($postIcon != 'disable') {
                    $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition']);
                    $postOverlayAttr['postIcon'] = $postIconAttr;
                }
                if($postAnimation !== 'disable'):
                    $postOverlayAttr['additionalClass'] .= ' icon-has-animation';
                endif;
                $render_modules .= '<div class="col-md-4 col-sm-6 list-item">';
                $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                $render_modules .= '</div>';
            endwhile;
            $render_modules .= '</div><!-- .posts-list -->';
            $render_modules .= '</div><!-- .atbs-ceris-posts-latest--overlay -->';
            
            return $render_modules;
        }
        static function listing_grid_small_no_sidebar__render($moduleID, $pagination) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postVerticalHTML = new ceris_vertical_1;
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'meta'          => 2,
                'cat'           => 1,
                'excerpt'       => 1,
            );
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);    
            
            $catStyle = 3;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            
            $postHorizontalHTML = new ceris_post_horizontal_1;         
            $postHorizontalAttr = array (
                'cat'                 => $catStyle,
                'catClass'            => $cat_Class,
                'additionalClass'     => 'post--horizontal-reverse post--horizontal-middle post--horizontal-120 remove-margin-bottom-lastchild post--horizontal-cat-no-line',
                'additionalThumbClass' => '',
                'thumbSize'           => 'ceris-s-1_1',
                'typescale'           => 'typescale-1',
                'postIcon'            => $postIconAttr,
            );
            
			$render_modules .= '<div class="posts-listing-grid-small atbs-ceris-post--listing-list-a-update">';
            $render_modules .= '<div class="post-list posts-list">';
            while (have_posts()): the_post();  
                $currentPost = $wp_query->current_post;     
                $postHorizontalAttr['postID'] = get_the_ID();
                $render_modules .= '<div class="list-item">';
                $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                $render_modules .= '</div>';
            endwhile;
            $render_modules .= '</div><!-- .posts-list -->';
            $render_modules .= '</div><!-- .posts-listing -->';
            
            return $render_modules;
        }
        
        static function listing_list_no_sidebar__render($moduleID, $bookmark = '') {
            $render_modules = '';
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postAnimation = self::bk_archive_pages_post_icon_animation();

            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';

            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'post_icon_animation' => $postAnimation,
                'bookmark'      => $bookmark,
            );
            
            if($moduleInfo['bookmark'] == 'on') {
                $bookmarkClass = 'post-has-bookmark';
            }else {
                $bookmarkClass = '';
            }
            
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);       
                     
            $catStyle = 4; //Above the Title - No BG
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            $postHorizontalHTML = new ceris_post_horizontal_1;                     
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-middle post--horizontal-reverse remove-margin-bottom-lastchild post__thumb--width-450 post--horizontal-normal '.$bookmarkClass,
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'ceris-xs-4_3',
                'typescale'         => 'typescale-3 custom-typescale-3',
                'except_length'     => 15,
                'postIcon'          => $postIconAttr,  
                'meta'              => array('author_name', 'date'),
                'bookmark'             => $moduleInfo['bookmark'],
            );
            
            $render_modules .= '<div class="atbs-ceris-posts-latest-has--smallpost">';
            $render_modules .= '<div class="posts-list">';
            
            while (have_posts()): the_post();                 
                $postHorizontalAttr['postID'] = get_the_ID();
                
                if($postIcon != 'disable') {
                    $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition']);
                    $postHorizontalAttr['postIcon'] = $postIconAttr;
                }
                if($postAnimation !== 'disable'):
                    $postHorizontalAttr['additionalClass'] .= ' icon-has-animation';
                endif;
                $render_modules .= '<div class="list-item">';
                $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                $render_modules .= '</div><!-- .atbs-ceris-posts-latest-has--smallpost -->';
            endwhile;
            
            $render_modules .= '</div>';
            $render_modules .= '</div>';
            return $render_modules;
        }
        static function listing_list_b_no_sidebar__render($moduleID, $bookmark = '') {
            $render_modules = '';
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postAnimation = self::bk_archive_pages_post_icon_animation();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';

            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'post_icon_animation' => $postAnimation,
                'bookmark'      => $bookmark,
            );
            
            if($moduleInfo['bookmark'] == 'on') {
                $bookmarkClass = 'post-has-bookmark';
            }else {
                $bookmarkClass = '';
            }
            
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);       
                     
            $catStyle = 4; //Above the Title - No BG
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            $postHorizontalHTML = new ceris_post_horizontal_1;                     
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-middle remove-margin-bottom-lastchild post__thumb--width-450 post--horizontal-no-excerpt '.$bookmarkClass,
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'ceris-xs-4_3',
                'typescale'         => 'typescale-3 custom-typescale-3',
                'except_length'     => 15,
                'postIcon'          => $postIconAttr,  
                'meta'              => array('author_name', 'date'),
                'bookmark'             => $moduleInfo['bookmark'],
            );
            
            $render_modules .= '<div class="atbs-ceris-posts-latest-has--smallpost-2">';
            $render_modules .= '<div class="posts-list">';
            
            while (have_posts()): the_post();                 
                $postHorizontalAttr['postID'] = get_the_ID();
                
                if($postIcon != 'disable') {
                    $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition']);
                    $postHorizontalAttr['postIcon'] = $postIconAttr;
                }
                if($postAnimation !== 'disable'):
                    $postHorizontalAttr['additionalClass'] .= ' icon-has-animation';
                endif;
                $render_modules .= '<div class="list-item">';
                $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                $render_modules .= '</div><!-- .atbs-ceris-posts-latest-has--smallpost -->';
            endwhile;
            
            $render_modules .= '</div>';
            $render_modules .= '</div>';
            return $render_modules;
        }
        static function listing_list_large_a_no_sidebar__render($moduleID, $bookmark = '') {
            $render_modules = '';
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postAnimation = self::bk_archive_pages_post_icon_animation();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';

            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'post_icon_animation' => $postAnimation,
                'bookmark'      => $bookmark,
            );
            
            if($moduleInfo['bookmark'] == 'on') {
                $bookmarkClass = 'post-has-bookmark bookmark__notice_align_right';
            }else {
                $bookmarkClass = '';
            }
                        
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);       
                     
            $catStyle = 4; //Above the Title - No BG
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            
            $postOverlayHTML = new ceris_post_overlay_9;                    
            $postOverlayAttr = array (
                'additionalClass'   => 'text-center post--overlay-text-center--bg post--overlay-bottom post--overlay-md post--overlay-text-has-shadow '.$bookmarkClass,
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'additionalThumbClass' => 'post__thumb--overlay atbs-thumb-object-fit',
                'thumbSize'         => 'ceris-l-16_9',
                'typescale'         => 'typescale-2',
                'meta'                 => array('author_name', 'date'),
                'postIcon'             => $postIconAttr,  
                'bookmark'             => $moduleInfo['bookmark'],
            );
            
            if($moduleInfo['bookmark'] == 'on') {
                $postOverlayAttr['meta'] = array('author_name');
            }else {
                $postOverlayAttr['meta'] = array('author_name', 'date');
            }

            $render_modules .= '<div class="atbs-ceris-posts-latest--text-right">';
            $render_modules .= '<div class="posts-list">';
            
            while (have_posts()): the_post();                 
                $postOverlayAttr['postID'] = get_the_ID();
                
                if($postIcon != 'disable') {
                    $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition']);
                    $postOverlayAttr['postIcon'] = $postIconAttr;
                }
                if($postAnimation !== 'disable'):
                    $postOverlayAttr['additionalClass'] .= ' icon-has-animation';
                endif;
                $render_modules .= '<div class="list-item">';
                $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                $render_modules .= '</div><!-- .atbs-ceris-posts-latest--text-right -->';
            endwhile;
            
            $render_modules .= '</div>';
            $render_modules .= '</div>';
            return $render_modules;
        }
        static function listing_list_large_b_no_sidebar__render($moduleID, $bookmark = '') {
            $render_modules = '';
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postAnimation = self::bk_archive_pages_post_icon_animation();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';

            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'post_icon_animation' => $postAnimation,
                'bookmark'      => $bookmark,
            );
            
            if($moduleInfo['bookmark'] == 'on') {
                $bookmarkClass = 'post-has-bookmark bookmark__notice_align_right';
            }else {
                $bookmarkClass = '';
            }
                        
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);       
                     
            $catStyle = 4; //Above the Title - No BG
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            
            $postOverlayHTML = new ceris_post_overlay_9;                  
            $postOverlayAttr = array (
                'additionalClass'   => 'text-center post--overlay-text-bottom-center--bg post--overlay-bottom post--overlay-md post--overlay-text-has-shadow '.$bookmarkClass,
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'additionalThumbClass' => 'post__thumb--overlay atbs-thumb-object-fit',
                'thumbSize'         => 'ceris-l-16_9',
                'typescale'         => 'typescale-2',
                'meta'              => array('author_name', 'date'),
                'postIcon'             => $postIconAttr,  
                'bookmark'             => $moduleInfo['bookmark'],
            );
            
            if($moduleInfo['bookmark'] == 'on') {
                $postOverlayAttr['meta'] = array('author_name');
            }else {
                $postOverlayAttr['meta'] = array('author_name', 'date');
            }
            
            $render_modules .= '<div class="atbs-ceris-posts-latest--text-left">';
            $render_modules .= '<div class="posts-list">';
            
            while (have_posts()): the_post();                 
                $postOverlayAttr['postID'] = get_the_ID();
                
                if($postIcon != 'disable') {
                    $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition']);
                    $postOverlayAttr['postIcon'] = $postIconAttr;
                }
                if($postAnimation !== 'disable'):
                    $postOverlayAttr['additionalClass'] .= ' icon-has-animation';
                endif;
                $render_modules .= '<div class="list-item">';
                $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                $render_modules .= '</div><!-- .atbs-ceris-posts-latest--text-left -->';
            endwhile;
            
            $render_modules .= '</div>';
            $render_modules .= '</div>';
            return $render_modules;
        }
        
        static function listing_list_alt_a_no_sidebar__render($moduleID) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postHorizontalHTML = new ceris_horizontal_1;
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'meta'          => 3,
                'cat'           => 3,
                'excerpt'       => 1,
            );
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);       
                        
            $cat = 3; //Above the Title - No BG
            $cat_Class = ceris_core::bk_get_cat_class($cat);
            
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-sm',
                'cat'               => $cat,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'ceris-xs-4_3',
                'typescale'         => 'typescale-3',
                'except_length'     => 23,
                'meta'              => array('author', 'date', 'comment'),
                'postIcon'          => $postIconAttr,  
            );
            
			$render_modules .= '<div class="posts-list list-space-md list-seperated">';
            
            while (have_posts()): the_post();                 
                $currentPost = $wp_query->current_post;
                $postHorizontalAttr['postID'] = get_the_ID();
                
                if($postIcon != 'disable') {
                    $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition']);
                    $postHorizontalAttr['postIcon'] = $postIconAttr;
                }
                
                if($currentPost % 5) : //Normal Posts 
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</div>';
                else: //Large Posts
                    $postHorizontalAttr_L = $postHorizontalAttr;
                    $postHorizontalAttr_L['additionalClass'] = '';
                    $postHorizontalAttr_L['postIcon']['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $moduleInfo['iconPosition']);
                    
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr_L);
                    $render_modules .= '</div>';
                endif;
            endwhile;
            
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        static function listing_list_alt_b_no_sidebar__render($moduleID) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postHorizontalHTML = new ceris_horizontal_1;
            $postOverlayHTML = new ceris_overlay_1;
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition_l'  => 'top-right',
                'iconPosition_s'  => 'top-right',
                'meta_l'          => 3,
                'cat_l'           => 1,
                'excerpt_l'       => 1,
                'meta_s'          => 3,
                'cat_s'           => 3,
                'excerpt_s'       => 1,
                'footer_style'    => '1-col',
            );
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
                        
            $cat_L = 1; //Above the Title - No BG
            $cat_L_Class = ceris_core::bk_get_cat_class($cat_L);
            
            $cat_S = 3; //Above the Title - No BG
            $cat_S_Class = ceris_core::bk_get_cat_class($cat_S);
            
            $postOverlayAttr = array (
                'additionalClass'   => 'post--overlay-floorfade post--overlay-bottom post--overlay-sm post--overlay-padding-lg',
                'cat'               => $cat_L,
                'catClass'          => $cat_L_Class,
                'thumbSize'         => 'ceris-m-16_9',
                'additionalThumbClass' => 'post__thumb--overlay atbs-thumb-object-fit',
                'typescale'         => 'typescale-4',
                'footerType'            => '1-col',
                'additionalMetaClass'   => '',
                'except_length'     => 23,
                'meta'              => array('author', 'date', 'comment'),
                'postIcon'          => $postIconAttr,  
            );
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-sm',
                'cat'               => $cat_S,
                'catClass'          => $cat_S_Class,
                'thumbSize'         => 'ceris-xs-4_3',
                'typescale'         => 'typescale-3',
                'except_length'     => 23,
                'meta'              => array('author', 'date', 'comment'),
                'postIcon'          => $postIconAttr,  
            );
			$render_modules .= '<div class="posts-list list-unstyled list-space-xl">';
            
            while (have_posts()): the_post();                 
                $currentPost = $wp_query->current_post;                
                
                if($currentPost % 5) : //Small Posts
                    $postHorizontalAttr['postID'] = get_the_ID();
                    
                    if($postIcon != 'disable') {
                        $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                        $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition_s']);
                        $postHorizontalAttr['postIcon'] = $postIconAttr;
                    }
                    
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</div>';
                else: //Large Posts
                    $postOverlayAttr['postID'] = get_the_ID();
                    
                    if($postIcon != 'disable') {
                        $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                        if($postIconAttr['iconType'] == 'gallery') {
                            $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                        }else {
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $moduleInfo['iconPosition_l']);
                        }
                        
                        $postOverlayAttr['postIcon']    = $postIconAttr;
                    }
                    
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                    $render_modules .= '</div>';
                endif;
                
            endwhile;
            
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        static function listing_list_alt_c_no_sidebar__render($moduleID) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postHorizontalHTML = new ceris_horizontal_1;
            $postVerticalHTML = new ceris_vertical_1;
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition_l'  => 'top-right',
                'iconPosition_s'  => 'top-right',
                'meta_l'          => 3,
                'cat_l'           => 1,
                'excerpt_l'       => 1,
                'meta_s'          => 3,
                'cat_s'           => 3,
                'excerpt_s'       => 1,
                'footer_style'    => '1-col',
            );
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
            $cat_L = 1; //Above the Title - No BG
            $cat_L_Class = ceris_core::bk_get_cat_class($cat_L);
            
            $cat_S = 3; //Above the Title - No BG
            $cat_S_Class = ceris_core::bk_get_cat_class($cat_S);

            $postVerticalAttr = array (
                'cat'               => $cat_L,
                'catClass'          => $cat_L_Class,
                'thumbSize'         => 'ceris-m-2_1',
                'typescale'         => 'typescale-4',
                'additionalExcerptClass' => 'post__excerpt--xxl ',
                'except_length'     => 23,
                'meta'              => array('author', 'date', 'comment'),
                'postIcon'          => $postIconAttr,
            );
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-sm',
                'cat'               => $cat_S,
                'catClass'          => $cat_S_Class,
                'thumbSize'         => 'ceris-xs-4_3',
                'typescale'         => 'typescale-3',
                'except_length'     => 23,
                'meta'              => array('author', 'date', 'comment'),
                'postIcon'          => $postIconAttr,     
            );
			$render_modules .= '<div class="posts-list list-unstyled list-space-xl">';
            
            while (have_posts()): the_post();                 
                $currentPost = $wp_query->current_post;                
                
                if($currentPost % 5) : //Small Posts
                    $postHorizontalAttr['postID'] = get_the_ID();
                    
                    if($postIcon != 'disable') {
                        $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                        $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition_s']);
                        $postHorizontalAttr['postIcon'] = $postIconAttr;
                    }
                    
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</div>';
                else: //Large Posts
                    $postVerticalAttr['postID'] = get_the_ID();
                    
                    if($postIcon != 'disable') {
                        $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                        $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $moduleInfo['iconPosition_l']);
                        $postVerticalAttr['postIcon']    = $postIconAttr;
                    }
                    
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                    $render_modules .= '</div>';
                endif;
                
            endwhile;
            
            $render_modules .= '</div>';
            
            return $render_modules;
        }
/** Main Col Modules **/
        static function listing_list__render($moduleID, $bookmark = '') {
            $render_modules = '';
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postAnimation = self::bk_archive_pages_post_icon_animation();
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'post_icon_animation' => $postAnimation,
                'bookmark'      => $bookmark,
            );
            
            if($moduleInfo['bookmark'] == 'on') {
                $bookmarkClass = 'post-has-bookmark';
            }else {
                $bookmarkClass = '';
            }
            
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
                        
            $catStyle = 4; //Above the Title - No BG
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            
            $postHorizontalHTML = new ceris_post_horizontal_1;                
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-middle post--horizontal-reverse remove-margin-bottom-lastchild post__thumb--width-400 post--horizontal-normal '.$bookmarkClass,
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'ceris-xs-4_3',
                'typescale'         => 'typescale-2',
                'except_length'     => 15,
                'postIcon'          => $postIconAttr,  
                'meta'              => array('author_name', 'date'),
                'bookmark'             => $moduleInfo['bookmark'],
            );
            
			$render_modules .= '<div class="atbs-ceris-posts-latest-has--smallpost">';
            $render_modules .= '<div class="posts-list">';
            while (have_posts()): the_post();                 
                $postHorizontalAttr['postID'] = get_the_ID();
                if($postIcon !== 'disable') {
                    $addClass = '';
                    $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition'], $addClass);
                    $postHorizontalAttr['postIcon'] = $postIconAttr;
                }
                if($postAnimation !== 'disable'):
                    $postHorizontalAttr['additionalClass'] .= ' icon-has-animation';
                endif;
                $render_modules .= '<div class="list-item">';
                $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                $render_modules .= '</div>';
                
            endwhile;
            
            $render_modules .= '</div>';
            $render_modules .= '</div><!-- .atbs-ceris-posts-latest-has--smallpost -->';
            
            return $render_modules;
        }
        static function listing_list_b__render($moduleID, $bookmark = '') {
            $render_modules = '';
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postAnimation = self::bk_archive_pages_post_icon_animation();
                        
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'post_icon_animation' => $postAnimation,
                'bookmark'      => $bookmark,
            );
            if($moduleInfo['bookmark'] == 'on') {
                $bookmarkClass = 'post-has-bookmark';
            }else {
                $bookmarkClass = '';
            }
            
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
                        
            $catStyle = 4; //Above the Title - No BG
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            
            $postHorizontalHTML = new ceris_post_horizontal_1;                     
            $postHorizontalAttr = array (
                    'additionalClass'   => 'post--horizontal-middle remove-margin-bottom-lastchild post__thumb--width-400 post--horizontal-no-excerpt '.$bookmarkClass,
                    'cat'               => $catStyle,
                    'catClass'          => $cat_Class,
                    'thumbSize'         => 'ceris-xs-4_3',
                    'typescale'         => 'typescale-2',
                    'postIcon'          => $postIconAttr,
                    'except_length'    => 15,  
                    'postIcon'          => $postIconAttr,  
                    'meta'              => array('author_name', 'date'),
                    'bookmark'             => $moduleInfo['bookmark'],
                );
            
			$render_modules .= '<div class="atbs-ceris-posts-latest-has--smallpost-2">';
            $render_modules .= '<div class="posts-list">';
            while (have_posts()): the_post();                 
                $postHorizontalAttr['postID'] = get_the_ID();
                if($postIcon !== 'disable') {
                    $addClass = '';
                    $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition'], $addClass);
                    $postHorizontalAttr['postIcon'] = $postIconAttr;
                }
                if($postAnimation !== 'disable'):
                    $postHorizontalAttr['additionalClass'] .= ' icon-has-animation';
                endif;
                $render_modules .= '<div class="list-item">';
                $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                $render_modules .= '</div>';
                
            endwhile;
            
            $render_modules .= '</div>';
            $render_modules .= '</div><!-- .atbs-ceris-posts-latest-has--smallpost-2 -->';
            
            return $render_modules;
        }
        static function listing_list_large_a__render($moduleID, $bookmark = '') {
            $render_modules = '';
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postAnimation = self::bk_archive_pages_post_icon_animation();
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'post_icon_animation' => $postAnimation,
                'bookmark'      => $bookmark,
            );
            
            if($moduleInfo['bookmark'] == 'on') {
                $bookmarkClass = 'post-has-bookmark bookmark__notice_align_right';
            }else {
                $bookmarkClass = '';
            }
                        
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
                        
            $catStyle = 4; //Above the Title - No BG
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            
            $postOverlayHTML = new ceris_post_overlay_9;                    
            $postOverlayAttr = array (
                'additionalClass'   => 'text-center post--overlay-text-center--bg post--overlay-bottom post--overlay-md post--overlay-text-has-shadow '.$bookmarkClass,
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'additionalThumbClass' => 'post__thumb--overlay atbs-thumb-object-fit',
                'thumbSize'         => 'ceris-l-16_9',
                'typescale'         => 'typescale-2',
                'postIcon'          => $postIconAttr,
                'meta'                 => array('author_name', 'date'),
                'postIcon'             => $postIconAttr,  
                'bookmark'             => $moduleInfo['bookmark'],
            );
            if($moduleInfo['bookmark'] == 'on') {
                $postOverlayAttr['meta'] = array('author_name');
            }else {
                $postOverlayAttr['meta'] = array('author_name', 'date');
            }
			$render_modules .= '<div class="atbs-ceris-posts-latest--text-right">';
            $render_modules .= '<div class="posts-list">';
            while (have_posts()): the_post();                 
                $postOverlayAttr['postID'] = get_the_ID();
                if($postIcon !== 'disable') {
                    $addClass = '';
                    $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition'], $addClass);
                    $postOverlayAttr['postIcon'] = $postIconAttr;
                }
                if($postAnimation !== 'disable'):
                    $postOverlayAttr['additionalClass'] .= ' icon-has-animation';
                endif;
                $render_modules .= '<div class="list-item">';
                $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                $render_modules .= '</div>';
                
            endwhile;
            
            $render_modules .= '</div>';
            $render_modules .= '</div><!-- .atbs-ceris-posts-latest--text-right -->';
            
            return $render_modules;
        }
        static function listing_list_large_b__render($moduleID, $bookmark = '') {
            $render_modules = '';
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postAnimation = self::bk_archive_pages_post_icon_animation();
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'post_icon_animation' => $postAnimation,
                'bookmark'      => $bookmark,
            );
            
            if($moduleInfo['bookmark'] == 'on') {
                $bookmarkClass = 'post-has-bookmark bookmark__notice_align_right';
            }else {
                $bookmarkClass = '';
            } 
            
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
                        
            $catStyle = 4; //Above the Title - No BG
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            
            $postOverlayHTML = new ceris_post_overlay_9;                    
            $postOverlayAttr = array (
                'additionalClass'   => 'text-center post--overlay-text-bottom-center--bg post--overlay-bottom post--overlay-md post--overlay-text-has-shadow '.$bookmarkClass,
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'ceris-l-16_9',
                'additionalThumbClass' => 'post__thumb--overlay atbs-thumb-object-fit',
                'typescale'         => 'typescale-2',
                'postIcon'          => $postIconAttr,
                'meta'              => array('author_name', 'date'),
                'postIcon'             => $postIconAttr,  
                'bookmark'             => $moduleInfo['bookmark'],
            );
            
            if($moduleInfo['bookmark'] == 'on') {
                $postOverlayAttr['meta'] = array('author_name');
            }else {
                $postOverlayAttr['meta'] = array('author_name', 'date');
            }

			$render_modules .= '<div class="atbs-ceris-posts-latest--text-left">';
            $render_modules .= '<div class="posts-list">';
            while (have_posts()): the_post();                 
                $postOverlayAttr['postID'] = get_the_ID();
                if($postIcon !== 'disable') {
                    $addClass = '';
                    $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition'], $addClass);
                    $postOverlayAttr['postIcon'] = $postIconAttr;
                }
                if($postAnimation !== 'disable'):
                    $postOverlayAttr['additionalClass'] .= ' icon-has-animation';
                endif;
                $render_modules .= '<div class="list-item">';
                $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                $render_modules .= '</div>';
                
            endwhile;
            
            $render_modules .= '</div>';
            $render_modules .= '</div><!-- .atbs-ceris-posts-latest--text-left -->';
            
            return $render_modules;
        }
        static function listing_list_alt_a__render($moduleID, $bookmark = '') {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postHorizontalHTML = new ceris_horizontal_1;
                        
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'meta'          => 3,
                'cat'           => 3,
                'excerpt'       => 1,
                'bookmark'      => $bookmark,
            );
            
            if($moduleInfo['bookmark'] == 'on') {
                $bookmarkClass = 'post-has-bookmark';
            }else {
                $bookmarkClass = '';
            }
            
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
            $cat = 3; //Above the Title - No BG
            $cat_Class = ceris_core::bk_get_cat_class($cat);
            
            $postHorizontalAttr = array (
                'additionalClass'   => $bookmarkClass,
                'cat'               => $cat,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'ceris-xs-4_3',
                'typescale'         => 'typescale-2',
                'except_length'     => 23,
                'meta'              => array('author', 'date', 'comment'),
                'postIcon'          => $postIconAttr,  
                'bookmark'          => $moduleInfo['bookmark'],
            );
            
			$render_modules .= '<div class="posts-list list-unstyled list-space-xl">';
            
            while (have_posts()): the_post();                 
                $currentPost = $wp_query->current_post;
                $postHorizontalAttr['postID'] = get_the_ID();
                $postHorizontalAttr['additionalClass'] = 'post--horizontal-sm '.$bookmarkClass;
                
                if($postIcon !== 'disable') {
                    $addClass = 'overlay-item--sm-p';
                    $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition'], $addClass);
                    $postHorizontalAttr['postIcon'] = $postIconAttr;
                }
                if($currentPost % 5) : //Normal Posts 
                    $postHorizontalAttr['additionalClass'] = 'post--horizontal-sm '.$bookmarkClass;
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</div>';
                else: //Large Posts
                    $postHorizontalAttr_L = $postHorizontalAttr;
                    $postHorizontalAttr_L['typescale'] = 'typescale-3';
                    $postHorizontalAttr_L['additionalClass'] = $bookmarkClass;
                    $postHorizontalAttr_L['postIcon']['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $moduleInfo['iconPosition']);
                    
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr_L);
                    $render_modules .= '</div>';
                endif;
            endwhile;
            
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        static function listing_list_alt_b__render($moduleID, $bookmark = '') {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postAnimation = self::bk_archive_pages_post_icon_animation();

            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postHorizontalHTML = new ceris_horizontal_1;
            $postOverlayHTML = new ceris_overlay_1;
                        
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition_l'  => 'top-right',
                'iconPosition_s'  => 'top-right',
                'meta_l'          => 3,
                'cat_l'           => 1,
                'excerpt_l'       => 1,
                'meta_s'          => 3,
                'cat_s'           => 3,
                'excerpt_s'       => 1,
                'footer_style'    => '1-col',
                'post_icon_animation' => $postAnimation,
                'bookmark'      => $bookmark,
            );
            
            if($moduleInfo['bookmark'] == 'on') {
                $bookmarkClass = 'post-has-bookmark';
            }else {
                $bookmarkClass = '';
            }
            
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
            $cat_L_Style = 1;
            $cat_L_Class = ceris_core::bk_get_cat_class($cat_L_Style);

            $catStyle = 4;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            
            $postOverlayHTML = new ceris_overlay_1;
            $postOverlayAttr = array (
                'additionalClass'      => 'post--overlay-floorfade posts-has-smaller-post-cat post--overlay-bottom post--overlay-md post--overlay-padding-lg custom_post--overlay '.$bookmarkClass,
                'cat'                  => $cat_L_Style,
                'catClass'             => $cat_L_Class,
                'thumbSize'            => 'ceris-m-16_9',
                'additionalThumbClass' => 'post__thumb--overlay atbs-thumb-object-fit',
                'typescale'            => 'typescale-3',
                'except_length'        => 22,
                'meta'                 => array('author', 'date'),
                'postIcon'             => $postIconAttr,  
                'bookmark'          => $moduleInfo['bookmark'],
            );
            $postHorizontalHTML = new ceris_post_horizontal_1;                     
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-middle remove-margin-bottom-lastchild post__thumb--width-400 post--horizontal-no-excerpt '.$bookmarkClass,
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'ceris-xs-4_3',
                'typescale'         => 'typescale-2',
                'except_length'     => 15,
                'postIcon'          => $postIconAttr,  
                'meta'              => array('author_name', 'date'),
                'bookmark'             => $moduleInfo['bookmark'],
            );
            
			$render_modules .= '<div class="posts-list list-unstyled list-space-xl">';
            
            while (have_posts()): the_post();                 
                $currentPost = $wp_query->current_post;                
                
                if($currentPost % 5) : //Small Posts
                    $postHorizontalAttr['postID'] = get_the_ID();
                    
                    if($postIcon !== 'disable') {
                        $addClass = 'overlay-item--sm-p';
                        $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                        $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'small', $moduleInfo['iconPosition_s'], $addClass);
                        $postHorizontalAttr['postIcon'] = $postIconAttr;
                    }
                    if($postAnimation !== 'disable'):
                        $postHorizontalAttr['additionalClass'] .= ' icon-has-animation';
                    endif;
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</div>';
                else: //Large Posts
                    $postOverlayAttr['postID'] = get_the_ID();
                    
                    if($postIcon !== 'disable') {
                        $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                        if($postIconAttr['iconType'] == 'gallery') {
                            $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                        }else {
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition_l']);
                        }
                        
                        $postOverlayAttr['postIcon']    = $postIconAttr;
                    }
                    if($postAnimation !== 'disable'):
                        $postOverlayAttr['additionalClass'] .= ' icon-has-animation';
                    endif;
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                    $render_modules .= '</div>';
                endif;
                
            endwhile;
            
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        static function listing_list_alt_c__render($moduleID, $bookmark = '') {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postHorizontalHTML = new ceris_horizontal_1;
            $postVerticalHTML = new ceris_vertical_1;

            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition_l'  => 'top-right',
                'iconPosition_s'  => 'top-right',
                'meta_l'          => 3,
                'cat_l'           => 1,
                'excerpt_l'       => 1,
                'meta_s'          => 3,
                'cat_s'           => 3,
                'excerpt_s'       => 1,
                'footer_style'    => '1-col',
            );
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
            $cat_L = 1; //Above the Title - No BG
            $cat_L_Class = ceris_core::bk_get_cat_class($cat_L);
            
            $cat_S = 3; //Above the Title - No BG
            $cat_S_Class = ceris_core::bk_get_cat_class($cat_S);

            $postVerticalAttr = array (
                'cat'           => $cat_L,
                'catClass'      => $cat_L_Class,
                'thumbSize'     => 'ceris-m-2_1',
                'typescale'     => 'typescale-4',
                'additionalExcerptClass' => 'post__excerpt--lg',
                'except_length' => 23,
                'meta'          => array('author', 'date', 'comment'),
                'postIcon'      => $postIconAttr,    
                'additionalTextClass'   => '',
            );
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-sm',
                'cat'               => $cat_S,
                'catClass'          => $cat_S_Class,
                'thumbSize'         => 'ceris-xs-4_3',
                'typescale'         => 'typescale-2',
                'except_length'     => 23,
                'meta'              => array('author', 'date', 'comment'),
                'postIcon'          => $postIconAttr,  
            );
            
			$render_modules .= '<div class="posts-list list-unstyled list-space-xl">';
            
            while (have_posts()): the_post();                 
                $currentPost = $wp_query->current_post;                
                
                if($currentPost % 5) : //Small Posts
                    $postHorizontalAttr['postID'] = get_the_ID();
                    $postHorizontalAttr['additionalClass'] = 'post--horizontal-sm';
                    
                    if($postIcon !== 'disable') {
                        $addClass = 'overlay-item--sm-p';
                        $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                        $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition_s'], $addClass);
                        $postHorizontalAttr['postIcon'] = $postIconAttr;
                    }
                    
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</div>';
                else: //Large Posts
                    $postVerticalAttr['postID'] = get_the_ID();
                    
                    if($postIcon !== 'disable') {
                        $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                        $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $moduleInfo['iconPosition_l']);
                        $postVerticalAttr['postIcon']    = $postIconAttr;
                    }
                    
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                    $render_modules .= '</div>';
                endif;
                
            endwhile;
            
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        static function listing_grid__render($moduleID, $pagination, $bookmark = '') {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            $postIcon = self::bk_archive_pages_post_icon();
            $postAnimation = self::bk_archive_pages_post_icon_animation();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'post_icon_animation' => $postAnimation,
                'bookmark'      => $bookmark,
            );
            
            if($moduleInfo['bookmark'] == 'on') {
                $bookmarkClass = 'post-has-bookmark bookmark__notice_align_right';
            }else {
                $bookmarkClass = '';
            } 
            
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
            $catStyle = 4;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            
            $postVerticalHTML = new ceris_post_vertical_3;         
            $postVerticalAttr = array (
                'cat'                 => $catStyle,
                'catClass'            => $cat_Class,
                'additionalClass'     => 'ceris-post-vertical--cat-overlay post--vertical-text-not-fullwidth '.$bookmarkClass,
                'additionalTextClass' => '',
                'thumbSize'           => 'ceris-xs-4_3',
                'typescale'           => 'typescale-2',
                'postIcon'            => $postIconAttr,
                'bookmark'          => $moduleInfo['bookmark'], 
                'except_length'     => 15,
                'meta'              => array('author_name', 'date'),
            );
            
            $render_modules .= '<div class="atbs-ceris-posts--vertical-text-not-fullwidth">';
			$render_modules .= '<div class="posts-list post-list row row--space-between grid-gutter-40 items-clear-both-2">';
                while (have_posts()): the_post();                 
                    $currentPost = $wp_query->current_post;
                    $postVerticalAttr['postID'] = get_the_ID();
                    if($postIcon !== 'disable') {
                        $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                        $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition']);
                        $postVerticalAttr['postIcon'] = $postIconAttr;
                    }
                    if($postAnimation !== 'disable'):
                        $postVerticalAttr['additionalClass'] .= ' icon-has-animation';
                    endif;
                    $render_modules .= '<div class="col-md-6 col-sm-6 list-item">';
                    $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                    $render_modules .= '</div>';
                endwhile;
            $render_modules .= '</div>';
            $render_modules .= '</div><!-- .atbs-ceris-posts--vertical-text-not-fullwidth -->';
            return $render_modules;
        }
        static function listing_grid_b__render($moduleID, $pagination, $bookmark = '') {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            $postIcon = self::bk_archive_pages_post_icon();
            $postAnimation = self::bk_archive_pages_post_icon_animation();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postIconAttr['post_icon_animation'] = '';
                        
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'post_icon_animation' => $postAnimation,
                'iconPosition'  => 'top-right',
                'bookmark'      => $bookmark,
            );
            
            if($moduleInfo['bookmark'] == 'on') {
                $bookmarkClass = 'post-has-bookmark bookmark__notice_align_right';
            }else {
                $bookmarkClass = '';
            }
                        
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
            $catStyle = 4; //Top - Left
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            
            $postOverlayHTML = new ceris_post_overlay_2;         
            $postOverlayAttr = array (
                'cat'                  => $catStyle,
                'catClass'             => $cat_Class.' overlay-item--top-left',
                'additionalClass'      => 'post--overlay-bottom post--overlay-floorfade posts-has-smaller-post-cat post--overlay-md post--overlay-padding-lg post--overlay-top-bottom '.$bookmarkClass,
                'additionalThumbClass' => 'post__thumb--overlay atbs-thumb-object-fit',
                'additionalTextClass'  => 'inverse-text',
                'thumbSize'            => 'ceris-s-1_1',
                'typescale'            => 'typescale-2',
                'postIcon'             => $postIconAttr,
                'bookmark'             => $moduleInfo['bookmark'], 
                'meta'                 => array('author', 'date'),
            );
            
            $render_modules .= '<div class="atbs-ceris-posts-latest--overlay">';
			$render_modules .= '<div class="posts-list post-list row row--space-between grid-gutter-40 items-clear-both-2">';
                while (have_posts()): the_post();                 
                    $currentPost = $wp_query->current_post;
                    $postOverlayAttr['postID'] = get_the_ID();
                    if($postIcon !== 'disable') {
                        $postIconAttr['iconType'] = ceris_core::bk_post_format_detect(get_the_ID());
                        $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition']);
                        $postOverlayAttr['postIcon'] = $postIconAttr;
                    }
                    if($postAnimation !== 'disable'):
                        $postOverlayAttr['additionalClass'] .= ' icon-has-animation';
                    endif;
                    $render_modules .= '<div class="col-md-6 col-sm-6 list-item">';
                    $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                    $render_modules .= '</div>';
                endwhile;
            $render_modules .= '</div>';
            $render_modules .= '</div><!-- .atbs-ceris-posts-latest--overlay -->';
            return $render_modules;
        }
        static function listing_grid_alt_a__render($moduleID, $pagination) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition_l'  => 'top-right',
                'iconPosition_s'  => 'top-right',
                'meta_l'          => 3,
                'cat_l'           => 1,
                'excerpt_l'       => 1,
                'meta_s'          => 2,
                'cat_s'           => 1,
                'excerpt_s'       => 1,
                'footer_style'    => '1-col',
            );
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
            $cat_L = 1; //Top - Left
            $cat_L_Class = ceris_core::bk_get_cat_class($cat_L);
            
            $cat_S = 1; //Top - Left
            $cat_S_Class = ceris_core::bk_get_cat_class($cat_S);
            
            $postVerticalHTML = new ceris_vertical_1;
            $postOverlayHTML = new ceris_overlay_1;
            $postOverlayAttr = array (
                'additionalClass'   => 'post--overlay-floorfade post--overlay-bottom post--overlay-md post--overlay-padding-lg',
                'additionalExcerptClass' => 'hidden-xs',
                'cat'               => $cat_L,
                'catClass'          => $cat_L_Class,
                'thumbSize'         => 'ceris-m-16_9',
                'typescale'         => 'typescale-4',
                'footerType'            => '1-col',
                'additionalMetaClass'   => '',
                'except_length'     => 23,
                'meta'              => array('author', 'date', 'comment'),
                'postIcon'          => $postIconAttr,  
            );
            $postVerticalAttr = array (
                'cat'               => $cat_S,
                'catClass'          => $cat_S_Class,
                'thumbSize'         => 'ceris-xs-2_1',
                'typescale'         => 'typescale-2',
                'except_length'     => 17,
                'meta'              => array('author', 'date'),
                'postIcon'          => $postIconAttr,      
            );
            
			$render_modules .= '<div class="posts-list">';
            
            $openRow = '<div class="row row--space-between">';
            $closeRow = '</div><!--Close Row -->';
            
            if($pagination == 'ajax-loadmore') :
                while (have_posts()): the_post();
                    $currentPost = $wp_query->current_post;
                    $currentPostINBLK = $currentPost % 5; //1 BLK has 5 Posts (Include: 1 Large Post and 4 Small Posts))
                    if(($currentPostINBLK == 1) || ($currentPostINBLK == 3)) {
                        $render_modules_tmp = '';
                        $render_modules_tmp .= $openRow;
                    }
                    if($currentPostINBLK % 5) : //Small Posts
                        $postVerticalAttr['postID'] = get_the_ID();
                        
                        if($postIcon !== 'disable') {
                            $postIconAttr['iconType']       = ceris_core::bk_post_format_detect(get_the_ID());
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition_s']);
                            $postVerticalAttr['postIcon']   = $postIconAttr;
                        }
                        
                        $render_modules_tmp .= '<div class="col-xs-12 col-sm-6">';
                        $render_modules_tmp .= $postVerticalHTML->render($postVerticalAttr);
                        $render_modules_tmp .= '</div>';
                    else: //Large Posts
                        $postOverlayAttr['postID'] = get_the_ID();
                        
                        if($postIcon !== 'disable') {
                            $postIconAttr['iconType']   = ceris_core::bk_post_format_detect(get_the_ID());
                            if($postIconAttr['iconType'] == 'gallery') {
                                $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                            }else {
                                $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $moduleInfo['iconPosition_l']);
                            }
                            $postOverlayAttr['postIcon']    = $postIconAttr;
                        }
                        
                        $render_modules .= $openRow;
                        $render_modules .= '<div class="col-xs-12">';
                        $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                        $render_modules .= '</div>';
                        $render_modules .= $closeRow;
                    endif;
                                        
                    if(($currentPostINBLK == 2) || ($currentPostINBLK == 4)) {
                        $render_modules_tmp .= $closeRow;
                        $render_modules .= $render_modules_tmp;
                    } 
                    if((($currentPostINBLK == 1) || ($currentPostINBLK == 3)) && ($wp_query->post_count == 1)) {
                        $render_modules_tmp .= $closeRow;
                        $render_modules .= $render_modules_tmp;
                    }
                endwhile;
            else :
                while (have_posts()): the_post();
                    $currentPost = $wp_query->current_post;
                    $currentPostINBLK = $currentPost % 5; //1 BLK has 5 Post (Include: 1 Large Post and 4 Small Post))
                    if(($currentPostINBLK == 1) || ($currentPostINBLK == 3)) {
                        $render_modules .= $openRow;
                    }
                    if($currentPostINBLK % 5) : // Normal Posts
                        $postVerticalAttr['postID'] = get_the_ID();
                        
                        if($postIcon !== 'disable') {
                            $postIconAttr['iconType']       = ceris_core::bk_post_format_detect(get_the_ID());
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition_s']);
                            $postVerticalAttr['postIcon']   = $postIconAttr;
                        }
                        $render_modules .= '<div class="col-xs-12 col-sm-6">';
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                        $render_modules .= '</div>';
                    else: // Large Posts
                        $postOverlayAttr['postID'] = get_the_ID();
                        
                        if($postIcon !== 'disable') {
                            $postIconAttr['iconType']   = ceris_core::bk_post_format_detect(get_the_ID());
                            if($postIconAttr['iconType'] == 'gallery') {
                                $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                            }else {
                                $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $moduleInfo['iconPosition_l']);
                            }
                            $postOverlayAttr['postIcon']    = $postIconAttr;
                        }
                        $render_modules .= $openRow;
                        $render_modules .= '<div class="col-xs-12">';
                        $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                        $render_modules .= '</div>';
                        $render_modules .= $closeRow;
                    endif;
                                        
                    if(($currentPostINBLK == 2) || ($currentPostINBLK == 4)) {
                        $render_modules .= $closeRow;
                    } 
                endwhile;
    
                if(($currentPostINBLK == 1) || ($currentPostINBLK == 3)) {
                    $render_modules .= $closeRow;
                } 
            endif;
            
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        static function listing_grid_alt_b__render($moduleID, $pagination, $bookmark = '') {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postAnimation = self::bk_archive_pages_post_icon_animation();

            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition_l'  => 'top-right',
                'iconPosition_s'  => 'top-right',
                'meta_l'          => 3,
                'cat_l'           => 1,
                'excerpt_l'       => 1,
                'meta_s'          => 2,
                'cat_s'           => 1,
                'excerpt_s'       => 1,
                'footer_style'    => '1-col',
                'post_icon_animation' => $postAnimation,
                'bookmark'        => $bookmark,

            );
            
            if($moduleInfo['bookmark'] == 'on') {
                $bookmarkClass = 'post-has-bookmark';
            }else {
                $bookmarkClass = '';
            }
            
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
            $cat_L_Style = 1;
            $cat_L_Class = ceris_core::bk_get_cat_class($cat_L_Style);
            
            
            $cat_S_Style = 4;
            $cat_S_Class = ceris_core::bk_get_cat_class($cat_S_Style);
            
            $postOverlayHTML = new ceris_overlay_1;
            $postOverlayAttr = array (
                'additionalClass'   => 'post--overlay-floorfade posts-has-smaller-post-cat post--overlay-bottom post--overlay-md post--overlay-padding-lg custom_post--overlay '.$bookmarkClass,
                'cat'               => $cat_L_Style,
                'catClass'          => $cat_L_Class,
                'thumbSize'         => 'ceris-m-16_9',
                'additionalThumbClass' => 'post__thumb--overlay atbs-thumb-object-fit',
                'typescale'         => 'typescale-3',
                'except_length'        => 23,
                'meta'                 => array('author', 'date'),
                'postIcon'             => $postIconAttr,  
                'bookmark'             => $moduleInfo['bookmark'],
            );
            
            $postVerticalHTML = new ceris_post_vertical_3;         
            $postVerticalAttr = array (
                'cat'                 => $cat_S_Style,
                'catClass'            => $cat_S_Class,
                'additionalClass'     => 'post--vertical-text-not-fullwidth '.$bookmarkClass,
                'additionalTextClass' => '',
                'thumbSize'           => 'ceris-xs-4_3',
                'typescale'           => 'typescale-2',
                'postIcon'            => $postIconAttr,
                'bookmark'          => $moduleInfo['bookmark'], 
                'except_length'     => 15,
                'meta'              => array('author_name', 'date'),
            );
            
			$render_modules .= '<div class="posts-list">';
            
            $openRow = '<div class="row row--space-between">';
            $closeRow = '</div><!--Close Row -->';
            
            if($pagination == 'ajax-loadmore') :
                while (have_posts()): the_post();
                    $currentPost = $wp_query->current_post;
                    $currentPostINBLK = $currentPost % 5; //1 BLK has 5 Posts (Include: 1 Large Post and 4 Small Posts))
                    if(($currentPostINBLK == 1) || ($currentPostINBLK == 3)) {
                        $render_modules_tmp = '';
                        $render_modules_tmp .= $openRow;
                    }
                    if($currentPostINBLK % 5) : //Small Posts
                        $postVerticalAttr['postID'] = get_the_ID();
                        
                        if($postIcon !== 'disable') {
                            $postIconAttr['iconType']       = ceris_core::bk_post_format_detect(get_the_ID());
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition_s']);
                            $postVerticalAttr['postIcon']   = $postIconAttr;
                        }
                        if($postAnimation !== 'disable'):
                            $postVerticalAttr['additionalClass'] .= ' icon-has-animation';
                        endif;
                        $render_modules_tmp .= '<div class="col-xs-12 col-sm-6">';
                        $render_modules_tmp .= $postVerticalHTML->render($postVerticalAttr);
                        $render_modules_tmp .= '</div>';
                    else: //Large Posts
                        $postOverlayAttr['postID'] = get_the_ID();
                        
                        if($postIcon !== 'disable') {
                            $postIconAttr['iconType']       = ceris_core::bk_post_format_detect(get_the_ID());
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition_l']);
                            $postOverlayAttr['postIcon'] = $postIconAttr;
                        }
                        if($postAnimation !== 'disable'):
                            $postOverlayAttr['additionalClass'] .= ' icon-has-animation';
                        endif;
                        $render_modules .= $openRow;
                        $render_modules .= '<div class="col-xs-12">';
                        $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                        $render_modules .= '</div>';
                        $render_modules .= $closeRow;
                    endif;
                                        
                    if(($currentPostINBLK == 2) || ($currentPostINBLK == 4)) {
                        $render_modules_tmp .= $closeRow;
                        $render_modules .= $render_modules_tmp;
                    } 
                    if((($currentPostINBLK == 1) || ($currentPostINBLK == 3)) && ($wp_query->post_count == 1)) {
                        $render_modules_tmp .= $closeRow;
                        $render_modules .= $render_modules_tmp;
                    }
                endwhile;
            else:
                while (have_posts()): the_post();
                    $currentPost = $wp_query->current_post;
                    $currentPostINBLK = $currentPost % 5; //1 BLK has 5 Post (Include: 1 Large Post and 4 Small Post))
                    if(($currentPostINBLK == 1) || ($currentPostINBLK == 3)) {
                        $render_modules .= $openRow;
                    }
                    if($currentPostINBLK % 5) : // Normal Posts
                        $postVerticalAttr['postID'] = get_the_ID();
                        
                        if($postIcon !== 'disable') {
                            $postIconAttr['iconType']       = ceris_core::bk_post_format_detect(get_the_ID());
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition_s']);
                            $postVerticalAttr['postIcon']   = $postIconAttr;
                        }
                        if($postAnimation !== 'disable'):
                            $postVerticalAttr['additionalClass'] .= ' icon-has-animation';
                        endif;
                        $render_modules .= '<div class="col-xs-12 col-sm-6">';
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                        $render_modules .= '</div>';
                    else: // Large Posts
                        $postOverlayAttr['postID']   = get_the_ID();
                        
                        if($postIcon !== 'disable') {
                            $postIconAttr['iconType']       = ceris_core::bk_post_format_detect(get_the_ID());
                            $postIconAttr['postIconClass']  = ceris_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition_l']);
                            $postOverlayAttr['postIcon'] = $postIconAttr;
                        }
                        if($postAnimation !== 'disable'):
                            $postOverlayAttr['additionalClass'] .= ' icon-has-animation';
                        endif;
                        $render_modules .= $openRow;
                        $render_modules .= '<div class="col-xs-12">';
                        $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                        $render_modules .= '</div>';
                        $render_modules .= $closeRow;
                    endif;
                                        
                    if(($currentPostINBLK == 2) || ($currentPostINBLK == 4)) {
                        $render_modules .= $closeRow;
                    } 
                endwhile;
    
                if(($currentPostINBLK == 1) || ($currentPostINBLK == 3)) {
                    $render_modules .= $closeRow;
                } 
                
            endif;
            
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        static function listing_grid_small__render($moduleID) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';

            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'meta'          => 2,
                'cat'           => 1,
            );
            ceris_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
            $catStyle = 3;
            $cat_Class = ceris_core::bk_get_cat_class($catStyle);
            
            $postHorizontalHTML = new ceris_post_horizontal_1;         
            $postHorizontalAttr = array (
                'cat'                 => $catStyle,
                'catClass'            => $cat_Class.' post__cat-has-line',
                'additionalClass'     => 'post--horizontal-reverse post--horizontal-middle post--horizontal-120 remove-margin-bottom-lastchild post--horizontal-cat-no-line',
                'additionalThumbClass' => '',
                'thumbSize'           => 'ceris-s-1_1',
                'typescale'           => 'typescale-2 custom-typescale-2--xxs',
                'postIcon'            => $postIconAttr,
            );
            
			$render_modules .= '<div class="posts-listing-grid-small atbs-ceris-post--listing-list-a-update">';
            $render_modules .= '<div class="post-list posts-list">';
            while (have_posts()): the_post();  
                $currentPost = $wp_query->current_post;     
                $postHorizontalAttr['postID'] = get_the_ID();
                $render_modules .= '<div class="list-item">';
                $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                $render_modules .= '</div>';
            endwhile;
            $render_modules .= '</div><!-- .posts-list -->';
            $render_modules .= '</div><!-- .posts-listing -->';
            
            return $render_modules;
        }
        static function author_box($authorID){  
            $bk_author_email = get_the_author_meta('publicemail', $authorID);
            $bk_author_name = get_the_author_meta('display_name', $authorID);
            $bk_author_tw = get_the_author_meta('twitter', $authorID);
            $bk_author_fb = get_the_author_meta('facebook', $authorID);
            $bk_author_yo = get_the_author_meta('youtube', $authorID);
            $bk_author_instagram = get_the_author_meta('instagram', $authorID);
            $bk_author_linkedin = get_the_author_meta('linkedin', $authorID);
            $bk_author_pinterest = get_the_author_meta('pinterest', $authorID);
            $bk_author_dribbble = get_the_author_meta('dribbble', $authorID);
            $bk_author_www = get_the_author_meta('url', $authorID);
            $bk_author_desc = get_the_author_meta('description', $authorID);
            $bk_author_posts = count_user_posts( $authorID ); 
    
            $authorImgALT = $bk_author_name;
            $authorArgs = array(
                'class' => 'avatar photo',
            );
            
            $render = '';
            $render .= '<div class="author-box">';
            $render .= '<div class="author-box__image">';
            $render .= '<div class="author-avatar">';
            $render .= get_avatar($authorID, '180', '', esc_attr($authorImgALT), $authorArgs);
            $render .= '</div>';
            $render .= '</div>';
            $render .= '<div class="author-box__text">';
            $render .= '<div class="author-name meta-font">';
            $render .= '<a href="'.get_author_posts_url($authorID).'" title="Posts by '.esc_attr($bk_author_name).'" rel="author">'.esc_attr($bk_author_name).'</a>';
            $render .= '</div>';
            $render .= '<div class="author-bio">';
            $render .= $bk_author_desc;
            $render .= '</div>';
            $render .= '<div class="author-info">';
            $render .= '<div class="row row--space-between row--flex row--vertical-center grid-gutter-20">';
            $render .= '<div class="author-socials col-xs-12">';
            $render .= '<ul class="list-unstyled list-horizontal list-space-xs">';

            if (($bk_author_email != NULL) || ($bk_author_www != NULL) || ($bk_author_tw != NULL) || ($bk_author_fb != NULL) ||($bk_author_yo != NULL) ||($bk_author_instagram != NULL) ||($bk_author_linkedin != NULL) ||($bk_author_dribbble != NULL) ||($bk_author_dribbble != NULL)) {
                if ($bk_author_email != NULL) { $render .= '<li><a href="mailto:'. esc_attr($bk_author_email) .'"><i class="mdicon mdicon-mail_outline"></i><span class="sr-only">e-mail</span></a></li>'; } 
                if ($bk_author_www != NULL) { $render .= ' <li><a href="'. esc_url($bk_author_www) .'" target="_blank"><i class="mdicon mdicon-public"></i><span class="sr-only">Website</span></a></li>'; } 
                if ($bk_author_tw != NULL) { $render .= ' <li><a href="'. esc_url($bk_author_tw).'" target="_blank" ><i class="mdicon mdicon-twitter"></i><span class="sr-only">Twitter</span></a></li>'; } 
                if ($bk_author_fb != NULL) { $render .= ' <li><a href="'. esc_url($bk_author_fb).'" target="_blank" ><i class="mdicon mdicon-facebook"></i><span class="sr-only">Facebook</span></a></li>'; }
                if ($bk_author_yo != NULL) { $render .= ' <li><a href="'. esc_url($bk_author_yo).'" target="_blank" ><i class="mdicon mdicon-youtube"></i><span class="sr-only">Youtube</span></a></li>'; }
                if ($bk_author_instagram != NULL) { $render .= ' <li><a href="'. esc_url($bk_author_instagram).'" target="_blank" ><i class="mdicon mdicon-instagram"></i><span class="sr-only">Instagram</span></a></li>'; }
                if ($bk_author_linkedin != NULL) { $render .= ' <li><a href="'. esc_url($bk_author_linkedin).'" target="_blank" ><i class="mdicon mdicon-linkedin"></i><span class="sr-only">Linkedin</span></a></li>'; }
                if ($bk_author_pinterest != NULL) { $render .= ' <li><a href="'. esc_url($bk_author_pinterest).'" target="_blank" ><i class="mdicon mdicon-pinterest-p"></i><span class="sr-only">Pinterest</span></a></li>'; }
                if ($bk_author_dribbble != NULL) { $render .= ' <li><a href="'. esc_url($bk_author_dribbble).'" target="_blank" ><i class="mdicon mdicon-dribbble"></i><span class="sr-only">Dribbble</span></a></li>'; }
            }       
                               
            $render .= '</ul>';
            $render .= '</div>';
            $render .= '</div>';
            $render .= '</div>';
            
            $render .= '</div>';
            $render .= '</div>';
            
            return $render;
        }
        
        static function author_item($authorID){  
            $bk_author_email = get_the_author_meta('publicemail', $authorID);
            $bk_author_name = get_the_author_meta('display_name', $authorID);
            $bk_author_tw = get_the_author_meta('twitter', $authorID);
            $bk_author_go = get_the_author_meta('googleplus', $authorID);
            $bk_author_fb = get_the_author_meta('facebook', $authorID);
            $bk_author_yo = get_the_author_meta('youtube', $authorID);
            $bk_author_www = get_the_author_meta('url', $authorID);
            $bk_author_desc = get_the_author_meta('description', $authorID);
            $bk_author_posts = count_user_posts( $authorID ); 
    
            $authorImgALT = $bk_author_name;
            $authorArgs = array(
                'class' => 'avatar',
            );
            
            $user_meta=get_userdata($authorID);
            if(empty($user_meta)){
                return '';
            }
            $user_roles=$user_meta->roles; //array of roles the user is part of.

            $render = '';
            $render .= '<div class="author-box author-box-vertical">';
            $render .= '<div class="author-box__image">';
            $render .= '<div class="author-avatar">';
            $render .= '<a href="'.get_author_posts_url($authorID).'" >'.get_avatar($authorID, '340', '', esc_attr($authorImgALT), $authorArgs).'</a>';
            $render .= '</div>';
            $render .= '</div>';
            $render .= '<div class="author-box__text text-center">';
            $render .= '<div class="author-name">';
            $render .= '<a href="'.get_author_posts_url($authorID).'" title="Posts by '.esc_attr($bk_author_name).'" rel="author">'.esc_attr($bk_author_name).'</a>';
            $render .= '</div>';
            $render .= '<span class="entry-author__task">'.esc_html($user_roles[0]).'</span>';
            $render .= '</div>';
            $render .= '</div>';
            return $render;
         
        }
    } // Close ceris_archive class
    
}
