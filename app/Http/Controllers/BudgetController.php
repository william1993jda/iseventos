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
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class BudgetController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($query) {
            $budgets = Budget::where('name', 'like', '%' . $query . '%')
                ->paginate(10);

            return view('budgets.index', compact('budgets', 'query'));
        }

        $budgets = Budget::paginate(10);

        return view('budgets.index', compact('budgets', 'query'));
    }

    public function create()
    {
        $budget = new Budget();
        $places = Place::pluck('name', 'id')->prepend('Selecione', '');
        $agencies = Agency::pluck('fantasy_name', 'id')->prepend('Selecione', '');
        $customers = Customer::pluck('fantasy_name', 'id')->prepend('Selecione', '');

        $settings = Settings::first();

        return view('budgets.form', compact('budget', 'places', 'agencies', 'customers', 'settings'));
    }

    public function store(BudgetRequest $request)
    {
        $params = $request->validated();
        $params['status_id'] = 1;
        $params['budget_number'] = (int) Budget::max('budget_number') + 1;

        $budget = Budget::create($params);

        return redirect()->route('budgets.mount', $budget->id);
    }

    public function edit(Budget $budget, $showMode = false)
    {
        $places = Place::pluck('name', 'id')->prepend('Selecione', '');
        $agencies = Agency::pluck('fantasy_name', 'id')->prepend('Selecione', '');
        $customers = Customer::pluck('fantasy_name', 'id')->prepend('Selecione', '');

        return view('budgets.form', compact('budget', 'places', 'agencies', 'customers', 'showMode'));
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
        $data['place'] = $budget->place->name;
        $data['place_address'] = '';

        if ($budget->place->street) {
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

        $budgetRoomProducts = BudgetRoomProduct::where('budget_id', $budget->id)->pluck('place_room_id')->toArray();
        $budgetRoomLabors = BudgetRoomLabor::where('budget_id', $budget->id)->pluck('place_room_id')->toArray();
        $placeRoomIds = array_unique(array_merge($budgetRoomProducts, $budgetRoomLabors));

        $arRoom = [];

        foreach ($placeRoomIds as $placeRoomId) {
            $placeRoom = PlaceRoom::find($placeRoomId);

            $products = BudgetRoomProduct::where('budget_id', $budget->id)->where('place_room_id', $placeRoom->id);
            $productsId = $products->pluck('product_id')->toArray();
            $productsList = $products->get();
            $labors = BudgetRoomLabor::where('budget_id', $budget->id)->where('place_room_id', $placeRoom->id);
            $laborsId = $labors->pluck('labor_id')->toArray();
            $laborsList = $labors->get();
            $categoryProductsId = Product::whereIn('id', $productsId)->groupBy('category_id')->pluck('category_id')->toArray();
            $categoryLaborsId = Labor::whereIn('id', $laborsId)->groupBy('category_id')->pluck('category_id')->toArray();
            $categoriesId = array_unique(array_merge($categoryProductsId, $categoryLaborsId));

            $arCategories = [];

            foreach ($categoriesId as $categoryId) {
                $category = Category::find($categoryId);
                $categoryProducts = [];
                $categoryLabors = [];

                foreach ($productsList as $product) {
                    if ($product->product->category_id == $categoryId) {
                        array_push($categoryProducts, $product->toArray());
                    }
                }

                foreach ($laborsList as $labor) {
                    if ($labor->labor->category_id == $categoryId) {
                        array_push($categoryLabors, $labor->toArray());
                    }
                }

                $obCategory = [
                    'id' => $category->id,
                    'name' => $category->name,
                    'products' => $categoryProducts,
                    'labors' => $categoryLabors,
                ];

                array_push($arCategories, $obCategory);
            }

            $budgetDays = explode('-', $budget->budget_days);
            $startDay = implode('-', array_reverse(explode('/', trim($budgetDays[0]))));
            $endDay = implode('-', array_reverse(explode('/', trim($budgetDays[1]))));

            $diifDays = Carbon::parse($startDay)->diffInDays(Carbon::parse($endDay)) - 1;

            $days = [];

            array_push($days, Carbon::parse($startDay)->format('d/m'));

            for ($i = 0; $i < $diifDays; $i++) {
                $date = Carbon::parse($startDay)->addDays($i + 1);
                array_push($days, $date->format('d/m'));
            }

            array_push($days, Carbon::parse($endDay)->format('d/m'));

            $arRoom[] = [
                'place_room_name' => $placeRoom->name,
                'place_room_id' => $placeRoom->id,
                'days' => $days,
                'categories' => $arCategories,
            ];
        }

        $data['rooms'] = $arRoom;

        $pdf = PDF::loadView('pdf.budget', $data);
        return $pdf->stream();
    }
}
