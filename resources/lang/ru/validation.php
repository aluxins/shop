<?php
return [
    'custom' => [
        'name' => [
            'required' => 'Не заполнено поле "Название".',
            'max' => 'Поле "Название" превышает длину.'
        ],
        'article' => [
            'required' => 'Не заполнено поле "Артикул".',
            'max' => 'Поле "Артикул" превышает длину.',
            'unique' => 'Введенный артикул присвоен другому товару.'
        ],
        'description' => [
            'max' => 'Поле "Описание" превышает длину.'
        ],
        'brand' => [
            'integer' => 'Не заполнено поле "Бренд".'
        ],
        'brand_new' => [
            'max' => 'Название нового бренда превышает длину.',
            'unique' => 'Введенный новый бренд уже существует в базе.'
        ],
        'section' => [
            'integer' => 'Не выбран "Раздел".'
        ],
        'price' => [
            'required' => 'Не заполнено поле "Цена".',
            'numeric' => 'Поле "Цена" должно быть числовым.',
            'between' => 'Поле "Цена" превышает максимальное значение 999999.99',
        ],
        'old_price' => [
            'required' => 'Не заполнено поле "Цена".',
            'numeric' => 'Поле "Цена" должно быть числовым.',
            'between' => 'Поле "Цена" превышает максимальное значение 999999.99',
        ],
        'available' => [
            'integer' => 'Поле "Количество" должно быть целым числом.'
        ],
        'searchId' => [
            'integer' => 'Поле поиска по "ID" должно быть целым числом.',
            'required_without' => 'Заполните одно из полей поиска.'
        ],
        'searchArticle' => [
             'required_without' => ''
        ],
        'sort.*' => [
            'numeric' => 'Значение для сортировки должно быть целым числом в диапазоне [-128, 127].'
        ],
        'images.*' => 'Изображение имеет недопустимые параметры.',
        'url' => [
            'alpha_dash' => 'Поле url должно содержать только буквы латинского алфавита, цифры, тире и символ подчеркивания.',
        ],
        'email' => [
            'email' => 'Некорректный формат адреса электронной почты.',
            'unique' => 'Данный адрес электронной почты уже зарегистрирован.'
        ],
        'password' => [
            'confirmed' => 'Введенный пароль не совпадает с повтором пароля.',
            'min' => 'Минимальная длина пароля :min символов.',
        ],
    ],
];
