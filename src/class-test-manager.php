<?php
/**
 * Manages GTmetrix tests and their status.
 */
class WF_Analyzer_TestManager {
    private $api;

    /**
     * Constructor.
     *
     * @param WF_Analyzer_API_Handler $api The API handler.
     */
    public function __construct(WF_Analyzer_API_Handler $api) {
        $this->api = $api;
    }

    /**
     * Starts a GTmetrix test.
     *
     * @param string $url The URL to test.
     * @param array $options Additional test options.
     * @return string|WP_Error The test ID or WP_Error on failure.
     */
    public function run_test($url, $options = []) {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return new WP_Error('invalid_url', 'Die eingegebene URL ist ungültig.');
        }

        $response = $this->api->start_test($url, $options);

        return is_wp_error($response) ? $response : ($response['data']['id'] ?? new WP_Error('invalid_response', 'Keine Test-ID zurückgegeben.'));
    }

    /**
     * Retrieves the report ID for a completed test.
     *
     * @param string $test_id The test ID.
     * @return string|WP_Error The report ID or WP_Error on failure.
     */
    /**
     * Überprüft den Status eines Tests und gibt den Report zurück, wenn er fertig ist.
     */
    public function get_report_data() {
        
     
    
        $test_id = $_POST['test_id'] ?? '';
    
        if (empty($test_id)) {
            wp_send_json_error(['message' => 'Test ID ist erforderlich.']);
        }
    
        $response = $this->api->check_status($test_id);
        error_log("API Response for test ID $test_id: " . print_r($response, true));
    
        if (is_wp_error($response)) {
            wp_send_json_error(['message' => $response->get_error_message()]);
        }
    
        if (empty($response['data'])) {
            wp_send_json_error(['message' => 'Keine gültigen Test-Daten erhalten.']);
        }
    
        $type = $response['data']['type'] ?? 'unknown';
        $status = $response['data']['attributes']['state'] ?? 'unknown';
    
        // **Test ist noch in der Warteschlange oder läuft**
        if ($type === 'test' && ($status === 'queued' || $status === 'started')) {
            wp_send_json_success([
                'pending' => true,
                'status' => $status,
                'message' => "Test läuft noch. Status: $status"
            ]);
        }
    
        // **Test ist abgeschlossen, wir senden HTML zurück**
        if ($type === 'report') {
            $html = $this->reportGenerator->generate_html_report($response);
            wp_send_json_success([
                'pending' => false,
                'report_html' => $html
            ]);
        }
    
        // **Falls kein passender Typ, Fehler zurückgeben**
        wp_send_json_error([
            'message' => 'Unbekannter API-Typ: ' . json_encode($response)
        ]);
    }
    
    
}