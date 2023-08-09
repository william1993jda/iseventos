<?php

namespace App\Http\Controllers;

use App\Http\Requests\BudgetRequest;
use App\Models\Agency;
use App\Models\Budget;
use App\Models\BudgetRoomLabor;
use App\Models\BudgetRoomProduct;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerContact;
use App\Models\Labor;
use App\Models\OrderService;
use App\Models\Place;
use App\Models\PlaceRoom;
use App\Models\Product;
use App\Models\Settings;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BudgetController extends Controller
{
    public function index(Request $request)
    {
        $places = Place::pluck('name', 'id')->prepend('Selecione', '');
        $customers = Customer::pluck('fantasy_name', 'id')->prepend('Selecione', '');
        $statuses = Status::pluck('name', 'id')->prepend('Selecione', '');

        $params = $request->all();
        $query = [
            'name' => '',
            'budget_days' => '',
            'place_id' => '',
            'customer_id' => '',
            'status_id' => '',
        ];

        if (!empty($params)) {
            $budgets = Budget::orderBy('name', 'ASC');

            if (!empty($params['name'])) {
                $query['name'] = $params['name'];
                $budgets->where('name', 'like', '%' . $params['name'] . '%');
            }

            if (!empty($params['budget_days'])) {
                $query['budget_days'] = $params['budget_days'];

                $budgetDays = explode('-', $params['budget_days']);
                $start = explode('/', trim($budgetDays[0]));
                $startDay = $start[2] . '-' . $start[1] . '-' . $start[0];
                $end = explode('/', trim($budgetDays[1]));
                $endDay = $end[2] . '-' . $end[1] . '-' . $end[0];

                $budgets->whereRaw("STR_TO_DATE(SUBSTRING_INDEX(budget_days, ' - ', 1), '%d/%m/%Y') >= '" . $startDay . "'");
                $budgets->whereRaw("STR_TO_DATE(SUBSTRING_INDEX(budget_days, ' - ', 1), '%d/%m/%Y') <= '" . $endDay . "'");
            }

            if (!empty($params['place_id'])) {
                $query['place_id'] = $params['place_id'];
                $budgets->where('place_id', $params['place_id']);
            }

            if (!empty($params['customer_id'])) {
                $query['customer_id'] = $params['customer_id'];
                $budgets->where('customer_id', $params['customer_id']);
            }

            if (!empty($params['status_id'])) {
                $query['status_id'] = $params['status_id'];
                $budgets->where('status_id', $params['status_id']);
            }

            $budgets = $budgets->paginate(30);

            return view('budgets.index', compact('budgets', 'places', 'customers', 'statuses', 'query'));
        }

        $budgets = Budget::orderBy('name', 'ASC')->paginate(30);

        return view('budgets.index', compact('budgets', 'places', 'customers', 'statuses', 'query'));
    }

    public function create()
    {
        $budget = new Budget();
        $places = Place::pluck('name', 'id')->prepend('Selecione', '');
        $agencies = Agency::pluck('fantasy_name', 'id')->prepend('Selecione', '');
        $customers = Customer::pluck('fantasy_name', 'id')->prepend('Selecione', '');
        $customerContacts = [];

        $settings = Settings::first();

        return view('budgets.form', compact('budget', 'places', 'agencies', 'customers', 'customerContacts', 'settings'));
    }

    public function store(BudgetRequest $request)
    {
        $params = $request->validated();
        $params['status_id'] = 1;

        $budget = Budget::create($params);

        return redirect()->route('budgets.mount', $budget->id);
    }

    public function edit(Budget $budget, $showMode = false)
    {
        $places = Place::pluck('name', 'id')->prepend('Selecione', '');
        $agencies = Agency::pluck('fantasy_name', 'id')->prepend('Selecione', '');
        $customers = Customer::pluck('fantasy_name', 'id')->prepend('Selecione', '');
        $customerContacts = CustomerContact::where('customer_id', $budget->customer_id)->orderBy('name', 'asc')->pluck('name', 'id')->prepend('Selecione', '');

        return view('budgets.form', compact('budget', 'places', 'agencies', 'customers', 'customerContacts', 'showMode'));
    }

    public function update(Budget $budget, BudgetRequest $request)
    {
        $budget->update($request->validated());

        return redirect()->route('budgets.index');
    }

    public function destroy(Budget $budget)
    {
        OrderService::where('budget_id', $budget->id)->delete();
        $budget->delete();

        return redirect()->route('budgets.index');
    }

    public function show(Budget $budget)
    {
        return $this->edit($budget, true);
    }

    public function getCustomerContacts(Request $request)
    {
        $contacts = CustomerContact::where('customer_id', $request->customer_id)->orderBy('name', 'asc')->get();

        return response()->json($contacts);
    }

    public function mount(Budget $budget)
    {
        return view('budgets.mount', compact('budget'));
    }

    public function roomProductDestroy(BudgetRoomProduct $budgetRoomProduct)
    {
        $budget = $budgetRoomProduct->budget;
        $budgetRoomProduct->delete();

        return redirect()->route('budgets.mount', $budget->id);
    }

    public function roomLaborDestroy(BudgetRoomLabor $budgetRoomLabor)
    {
        $budget = $budgetRoomLabor->budget;
        $budgetRoomLabor->delete();

        return redirect()->route('budgets.mount', $budget->id);
    }

    public function print($id)
    {
        $budget = Budget::find($id);

        $data = $budget->toArray();
        $data['request_date'] = $budget->request_date->format('d/m/Y');
        $data['status'] = $budget->status->name;
        $data['budget_number'] = $budget->budget_number;
        $data['observation'] = $budget->observation;
        $data['customer'] = $budget->customer->fantasy_name;
        $data['customer_ein'] = $budget->customer->ein;
        $data['customer_name'] = '';
        $data['customer_phone'] = '';
        $data['customer_email'] = '';

        if (!empty($budget->customer_contact_id)) {
            $customerContact = CustomerContact::find($budget->customer_contact_id);
            $data['customer_name'] = $customerContact->name;
            $data['customer_phone'] = $customerContact->phone;
            $data['customer_email'] = $customerContact->email;
        }

        $data['agency'] = $budget->agency ? $budget->agency->fantasy_name : null;
        $data['place'] = $budget->place ? $budget->place->name : null;
        $data['place_address'] = '';

        if ($budget->place && $budget->place->street) {
            $data['place_address'] = $budget->place->street;

            if ($budget->place->number) {
                $data['place_address'] .= ', ' . $budget->place->number;
            }

            if ($budget->place->complement) {
                $data['place_address'] .= ' - ' . $budget->place->complement;
            }

            if ($budget->place->district) {
                $data['place_address'] .= ' - ' . $budget->place->district;
            }

            if ($budget->place->city) {
                $data['place_address'] .= ' - ' . $budget->place->city;
            }

            if ($budget->place->state) {
                $data['place_address'] .= ' - ' . $budget->place->state;
            }
        }

        $data['city'] = $budget->city;

        $budgetDays = explode('-', $budget->budget_days);

        $data['start_date'] = trim($budgetDays[0]);
        $data['end_date'] = trim($budgetDays[1]);

        if (!empty($budget->start_time)) {
            $data['start_date'] .= ' - ' . substr($budget->start_time, 0, 5);
        }

        if (!empty($budget->end_time)) {
            $data['end_date'] .= ' - ' . substr($budget->end_time, 0, 5);
        }

        $data['mount_date'] = $budget->mount_date ? $budget->mount_date->format('d/m/Y') : null;
        $data['unmount_date'] = $budget->unmount_date ? $budget->unmount_date->format('d/m/Y') : null;
        $data['public'] = $budget->public;
        $data['situation'] = $budget->situation;
        $data['commercial_conditions'] = $budget->commercial_conditions;

        $budgetRoomProducts = BudgetRoomProduct::where('budget_id', $budget->id)->get();
        $budgetRoomLabors = BudgetRoomLabor::where('budget_id', $budget->id)->get();

        $categories = Product::whereIn('id', $budgetRoomProducts->pluck('product_id')->toArray())->groupBy('category_id')->pluck('category_id')->toArray();

        $arCategories = [];

        foreach ($categories as $categoryId) {
            $category = Category::find($categoryId);
            $categoryProducts = [];

            foreach ($budgetRoomProducts as $product) {
                if ($product->product->category_id == $categoryId) {
                    $obProduct = [
                        'id' => $product->id,
                        'name' => $product->product->name,
                        'quantity' => $product->quantity,
                        'days' => $product->days,
                        'price' => $product->price,
                        'place_room_name' => $product->placeRoom ? $product->placeRoom->name : null,
                    ];

                    array_push($categoryProducts, $obProduct);
                }
            }

            $obCategory = [
                'id' => $category->id,
                'name' => $category->name,
                'products' => $categoryProducts,
            ];

            array_push($arCategories, $obCategory);
        }

        $arLabors = [];

        foreach ($budgetRoomLabors as $labor) {
            $obLabor = [
                'id' => $labor->id,
                'name' => $labor->labor->name,
                'quantity' => $labor->quantity,
                'days' => $labor->days,
                'price' => $labor->price,
                'place_room_name' => $labor->placeRoom ? $labor->placeRoom->name : null,
            ];

            array_push($arLabors, $obLabor);
        }

        $budgetDays = explode('-', $budget->budget_days);
        $startDay = implode('-', array_reverse(explode('/', trim($budgetDays[0]))));
        $endDay = implode('-', array_reverse(explode('/', trim($budgetDays[1]))));

        if ($startDay == $endDay) {
            $days = [Carbon::parse($startDay)->format('d/m')];
        } else {
            $difDays = Carbon::parse($startDay)->diffInDays(Carbon::parse($endDay)) - 1;

            $days = [];

            array_push($days, Carbon::parse($startDay)->format('d/m'));

            for ($i = 0; $i < $difDays; $i++) {
                $date = Carbon::parse($startDay)->addDays($i + 1);
                array_push($days, $date->format('d/m'));
            }

            array_push($days, Carbon::parse($endDay)->format('d/m'));
        }

        $data['products'] = [
            'days' => $days,
            'categories' => $arCategories,
        ];

        $data['labors'] = $arLabors;

        // dd($data);

        $pdf = PDF::loadView('pdf.budget', $data);
        return $pdf->stream();
    }
}
