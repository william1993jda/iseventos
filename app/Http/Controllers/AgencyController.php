<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgencyRequest;
use App\Models\Agency;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($query) {
            $agencies = Agency::where('fantasy_name', 'like', '%' . $query . '%')
                ->orWhere('email', 'like', '%' . $query . '%')
                ->orderBy('fantasy_name', 'ASC')
                ->paginate(10);

            return view('agencies.index', compact('agencies', 'query'));
        }

        $agencies = Agency::orderBy('fantasy_name', 'ASC')->paginate(10);

        return view('agencies.index', compact('agencies', 'query'));
    }

    public function create()
    {
        $agency = new Agency();

        return view('agencies.form', compact('agency'));
    }

    public function store(AgencyRequest $request)
    {
        Agency::create($request->validated());

        return redirect()->route('agencies.index');
    }

    public function edit(Agency $agency, $showMode = false)
    {
        return view('agencies.form', compact('agency', 'showMode'));
    }

    public function update(Agency $agency, AgencyRequest $request)
    {
        $agency->update($request->validated());

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
        return $this->edit($agency, true);
    }
}
