<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');
        
        if ($query) {
            $customers = Customer::where('fantasy_name', 'like', '%' . $query . '%')
                ->orWhere('email', 'like', '%' . $query . '%')
                ->orderBy('fantasy_name', 'ASC')
                ->paginate(10);
                
            return view('customers.index', compact('customers', 'query'));
        }

        $customers = Customer::orderBy('fantasy_name', 'ASC')->paginate(10);

        return view('customers.index', compact('customers', 'query'));
    }

    public function create()
    {
        $customer = new Customer();

        return view('customers.form', compact('customer'));
    }

    public function store(CustomerRequest $request)
    {
        Customer::create($request->validated());

        return redirect()->route('customers.index');
    }

    public function edit(Customer $customer, $showMode = false)
    {
        return view('customers.form', compact('customer', 'showMode'));
    }

    public function update(Customer $customer, CustomerRequest $request)
    {
        $customer->update($request->validated());

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
        return $this->edit($customer, true);
    }
}
