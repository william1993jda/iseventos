<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProviderBankRequest;
use App\Models\Provider;
use App\Models\ProviderBank;
use Illuminate\Http\Request;

class ProviderBankController extends Controller
{
    public function index(Provider $provider, Request $request)
    {
        $banks = $provider->banks()->orderBy('name', 'ASC')->paginate(10);

        return view('providers.banks.index', compact('provider', 'banks'));
    }

    public function create(Provider $provider)
    {
        $bank = new ProviderBank();
        $types = ProviderBank::TYPES;

        return view('providers.banks.form', compact('provider', 'bank', 'types'));
    }

    public function store(Provider $provider, ProviderBankRequest $request)
    {
        $provider->banks()->create($request->validated());

        return redirect()->route('providers.banks.index', $provider->id);
    }

    public function edit(Provider $provider, ProviderBank $bank, $showMode = false)
    {
        $types = ProviderBank::TYPES;

        return view('providers.banks.form', compact('provider', 'bank', 'types', 'showMode'));
    }

    public function update(Provider $provider, ProviderBank $bank, ProviderBankRequest $request)
    {
        $bank->update($request->validated());

        return redirect()->route('providers.banks.index', $provider->id);
    }

    public function destroy(Provider $provider, ProviderBank $bank)
    {
        $bank->delete();

        return redirect()->route('providers.banks.index', $provider->id);
    }

    public function show(Provider $provider, ProviderBank $bank)
    {
        return $this->edit($provider, $bank, true);
    }
}
