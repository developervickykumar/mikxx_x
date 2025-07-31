<?php

return [
    'title' => 'Constructor de Tablas',
    'tabs' => [
        'table' => 'Tabla',
        'graph' => 'Gráfico',
        'form' => 'Formulario',
    ],
    'actions' => [
        'add_sheet' => 'Agregar Hoja',
        'add_row' => 'Agregar Fila',
        'add_column' => 'Agregar Columna',
        'delete_row' => 'Eliminar Fila',
        'delete_column' => 'Eliminar Columna',
        'save' => 'Guardar',
        'load' => 'Cargar',
        'export' => 'Exportar',
    ],
    'graph' => [
        'types' => [
            'bar' => 'Gráfico de Barras',
            'line' => 'Gráfico de Líneas',
            'pie' => 'Gráfico Circular',
            'doughnut' => 'Gráfico de Dona',
        ],
        'data_source' => [
            'current' => 'Hoja Actual',
            'all' => 'Todas las Hojas',
        ],
        'export' => 'Exportar Gráfico',
    ],
    'form' => [
        'name' => 'Nombre del Formulario',
        'add_field' => 'Agregar Campo',
        'save_form' => 'Guardar Formulario',
        'preview' => 'Vista Previa',
        'field_types' => [
            'text' => 'Texto',
            'number' => 'Número',
            'email' => 'Correo Electrónico',
            'date' => 'Fecha',
            'select' => 'Selección',
            'radio' => 'Radio',
            'checkbox' => 'Casilla de Verificación',
            'textarea' => 'Área de Texto',
        ],
        'options' => [
            'required' => 'Requerido',
            'placeholder' => 'Marcador de Posición',
            'label' => 'Etiqueta',
            'options' => 'Opciones',
            'add_option' => 'Agregar Opción',
            'delete_option' => 'Eliminar Opción',
        ],
    ],
    'messages' => [
        'success' => [
            'save' => 'Guardado exitosamente',
            'load' => 'Cargado exitosamente',
            'delete' => 'Eliminado exitosamente',
        ],
        'error' => [
            'save' => 'Error al guardar',
            'load' => 'Error al cargar',
            'delete' => 'Error al eliminar',
        ],
    ],
]; 