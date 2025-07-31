<?php

return [
    'title' => 'टेबल बिल्डर',
    'tabs' => [
        'table' => 'टेबल',
        'graph' => 'ग्राफ',
        'form' => 'फॉर्म',
    ],
    'actions' => [
        'add_sheet' => 'शीट जोडा',
        'add_row' => 'रो जोडा',
        'add_column' => 'कॉलम जोडा',
        'delete_row' => 'रो हटवा',
        'delete_column' => 'कॉलम हटवा',
        'save' => 'जतन करा',
        'load' => 'लोड करा',
        'export' => 'एक्सपोर्ट करा',
    ],
    'graph' => [
        'types' => [
            'bar' => 'बार ग्राफ',
            'line' => 'लाइन ग्राफ',
            'pie' => 'पाई ग्राफ',
            'doughnut' => 'डोनट ग्राफ',
        ],
        'data_source' => [
            'current' => 'सध्याची शीट',
            'all' => 'सर्व शीट्स',
        ],
        'export' => 'ग्राफ एक्सपोर्ट करा',
    ],
    'form' => [
        'name' => 'फॉर्मचे नाव',
        'add_field' => 'फील्ड जोडा',
        'save_form' => 'फॉर्म जतन करा',
        'preview' => 'प्रीव्ह्यू',
        'field_types' => [
            'text' => 'टेक्स्ट',
            'number' => 'नंबर',
            'email' => 'ईमेल',
            'date' => 'तारीख',
            'select' => 'सिलेक्ट',
            'radio' => 'रेडिओ बटन',
            'checkbox' => 'चेकबॉक्स',
            'textarea' => 'टेक्स्ट एरिया',
        ],
        'options' => [
            'required' => 'आवश्यक',
            'placeholder' => 'प्लेसहोल्डर',
            'label' => 'लेबल',
            'options' => 'ऑप्शन्स',
            'add_option' => 'ऑप्शन जोडा',
            'delete_option' => 'ऑप्शन हटवा',
        ],
    ],
    'messages' => [
        'success' => [
            'save' => 'यशस्वीरित्या जतन केले',
            'load' => 'यशस्वीरित्या लोड केले',
            'delete' => 'यशस्वीरित्या हटवले',
        ],
        'error' => [
            'save' => 'जतन करताना त्रुटी',
            'load' => 'लोड करताना त्रुटी',
            'delete' => 'हटवताना त्रुटी',
        ],
    ],
]; 