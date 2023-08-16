<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\OrderService;
use App\Models\OsProduct;
use App\Models\OsStatus;
use App\Models\Sublease;
use Illuminate\Http\Request;

class SubleasedController extends Controller
{
    public function index(Request $request)
    {
        $statusReproved = OsStatus::where('slug', 'reprovado')->first();

        $subleases = Sublease::with('orderService')
            ->get()
            ->where('orderService.os_status_id', '!=', $statusReproved->id);

        // dd($subleases);

        return view('subleases.index', compact('subleases'));
    }

    public function items(Sublease $sublease)
    {
        return view('subleases.items', compact('sublease'));
    }

    // public function index(Request $request)
    // {
    //     $arProductQuantity = [];
    //     $products = [];

    //     $statusReproved = OsStatus::where('slug', 'reprovado')->first();

    //     $orderServices = OrderService::with('budget')
    //         ->where('os_status_id', '!=', $statusReproved->id)
    //         ->get()
    //         ->where('budget.mount_date', '>=', date('Y-m-d'));

    //     // dd($orderServices);

    //     foreach ($orderServices as $orderService) {
    //         if (!isset($orderService->products)) {
    //             continue;
    //         }

    //         foreach ($orderService->products as $product) {
    //             if (!isset($arProductQuantity[$product->os_product_id])) {
    //                 $arProductQuantity[$product->os_product_id] = [
    //                     'quantity' => 0,
    //                     'order_service_id' => $orderService->id,
    //                     'os_number' => $orderService->os_number,
    //                     'days' => $orderService->budget->budget_days
    //                 ];
    //             }

    //             $arProductQuantity[$product->os_product_id] = [
    //                 'quantity' => $arProductQuantity[$product->os_product_id]['quantity'] + $product->quantity,
    //                 'order_service_id' => $orderService->id,
    //                 'os_number' => $orderService->os_number,
    //                 'days' => $orderService->budget->budget_days
    //             ];
    //         }
    //     }

    //     // dd($arProductQuantity);

    //     foreach ($arProductQuantity as $productId => $item) {
    //         $product = OsProduct::find($productId);

    //         $diff = $item['quantity'] - $product->stocks->count();

    //         if ($diff > 0) {
    //             $products[] = [
    //                 'name' => $product->name,
    //                 'quantity' => $diff,
    //                 'order_service_id' => $item['order_service_id'],
    //                 'os_number' => $item['os_number'],
    //                 'days' => $item['days'],
    //             ];
    //         }
    //     }

    //     // dd($products);

    //     return view('subleases.index', compact('products'));
    // }
}
