<div class="modal-body">
    <h5 class="mb-3">Service Summary</h5>
    <table class="table table-bordered">
        <tbody>
            <tr><th class="text-end pe-3">Service Name</th><td>{{ $data['service_name'] ?? '' }}</td></tr>
            <tr><th class="text-end pe-3">Provider</th><td>{{ $data['provider_name'] ?? '' }}</td></tr>
            <tr><th class="text-end pe-3">Duration</th><td>{{ $data['duration'] ?? '' }}</td></tr>
            <tr><th class="text-end pe-3">Charges</th><td>{{ $data['charges'] ?? '' }}</td></tr>
            <tr><th class="text-end pe-3">Booking Date</th><td>{{ $data['booking_date'] ?? '' }}</td></tr>
        </tbody>
    </table>
</div>