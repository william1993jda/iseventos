<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgencyContactRequest;
use App\Models\Agency;
use App\Models\AgencyContact;
use Illuminate\Http\Request;

class AgencyContactController extends Controller
{
    public function index(Agency $agency, Request $request)
    {
        $contacts = $agency->contacts()->orderBy('name', 'ASC')->paginate(10);

        return view('agencies.contacts.index', compact('agency', 'contacts'));
    }

    public function create(Agency $agency)
    {
        $contact = new AgencyContact();

        return view('agencies.contacts.form', compact('agency', 'contact'));
    }

    public function store(Agency $agency, AgencyContactRequest $request)
    {
        $agency->contacts()->create($request->validated());

        return redirect()->route('agencies.contacts.index', $agency->id);
    }

    public function edit(Agency $agency, AgencyContact $contact, $showMode = false)
    {
        return view('agencies.contacts.form', compact('agency', 'contact'));
    }

    public function update(Agency $agency, AgencyContact $contact, AgencyContactRequest $request)
    {
        $contact->update($request->validated());

        return redirect()->route('agencies.contacts.index', $agency->id);
    }

    public function destroy(Agency $agency, AgencyContact $contact)
    {
        $contact->delete();

        return redirect()->route('agencies.contacts.index', $agency->id);
    }

    public function show(Agency $agency, AgencyContact $contact)
    {
        return $this->edit($agency, $contact, true);
    }
}
