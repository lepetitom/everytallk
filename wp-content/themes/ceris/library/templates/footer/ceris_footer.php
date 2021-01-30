<?php
if (!class_exists('ceris_footer')) {
    class ceris_footer {
        static function bk_footer_mailchimp(){
            $ceris_option = ceris_core::bk_get_global_var('ceris_option');
            $htmlOutput = '';
			
            if(isset($ceris_option['footer-mailchimp--shortcode']) && ($ceris_option['footer-mailchimp--shortcode'] != '')) :
    			$htmlOutput .= do_shortcode($ceris_option['footer-mailchimp--shortcode']);
            endif;
            
            return $htmlOutput;
        }
        
    } // Close ceris_single
    
}