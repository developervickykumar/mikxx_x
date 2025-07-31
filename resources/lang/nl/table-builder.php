<?php

return [
    'title' => 'Tabelbouwer',
    'tabs' => [
        'table' => 'Tabel',
        'graph' => 'Grafiek',
        'form' => 'Formulier',
    ],
    'actions' => [
        'add_sheet' => 'Blad toevoegen',
        'add_row' => 'Rij toevoegen',
        'add_column' => 'Kolom toevoegen',
        'delete_row' => 'Rij verwijderen',
        'delete_column' => 'Kolom verwijderen',
        'save' => 'Opslaan',
        'load' => 'Laden',
        'export' => 'Exporteren',
    ],
    'graph' => [
        'types' => [
            'bar' => 'Staafdiagram',
            'line' => 'Lijndiagram',
            'pie' => 'Cirkeldiagram',
            'doughnut' => 'Ringdiagram',
        ],
        'data_source' => [
            'current' => 'Huidig blad',
            'all' => 'Alle bladen',
        ],
        'export' => 'Grafiek exporteren',
    ],
    'form' => [
        'name' => 'Formuliernaam',
        'add_field' => 'Veld toevoegen',
        'save_form' => 'Formulier opslaan',
        'preview' => 'Voorbeeld',
        'field_types' => [
            'text' => 'Tekst',
            'number' => 'Nummer',
            'email' => 'E-mail',
            'date' => 'Datum',
            'select' => 'Selectie',
            'radio' => 'Radioknop',
            'checkbox' => 'Selectievakje',
            'textarea' => 'Tekstgebied',
        ],
        'options' => [
            'required' => 'Verplicht',
            'placeholder' => 'Plaatshouder',
            'label' => 'Label',
            'options' => 'Opties',
            'add_option' => 'Optie toevoegen',
            'delete_option' => 'Optie verwijderen',
        ],
    ],
    'messages' => [
        'success' => [
            'save' => 'Succesvol opgeslagen',
            'load' => 'Succesvol geladen',
            'delete' => 'Succesvol verwijderd',
        ],
        'error' => [
            'save' => 'Fout bij opslaan',
            'load' => 'Fout bij laden',
            'delete' => 'Fout bij verwijderen',
        ],
    ],
]; 