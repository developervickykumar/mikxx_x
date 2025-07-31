<div class="modal-body">
    <h5 class="mb-3">Food Order Summary</h5>
    <table class="table table-bordered">
        <tbody>
            <tr><th class="text-end pe-3">Dish</th><td>{{ $data['dish_name'] ?? '' }}</td></tr>
            <tr><th class="text-end pe-3">Cuisine</th><td>{{ $data['cuisine_type'] ?? '' }}</td></tr>
            <tr><th class="text-end pe-3">Spice Level</th><td>{{ $data['spice_level'] ?? '' }}</td></tr>
            <tr><th class="text-end pe-3">Add-ons</th><td>{{ $data['addons'] ?? '' }}</td></tr>
            <tr><th class="text-end pe-3">Total Price</th><td>{{ $data['total_price'] ?? '' }}</td></tr>
        </tbody>
    </table>
</div>