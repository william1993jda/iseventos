<?php

namespace App\Http\Controllers;

use App\Http\Requests\OsProductRequest;
use App\Models\OsCategory;
use App\Models\OsProduct;
use Illuminate\Http\Request;

class OsProductController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($query) {
            $osProducts = OsProduct::where('name', 'like', '%' . $query . '%')
                ->orderBy('name', 'ASC')
                ->paginate(10);

            return view('os-products.index', compact('osProducts', 'query'));
        }

        $osProducts = OsProduct::orderBy('name', 'ASC')->paginate(10);

        return view('os-products.index', compact('osProducts', 'query'));
    }

    public function create()
    {
        $osProduct = new OSProduct();
        $osCategories = OsCategory::pluck('name', 'id')->prepend('Selecione', '');

        return view('os-products.form', compact('osProduct', 'osCategories'));
    }

    public function store(OsProductRequest $request)
    {
        OsProduct::create($request->validated());

        return redirect()->route('os-products.index');
    }

    public function edit(OsProduct $osProduct, $showMode = false)
    {
        $osCategories = OsCategory::pluck('name', 'id')->prepend('Selecione', '');

        return view('os-products.form', compact('osProduct', 'osCategories', 'showMode'));
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
        return $this->edit($osProduct, true);
    }
}
