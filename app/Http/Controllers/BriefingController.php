<?php

namespace App\Http\Controllers;

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

        $briefings = Briefing::paginate(10);

        return view('briefings.index', compact('briefings', 'query'));
    }

    public function create()
    {
        $briefing = new Briefing();


        return view('briefings.form', compact('briefing'));
    }

    public function store(BriefingRequest $request)
    {
        Briefing::create($request->validated());

        return redirect()->route('briefings.index');
    }

    public function edit(Briefing $briefing, $showMode = false)
    {


        return view('briefings.form', compact('briefing', 'categories', 'showMode'));
    }

    public function update(Briefing $briefing, BriefingRequest $request)
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
