<?php

return [
    'title' => 'Pembuat Tabel',
    'tabs' => [
        'table' => 'Tabel',
        'graph' => 'Grafik',
        'form' => 'Formulir',
    ],
    'actions' => [
        'add_sheet' => 'Tambah Lembar',
        'add_row' => 'Tambah Baris',
        'add_column' => 'Tambah Kolom',
        'delete_row' => 'Hapus Baris',
        'delete_column' => 'Hapus Kolom',
        'save' => 'Simpan',
        'load' => 'Muat',
        'export' => 'Ekspor',
    ],
    'graph' => [
        'types' => [
            'bar' => 'Grafik Batang',
            'line' => 'Grafik Garis',
            'pie' => 'Grafik Lingkaran',
            'doughnut' => 'Grafik Donat',
        ],
        'data_source' => [
            'current' => 'Lembar Saat Ini',
            'all' => 'Semua Lembar',
        ],
        'export' => 'Ekspor Grafik',
    ],
    'form' => [
        'name' => 'Nama Formulir',
        'add_field' => 'Tambah Bidang',
        'save_form' => 'Simpan Formulir',
        'preview' => 'Pratinjau',
        'field_types' => [
            'text' => 'Teks',
            'number' => 'Angka',
            'email' => 'Email',
            'date' => 'Tanggal',
            'select' => 'Pilih',
            'radio' => 'Tombol Radio',
            'checkbox' => 'Kotak Centang',
            'textarea' => 'Area Teks',
        ],
        'options' => [
            'required' => 'Wajib',
            'placeholder' => 'Tempat Penampung',
            'label' => 'Label',
            'options' => 'Opsi',
            'add_option' => 'Tambah Opsi',
            'delete_option' => 'Hapus Opsi',
        ],
    ],
    'messages' => [
        'success' => [
            'save' => 'Berhasil disimpan',
            'load' => 'Berhasil dimuat',
            'delete' => 'Berhasil dihapus',
        ],
        'error' => [
            'save' => 'Kesalahan saat menyimpan',
            'load' => 'Kesalahan saat memuat',
            'delete' => 'Kesalahan saat menghapus',
        ],
    ],
]; 