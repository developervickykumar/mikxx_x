<?php

return [
    'title' => 'Construtor de Tabelas',
    'tabs' => [
        'table' => 'Tabela',
        'graph' => 'Gráfico',
        'form' => 'Formulário',
    ],
    'actions' => [
        'add_sheet' => 'Adicionar Planilha',
        'add_row' => 'Adicionar Linha',
        'add_column' => 'Adicionar Coluna',
        'delete_row' => 'Excluir Linha',
        'delete_column' => 'Excluir Coluna',
        'save' => 'Salvar',
        'load' => 'Carregar',
        'export' => 'Exportar',
    ],
    'graph' => [
        'types' => [
            'bar' => 'Gráfico de Barras',
            'line' => 'Gráfico de Linhas',
            'pie' => 'Gráfico de Pizza',
            'doughnut' => 'Gráfico de Rosca',
        ],
        'data_source' => [
            'current' => 'Planilha Atual',
            'all' => 'Todas as Planilhas',
        ],
        'export' => 'Exportar Gráfico',
    ],
    'form' => [
        'name' => 'Nome do Formulário',
        'add_field' => 'Adicionar Campo',
        'save_form' => 'Salvar Formulário',
        'preview' => 'Visualizar',
        'field_types' => [
            'text' => 'Texto',
            'number' => 'Número',
            'email' => 'E-mail',
            'date' => 'Data',
            'select' => 'Seleção',
            'radio' => 'Botão de Rádio',
            'checkbox' => 'Caixa de Seleção',
            'textarea' => 'Área de Texto',
        ],
        'options' => [
            'required' => 'Obrigatório',
            'placeholder' => 'Texto de Exemplo',
            'label' => 'Rótulo',
            'options' => 'Opções',
            'add_option' => 'Adicionar Opção',
            'delete_option' => 'Excluir Opção',
        ],
    ],
    'messages' => [
        'success' => [
            'save' => 'Salvo com sucesso',
            'load' => 'Carregado com sucesso',
            'delete' => 'Excluído com sucesso',
        ],
        'error' => [
            'save' => 'Erro ao salvar',
            'load' => 'Erro ao carregar',
            'delete' => 'Erro ao excluir',
        ],
    ],
]; 