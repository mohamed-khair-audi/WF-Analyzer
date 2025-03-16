<?php
/**
 * Handles enqueuing of scripts and styles for the plugin.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class WF_Analyzer_Scripts_Loader {

    /**
     * Class constructor: Hooks into WordPress.
     */
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'register_assets']);
    }

    /**
     * Register styles and scripts globally (without enqueuing them yet).
     */
    public function register_assets() {
        wp_register_style('wf-style', plugins_url('../../assets/prod/css/style.min.css', __FILE__));
        wp_register_style('animate-css', plugins_url('../../assets/prod/css/libs/animate.min.css', __FILE__));

        wp_register_script('chart-js', plugins_url('../../assets/prod/js/libs/chart.min.js', __FILE__), [], '3.9.1', true);
        wp_register_script('lottie-js', plugins_url('../../assets/prod/js/libs/lottiefiles.min.js', __FILE__), [], '3.9.1', true);
        wp_register_script('wf-main-js', plugins_url('../../assets/prod/js/scripts.min.js', __FILE__), ['chart-js'], null, true);
    }

    /**
     * Enqueue scripts and styles only when needed.
     */
    public function enqueue_scripts() {
        if (wp_script_is('wf-main-js', 'enqueued')) {
            return;
        }

        wp_enqueue_script('wf-main-js');
        wp_enqueue_script('chart-js');
        wp_enqueue_script('lottie-js');

        wp_enqueue_style('wf-style');
        wp_enqueue_style('animate-css');

        // Localize script with necessary variables
        $script_data = [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('wf_analyzer_nonce'),
        ];
        wp_localize_script('wf-main-js', 'wfAnalyzerVars', $script_data);
    }
}
