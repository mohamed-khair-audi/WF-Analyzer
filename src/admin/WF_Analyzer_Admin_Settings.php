<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handles plugin admin settings page.
 */
class WF_Analyzer_Admin_Settings {
    public function __construct() {
        add_action('admin_menu', [$this, 'register_settings_page']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function register_settings_page() {
        add_options_page(
            'WF Analyzer Einstellungen',
            'WF Analyzer',
            'manage_options',
            'wf-analyzer-settings',
            [$this, 'render_settings_page']
        );
    }

    public function register_settings() {
        register_setting('wf_analyzer_settings_group', 'wf_analyzer_api_key', ['sanitize_callback' => 'sanitize_text_field']);
        $this->register_test_settings();
    }

    private function register_test_settings() {
        $settings = [
            'wf_analyzer_default_location',
            'wf_analyzer_default_browser',
            'wf_analyzer_default_connection',
            'wf_analyzer_enable_video',
        ];
        foreach ($settings as $setting) {
            register_setting('wf_analyzer_settings_group', $setting, ['sanitize_callback' => 'sanitize_text_field']);
        }
    }

    public function render_settings_page() {
        $template = plugin_dir_path(__FILE__) . '../../templates/admin-settings.php';
        if (file_exists($template)) {
            include $template;
        } else {
            echo '<div class="notice notice-error"><p>Template Datei nicht gefunden.</p></div>';
        }
    }

    public static function render_options($option_name, $options) {
        $selected_value = get_option($option_name);
        foreach ($options as $key => $label) {
            echo '<option value="' . esc_attr($key) . '" ' . selected($selected_value, $key, false) . '>' . esc_html($label) . '</option>';
        }
    }

    public static function get_locations() {
        return ['1' => 'Vancouver, Canada', '2' => 'London, UK'];
    }

    public static function get_browsers() {
        return ['chrome' => 'Chrome', 'firefox' => 'Firefox'];
    }

    public static function get_connections() {
        return ['native' => 'Keine Drosselung (Native)', 'DSL' => 'DSL (1.5 Mbps/384 Kbps)'];
    }
}

// Initialize the settings page
new WF_Analyzer_Admin_Settings();
