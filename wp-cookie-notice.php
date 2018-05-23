<?php

/*
Plugin Name: WP Cookie Notice
Plugin URI: https://github.com/asmbs/wp-cookie-notice
Description: Adds a cookie notice to a Wordpress site.
Version: 0.0.4
Author: Max McMahon
Author URI: https://github.com/maxwellmc
License: MIT
*/

class WPCookieNotice
{
    private static $_instance = null;

    /**
     * Get an instance of this class.
     *
     * @return WPCookieNotice
     */
    public static function get_instance() {
        if ( self::$_instance == null ) {
            self::$_instance = new WPCookieNotice();
        }

        return self::$_instance;
    }

    /**
     * Initialize all of the functionality.
     */
    public function init(){

        // Add the settings menu
        add_action('admin_menu', array($this, 'add_settings_menu'));

        // Add the styles
        add_action('init', array($this, 'add_styles'));

        // Add the scripts
        add_action('init', array($this, 'add_scripts'));

        // Apply action
        add_action('template_redirect', array($this, 'add_cookie_notice'));
    }

    /**
     * Add the CSS styles.
     */
    function add_styles() {
        // Register the styles
        wp_register_style( 'wpcn', plugins_url( '/css/style.css', __FILE__ ) );
        wp_enqueue_style( 'wpcn' );
    }

    /**
     * Add the JS scripts.
     */
    function add_scripts() {
        // Register the scripts
        wp_register_script( 'wpcn', plugins_url( '/js/scripts.js', __FILE__ ) );
        wp_enqueue_script( 'wpcn' );
    }

    /**
     * Add the settings page.
     */
    function add_settings_menu() {

        // Register the new settings page
        register_setting('wpcn', 'wpcn_settings' );

        // Add a section to the new settings page
        add_settings_section(
            'wpcn_section_main',
            null,
            array($this, 'wpcn_section_main_cb'),
            'wpcn'
        );

        // Add the "Notice Message" field
        add_settings_field(
            'wpcn_field_message',
            __( 'Notice Message', 'wpcn' ),
            array($this, 'wpcn_field_message_cb'),
            'wpcn',
            'wpcn_section_main',
            [
                'label_for' => 'wpcn_field_message',
            ]
        );

        // Add the "Color" field
        add_settings_field(
            'wpcn_field_color',
            __( 'Color', 'wpcn' ),
            array($this, 'wpcn_field_color_cb'),
            'wpcn',
            'wpcn_section_main',
            [
                'label_for' => 'wpcn_field_color',
            ]
        );

        // Add the new settings page to the "Settings" menu
        add_submenu_page(
            'options-general.php',
            'Cookie Notice Settings',
            'Cookie Notice',
            'manage_options',
            'wp-cookie-notice',
            array($this, 'wpcn_settings_page_html')
        );

    }

    /**
     * Callback to create the settings section title.
     *
     * @param $args
     */
    function wpcn_section_main_cb( $args ) {
        // No-op (no section title)
    }

    /**
     * Callback to create the "Notice Message" field on the settings page.
     *
     * @param $args
     */
    function wpcn_field_message_cb( $args ) {
        // Get the value of the setting we've registered with register_setting()
        $options = get_option( 'wpcn_settings' );
        // Output the field
        ?>
        <textarea id="<?php echo esc_attr( $args['label_for'] ); ?>"
                  name="wpcn_settings[<?php echo esc_attr( $args['label_for'] ); ?>]"
                  rows="4"
                  cols="50"
                  class="wpcn"
        ><?php
            if(isset($options[$args['label_for']])){
                echo esc_attr( $options[$args['label_for']] );
            }else{
                echo 'This website uses cookies. By using this site, you agree to allow us to collect information through cookies.';
            }
            ?></textarea>
        <?php
    }

    /**
     * Callback to create the "Color" field on the settings page.
     *
     * @param $args
     */
    function wpcn_field_color_cb( $args ) {
        // Get the value of the setting we've registered with register_setting()
        $options = get_option( 'wpcn_settings' );
        // Output the field
        ?>
        <select id="<?php echo esc_attr( $args['label_for'] ); ?>"
                  name="wpcn_settings[<?php echo esc_attr( $args['label_for'] ); ?>]"
                  rows="4"
                  cols="50"
                  class="wpcn"
        >
            <option value="light-blue" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'light-blue', false ) ) : ( '' ); ?>>
                <?php esc_html_e( 'Light Blue', 'wpcn' ); ?>
            </option>
            <option value="dark-blue" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'dark-blue', false ) ) : ( '' ); ?>>
                <?php esc_html_e( 'Dark Blue', 'wpcn' ); ?>
            </option>
            <option value="gray" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'gray', false ) ) : ( '' ); ?>>
                <?php esc_html_e( 'Gray', 'wpcn' ); ?>
            </option>
            <option value="green" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'green', false ) ) : ( '' ); ?>>
                <?php esc_html_e( 'Green', 'wpcn' ); ?>
            </option>
            <option value="orange" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'orange', false ) ) : ( '' ); ?>>
                <?php esc_html_e( 'Orange', 'wpcn' ); ?>
            </option>
            <option value="red" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'red', false ) ) : ( '' ); ?>>
                <?php esc_html_e( 'Red', 'wpcn' ); ?>
            </option>
        </select>
        <?php
    }

    /**
     * The HTML for the settings page.
     */
    function wpcn_settings_page_html()
    {
        // Check user capabilities
        if (!current_user_can('manage_options')) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?= esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields('wpcn');
                do_settings_sections('wpcn');
                submit_button('Save Settings');
                ?>
            </form>
        </div>
        <?php
    }

    // Adds the cookie notice to all pages for the end-user
    function add_cookie_notice() {

        if(current_user_can('manage_options')){
           return null;
        }

        $options = get_option( 'wpcn_settings' );
        if(isset($options['wpcn_field_color'])){
            $color = $options['wpcn_field_color'];
        }else{
            $color = 'gray';
        }
        $message = $options['wpcn_field_message'];

        return print <<<END
<div id="wpcn_container" class="wpcn wpcn-container wpcn-$color d-none">
    <div id="wpcn_message" class="wpcn wpcn-message">
        $message
    </div>
    <button id="wpcn_button_accept" type="button" class="wpcn wpcn-$color">Accept</button>
</div>
END;
    }

}

$WPCookieNotice = WPCookieNotice::get_instance();
$WPCookieNotice->init();
