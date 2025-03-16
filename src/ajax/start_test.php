<?php

add_action('wp_ajax_wf_start_test', 'wf_start_test');
add_action('wp_ajax_nopriv_wf_start_test', 'wf_start_test');

function wf_start_test() {
    check_ajax_referer('wf_analyzer_nonce', 'security');

    $container = new WF_Analyzer_ServiceContainer();
    $starter = $container->get('starter');

    $url = $_POST['url'] ?? '';
    if (!$url) {
        wp_send_json_error(['message' => 'Website-URL nicht vorhanden.']);
    }

    if( get_transient( urlencode($url) )) {
        wp_send_json_success(['test_id' => get_transient( urlencode($url)), 'message' => 'Test wurde erfolgreich gestartet. Bitte warten...']);
    }

    $test_id = $starter->start_test($url);
    if (is_wp_error($test_id)) {
        wp_send_json_error(['message' => $test_id->get_error_message()]);
    }

    set_transient(urlencode($url), $test_id, 100 * 60);
    wp_send_json_success(['test_id' => $test_id, 'message' => 'Test wurde erfolgreich gestartet. Bitte warten...']);
}
