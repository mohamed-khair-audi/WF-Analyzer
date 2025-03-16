const charts = {};

charts.chartPageSpeed = createChart('chartPageSpeed', 0, 100, '%'); // GTmetrix Score
charts.chartPerformance = createChart('chartPerformance', 0, 100, '%'); // Performance Score
charts.chartStructure = createChart('chartStructure', 0, 100, '%'); // Structure Score
charts.chartLoadTime = createChart('chartLoadTime', 0, 10, 's', false); // Fully Loaded Time
charts.chartLCP = createChart('chartLCP', 0, 10, 's', false); // Largest Contentful Paint
charts.chartTTFB = createChart('chartTTFB', 0, 5, 's', false); // Time to First Byte
 
// Function to update the chart's y value with animation
function updateChartValue(chartInstance, newValue) {
    chartInstance.series(0).points(0).options({ y: newValue });
}


function updateChartValues(data) {
    updateChartValue(charts.chartPageSpeed, data.gtmetrix_score);
    updateChartValue(charts.chartPerformance, data.performance_score);
    updateChartValue(charts.chartStructure, data.structure_score);
    updateChartValue(charts.chartLoadTime, data.fully_loaded_time);
    updateChartValue(charts.chartLCP, data.largest_contentful_paint);
    updateChartValue(charts.chartTTFB, data.time_to_first_byte);
}


function createChart(containerId, value, maxValue, label, isPositiveOnHighValue = true) {
    return JSC.chart(containerId, { 
        debug: false, 
        type: 'gauge', 
        animation_duration: 1500, // Animation duration for smooth transition
        legend_visible: false, 
        xAxis: { spacingPercentage: 0.35}, 
        yAxis: { 
          defaultTick: { 
            padding: -5, 
            label_style_fontSize: '12px'
          }, 
          line: { 
            width: 9, 
            color: 'smartPalette', 
            breaks_gap: 0.07 
          }, 
          scale_range: [0, maxValue] 
        }, 
        palette: { 
          pointValue: `{%value/${maxValue}}`, 
          colors: isPositiveOnHighValue ? ['red', 'red', 'red', 'yellow',  'green'] : ['green', 'yellow', 'red', 'red',  'red']
        }, 
        defaultTooltip_enabled: false, 
        defaultSeries: { 
          angle: { sweep: 200 }, 
          shape: { 
            innerSize: '65%', 
            label: { 
              text: `<span color="%color">{%sum:n1}</span><span color="#696969" fontSize="20px"> ${label}</span>`,
              style_fontSize: '50px', 
              verticalAlign: 'middle'
            } 
          } 
        }, 
        series: [ 
          { 
            type: 'column roundcaps', 
            points: [{ id: '1', x: 'speed', y: value }] // Start at 0
          } 
        ] 
    })
}