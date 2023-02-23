<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\AgencyContact;
use Illuminate\Http\Request;

class AgencyContactController extends Controller
{
    public function index(Agency $agency, Request $request)
    {
        $contacts = $agency->contacts()->paginate(10);

        return view('agencies.contacts.index', compact('agency', 'contacts'));
    }

    public function create(Agency $agency)
    {
        $contact = new AgencyContact();

        return view('agencies.contacts.form', compact('agency', 'contact'));
    }

    public function store(Agency $agency, Request $request)
    {
        $agency->contacts()->create($request->all());

        return redirect()->route('agencies.contacts.index', $agency->id);
    }

    public function edit(Agency $agency, AgencyContact $contact)
    {
        return view('agencies.contacts.form', compact('agency', 'contact'));
    }

    public function update(Agency $agency, AgencyContact $contact, Request $request)
    {
        $contact->update($request->all());

        return redirect()->route('agencies.contacts.index', $agency->id);
    }

    public function destroy(Agency $agency, AgencyContact $contact)
    {
        $contact->delete();

        return redirect()->route('agencies.contacts.index', $agency->id);
    }

    public function show(Agency $agency, AgencyContact $contact)
    {
        $showMode = true;

        return view('agencies.contacts.form', compact('agency', 'contact', 'showMode'));
    }
}
