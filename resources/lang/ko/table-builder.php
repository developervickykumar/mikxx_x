<?php

return [
    'title' => '테이블 빌더',
    'tabs' => [
        'table' => '테이블',
        'graph' => '그래프',
        'form' => '양식',
    ],
    'actions' => [
        'add_sheet' => '시트 추가',
        'add_row' => '행 추가',
        'add_column' => '열 추가',
        'delete_row' => '행 삭제',
        'delete_column' => '열 삭제',
        'save' => '저장',
        'load' => '불러오기',
        'export' => '내보내기',
    ],
    'graph' => [
        'types' => [
            'bar' => '막대 그래프',
            'line' => '선 그래프',
            'pie' => '파이 그래프',
            'doughnut' => '도넛 그래프',
        ],
        'data_source' => [
            'current' => '현재 시트',
            'all' => '모든 시트',
        ],
        'export' => '그래프 내보내기',
    ],
    'form' => [
        'name' => '양식 이름',
        'add_field' => '필드 추가',
        'save_form' => '양식 저장',
        'preview' => '미리보기',
        'field_types' => [
            'text' => '텍스트',
            'number' => '숫자',
            'email' => '이메일',
            'date' => '날짜',
            'select' => '선택',
            'radio' => '라디오 버튼',
            'checkbox' => '체크박스',
            'textarea' => '텍스트 영역',
        ],
        'options' => [
            'required' => '필수',
            'placeholder' => '플레이스홀더',
            'label' => '레이블',
            'options' => '옵션',
            'add_option' => '옵션 추가',
            'delete_option' => '옵션 삭제',
        ],
    ],
    'messages' => [
        'success' => [
            'save' => '성공적으로 저장되었습니다',
            'load' => '성공적으로 불러왔습니다',
            'delete' => '성공적으로 삭제되었습니다',
        ],
        'error' => [
            'save' => '저장 중 오류 발생',
            'load' => '불러오기 중 오류 발생',
            'delete' => '삭제 중 오류 발생',
        ],
    ],
]; 