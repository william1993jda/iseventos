<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgencyRequest;
use App\Models\Agency;
use App\Models\Budget;
use App\Models\Customer;
use App\Models\OrderService;
use App\Models\Provider;
use App\Models\Status;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $budgets = Budget::count();
        $orderServices = OrderService::count();
        $customers = Customer::count();
        $providers = Provider::count();

        $today = date('Y-m-d');

        $events = Budget::all()
            ->map(function ($budget) {
                return [
                    "id" => $budget->id,
                    "title" => $budget->name,
                    "start" => $budget->mount_date,
                    "end" => $budget->unmount_date,
                    "color" => $budget->status->color,
                    "place" => $budget->place->name,
                    "dates" => $budget->budget_days,
                    "customer" => $budget->customer->fantasy_name,
                    "status" => $budget->status->name,
                    "link" => route('budgets.show', $budget->id),
                ];
            })
            ->toArray();

        return view('dashboard.index', compact('budgets', 'orderServices', 'customers', 'providers', 'today', 'events'));
    }
}
