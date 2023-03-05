<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusRequest;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($params) {
            $statuses = Status::where('name', 'like', '%' . $params['query'] . '%')
                ->orWhere('email', 'like', '%' . $params['query'] . '%')
                ->paginate(10);

            return view('statuses.index', compact('statuses', 'query'));
        }

        $statuses = Status::paginate(10);

        return view('statuses.index', compact('statuses', 'query'));
    }

    public function create()
    {
        $status = new Status();


        return view('statuses.form', compact('status'));
    }

    public function store(StatusRequest $request)
    {
        Status::create($request->validated());

        return redirect()->route('statuses.index');
    }

    public function edit(Status $status)
    {

        return view('statuses.form', compact('status'));
    }

    public function update(Status $status, StatusRequest $request)
    {
        $params = $request->validated();

        if (!$request->has('active')) {
            $params['active'] = 0;
        }

        $status->update($params);

        return redirect()->route('statuses.index');
    }

    public function destroy(Status $status)
    {
        $status->delete();

        return redirect()->route('statuses.index');
    }

    public function show(Status $status)
    {
        $showMode = true;

        return view('statuses.form', compact('status', 'showMode'));
    }
}