<?php if(!is_404()) :?>
<?php $ceris_option = ceris_core::bk_get_global_var('ceris_option');?>
<?php $cerisWcnt[] = isset($ceris_option['bk-wcount-per-min']) ? $ceris_option['bk-wcount-per-min'] : 130;?>
<?php
    $infinityScrolling  = $ceris_option['single-sections-infinity-scrolling'] ? $ceris_option['single-sections-infinity-scrolling'] : 0;
    if(($infinityScrolling != '') || ($infinityScrolling != 0)):    
        if(isset($ceris_option['bk-current-reading-popup-sw']) && ($ceris_option['bk-current-reading-popup-sw'] != 0)) {
            if(is_single()){
                get_template_part( 'library/templates/single/next-article-popup');
            }
        }
    endif;    
?>
<?php
    if (isset($ceris_option) && ($ceris_option != '')): 
        $bkFooterTemplate = $ceris_option['bk-footer-template'];
    else :
        $bkFooterTemplate = 'default';
    endif;
    if ($bkFooterTemplate == 'default') {
        get_template_part( 'library/templates/footer/partials/default', '10' );
    }elseif ($bkFooterTemplate == 'footer-1') {
        get_template_part( 'library/templates/footer/partials/footer', '1' );
    }elseif ($bkFooterTemplate == 'footer-2') {
        get_template_part( 'library/templates/footer/partials/footer', '2' );
    }elseif ($bkFooterTemplate == 'footer-3') {
        get_template_part( 'library/templates/footer/partials/footer', '3' );
    }elseif ($bkFooterTemplate == 'footer-4') {
        get_template_part( 'library/templates/footer/partials/footer', '4' );
    }elseif ($bkFooterTemplate == 'footer-5') {
        get_template_part( 'library/templates/footer/partials/footer', '5' );
    }elseif ($bkFooterTemplate == 'footer-6') {
        get_template_part( 'library/templates/footer/partials/footer', '6' );
    }elseif ($bkFooterTemplate == 'footer-7') {
        get_template_part( 'library/templates/footer/partials/footer', '7' );
    }elseif ($bkFooterTemplate == 'footer-8') {
        get_template_part( 'library/templates/footer/partials/footer', '8' );
    }
?>
</div><!-- .site-wrapper -->
<?php
    ceris_core::ceris_create_ajax_security_code();
    ceris_core::ceris_wcount_cal($cerisWcnt);
?>
<?php endif; //End if is_404?>

<?php wp_footer(); ?>

</body>
</html>