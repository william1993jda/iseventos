<?php

namespace App\Http\Controllers;

use App\Http\Requests\FreelancerDependentRequest;
use App\Models\Freelancer;
use App\Models\FreelancerDependent;
use Illuminate\Http\Request;

class FreelancerDependentController extends Controller
{
    public function index(Freelancer $freelancer, Request $request)
    {
        $dependents = $freelancer->dependents()->orderBy('name', 'ASC')->paginate(10);

        return view('freelancers.dependents.index', compact('freelancer', 'dependents'));
    }

    public function create(Freelancer $freelancer)
    {
        $dependent = new FreelancerDependent();

        return view('freelancers.dependents.form', compact('freelancer', 'dependent'));
    }

    public function store(Freelancer $freelancer, FreelancerDependentRequest $request)
    {
        $freelancer->dependents()->create($request->validated());

        return redirect()->route('freelancers.dependents.index', $freelancer->id);
    }

    public function edit(Freelancer $freelancer, FreelancerDependent $dependent, $showMode = false)
    {

        return view('freelancers.dependents.form', compact('freelancer', 'dependent', 'showMode'));
    }

    public function update(Freelancer $freelancer, FreelancerDependent $dependent, FreelancerDependentRequest $request)
    {
        $dependent->update($request->validated());

        return redirect()->route('freelancers.dependents.index', $freelancer->id);
    }

    public function destroy(Freelancer $freelancer, FreelancerDependent $dependent)
    {
        $dependent->delete();

        return redirect()->route('freelancers.dependents.index', $freelancer->id);
    }

    public function show(Freelancer $freelancer, FreelancerDependent $dependent)
    {
        return $this->edit($freelancer, $dependent, true);
    }
}
