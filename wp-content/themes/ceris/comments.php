<?php
/**
 * The template for displaying Comments.
 */
?>
<?php
    /*
     * If the current post is protected by a password and
     * the visitor has not yet entered the password we will
     * return early without loading the comments.
     */
    if (post_password_required()) return;
?>
<?php
    $postID = get_the_ID();  
    $ceris_option = ceris_core::bk_get_global_var('ceris_option');
    
    $sidebar_option = '';
    $sidebar        =  ceris_single::bk_get_post_option($postID, 'bk_post_sb_select'); 
    if(!is_active_sidebar($sidebar)) {
        $sidebar_option = 'disable';
    }
    
    $finalPostLayout = ceris_single::bk_get_single_post_layout($postID);
    if($finalPostLayout == '') {
        $finalPostLayout = 'single-1';
    }   
    
    if(isset($ceris_option['single-section-heading-font']['font-size']) && ($ceris_option['single-section-heading-font']['font-size'] != '')) {
        $headingFontSize = intval($ceris_option['single-section-heading-font']['font-size'], 10);
        $headingFontSizeClass = ' '.ceris_core::bk_detect_heading_size($headingFontSize);
    }else {
        $headingFontSizeClass = '';
    }
    
    $fwlayoutArray = array('single-3', 'single-6', 'single-8', 'single-10', 'single-13', 'single-16');
    if( in_array($finalPostLayout, $fwlayoutArray)) {?>
        <!-- Comments section -->
        <div class="atbs-ceris-block atbs-ceris-block--fullwidth comments-section">
        	<div class="container container--narrow">
    <?php
    }else { ?>
        <div class="comments-section single-entry-section">
    <?php
    }
?>
    <div id="comments" class="comments-area <?php echo esc_attr($headingFontSizeClass);?>">
        <?php if (have_comments()):?>
            <h2 class="comments-title">
                <?php 
                    if(get_comments_number() > 1) {
                        echo (number_format_i18n(get_comments_number()) .' '. esc_html__('Comments', 'ceris'));
                    }else {
                        echo ('1 '. esc_html__('Comment', 'ceris'));
                                            
                    }
                ?>
            </h2><!-- End Comment Area Title -->
        <?php endif;?>
        <?php // You can start editing here -- including this comment! ?>
            <?php if ( have_comments() ) : ?>
            <ol class="comment-list">
                <?php
                    /* Loop through and list the comments. Tell wp_list_comments()
                     * to use wpgrade_comment() to format the comments.
                     * If you want to overload this in a child theme then you can
                     * define wpgrade_comment() and that will be used instead.
                     * See wpgrade_comment() in inc/template-tags.php for more.
                     */
                    wp_list_comments( array( 'callback' => 'ceris_comments','short_ping'  => true, 'style' => 'ol' ) );
                ?>
            </ol><!-- .comment-list -->
    
                <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
                <nav role="navigation" id="comment-nav-bottom" class="comment-navigation">
                    <div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'ceris' ) ); ?></div>
                    <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'ceris' ) ); ?></div>
                </nav>
                <?php endif; // check for comment navigation ?>
            <?php endif; // have_comments() ?>
        <?php
            // If comments are closed and there are comments, let's leave a little note, shall we?
            if ( ! comments_open() && post_type_supports( get_post_type(), 'comments' ) && !is_page() ) :
        ?>
        <p class="nocomments"><?php esc_html_e( 'Comments are closed.', 'ceris' ); ?></p>
        <?php endif; ?>
    <?php
    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    
    $comment__note = '<p class="comment-notes"><span id="email-notes">'.esc_html__('Your email address will not be published.', 'ceris').' </span>'.esc_html__('Required fields are marked', 'ceris').' <span class="required">*</span></p>';
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        $comments_args = array(
            // change the title of send button
            'title_reply'=> esc_html__('Leave a reply', 'ceris'),
            'fields' => apply_filters( 'comment_form_default_fields', array(
                'author' => '<p class="comment-form-author"><label for="author">'.esc_html__('Name', 'ceris').' <span class="required">*</span></label><input id="author" name="author" type="text" size="30" placeholder="'.esc_html__( 'Name *', 'ceris' ).'" maxlength="245" ' .  $aria_req . ' /></p>',
                'email' => '<p class="comment-form-email"><label for="email">'.esc_html__('Email', 'ceris').' <span class="required">*</span></label><input id="email" name="email" size="30" maxlength="100" placeholder="'.esc_html__( 'Email *', 'ceris' ).'" type="text" '. $aria_req .' /></p>' ) ),
            'id_submit' => 'comment-submit',
            'label_submit' => esc_html__('Post Comment', 'ceris'),
            // redefine your own textarea (the comment body)
            'comment_field' => '<p class="comment-form-comment"><label for="comment">'.esc_html__( 'Comment', 'ceris' ).'</label><textarea id="comment" name="comment" cols="45" rows="8" placeholder="'.esc_html__( 'Your comment', 'ceris' ).'" aria-required="true"></textarea></p>');
    } else {
        $comments_args = array(
        // change the title of send button
        'title_reply'=> esc_html__('Leave a reply', 'ceris'),
        'fields' => apply_filters( 'comment_form_default_fields', array(
                'author' => '<p class="comment-form-author"><label for="author">'.esc_html__('Name', 'ceris').' <span class="required">*</span></label><input id="author" name="author" type="text" size="30" placeholder="'.esc_html__( 'Name *', 'ceris' ).'" maxlength="245" ' .  $aria_req . ' /></p><!--',
                'email' => '--><p class="comment-form-email"><label for="email">'.esc_html__('Email', 'ceris').' <span class="required">*</span></label><input id="email" name="email" size="30" maxlength="100" placeholder="'.esc_html__( 'Email *', 'ceris' ).'" type="text" '. $aria_req .' /></p><!--',
                'url' => '--><p class="comment-form-url"><label for="url">'.esc_html__('Website', 'ceris').'</label><input id="url" name="url" size="30" maxlength="200" type="text"></p>') ),
        'id_submit' => 'comment-submit',
        'label_submit' => esc_html__('Post Comment', 'ceris'),
        // redefine your own textarea (the comment body)
        'comment_field' => '<p class="comment-form-comment"><label for="comment">'.esc_html__( 'Comment', 'ceris' ).'</label><textarea id="comment" name="comment" cols="45" rows="8" placeholder="'.esc_html__( 'Your comment', 'ceris' ).'" aria-required="true"></textarea></p>');
    }
	
	//if we have no comments than we don't a second title, one is enough
	if ( !have_comments() ){
		$comments_args['title_reply'] = esc_html__('Leave a reply', 'ceris');
	}
	
    comment_form($comments_args); ?>
    </div><!-- #comments .comments-area -->
    <?php
    if( in_array($finalPostLayout, $fwlayoutArray)) {?>
        	</div><!-- .container -->
        </div><!-- Comments section -->
    <?php
    }else { ?>
        </div> <!-- End Comment Box -->
    <?php
    }
?>