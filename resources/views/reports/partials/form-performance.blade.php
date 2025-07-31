<h5>Form Performance Report</h5>
<ul class="list-group mb-3">
    <li class="list-group-item">Submitted: 300</li>
    <li class="list-group-item">Viewed: 1200</li>
    <li class="list-group-item">Shared: 150</li>
    <li class="list-group-item">Incomplete: 75</li>
</ul>
<canvas id="formPerfChart" height="100"></canvas>
<script>
    new Chart(document.getElementById('formPerfChart'), {
        type: 'bar',
        data: {
            labels: ['Submitted', 'Viewed', 'Shared', 'Incomplete'],
            datasets: [{
                label: 'Performance',
                data: [300, 1200, 150, 75],
                backgroundColor: ['#10b981', '#6366f1', '#f59e0b', '#ef4444']
            }]
        },
        options: {
            responsive: true,
            indexAxis: 'y',
            plugins: { legend: { display: false } },
            scales: { x: { beginAtZero: true } }
        }
    });
</script>