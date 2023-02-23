<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($params) {
            $customers = Customer::where('name', 'like', '%' . $params['query'] . '%')
                ->orWhere('email', 'like', '%' . $params['query'] . '%')
                ->paginate(10);

            return view('customers.index', compact('customers', 'query'));
        }

        $customers = Customer::paginate(10);

        return view('customers.index', compact('customers', 'query'));
    }

    public function create()
    {
        $customer = new Customer();

        return view('customers.form', compact('customer'));
    }

    public function store(Request $request)
    {
        Customer::create($request->all());

        return redirect()->route('customers.index');
    }

    public function edit(Customer $customer)
    {
        return view('customers.form', compact('customer'));
    }

    public function update(Customer $customer, Request $request)
    {
        $customer->update($request->all());

        return redirect()->route('customers.index');
    }

    public function destroy(Customer $customer)
    {
        $customer->addresses()->delete();
        $customer->contacts()->delete();
        $customer->delete();

        return redirect()->route('customers.index');
    }

    public function show(Customer $customer)
    {
        $showMode = true;

        return view('customers.form', compact('customer', 'showMode'));
    }
}
