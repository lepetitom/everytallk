<?php
define('CERIS_LIBS', get_template_directory().'/library/');

define('CERIS_INC', get_template_directory().'/inc/');
define('CERIS_INC_LIBS', CERIS_INC.'libs/');
define('CERIS_BLOCKS', CERIS_INC.'blocks/');
define('CERIS_MODULES', CERIS_INC.'/modules/');

define ('CERIS_TEMPLATES', CERIS_LIBS.'templates/');
define ('CERIS_AJAX', CERIS_LIBS.'/ajax/');
define ('CERIS_HEADER_TEMPLATES', CERIS_TEMPLATES.'header/');
define ('CERIS_FOOTER_TEMPLATES', CERIS_TEMPLATES.'footer/');
define ('CERIS_SINGLE_TEMPLATES', CERIS_TEMPLATES.'single/');

define ('CERIS_THEMEOPTONS', CERIS_LIBS.'theme-options/');
define ('CERIS_THEMEOPTONS_SECTIONS', CERIS_LIBS.'theme-options/sections/');
/**
 * Enqueue Style and Script Files Init Theme
 */
require_once (CERIS_INC.'bk_enqueue_scripts.php');
require_once (CERIS_INC.'bk_theme_settings.php');
require_once (CERIS_INC.'bk_woocommerce_settings.php');
require_once (CERIS_LIBS.'mega_menu.php');

/**
 * Add php library file.
 */
require_once (CERIS_LIBS.'core.php');
require_once (CERIS_LIBS.'custom_css.php');
require_once (CERIS_LIBS.'translation.php');
require_once (CERIS_INC.'bk_inc_files.php');