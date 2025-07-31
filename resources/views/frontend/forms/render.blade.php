<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $form->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px 0;
        }
        .form-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        .form-header {
            margin-bottom: 20px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-container">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="form-header">
                        <h2>{{ $form->title }}</h2>
                        @if($form->description)
                            <p class="text-muted">{{ $form->description }}</p>
                        @endif
                    </div>

                    @include('components.dynamic-form', [
                        'form' => $form,
                        'fieldsBySection' => $fieldsBySection,
                        'action' => route('forms.submit', $form->slug)
                    ])
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle conditional logic (this would be expanded based on your full implementation)
            function handleConditions() {
                // Basic implementation - would be expanded based on your actual condition logic
                console.log('Handling form conditions');
            }

            // Initial check for conditions
            handleConditions();

            // Listen for changes on form fields to trigger condition checks
            const formFields = document.querySelectorAll('.form-control, .form-check-input');
            formFields.forEach(field => {
                field.addEventListener('change', handleConditions);
            });
        });
    </script>
</body>
</html> 