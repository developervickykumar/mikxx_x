<?php

return [
    'title' => 'ટેબલ બિલ્ડર',
    'tabs' => [
        'table' => 'ટેબલ',
        'graph' => 'ગ્રાફ',
        'form' => 'ફોર્મ',
    ],
    'actions' => [
        'add_sheet' => 'શીટ ઉમેરો',
        'add_row' => 'પંક્તિ ઉમેરો',
        'add_column' => 'કૉલમ ઉમેરો',
        'delete_row' => 'પંક્તિ કાઢો',
        'delete_column' => 'કૉલમ કાઢો',
        'save' => 'સાચવો',
        'load' => 'લોડ કરો',
        'export' => 'નિકાસ કરો',
    ],
    'graph' => [
        'types' => [
            'bar' => 'બાર ગ્રાફ',
            'line' => 'લાઈન ગ્રાફ',
            'pie' => 'પાઇ ગ્રાફ',
            'doughnut' => 'ડોનટ ગ્રાફ',
        ],
        'data_source' => [
            'current' => 'વર્તમાન શીટ',
            'all' => 'બધી શીટ',
        ],
        'export' => 'ગ્રાફ નિકાસ કરો',
    ],
    'form' => [
        'name' => 'ફોર્મનું નામ',
        'add_field' => 'ફીલ્ડ ઉમેરો',
        'save_form' => 'ફોર્મ સાચવો',
        'preview' => 'પૂર્વાવલોકન',
        'field_types' => [
            'text' => 'ટેક્સ્ટ',
            'number' => 'નંબર',
            'email' => 'ઈમેલ',
            'date' => 'તારીખ',
            'select' => 'પસંદ કરો',
            'radio' => 'રેડિયો બટન',
            'checkbox' => 'ચેકબોક્સ',
            'textarea' => 'ટેક્સ્ટ એરિયા',
        ],
        'options' => [
            'required' => 'જરૂરી',
            'placeholder' => 'પ્લેસહોલ્ડર',
            'label' => 'લેબલ',
            'options' => 'વિકલ્પો',
            'add_option' => 'વિકલ્પ ઉમેરો',
            'delete_option' => 'વિકલ્પ કાઢો',
        ],
    ],
    'messages' => [
        'success' => [
            'save' => 'સફળતાપૂર્વક સાચવ્યું',
            'load' => 'સફળતાપૂર્વક લોડ થયું',
            'delete' => 'સફળતાપૂર્વક કાઢી નાખ્યું',
        ],
        'error' => [
            'save' => 'સાચવવામાં ભૂલ',
            'load' => 'લોડ કરવામાં ભૂલ',
            'delete' => 'કાઢવામાં ભૂલ',
        ],
    ],
]; 