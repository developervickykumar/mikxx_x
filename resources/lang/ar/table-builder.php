<?php

return [
    'title' => 'منشئ الجداول',
    'tabs' => [
        'table' => 'جدول',
        'graph' => 'رسم بياني',
        'form' => 'نموذج',
    ],
    'actions' => [
        'add_sheet' => 'إضافة ورقة',
        'add_row' => 'إضافة صف',
        'add_column' => 'إضافة عمود',
        'delete_row' => 'حذف صف',
        'delete_column' => 'حذف عمود',
        'save' => 'حفظ',
        'load' => 'تحميل',
        'export' => 'تصدير',
    ],
    'graph' => [
        'types' => [
            'bar' => 'رسم بياني شريطي',
            'line' => 'رسم بياني خطي',
            'pie' => 'رسم بياني دائري',
            'doughnut' => 'رسم بياني حلقي',
        ],
        'data_source' => [
            'current' => 'الورقة الحالية',
            'all' => 'جميع الأوراق',
        ],
        'export' => 'تصدير الرسم البياني',
    ],
    'form' => [
        'name' => 'اسم النموذج',
        'add_field' => 'إضافة حقل',
        'save_form' => 'حفظ النموذج',
        'preview' => 'معاينة',
        'field_types' => [
            'text' => 'نص',
            'number' => 'رقم',
            'email' => 'بريد إلكتروني',
            'date' => 'تاريخ',
            'select' => 'قائمة منسدلة',
            'radio' => 'زر راديو',
            'checkbox' => 'مربع اختيار',
            'textarea' => 'منطقة نصية',
        ],
        'options' => [
            'required' => 'مطلوب',
            'placeholder' => 'نص توضيحي',
            'label' => 'تسمية',
            'options' => 'خيارات',
            'add_option' => 'إضافة خيار',
            'delete_option' => 'حذف خيار',
        ],
    ],
    'messages' => [
        'success' => [
            'save' => 'تم الحفظ بنجاح',
            'load' => 'تم التحميل بنجاح',
            'delete' => 'تم الحذف بنجاح',
        ],
        'error' => [
            'save' => 'خطأ في الحفظ',
            'load' => 'خطأ في التحميل',
            'delete' => 'خطأ في الحذف',
        ],
    ],
]; 