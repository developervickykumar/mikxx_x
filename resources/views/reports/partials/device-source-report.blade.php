<h5>Device Source Report</h5>
<ul class="list-group mb-3">
    <li class="list-group-item">Android Mobile</li>
    <li class="list-group-item">iOS Mobile</li>
    <li class="list-group-item">Other Mobile</li>
    <li class="list-group-item">Desktop</li>
</ul>
<canvas id="deviceChart" height="100"></canvas>
<script>
    new Chart(document.getElementById('deviceChart'), {
        type: 'bar',
        data: {
            labels: ['Android', 'iOS', 'Other', 'Desktop'],
            datasets: [{
                label: 'Devices',
                data: [200, 80, 40, 100],
                backgroundColor: ['#3b82f6', '#f59e0b', '#10b981', '#6366f1']
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>