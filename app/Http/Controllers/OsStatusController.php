<?php

namespace App\Http\Controllers;

use App\Http\Requests\OsStatusRequest;
use App\Models\OsStatus;
use App\Models\User;
use Illuminate\Http\Request;

class OsStatusController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($query) {
            $osStatuses = OsStatus::where('name', 'like', '%' . $query . '%')
                ->orderBy('name', 'ASC')
                ->paginate(10);

            return view('os-statuses.index', compact('osStatuses', 'query'));
        }

        $osStatuses = OsStatus::orderBy('name', 'ASC')->paginate(10);

        return view('os-statuses.index', compact('osStatuses', 'query'));
    }

    public function create()
    {
        $osStatus = new OsStatus();

        return view('os-statuses.form', compact('osStatus'));
    }

    public function store(OsStatusRequest $request)
    {
        OsStatus::create($request->validated());

        return redirect()->route('os-statuses.index');
    }

    public function edit(OsStatus $OsStatus, $showMode = false)
    {
        return view('os-statuses.form', compact('OsStatus', 'showMode'));
    }

    public function update(OsStatus $osStatus, OsStatusRequest $request)
    {
        $params = $request->validated();

        if (!$request->has('active')) {
            $params['active'] = 0;
        }

        $osStatus->update($params);

        return redirect()->route('os-statuses.index');
    }

    public function destroy(OsStatus $osStatus)
    {
        $osStatus->delete();

        return redirect()->route('os-statuses.index');
    }

    public function show(OsStatus $osStatus)
    {
        return $this->edit($osStatus, true);
    }
}
