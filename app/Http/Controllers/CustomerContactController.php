<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerContact;
use Illuminate\Http\Request;

class CustomerContactController extends Controller
{
    public function index(Customer $customer, Request $request)
    {
        $contacts = $customer->contacts()->paginate(10);

        return view('customers.contacts.index', compact('customer', 'contacts'));
    }

    public function create(Customer $customer)
    {
        $contact = new CustomerContact();

        return view('customers.contacts.form', compact('customer', 'contact'));
    }

    public function store(Customer $customer, Request $request)
    {
        $customer->contacts()->create($request->all());

        return redirect()->route('customers.contacts.index', $customer->id);
    }

    public function edit(Customer $customer, CustomerContact $contact)
    {
        return view('customers.contacts.form', compact('customer', 'contact'));
    }

    public function update(Customer $customer, CustomerContact $contact, Request $request)
    {
        $contact->update($request->all());

        return redirect()->route('customers.contacts.index', $customer->id);
    }

    public function destroy(Customer $customer, CustomerContact $contact)
    {
        $contact->delete();

        return redirect()->route('customers.contacts.index', $customer->id);
    }

    public function show(Customer $customer, CustomerContact $contact)
    {
        $showMode = true;

        return view('customers.contacts.form', compact('customer', 'contact', 'showMode'));
    }
}
