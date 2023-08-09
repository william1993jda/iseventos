<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($query) {
            $categories = Category::where('name', 'like', '%' . $query . '%')
                ->orderBy('name', 'ASC')
                ->paginate(10);

            return view('categories.index', compact('categories', 'query'));
        }

        $categories = Category::orderBy('name', 'ASC')->paginate(10);

        return view('categories.index', compact('categories', 'query'));
    }

    public function create()
    {
        $category = new Category();


        return view('categories.form', compact('category'));
    }

    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());

        return redirect()->route('categories.index');
    }

    public function edit(Category $category, $showMode = false)
    {

        return view('categories.form', compact('category', 'showMode'));
    }

    public function update(Category $category, CategoryRequest $request)
    {
        $params = $request->validated();

        if (!$request->has('active')) {
            $params['active'] = 0;
        }

        $category->update($params);

        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index');
    }

    public function show(Category $category)
    {
        return $this->edit($category, true);
    }
}
