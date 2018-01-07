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
        add_action('admin_menu', array($this, 'inline_hcjm_add_plugin_page'));
        add_action('admin_init', array($this, 'inline_hcjm_page_init'));
    }

    /**
     * Add options page
     */
    public function inline_hcjm_add_plugin_page() {
        // Will appear under "Settings"
        add_options_page(
            'Settings Admin',
            'Inline Html CSS & Javascript Minifier',
            'manage_options',
            'inline-html-css-javascript-minifier-settings',
            array($this, 'inline_hcjm_create_admin_page')
        );
    }

    /**
     * Options page callback
     */
    public function inline_hcjm_create_admin_page() {
        // Set class property
        $this->options = get_option('inline_hcjm_options');
        ?>
        <div class="wrap">
            <h1>Inline Html CSS &amp; Javascript Minifier</h1>
            <form method="post" action="options.php">
                <?php
                    // This pronts out all hidden setting fields
                    settings_fields('inline_hcjm_option_group');
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
    public function inline_hcjm_page_init() {

        register_setting(
            'inline_hcjm_option_group',
            'inline_hcjm_options',
            array($this,'sanatize')
        );

        add_settings_section(
            'main_settings', // id
            'Choose what gets minified',   // title
            array($this,'inline_hcjm_print_setting_info'), // callback
            'inline-html-css-javascript-minifier-settings' // page
        );

        add_settings_field(
            'html', // id
            'HTML', // title
            array($this,'inline_hcjm_checkbox_html'), // callback
            'inline-html-css-javascript-minifier-settings', // page
            'main_settings' // section
        );
        add_settings_field(
            'css', // id
            'CSS', // title
            array($this,'inline_hcjm_checkbox_css'), // callback
            'inline-html-css-javascript-minifier-settings', // page
            'main_settings' // section
        );
        add_settings_field(
            'javascript', // id
            'Javascript', // title
            array($this,'inline_hcjm_checkbox_javascript'), // callback
            'inline-html-css-javascript-minifier-settings', // page
            'main_settings' // section
        );

    }

    /**
     * Print the section text
     */
    public function inline_hcjm_print_setting_info() {
        //print 'Enter your settings below:';
    }

    /**
     * Get the settings options array and print one of its values
     */
    public function inline_hcjm_checkbox_html() {
        pc::Debug($this->options, 'optionssss');
        printf(
            '<input type="checkbox" id="html" name="inline_hcjm_options[html]" value="1" %s />',
            isset($this->options['html']) && intval($this->options['html']) === 1 ? 'checked="checked"' : ''
        );
    }
    public function inline_hcjm_checkbox_css() {
        printf(
            '<input type="checkbox" id="css" name="inline_hcjm_options[css]" value="1" %s />',
            isset($this->options['css']) && intval($this->options['css']) === 1 ? 'checked="checked"' : ''
        );
    }
    public function inline_hcjm_checkbox_javascript() {
        printf(
            '<input type="checkbox" id="javascript" name="inline_hcjm_options[javascript]" value="1" %s />',
            isset($this->options['javascript']) && intval($this->options['javascript']) === 1 ? 'checked="checked"' : ''
        );
    }

}
