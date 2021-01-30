<?php
$ceris_option = ceris_core::bk_get_global_var('ceris_option');
$moduleConfigs['orderby']           = 'date';
$moduleConfigs['tags']              = ceris_core::bk_get_theme_option('header-module-tags-filter') ? implode(", ",ceris_core::bk_get_theme_option('header-module-tags-filter')) : '';
$moduleConfigs['offset']            = 0;
$moduleConfigs['feature']           = ceris_core::bk_get_theme_option('header-module-featured-post-switch');
$moduleConfigs['category_id']       = implode(", ",ceris_core::bk_get_theme_option('header-module-categories-filter'));
$moduleConfigs['editor_pick']       = ceris_core::bk_get_theme_option('header-module-pick-posts');
$moduleConfigs['editor_exclude']    = ceris_core::bk_get_theme_option('header-module-exclude-posts');
$moduleConfigs['limit']             = ceris_core::bk_get_theme_option('header-module-post-limit');
$moduleConfigs['post_source']       = 'all';
$moduleConfigs['post_icon']         = '';
$theModule = new ceris_featured_slider_b;       
$the_query = bk_get_query::ceris_query($moduleConfigs);              //get query
$block_str = '';
$block_str .= '<div class="header-feature-module atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin ceris-feature-slider-b">';
$block_str .= '<div class="atbs-ceris-block__inner clearfix">';
$block_str .= '<div class="post-slider-text-align-center">';
$block_str .= $theModule->render_modules($the_query);              //render modules
$block_str .= '</div><!-- .post-slider-text-align-center -->';
$block_str .= '</div><!-- .atbs-ceris-block__inner -->';
$block_str .= '</div><!-- .atbs-ceris-block -->';
echo ceris_core::ceris_html_render($block_str);
unset($moduleConfigs);
wp_reset_postdata();