<?php

namespace App\Http\Livewire;

use App\Models\BudgetRoomLabor;
use App\Models\BudgetRoomProduct;
use App\Models\Category;
use App\Models\Freelancer;
use App\Models\Group;
use App\Models\Labor;
use App\Models\OrderServiceRoomFreelancer;
use App\Models\OrderServiceRoomGroup;
use App\Models\OrderServiceRoomLabor;
use App\Models\OrderServiceRoomProduct;
use App\Models\OrderServiceRoomProvider;
use App\Models\OsCategory;
use App\Models\OsProduct;
use App\Models\OsStatus;
use App\Models\PlaceRoom;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Status;
use Carbon\Carbon;
use Livewire\Component;

class OrderServiceMountLivewire extends Component
{
    public $orderService;
    public $osCategories = [];
    public $categories = [];
    public $osStatuses = [];
    public $products = [];
    public $providers = [];
    public $printProviders = [];
    public $groups = [];
    public $placeRooms = [];
    public $rooms = [];
    public $dataOrderService = [];
    public $dataProduct = [];
    public $dataLabor = [];
    public $dataFreelancer = [];
    public $dataProvider = [];
    public $dataGroup = [];
    public $dataStatus = [];
    public $listProducts = [];

    public function mount($orderService)
    {
        $this->osCategories = OsCategory::pluck('name', 'id')->prepend('Selecione', '');
        $this->osStatuses = OsStatus::pluck('name', 'id')->prepend('Selecione', '');
        $this->placeRooms = $orderService->budget->place->rooms->pluck('name', 'id')->prepend('Selecione', '');
        $this->groups = Group::pluck('name', 'id')->prepend('Selecione', '');

        $this->mountOrderService();
    }

