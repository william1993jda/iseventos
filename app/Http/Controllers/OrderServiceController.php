<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderServiceRequest;
use App\Models\Agency;
use App\Models\Budget;
use App\Models\CustomerContact;
use App\Models\OsStatus;
use App\Models\OrderService;
use App\Models\OrderServiceRoomFreelancer;
use App\Models\OrderServiceRoomGroup;
use App\Models\OrderServiceRoomProduct;
use App\Models\OrderServiceRoomProvider;
use App\Models\OsCategory;
use App\Models\OsProduct;
use App\Models\PlaceRoom;
use App\Models\Provider;
use App\Models\Settings;
use App\Models\User;
use App\Models\Customer;
use App\Models\Place;
use App\Models\Status;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class OrderServiceController extends Controller
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
            $orderServices = OrderService::orderBy('order_services.id', 'DESC');
            $orderServices->join('budgets', 'budgets.id', '=', 'order_services.budget_id');

            if (!empty($params['name'])) {
                $query['name'] = $params['name'];
                $orderServices->where('budgets.name', 'like', '%' . $params['name'] . '%');
            }

            if (!empty($params['budget_days'])) {
                $query['budget_days'] = $params['budget_days'];

                $budgetDays = explode('-', $params['budget_days']);
                $start = explode('/', trim($budgetDays[0]));
                $startDay = $start[2] . '-' . $start[1] . '-' . $start[0];
                $end = explode('/', trim($budgetDays[1]));
                $endDay = $end[2] . '-' . $end[1] . '-' . $end[0];

                $orderServices->whereRaw("STR_TO_DATE(SUBSTRING_INDEX(budgets.budget_days, ' - ', 1), '%d/%m/%Y') >= '" . $startDay . "'");
                $orderServices->whereRaw("STR_TO_DATE(SUBSTRING_INDEX(budgets.budget_days, ' - ', 1), '%d/%m/%Y') <= '" . $endDay . "'");
            }

            if (!empty($params['place_id'])) {
                $query['place_id'] = $params['place_id'];
                $orderServices->where('budgets.place_id', $params['place_id']);
            }

            if (!empty($params['customer_id'])) {
                $query['customer_id'] = $params['customer_id'];
                $orderServices->where('budgets.customer_id', $params['customer_id']);
            }

            if (!empty($params['status_id'])) {
                $query['status_id'] = $params['status_id'];
                $orderServices->where('os_status_id', $params['status_id']);
            }

            $orderServices = $orderServices->paginate(30);
            $budgets = [];

            // dd($orderServices);

            return view('order-services.index', compact('budgets', 'orderServices', 'places', 'customers', 'statuses', 'query'));
        }

        $orderServices = OrderService::orderBy('id', 'DESC');

        $budgetIds = $orderServices->pluck('budget_id')->unique()->toArray();
        $statusApproved = Status::where('slug', 'aprovado')->first();
        $budgets = Budget::whereNotIn('id', $budgetIds)->where('status_id', $statusApproved->id)->orderBy('id', 'DESC')->paginate(10);

        $orderServices = $orderServices->paginate(30);

        return view('order-services.index', compact('budgets', 'orderServices', 'places', 'customers', 'statuses', 'query'));
    }

    public function create(Budget $budget)
    {
        $orderService = OrderService::create([
            'os_status_id' => 1,
            'budget_id' => $budget->id,
            'os_number' => (int) OrderService::withTrashed()->max('os_number') + 1,
            'os_version' => 1,
            'budget_version' => $budget->budget_version,
        ]);

        $orderServicesToday = OrderService::join('budgets', 'budgets.id', '=', 'order_services.budget_id')
            ->where('budgets.mount_date', '=', $orderService->budget->mount_date)
            ->count();

        if ($orderServicesToday > 3) {
            return redirect()->route('orderServices.mount')->with('warning', 'Já existem 3 ou mais eventos nesta mesma data.');
        }

        return redirect()->route('orderServices.mount', $orderService->id);
    }

    public function store(OrderServiceRequest $request)
    {
        $params = $request->validated();
        $params['os_status_id'] = 1;
        $params['os_number'] = (int) OrderService::max('os_number') + 1;

        $orderService = OrderService::create($params);

        $orderServicesToday = OrderService::join('budgets', 'budgets.id', '=', 'order_services.budget_id')
            ->where('budgets.mount_date', '=', $orderService->budget->mount_date)
            ->count();

        if ($orderServicesToday > 3) {
            return redirect()->route('orderServices.index')->with('warning', 'Já existem 3 ou mais eventos nesta mesma data.');
        }

        // return redirect()->route('orderServices.index');
        return redirect()->route('orderServices.mount', $orderService->id);
    }

    public function edit(OrderService $orderService, $showMode = false)
    {
        $osStatuses = OsStatus::pluck('name', 'id')->prepend('Selecione', '');
        $budgets = Budget::pluck('name', 'id')->prepend('Selecione', '');

        return view('order-services.form', compact('orderService', 'osStatuses', 'budgets', 'showMode'));
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
        return $this->edit($orderService, true);
    }

    public function mount(OrderService $orderService)
    {
        return view('order-services.mount', compact('orderService'));
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

    public function roomFreelancerDestroy(OrderServiceRoomFreelancer $orderServiceRoomFreelancer)
    {
        $orderService = $orderServiceRoomFreelancer->orderService;
        $orderServiceRoomFreelancer->delete();

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

            $freelancers = OrderServiceRoomFreelancer::where('order_service_id', $orderService->id)->where('place_room_id', $placeRoom->id);
            $freelancersList = $freelancers->get();

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
                    'freelancers' => [],
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
                    'freelancers' => [],
                ]);
            }

            if (count($freelancersList) > 0) {
                $freelancers = $freelancersList->map(function ($freelancer) {
                    $arFreelancer = $freelancer->toArray();
                    $arFreelancer['freelancer'] = $freelancer->freelancer->toArray();
                    return $arFreelancer;
                })->toArray();

                array_push($arCategories, [
                    'id' => 0,
                    'name' => 'FREELANCER',
                    'products' => [],
                    'providers' => [],
                    'groups' => [],
                    'freelancers' => $freelancers,
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

    public function printProvider(OrderService $orderService, Provider $provider)
    {
        $orderServiceRoomProviders = OrderServiceRoomProvider::where('order_service_id', $orderService->id)->get();

        $arProducts = [];

        foreach ($orderServiceRoomProviders as $orderServiceRoomProvider) {
            if ($orderServiceRoomProvider->osProduct->provider_id == $provider->id) {
                array_push($arProducts, [
                    'id' => $orderServiceRoomProvider->osProduct->id,
                    'name' => $orderServiceRoomProvider->osProduct->name,
                    'quantity' => $orderServiceRoomProvider->quantity,
                    'days' => $orderServiceRoomProvider->days,
                ]);
            }
        }

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


        $data['fantasy_name'] = $provider->fantasy_name;
        $data['os_number'] = $orderService->os_number;
        $data['products'] = $arProducts;
        $data['last_user_name'] = $orderService->last_user_id ? $orderService->lastUser->name : '';

        $pdf = PDF::loadView('pdf.orderServiceProvider', $data);
        return $pdf->stream();
    }

    public function printFreelancer(OrderService $orderService)
    {
        $orderServiceRoomFreelancers = OrderServiceRoomFreelancer::where('order_service_id', $orderService->id)->get();

        $arFreelancers = [];

        foreach ($orderServiceRoomFreelancers as $freelancer) {
            $obFreelancer = [
                'id' => $freelancer->id,
                'name' => $freelancer->freelancer->name,
                'quantity' => $freelancer->quantity,
                'days' => $freelancer->days,
                'place_room_id' => $freelancer->place_room_id,
            ];

            array_push($arFreelancers, $obFreelancer);
        }

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


        // $data['fantasy_name'] = $provider->fantasy_name;
        $data['os_number'] = $orderService->os_number;
        $data['products'] = $arFreelancers;
        $data['last_user_name'] = $orderService->last_user_id ? $orderService->lastUser->name : '';

        // dd($data);

        $pdf = PDF::loadView('pdf.orderServiceFreelancer', $data);
        return $pdf->stream();
    }
}
