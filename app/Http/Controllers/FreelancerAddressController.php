<?php

namespace App\Http\Controllers;

use App\Http\Requests\FreelancerAddressRequest;
use App\Models\Freelancer;
use App\Models\FreelancerAddress;
use Illuminate\Http\Request;

class FreelancerAddressController extends Controller
{
    public function index(Freelancer $freelancer, Request $request)
    {
        $addresses = $freelancer->addresses()->orderBy('name', 'ASC')->paginate(10);

        return view('freelancers.addresses.index', compact('freelancer', 'addresses'));
    }

    public function create(Freelancer $freelancer)
    {
        $address = new FreelancerAddress();
        $states = FreelancerAddress::STATES;

        return view('freelancers.addresses.form', compact('freelancer', 'address', 'states'));
    }

    public function store(Freelancer $freelancer, FreelancerAddressRequest $request)
    {
        $freelancer->addresses()->create($request->validated());

        return redirect()->route('freelancers.addresses.index', $freelancer->id);
    }

    public function edit(Freelancer $freelancer, FreelancerAddress $address, $showMode = false)
    {
        $states = FreelancerAddress::STATES;

        return view('freelancers.addresses.form', compact('freelancer', 'address', 'states', 'showMode'));
    }

    public function update(Freelancer $freelancer, FreelancerAddress $address, FreelancerAddressRequest $request)
    {
        $address->update($request->validated());

        return redirect()->route('freelancers.addresses.index', $freelancer->id);
    }

    public function destroy(Freelancer $freelancer, FreelancerAddress $address)
    {
        $address->delete();

        return redirect()->route('freelancers.addresses.index', $freelancer->id);
    }

    public function show(Freelancer $freelancer, FreelancerAddress $address)
    {
        return $this->edit($freelancer, $address, true);
    }
}
