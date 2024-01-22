<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;

class CatalogSettings
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Данные по умолчанию.
        $default = [
            'sort' => config('app.store_settings')['catalog']['sort']['default'],
            'count' => config('app.store_settings')['catalog']['count']['default'],
        ];

        // Считываем значение параметра catalog_settings из cookie.
        $data = json_decode($request->cookie('catalog_settings') ?? '', true);

        //Валидация данных.
        $catalog_settings = $data !== null
            ? Validator::make($data,[
                    'sort' => [
                        'required',
                        'alpha',
                        Rule::in(config('app.store_settings')['catalog']['sort']['values']),
                        ],
                    'count' => [
                        'required',
                        'numeric',
                        Rule::in(config('app.store_settings')['catalog']['count']['values']),
                        ],
                    ]
                )->valid()
            : null;

        // Если валидацию прошли не все данные.
        if(count($catalog_settings) !== count(config('app.store_settings')['catalog']))
            $catalog_settings = null;

        // Если cookie - catalog_settings не прошло валидацию - устанавливаем в cookie значение по умолчанию.
        if($catalog_settings === null)
            Cookie::queue('catalog_settings', json_encode($default), 365*24*60);
            //$response->cookie('catalog_settings', json_encode($default), 365*24*60);

        // Если после валидации $catalog_settings есть null, то присваиваем данные по умолчанию.
        $catalog_settings = $catalog_settings ?? $default;

        // Получаем параметр из get строки
        // Если параметр валидный и отличается от параметра в cookie, то перезаписываем новое значение параметра.
        if($request->all('settings') !== null){
            $setting = explode('_', $request->get('settings'));
            if(array_key_exists($setting[0], config('app.store_settings')['catalog'])
                and in_array($setting[1] ?? '', config('app.store_settings')['catalog'][$setting[0]]['values'])
                and $setting[1] !== $catalog_settings[$setting[0]]) {

                    // Изменяем параметр в массиве $catalog_settings
                    $catalog_settings[$setting[0]] = $setting[1];
                    // Перезаписываем куки
                    Cookie::queue('catalog_settings', json_encode($catalog_settings), 365 * 24 * 60);
            }
        }

        // Добавляем данные catalog_settings в сессию. При отсутствии добавляем данные по умолчанию.
        $request->session()->put('catalog_settings', $catalog_settings);

        $response = $next($request);
        $response->header('Catalog-Settings', $request->session()->get('catalog_settings'));
        return $response;
    }
}
