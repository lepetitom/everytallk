<!-- search popup-->
<?php
    $ceris_option                = ceris_core::bk_get_global_var('ceris_option');
    $posts_section_heading      = $ceris_option['search_recommend_heading'] ? $ceris_option['search_recommend_heading'] : '';
    $post_section_query         = $ceris_option['search_recommend_query_option'] ? $ceris_option['search_recommend_query_option'] : '';
    
    $tags_section_heading       = $ceris_option['search_panel_tags_headline'] ? $ceris_option['search_panel_tags_headline'] : '';
    $tagIDs                     = (array_key_exists('section_search_panel_tag_option',$ceris_option) && $ceris_option['section_search_panel_tag_option']) ? $ceris_option['section_search_panel_tag_option'] : '';
?>
<div class="atbs-ceris-search-full">
    <span id="atbs-ceris-search-remove"><i class="mdicon mdicon-close"></i></span>
    <div class="atbs-ceris-search-full--wrap ajax-search is-in-navbar js-ajax-search is-active">
        <div class="atbs-ceris-search-full--form">
            <form action="<?php echo esc_url(home_url('/')); ?>" method="get">
                <input type="text" name="s" class="form-control search-form__input" autocomplete="off" placeholder="<?php esc_attr_e('Type to search', 'ceris');?>" value="">
                <button type="submit" class="btn-search-full"><i class="mdicon mdicon-arrow_forward"></i></button>
            </form>
            <div class="result-default">
                <div class="search-recommend-articles">
                    <h2 class="search-module-heading">
                        <?php 
                            if($posts_section_heading != '') :
                                echo esc_html($posts_section_heading);
                            else:
                                esc_html_e('Recommend Posts', 'ceris');
                            endif;
                        ?>
                    </h2>
                    <?php 
                        $args = array(
                            'orderby'       => 'date',
                            'post_status'   => 'publish',
            				'ignore_sticky_posts'   => 1,
            				'posts_per_page'        => 5,
                            'post_type'             => 'post',
                        );
                        switch ( $post_section_query ) {
    
            				//Date post
            				case 'date' :
            					$args['orderby'] = 'date';
            					break;
            
            				//Popular comment
            				case 'comment_count' :
            					$args['orderby'] = 'comment_count';
            					break;
                            
                            //Popular Views
            				case 'view_count' :
                                $args['meta_key'] = 'post_views_count';
            					$args['orderby']  = 'meta_value_num';
            					$args['order']    = 'DESC';
            					break;
                            
            				//Modified
            				case 'modified' :
            					$args['orderby'] = 'modified';
            					break;
                                
                            // Review
            				case 'top_review' :
            					$args['meta_key'] = 'bk_review_score';
            					$args['orderby']  = 'meta_value_num';
            					$args['order']    = 'DESC';
            					break;
            				//Random
            				case 'rand':
            					$args['orderby'] = 'rand';
            					break;
            
            				//Alphabet decs
            				case 'alphabetical_decs':
            					$args['orderby'] = 'title';
            					$args['order']   = 'DECS';
            					break;
            
            				//Alphabet asc
            				case 'alphabetical_asc':
            					$args['orderby'] = 'title';
            					$args['order']   = 'ASC';
            					break;
                            
                            // Default
                            default:
                                $args['orderby'] = 'date';
            					break;
            			}
                        $the_query = new WP_Query( $args );
                    ?>
                    <div class="popular-post-inner">
                        <div class="post-list">
                            <?php 
                            while ( $the_query->have_posts() ): $the_query->the_post(); 
                                $postID = get_the_ID();
                                $bk_permalink = get_permalink($postID);
                                $bk_post_title = get_the_title($postID);
                            ?>
                            <div class="list-item">
                                <article class="post">
                                    <div class="post__text">
                                        <h3 class="post__title typescale-1 custom-typescale-1">
                                            <a href="<?php echo esc_url($bk_permalink);?>"><?php echo esc_attr($bk_post_title);?></a>
                                        </h3>
                                    </div>
                                </article>
                            </div>
                            <?php    
                            endwhile;
                            ?> 
                        </div>
                    </div>
                </div>
                 <?php if(is_array($tagIDs) && ($tagIDs[0]) != ''):?>
                <div class="search-tags">
                    <h2 class="search-module-heading">    
                        <?php 
                            if($tags_section_heading != '') :
                                echo esc_html($tags_section_heading);
                            else:
                                esc_html_e('Popular Tags', 'ceris');
                            endif;
                        ?>
                    </h2>                    
                    <div class="tags-list entry-tags">
                        <ul>
                        <?php 
                            foreach ($tagIDs as $tagID):
                                $tag = get_tag($tagID);
                                $imageID = get_term_meta( $tagID, 'bk_archive_feat_img', false );
                                if((!empty($imageID)) && (count($imageID) != 0) && $imageID[0] != '') {
                                    $bgURL = wp_get_attachment_image_src( $imageID[0], 'ceris-xs-2_1');
                                    
                                }else {
                                    $bgURL = '';
                                }if(isset($bgURL[0]) && ($bgURL[0] != '')) {
                                    $bgStyle = 'style="background-image: url('. "'" .esc_url($bgURL[0]). "'" . ');"';
                                    $tagImg = '<img src="'.esc_url($bgURL[0]).'" alt="bg-0" />';
                                }else {
                                    $bgStyle = '';
                                    $tagImg = '';
                                }
                                ?>
                                <li>
                                <div class="background-img category-title-image">
                                    <?php echo ceris_core::ceris_html_render($tagImg); ?>
                                </div>
                                <div class="category-tile__inner">
                                    <div class="category-tile__text">
                                        <div class="category-tile__name"><?php echo esc_html($tag->name);?></div>
                                    </div>
                                </div>
                                <a href="<?php echo esc_url(get_tag_link($tag->term_id));?>" class="link-overlay" title="<?php esc_html_e('View all','ceris') ?>"></a>
                                </li>
                                <?php
                    		endforeach;
                        ?>
                        </ul>
                    </div>
                </div>
                <?php endif;?>
            </div>
        </div>
        <div class="atbs-ceris-search-full--result search-results">
            <div class="typing-loader"></div>
            <div class="search-results__inner">
            </div>                
        </div>
    </div>
</div>
<!-- .header-search-popup -->

