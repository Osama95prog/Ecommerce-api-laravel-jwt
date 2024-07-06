<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api')->except('show');
    }


    public function index(Request $request)
    {
        $products = Product::filter($request->query())
            ->with('category:id,name')
            ->paginate();

        return ProductResource::collection($products);
    }

    public function store(ProductRequest $request)
    {
        $user = $request->user();

        $product = Product::create($request->all());
        return new ProductResource($product);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(ProductRequest $request, Product $product)
    {

        $product->update($request->all());
        return new ProductResource($product);
    }


    public function destroy($id){

        Product::destroy($id);

        return[
            'status' => 'success',
            'message' => 'Product deleted successfully',
        ];
    }
}
