<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerAddressRequest;
use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;

class CustomerAddressController extends Controller
{
    public function index(Customer $customer, Request $request)
    {
        $addresses = $customer->addresses()->orderBy('name', 'ASC')->paginate(10);

        return view('customers.addresses.index', compact('customer', 'addresses'));
    }

    public function create(Customer $customer)
    {
        $address = new CustomerAddress();
        $states = CustomerAddress::STATES;

        return view('customers.addresses.form', compact('customer', 'address', 'states'));
    }

    public function store(Customer $customer, CustomerAddressRequest $request)
    {
        $customer->addresses()->create($request->validated());

        return redirect()->route('customers.addresses.index', $customer->id);
    }

    public function edit(Customer $customer, CustomerAddress $address, $showMode = false)
    {
        $states = CustomerAddress::STATES;

        return view('customers.addresses.form', compact('customer', 'address', 'states', 'showMode'));
    }

    public function update(Customer $customer, CustomerAddress $address, CustomerAddressRequest $request)
    {
        $address->update($request->validated());

        return redirect()->route('customers.addresses.index', $customer->id);
    }

    public function destroy(Customer $customer, CustomerAddress $address)
    {
        $address->delete();

        return redirect()->route('customers.addresses.index', $customer->id);
    }

    public function show(Customer $customer, CustomerAddress $address)
    {
        return $this->edit($customer, $address, true);
    }
}
