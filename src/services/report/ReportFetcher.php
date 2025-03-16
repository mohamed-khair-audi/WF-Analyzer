<?php
if (!defined('ABSPATH')) {
    exit;
}

class ReportFetcher {
    private WF_Analyzer_API_Handler $api;

    public function __construct(WF_Analyzer_API_Handler $api) {
        $this->api = $api;
    }

    public function fetch_report(string $test_id): array|WP_Error {
        $response = $this->api->check_status($test_id);
        if (is_wp_error($response)) {
            return $response;
        }

        if ($response['data']['type'] !== 'report') {
            return new WP_Error('not_ready', 'Der Bericht ist noch nicht verfügbar.');
        }

        return $response;
    }

    public function fetch_screenshot(string $reportId) {
        
       $response = $this->api->get_screenshot($reportId);
      
        return $response;
    }
}
