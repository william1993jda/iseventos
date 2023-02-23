<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\ProviderBank;
use Illuminate\Http\Request;

class ProviderBankController extends Controller
{
    public function index(Provider $provider, Request $request)
    {
        $banks = $provider->banks()->paginate(10);

        return view('providers.banks.index', compact('provider', 'banks'));
    }

    public function create(Provider $provider)
    {
        $bank = new ProviderBank();
        $types = ProviderBank::TYPES;

        return view('providers.banks.form', compact('provider', 'bank', 'types'));
    }

    public function store(Provider $provider, Request $request)
    {
        $provider->banks()->create($request->all());

        return redirect()->route('providers.banks.index', $provider->id);
    }

    public function edit(Provider $provider, ProviderBank $bank)
    {
        $types = ProviderBank::TYPES;

        return view('providers.banks.form', compact('provider', 'bank', 'types'));
    }

    public function update(Provider $provider, ProviderBank $bank, Request $request)
    {
        $bank->update($request->all());

        return redirect()->route('providers.banks.index', $provider->id);
    }

    public function destroy(Provider $provider, ProviderBank $bank)
    {
        $bank->delete();

        return redirect()->route('providers.banks.index', $provider->id);
    }

    public function show(Provider $provider, ProviderBank $bank)
    {
        $showMode = true;
        $types = ProviderBank::TYPES;

        return view('providers.banks.form', compact('provider', 'bank', 'showMode', 'types'));
    }
}
