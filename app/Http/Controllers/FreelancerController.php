<?php

namespace App\Http\Controllers;

use App\Http\Requests\FreelancerRequest;
use App\Models\Freelancer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FreelancerController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($query) {
            $freelancers = Freelancer::where('name', 'like', '%' . $query . '%')
                ->orWhere('email', 'like', '%' . $query . '%')
                ->paginate(10);

            return view('freelancers.index', compact('freelancers', 'query'));
        }

        $freelancers = Freelancer::paginate(10);

        return view('freelancers.index', compact('freelancers', 'query'));
    }

    public function create()
    {
        $freelancer = new Freelancer();
        $roles = Freelancer::ROLES;

        return view('freelancers.form', compact('freelancer', 'roles'));
    }

    public function store(FreelancerRequest $request)
    {
        $params = $request->validated();

        Freelancer::create($params);

        return redirect()->route('freelancers.index');
    }

    public function edit(Freelancer $freelancer, $showMode = false)
    {

        return view('freelancers.form', compact('freelancer', 'showMode'));
    }

    public function update(Freelancer $freelancer, FreelancerRequest $request)
    {
        $params = $request->validated();

        $freelancer->fill($params);
        $freelancer->save();


        return redirect()->route('freelancers.index');
    }

    public function destroy(Freelancer $freelancer)
    {
        $freelancer->delete();

        return redirect()->route('freelancers.index');
    }

    public function show(Freelancer $freelancer)
    {
        return $this->edit($freelancer, true);
    }
}
