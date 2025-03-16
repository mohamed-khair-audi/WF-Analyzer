<?php
/**
 * Plugin Name: WF Analyzer
 * Plugin URI: https://yourwebsite.com
 * Description: Ein Plugin zur Analyse von Webseiten mit GTmetrix, PDF-Generierung und E-Mail-Berichten.
 * Version: 1.0.0
 * Author: Mohamed Audi
 * License: GPL2
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'src/_src.php';

require 'plugin-update-checker-4.11/plugin-update-checker.php';
$updateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/mohamed-khair-audi/WF-Analyzer.git',
    __FILE__,
    'wf-analyzer'
);
$updateChecker->setBranch('master');
