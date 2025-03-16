<?php if (!defined('ABSPATH')) exit; ?>

<div class="wrap">
    <h1>WF Analyzer Einstellungen</h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('wf_analyzer_settings_group');
        do_settings_sections('wf-analyzer-settings');
        ?>
        <h2>API Einstellungen</h2>
        <table class="form-table">
            <tr>
                <th scope="row">GTmetrix API Key</th>
                <td>
                    <input type="text" name="wf_analyzer_api_key" value="<?php echo esc_attr(get_option('wf_analyzer_api_key')); ?>" class="regular-text">
                </td>
            </tr>
        </table>

        <h2>Standard Testparameter</h2>
        <table class="form-table">
            <tr>
                <th scope="row">Standort</th>
                <td>
                    <select name="wf_analyzer_default_location">
                        <?php WF_Analyzer_Admin_Settings::render_options('wf_analyzer_default_location', WF_Analyzer_Admin_Settings::get_locations()); ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">Browser</th>
                <td>
                    <select name="wf_analyzer_default_browser">
                        <?php WF_Analyzer_Admin_Settings::render_options('wf_analyzer_default_browser', WF_Analyzer_Admin_Settings::get_browsers()); ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">Verbindungsgeschwindigkeit</th>
                <td>
                    <select name="wf_analyzer_default_connection">
                        <?php WF_Analyzer_Admin_Settings::render_options('wf_analyzer_default_connection', WF_Analyzer_Admin_Settings::get_connections()); ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">Videoaufzeichnung aktivieren</th>
                <td><input type="checkbox" name="wf_analyzer_enable_video" value="1" <?php checked(get_option('wf_analyzer_enable_video'), 1); ?>></td>
            </tr>
        </table>

        <?php submit_button(); ?>
    </form>
</div>
