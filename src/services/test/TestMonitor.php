<?php
if (!defined('ABSPATH')) {
    exit;
}

class TestMonitor {
    private WF_Analyzer_API_Handler $api;

    public function __construct(WF_Analyzer_API_Handler $api) {
        $this->api = $api;
    }

    public function check_status(string $test_id): array|WP_Error {
        $response = $this->api->check_status($test_id);
        if (is_wp_error($response)) {
            return $response;
        }

        $status = $response['data']['attributes']['state'] ?? 'unknown';

        if ($status === 'queued' || $status === 'started') {
            return ['pending' => true, 'status' => $status, 'message' => 'Test läuft noch. Bitte warten...'];
        }

        if ($response['data']['type'] !== 'report') {
            return new WP_Error('invalid_status', 'GTmetrix API hat einen unerwarteten Status zurückgegeben.');
        }

        return $response;
    }
}
