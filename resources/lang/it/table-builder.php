<?php

return [
    'title' => 'Generatore di Tabelle',
    'tabs' => [
        'table' => 'Tabella',
        'graph' => 'Grafico',
        'form' => 'Modulo',
    ],
    'actions' => [
        'add_sheet' => 'Aggiungi Foglio',
        'add_row' => 'Aggiungi Riga',
        'add_column' => 'Aggiungi Colonna',
        'delete_row' => 'Elimina Riga',
        'delete_column' => 'Elimina Colonna',
        'save' => 'Salva',
        'load' => 'Carica',
        'export' => 'Esporta',
    ],
    'graph' => [
        'types' => [
            'bar' => 'Grafico a Barre',
            'line' => 'Grafico a Linee',
            'pie' => 'Grafico a Torta',
            'doughnut' => 'Grafico ad Anello',
        ],
        'data_source' => [
            'current' => 'Foglio Corrente',
            'all' => 'Tutti i Fogli',
        ],
        'export' => 'Esporta Grafico',
    ],
    'form' => [
        'name' => 'Nome del Modulo',
        'add_field' => 'Aggiungi Campo',
        'save_form' => 'Salva Modulo',
        'preview' => 'Anteprima',
        'field_types' => [
            'text' => 'Testo',
            'number' => 'Numero',
            'email' => 'Email',
            'date' => 'Data',
            'select' => 'Selezione',
            'radio' => 'Pulsante Radio',
            'checkbox' => 'Casella di Spunta',
            'textarea' => 'Area di Testo',
        ],
        'options' => [
            'required' => 'Obbligatorio',
            'placeholder' => 'Testo Segnaposto',
            'label' => 'Etichetta',
            'options' => 'Opzioni',
            'add_option' => 'Aggiungi Opzione',
            'delete_option' => 'Elimina Opzione',
        ],
    ],
    'messages' => [
        'success' => [
            'save' => 'Salvato con successo',
            'load' => 'Caricato con successo',
            'delete' => 'Eliminato con successo',
        ],
        'error' => [
            'save' => 'Errore durante il salvataggio',
            'load' => 'Errore durante il caricamento',
            'delete' => 'Errore durante l\'eliminazione',
        ],
    ],
]; 