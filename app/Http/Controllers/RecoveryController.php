<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class RecoveryController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('query');
        $modules = [
            '' => 'Selecione',
            'employees' => 'Funcionários'
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
        }

        return redirect()->route('recoveries.index');
    }
}
