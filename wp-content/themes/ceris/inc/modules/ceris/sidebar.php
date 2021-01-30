<?php
if (!class_exists('atbs_ceris_sidebar')) {
    class atbs_ceris_sidebar {
        
        function render($sidebarID) {
            ob_start();
            ?>
            <?php dynamic_sidebar( $sidebarID);?>
            <?php return ob_get_clean();
        }
        
    }
}