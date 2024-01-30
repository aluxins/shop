<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\StoreBrand;
use App\Models\StoreImage;
use App\Models\StoreOrders;
use App\Models\StoreOrdersProducts;
use App\Models\StorePages;
use App\Models\StoreProduct;
use App\Models\StoreProfiles;
use App\Models\StoreSections;
use App\Models\User;
use Database\Factories\StoreImageFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Разделы.
        $sections = self::SectionsFactory();

        // Бренды.
        $brands = self::BrandFactory();

        // Товары.
        $products_n = self::ProductFactory($sections, $brands);

        // Изображения товаров.
        self::ImagesFactory($products_n);

        // Пользователи.
        $users = self::UsersFactory();

        // Профили пользователей.
        self::ProfilesFactory($users);

        // Заказы пользователей.
        self::OrdersFactory($users, $products_n);

        // Страницы.
        self::PagesFactory();

    }

    /**
     * Наполнение таблицы StoreSections (разделы каталога).
     * @param int $n
     * @return array
     */
    public function SectionsFactory(int $n = 6): array
    {
        $sections = StoreSections::factory()->count($n)->create(['parent' => 0])->toArray();

        $sections = StoreSections::factory()->count($n * 3)
            ->state(function () use ($sections) {
                return ['parent' => $sections[array_rand($sections)]['id']];
            })->create()->toArray();

        $sections = StoreSections::factory()->count($n * 9)
            ->state(function () use ($sections) {
                return ['parent' => $sections[array_rand($sections)]['id']];
            })->create()->toArray();

        StoreSections::factory()->count($n * 9)
            ->state(function () use ($sections) {
                return ['parent' => $sections[array_rand($sections)]['id']];
            })->create()->toArray();

        // Находим только конечные разделы.
        return self::helperSections(
            StoreSections::orderBy('sort')->orderBy('id')->get()->toArray()
        );
    }

    /**
     * Наполнение таблицы StoreProduct (товары).
     * @param $sections
     * @param $brands
     * @return array
     */
    public function ProductFactory($sections, $brands): array
    {
        $n = 3; // Количество товаров в каждом разделе.

        $products_n = []; // Массив Id товаров.

        foreach ($sections as $section) {
            for ($i = 1; $i <= $n; $i++) {
                $product = StoreProduct::factory()
                    ->state(function () use ($section, $brands) {
                        return ['section' => $section,
                            'brand' => $brands[array_rand($brands)]['id']];
                    })->create();
                $products_n[] = $product->id;
            }
        }
        return $products_n;
    }

    /**
     * Наполнение таблицы StoreImage.
     * @param array $products
     * @return void
     */
    public function ImagesFactory(array $products): void
    {
        $images_array = StoreImageFactory::DataImages();
        foreach ($products as $product) {
            foreach ($images_array[array_rand($images_array)] as $image) {
                StoreImage::factory()
                    ->state(function () use ($image, $product) {
                        return ['product' => $product,
                            'name' => $image];
                    })->create()->toArray();
            }
        }
    }

    /**
     * Наполнение таблицы StoreBrand (бренды).
     * @param int $n
     * @return array
     */
    public function BrandFactory(int $n = 10): array
    {
        return StoreBrand::factory()->count($n)->create()->toArray();
    }


    /**
     * Создаем пользователей.
     * @param int $n
     * @return array
     */
    public function UsersFactory(int $n = 9): array
    {
        return User::factory()->count($n)->create()->toArray();
    }

    /**
     * Создаем профили пользователей.
     * @param array $users
     * @return void
     */
    public function ProfilesFactory(array $users): void
    {
        foreach ($users as $user) {
            StoreProfiles::factory()->state(function () use ($user) {
                return ['user' => $user['id']];
            })->create();
        }
    }

    /**
     * Создаем заказы пользователей.
     * @param array $users
     * @param array $products_n
     * @return void
     */
    public function OrdersFactory(array $users, array $products_n): void
    {
        foreach ($users as $user)
        {
            $k = rand(2, 5);
            $orders = StoreOrders::factory()
                ->count($k)
                ->state(function () use ($user) {
                            return ['user' => $user['id']];
                    })
                ->create()->toArray();

            // Товары заказа.
            self::OrdersProductsFactory($orders, $products_n);

        }
    }

    /**
     * Создаем товары в заказах.
     * @param $orders
     * @param $products_n
     * @return void
     */
    public function OrdersProductsFactory($orders, $products_n): void
    {
        foreach ($orders as $order) {
            $j = rand(1, 5);
            StoreOrdersProducts::factory()
                ->count($j)
                ->state(function () use ($order, $products_n) {
                    return ['order' => $order['id'],
                        'product' => $products_n[array_rand($products_n)],];
                })
                ->create();
        }
    }

    /**
     * Создаем страницы.
     * @param int $n
     * @return void
     */
    public function PagesFactory(int $n = 2): void
    {
        // Главная страница.
        StorePages::factory()->state(function () {
            return ['name' => 'Home',
                'url' => 'index',
                'sort' => 0];
        })->create();

        // Остальные страницы.
        StorePages::factory()->count($n)->create();
    }

    /**
     * Поиск конечных разделов каталога.
     * @param array $array
     * @param int $id
     * @param array $search
     * @return array
     */
    public function helperSections(array $array, int $id = 0, array &$search = []): array
    {
        $flag = false;
        foreach($array as $el){
            if($el['parent'] === $id) {
                self::helperSections($array, $el['id'], $search);
                $flag = true;
            }
        }
        if($flag === false)$search[] = $id;
        return $search;
    }
}
