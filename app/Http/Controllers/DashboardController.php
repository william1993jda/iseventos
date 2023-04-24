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
        // $params = $request->all();
        // $query = $request->get('query');

        // if ($query) {
        //     $agencies = Agency::where('fantasy_name', 'like', '%' . $query . '%')
        //         ->orWhere('email', 'like', '%' . $query . '%')
        //         ->paginate(10);

        //     return view('agencies.index', compact('agencies', 'query'));
        // }

        // $agencies = Agency::paginate(10);

        // return view('agencies.index', compact('agencies', 'query'));

        $budgets = Budget::count();
        $orderServices = OrderService::count();
        $customers = Customer::count();
        $providers = Provider::count();

        $today = date('Y-m-d');
        // $month = date('m');
        // $firstDay = date('Y-m-01');
        // $lastDay = date('Y-m-t');

        // $events = Budget::where('mount_date', '>=', $firstDay)
        //     ->where('mount_date', '<=', $lastDay)
        //     ->get()
        //     ->map(function ($budget) {

        //         $budget_days = explode(' - ', $budget->budget_days);
        //         $start = implode('-', array_reverse(explode('/', $budget_days[0])));
        //         $end = implode('-', array_reverse(explode('/', $budget_days[1])));

        //         return [
        //             "id" => $budget->id,
        //             "title" => $budget->name,
        //             "start" => $start,
        //             "end" => $end,
        //             "color" => $budget->status->color,
        //         ];
        //     })
        //     ->toArray();

        $events = Budget::all()
            ->map(function ($budget) {

                $budget_days = explode(' - ', $budget->budget_days);
                $start = implode('-', array_reverse(explode('/', $budget_days[0])));
                $end = implode('-', array_reverse(explode('/', $budget_days[1])));

                return [
                    "id" => $budget->id,
                    "title" => $budget->name,
                    "start" => $start,
                    "end" => $end,
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
