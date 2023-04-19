<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgencyRequest;
use App\Models\Agency;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // $params = $request->all();
        // $query = $request->get('query');

        // if ($query) {
        //     $agencies = Agency::where('fantasy_name', 'like', '%' . $query . '%')
        //         ->orWhere('email', 'like', '%' . $query . '%')
        //         ->paginate(10);

        //     return view('agencies.index', compact('agencies', 'query'));
        // }

        // $agencies = Agency::paginate(10);

        // return view('agencies.index', compact('agencies', 'query'));

        return view('dashboard.index');
    }
}
