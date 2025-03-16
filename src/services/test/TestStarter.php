<?php
if (!defined('ABSPATH')) {
    exit;
}

class TestStarter {
    private WF_Analyzer_API_Handler $api;

    public function __construct(WF_Analyzer_API_Handler $api) {
        $this->api = $api;
    }

    public function start_test(string $url): string|WP_Error {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return new WP_Error('invalid_url', 'Die eingegebene URL ist ungültig.');
        }

        $response = $this->api->start_test($url);
        if (is_wp_error($response)) {
            return $response;
        }

        $test_id = $response['data']['id'] ?? null;
        if (!$test_id) {
            return new WP_Error('invalid_response', 'GTmetrix hat keine Test-ID zurückgegeben.');
        }

        return $test_id;
    }
}
