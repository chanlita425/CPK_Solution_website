<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $products = collect([
            [
                'id' => 1,
                'name' => 'iPhone 15 Pro Max',
                'model' => 'A3108',
                'price' => 1299,
                'slug' => 'iphone-15-pro-max',
                'image' => 'images/products/iphone.png',
            ],
            [
                'id' => 2,
                'name' => 'Samsung Galaxy S24',
                'model' => 'SM-S921B',
                'price' => 999,
                'slug' => 'samsung-s24',
                'image' => 'images/products/samsung.png',
            ],
            [
                'id' => 3,
                'name' => 'Sony Headphones',
                'model' => 'WH-1000XM5',
                'price' => 399,
                'slug' => 'sony-headphones',
                'image' => 'images/products/headphone.png',
            ],
        ]);

        $products = $products->concat($products)->concat($products);

        $perPageXs = 5;
        $perPageSm = 10;
        $perPageLg = 15;

        return view('frontend.pages.home', [
            'productsXs' => $products->take($perPageXs),
            'productsSm' => $products->take($perPageSm),
            'productsLg' => $products->take($perPageLg),

            'pageXs' => 1,
            'pageSm' => 1,
            'pageLg' => 1,

            'totalPagesXs' => ceil($products->count() / $perPageXs),
            'totalPagesSm' => ceil($products->count() / $perPageSm),
            'totalPagesLg' => ceil($products->count() / $perPageLg),

            'promoUrl' => '#',
            'promoImage' => 'images/promo.png',
            'promoPosition' => 3,

            'pgUrl' => fn($p) => request()->fullUrlWithQuery(['page' => $p]),

            'lgFillCount' => (4 - (min($perPageLg, $products->count()) % 4)) % 4,
        ]);
    }
}