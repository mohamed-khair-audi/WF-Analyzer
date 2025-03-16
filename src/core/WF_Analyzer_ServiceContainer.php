<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class WF_Analyzer_ServiceContainer {
    private array $instances = [];

    public function get(string $class) {
        if (!isset($this->instances[$class])) {
            switch ($class) {
                case 'api':
                    $this->instances[$class] = new WF_Analyzer_API_Handler(get_option('wf_analyzer_api_key'));
                    break;
                case 'starter':
                    $this->instances[$class] = new TestStarter($this->get('api'));
                    break;
                case 'monitor':
                    $this->instances[$class] = new TestMonitor($this->get('api'));
                    break;
                case 'fetcher':
                    $this->instances[$class] = new ReportFetcher($this->get('api'));
                    break;
                case 'processor':
                    $this->instances[$class] = new ReportProcessor();
                    break;
                default:
                    error_log("[WF_Analyzer] Unbekannter Service: $class");
                    return null;
            }
        }
        return $this->instances[$class];
    }
}
