<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProviderContactRequest;
use App\Models\Provider;
use App\Models\ProviderContact;
use Illuminate\Http\Request;

class ProviderContactController extends Controller
{
    public function index(Provider $provider, Request $request)
    {
        $contacts = $provider->contacts()->orderBy('name', 'ASC')->paginate(10);

        return view('providers.contacts.index', compact('provider', 'contacts'));
    }

    public function create(Provider $provider)
    {
        $contact = new ProviderContact();

        return view('providers.contacts.form', compact('provider', 'contact'));
    }

    public function store(Provider $provider, ProviderContactRequest $request)
    {
        $provider->contacts()->create($request->validated());

        return redirect()->route('providers.contacts.index', $provider->id);
    }

    public function edit(Provider $provider, ProviderContact $contact, $showMode = false)
    {
        return view('providers.contacts.form', compact('provider', 'contact', 'showMode'));
    }

    public function update(Provider $provider, ProviderContact $contact, ProviderContactRequest $request)
    {
        $contact->update($request->validated());

        return redirect()->route('providers.contacts.index', $provider->id);
    }

    public function destroy(Provider $provider, ProviderContact $contact)
    {
        $contact->delete();

        return redirect()->route('providers.contacts.index', $provider->id);
    }

    public function show(Provider $provider, ProviderContact $contact)
    {
        return $this->edit($provider, $contact, true);
    }
}
