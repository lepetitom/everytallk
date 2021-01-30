<?php
if((is_user_logged_in())) {
    $userID = get_current_user_id();  
    $bookmarkData = get_user_meta( $userID, 'atbs_posts_bookmarked', true );
}else {
    $bookmarkData = array();
    return;
}

if(is_array($bookmarkData) && (count($bookmarkData) == 0)) :
    return;
elseif (!is_array($bookmarkData)) :
    return;
endif;

$args = array(
    'post__not_in'      => '',
	'post_type'         => 'post',
    'ignore_sticky_posts' => 1,
	'posts_per_page'    => 4,
    'post__in'          =>  $bookmarkData,
    'orderby'           => 'post__in',
    'offset'            => 0,
);

$the_query = new WP_Query( $args );

$postHorizontalHTML = new ceris_horizontal_1;
$postHorizontalAttr = array (
    'additionalClass'   => 'post--horizontal-xxs',
    'thumbSize'         => 'ceris-xxs-1_1',
    'typescale'         => 'typescale-1',
    'meta'              => array('date'),
);
$bookmarkLink = ceris_core::bk_get_theme_option('bookmark_dropdown_bookmark_news');
if($bookmarkLink == '') {
    $bookmarkLink = '#';
}
?>
<div class="btn-bookmark-list">
    <div class="bookmark-drop"></div>
    <a href="<?php echo esc_url($bookmarkLink);?>" class="btn-bookmark-link">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon-bookmark-default" width="16" height="16" viewBox="0 0 16 16">
            <g class="nc-icon-wrapper" stroke-width="1" fill="#111111" stroke="#111111">
                <path d="M12.5,15.5,7,11.5l-5.5,4V4A1.5,1.5,0,0,1,3,2.5h8A1.5,1.5,0,0,1,12.5,4Z" fill="none" stroke="#111111" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M5,.5h8A1.5,1.5,0,0,1,14.5,2V13" fill="none" stroke-linecap="round" stroke-linejoin="round" data-color="color-2"/>
            </g>
        </svg>
    </a>
    <div class="bookmark-list">
        <div class="posts-list">
            <?php
                while ( $the_query->have_posts() ): $the_query->the_post();   
                    $postHorizontalAttr['postID'] = get_the_ID();
                    echo '<div class="list-item">';
                    echo ceris_core::ceris_html_render($postHorizontalHTML->render($postHorizontalAttr));
                    echo '</div>';
                endwhile;
            ?>
        </div>
        <?php if($bookmarkLink != '#'):?>
        <a href="<?php echo esc_url($bookmarkLink);?>" class="bookmark-see-more"><span> <?php esc_html_e('See more','ceris') ?></span> <i class="mdicon mdicon-arrow_forward"></i></a>
        <?php endif;?>
    </div>
</div>