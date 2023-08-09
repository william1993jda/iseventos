<?php

namespace App\Http\Controllers;

use App\Http\Requests\FreelancerBankRequest;
use App\Models\Freelancer;
use App\Models\FreelancerBank;
use Illuminate\Http\Request;

class FreelancerBankController extends Controller
{
    public function index(Freelancer $freelancer, Request $request)
    {
        $banks = $freelancer->banks()->orderBy('name', 'ASC')->paginate(10);

        return view('freelancers.banks.index', compact('freelancer', 'banks'));
    }

    public function create(Freelancer $freelancer)
    {
        $bank = new FreelancerBank();
        $types = FreelancerBank::TYPES;

        return view('freelancers.banks.form', compact('freelancer', 'bank', 'types'));
    }

    public function store(Freelancer $freelancer, FreelancerBankRequest $request)
    {
        $freelancer->banks()->create($request->validated());

        return redirect()->route('freelancers.banks.index', $freelancer->id);
    }

    public function edit(Freelancer $freelancer, FreelancerBank $bank, $showMode = false)
    {
        $types = FreelancerBank::TYPES;

        return view('freelancers.banks.form', compact('freelancer', 'bank', 'types', 'showMode'));
    }

    public function update(Freelancer $freelancer, FreelancerBank $bank, FreelancerBankRequest $request)
    {
        $bank->update($request->validated());

        return redirect()->route('freelancers.banks.index', $freelancer->id);
    }

    public function destroy(Freelancer $freelancer, FreelancerBank $bank)
    {
        $bank->delete();

        return redirect()->route('freelancers.banks.index', $freelancer->id);
    }

    public function show(Freelancer $freelancer, FreelancerBank $bank)
    {
        return $this->edit($freelancer, $bank, true);
    }
}
