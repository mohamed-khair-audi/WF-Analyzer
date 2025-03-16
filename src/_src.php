<?php 


// Define the base path of the plugin
$base_path = plugin_dir_path(__FILE__);

// Load API Handler (Core Dependency)
require_once $base_path . 'api/WF_Analyzer_API_Handler.php';

// Load the Service Container (Manages Dependencies)
require_once $base_path . 'core/WF_Analyzer_ServiceContainer.php';
require_once $base_path . 'core/WF_Analyzer_Scripts_Loader.php';

// Load WordPress-Specific Core Classes (Admin & Shortcodes)
require_once $base_path . 'admin/WF_Analyzer_Admin_Settings.php';   // Handles plugin admin settings
require_once $base_path . 'shortcodes/WF_Analyzer_Shortcode_Manager.php'; // Manages shortcodes

// Load Main Functional Classes in Correct Order
require_once $base_path . 'services/test/TestStarter.php';    // Starts a GTmetrix test
require_once $base_path . 'services/test/TestMonitor.php';    // Checks the status of the test

require_once $base_path . 'services/report/ReportFetcher.php';  // Fetches the final report
require_once $base_path . 'services/report/ReportProcessor.php'; // Processes and formats the report data

// Load AJAX Handlers (Relies on the Above Classes)
require_once $base_path . 'ajax/start_test.php'; // Handles starting a test
require_once $base_path . 'ajax/get_report.php'; // Handles fetching the report



