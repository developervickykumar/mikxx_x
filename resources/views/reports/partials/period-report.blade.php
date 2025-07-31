<h5>Period Report</h5>
<ul class="list-group mb-3">
    <li class="list-group-item">Daily</li>
    <li class="list-group-item">Weekly</li>
    <li class="list-group-item">Monthly</li>
    <li class="list-group-item">Date Range</li>
</ul>
<canvas id="periodChart" height="100"></canvas>
<script>
    new Chart(document.getElementById('periodChart'), {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
            datasets: [{
                label: 'Submissions',
                data: [10, 20, 30, 25, 35],
                borderColor: '#3b82f6',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>