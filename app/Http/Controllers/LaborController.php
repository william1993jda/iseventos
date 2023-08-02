<?php

namespace App\Http\Controllers;

use App\Http\Requests\LaborRequest;
use App\Models\Category;
use App\Models\Labor;
use App\Models\User;
use Illuminate\Http\Request;

class LaborController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($query) {
            $labors = Labor::where('name', 'like', '%' . $query . '%')
                ->orderBy('name', 'ASC')
                ->paginate(10);

            return view('labors.index', compact('labors', 'query'));
        }

        $labors = Labor::orderBy('name', 'ASC')->paginate(10);

        return view('labors.index', compact('labors', 'query'));
    }

    public function create()
    {
        $labor = new Labor();
        $categories = Category::pluck('name', 'id')->prepend('Selecione', '');

        return view('labors.form', compact('labor', 'categories'));
    }

    public function store(LaborRequest $request)
    {
        Labor::create($request->validated());

        return redirect()->route('labors.index');
    }

    public function edit(Labor $labor, $showMode = false)
    {
        $categories = Category::pluck('name', 'id')->prepend('Selecione', '');

        return view('labors.form', compact('labor', 'categories', 'showMode'));
    }

    public function update(Labor $labor, LaborRequest $request)
    {
        $params = $request->validated();

        if (!$request->has('active')) {
            $params['active'] = 0;
        }

        $labor->update($params);

        return redirect()->route('labors.index');
    }

    public function destroy(Labor $labor)
    {
        $labor->delete();

        return redirect()->route('labors.index');
    }

    public function show(Labor $labor)
    {
        return $this->edit($labor, true);
    }
}
