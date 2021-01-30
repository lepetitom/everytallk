<?php
if (!class_exists('ceris_about_module')) {
    class ceris_about_module {
        public function render( $page_info ) {
            $ceris_option = ceris_core::bk_get_global_var('ceris_option');
            $about_title     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_about_title', true );
            $about_img = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_about_img', true );
            $about_signature = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_about_signature', true );
            $about_social = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_about_social', true );
            $about_link = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_about_link', true );
            $about_bio = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_about_bio', true );
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            
            //Check Margin
            $moduleConfigs['module_custom_spacing_option'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_module_custom_spacing_option', true );
            if($moduleConfigs['module_custom_spacing_option'] == 'disable'){
                $blockMarginTopClass = '';
            }else{
                //Spacing Between Elements
                $moduleConfigs['module_margin_top'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_module_margin_top', true );
                $moduleConfigs['heading_margin_bottom'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_margin_bottom', true );
                
                if($moduleConfigs['module_margin_top'] < 0) :
                    $blockMarginTopClass = 'atbs-custom-margin-top-minus-'.abs($moduleConfigs['module_margin_top']);
                elseif(($moduleConfigs['module_margin_top'] > 0)) :
                    $blockMarginTopClass = 'atbs-custom-margin-top-'.abs($moduleConfigs['module_margin_top']);
                else:
                    $blockMarginTopClass = '';
                endif;
            }
            
            $moduleConfigs['module_custom_spacing_option'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_module_custom_spacing_option', true );
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = $moduleConfigs['custom_class'].' ';
            }else {
                $moduleCustomClass = '';
            }
            
            ?>
            <!-- About Module -->
            <div class="atbs-ceris-block atbs-ceris-block--fullwidth ceris-about-module atbs-ceris-block-custom-margin <?php if($moduleCustomClass != '') { echo esc_attr($moduleCustomClass); }?> <?php if($blockMarginTopClass != '') {echo esc_attr($blockMarginTopClass);}?>">
                <div class="container">
                    <div class="about__inner">
            
                        <div class="about__content flexbox">
                            <div class="about__thumbnail">
                                <div class="background-img" style="background: url('<?php echo esc_url($about_img);?>');"></div>
                                <a href="<?php echo esc_url($about_link);?>" class="link-overlay"></a>
                            </div>
            
                            <div class="about__text flexbox__item ">
                                <h3 class="about__title  typescale-4 font-weight-7"><a href="<?php echo esc_url($about_link);?>"><?php echo esc_html($about_title);?></a></h3>
                                <div class="about__bio">
                                    <?php echo esc_html($about_bio);?>
                                </div>
                                <div class="about-signature">
                                    <img src="<?php echo esc_url($about_signature);?>" alt="<?php esc_html_e('about signature','ceris');?>">
                                </div>
                            </div>
            
                        </div>
                    </div>
                </div>
            </div>
            <!-- End About Module -->
            <?php
    	}    
    }
}