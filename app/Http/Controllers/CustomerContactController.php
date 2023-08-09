<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerContactRequest;
use App\Models\Customer;
use App\Models\CustomerContact;
use Illuminate\Http\Request;

class CustomerContactController extends Controller
{
    public function index(Customer $customer, Request $request)
    {
        $contacts = $customer->contacts()->orderBy('name', 'ASC')->paginate(10);

        return view('customers.contacts.index', compact('customer', 'contacts'));
    }

    public function create(Customer $customer)
    {
        $contact = new CustomerContact();

        return view('customers.contacts.form', compact('customer', 'contact'));
    }

    public function store(Customer $customer, CustomerContactRequest $request)
    {
        $customer->contacts()->create($request->validated());

        return redirect()->route('customers.contacts.index', $customer->id);
    }

    public function edit(Customer $customer, CustomerContact $contact, $showMode = false)
    {
        return view('customers.contacts.form', compact('customer', 'contact', 'showMode'));
    }

    public function update(Customer $customer, CustomerContact $contact, CustomerContactRequest $request)
    {
        $contact->update($request->validated());

        return redirect()->route('customers.contacts.index', $customer->id);
    }

    public function destroy(Customer $customer, CustomerContact $contact)
    {
        $contact->delete();

        return redirect()->route('customers.contacts.index', $customer->id);
    }

    public function show(Customer $customer, CustomerContact $contact)
    {
        return $this->edit($customer, $contact, true);
    }
}
