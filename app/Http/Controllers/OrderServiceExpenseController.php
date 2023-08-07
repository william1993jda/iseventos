<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderServiceExpenseRequest;
use App\Models\OrderService;
use App\Models\OrderServiceExpense;
use App\Models\Budget;
use Illuminate\Http\Request;

class OrderServiceExpenseController extends Controller
{
    public function index(OrderService $orderService, Request $request)
    {
        $expenses = $orderService->expenses()->paginate(10);

        return view('order-services.expenses.index', compact('orderService', 'expenses'));
    }

    public function create(OrderService $orderService)
    {
        $expense = new OrderServiceExpense;
        // dd('XXX', $expense);

        return view('order-services.expenses.form', compact('orderService', 'expense'));
    }

    public function store(OrderService $orderService, OrderServiceExpenseRequest $request)
    {
        $orderService->expenses()->create($request->validated());

        return redirect()->route('orderServices.expenses.index', $orderService->id);
    }

    public function edit(OrderService $orderService, OrderServiceExpense $expense, $showMode = false)
    {
        return view('order-services.expenses.form', compact('orderService', 'expense', 'showMode'));
    }

    public function update(OrderService $orderService, OrderServiceExpense $expense, OrderServiceExpenseRequest $request)
    {
        $expense->update($request->validated());

        return redirect()->route('orderServices.expenses.index', $orderService->id);
    }

    public function destroy(OrderService $orderService, OrderServiceExpense $expense)
    {
        $expense->delete();

        return redirect()->route('orderServices.expenses.index', $orderService->id);
    }

    public function show(OrderService $orderService, OrderServiceExpense $expense)
    {
        return $this->edit($orderService, $expense, true);
    }
}
