<?php
    $postID = get_the_ID();
    $ceris_option = ceris_core::bk_get_global_var('ceris_option');
    
    $reviewCheck = get_post_meta($postID,'bk_performance_review_checkbox',true);
    $readerReviewData = array();
    $isReviewFormVisible = '';
    $readerReviewIDs = array();
    
    if($reviewCheck != 1) :
        return '';
    endif;
    
    $readerReviewIDs = get_post_meta( $postID, 'atbs_reader_review_IDs', true );
    if((is_user_logged_in())) {
        $userID = get_current_user_id();
        if( is_array($readerReviewIDs) && ($readerReviewIDs != '') && in_array(intval($userID), $readerReviewIDs)) {
            $isReviewFormVisible = 'hidden-form';
            $readerReviewData = get_post_meta( $postID, 'atbs_reader_review_DATA-'.$userID, true );
        }
    }else {
        $userID = '';
    }
    $reviewBoxTitle = ceris_core::bk_get_theme_option('reader_review_box_title');
    ?>
    <div class="ceris-reviews-section">
        <div class="reviews-title">
            <h3 class="heading-title"><?php echo esc_html($reviewBoxTitle);?></h3>
        </div>
        <div class="reviews-content">
            <div class="reviews-score">
                <div class="reviews-score-list">
    <?php
    $reviewCriterias = get_post_meta($postID,'bk_performance_review_score_criteria_group',true);
    if(is_array($reviewCriterias) && (count($reviewCriterias) > 0)) {
        foreach($reviewCriterias as $reviewCriteria) :
            if (isset($reviewCriteria['review_criteria_title']) && (isset($reviewCriteria['review_criteria_score']))) :
            ?>
            <div class="score-item" data-total="<?php echo esc_html($reviewCriteria['review_criteria_score']*10);?>">
                <div class="score-text">
                    <span class="score-name"><?php echo esc_html($reviewCriteria['review_criteria_title']);?></span>
                    <span class="score-number"><?php echo esc_html($reviewCriteria['review_criteria_score']);?></span>
                </div>
                <div class="score-value">
                    <span class="score-percent"></span>
                </div>
            </div>
            <?php
            endif;
        endforeach;
    }
    ?>
                </div>
            </div>
            <?php $readerReviewCheck = get_post_meta($postID,'bk_reader_review_checkbox',true);?>
            <?php if (($readerReviewCheck != 0) && ($readerReviewCheck != '')):?>
            <div class="ceris-user-review-wrap">
                <div class="reviews-rating <?php echo esc_attr($isReviewFormVisible);?>" <?php if((is_user_logged_in())) {echo 'data-userid="'.get_current_user_id().'" data-postid="'.esc_attr($postID).'"';}?>>
                    <?php if (is_array($readerReviewIDs) && (count($readerReviewIDs) > 0)):?>
                    <div class="reviews-score-average">
                        <span class="score-average-title"><?php esc_html_e('User Reviews','ceris');?></span>
                        <div class="score-average-content-wrap">
                            <?php 
                                $totalScore = 0;                        
                                foreach($readerReviewIDs as $readerReviewID) :
                                    $userReviewData = get_post_meta( $postID, 'atbs_reader_review_DATA-'.$readerReviewID, true );                            
                                    $totalScore += round($userReviewData['user_star_rating'], 1);
                                endforeach;
                                $userStarsAverage = round($totalScore/(count($readerReviewIDs)), 1);
                                echo '<div class="score-average-number">'.esc_html($userStarsAverage).'/<span>5</span></div>';
                            ?>
                            <ul class="stars-list">                    
                            <?php                                                                                                                                                                                                
                                $starCounting = 1;
                                for($starCounting = 1; $starCounting <= 5; $starCounting++) {
                                    if($starCounting <= $userStarsAverage) {
                                        echo '<li class="star-item star-full"><i class="mdicon mdicon-star"></i></li>';
                                    }else {
                                        $deltaStar =  $userStarsAverage - (int) $userStarsAverage;  // .7
                                        if(($deltaStar > 0) && ($deltaStar < 1)) {
                                            echo '<li class="star-item star-half"><i class="mdicon mdicon-star"></i></li>';
                                            $userStarsAverage = 0;
                                        }else {
                                             echo '<li class="star-item"><i class="mdicon mdicon-star"></i></li>';
                                        }
                                    }
                                }
                            ?>
                            </ul>                                                                
                            <span class="score-average-counter">(<?php echo count($readerReviewIDs).' '; echo esc_html_e('reviews', 'ceris');?>)</span>
                        </div>
                    </div>
                    <?php endif;?>
                    <?php if((is_user_logged_in())) { ?>
                        <label <?php if((is_user_logged_in())) { echo 'for="btn-open-form-rating-'.$postID.'"';}?> class="btn-open-form-rating ceris-noselect">
                            <?php echo esc_html('Add Your Review', 'ceris');?>
                        </label>
                    <?php }else {?>
                        <?php echo '<a class="btn-open-form-rating" href="#login-modal" data-toggle="modal" data-target="#login-modal">';?>
                        <span <?php if((is_user_logged_in())) { echo 'for="btn-open-form-rating-'.$postID.'"';}?> class="ceris-noselect">
                            <?php echo esc_html('Add Your Review', 'ceris');?>
                        </span>
                        <?php echo '</a>';?>
                    <?php }?>
                    
                    <input type="checkbox" <?php if((is_user_logged_in())) { echo 'id="btn-open-form-rating-'.$postID.'"';}?> class="toggle-btn-open-form-rating" name="btn-open-form-rating" value="Review Product">
                    <div class="rating-frame">
                        <div class="rating-title">
                            <?php if(isset($ceris_option['reader_review_heading']) && ($ceris_option['reader_review_heading'] != '')) {?>
                                <h3 class="heading-title"><?php echo esc_html($ceris_option['reader_review_heading'])?></h3>
                            <?php }else {?>
                                <h3 class="heading-title"><?php esc_html_e('Your Review', 'ceris');?></h3>
                            <?php }?>
                            <?php if(isset($ceris_option['reader_review_sub_heading']) && ($ceris_option['reader_review_sub_heading'] != '')) {?>
                                <div class="heading-excerpt">
                                    <?php echo esc_html($ceris_option['reader_review_sub_heading'])?>
                                </div>
                            <?php }?>
                        </div>
                        <div class="rating-content">
                            <form method="post" class="rating-form">
                                <p class="rating-star">
                                    <span class="stars-label"><?php esc_html_e('Rate the product','ceris');?></span>
                                    <span class="stars-list">
                                        <span class="star-item"><i class="mdicon mdicon-star_border"></i></span>
                                        <span class="star-item"><i class="mdicon mdicon-star_border"></i></span>
                                        <span class="star-item"><i class="mdicon mdicon-star_border"></i></span>
                                        <span class="star-item"><i class="mdicon mdicon-star_border"></i></span>
                                        <span class="star-item"><i class="mdicon mdicon-star_border"></i></span>
                                    </span>
                                </p>
                                <input name="user-star-rating" class="user-star-rating ceris-field-invisible" value="1"/>
                                <p class="rating-name">
                                    <input type="text" class="field-input" placeholder="Review Title" name="user-review-title" required>
                                </p>
                                <p class="rating-content">
                                    <textarea class="field-input" placeholder="Write Your Review" name="user-review-content" required></textarea>
                                </p>
                                <p class="rating-submit">
                                    <input name="submit" type="submit" class="submit field-submit field-submit-reviews" value="Post Review">
                                    <i class="mdicon mdicon--last mdicon-spinner2"></i>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
                $readerReviewIDsReverse = array();
                $userReviewCount = 2;
                if(is_array($readerReviewIDs) && count($readerReviewIDs)) : ?>
                <div class="ceris-user-reviews ceris-user-reviews-rating" data-user-review-count="<?php echo esc_attr($userReviewCount);?>">
                    <div class="user-reviews__inner">
                        <div class="user-reviews-title">
                            <h3 class="heading-title"><?php esc_html_e('User Reviews','ceris');?></h3>
                        </div>
                        <div class="user-reviews-content">
                            <div class="user-reviews-list">
                                <?php
                                    $readerReviewIDsReverse = array_reverse($readerReviewIDs);
                                    foreach($readerReviewIDsReverse as $arrayKey => $readerReviewID) :
                                        echo ceris_single::bk_get_user_review_on_article($postID, $readerReviewID);
                                        if($arrayKey == ($userReviewCount - 1)) {
                                            break;
                                        }
                                    endforeach;
                                ?>
                            </div>
                            <?php 
                                $maxPages = (count($readerReviewIDs) / $userReviewCount);
                                $deltaMaxPages = $maxPages - intval($maxPages);
                                if($deltaMaxPages > 0) {
                                    $finalMaxPages= intval($maxPages) + 1;
                                }else {
                                    $finalMaxPages = intval($maxPages);
                                }
                                $paginationClass = ' ceris-user-review-pagination';
                                if($finalMaxPages > 1):
                                    echo ceris_ajax_function::ajax_pagination($finalMaxPages, $paginationClass);
                                endif;
                            ?>
                        </div>
                    </div>
                </div>
                <?php else :?>
                <div class="ceris-user-reviews ceris-user-reviews-rating" data-user-review-count="<?php echo esc_attr($userReviewCount);?>">
                    <div class="user-reviews__inner">
                        <div class="user-reviews-title">
                            <h3 class="heading-title text-center" style="font-weight: 400;"><?php echo esc_html('Be the first one review on this article', 'ceris');?></h3>
                        </div>
                        <div class="user-reviews-content">
                            <div class="user-reviews-list">
                            </div>
                        </div>
                    </div>
                </div>
            
                <?php endif;?>
            </div> <!-- .ceris-user-review-wrap --->
            <?php endif;?>
        </div>
        <?php 
        $confirmation_box_title = $ceris_option['confirmation_box_title'];
        $confirmation_box_text = $ceris_option['confirmation_box_text'];
        ?>
        <div class="ceris-user-review-popup-notification">
            <div class="popup-content-wrap">
                <div class="popup-heading-icon">
                    <div class="circle-loader">
                      <div class="checkmark draw"></div>
                    </div>
                </div>
                <div class="popup-heading-wrap">
                    <h3><?php echo esc_html($confirmation_box_title);?></h3>
                    <div class="popup-content">
                        <p><?php echo esc_html($confirmation_box_text);?></p>
                        <div class="btn-close-review-popup">
                            <span>Ok</span>
                        </div>
                    </div>
                </div>
                <div class="btn-close-review-normal">
                    <span>X</span>
                </div>
            </div>
        </div>
        <div class="review-popup-backdrop"></div>        
    </div><!-- End Review Section -->