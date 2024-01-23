<?php

namespace App\Helpers;

if (!class_exists('RecursionArray')) {
    class RecursionArray {
        /**
         * Преобразование одномерного массива в многомерный.
         * @param array $array
         * @param int $id
         * @return array
         */
        public static function multidimensional(array $array, int $id = 0): array
        {
            $search = [];
            foreach($array as $el){
                if($el['parent'] === $id) {
                    $search[] = [
                        'id' => $el['id'],
                        'name' => $el['name'],
                        'link' => $el['link'],
                        'children' => self::multidimensional($array, $el['id'])
                    ];
                }
            }
            return $search;
        }

        /**
         * Определение глубины вложенности элемента в одномерном представлении данных.
         * @param $array
         * @param $id
         * @param bool $direction направление: *true - поиск parents* или *false - поиск children
         * @param bool $line представление выходных данных: *false - одномерный массив* или *true - двумерный массив*
         * @param array $search
         * @return array
         */
        public static function depth($array, $id, bool $direction = true, bool $line = false, array &$search = []): array
        {
            foreach($array as $el){
                if(($direction ? $el['id'] : $el['parent']) == $id){
                    $search[] = $line
                        ? $el['id']
                        : ['id' => $el['id'], 'name' => $el['name']];
                    self::depth($array, $direction ? $el['parent'] : $el['id'], $direction, $line,$search);
                }
            }
            return $search;
        }
    }
}
