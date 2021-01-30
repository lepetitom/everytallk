<div class="bookmark__buttons-wrap bookmark-for-user" data-userid="<?php echo get_current_user_id();?>" data-postID="<?php echo get_the_ID();?>">
    <div class="post__button-remove-bookmark post__button-bookmark-option">
        <span class="button-bookmark-option">
            <svg class="svgIcon-use" width="25" height="25">
                <path d="M5 12.5c0 .552.195 1.023.586 1.414.39.39.862.586 1.414.586.552 0 1.023-.195 1.414-.586.39-.39.586-.862.586-1.414 0-.552-.195-1.023-.586-1.414A1.927 1.927 0 0 0 7 10.5c-.552 0-1.023.195-1.414.586-.39.39-.586.862-.586 1.414zm5.617 0c0 .552.196 1.023.586 1.414.391.39.863.586 1.414.586.552 0 1.023-.195 1.414-.586.39-.39.586-.862.586-1.414 0-.552-.195-1.023-.586-1.414a1.927 1.927 0 0 0-1.414-.586c-.551 0-1.023.195-1.414.586-.39.39-.586.862-.586 1.414zm5.6 0c0 .552.195 1.023.586 1.414.39.39.868.586 1.432.586.551 0 1.023-.195 1.413-.586.391-.39.587-.862.587-1.414 0-.552-.196-1.023-.587-1.414a1.927 1.927 0 0 0-1.413-.586c-.565 0-1.042.195-1.432.586-.39.39-.586.862-.587 1.414z" fill-rule="evenodd"></path>
            </svg>
        </span>
        <div class="button-bookmark-option-content--wrap">
            <div class="button-bookmark-option-content">
                <div class="option-item">
                    <span class="remove-bookmark ceris-dismiss-item ceris-remove-dismiss"><?php esc_html_e('Remove from the dismiss list', 'ceris');?></span>
                </div>
            </div>
        </div>
    </div>
</div> 