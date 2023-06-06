<?php

namespace App\Http\Controllers;

use App\Http\Requests\OsProductRequest;
use App\Http\Requests\OsProductStockRequest;
use App\Models\OsCategory;
use App\Models\OsProduct;
use App\Models\OsProductStock;
use Illuminate\Http\Request;

class OsProductStockController extends Controller
{
    public function index(Request $request, OsProduct $osProduct)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($query) {
            $osProductStocks = OsProductStock::where('os_product_id', $osProduct->id)->where('name', 'like', '%' . $query . '%')
                ->paginate(10);

            return view('os-products.stocks.index', compact('osProduct', 'osProductStocks', 'query'));
        }

        $osProductStocks = OsProductStock::where('os_product_id', $osProduct->id)->paginate(10);

        return view('os-products.stocks.index', compact('osProduct', 'osProductStocks', 'query'));
    }

    public function create(OSProduct $osProduct)
    {
        $stock = new OsProductStock();
        $statuses = OsProductStock::STATUSES;

        return view('os-products.stocks.form', compact('osProduct', 'stock', 'statuses'));
    }

    public function store(OSProduct $osProduct, OsProductStockRequest $request)
    {
        $osProduct->stocks()->create($request->validated());

        return redirect()->route('os-products.stocks.index', $osProduct->id);
    }

    public function edit(OsProduct $osProduct, OsProductStock $stock, $showMode = false)
    {
        $statuses = OsProductStock::STATUSES;

        return view('os-products.stocks.form', compact('osProduct', 'stock', 'statuses', 'showMode'));
    }

    public function update(OsProduct $osProduct, OsProductStock $stock, OsProductStockRequest $request)
    {
        $stock->update($request->validated());

        return redirect()->route('os-products.stocks.index', $osProduct->id);
    }

    public function destroy(OsProduct $osProduct, OsProductStock $stock)
    {
        $stock->delete();

        return redirect()->route('os-products.stocks.index', $osProduct->id);
    }

    public function show(OsProduct $osProduct, OsProductStock $stock)
    {
        return $this->edit($osProduct, $stock, true);
    }
}
