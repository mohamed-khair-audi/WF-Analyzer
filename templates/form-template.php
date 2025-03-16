<?php
/**
 * Template for displaying the WF Analyzer form.
 *
 * @package YourPluginName
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<div class="wf-analyzer-container">
    <h1 class="wf-analyzer-title">Website Analyzer</h1>
    <p class="wf-analyzer-description animate__animated wf-hide-after-submit">Gib die URL deiner Website ein, um eine GTmetrix-Analyse zu starten.</p>
    
    <form id="wf-analyzer-form" class="wf-analyzer-form animate__animated wf-hide-after-submit">
        <div class="wf-analyzer-form-group">
            <label for="wf-analyzer-website-url" class="wf-analyzer-label">Website-URL</label>
            <input type="url" id="wf-analyzer-website-url" name="website-url" class="wf-analyzer-input" placeholder="https://www.mohamed-audi.de" value="https://www.mohamed-audi.de" required>
        </div>
        <button type="submit" class="wf-analyzer-submit-button">Analyse starten</button>
    </form>
    <div class="d-flex">
        <div id="wf-processing-container">
            <div id="wf-lottie-container"></div>
            <div id="wf-analyzer-status">Bereit zum Starten.</div>
        </div>
        <div id="wf-analyzer-result" class="wf-analyzer-result-container wf-analyzer-hidden">
            <div id="wf-analyzer-screenshot-container">
                <img src="" id="wf-analyzer-screenshot" alt="GTMetrix Screenshot" />
            </div>
            <div id="wf-chart-container" class="chart-container wf-analyzer-hidden">
                <div class="chart-card">
                    <div class="chart" id="chartPageSpeed"></div>
                    <p>PageSpeed Score</p>
                </div>
                <div class="chart-card">
                    <div class="chart" id="chartPerformance"></div>
                    <p>Performance Score</p>
                </div>
                <div class="chart-card">
                    <div class="chart" id="chartStructure"></div>
                    <p>Structure Score</p>
                </div>
                <div class="chart-card">
                    <div class="chart" id="chartLoadTime"></div>
                    <p>Fully Loaded Time</p>
                </div>
                <div class="chart-card">
                    <div class="chart" id="chartLCP"></div>
                    <p>Largest Contentful Paint</p>
                </div>
                <div class="chart-card">
                    <div class="chart" id="chartTTFB"></div>
                    <p>Time to First Byte</p>
                </div>
            </div>
        </div>
        
     </div> 
</div>