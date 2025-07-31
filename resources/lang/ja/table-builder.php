<?php

return [
    'title' => 'テーブルビルダー',
    'tabs' => [
        'table' => 'テーブル',
        'graph' => 'グラフ',
        'form' => 'フォーム',
    ],
    'actions' => [
        'add_sheet' => 'シートを追加',
        'add_row' => '行を追加',
        'add_column' => '列を追加',
        'delete_row' => '行を削除',
        'delete_column' => '列を削除',
        'save' => '保存',
        'load' => '読み込み',
        'export' => 'エクスポート',
    ],
    'graph' => [
        'types' => [
            'bar' => '棒グラフ',
            'line' => '折れ線グラフ',
            'pie' => '円グラフ',
            'doughnut' => 'ドーナツグラフ',
        ],
        'data_source' => [
            'current' => '現在のシート',
            'all' => 'すべてのシート',
        ],
        'export' => 'グラフをエクスポート',
    ],
    'form' => [
        'name' => 'フォーム名',
        'add_field' => 'フィールドを追加',
        'save_form' => 'フォームを保存',
        'preview' => 'プレビュー',
        'field_types' => [
            'text' => 'テキスト',
            'number' => '数値',
            'email' => 'メール',
            'date' => '日付',
            'select' => 'セレクト',
            'radio' => 'ラジオボタン',
            'checkbox' => 'チェックボックス',
            'textarea' => 'テキストエリア',
        ],
        'options' => [
            'required' => '必須',
            'placeholder' => 'プレースホルダー',
            'label' => 'ラベル',
            'options' => 'オプション',
            'add_option' => 'オプションを追加',
            'delete_option' => 'オプションを削除',
        ],
    ],
    'messages' => [
        'success' => [
            'save' => '保存しました',
            'load' => '読み込みました',
            'delete' => '削除しました',
        ],
        'error' => [
            'save' => '保存エラー',
            'load' => '読み込みエラー',
            'delete' => '削除エラー',
        ],
    ],
]; 