<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($params) {
            $products = Product::where('name', 'like', '%' . $params['query'] . '%')
                ->orWhere('email', 'like', '%' . $params['query'] . '%')
                ->paginate(10);

            return view('products.index', compact('products', 'query'));
        }

        $products = Product::paginate(10);

        return view('products.index', compact('products', 'query'));
    }

    public function create()
    {
        $product = new Product();
        $categories = Category::pluck('name', 'id')->prepend('Selecione', '');

        return view('products.form', compact('product', 'categories'));
    }

    public function store(ProductRequest $request)
    {
        Product::create($request->validated());

        return redirect()->route('products.index');
    }

    public function edit(Product $product)
    {
        $categories = Category::pluck('name', 'id')->prepend('Selecione', '');

        return view('products.form', compact('product', 'categories'));
    }

    public function update(Product $product, ProductRequest $request)
    {
        $params = $request->validated();

        if (!$request->has('active')) {
            $params['active'] = 0;
        }

        $product->update($params);

        return redirect()->route('products.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index');
    }

    public function show(Product $product)
    {
        $showMode = true;
        $categories = Category::pluck('name', 'id')->prepend('Selecione', '');

        return view('products.form', compact('product', 'categories', 'showMode'));
    }
}
