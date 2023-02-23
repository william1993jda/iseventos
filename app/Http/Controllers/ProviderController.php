<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\User;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($params) {
            $providers = Provider::where('name', 'like', '%' . $params['query'] . '%')
                ->orWhere('email', 'like', '%' . $params['query'] . '%')
                ->paginate(10);

            return view('providers.index', compact('providers', 'query'));
        }

        $providers = Provider::paginate(10);

        return view('providers.index', compact('providers', 'query'));
    }

    public function create()
    {
        $provider = new Provider();

        return view('providers.form', compact('provider'));
    }

    public function store(Request $request)
    {
        Provider::create($request->all());

        return redirect()->route('providers.index');
    }

    public function edit(Provider $provider)
    {
        return view('providers.form', compact('provider'));
    }

    public function update(Provider $provider, Request $request)
    {
        $provider->update($request->all());

        return redirect()->route('providers.index');
    }

    public function destroy(Provider $provider)
    {
        $provider->addresses()->delete();
        $provider->contacts()->delete();
        $provider->banks()->delete();
        $provider->delete();

        return redirect()->route('providers.index');
    }

    public function show(Provider $provider)
    {
        $showMode = true;

        return view('providers.form', compact('provider', 'showMode'));
    }
}
