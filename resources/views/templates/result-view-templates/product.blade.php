<div class="modal-body">
    <h5 class="mb-3">Product Summary</h5>
    <table class="table table-bordered">
        <tbody>
            <tr><th class="text-end pe-3">Product Name</th><td>{{ $data['product_name'] ?? '' }}</td></tr>
            <tr><th class="text-end pe-3">Code</th><td>{{ $data['product_code'] ?? '' }}</td></tr>
            <tr><th class="text-end pe-3">Variant</th><td>{{ $data['selected_variant'] ?? '' }}</td></tr>
            <tr><th class="text-end pe-3">Price</th><td>{{ $data['price'] ?? '' }}</td></tr>
            <tr><th class="text-end pe-3">Discount</th><td>{{ $data['discount'] ?? '' }}</td></tr>
            <tr><th class="text-end pe-3">Quantity</th><td>{{ $data['quantity'] ?? '' }}</td></tr>
            <tr><th class="text-end pe-3">Total Payable</th><td>{{ $data['total_payable'] ?? '' }}</td></tr>
        </tbody>
    </table>
</div>