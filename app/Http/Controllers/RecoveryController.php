<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Employee;
use Illuminate\Http\Request;

class RecoveryController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('query');
        $modules = [
            '' => 'Selecione',
            'employees' => 'Funcionários',
            'budgets' => 'Orçamentos'
        ];

        $records = [];

        if ($query) {

            switch ($query) {
                case 'employees':
                    $records = Employee::onlyTrashed()->get()->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'name' => $item->user->name,
                            'module' => 'employees'
                        ];
                    });
                    break;
                case 'budgets':
                    $records = Budget::onlyTrashed()->get()->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'name' => $item->name,
                            'module' => 'budgets'
                        ];
                    });
                    break;
            }
        }

        return view('recoveries.index', compact('modules', 'records', 'query'));
    }

    public function recovery(Request $request, $id)
    {
        switch ($request->get('recovery_module')) {
            case 'employees':
                Employee::withTrashed()->find($id)->restore();
                break;
            case 'budgets':
                Budget::withTrashed()->find($id)->restore();
                break;
        }

        return redirect()->route('recoveries.index');
    }
}
