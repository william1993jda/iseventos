<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerDocumentRequest;
use App\Models\Customer;
use App\Models\CustomerDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CustomerDocumentController extends Controller
{
    public function index(Customer $customer)
    {
        $documents = $customer->documents()->orderBy('name', 'ASC')->paginate(10);

        return view('customers.documents.index', compact('customer', 'documents'));
    }

    public function create(Customer $customer)
    {
        $document = new CustomerDocument();

        return view('customers.documents.form', compact('customer', 'document'));
    }

    public function store(Customer $customer, CustomerDocumentRequest $request)
    {
        if ($request->has('file')) {
            $file = $request->file('file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $url = 'customers/documents/' . $filename;

            Storage::disk("s3")->put($url, file_get_contents($file));

            $customer->documents()->create([
                'name' => $request->get('name'),
                'url' => $url,
            ]);
        }

        return redirect()->route('customers.documents.index', $customer->id);
    }

    public function edit(Customer $customer, CustomerDocument $document, $showMode = false)
    {
        return view('customers.documents.form', compact('customer', 'document', 'showMode'));
    }

    public function update(Customer $customer, CustomerDocument $document, CustomerDocumentRequest $request)
    {
        $document->update($request->all());

        return redirect()->route('customers.documents.index', $customer->id);
    }

    public function destroy(Customer $customer, CustomerDocument $document)
    {
        $document->delete();

        return redirect()->route('customers.documents.index', $customer->id);
    }

    public function show(Customer $customer, CustomerDocument $document)
    {
        return $this->edit($customer, $document, true);
    }
}
