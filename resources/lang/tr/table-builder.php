<?php

return [
    'title' => 'Tablo Oluşturucu',
    'tabs' => [
        'table' => 'Tablo',
        'graph' => 'Grafik',
        'form' => 'Form',
    ],
    'actions' => [
        'add_sheet' => 'Sayfa Ekle',
        'add_row' => 'Satır Ekle',
        'add_column' => 'Sütun Ekle',
        'delete_row' => 'Satır Sil',
        'delete_column' => 'Sütun Sil',
        'save' => 'Kaydet',
        'load' => 'Yükle',
        'export' => 'Dışa Aktar',
    ],
    'graph' => [
        'types' => [
            'bar' => 'Çubuk Grafik',
            'line' => 'Çizgi Grafik',
            'pie' => 'Pasta Grafik',
            'doughnut' => 'Halka Grafik',
        ],
        'data_source' => [
            'current' => 'Mevcut Sayfa',
            'all' => 'Tüm Sayfalar',
        ],
        'export' => 'Grafiği Dışa Aktar',
    ],
    'form' => [
        'name' => 'Form Adı',
        'add_field' => 'Alan Ekle',
        'save_form' => 'Formu Kaydet',
        'preview' => 'Önizleme',
        'field_types' => [
            'text' => 'Metin',
            'number' => 'Sayı',
            'email' => 'E-posta',
            'date' => 'Tarih',
            'select' => 'Seçim',
            'radio' => 'Radyo Düğmesi',
            'checkbox' => 'Onay Kutusu',
            'textarea' => 'Metin Alanı',
        ],
        'options' => [
            'required' => 'Gerekli',
            'placeholder' => 'Yer Tutucu',
            'label' => 'Etiket',
            'options' => 'Seçenekler',
            'add_option' => 'Seçenek Ekle',
            'delete_option' => 'Seçenek Sil',
        ],
    ],
    'messages' => [
        'success' => [
            'save' => 'Başarıyla kaydedildi',
            'load' => 'Başarıyla yüklendi',
            'delete' => 'Başarıyla silindi',
        ],
        'error' => [
            'save' => 'Kaydetme hatası',
            'load' => 'Yükleme hatası',
            'delete' => 'Silme hatası',
        ],
    ],
]; 