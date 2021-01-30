<?php
if (!class_exists('ceris_category_tile')) {
    class ceris_category_tile {
        
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
            }else {
                $bgStyle = '';
            }
            ?>
            <div class="category-item cat-<?php echo trim($catID);?> <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
                <h3 class="category-name"><a href="<?php echo get_category_link( $catID )?>"><?php echo get_cat_name($catID);?></a></h3>
                <div class="category--wrap">
                    <div class="category-description">
                        <?php if((isset($postAttr['description'])) && (isset($postAttr['description']) != '')) echo '<div class="category-tile__description">'. $postAttr['description'] .'</div>';?>
                    </div>
                    <div class="category-read-more">
                        <a href="<?php echo get_category_link( $catID )?>"> <?php esc_html_e('Learn More', 'ceris'); ?> <i class="mdicon mdicon-arrow_forward"></i></a>
                    </div>
                </div>
            </div>
            <?php return ob_get_clean();
        }
    }
}