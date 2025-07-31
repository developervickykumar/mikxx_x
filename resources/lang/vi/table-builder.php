<?php

return [
    'title' => 'Trình Tạo Bảng',
    'tabs' => [
        'table' => 'Bảng',
        'graph' => 'Đồ thị',
        'form' => 'Biểu mẫu',
    ],
    'actions' => [
        'add_sheet' => 'Thêm trang',
        'add_row' => 'Thêm hàng',
        'add_column' => 'Thêm cột',
        'delete_row' => 'Xóa hàng',
        'delete_column' => 'Xóa cột',
        'save' => 'Lưu',
        'load' => 'Tải',
        'export' => 'Xuất',
    ],
    'graph' => [
        'types' => [
            'bar' => 'Biểu đồ cột',
            'line' => 'Biểu đồ đường',
            'pie' => 'Biểu đồ tròn',
            'doughnut' => 'Biểu đồ vành khuyên',
        ],
        'data_source' => [
            'current' => 'Trang hiện tại',
            'all' => 'Tất cả các trang',
        ],
        'export' => 'Xuất đồ thị',
    ],
    'form' => [
        'name' => 'Tên biểu mẫu',
        'add_field' => 'Thêm trường',
        'save_form' => 'Lưu biểu mẫu',
        'preview' => 'Xem trước',
        'field_types' => [
            'text' => 'Văn bản',
            'number' => 'Số',
            'email' => 'Email',
            'date' => 'Ngày',
            'select' => 'Chọn',
            'radio' => 'Nút radio',
            'checkbox' => 'Hộp kiểm',
            'textarea' => 'Vùng văn bản',
        ],
        'options' => [
            'required' => 'Bắt buộc',
            'placeholder' => 'Giữ chỗ',
            'label' => 'Nhãn',
            'options' => 'Tùy chọn',
            'add_option' => 'Thêm tùy chọn',
            'delete_option' => 'Xóa tùy chọn',
        ],
    ],
    'messages' => [
        'success' => [
            'save' => 'Lưu thành công',
            'load' => 'Tải thành công',
            'delete' => 'Xóa thành công',
        ],
        'error' => [
            'save' => 'Lỗi khi lưu',
            'load' => 'Lỗi khi tải',
            'delete' => 'Lỗi khi xóa',
        ],
    ],
]; 