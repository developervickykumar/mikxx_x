<h5>Lead Source Report</h5>
<ul class="list-group mb-3">
    <li class="list-group-item">Website</li>
    <li class="list-group-item">Affiliate</li>
    <li class="list-group-item">Mikxx</li>
    <li class="list-group-item">Whatsapp</li>
    <li class="list-group-item">Facebook</li>
    <li class="list-group-item">Google</li>
    <li class="list-group-item">Instagram</li>
    <li class="list-group-item">Others</li>
</ul>
<canvas id="leadChart" height="100"></canvas>
<script>
    new Chart(document.getElementById('leadChart'), {
        type: 'pie',
        data: {
            labels: ['Website', 'Affiliate', 'WhatsApp', 'Google'],
            datasets: [{
                label: 'Sources',
                data: [150, 50, 80, 120],
                backgroundColor: ['#6366f1', '#10b981', '#f59e0b', '#ef4444']
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>