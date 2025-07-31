<h5>Demographic Report</h5>
<ul class="list-group mb-3">
    <li class="list-group-item">Age Group: 18-24, 25-34, 35-50</li>
    <li class="list-group-item">Gender: Male, Female, Other</li>
    <li class="list-group-item">Marital Status: Single, Married</li>
    <li class="list-group-item">Location: India, USA, UK</li>
    <li class="list-group-item">Profile Type: Student, Professional</li>
</ul>
<canvas id="demographicChart" height="100"></canvas>
<script>
    new Chart(document.getElementById('demographicChart'), {
        type: 'doughnut',
        data: {
            labels: ['Male', 'Female', 'Other'],
            datasets: [{
                label: 'Gender',
                data: [45, 50, 5],
                backgroundColor: ['#6366f1', '#ec4899', '#10b981']
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>