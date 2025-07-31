<?php

return [
    'title' => 'টেবল বিল্ডার',
    'tabs' => [
        'table' => 'টেবল',
        'graph' => 'গ্রাফ',
        'form' => 'ফর্ম',
    ],
    'actions' => [
        'add_sheet' => 'শীট যোগ',
        'add_row' => 'সারি যোগ',
        'add_column' => 'কলাম যোগ',
        'delete_row' => 'সারি মুছে ফেল',
        'delete_column' => 'কলাম মুছে ফেল',
        'save' => 'সংরক্ষণ',
        'load' => 'লোড',
        'export' => 'রপ্তানি',
    ],
    'graph' => [
        'types' => [
            'bar' => 'বার গ্রাফ',
            'line' => 'লাইন গ্রাফ',
            'pie' => 'পাই গ্রাফ',
            'doughnut' => 'ডোনাট গ্রাফ',
        ],
        'data_source' => [
            'current' => 'বর্তমান শীট',
            'all' => 'সকল শীট',
        ],
        'export' => 'গ্রাফ রপ্তানি',
    ],
    'form' => [
        'name' => 'ফর্মের নাম',
        'add_field' => 'ফিল্ড যোগ',
        'save_form' => 'ফর্ম সংরক্ষণ',
        'preview' => 'প্রাকদর্শন',
        'field_types' => [
            'text' => 'টেক্সট',
            'number' => 'সংখ্যা',
            'email' => 'ইমেইল',
            'date' => 'তারিখ',
            'select' => 'নির্বাচন',
            'radio' => 'রেডিও বাটন',
            'checkbox' => 'চেকবক্স',
            'textarea' => 'টেক্সট এরিয়া',
        ],
        'options' => [
            'required' => 'প্রয়োজনীয়',
            'placeholder' => 'প্লেসহোল্ডার',
            'label' => 'লেবেল',
            'options' => 'অপশন',
            'add_option' => 'অপশন যোগ',
            'delete_option' => 'অপশন মুছে ফেল',
        ],
    ],
    'messages' => [
        'success' => [
            'save' => 'সফলভাবে সংরক্ষিত হয়েছে',
            'load' => 'সফলভাবে লোড হয়েছে',
            'delete' => 'সফলভাবে মুছে ফেলা হয়েছে',
        ],
        'error' => [
            'save' => 'সংরক্ষণে ত্রুটি',
            'load' => 'লোডে ত্রুটি',
            'delete' => 'মুছে ফেলায় ত্রুটি',
        ],
    ],
]; 