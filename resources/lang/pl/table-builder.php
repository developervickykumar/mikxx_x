<?php

return [
    'title' => 'Kreator Tabel',
    'tabs' => [
        'table' => 'Tabela',
        'graph' => 'Wykres',
        'form' => 'Formularz',
    ],
    'actions' => [
        'add_sheet' => 'Dodaj arkusz',
        'add_row' => 'Dodaj wiersz',
        'add_column' => 'Dodaj kolumnę',
        'delete_row' => 'Usuń wiersz',
        'delete_column' => 'Usuń kolumnę',
        'save' => 'Zapisz',
        'load' => 'Załaduj',
        'export' => 'Eksportuj',
    ],
    'graph' => [
        'types' => [
            'bar' => 'Wykres słupkowy',
            'line' => 'Wykres liniowy',
            'pie' => 'Wykres kołowy',
            'doughnut' => 'Wykres pierścieniowy',
        ],
        'data_source' => [
            'current' => 'Bieżący arkusz',
            'all' => 'Wszystkie arkusze',
        ],
        'export' => 'Eksportuj wykres',
    ],
    'form' => [
        'name' => 'Nazwa formularza',
        'add_field' => 'Dodaj pole',
        'save_form' => 'Zapisz formularz',
        'preview' => 'Podgląd',
        'field_types' => [
            'text' => 'Tekst',
            'number' => 'Liczba',
            'email' => 'E-mail',
            'date' => 'Data',
            'select' => 'Wybierz',
            'radio' => 'Przycisk opcji',
            'checkbox' => 'Pole wyboru',
            'textarea' => 'Obszar tekstowy',
        ],
        'options' => [
            'required' => 'Wymagane',
            'placeholder' => 'Placeholder',
            'label' => 'Etykieta',
            'options' => 'Opcje',
            'add_option' => 'Dodaj opcję',
            'delete_option' => 'Usuń opcję',
        ],
    ],
    'messages' => [
        'success' => [
            'save' => 'Pomyślnie zapisano',
            'load' => 'Pomyślnie załadowano',
            'delete' => 'Pomyślnie usunięto',
        ],
        'error' => [
            'save' => 'Błąd podczas zapisywania',
            'load' => 'Błąd podczas ładowania',
            'delete' => 'Błąd podczas usuwania',
        ],
    ],
]; 