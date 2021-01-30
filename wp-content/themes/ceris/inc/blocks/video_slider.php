<?php
if (!class_exists('ceris_video_slider')) {
    class ceris_video_slider {
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('ceris_video_slider-');
            $moduleConfigs['video_1']        = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_video_1', true );
            $moduleConfigs['video_img_1']        = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_video_img_1', true );
            $moduleConfigs['video_2']        = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_video_2', true );
            $moduleConfigs['video_img_2']        = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_video_img_2', true );
            $moduleConfigs['video_3']        = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_video_3', true );
            $moduleConfigs['video_img_3']        = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_video_img_3', true );
            $moduleConfigs['video_4']        = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_video_4', true );
            $moduleConfigs['video_img_4']        = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_video_img_4', true );
            $moduleConfigs['video_5']        = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_video_5', true );
            $moduleConfigs['video_img_5']        = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_video_img_5', true );
            
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = ' '.$moduleConfigs['custom_class'];
            }else {
                $moduleCustomClass = '';
            }

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
            //end Spacing Between Elements
            $blockOpen  = '';
            if (substr( $page_info['block_prefix'], 0, 10 ) == 'bk_has_rsb') {
                $blockOpen .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block-custom-margin atbs-ceris-custom-video '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
                $blockOpen .= ceris_core::bk_render_block_heading_has_sidebar($page_info);
                
                $blockClose = '</div><!-- .atbs-ceris-block -->';                       
            }else {
                $blockOpen .= '<div id="'.$moduleID.'" class="atbs-ceris-block atbs-ceris-block-custom-margin atbs-ceris-block--fullwidth atbs-ceris-custom-video '.$moduleCustomClass.' '.$blockMarginTopClass.'">';
                $blockOpen .= ceris_core::bk_render_block_heading($page_info);
                $blockOpen .= '<div class="container">';
                $blockClose = '</div><!-- .container --></div><!-- .atbs-ceris-block -->';
            }
            
            $block_str .= $blockOpen; 
            $block_str .='<div class="fotorama ceris-video-slider-wrap">';
            if($moduleConfigs['video_1'] != ''):
            $block_str .='<a href="'.esc_url($moduleConfigs['video_1']).'"  data-video="true">';
            $block_str .='<img src="'.esc_url($moduleConfigs['video_img_1']).'">';
            $block_str .='</a>';
            endif;
            if($moduleConfigs['video_2'] != ''):
            $block_str .='<a href="'.esc_url($moduleConfigs['video_2']).'"  data-video="true">';
            $block_str .='<img src="'.esc_url($moduleConfigs['video_img_2']).'">';
            $block_str .='</a>';
            endif;
            if($moduleConfigs['video_3'] != ''):
            $block_str .='<a href="'.esc_url($moduleConfigs['video_3']).'"  data-video="true">';
            $block_str .='<img src="'.esc_url($moduleConfigs['video_img_3']).'">';
            $block_str .='</a>';
            endif;
            if($moduleConfigs['video_4'] != ''):
            $block_str .='<a href="'.esc_url($moduleConfigs['video_4']).'"  data-video="true">';
            $block_str .='<img src="'.esc_url($moduleConfigs['video_img_4']).'">';
            $block_str .='</a>';
            endif;
            if($moduleConfigs['video_5'] != ''):
            $block_str .='<a href="'.esc_url($moduleConfigs['video_5']).'"  data-video="true">';
            $block_str .='<img src="'.esc_url($moduleConfigs['video_img_5']).'">';
            $block_str .='</a>';
            endif;
            $block_str .='</div>';
            $block_str .= $blockClose;
            return $block_str;
    	}
        
    }
}