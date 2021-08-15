<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
   public function recentlyAddedProducts()
   {      
      Cache::add('recent_products', Product::latest()->take(10)->get());
      return response()->json(['data' => 
         ProductResource::collection(Cache::get('recent_products', Product::latest()->take(10)->get()))
      ]);
   }
}
