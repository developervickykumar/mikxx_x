<?php

return [
    'title' => 'Tabellbyggare',
    'tabs' => [
        'table' => 'Tabell',
        'graph' => 'Graf',
        'form' => 'Formulär',
    ],
    'actions' => [
        'add_sheet' => 'Lägg till ark',
        'add_row' => 'Lägg till rad',
        'add_column' => 'Lägg till kolumn',
        'delete_row' => 'Ta bort rad',
        'delete_column' => 'Ta bort kolumn',
        'save' => 'Spara',
        'load' => 'Ladda',
        'export' => 'Exportera',
    ],
    'graph' => [
        'types' => [
            'bar' => 'Stapeldiagram',
            'line' => 'Linjediagram',
            'pie' => 'Cirkeldiagram',
            'doughnut' => 'Ringdiagram',
        ],
        'data_source' => [
            'current' => 'Aktuellt ark',
            'all' => 'Alla ark',
        ],
        'export' => 'Exportera graf',
    ],
    'form' => [
        'name' => 'Formulärnamn',
        'add_field' => 'Lägg till fält',
        'save_form' => 'Spara formulär',
        'preview' => 'Förhandsgranska',
        'field_types' => [
            'text' => 'Text',
            'number' => 'Nummer',
            'email' => 'E-post',
            'date' => 'Datum',
            'select' => 'Välj',
            'radio' => 'Radioknapp',
            'checkbox' => 'Kryssruta',
            'textarea' => 'Textområde',
        ],
        'options' => [
            'required' => 'Obligatorisk',
            'placeholder' => 'Platshållare',
            'label' => 'Etikett',
            'options' => 'Alternativ',
            'add_option' => 'Lägg till alternativ',
            'delete_option' => 'Ta bort alternativ',
        ],
    ],
    'messages' => [
        'success' => [
            'save' => 'Sparad',
            'load' => 'Laddad',
            'delete' => 'Borttagen',
        ],
        'error' => [
            'save' => 'Fel vid sparande',
            'load' => 'Fel vid laddning',
            'delete' => 'Fel vid borttagning',
        ],
    ],
]; 