<?php

class WF_Analyzer_API_Handler {
    private $api_key;
    private $api_url;

    /**
     * Constructor.
     *
     * @param string $api_key The GTmetrix API key.
     * @param string $api_url The GTmetrix API base URL.
     */
    public function __construct($api_key, $api_url = 'https://gtmetrix.com/api/2.0/') {
        if (empty($api_key)) {
            throw new InvalidArgumentException('API Key darf nicht leer sein.');
        }

        $this->api_key = $api_key;
        $this->api_url = rtrim($api_url, '/') . '/';
    }

    /**
     * Makes an API request.
     *
     * @param string $method The HTTP method (GET, POST, etc.).
     * @param string $endpoint The API endpoint.
     * @param array|null $body The request body.
     * @return array|WP_Error The API response or WP_Error on failure.
     */
    private function make_request($method, $endpoint, $body = null) {
        $args = [
            'method'  => $method,
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode($this->api_key . ':'),
                'Content-Type'  => 'application/vnd.api+json',
                'Accept'        => 'application/vnd.api+json',
            ],
            'timeout' => 30,
        ];

        if ($body) {
            $args['body'] = json_encode($body);
        }

        $response = wp_remote_request($this->api_url . $endpoint, $args);

        if (is_wp_error($response)) {
            return $response;
        }

        $content_type = wp_remote_retrieve_header($response, 'content-type');
        if (strpos($content_type, 'image/jpeg') !== false) {
            // Bilddaten zurückgeben (Binärdaten)
            return wp_remote_retrieve_body($response);
        }

        $response_body = json_decode(wp_remote_retrieve_body($response), true);

        if (isset($response_body['errors'])) {
            return new WP_Error('api_error', 'GTmetrix API Fehler: ' . $response_body['errors'][0]['title']);
        }

        return $response_body;
    }

    /**
     * Starts a GTmetrix test.
     *
     * @param string $url The URL to test.
     * @param array $options Additional test options.
     * @return array|WP_Error The test ID or WP_Error on failure.
     */
    public function start_test($url, $options = []) {
        $params = array_merge([
            'url'      => $url,
            'location' => get_option('wf_analyzer_default_location', '1'),
        ], $options);

        return $this->make_request('POST', 'tests', ["data" => ["type" => "test", "attributes" => $params]]);
    }

    /**
     * Checks the status of a GTmetrix test.
     *
     * @param string $test_id The test ID.
     * @return array|WP_Error The test status or WP_Error on failure.
     */
    public function check_status($test_id) {
        return $this->make_request('GET', 'tests/' . $test_id);
    }

    /**
     * Retrieves the report for a completed test.
     *
     * @param string $test_id The test ID.
     * @return array|WP_Error The report data or WP_Error on failure.
     */
    public function get_report($test_id) {
        return $this->make_request('GET', 'tests/' . $test_id);
    }


    public function get_screenshot($reportId) {
        return $this->make_request('GET', 'reports/' . $reportId . '/resources/screenshot.jpg');
    }
}