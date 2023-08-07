<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderServiceDocumentRequest;
use App\Models\OrderService;
use App\Models\OrderServiceCheck;
use App\Models\OrderServiceCheckItem;
use App\Models\OrderServiceDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OrderServiceCheckController extends Controller
{
    public function index(OrderService $orderService)
    {
        $orderServiceCheck = OrderServiceCheck::where('order_service_id', $orderService->id)->first();

        if (empty($orderServiceCheck)) {
            $orderServiceCheck = OrderServiceCheck::create([
                'order_service_id' => $orderService->id,
                'status' => 0,
            ]);

            $orderService->products->each(function ($product) use ($orderServiceCheck) {
                OrderServiceCheckItem::create([
                    'order_service_check_id' => $orderServiceCheck->id,
                    'order_service_room_product_id' => $product->id,
                    'os_product_id' => $product->os_product_id,
                    'status' => 1,
                ]);
            });

            $orderService->groups->each(function ($group) use ($orderServiceCheck) {
                $groupProducts = $group->group->products;

                $groupProducts->each(function ($product) use ($group, $orderServiceCheck) {
                    OrderServiceCheckItem::create([
                        'order_service_check_id' => $orderServiceCheck->id,
                        'order_service_room_product_id' => $product->id,
                        'os_product_id' => $product->os_product_id,
                        'group_id' => $group->group_id,
                        'status' => 1,
                    ]);
                });
            });
        }

        $budget = $orderService->budget;

        return view('order-services.check', compact('budget', 'orderService', 'orderServiceCheck'));
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
