<?php
//Источник с примерами https://snipp.ru/php/word-declination

if (!function_exists('declensionWord')) {
    /**
     * Склонение существительных после числительных.
     * @param string $value Значение
     * @param array $words Массив вариантов, например: array('товар', 'товара', 'товаров')
     * @param bool $show Включает значение $value в результирующею строку
     * @return string
     */
    function declensionWord(string $value, array $words, bool $show = true): string
    {
        $num = $value % 100;
        if ($num > 19) {
            $num = $num % 10;
        }

        $out = $show ? $value . ' ' : '';
        $out .= match ($num) {
            1 => $words[0],
            2, 3, 4 => $words[1],
            default => $words[2],
        };

        return $out;
    }
}
