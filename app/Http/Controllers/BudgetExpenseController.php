<?php

namespace App\Http\Controllers;

use App\Http\Requests\BudgetExpenseRequest;
use App\Models\Budget;
use App\Models\BudgetExpense;
use Illuminate\Http\Request;

class BudgetExpenseController extends Controller
{
    public function index(Budget $budget, Request $request)
    {
        $expenses = $budget->expenses()->paginate(10);

        return view('budgets.expenses.index', compact('budget', 'expenses'));
    }

    public function create(Budget $budget)
    {
        $expense = new BudgetExpense();

        return view('budgets.expenses.form', compact('budget', 'expense'));
    }

    public function store(Budget $budget, BudgetExpenseRequest $request)
    {
        $budget->expenses()->create($request->validated());

        return redirect()->route('budgets.expenses.index', $budget->id);
    }

    public function edit(Budget $budget, BudgetExpense $expense, $showMode = false)
    {
        return view('budgets.expenses.form', compact('budget', 'expense', 'showMode'));
    }

    public function update(Budget $budget, BudgetExpense $expense, BudgetExpenseRequest $request)
    {
        $expense->update($request->validated());

        return redirect()->route('budgets.expenses.index', $budget->id);
    }

    public function destroy(Budget $budget, BudgetExpense $expense)
    {
        $expense->delete();

        return redirect()->route('budgets.expenses.index', $budget->id);
    }

    public function show(Budget $budget, BudgetExpense $expense)
    {
        return $this->edit($budget, $expense, true);
    }
}
