<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductResource;

/**
 * @group Products
 *
 * Managing Products
 */
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(3);

        return ProductResource::collection($products);
    }
}
