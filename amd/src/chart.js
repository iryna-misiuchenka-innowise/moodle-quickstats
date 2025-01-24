// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This plugin provides access to Moodle data in form of analytics and reports in real time.
 *
 *
 * @package   quickstats
 * @copyright Copyright (c) 2025 Innowise (https://innowise.com)
 * @license   http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */

// Configure RequireJS to load Chart.js from a CDN
require.config({
    paths: {
        'quickstats/chartjs': 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min'
    }
});

// Define the module
define(['jquery', 'quickstats/chartjs'], function($, Chart) {
    return {
        init: function() {
            const chartContainer = $('#quickstats-chart');

            if (!chartContainer.length) {
                return;
            }

            const chartData = chartContainer.data('chart-data');

            const ctx = document.createElement('canvas');
            chartContainer.append(ctx);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.map(item => item.time),
                    datasets: [{
                        label: 'Active Users',
                        data: chartData.map(item => item.count),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {title: {display: true, text: 'Date'}},
                        y: {title: {display: true, text: 'Users'}},
                    }
                }
            });
        }
    };
});