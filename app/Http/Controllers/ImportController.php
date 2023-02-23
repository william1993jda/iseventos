<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Imports\ProductImport;
use App\Services\Imports\OsProductImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function products(Request $request)
    {
        $params = $request->all();

        if (!empty($params)) {
            Excel::import(new ProductImport, $params['filename']);
        }

        return view('imports.form');
    }

    public function osProducts(Request $request)
    {
        $params = $request->all();

        if (!empty($params)) {
            Excel::import(new OsProductImport, $params['filename']);
        }

        return view('imports.os-form');
    }
}
