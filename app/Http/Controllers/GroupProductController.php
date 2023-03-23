<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupProductRequest;
use App\Models\OsProduct;
use App\Models\GroupProduct;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupProductController extends Controller
{
    public function index(Group $group, Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($query) {
            $products = GroupProduct::where('name', 'like', '%' . $query . '%')
                ->where('group_id', $group->id)
                ->paginate(10);

            return view('groups.products.index', compact('group', 'products', 'query'));
        }

        $products = GroupProduct::where('group_id', $group->id)->paginate(10);

        return view('groups.products.index', compact('group', 'products', 'query'));
    }

    public function create(Group $group)
    {
        $product = new GroupProduct();
        $products = OsProduct::pluck('name', 'id')->prepend('Selecione', '');
        $groups = Group::pluck('name', 'id')->prepend('Selecione', '');

        return view('groups.products.form', compact('group', 'product', 'groups', 'products'));
    }

    public function store(Group $group, GroupProductRequest $request)
    {
        $group->products()->create([
            'os_product_id' => $request->get('os_product_id'),
        ]);


        return redirect()->route('groups.products.index', $group->id);
    }

    public function edit(Group $group, GroupProduct $product, $showMode = false)
    {
        $product = GroupProduct::pluck('name', 'id')->prepend('Selecione', '');

        return view('groups.products.form', compact('group', 'product', 'osProduct', 'showMode'));
    }

    public function update(Group $group, GroupProduct $product, GroupProductRequest $request)
    {
        $request->merge(['group_id' => $group->id]);

        $params = $request->validated();

        if (!$request->has('active')) {
            $params['active'] = 0;
        }

        $product->update($params);

        return redirect()->route('groups.products.index', $group->id);
    }

    public function destroy(Group $group, GroupProduct $product)
    {
        $product->delete();

        return redirect()->route('groups.products.index', $group->id);
    }

    public function show(Group $group, GroupProduct $product)
    {
        return $this->edit($group, $product, true);
    }
}
