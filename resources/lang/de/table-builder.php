<?php

return [
    'title' => 'Tabellen-Generator',
    'tabs' => [
        'table' => 'Tabelle',
        'graph' => 'Diagramm',
        'form' => 'Formular',
    ],
    'actions' => [
        'add_sheet' => 'Blatt Hinzufügen',
        'add_row' => 'Zeile Hinzufügen',
        'add_column' => 'Spalte Hinzufügen',
        'delete_row' => 'Zeile Löschen',
        'delete_column' => 'Spalte Löschen',
        'save' => 'Speichern',
        'load' => 'Laden',
        'export' => 'Exportieren',
    ],
    'graph' => [
        'types' => [
            'bar' => 'Balkendiagramm',
            'line' => 'Liniendiagramm',
            'pie' => 'Kreisdiagramm',
            'doughnut' => 'Ringdiagramm',
        ],
        'data_source' => [
            'current' => 'Aktuelles Blatt',
            'all' => 'Alle Blätter',
        ],
        'export' => 'Diagramm Exportieren',
    ],
    'form' => [
        'name' => 'Formularname',
        'add_field' => 'Feld Hinzufügen',
        'save_form' => 'Formular Speichern',
        'preview' => 'Vorschau',
        'field_types' => [
            'text' => 'Text',
            'number' => 'Zahl',
            'email' => 'E-Mail',
            'date' => 'Datum',
            'select' => 'Auswahl',
            'radio' => 'Radio-Button',
            'checkbox' => 'Kontrollkästchen',
            'textarea' => 'Textbereich',
        ],
        'options' => [
            'required' => 'Erforderlich',
            'placeholder' => 'Platzhalter',
            'label' => 'Beschriftung',
            'options' => 'Optionen',
            'add_option' => 'Option Hinzufügen',
            'delete_option' => 'Option Löschen',
        ],
    ],
    'messages' => [
        'success' => [
            'save' => 'Erfolgreich gespeichert',
            'load' => 'Erfolgreich geladen',
            'delete' => 'Erfolgreich gelöscht',
        ],
        'error' => [
            'save' => 'Fehler beim Speichern',
            'load' => 'Fehler beim Laden',
            'delete' => 'Fehler beim Löschen',
        ],
    ],
]; 