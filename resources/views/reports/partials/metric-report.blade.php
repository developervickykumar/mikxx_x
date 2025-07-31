<h5>Metric Report</h5>
<ul class="list-group mb-3">
    <li class="list-group-item">Total Submissions: {{ rand(100, 500) }}</li>
    <li class="list-group-item">Views: {{ rand(1000, 5000) }}</li>
    <li class="list-group-item">Shared: {{ rand(50, 300) }}</li>
    <li class="list-group-item">Completed: {{ rand(70, 400) }}</li>
    <li class="list-group-item">Unique Users: {{ rand(200, 800) }}</li>
    <li class="list-group-item">Avg Time: {{ rand(1, 10) }} min</li>
</ul>
<canvas id="metricChart" height="100"></canvas>
<script>
    new Chart(document.getElementById('metricChart'), {
        type: 'bar',
        data: {
            labels: ['Submissions', 'Views', 'Shared', 'Completed', 'Users', 'Avg Time'],
            datasets: [{
                label: 'Metrics',
                data: [120, 3400, 180, 220, 600, 6],
                backgroundColor: '#6366f1'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>