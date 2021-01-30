<?php
/**
 * Load the TGM Plugin Activator class to notify the user
 * to install the Envato WordPress Toolkit Plugin
 */
require_once( get_template_directory() . '/inc/class-tgm-plugin-activation.php' );
function ceris_tgmpa_register_toolkit() {
    // Specify the Envato Toolkit plugin
    $plugins = array(
        array(
            'name' => esc_html__('BKNinja Composer', 'ceris'),
            'slug' => esc_html__('bkninja-composer', 'ceris'),
            'img' => get_template_directory_uri() . '/images/plugins/bkninja-composer.jpg',
            'source' => get_template_directory() . '/plugins/bkninja-composer.zip',
            'required' => true,
            'version' => '3.0',
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('Social Login WordPress Plugin - AccessPress Social Login Lite', 'ceris'),
            'slug' => 'accesspress-social-login-lite',
            'img' => get_template_directory_uri() . '/images/plugins/social-login.jpg',
            'version' => '',
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('Meta Box', 'ceris'),
            'slug' => 'meta-box',
            'img' => get_template_directory_uri() . '/images/plugins/meta-box.jpg',
            'required' => true,
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),   
        array(
            'name' => esc_html__('MB Term Meta', 'ceris'),
            'slug' => esc_html__('mb-term-meta', 'ceris'),
            'img' => get_template_directory_uri() . '/images/plugins/Term-Meta.jpg',
            'source' => get_template_directory() . '/plugins/mb-term-meta.zip',
            'required' => true,
            'version' => '1.2.9',
            'external_url' => '',
        ),   
        array(
            'name' => esc_html__('Meta Box Conditional Logic', 'ceris'),
            'slug' => esc_html__('meta-box-conditional-logic', 'ceris'),
            'img' => get_template_directory_uri() . '/images/plugins/Conditional-Logic.jpg',
            'source' => get_template_directory() . '/plugins/meta-box-conditional-logic.zip',
            'required' => true,
            'version' => '1.6.13',
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('Meta Box Group', 'ceris'),
            'slug' => esc_html__('meta-box-group', 'ceris'),
            'img' => get_template_directory_uri() . '/images/plugins/metabox-group.jpg',
            'source' => get_template_directory() . '/plugins/meta-box-group.zip',
            'required' => true,
            'version' => '1.3.11',
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('Ceris Extension', 'ceris'),
            'slug' => esc_html__('ceris-extension', 'ceris'),
            'img' => get_template_directory_uri() . '/images/plugins/ceris-extension.jpg',
            'source' => get_template_directory() . '/plugins/ceris-extension.zip',
            'version' => '3.3',
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('Login With Ajax', 'ceris'),
            'slug' => 'login-with-ajax',
            'img' => get_template_directory_uri() . '/images/plugins/login-with-ajax.jpg',
            'version' => '',
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('MailChimp for WordPress', 'ceris'),
            'slug' => 'mailchimp-for-wp',
            'img' => get_template_directory_uri() . '/images/plugins/mailchimp.jpg',
            'version' => '',
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('Classic Editor', 'ceris'),
            'slug' => 'classic-editor',
            'img' => get_template_directory_uri() . '/images/plugins/classic-editor.jpg',
            'required' => '',
            'version' => '',
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('Ceris Sidebar Generator', 'ceris'),
            'slug' => 'ceris-sidebar-generator',
            'img' => get_template_directory_uri() . '/images/plugins/sidebar-generator.jpg',
            'source' => get_template_directory() . '/plugins/ceris-sidebar-generator.zip',
            'version' => '',
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('Contact Form 7', 'ceris'),
            'slug' => 'contact-form-7',
            'title' => esc_html__('Contact Form 7 - Optional', 'ceris'),
            'img' => get_template_directory_uri() . '/images/plugins/contact-form-7.jpg',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        
        array(
            'name' => esc_html__('WPForms', 'ceris'),
            'slug' => 'wpforms-lite',
            'title' => esc_html__('WPForms - Optional', 'ceris'),
            'img' => get_template_directory_uri() . '/images/plugins/wpforms.png',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        
        array(
            'name' => esc_html__('Ceris Admin Panel', 'ceris'),
            'slug' => 'ceris-admin-panel',
            'title' => esc_html__('TNM Admin Panel - Optional', 'ceris'),
            'source' => get_template_directory() . '/plugins/ceris-admin-panel.zip',
            'required' => false,
            'version' => '1.4',
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        
    );
     
    // Configuration of TGM
    $config = array(
        'domain'           => 'ceris',
        'default_path'     => '',
        'menu'             => 'install-required-plugins',
        'has_notices'      => true,
        'is_automatic'     => true,
        'message'          => '',
        'strings'          => array(
            'page_title'                      => esc_html__( 'Install Required Plugins', 'ceris' ),
            'menu_title'                      => esc_html__( 'Install Plugins', 'ceris' ),
            'installing'                      => esc_html__( 'Installing Plugin: %s', 'ceris' ),
            'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'ceris' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'ceris' ),
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'ceris' ),
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'ceris' ),
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'ceris' ),
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'ceris' ),
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'ceris' ),
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'ceris' ),
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'ceris' ),
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'ceris' ),
            'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'ceris' ),
            'return'                          => esc_html__( 'Return to Required Plugins Installer', 'ceris' ),
            'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'ceris' ),
            'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'ceris' ),
            'nag_type'                        => 'updated'
        )
    );
    tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'ceris_tgmpa_register_toolkit' );