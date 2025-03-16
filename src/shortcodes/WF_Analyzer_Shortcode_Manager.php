<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Handles the WF Analyzer form shortcode.
 */
class WF_Analyzer_Shortcode_Manager {

    /**
     * Holds the scripts loader instance.
     * @var WF_Analyzer_Scripts_Loader
     */
    private $scripts_loader;

    /**
     * Constructor with dependency injection.
     *
     * @param WF_Analyzer_Scripts_Loader $scripts_loader Instance of the script loader.
     */
    public function __construct(WF_Analyzer_Scripts_Loader $scripts_loader) {
        $this->scripts_loader = $scripts_loader;
        add_shortcode('wf_analyzer_form', [$this, 'render_main_form']);
    }



    /**
     * Renders the WF Analyzer form shortcode.
     *
     * @return string The form HTML.
     */
    public function render_main_form() {
        // Load assets only when the shortcode is used
        $this->scripts_loader->enqueue_scripts();

        ob_start();
        include plugin_dir_path(__FILE__) . '../../templates/form-template.php';
        return ob_get_clean();
    }
}


$wf_scripts_loader = new WF_Analyzer_Scripts_Loader();
$wf_shortcode_manager = new WF_Analyzer_Shortcode_Manager($wf_scripts_loader);