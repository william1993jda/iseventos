<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\AgencyAddress;
use Illuminate\Http\Request;

class AgencyAddressController extends Controller
{
    public function index(Agency $agency, Request $request)
    {
        $addresses = $agency->addresses()->paginate(10);

        return view('agencies.addresses.index', compact('agency', 'addresses'));
    }

    public function create(Agency $agency)
    {
        $address = new AgencyAddress();
        $states = AgencyAddress::STATES;

        return view('agencies.addresses.form', compact('agency', 'address', 'states'));
    }

    public function store(Agency $agency, Request $request)
    {
        $agency->addresses()->create($request->all());

        return redirect()->route('agencies.addresses.index', $agency->id);
    }

    public function edit(Agency $agency, AgencyAddress $address)
    {
        $states = AgencyAddress::STATES;

        return view('agencies.addresses.form', compact('agency', 'address', 'states'));
    }

    public function update(Agency $agency, AgencyAddress $address, Request $request)
    {
        $address->update($request->all());

        return redirect()->route('agencies.addresses.index', $agency->id);
    }

    public function destroy(Agency $agency, AgencyAddress $address)
    {
        $address->delete();

        return redirect()->route('agencies.addresses.index', $agency->id);
    }

    public function show(Agency $agency, AgencyAddress $address)
    {
        $showMode = true;

        return view('agencies.addresses.form', compact('agency', 'address', 'showMode'));
    }
}