    public function mountOrderService()
    {
        $this->dataProduct = [];

        $orderServiceRoomProducts = OrderServiceRoomProduct::where('order_service_id', $this->orderService->id)->get();
        $osCategories = OsProduct::whereIn('id', $orderServiceRoomProducts->pluck('os_product_id')->toArray())->groupBy('os_category_id')->pluck('os_category_id')->toArray();

        $arOsCategories = [];

        foreach ($osCategories as $osCategoryId) {
            $osCategory = OsCategory::find($osCategoryId);
            $osCategoryProducts = [];

            foreach ($orderServiceRoomProducts as $product) {
                if ($product->osProduct->os_category_id == $osCategoryId) {
                    $obProduct = [
                        'id' => $product->id,
                        'name' => $product->osProduct->name,
                        'quantity' => $product->quantity,
                        'days' => $product->days,
                        'place_room_id' => $product->place_room_id,
                    ];

                    array_push($osCategoryProducts, $obProduct);
                }
            }

            $obCategory = [
                'id' => $osCategory->id,
                'name' => $osCategory->name,
                'products' => $osCategoryProducts,
            ];

            array_push($arOsCategories, $obCategory);
        }

        $budgetDays = explode('-', $this->orderService->budget->budget_days);
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

        $this->listProducts = [
            'days' => $days,
            'categories' => $arOsCategories,
        ];

        // dd($this->listProducts);


        $orderServiceRoomProducts = OrderServiceRoomProduct::where('order_service_id', $this->orderService->id)->pluck('place_room_id')->toArray();
        $orderServiceRoomProviders = OrderServiceRoomProvider::where('order_service_id', $this->orderService->id)->pluck('place_room_id')->toArray();
        $orderServiceRoomGroups = OrderServiceRoomGroup::where('order_service_id', $this->orderService->id)->pluck('place_room_id')->toArray();
        $placeRoomIds = array_unique(array_merge($orderServiceRoomProducts, $orderServiceRoomProviders, $orderServiceRoomGroups));

        $arRoom = [];

        foreach ($placeRoomIds as $placeRoomId) {
            $placeRoom = PlaceRoom::find($placeRoomId);

            $products = OrderServiceRoomProduct::where('order_service_id', $this->orderService->id)->where('place_room_id', $placeRoom->id);
            $productsId = $products->pluck('os_product_id')->toArray();
            $productsList = $products->get();

            $labors = OrderServiceRoomLabor::where('order_service_id', $this->orderService->id)->where('place_room_id', $placeRoom->id);
            $laborsId = $labors->pluck('labor_id')->toArray();
            $laborsList = $labors->get();

            $providers = OrderServiceRoomProvider::where('order_service_id', $this->orderService->id)->where('place_room_id', $placeRoom->id);
            $providersId = $providers->pluck('os_product_id')->toArray();
            $providersList = $providers->get();

            $groups = OrderServiceRoomGroup::where('order_service_id', $this->orderService->id)->where('place_room_id', $placeRoom->id);
            $groupsList = $groups->get();

            $freelancers = OrderServiceRoomFreelancer::where('order_service_id', $this->orderService->id)->where('place_room_id', $placeRoom->id);
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

            $budgetDays = explode('-', $this->orderService->budget->budget_days);
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

        $this->rooms = $arRoom;

        // dd($this->rooms);
    }

    public function render()
    {
        return view('order-services.livewire.mount');
    }

    public function addProduct()
    {
        $this->dataProduct = [];
        $this->emit('productError', null);
        return $this->emit('addProduct');
    }

    public function addLabor()
    {
        $categories = category::pluck('name', 'id')->prepend('Selecione', '');

        $this->emit('addLabor', $categories);
    }

    public function addFreelancer()
    {
        $freelancers = Freelancer::pluck('name', 'id')->prepend('Selecione', '');

        $this->emit('addFreelancer', $freelancers);
    }

    public function addProvider()
    {
        $providers = Provider::pluck('fantasy_name', 'id')->prepend('Selecione', '');

        $this->emit('addProvider', $providers);
    }

    public function addKit()
    {
        $this->dataProduct = [];
        $this->emit('kitError', null);
        return $this->emit('addKit');
    }

    public function editStatus()
    {
        $this->emit('editStatus');
    }

    public function editObservation()
    {
        $this->dataOrderService['observation'] = $this->orderService->observation;
        $this->emit('editObservation');
    }

    public function onSelectOsCategory(OsCategory $osCategory)
    {
        $products = $osCategory->products->pluck('name', 'id');

        $this->emit('updateProductList', $products);
    }

    public function onSelectCategoryLabor(Category $category)
    {
        $labors = $category->labors->pluck('name', 'id');

        $this->emit('updateLaborList', $labors);
    }

    public function onSelectProvider(Provider $provider)
    {
        $osCategoryIds = OsProduct::where('provider_id', $provider->id)->pluck('os_category_id')->toArray();

        $osCategories = OsCategory::whereIn('id', $osCategoryIds)->pluck('name', 'id')->prepend('Selecione', '');

        $this->emit('updateProviderCategoryList', $osCategories);
    }

    public function onSelectCategoryProvider(OsCategory $osCategory)
    {
        $products = $osCategory->products->where('provider_id', $this->dataProvider['provider_id'])->pluck('name', 'id');

        $this->emit('updateProviderProductList', $products);
    }

    public function saveObservation()
    {
        $this->orderService->update($this->dataOrderService);

        return $this->emit('saved');
    }

    public function saveProduct()
    {
        $errors = [];

        if (empty($this->dataProduct['os_category_id'])) {
            $errors['os_category_id'] = 'o campo categoria é obrigatório';
        }

        if (empty($this->dataProduct['product_id'])) {
            $errors['product_id'] = 'o campo equipamento é obrigatório';
        }

        if (empty($this->dataProduct['place_room_id'])) {
            $errors['place_room_id'] = 'o campo sala é obrigatório';
        }

        if (empty($this->dataProduct['quantity'])) {
            $errors['quantity'] = 'o campo quantidade é obrigatório';
        }

        if (count($errors) > 0) {
            return $this->emit('productError', $errors);
        } else {
            $this->emit('productError', null);
        }

        $budgetDays = explode('-', $this->orderService->budget->budget_days);
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

        OrderServiceRoomProduct::create([
            'order_service_id' => $this->orderService->id,
            'place_room_id' => $this->dataProduct['place_room_id'],
            'os_product_id' => $this->dataProduct['product_id'],
            'days' => implode(',', $days),
            'quantity' => $this->dataProduct['quantity'],
        ]);

        $this->dataProduct = [];
        $this->emit('productSaved');

        return $this->mountOrderService();
    }

    // public function saveLabor()
    // {
    //     // $this->validate([
    //     //     'dataLabor.category_id' => 'required',
    //     //     'dataLabor.labor_id' => 'required',
    //     //     'dataLabor.place_room_id' => 'required',
    //     //     'dataLabor.quantity' => 'required',
    //     // ], [], [
    //     //     'dataLabor.category_id' => 'categoria',
    //     //     'dataLabor.labor_id' => 'equipamento',
    //     //     'dataLabor.place_room_id' => 'sala',
    //     //     'dataLabor.quantity' => 'quantidade',
    //     // ]);

    //     if (empty($this->dataLabor['category_id'])) {
    //         return $this->emit('laborError', true);
    //     }

    //     if (empty($this->dataLabor['labor_id'])) {
    //         return $this->emit('laborError', true);
    //     }

    //     if (empty($this->dataLabor['place_room_id'])) {
    //         return $this->emit('laborError', true);
    //     }


    //     if (empty($this->dataLabor['quantity'])) {
    //         return $this->emit('laborError', true);
    //     }

    //     if (empty($this->dataLabor['days'])) {
    //         return $this->emit('laborError', true);
    //     }

    //     $this->emit('laborError', false);

    //     OrderServiceRoomLabor::create([
    //         'order_service_id' => $this->orderService->id,
    //         'place_room_id' => $this->dataLabor['place_room_id'],
    //         'labor_id' => $this->dataLabor['labor_id'],
    //         'days' => $this->dataLabor['days'],
    //         'quantity' => $this->dataLabor['quantity'],
    //     ]);

    //     $this->dataLabor = [];

    //     return $this->emit('saved');
    // }

    public function saveFreelancer()
    {
        // $this->validate([
        //     'dataFreelancer.freelancer_id' => 'required',
        //     'dataFreelancer.place_room_id' => 'required',
        //     'dataFreelancer.quantity' => 'required',
        // ], [], [
        //     'dataFreelancer.freelancer_id' => 'equipamento',
        //     'dataFreelancer.place_room_id' => 'sala',
        //     'dataFreelancer.quantity' => 'quantidade',
        // ]);


        if (empty($this->dataFreelancer['freelancer_id'])) {
            return $this->emit('freelancerError', true);
        }

        if (empty($this->dataFreelancer['place_room_id'])) {
            return $this->emit('freelancerError', true);
        }


        if (empty($this->dataFreelancer['quantity'])) {
            return $this->emit('freelancerError', true);
        }

        if (empty($this->dataFreelancer['days'])) {
            return $this->emit('freelancerError', true);
        }

        $this->emit('laborError', false);

        OrderServiceRoomFreelancer::create([
            'order_service_id' => $this->orderService->id,
            'place_room_id' => $this->dataFreelancer['place_room_id'],
            'freelancer_id' => $this->dataFreelancer['freelancer_id'],
            'days' => $this->dataFreelancer['days'],
            'quantity' => $this->dataFreelancer['quantity'],
        ]);

        $this->dataFreelancer = [];

        return $this->emit('saved');
    }

    public function saveProvider()
    {
        // $this->validate([
        //     'dataProvider.provider_id' => 'required',
        //     'dataProvider.provider_category_id' => 'required',
        //     'dataProvider.provider_product_id' => 'required',
        //     'dataProvider.place_room_id' => 'required',
        //     'dataProvider.quantity' => 'required',
        // ], [], [
        //     'dataProvider.provider_id' => 'fornecedor',
        //     'dataProvider.provider_category_id' => 'categoria',
        //     'dataProvider.provider_product_id' => 'equipamento',
        //     'dataProvider.place_room_id' => 'sala',
        //     'dataProvider.quantity' => 'quantidade',
        // ]);

        if (empty($this->dataProvider['provider_id'])) {
            return $this->emit('providerError', true);
        }

        if (empty($this->dataProvider['provider_category_id'])) {
            return $this->emit('providerError', true);
        }

        if (empty($this->dataProvider['provider_product_id'])) {
            return $this->emit('providerError', true);
        }

        if (empty($this->dataProvider['place_room_id'])) {
            return $this->emit('providerError', true);
        }

        if (empty($this->dataProvider['quantity'])) {
            return $this->emit('providerError', true);
        }

        $this->emit('providerError', false);

        $budgetDays = explode('-', $this->orderService->budget->budget_days);
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

        OrderServiceRoomProvider::create([
            'order_service_id' => $this->orderService->id,
            'place_room_id' => $this->dataProvider['place_room_id'],
            'os_product_id' => $this->dataProvider['provider_product_id'],
            'days' => implode(',', $days),
            'quantity' => $this->dataProvider['quantity'],
        ]);

        $this->dataProvider = [];

        return $this->emit('saved');
    }

    public function saveKit()
    {
        $errors = [];

        if (empty($this->dataGroup['group_id'])) {
            $errors['group_id'] = 'o campo kit é obrigatório';
        }

        if (empty($this->dataGroup['place_room_id'])) {
            $errors['place_room_id'] = 'o campo sala é obrigatório';
        }

        if (empty($this->dataGroup['quantity'])) {
            $errors['quantity'] = 'o campo quantidade é obrigatório';
        }

        if (count($errors) > 0) {
            return $this->emit('kitError', $errors);
        } else {
            $this->emit('kitError', null);
        }

        $budgetDays = explode('-', $this->orderService->budget->budget_days);
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

        OrderServiceRoomGroup::create([
            'order_service_id' => $this->orderService->id,
            'place_room_id' => $this->dataGroup['place_room_id'],
            'group_id' => $this->dataGroup['group_id'],
            'days' => implode(',', $days),
            'quantity' => $this->dataGroup['quantity'],
        ]);

        $this->dataGroup = [];
        $this->emit('kitSaved');

        return $this->mountOrderService();
    }

    public function saveStatus()
    {
        // $this->validate([
        //     'dataStatus.status_id' => 'required',
        // ], [], [
        //     'dataStatus.status_id' => 'status',
        // ]);

        if (empty($this->dataStatus['status_id'])) {
            return $this->emit('statusError', true);
        }

        $this->emit('statusError', false);

        $this->orderService->update([
            'os_status_id' => $this->dataStatus['status_id']
        ]);

        return $this->emit('saved');
    }

    public function confirmProductRemove(OrderServiceRoomProduct $orderServiceRoomProduct)
    {
        return $this->emit('confirmProductRemove', $orderServiceRoomProduct->id);
    }

    public function removeProduct(OrderServiceRoomProduct $orderServiceRoomProduct)
    {
        $orderServiceRoomProduct->delete();

        return $this->mountOrderService();
    }

    public function confirmKitRemove(OrderServiceRoomGroup $orderServiceRoomGroup)
    {
        return $this->emit('confirmKitRemove', $orderServiceRoomGroup->id);
    }

    public function removeKit(OrderServiceRoomGroup $orderServiceRoomGroup)
    {
        $orderServiceRoomGroup->delete();

        return $this->mountOrderService();
    }

    public function checkDayRoomProduct(OrderServiceRoomProduct $orderServiceRoomProduct, $roomDate)
    {
        $days = explode(',', $orderServiceRoomProduct->days);

        if (in_array($roomDate, $days)) {
            unset($days[array_search($roomDate, $days)]);
        } else {
            $days[] = $roomDate;
        }

        $orderServiceRoomProduct->days = implode(',', $days);
        $orderServiceRoomProduct->save();

        return $this->emit('saved');
    }

    public function checkDayRoomProvider(OrderServiceRoomProvider $orderServiceRoomProvider, $roomDate)
    {
        $days = explode(',', $orderServiceRoomProvider->days);

        if (in_array($roomDate, $days)) {
            unset($days[array_search($roomDate, $days)]);
        } else {
            $days[] = $roomDate;
        }

        $orderServiceRoomProvider->days = implode(',', $days);
        $orderServiceRoomProvider->save();

        return $this->emit('saved');
    }

    public function checkDayRoomGroup(OrderServiceRoomGroup $orderServiceRoomGroup, $roomDate)
    {
        $days = explode(',', $orderServiceRoomGroup->days);

        if (in_array($roomDate, $days)) {
            unset($days[array_search($roomDate, $days)]);
        } else {
            $days[] = $roomDate;
        }

        $orderServiceRoomGroup->days = implode(',', $days);
        $orderServiceRoomGroup->save();

        return $this->emit('saved');
    }

    public function onChangeQuantityProduct(OrderServiceRoomProduct $orderServiceRoomProduct, $quantity)
    {
        if ($quantity > 0) {
            $orderServiceRoomProduct->quantity = $quantity;
            $orderServiceRoomProduct->save();

            return $this->emit('saved');
        }
    }

    public function onChangeQuantityProvider(OrderServiceRoomProvider $orderServiceRoomProvider, $quantity)
    {
        if ($quantity > 0) {
            $orderServiceRoomProvider->quantity = $quantity;
            $orderServiceRoomProvider->save();

            return $this->emit('saved');
        }
    }

    public function onChangeQuantityGroup(OrderServiceRoomGroup $orderServiceRoomGroup, $quantity)
    {
        if ($quantity > 0) {
            $orderServiceRoomGroup->quantity = $quantity;
            $orderServiceRoomGroup->save();

            return $this->emit('saved');
        }
    }

    public function onChangeLaborQuantity(BudgetRoomLabor $budgetRoomLabor, $quantity)
    {
        if ($quantity > 0) {
            $budgetRoomLabor->quantity = $quantity;
            $budgetRoomLabor->save();

            // $this->dataLabor = [];
            // $this->mountOrderService();
            return $this->emit('saved');
        }
    }

    public function onChangeLaborDays(BudgetRoomLabor $budgetRoomLabor, $days)
    {
        if ($days > 0) {
            $budgetRoomLabor->days = $days;
            $budgetRoomLabor->save();

            // $this->dataLabor = [];
            // $this->mountOrderService();
            return $this->emit('saved');
        }
    }

    public function onChangeFreelancerQuantity(OrderServiceRoomFreelancer $orderServiceRoomFreelancer, $quantity)
    {
        if ($quantity > 0) {
            $orderServiceRoomFreelancer->quantity = $quantity;
            $orderServiceRoomFreelancer->save();

            return $this->emit('saved');
        }
    }

    public function onChangeFreelancerDays(OrderServiceRoomFreelancer $orderServiceRoomFreelancer, $days)
    {
        if ($days > 0) {
            $orderServiceRoomFreelancer->days = $days;
            $orderServiceRoomFreelancer->save();

            return $this->emit('saved');
        }
    }

    public function listPrintProviders()
    {
        $productProviders = OrderServiceRoomProvider::where('order_service_id', $this->orderService->id)->get();
        $arProviders = [];

        foreach ($productProviders as $productProvider) {
            if (!in_array($productProvider->osProduct->provider->id, $arProviders))
                array_push($arProviders, $productProvider->osProduct->provider->id);
        }

        $this->printProviders = Provider::whereIn('id', $arProviders)->get();

        $this->emit('showPrintProviders');
    }

    public function updateVersion()
    {
        $this->orderService->budget_version = $this->orderService->budget->budget_version;
        $this->orderService->saveQuietly();
        $this->orderService->refresh();

        $this->emit('versionUpdated');
    }
}
