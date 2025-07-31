// Graph Builder Class
class GraphBuilder {
    constructor() {
        this.chart = null;
        this.chartType = 'bar';
        this.initializeEventListeners();
    }

    initializeEventListeners() {
        // Chart type selection
        document.querySelector('.chart-type-select').addEventListener('change', (e) => {
            this.chartType = e.target.value;
            this.updateChart();
        });

        // Data source selection
        document.querySelector('.data-source-select').addEventListener('change', (e) => {
            this.updateChart();
        });
    }

    updateChart() {
        const table = document.querySelector(`#tab-${window.tableBuilder.activeTab} table`);
        const data = this.extractDataFromTable(table);
        
        if (this.chart) {
            this.chart.destroy();
        }

        const ctx = document.getElementById('chartCanvas').getContext('2d');
        this.chart = new Chart(ctx, {
            type: this.chartType,
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Data',
                    data: data.values,
                    backgroundColor: this.getRandomColors(data.values.length),
                    borderColor: this.getRandomColors(data.values.length),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    extractDataFromTable(table) {
        const rows = table.querySelectorAll('tbody tr');
        const labels = [];
        const values = [];

        rows.forEach(row => {
            const cells = row.querySelectorAll('td:not(:first-child)');
            cells.forEach((cell, index) => {
                if (index === 0) {
                    labels.push(cell.textContent || `Column ${index + 1}`);
                }
                const value = parseFloat(cell.textContent) || 0;
                values.push(value);
            });
        });

        return { labels, values };
    }

    getRandomColors(count) {
        const colors = [];
        for (let i = 0; i < count; i++) {
            colors.push(`hsl(${Math.random() * 360}, 70%, 50%)`);
        }
        return colors;
    }

    exportChart() {
        const canvas = document.getElementById('chartCanvas');
        const link = document.createElement('a');
        link.download = 'chart.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
    }
}

// Initialize graph builder when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.graphBuilder = new GraphBuilder();
}); 