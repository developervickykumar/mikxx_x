<?php

return [
    'title' => '表格生成器',
    'tabs' => [
        'table' => '表格',
        'graph' => '图表',
        'form' => '表单',
    ],
    'actions' => [
        'add_sheet' => '添加工作表',
        'add_row' => '添加行',
        'add_column' => '添加列',
        'delete_row' => '删除行',
        'delete_column' => '删除列',
        'save' => '保存',
        'load' => '加载',
        'export' => '导出',
    ],
    'graph' => [
        'types' => [
            'bar' => '柱状图',
            'line' => '折线图',
            'pie' => '饼图',
            'doughnut' => '环形图',
        ],
        'data_source' => [
            'current' => '当前工作表',
            'all' => '所有工作表',
        ],
        'export' => '导出图表',
    ],
    'form' => [
        'name' => '表单名称',
        'add_field' => '添加字段',
        'save_form' => '保存表单',
        'preview' => '预览',
        'field_types' => [
            'text' => '文本输入',
            'number' => '数字输入',
            'email' => '邮箱输入',
            'date' => '日期输入',
            'select' => '下拉选择',
            'radio' => '单选按钮',
            'checkbox' => '复选框',
            'textarea' => '文本区域',
        ],
        'options' => [
            'required' => '必填',
            'placeholder' => '占位符',
            'label' => '标签',
            'options' => '选项',
            'add_option' => '添加选项',
            'delete_option' => '删除选项',
        ],
    ],
    'messages' => [
        'success' => [
            'save' => '保存成功',
            'load' => '加载成功',
            'delete' => '删除成功',
        ],
        'error' => [
            'save' => '保存失败',
            'load' => '加载失败',
            'delete' => '删除失败',
        ],
    ],
]; 