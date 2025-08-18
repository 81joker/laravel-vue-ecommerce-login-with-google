<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        // $products = Product::query()->orderBy('updated_at', 'desc')->paginate(8);
        // return view('product.index', ['products' => $products]);
        $products = Product::query()
            // ->where('published', '=', 1)
            ->orderBy('updated_at', 'desc')
            ->paginate(5);
        return view('product.index', [
            'products' => $products
        ]);
    }

    public function category(Category $category){

       $categories = Category::getAllChildrenByParent($category);

        $products = Product::query()
            ->select('products.*')
            // This mean in jon product_categories table ===>SELECT * FROM product_categories WHERE product_id = [current_product_id]
            ->join('product_categories AS pc', 'pc.product_id', 'products.id')
            ->whereIn('pc.category_id', array_map(fn($c) => $c->id, $categories))
             ->orderBy('updated_at', 'desc')
            ->paginate(5);
        return view('product.index', [
            'products' => $products,
        ]);
    }
    // public function category($category){
    //     $products = Product::query()
    //         ->where('category_id', $category->id)
    //         ->orderBy('updated_at', 'desc')
    //         ->paginate(5);
    //     return view('product.index', [
    //         'products' => $products,
    //         'category' => $category
    //     ]);
    // }
    public function view(Product $product){
        return view('product.show', ['product' => $product]);
    }
}
