<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\OsProduct;
use Illuminate\Http\Request;

class SubleasedController extends Controller
{
    public function index(Request $request)
    {
        $arProductQuantity = [];
        $products = [];

        $orderServices = Budget::with('orderService')
            // ->where('mount_date', '>=', date('Y-m-d'))
            ->get();

        foreach ($orderServices as $orderService) {
            if (!isset($orderService->orderService->products)) {
                continue;
            }

            foreach ($orderService->orderService->products as $product) {
                if (!isset($arProductQuantity[$product->os_product_id])) {
                    $arProductQuantity[$product->os_product_id] = [
                        'quantity' => 0,
                        'order_service_id' => $orderService->orderService->id,
                        'os_number' => $orderService->orderService->os_number,
                        'days' => $orderService->orderService->budget->budget_days
                    ];
                }

                $arProductQuantity[$product->os_product_id] = [
                    'quantity' => $arProductQuantity[$product->os_product_id]['quantity'] + $product->quantity,
                    'order_service_id' => $orderService->orderService->id,
                    'os_number' => $orderService->orderService->os_number,
                    'days' => $orderService->orderService->budget->budget_days
                ];
            }
        }

        foreach ($arProductQuantity as $productId => $item) {
            $product = OsProduct::find($productId);

            $diff = $item['quantity'] - $product->stocks->count();

            if ($diff > 0) {
                $products[] = [
                    'name' => $product->name,
                    'quantity' => $diff,
                    'order_service_id' => $item['order_service_id'],
                    'os_number' => $item['os_number'],
                    'days' => $item['days'],
                ];
            }
        }

        return view('subleases.index', compact('products'));
    }
}
