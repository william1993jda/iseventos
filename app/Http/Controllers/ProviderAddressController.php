<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\ProviderAddress;
use Illuminate\Http\Request;

class ProviderAddressController extends Controller
{
    public function index(Provider $provider, Request $request)
    {
        $addresses = $provider->addresses()->paginate(10);

        return view('providers.addresses.index', compact('provider', 'addresses'));
    }

    public function create(Provider $provider)
    {
        $address = new ProviderAddress();
        $states = ProviderAddress::STATES;

        return view('providers.addresses.form', compact('provider', 'address', 'states'));
    }

    public function store(Provider $provider, Request $request)
    {
        $provider->addresses()->create($request->all());

        return redirect()->route('providers.addresses.index', $provider->id);
    }

    public function edit(Provider $provider, ProviderAddress $address)
    {
        $states = ProviderAddress::STATES;

        return view('providers.addresses.form', compact('provider', 'address', 'states'));
    }

    public function update(Provider $provider, ProviderAddress $address, Request $request)
    {
        $address->update($request->all());

        return redirect()->route('providers.addresses.index', $provider->id);
    }

    public function destroy(Provider $provider, ProviderAddress $address)
    {
        $address->delete();

        return redirect()->route('providers.addresses.index', $provider->id);
    }

    public function show(Provider $provider, ProviderAddress $address)
    {
        $showMode = true;

        return view('providers.addresses.form', compact('provider', 'address', 'showMode'));
    }
}
