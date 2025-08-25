<html>
<head>
    <title>Embedded Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-4">
        <form method="POST" action="{{ route('vehicle.store') }}" enctype="multipart/form-data">
            @csrf
            <ul class="nav nav-pills mb-3" id="formTabs"></ul>
            <div class="tab-content" id="formTabsContent"></div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary">Submit Form</button>
            </div>
        </form>
    </div>

    <script>
        const steps = @json($steps);
        console.log("Steps data:", steps);
        if (steps && steps.length) {
            buildForm(steps);   // <- tumhara function call
        }
    </script>
    <script src="{{ asset('js/build-form.js') }}"></script>
</body>
</html>
