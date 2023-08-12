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
use Illuminate\Support\Facades\Log;

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
        $params = $request->validated();

        if ($budget->budget_days != $params['budget_days']) {
            $budgetDays = explode('-', $params['budget_days']);
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

            BudgetRoomProduct::where('budget_id', $budget->id)->update(['days' => implode(',', $days)]);
        }

        $budget->update($params);

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
        $placeRoomIds = array_unique(array_merge($budgetRoomProducts->pluck('place_room_id')->toArray(), $budgetRoomLabors->pluck('place_room_id')->toArray()));

        $arRooms = [];

        foreach ($placeRoomIds as $placeRoomId) {
            if (!empty($placeRoomId)) {
                $placeRoom = PlaceRoom::find($placeRoomId);
                $arRooms[$placeRoom->id] = [
                    'name' => $placeRoom->name,
                    'categories' => []
                ];
            }
        }

        foreach ($arRooms as $placeRoomId => $arRoom) {
            if ($placeRoomId != 0) {
                $productIds = $budgetRoomProducts->where('place_room_id', $placeRoomId)->pluck('product_id')->toArray();
                $categoryIds = Product::whereIn('id', $productIds)->groupBy('category_id')->pluck('category_id')->toArray();

                $arCategories = [];

                foreach ($categoryIds as $categoryId) {
                    $category = Category::find($categoryId);

                    $arCategoryProducts = [];
                    $arCategoryLabors = [];

                    foreach ($budgetRoomProducts->where('place_room_id', $placeRoomId) as $budgetRoomProduct) {
                        if ($budgetRoomProduct->product->category_id == $categoryId) {

                            $days = count(explode(',', $budgetRoomProduct->days));
                            $bv = (int) $budgetRoomProduct->bv;

                            $obProduct = [
                                'id' => $budgetRoomProduct->id,
                                'name' => $budgetRoomProduct->product->name,
                                'quantity' => $budgetRoomProduct->quantity,
                                'days' => $days,
                                'price' => $bv > 0 ? $budgetRoomProduct->price + ($budgetRoomProduct->price * ($bv / 100)) : $budgetRoomProduct->price,
                                'place_room_name' => $budgetRoomProduct->placeRoom ? $budgetRoomProduct->placeRoom->name : null,
                            ];

                            array_push($arCategoryProducts, $obProduct);
                        }
                    }

                    $obCategory = [
                        'id' => $category->id,
                        'name' => $category->name,
                        'products' => $arCategoryProducts,
                    ];

                    array_push($arCategories, $obCategory);
                }

                foreach ($budgetRoomLabors->where('place_room_id', $placeRoomId) as $budgetRoomLabor) {
                    $bv = (int) $budgetRoomLabor->bv;

                    $obLabor = [
                        'id' => $budgetRoomLabor->id,
                        'name' => $budgetRoomLabor->labor->name,
                        'quantity' => $budgetRoomLabor->quantity,
                        'days' => $budgetRoomLabor->days,
                        'price' => $bv > 0 ? $budgetRoomLabor->price + ($budgetRoomLabor->price * ($bv / 100)) : $budgetRoomLabor->price,
                        'place_room_name' => $budgetRoomLabor->placeRoom ? $budgetRoomLabor->placeRoom->name : null,
                    ];

                    array_push($arCategoryLabors, $obLabor);
                }

                if (count($arCategoryLabors) > 0) {
                    $obCategory = [
                        'id' => 0,
                        'name' => 'MÃO DE OBRA',
                        'products' => $arCategoryLabors,
                    ];

                    array_push($arCategories, $obCategory);
                }


                $arRooms[$placeRoomId]['categories'] = $arCategories;
            }
        }

        if ($budgetRoomProducts->whereNull('place_room_id')->count() > 0 || $budgetRoomLabors->whereNull('place_room_id')->count() > 0) {
            $productIds = $budgetRoomProducts->whereNull('place_room_id')->pluck('product_id')->toArray();
            $categoryIds = Product::whereIn('id', $productIds)->groupBy('category_id')->pluck('category_id')->toArray();

            $arCategories = [];

            foreach ($categoryIds as $categoryId) {
                $category = Category::find($categoryId);

                $arCategoryProducts = [];
                $arCategoryLabors = [];

                foreach ($budgetRoomProducts->whereNull('place_room_id') as $budgetRoomProduct) {
                    if ($budgetRoomProduct->product->category_id == $categoryId) {

                        $days = count(explode(',', $budgetRoomProduct->days));
                        $bv = (int) $budgetRoomProduct->bv;

                        $obProduct = [
                            'id' => $budgetRoomProduct->id,
                            'name' => $budgetRoomProduct->product->name,
                            'quantity' => $budgetRoomProduct->quantity,
                            'days' => $days,
                            'price' => $bv > 0 ? $budgetRoomProduct->price + ($budgetRoomProduct->price * ($bv / 100)) : $budgetRoomProduct->price,
                            'place_room_name' => $budgetRoomProduct->placeRoom ? $budgetRoomProduct->placeRoom->name : null,
                        ];

                        array_push($arCategoryProducts, $obProduct);
                    }
                }

                $obCategory = [
                    'id' => $category->id,
                    'name' => $category->name,
                    'products' => $arCategoryProducts,
                ];

                array_push($arCategories, $obCategory);
            }

            foreach ($budgetRoomLabors->whereNull('place_room_id') as $budgetRoomLabor) {
                $bv = (int) $budgetRoomProduct->bv;

                $obLabor = [
                    'id' => $budgetRoomLabor->id,
                    'name' => $budgetRoomLabor->labor->name,
                    'quantity' => $budgetRoomLabor->quantity,
                    'days' => $budgetRoomLabor->days,
                    'price' => $bv > 0 ? $budgetRoomLabor->price + ($budgetRoomLabor->price * ($bv / 100)) : $budgetRoomLabor->price,
                    'place_room_name' => $budgetRoomLabor->placeRoom ? $budgetRoomLabor->placeRoom->name : null,
                ];

                array_push($arCategoryLabors, $obLabor);
            }

            if (count($arCategoryLabors) > 0) {
                $obCategory = [
                    'id' => 0,
                    'name' => 'MÃO DE OBRA',
                    'products' => $arCategoryLabors,
                ];

                array_push($arCategories, $obCategory);
            }

            $arRooms[0] = [
                'name' => '-',
                'categories' => $arCategories
            ];
        }

        $data['rooms'] = $arRooms;

        $pdf = PDF::loadView('pdf.budget', $data);
        return $pdf->stream();
    }
}
