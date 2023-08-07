<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderServiceDocumentRequest;
use App\Models\OrderService;
use App\Models\OrderServiceDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OrderServiceDocumentController extends Controller
{
    public function index(OrderService $orderService)
    {
        $documents = $orderService->documents()->paginate(10);

        return view('order-services.documents.index', compact('orderService', 'documents'));
    }

    public function create(OrderService $orderService)
    {
        $document = new OrderServiceDocument();

        return view('order-services.documents.form', compact('orderService', 'document'));
    }

    public function store(OrderService $orderService, OrderServiceDocumentRequest $request)
    {
        if ($request->has('file')) {
            $file = $request->file('file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $url = 'orderServices/documents/' . $filename;

            Storage::disk("s3")->put($url, file_get_contents($file));

            $orderService->documents()->create([
                'name' => $request->get('name'),
                'url' => $url,
            ]);
        }

        return redirect()->route('orderServices.documents.index', $orderService->id);
    }

    public function edit(OrderService $orderService, OrderServiceDocument $document, $showMode = false)
    {
        return view('order-services.documents.form', compact('orderService', 'document', 'showMode'));
    }

    public function update(OrderService $orderService, OrderServiceDocument $document, OrderServiceDocumentRequest $request)
    {
        $document->update($request->all());

        return redirect()->route('orderServices.documents.index', $orderService->id);
    }

    public function destroy(OrderService $orderService, OrderServiceDocument $document)
    {
        $document->delete();

        return redirect()->route('orderServices.documents.index', $orderService->id);
    }

    public function show(OrderService $orderService, OrderServiceDocument $document)
    {
        return $this->edit($orderService, $document, true);
    }
}
