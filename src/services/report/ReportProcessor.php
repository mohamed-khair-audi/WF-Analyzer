<?php
if (!defined('ABSPATH')) {
    exit;
}

class ReportProcessor {
    public function generate_html_report(array $report): string {
        $data = $report['data']['attributes'] ?? [];
        $report_url = $report['data']['links']['report_url'] ?? '#';

        ob_start();
        ?>
        <div class="gtmetrix-report">
            <h2>GTmetrix Testergebnis</h2>
            <p><strong>GTmetrix Score:</strong> <?= esc_html($data['gtmetrix_score'] ?? 'N/A'); ?></p>
            <p><strong>Performance Score:</strong> <?= esc_html($data['performance_score'] ?? 'N/A'); ?></p>
            <p><strong>Structure Score:</strong> <?= esc_html($data['structure_score'] ?? 'N/A'); ?></p>
            <p><strong>Fully Loaded Time:</strong> <?= esc_html(($data['fully_loaded_time'] ?? 'N/A') . ' ms'); ?></p>
            <p><strong>Report Link:</strong> <a href="<?= esc_url($report_url); ?>" target="_blank">GTmetrix Report ansehen</a></p>
        </div>
        <?php
        return ob_get_clean();
    }
}
