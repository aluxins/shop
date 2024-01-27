<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Repositories\Interfaces\ProductsRepositoryInterface;

class ProductController extends Controller
{
    public function index(ProductsRepositoryInterface $productsRepository, $id): View|RedirectResponse
    {

        $product = $productsRepository->getProductById($id);

        if(is_null($product)) abort(404);

        return view('product',[
                'id' => $id,
                'product' => $product->toArray(),
            ]);
    }

}
