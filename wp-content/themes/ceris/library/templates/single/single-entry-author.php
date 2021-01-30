<!-- Entry meta -->
<?php
    global $post; //$post->post_author
    $ceris_option = ceris_core::bk_get_global_var('ceris_option');
    $postID = get_the_ID();
    $bk_author_name = get_the_author_meta('display_name', $post->post_author);
    $authorImgALT = $bk_author_name;
    $authorArgs = array(
        'class' => 'entry-author__avatar',
    );
    $ceris_article_date_unix = get_the_time('U', $postID);
    $ceris_meta_items = 8;
    if(isset($ceris_option['bk-single-meta-items'])):
        $ceris_meta_case = $ceris_option['bk-single-meta-items'];
        $ceris_meta_items = ceris_core::bk_get_meta_list($ceris_meta_case);
    endif;
?>
<div class="entry-author atbs-author-style">
    <?php 
        echo get_avatar($post->post_author, '50', '', $authorImgALT, $authorArgs);
            //function coauthors_posts_links( $between = null, $betweenLast = null, $before = null, $after = null, $echo = true )
        if(function_exists('coauthors_posts_links')){
              echo coauthors_posts_links(', ', esc_html__(' and ', 'ceris'), ' ', ' ', false);
        }
        else {
              echo ' <a class="entry-author__name" title="Posts by '.esc_attr($bk_author_name).'" rel="author" href="'.get_author_posts_url($post->post_author).'">'.esc_attr($bk_author_name).'</a>';
        }  
    ?>
</div>