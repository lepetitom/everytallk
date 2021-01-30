<?php
if (!class_exists('ceris_shortcode')) {
    class ceris_shortcode {
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_shortcode-');
            $i=0;
            
            $moduleConfigs['shortcode']         = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_shortcode', true );
            
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            $moduleCustomClass = '';
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = ' '.$moduleConfigs['custom_class'];
            }else {
                $moduleCustomClass = '';
            }
            $shortcodes = explode("[shortcode_separator]",$moduleConfigs['shortcode']);

            //Check Margin
            $moduleConfigs['module_custom_spacing_option'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_module_custom_spacing_option', true );
            if($moduleConfigs['module_custom_spacing_option'] == 'disable'){
                $blockMarginTopClass = '';
            }else{
                //Spacing Between Elements
                $moduleConfigs['module_margin_top'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_module_margin_top', true );
                if($moduleConfigs['module_margin_top'] < 0) :
                    $blockMarginTopClass = 'atbs-custom-margin-top-minus-'.abs($moduleConfigs['module_margin_top']);
                elseif(($moduleConfigs['module_margin_top'] > 0)) :
                    $blockMarginTopClass = 'atbs-custom-margin-top-'.abs($moduleConfigs['module_margin_top']);
                else:
                    $blockMarginTopClass = '';
                endif;
            }
            $blockOpen  = '';
            if (substr( $page_info['block_prefix'], 0, 10 ) == 'bk_has_rsb') {
                $blockOpen .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block-custom-margin atbs-ceris-shortcode-module '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
                $blockOpen .= ceris_core::bk_render_block_heading_has_sidebar($page_info);
                $blockClose = '</div><!-- .atbs-ceris-block -->';                       
            }else {
                $blockOpen .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block--fullwidth atbs-ceris-block-custom-margin atbs-ceris-shortcode-module '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
                $blockOpen .= ceris_core::bk_render_block_heading($page_info);
                $blockOpen .= '<div class="container">';
                $blockClose = '</div><!-- .container --></div><!-- .atbs-ceris-block -->';
            }
            
            $block_str .= $blockOpen; 
            
            for ($i=0; $i< count($shortcodes); $i++) {
                $block_str .= do_shortcode($shortcodes[$i]);
            }
            $block_str .= $blockClose;

            return $block_str;
    	}
        
    }
}