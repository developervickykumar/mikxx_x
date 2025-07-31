<?php

return [
    'title' => 'Table Builder',
    'tabs' => [
        'table' => 'Table',
        'graph' => 'Graph',
        'form' => 'Form'
    ],
    'actions' => [
        'add_row' => 'Add Row',
        'add_column' => 'Add Column',
        'delete_row' => 'Delete Row',
        'delete_column' => 'Delete Column',
        'save' => 'Save',
        'load' => 'Load',
        'export' => 'Export',
        'add_sheet' => 'Add Sheet',
        'delete_sheet' => 'Delete Sheet'
    ],
    'graph' => [
        'types' => [
            'bar' => 'Bar Chart',
            'line' => 'Line Chart',
            'pie' => 'Pie Chart',
            'doughnut' => 'Doughnut Chart'
        ],
        'data_source' => [
            'current' => 'Current Sheet',
            'all' => 'All Sheets'
        ],
        'export' => 'Export Chart'
    ],
    'form' => [
        'name' => 'Form Name',
        'add_field' => 'Add Field',
        'save_form' => 'Save Form',
        'preview' => 'Preview',
        'field_types' => [
            'text' => 'Text Input',
            'number' => 'Number Input',
            'email' => 'Email Input',
            'date' => 'Date Input',
            'select' => 'Select Input',
            'checkbox' => 'Checkbox',
            'radio' => 'Radio Buttons',
            'textarea' => 'Text Area'
        ],
        'field_options' => [
            'label' => 'Field Label',
            'name' => 'Field Name',
            'required' => 'Required',
            'placeholder' => 'Placeholder',
            'options' => 'Options (one per line)'
        ]
    ],
    'messages' => [
        'save_success' => 'Saved successfully',
        'load_success' => 'Loaded successfully',
        'delete_success' => 'Deleted successfully',
        'error' => 'An error occurred',
        'confirm_delete' => 'Are you sure you want to delete this?'
    ]
]; 