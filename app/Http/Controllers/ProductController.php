<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
       private $products;

    public function __construct()
    {
        // Using your sample data
        $this->products = collect([
            ['id'=>1,  'name'=>'Smart Lock Pro X1', 'model'=>'Wi-Fi + Fingerprint · SLP-X1', 'price'=>89.90, 'image'=>null,'slug'=>'smart-lock-pro-x1'],
            ['id'=>2,  'name'=>'Yale Assure Lock 2', 'model'=>'Bluetooth · YAL-2022', 'price'=>124.99, 'image'=>null,'slug'=>'yale-assure-lock-2'],
            // ... add all other items
            ['id'=>30, 'name'=>'Ultraloq U-Bolt', 'model'=>'5-in-1 · UL3-STD', 'price'=>79.99, 'image'=>null,'slug'=>'ultraloq-u-bolt'],
        ]);
    }

    public function index()
    {
        $products = $this->products;
        return view('products.index', compact('products'));
    }

    public function show($slug)
    {
        $product = $this->products->firstWhere('slug', $slug);

        if (!$product) abort(404);

        return view('products.show', compact('product'));
    }
}
