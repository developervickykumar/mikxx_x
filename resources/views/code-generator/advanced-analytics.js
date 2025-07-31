// Advanced Analytics and Visualization Components
const AdvancedAnalytics = {
    // Configuration
    config: {
        chartColors: [
            '#4e79a7', '#f28e2c', '#e15759', '#76b7b2', '#59a14f',
            '#edc949', '#af7aa1', '#ff9da7', '#9c755f', '#bab0ab'
        ],
        chartOptions: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 1000
            }
        }
    },

    // Initialize charts and visualizations
    init() {
        this.initFunnelChart();
        this.initRetentionChart();
        this.initHeatmap();
        this.initUserFlow();
        this.initCustomReports();
    },

    // Funnel Analysis
    initFunnelChart() {
        const funnelData = {
            labels: ['Visits', 'Sign-ups', 'Onboarding', 'Active Users', 'Retained Users'],
            datasets: [{
                data: [1000, 800, 600, 400, 200],
                backgroundColor: this.config.chartColors
            }]
        };

        const ctx = document.getElementById('funnel-chart').getContext('2d');
        new Chart(ctx, {
            type: 'funnel',
            data: funnelData,
            options: {
                ...this.config.chartOptions,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                const value = context.raw;
                                const total = context.dataset.data[0];
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    },

    // Retention Analysis
    initRetentionChart() {
        const retentionData = {
            labels: ['Day 1', 'Day 7', 'Day 14', 'Day 30', 'Day 60', 'Day 90'],
            datasets: [{
                label: 'Retention Rate',
                data: [100, 75, 60, 45, 35, 30],
                borderColor: this.config.chartColors[0],
                fill: false
            }]
        };

        const ctx = document.getElementById('retention-chart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: retentionData,
            options: {
                ...this.config.chartOptions,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        title: {
                            display: true,
                            text: 'Retention Rate (%)'
                        }
                    }
                }
            }
        });
    },

    // Heatmap Analysis
    initHeatmap() {
        const heatmapData = {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'User Activity',
                data: Array(7).fill().map(() => Array(24).fill().map(() => Math.random() * 100)),
                backgroundColor: (context) => {
                    const value = context.dataset.data[context.dataIndex];
                    const alpha = value / 100;
                    return `rgba(255, 99, 132, ${alpha})`;
                }
            }]
        };

        const ctx = document.getElementById('heatmap-chart').getContext('2d');
        new Chart(ctx, {
            type: 'matrix',
            data: heatmapData,
            options: {
                ...this.config.chartOptions,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                const value = context.dataset.data[context.dataIndex];
                                return `Activity: ${value.toFixed(1)}%`;
                            }
                        }
                    }
                }
            }
        });
    },

    // User Flow Analysis
    initUserFlow() {
        const userFlowData = {
            nodes: [
                { id: 'home', label: 'Home' },
                { id: 'signup', label: 'Sign Up' },
                { id: 'dashboard', label: 'Dashboard' },
                { id: 'profile', label: 'Profile' },
                { id: 'settings', label: 'Settings' }
            ],
            edges: [
                { from: 'home', to: 'signup', value: 500 },
                { from: 'signup', to: 'dashboard', value: 400 },
                { from: 'dashboard', to: 'profile', value: 200 },
                { from: 'dashboard', to: 'settings', value: 150 }
            ]
        };

        const container = document.getElementById('user-flow-chart');
        const network = new vis.Network(container, userFlowData, {
            nodes: {
                shape: 'dot',
                size: 20
            },
            edges: {
                arrows: 'to',
                width: 2
            },
            physics: {
                stabilization: true
            }
        });
    },

    // Custom Reports
    initCustomReports() {
        const reportTemplates = {
            userEngagement: {
                title: 'User Engagement Report',
                metrics: ['DAU', 'MAU', 'Session Duration', 'Pages per Session'],
                chartType: 'line'
            },
            conversion: {
                title: 'Conversion Report',
                metrics: ['Sign-up Rate', 'Activation Rate', 'Retention Rate'],
                chartType: 'bar'
            },
            performance: {
                title: 'Performance Report',
                metrics: ['Load Time', 'Time to Interactive', 'First Contentful Paint'],
                chartType: 'line'
            }
        };

        // Initialize report builder
        const reportBuilder = document.getElementById('report-builder');
        Object.entries(reportTemplates).forEach(([key, template]) => {
            const option = document.createElement('option');
            option.value = key;
            option.textContent = template.title;
            reportBuilder.appendChild(option);
        });

        // Handle report generation
        reportBuilder.addEventListener('change', (e) => {
            const template = reportTemplates[e.target.value];
            this.generateReport(template);
        });
    },

    // Generate custom report
    generateReport(template) {
        const reportContainer = document.getElementById('report-container');
        reportContainer.innerHTML = '';

        // Create report header
        const header = document.createElement('h2');
        header.textContent = template.title;
        reportContainer.appendChild(header);

        // Create metrics section
        const metricsSection = document.createElement('div');
        metricsSection.className = 'metrics-section';
        template.metrics.forEach(metric => {
            const metricElement = document.createElement('div');
            metricElement.className = 'metric-card';
            metricElement.innerHTML = `
                <h3>${metric}</h3>
                <div class="metric-value">${this.getMetricValue(metric)}</div>
                <div class="metric-chart" id="${metric.toLowerCase().replace(/\s+/g, '-')}-chart"></div>
            `;
            metricsSection.appendChild(metricElement);
        });
        reportContainer.appendChild(metricsSection);

        // Initialize charts for each metric
        template.metrics.forEach(metric => {
            this.initMetricChart(metric, template.chartType);
        });
    },

    // Get metric value (mock data for demonstration)
    getMetricValue(metric) {
        const mockData = {
            'DAU': '1,234',
            'MAU': '12,345',
            'Session Duration': '5m 30s',
            'Pages per Session': '4.2',
            'Sign-up Rate': '25%',
            'Activation Rate': '60%',
            'Retention Rate': '45%',
            'Load Time': '1.2s',
            'Time to Interactive': '2.5s',
            'First Contentful Paint': '0.8s'
        };
        return mockData[metric] || 'N/A';
    },

    // Initialize chart for a specific metric
    initMetricChart(metric, chartType) {
        const ctx = document.getElementById(`${metric.toLowerCase().replace(/\s+/g, '-')}-chart`).getContext('2d');
        const data = this.generateMockData(metric);
        
        new Chart(ctx, {
            type: chartType,
            data: {
                labels: data.labels,
                datasets: [{
                    label: metric,
                    data: data.values,
                    borderColor: this.config.chartColors[0],
                    backgroundColor: this.config.chartColors[0] + '40'
                }]
            },
            options: this.config.chartOptions
        });
    },

    // Generate mock data for charts
    generateMockData(metric) {
        const labels = Array(7).fill().map((_, i) => `Day ${i + 1}`);
        const values = Array(7).fill().map(() => Math.random() * 100);
        return { labels, values };
    }
};

// Initialize advanced analytics when the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    AdvancedAnalytics.init();
}); 