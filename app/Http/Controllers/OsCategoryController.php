<?php

namespace App\Http\Controllers;

use App\Http\Requests\OsCategoryRequest;
use App\Models\OsCategory;
use App\Models\User;
use Illuminate\Http\Request;

class OsCategoryController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($query) {
            $osCategories = OsCategory::where('name', 'like', '%' . $query . '%')
                ->orderBy('name', 'ASC')
                ->paginate(10);

            return view('os-categories.index', compact('osCategories', 'query'));
        }

        $osCategories = OsCategory::orderBy('name', 'ASC')->paginate(10);

        return view('os-categories.index', compact('osCategories', 'query'));
    }

    public function create()
    {
        $osCategory = new OsCategory();


        return view('os-categories.form', compact('osCategory'));
    }

    public function store(OsCategoryRequest $request)
    {
        OsCategory::create($request->validated());

        return redirect()->route('os-categories.index');
    }

    public function edit(OsCategory $osCategory, $showMode = false)
    {
        return view('os-categories.form', compact('osCategory', 'showMode'));
    }

    public function update(OsCategory $osCategory, OsCategoryRequest $request)
    {
        $params = $request->validated();

        if (!$request->has('active')) {
            $params['active'] = 0;
        }

        $osCategory->update($params);

        return redirect()->route('os-categories.index');
    }

    public function destroy(OsCategory $osCategory)
    {
        $osCategory->delete();

        return redirect()->route('os-categories.index');
    }

    public function show(OsCategory $osCategory)
    {
        return $this->edit($osCategory, true);
    }
}
