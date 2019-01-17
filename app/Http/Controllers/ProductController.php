<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Product;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{

    public function userProducts(){
      $user = Auth::user();
      $userProducts = $user->Products;

      return view('product.products' , ['userProducts' => $userProducts]);

    }

    public function productDashboard($id){
        $product = Product::find($id);
        $ProudctPostCount = Post::where('product_id' , $product->id)->count();
        return view('admin.dashboard', ['counts' =>   $ProudctPostCount]);
    }

    public function add(Request $request)
    {
        $products=$request->get('products');
        foreach ($products as $product){
            $tempProduct=Product::find($product);
            if ($tempProduct){
                $tempProduct->users()->attach(Auth::user()->id);
            }
        }

        return back();

    }


    public function view($id){
        $product=Product::find($id);
        if (!$product){

        }
        return view('adminlte::products.view',compact('product'));
    }



}
