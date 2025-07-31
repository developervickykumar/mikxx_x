<h5>Time Comparison Report</h5>
<ul class="list-group mb-3">
    <li class="list-group-item">Today</li>
    <li class="list-group-item">Yesterday</li>
    <li class="list-group-item">Week over Week</li>
    <li class="list-group-item">Month over Month</li>
    <li class="list-group-item">Date Range Comparison</li>
</ul>
<canvas id="timeCompChart" height="100"></canvas>
<script>
    new Chart(document.getElementById('timeCompChart'), {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
            datasets: [
                {
                    label: 'This Week',
                    data: [50, 60, 70, 65, 80],
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99,102,241,0.1)',
                    tension: 0.4
                },
                {
                    label: 'Last Week',
                    data: [40, 55, 60, 50, 70],
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245,158,11,0.1)',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>