<?php

if (!function_exists('sortImages')) {
    // Сортируем массив изображений
    function sortImages(string $images): array|bool
    {
        $images = json_decode($images, true);
        if($images) {
            uasort($images, function ($a, $b) {
                if ($a == $b) {
                    return 0;
                }
                return ($a < $b) ? -1 : 1;
            });
            return $images;
        }
        return false;
    }
}
