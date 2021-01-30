<?php
if (!class_exists('atbs_ceris_category_tile')) {
    class atbs_ceris_category_tile {
        
        function render($postAttr) {
            ob_start();
            if(isset($postAttr['catID'])) {
                $catID = intval($postAttr['catID']);
            }else {
                return ob_get_clean();
            }
            $imageID = get_term_meta( $catID, 'bk_category_feat_img', false );
            if((!empty($imageID)) && (count($imageID) != 0) && $imageID[0] != '') {
                $bgURL = wp_get_attachment_image_src( $imageID[0], $postAttr['thumbSize'] );
                
            }else {
                $bgURL = '';
            }
            if(isset($bgURL[0]) && ($bgURL[0] != '')) {
                $bgStyle = 'style="background-image: url('. "'" .esc_url($bgURL[0]). "'" . ');"';
                $img = '<img src="'.esc_url($bgURL[0]).'" alt="bg-0" />';
            }else {
                $bgStyle = '';
                $img = '';
            }
            ?>
            <div class="category-tile cat-<?php echo trim($catID);?> <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
                <div class="category-tile__wrap">
                    <div class="background-img category-title-image">
                    <?php echo ceris_core::ceris_html_render($img); ?>               
                    <?php if((isset($postAttr['description'])) && (isset($postAttr['description']) != '')) echo '<div class="category-tile__description">'. $postAttr['description'] .'</div>';?>
                    </div>
                    <div class="category-tile__inner">
                        <div class="category-tile__text">
                            <div class="category-tile__name"><?php echo get_cat_name($catID);?></div>
                        </div>
                    </div>
                    <a href="<?php echo get_category_link( $catID )?>" class="link-overlay" title="<?php esc_html_e('View all','ceris') ?>"></a>
                </div>
            </div>

            <?php return ob_get_clean();
        }
        
    }
}