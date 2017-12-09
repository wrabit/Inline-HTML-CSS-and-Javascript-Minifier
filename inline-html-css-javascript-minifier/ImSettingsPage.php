<?php

class ImSettingsPage {
    /*
     *
     */
    private $options;

    /**
     * Start up
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action('admin_init', array($this, 'page_init'));
    }

    /**
     * Add options page
     */
    public function add_plugin_page() {
        // Will appear under "Settings"
        add_options_page(
            'Settings Admin',
            'Inline Html CSS & Javascript Minifier',
            'manage_options',
            'inline-html-css-javascript-minifier-settings',
            array($this, 'create_admin_page')
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page() {
        // Set class property
        $this->options = get_option('im_options');
        ?>
        <div class="wrap">
            <h1>Inline Html CSS &amp; Javascript Minifier</h1>
            <form method="post" action="options.php">
                <?php
                    // This pronts out all hidden setting fields
                    settings_fields('my_option_group');
                    do_settings_sections('inline-html-css-javascript-minifier-settings');
                    submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init() {

        register_setting(
            'my_option_group',
            'im_options',
            array($this,'sanatize')
        );

        add_settings_section(
            'main_settings', // id
            'Choose what gets minified',   // title
            array($this,'print_setting_info'), // callback
            'inline-html-css-javascript-minifier-settings' // page
        );

        add_settings_field(
            'html', // id
            'HTML', // title
            array($this,'checkbox_html'), // callback
            'inline-html-css-javascript-minifier-settings', // page
            'main_settings' // section
        );
        add_settings_field(
            'css', // id
            'CSS', // title
            array($this,'checkbox_css'), // callback
            'inline-html-css-javascript-minifier-settings', // page
            'main_settings' // section
        );
        add_settings_field(
            'javascript', // id
            'Javascript', // title
            array($this,'checkbox_javascript'), // callback
            'inline-html-css-javascript-minifier-settings', // page
            'main_settings' // section
        );

    }

    /**
     * Santize each setting field as needed
     */
    public function sanitize($input) {

        $new_input = array();
        if( isset($input['id_number']) )
            $new_input['id_number'] = absint($input['id_number']);

        if( isset($input['title']) )
            $new_input['title'] = sanitize_text_field($input['title']);

        return $new_input;

    }

    /**
     * Print the section text
     */
    public function print_setting_info() {
        //print 'Enter your settings below:';
    }

    /**
     * Get the settings options array and print one of its values
     */
    public function checkbox_html() {
        printf(
            '<input type="checkbox" id="html" name="im_options[html]" value="1" %s />',
            isset($this->options['html']) && intval($this->options['html']) === 1 ? 'checked="checked"' : ''
        );
    }
    public function checkbox_css() {
        printf(
            '<input type="checkbox" id="css" name="im_options[css]" value="1" %s />',
            isset($this->options['css']) && intval($this->options['css']) === 1 ? 'checked="checked"' : ''
        );
    }
    public function checkbox_javascript() {
        printf(
            '<input type="checkbox" id="javascript" name="im_options[javascript]" value="1" %s />',
            isset($this->options['javascript']) && intval($this->options['javascript']) === 1 ? 'checked="checked"' : ''
        );
    }

}
