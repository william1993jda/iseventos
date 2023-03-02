<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($params) {
            $agencies = Agency::where('name', 'like', '%' . $params['query'] . '%')
                ->orWhere('email', 'like', '%' . $params['query'] . '%')
                ->paginate(10);

            return view('agencies.index', compact('agencies', 'query'));
        }

        $agencies = Agency::paginate(10);

        return view('agencies.index', compact('agencies', 'query'));
    }

    public function create()
    {
        $agency = new Agency();

        return view('agencies.form', compact('agency'));
    }

    public function store(Request $request)
    {
        Agency::create($request->all());

        return redirect()->route('agencies.index');
    }

    public function edit(Agency $agency)
    {
        return view('agencies.form', compact('agency'));
    }

    public function update(Agency $agency, Request $request)
    {
        $agency->update($request->all());

        return redirect()->route('agencies.index');
    }

    public function destroy(Agency $agency)
    {
        $agency->addresses()->delete();
        $agency->contacts()->delete();
        $agency->delete();

        return redirect()->route('agencies.index');
    }

    public function show(Agency $agency)
    {
        $showMode = true;

        return view('agencies.form', compact('agency', 'showMode'));
    }
}
