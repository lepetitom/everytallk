<?php
if (!function_exists('bk_demo_config_options')) {
    function bk_demo_config_options(){
        $count = 0;
        $bk_theme_demos = array();
        for($count = 1; $count <= BK_DEMO_COUNT; $count++) {
            $bk_theme_demos['demo_'.$count] = array (
                 'class' => 'demo_'.$count,
                 'title' => 'Ceris (Main Demo)',
                 'img'   => BK_AD_PLUGIN_URL . 'demo_content/demo_'.$count.'/screenshot.png',
            );
            switch($count) {
                case(1):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Ceris (Main Demo)';
                    break;
                case(2):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Game';
                    break;
                case(3):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Architecture';
                    break;
                case(4):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Fitness';
                    break;
                case(5):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Technology';
                    break;
                case(6):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Minimal';
                    break;
                case(7):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Lifestyle';
                    break;
                case(8):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Sport';
                    break;
                case(9):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Interior';
                    break;
                case(10):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Resort';
                    break;
                case(11):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Cultures';
                    break;
                case(12):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Salon';
                    break;
                case(13):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Business';
                    break;
                case(14):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Food';
                    break;
                case(15):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Newspaper';
                    break;
                case(16):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Travel';
                    break;
                case(17):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Fashion';
                    break;
                case(18):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Music';
                    break;
                case(19):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Coffee';
                    break;
                case(20):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Art';
                    break;
                case(21):
                    $bk_theme_demos['demo_'.$count]['title'] = 'News';
                    break;
                case(22):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Portfolio';
                    break;
                case(23):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Photography';
                    break;
                case(24):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Minimal Personal';
                    break;
                case(25):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Photography v2';
                    break;
                case(26):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Nature';
                    break;
                case(27):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Health';
                    break;
                case(28):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Garden';
                    break;
                case(29):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Entertainment';
                    break;
                case(30):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Science';
                    break;
                case(31):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Racing';
                    break;
                case(32):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Spa';
                    break;
                case(33):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Construct';
                    break;
                case(34):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Cyberpunk';
                    break;
                case(35):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Basketball';
                    break;
                case(36):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Inspiration';
                    break;
                case(37):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Cafe';
                    break;
                case(38):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Baby';
                    break;
                case(39):
                    $bk_theme_demos['demo_'.$count]['title'] = 'FBlog';
                    break;
                case(40):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Urban Art';
                    break;
                case(41):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Boxing';
                    break;
                case(42):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Men Magazine';
                    break;
                case(43):
                    $bk_theme_demos['demo_'.$count]['title'] = 'Daily News';
                    break;
            }
        }
            
        $import_source = array();
        for($count = 1; $count <= BK_DEMO_COUNT; $count++) {
            $import_source['demo_'.$count] = array (
                'content'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/content.xml',
                'widgets'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/widgets.wie',
                'theme_options' => BK_AD_PLUGIN_DIR . 'demo_content/demo_'.$count.'/theme_options.json',
            );
        }  
        wp_localize_script( 'bkadscript', 'import_source', $import_source );
        return $bk_theme_demos;        
    }        
}    