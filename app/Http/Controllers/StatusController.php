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

        if ($query) {
            $statuses = Status::where('name', 'like', '%' . $query . '%')
                ->orderBy('name', 'ASC')
                ->paginate(10);

            return view('statuses.index', compact('statuses', 'query'));
        }

        $statuses = Status::orderBy('name', 'ASC')->paginate(10);

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

    public function edit(Status $status, $showMode = false)
    {
        return view('statuses.form', compact('status', 'showMode'));
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
        return $this->edit($status, true);
    }
}
