<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProviderRequest;
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

    public function store(ProviderRequest $request)
    {
        Provider::create($request->validated());

        return redirect()->route('providers.index');
    }

    public function edit(Provider $provider, $showMode = false)
    {
        return view('providers.form', compact('provider', 'showMode'));
    }

    public function update(Provider $provider, ProviderRequest $request)
    {
        $provider->update($request->validated());

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
        return $this->edit($provider, true);
    }
}
