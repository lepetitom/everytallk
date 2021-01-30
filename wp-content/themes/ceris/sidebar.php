<?php $ceris_option = ceris_core::bk_get_global_var('ceris_option');?>
    <?php            
        if (is_front_page()) {
            dynamic_sidebar('home_sidebar');
        }else if(is_single()){
            if (strlen($sidebar)) {
                dynamic_sidebar($sidebar);
            }else {
                dynamic_sidebar('home_sidebar');
            }
        }else if(is_category()) {
            if(isset($ceris_option['category-page-sidebar'])) {
                $sidebar = $ceris_option['category-page-sidebar'];
            }else {
                $sidebar = '';
            }
            if (strlen($sidebar)) {
                dynamic_sidebar($sidebar);
            }else {
                dynamic_sidebar('home_sidebar');
            }
        }else if (is_author()){
            if(isset($ceris_option['author-page-sidebar'])) {
                $sidebar = $ceris_option['author-page-sidebar'];
            }else {
                $sidebar = '';
            }
            if (strlen($sidebar)) {
                dynamic_sidebar($sidebar);
            }else {
                dynamic_sidebar('home_sidebar');
            }
        }else if (is_archive()) {
            if(isset($ceris_option['archive-page-sidebar'])) {
                $sidebar = $ceris_option['archive-page-sidebar'];
            }else {
                $sidebar = '';
            }
            if (strlen($sidebar)) {
                dynamic_sidebar($sidebar);
            }else {
                dynamic_sidebar('home_sidebar');
            }
        }else if (is_search()) {
            if(isset($ceris_option['search-page-sidebar'])) {
                $sidebar = $ceris_option['search-page-sidebar'];
            }else {
                $sidebar = '';
            }
            if (strlen($sidebar)) {
                dynamic_sidebar($sidebar);
            }else {
                dynamic_sidebar('home_sidebar');
            }
        }else {
            wp_reset_postdata();
            if (is_page_template('blog.php')) {
                if(isset($ceris_option['blog-page-sidebar'])) {
                    $sidebar = $ceris_option['blog-page-sidebar'];
                }else {
                    $sidebar = '';
                }
                if (strlen($sidebar)) {
                    dynamic_sidebar($sidebar);
                }else {
                    dynamic_sidebar('home_sidebar');
                }
            }else {                     
                dynamic_sidebar('home_sidebar');
            }
        }
    ?>  	
<!--</home sidebar widget>-->