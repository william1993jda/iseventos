<?php

namespace App\Http\Controllers;

use App\Http\Requests\OsProductRequest;
use App\Models\OsCategory;
use App\Models\OsProduct;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderOsProductController extends Controller
{
    public function index(Provider $provider, Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($query) {
            $osProducts = OsProduct::where('name', 'like', '%' . $query . '%')
                ->where('provider_id', $provider->id)
                ->paginate(10);

            return view('providers.os-products.index', compact('provider', 'osProducts', 'query'));
        }

        $osProducts = OsProduct::where('provider_id', $provider->id)->paginate(10);

        return view('providers.os-products.index', compact('provider', 'osProducts', 'query'));
    }

    public function create(Provider $provider)
    {
        $osProduct = new OsProduct();
        $osCategories = OsCategory::pluck('name', 'id')->prepend('Selecione', '');

        return view('providers.os-products.form', compact('provider', 'osProduct', 'osCategories'));
    }

    public function store(Provider $provider, OsProductRequest $request)
    {
        $request->merge(['provider_id' => $provider->id]);

        OsProduct::create($request->validated());

        return redirect()->route('providers.os-products.index', $provider->id);
    }

    public function edit(Provider $provider, OsProduct $product, $showMode = false)
    {
        $osCategories = OsCategory::pluck('name', 'id')->prepend('Selecione', '');

        return view('providers.os-products.form', compact('provider', 'product', 'osCategories', 'showMode'));
    }

    public function update(Provider $provider, OsProduct $product, OsProductRequest $request)
    {
        $request->merge(['provider_id' => $provider->id]);

        $params = $request->validated();

        if (!$request->has('active')) {
            $params['active'] = 0;
        }

        $product->update($params);

        return redirect()->route('providers.os-products.index', $provider->id);
    }

    public function destroy(Provider $provider, OsProduct $product)
    {
        $product->delete();

        return redirect()->route('providers.os-products.index', $provider->id);
    }

    public function show(Provider $provider, OsProduct $product)
    {
        return $this->edit($provider, $product, true);
    }
}
