<?php

return [
    'title' => 'Constructeur de Tableaux',
    'tabs' => [
        'table' => 'Tableau',
        'graph' => 'Graphique',
        'form' => 'Formulaire',
    ],
    'actions' => [
        'add_sheet' => 'Ajouter une Feuille',
        'add_row' => 'Ajouter une Ligne',
        'add_column' => 'Ajouter une Colonne',
        'delete_row' => 'Supprimer la Ligne',
        'delete_column' => 'Supprimer la Colonne',
        'save' => 'Enregistrer',
        'load' => 'Charger',
        'export' => 'Exporter',
    ],
    'graph' => [
        'types' => [
            'bar' => 'Graphique en Barres',
            'line' => 'Graphique en Lignes',
            'pie' => 'Graphique Circulaire',
            'doughnut' => 'Graphique en Anneau',
        ],
        'data_source' => [
            'current' => 'Feuille Actuelle',
            'all' => 'Toutes les Feuilles',
        ],
        'export' => 'Exporter le Graphique',
    ],
    'form' => [
        'name' => 'Nom du Formulaire',
        'add_field' => 'Ajouter un Champ',
        'save_form' => 'Enregistrer le Formulaire',
        'preview' => 'Aperçu',
        'field_types' => [
            'text' => 'Texte',
            'number' => 'Nombre',
            'email' => 'E-mail',
            'date' => 'Date',
            'select' => 'Sélection',
            'radio' => 'Bouton Radio',
            'checkbox' => 'Case à Cocher',
            'textarea' => 'Zone de Texte',
        ],
        'options' => [
            'required' => 'Obligatoire',
            'placeholder' => 'Texte Indicatif',
            'label' => 'Étiquette',
            'options' => 'Options',
            'add_option' => 'Ajouter une Option',
            'delete_option' => 'Supprimer l\'Option',
        ],
    ],
    'messages' => [
        'success' => [
            'save' => 'Enregistré avec succès',
            'load' => 'Chargé avec succès',
            'delete' => 'Supprimé avec succès',
        ],
        'error' => [
            'save' => 'Erreur lors de l\'enregistrement',
            'load' => 'Erreur lors du chargement',
            'delete' => 'Erreur lors de la suppression',
        ],
    ],
]; 