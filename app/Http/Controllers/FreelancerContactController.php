<?php

namespace App\Http\Controllers;

use App\Http\Requests\FreelancerContactRequest;
use App\Models\Freelancer;
use App\Models\FreelancerContact;
use Illuminate\Http\Request;

class FreelancerContactController extends Controller
{
    public function index(Freelancer $freelancer, Request $request)
    {
        $contacts = $freelancer->contacts()->orderBy('name', 'ASC')->paginate(10);

        return view('freelancers.contacts.index', compact('freelancer', 'contacts'));
    }

    public function create(Freelancer $freelancer)
    {
        $contact = new FreelancerContact();

        return view('freelancers.contacts.form', compact('freelancer', 'contact'));
    }

    public function store(Freelancer $freelancer, FreelancerContactRequest $request)
    {
        $freelancer->contacts()->create($request->validated());

        return redirect()->route('freelancers.contacts.index', $freelancer->id);
    }

    public function edit(Freelancer $freelancer, FreelancerContact $contact, $showMode = false)
    {
        return view('freelancers.contacts.form', compact('freelancer', 'contact', 'showMode'));
    }

    public function update(Freelancer $freelancer, FreelancerContact $contact, FreelancerContactRequest $request)
    {
        $contact->update($request->validated());

        return redirect()->route('freelancers.contacts.index', $freelancer->id);
    }

    public function destroy(Freelancer $freelancer, FreelancerContact $contact)
    {
        $contact->delete();

        return redirect()->route('freelancers.contacts.index', $freelancer->id);
    }

    public function show(Freelancer $freelancer, FreelancerContact $contact)
    {
        return $this->edit($freelancer, $contact, true);
    }
}
