<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderServiceRequest;
use App\Models\Agency;
use App\Models\Budget;
use App\Models\CustomerContact;
use App\Models\OsStatus;
use App\Models\OrderService;
use App\Models\OrderServiceRoomGroup;
use App\Models\OrderServiceRoomProduct;
use App\Models\OrderServiceRoomProvider;
use App\Models\OsCategory;
use App\Models\OsProduct;
use App\Models\PlaceRoom;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class OrderServiceController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($query) {
            $orderServices = Budget::where('name', 'like', '%' . $query . '%')
                ->paginate(10);

            return view('orderServices.index', compact('orderServices', 'query'));
        }

        $orderServices = OrderService::paginate(10);

        return view('orderServices.index', compact('orderServices', 'query'));
    }

    public function create()
    {
        $orderService = new OrderService();
        $osStatuses = OsStatus::pluck('name', 'id')->prepend('Selecione', '');
        $budgets = Budget::pluck('name', 'id')->prepend('Selecione', '');


        return view('orderServices.form', compact('orderService', 'budgets', 'osStatuses'));
    }

    public function store(OrderServiceRequest $request)
    {
        $params = $request->validated();
        $params['os_number'] = (int) OrderService::max('os_number') + 1;

        OrderService::create($params);

        return redirect()->route('orderServices.index');
    }

    public function edit(OrderService $orderService)
    {
        $os_statuses = OsStatus::pluck('name', 'id')->prepend('Selecione', '');
        $budgets = Budget::pluck('name', 'id')->prepend('Selecione', '');


        return view('orderServices.form', compact('orderService', 'os_statuses', 'budgets'));
    }

    public function update(OrderService $orderService, OrderServiceRequest $request)
    {
        $orderService->update($request->validated());

        return redirect()->route('orderServices.index');
    }

    public function destroy(OrderService $orderService)
    {
        $orderService->delete();

        return redirect()->route('orderServices.index');
    }

    public function show(OrderService $orderService)
    {
        $showMode = true;

        return view('orderServices.form', compact('orderService', 'showMode'));
    }

    public function mount(OrderService $orderService)
    {
        return view('orderServices.mount', compact('orderService'));
    }


    public function roomProductDestroy(OrderServiceRoomProduct $orderServiceRoomProduct)
    {
        $orderService = $orderServiceRoomProduct->orderService;
        $orderServiceRoomProduct->delete();

        return redirect()->route('orderServices.mount', $orderService->id);
    }

    public function roomProviderDestroy(OrderServiceRoomProvider $orderServiceRoomProvider)
    {
        $orderService = $orderServiceRoomProvider->orderService;
        $orderServiceRoomProvider->delete();

        return redirect()->route('orderServices.mount', $orderService->id);
    }

    public function roomGroupDestroy(OrderServiceRoomGroup $orderServiceRoomGroup)
    {
        $orderService = $orderServiceRoomGroup->orderService;
        $orderServiceRoomGroup->delete();

        return redirect()->route('orderServices.mount', $orderService->id);
    }


    public function print($id)
    {
        $orderService = OrderService::find($id);

        $data = $orderService->toArray();
        $data['name'] = $orderService->budget->name;
        $data['request_date'] = $orderService->budget->request_date->format('d/m/Y');
        $data['observation'] = $orderService->observation;
        $data['customer'] = $orderService->budget->customer->fantasy_name;
        $data['customer_name'] = '';
        $data['customer_phone'] = '';
        $data['customer_email'] = '';

        if (!empty($orderService->budget->customer_contact_id)) {
            $customerContact = CustomerContact::find($orderService->budget->customer_contact_id);
            $data['customer_name'] = $customerContact->name;
            $data['customer_phone'] = $customerContact->phone;
            $data['customer_email'] = $customerContact->email;
        }

        $data['agency'] = $orderService->budget->agency ? $orderService->budget->agency->fantasy_name : null;
        $data['place'] = $orderService->budget->place->name;
        $data['city'] = $orderService->budget->city;

        $budgetDays = explode('-', $orderService->budget->budget_days);

        $data['start_date'] = trim($budgetDays[0]);
        $data['end_date'] = trim($budgetDays[1]);
        $data['mount_date'] = $orderService->budget->mount_date ? $orderService->budget->mount_date->format('d/m/Y') : null;
        $data['unmount_date'] = $orderService->budget->unmount_date ? $orderService->budget->unmount_date->format('d/m/Y') : null;
        $data['public'] = $orderService->budget->public;
        $data['situation'] = $orderService->budget->situation;
        $data['commercial_conditions'] = $orderService->budget->commercial_conditions;

        // $budgetRoomProducts = BudgetRoomProduct::where('budget_id', $orderService->id)->pluck('place_room_id')->toArray();
        // $budgetRoomLabors = BudgetRoomLabor::where('budget_id', $orderService->id)->pluck('place_room_id')->toArray();
        // $placeRoomIds = array_unique(array_merge($budgetRoomProducts, $budgetRoomLabors));

        // $arRoom = [];

        // foreach ($placeRoomIds as $placeRoomId) {
        //     $placeRoom = PlaceRoom::find($placeRoomId);

        //     $products = BudgetRoomProduct::where('budget_id', $budget->id)->where('place_room_id', $placeRoom->id);
        //     $productsId = $products->pluck('product_id')->toArray();
        //     $productsList = $products->get();
        //     $labors = BudgetRoomLabor::where('budget_id', $budget->id)->where('place_room_id', $placeRoom->id);
        //     $laborsId = $labors->pluck('labor_id')->toArray();
        //     $laborsList = $labors->get();
        //     $categoryProductsId = Product::whereIn('id', $productsId)->groupBy('category_id')->pluck('category_id')->toArray();
        //     $categoryLaborsId = Labor::whereIn('id', $laborsId)->groupBy('category_id')->pluck('category_id')->toArray();
        //     $categoriesId = array_unique(array_merge($categoryProductsId, $categoryLaborsId));

        //     $arCategories = [];

        //     foreach ($categoriesId as $categoryId) {
        //         $category = Category::find($categoryId);
        //         $categoryProducts = [];
        //         $categoryLabors = [];

        //         foreach ($productsList as $product) {
        //             if ($product->product->category_id == $categoryId) {
        //                 array_push($categoryProducts, $product->toArray());
        //             }
        //         }

        //         foreach ($laborsList as $labor) {
        //             if ($labor->labor->category_id == $categoryId) {
        //                 array_push($categoryLabors, $labor->toArray());
        //             }
        //         }

        //         $obCategory = [
        //             'id' => $category->id,
        //             'name' => $category->name,
        //             'products' => $categoryProducts,
        //             'labors' => $categoryLabors,
        //         ];

        //         array_push($arCategories, $obCategory);
        //     }

        //     $budgetDays = explode('-', $budget->budget_days);
        //     $startDay = implode('-', array_reverse(explode('/', trim($budgetDays[0]))));
        //     $endDay = implode('-', array_reverse(explode('/', trim($budgetDays[1]))));

        //     $diifDays = Carbon::parse($startDay)->diffInDays(Carbon::parse($endDay)) - 1;

        //     $days = [];

        //     array_push($days, Carbon::parse($startDay)->format('d/m'));

        //     for ($i = 0; $i < $diifDays; $i++) {
        //         $date = Carbon::parse($startDay)->addDays($i + 1);
        //         array_push($days, $date->format('d/m'));
        //     }

        //     array_push($days, Carbon::parse($endDay)->format('d/m'));

        //     $arRoom[] = [
        //         'place_room_name' => $placeRoom->name,
        //         'place_room_id' => $placeRoom->id,
        //         'days' => $days,
        //         'categories' => $arCategories,
        //     ];
        // }

        $orderServiceRoomProducts = OrderServiceRoomProduct::where('order_service_id', $orderService->id)->pluck('place_room_id')->toArray();
        $orderServiceRoomProviders = OrderServiceRoomProvider::where('order_service_id', $orderService->id)->pluck('place_room_id')->toArray();
        $orderServiceRoomGroups = OrderServiceRoomGroup::where('order_service_id', $orderService->id)->pluck('place_room_id')->toArray();
        $placeRoomIds = array_unique(array_merge($orderServiceRoomProducts, $orderServiceRoomProviders, $orderServiceRoomGroups));

        $arRoom = [];

        foreach ($placeRoomIds as $placeRoomId) {
            $placeRoom = PlaceRoom::find($placeRoomId);

            $products = OrderServiceRoomProduct::where('order_service_id', $orderService->id)->where('place_room_id', $placeRoom->id);
            $productsId = $products->pluck('os_product_id')->toArray();
            $productsList = $products->get();

            $providers = OrderServiceRoomProvider::where('order_service_id', $orderService->id)->where('place_room_id', $placeRoom->id);
            $providersId = $providers->pluck('os_product_id')->toArray();
            $providersList = $providers->get();

            $groups = OrderServiceRoomGroup::where('order_service_id', $orderService->id)->where('place_room_id', $placeRoom->id);
            $groupsId = $groups->pluck('group_id')->toArray();
            $groupsList = $groups->get();

            $categoryProductsId = OsProduct::whereIn('id', $productsId)->groupBy('os_category_id')->pluck('os_category_id')->toArray();
            $categoryProvidersId = OsProduct::whereIn('id', $providersId)->groupBy('os_category_id')->pluck('os_category_id')->toArray();
            $categoriesId = array_unique(array_merge($categoryProductsId, $categoryProvidersId));

            $arCategories = [];

            foreach ($categoriesId as $categoryId) {
                $category = OsCategory::find($categoryId);
                $categoryProducts = [];
                $categoryProviders = [];

                foreach ($productsList as $product) {
                    if ($product->osProduct->os_category_id == $categoryId) {
                        array_push($categoryProducts, $product->toArray());
                    }
                }

                foreach ($providersList as $provider) {
                    if ($provider->osProduct->os_category_id == $categoryId) {

                        $arProvider = $provider->toArray();
                        $arProvider['os_product'] = $provider->osProduct->toArray();
                        $arProvider['os_product']['provider'] = $provider->osProduct->provider->toArray();

                        array_push($categoryProviders, $arProvider);
                    }
                }

                $obCategory = [
                    'id' => $category->id,
                    'name' => $category->name,
                    'products' => $categoryProducts,
                    'providers' => $categoryProviders,
                    'groups' => [],
                ];

                array_push($arCategories, $obCategory);
            }

            if (count($groupsList) > 0) {

                $arGroups = [];

                foreach ($groupsList as $group) {
                    $arGroup = $group->toArray();
                    $arGroup['group'] = $group->group->toArray();
                    $arGroup['group']['products'] = $group->group->products->map(function ($product) {
                        return [
                            'id' => $product->os_product_id,
                            'name' => $product->product->name,
                        ];
                    })->toArray();

                    array_push($arGroups, $arGroup);
                }

                array_push($arCategories, [
                    'id' => 0,
                    'name' => 'KITS',
                    'products' => [],
                    'providers' => [],
                    'groups' => $arGroups,
                ]);
            }

            $budgetDays = explode('-', $orderService->budget->budget_days);
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

        // dd($data);

        $pdf = PDF::loadView('pdf.orderService', $data);
        return $pdf->stream();
    }
}
