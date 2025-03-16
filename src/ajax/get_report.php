<?php

add_action('wp_ajax_wf_get_report', 'wf_get_report');
add_action('wp_ajax_nopriv_wf_get_report', 'wf_get_report');

function wf_get_report() {
    check_ajax_referer('wf_analyzer_nonce', 'security');

    $container = new WF_Analyzer_ServiceContainer();
    $monitor = $container->get('monitor');
    $fetcher = $container->get('fetcher');
    $processor = $container->get('processor');

    $test_id = $_POST['test_id'] ?? '';
    if (!$test_id) {
        wp_send_json_error(['message' => 'Test ID ist erforderlich.']);
    }

    if( get_transient( 'wf_' . $test_id )) {
        wp_send_json_success(get_transient( 'wf_' . $test_id ));
    }

    $status = $monitor->check_status($test_id);
    if (is_wp_error($status)) {
        wp_send_json_error(['message' => $status->get_error_message()]);
    }

    if (!empty($status['pending'])) {
        wp_send_json_success($status);
    }

    $report = $fetcher->fetch_report($test_id);
    if (is_wp_error($report)) {
        wp_send_json_error(['message' => $report->get_error_message()]);
    }




    $html = $processor->generate_html_report($report);

    $attr = $report['data']['attributes'];

    // Nur die relevanten Werte extrahieren und in ein sauberes Array packen
    $report_data = [
        'gtmetrix_score'           => $attr['gtmetrix_score'] ?? 1,
        'performance_score'        => $attr['performance_score'] ?? 0,
        'structure_score'          => $attr['structure_score'] ?? 0,
        'fully_loaded_time'        => isset($attr['fully_loaded_time']) ? $attr['fully_loaded_time'] / 1000 : 0, // ms → s
        'largest_contentful_paint' => isset($attr['largest_contentful_paint']) ? $attr['largest_contentful_paint'] / 1000 : 0, // ms → s
        'time_to_first_byte'       => isset($attr['time_to_first_byte']) ? $attr['time_to_first_byte'] / 1000 : 0 // ms → s
    ];

    $report_id = $report['data']['id'];

    $report_screenshot = $fetcher->fetch_screenshot($report_id);

    if (is_wp_error($report_screenshot)) {
        wp_send_json_error(['message' => 'Fehler beim Abrufen des Screenshots.']);
    }

    $report_data['base64_screen_shot'] = !is_wp_error($report_screenshot) ? base64_encode($report_screenshot) : ''; 

    set_transient('wf_' . $test_id, $report_data, 100 * 60);

    wp_send_json_success($report_data);

}
