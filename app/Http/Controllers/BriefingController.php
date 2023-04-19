<?php

namespace App\Http\Controllers;

use App\Http\Requests\BriefingHybridRequest;
use App\Http\Requests\BriefingOnlineRequest;
use App\Http\Requests\BriefingPersonRequest;
use App\Http\Requests\BriefingRequest;
use App\Models\Category;
use App\Models\Briefing;
use App\Models\User;
use Illuminate\Http\Request;

class BriefingController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($query) {
            $briefings = Briefing::where('name', 'like', '%' . $query . '%')
                ->paginate(10);

            return view('briefings.index', compact('briefings', 'query'));
        }

        $briefings = Briefing::paginate(10);

        return view('briefings.index', compact('briefings', 'query'));
    }

    public function create($type)
    {
        $briefing = new Briefing();

        if ($type == 'online') {
            return view('briefings.form-online', compact('briefing'));
        }
        if ($type == 'person') {
            return view('briefings.form-person', compact('briefing'));
        }
        if ($type == 'hybrid') {
            return view('briefings.form-hybrid', compact('briefing'));
        }
    }

    public function store(Request $request)
    {
        Briefing::create($request->validated());

        return redirect()->route('briefings.index');
    }

    public function storeOnline(BriefingOnlineRequest $request)
    {
        $params = $request->validated();
        $params['type_event'] = 0;

        $briefing = Briefing::create($params);
        $briefing->online()->create($params);

        return redirect()->route('briefings.index');
    }

    public function storePerson(BriefingPersonRequest $request)
    {
        $params = $request->validated();
        $params['type_event'] = 0;

        $briefing = Briefing::create($params);
        $briefing->person()->create($params);

        return redirect()->route('briefings.index');
    }
    public function storeHybrid(BriefingHybridRequest $request)
    {
        $params = $request->validated();
        $params['type_event'] = 0;

        $briefing = Briefing::create($params);
        $briefing->hybrid()->create($params);

        return redirect()->route('briefings.index');
    }

    public function edit(Briefing $briefing, $showMode = false)
    {


        return view('briefings.form', compact('briefing', 'categories', 'showMode'));
    }

    public function update(Briefing $briefing, Request $request)
    {
        $params = $request->validated();

        if (!$request->has('active')) {
            $params['active'] = 0;
        }

        $briefing->update($params);

        return redirect()->route('briefings.index');
    }

    public function updateOnline(Briefing $briefing, BriefingOnlineRequest $request)
    {
        $params = $request->validated();

        if (!$request->has('active')) {
            $params['active'] = 0;
        }

        $briefing->update($params);

        return redirect()->route('briefings.index');
    }
    public function updatePerson(Briefing $briefing, BriefingPersonRequest $request)
    {
        $params = $request->validated();

        if (!$request->has('active')) {
            $params['active'] = 0;
        }

        $briefing->update($params);

        return redirect()->route('briefings.index');
    }
    public function updateHybrid(Briefing $briefing, BriefingHybridRequest $request)
    {
        $params = $request->validated();

        if (!$request->has('active')) {
            $params['active'] = 0;
        }

        $briefing->update($params);

        return redirect()->route('briefings.index');
    }

    public function destroy(Briefing $briefing)
    {
        $briefing->delete();

        return redirect()->route('briefings.index');
    }

    public function show(Briefing $briefing)
    {
        return $this->edit($briefing, true);
    }
}
