<!-- Schema meta -->
<?php
    if(!is_single()) {
        return '';
    }
    global $post;
    $ceris_option = ceris_core::bk_get_global_var('ceris_option');
    $schemaSW = isset($ceris_option['bk-wp-schema-meta']) ? $ceris_option['bk-wp-schema-meta'] : 1;
    if($schemaSW != 1) {
        return;
    }
    $postID = get_the_ID();
    $post_slug = get_post_field( 'post_name', get_post() );
    $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $postID ), 'full' );
    $bkEntryTeaser      = '';
    
    $reviewScore = 0;
    $reviewCheck = get_post_meta($postID,'bk_review_checkbox',true);
    if($reviewCheck == 1) :
        $reviewScore = get_post_meta($postID,'bk_review_score',true);
        $productName = get_post_meta($postID,'bk_review_box_title',true);
        $reviewSummary = get_post_meta($postID,'bk_review_summary',true);
    endif;
    
    $bk_logo_url = '';
    $logo_src[0] = '';
    if ((isset($ceris_option['bk-logo'])) && (($ceris_option['bk-logo']) != NULL)){ 
        $bk_logo = $ceris_option['bk-logo'];
        if (($bk_logo != null) && (array_key_exists('url',$bk_logo)) && ($bk_logo['url'] != '')) {
            $bk_logo_url = $bk_logo['url'];
            $logo_attachment_id = attachment_url_to_postid( $bk_logo_url );
            $logo_src = wp_get_attachment_image_src( $logo_attachment_id, 'full' );
        }
    }
    
    $bk_author_name = get_the_author_meta('display_name', $post->post_author);
    
    $bk_publisher_name = get_bloginfo('name');
    if (empty($bk_publisher_name)){
        $bk_publisher_name = $bk_author_name;
    }
    
?>
<?php
    $reviewCheck = get_post_meta($postID,'bk_review_checkbox',true);
    if($reviewCheck != 1) :?>
        <script type="application/ld+json">
    {
          "@context": "http://schema.org",
          "@type": "NewsArticle",
          "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "<?php echo esc_url(get_permalink($postID))?>"
          },
          "headline": "<?php echo get_the_title($postID);?>",
          "image": [
            "<?php echo esc_url($thumbnail_src[0]);?>"
           ],
          "datePublished": "<?php echo date(DATE_W3C, get_the_time('U', $postID));?>",
          "dateModified": "<?php echo the_modified_date('c', '', '', false);?>",
          "author": {
            "@type": "Person",
            "name": "<?php echo esc_attr($bk_author_name);?>"
          },
           "publisher": {
            "@type": "Organization",
            "name": "<?php echo esc_attr($bk_publisher_name);?>",
            "logo": {
              "@type": "ImageObject",
              "url": "<?php echo esc_url($logo_src[0]);?>"
            }
          },
          "description": "<?php echo esc_html($bkEntryTeaser);?>"
        }
        </script>
    <?php else:?>
        <script type="application/ld+json">
    {
          "@context": "http://schema.org/",
          "@type": "Review",
          "itemReviewed": {
            "@type" : "Product",
            "name"  : "<?php echo esc_attr($productName);?>",
            "description": "<?php echo esc_html($reviewSummary);?>",
            "image" : "<?php echo esc_url($thumbnail_src[0]);?>",
            "sku"   : "<?php echo esc_attr($post_slug);?>",
            "mpn"   : "<?php echo esc_url(get_permalink($postID))?>",
            "brand" : {
                "@type" : "Organization",
                "name"  : "<?php bloginfo('name');?>"
            },
            "aggregateRating" : {
                "@type": "AggregateRating",
                "ratingValue" : "<?php echo esc_attr($reviewScore);?>",
                "ratingCount" : "1",
                "bestRating"  : "10",
                "worstRating" : "1"
            }
          },
          "author": {
            "@type": "Person",
            "name": "<?php echo esc_attr($bk_author_name);?>"
          },
          "reviewRating": {
            "@type": "Rating",
            "ratingValue": "<?php echo esc_attr($reviewScore);?>",
            "bestRating": "10",
            "worstRating": "1"
          },
          "publisher": {
            "@type": "Organization",
            "name": "<?php echo esc_attr($bk_publisher_name);?>"
          }
        }
        </script>
    <?php endif;
?>