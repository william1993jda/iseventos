<?php

namespace App\Http\Controllers;

use App\Http\Requests\OsProductRequest;
use App\Models\Category;
use App\Models\Provider;
use App\Models\OsProduct;
use App\Models\User;
use Illuminate\Http\Request;

class OsProductController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($params) {
            $osProducts = OsProduct::where('name', 'like', '%' . $params['query'] . '%')
                ->orWhere('email', 'like', '%' . $params['query'] . '%')
                ->paginate(10);

            return view('os-products.index', compact('osProducts', 'query'));
        }

        $osProducts = OsProduct::paginate(10);

        return view('os-products.index', compact('osProducts', 'query'));
    }

    public function create()
    {
        $osProduct = new OSProduct();
        $categories = Category::pluck('name', 'id')->prepend('Selecione', '');


        return view('os-products.form', compact('osProduct', 'categories'));
    }

    public function store(OsProductRequest $request)
    {
        OsProduct::create($request->validated());

        return redirect()->route('os-products.index');
    }

    public function edit(OsProduct $osProduct)
    {
        $categories = Category::pluck('name', 'id')->prepend('Selecione', '');


        return view('os-products.form', compact('osProduct', 'categories'));
    }

    public function update(OsProduct $osProduct, OsProductRequest $request)
    {
        $params = $request->validated();

        if (!$request->has('active')) {
            $params['active'] = 0;
        }

        $osProduct->update($params);

        return redirect()->route('os-products.index');
    }

    public function destroy(OsProduct $osProduct)
    {
        $osProduct->delete();

        return redirect()->route('os-products.index');
    }

    public function show(OsProduct $osProduct)
    {
        $showMode = true;
        $categories = Category::pluck('name', 'id')->prepend('Selecione', '');


        return view('os-products.form', compact('osProduct', 'categories', 'showMode'));
    }
}
