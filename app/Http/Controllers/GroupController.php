<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($query) {
            $groups = Group::where('name', 'like', '%' . $query . '%')
                ->orderBy('name', 'ASC')
                ->paginate(10);

            return view('groups.index', compact('groups', 'query'));
        }

        $groups = Group::orderBy('name', 'ASC')->paginate(10);

        return view('groups.index', compact('groups', 'query'));
    }

    public function create()
    {
        $group = new Group();

        return view('groups.form', compact('group'));
    }

    public function store(GroupRequest $request)
    {
        Group::create($request->validated());

        return redirect()->route('groups.index');
    }

    public function edit(Group $group, $showMode = false)
    {


        return view('groups.form', compact('group', 'showMode'));
    }

    public function update(Group $group, GroupRequest $request)
    {
        $group->update($request->validated());

        return redirect()->route('groups.index');
    }

    public function destroy(Group $group)
    {
        $group->products()->delete();
        $group->delete();

        return redirect()->route('groups.index');
    }

    public function show(Group $group)
    {
        return $this->edit($group, true);
    }
}
