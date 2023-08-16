<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Freelancer;
use App\Models\Group;
use App\Models\GroupProduct;
use App\Models\OrderService;
use App\Models\OrderServiceRoomFreelancer;
use App\Models\OrderServiceRoomGroup;
use App\Models\OrderServiceRoomLabor;
use App\Models\OrderServiceRoomProduct;
use App\Models\OrderServiceRoomProvider;
use App\Models\OsCategory;
use App\Models\OsProduct;
use App\Models\OsProductStock;
use App\Models\OsStatus;
use App\Models\PlaceRoom;
use App\Models\Provider;
use App\Models\Sublease;
use App\Models\SubleaseItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class OrderServiceMountLivewire extends Component
{
    public $orderService;
    public $osCategories = [];
    public $categories = [];
    public $osStatuses = [];
    public $products = [];
    public $freelancers = [];
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
    public $listGroups = [];
    public $listFreelancers = [];
    public $listProviders = [];

    public function mount($orderService)
    {
        $this->osCategories = OsCategory::pluck('name', 'id')->prepend('Selecione', '');
        $this->osStatuses = OsStatus::pluck('name', 'id')->prepend('Selecione', '');
        $this->placeRooms = $orderService->budget->place->rooms->pluck('name', 'id')->prepend('Selecione', '');
        $this->groups = Group::pluck('name', 'id')->prepend('Selecione', '');
        $this->freelancers = Freelancer::pluck('name', 'id')->prepend('Selecione', '');
        $this->providers = Provider::pluck('fantasy_name', 'id')->prepend('Selecione', '');

        $this->mountOrderService();
    }

    public function mountOrderService()
    {
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

        // PRODUCTS
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

        $this->listProducts = [
            'days' => $days,
            'categories' => $arOsCategories,
        ];


        // KITS
        $this->listGroups = [];
        $orderServiceRoomGroups = OrderServiceRoomGroup::where('order_service_id', $this->orderService->id)->get();
        $arGroups = [];

        foreach ($orderServiceRoomGroups as $group) {
            $obGroup = [
                'id' => $group->id,
                'name' => $group->group->name,
                'quantity' => $group->quantity,
                'days' => $group->days,
                'place_room_id' => $group->place_room_id,
                'products' => $group->group->products->map(function ($product) {
                    return [
                        'id' => $product->os_product_id,
                        'name' => $product->product->name,
                    ];
                })->toArray(),
            ];

            array_push($arGroups, $obGroup);
        }

        $this->listGroups = [
            'days' => $days,
            'groups' => $arGroups,
        ];

        // FREELANCERS
        $this->listFreelancers = [];
        $orderServiceRoomFreelancers = OrderServiceRoomFreelancer::where('order_service_id', $this->orderService->id)->get();
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

        $this->listFreelancers = [
            'days' => $days,
            'freelancers' => $arFreelancers,
        ];

        // PROVIDERS
        $this->listProviders = [];
        $orderServiceRoomProviders = OrderServiceRoomProvider::where('order_service_id', $this->orderService->id)->get();
        $providerProductsIds = $orderServiceRoomProviders->pluck('os_product_id')->toArray();
        $providerIds = OsProduct::whereIn('id', $providerProductsIds)
            ->groupBy('provider_id')
            ->pluck('provider_id')
            ->toArray();

        $providerCategoriesIds = OsProduct::whereIn('id', $providerProductsIds)
            ->groupBy('os_category_id')
            ->pluck('os_category_id')
            ->toArray();

        $arProviders = [];

        foreach ($providerIds as $providerId) {
            $provider = Provider::find($providerId);

            $arProviders[$provider->id] = [
                'id' => $provider->id,
                'name' => $provider->fantasy_name,
                'categories' => [],
            ];

            foreach ($providerCategoriesIds as $providerCategoriesId) {
                $providerCategory = OsCategory::find($providerCategoriesId);

                $arProviders[$provider->id]['categories'][$providerCategory->id] = [
                    'id' => $providerCategory->id,
                    'name' => $providerCategory->name,
                    'products' => [],
                ];

                foreach ($orderServiceRoomProviders as $orderServiceRoomProvider) {
                    $arProviders[$orderServiceRoomProvider->osProduct->provider_id]['categories'][$orderServiceRoomProvider->osProduct->os_category_id]['products'][$orderServiceRoomProvider->os_product_id] = [
                        'id' => $orderServiceRoomProvider->id,
                        'name' => $orderServiceRoomProvider->osProduct->name,
                        'quantity' => $orderServiceRoomProvider->quantity,
                        'days' => $orderServiceRoomProvider->days,
                        'place_room_id' => $orderServiceRoomProvider->place_room_id,
                    ];
                }

                if (count($arProviders[$provider->id]['categories'][$providerCategory->id]['products']) == 0) {
                    unset($arProviders[$provider->id]['categories'][$providerCategory->id]);
                }
            }
        }

        $this->listProviders = [
            'days' => $days,
            'providers' => $arProviders,
        ];

        // dd($this->listProviders);
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

    public function addGroup()
    {
        $this->dataGroup = [];
        $this->emit('groupError', null);
        return $this->emit('addGroup');
    }

    public function addFreelancer()
    {
        $this->dataFreelancer = [];
        $this->emit('freelancerError', null);
        return $this->emit('addFreelancer');
    }

    public function addProvider()
    {
        $this->dataProvider = [];
        $this->emit('providerError', null);
        return $this->emit('addProvider');
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
        $this->orderService->observation = $this->dataOrderService['observation'];
        $this->orderService->saveQuietly();
        $this->orderService->refresh();

        $this->dataOrderService = [];

        $this->emit('observationUpdated');
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

        $this->checkSublease($this->dataProduct['product_id']);

        $this->orderService->last_user_id = auth()->user()->id;
        $this->orderService->saveQuietly();
        $this->orderService->refresh();

        $this->dataProduct = [];
        $this->emit('productSaved');

        return $this->mountOrderService();
    }

    public function saveGroup()
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
            return $this->emit('groupError', $errors);
        } else {
            $this->emit('groupError', null);
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

        GroupProduct::where('group_id', $this->dataGroup['group_id'])->get()->map(function ($groupProduct) {
            $this->checkSublease($groupProduct->os_product_id);
        });

        $this->orderService->last_user_id = auth()->user()->id;
        $this->orderService->saveQuietly();
        $this->orderService->refresh();

        $this->dataGroup = [];
        $this->emit('groupSaved');

        return $this->mountOrderService();
    }

    public function saveFreelancer()
    {
        $errors = [];

        if (empty($this->dataFreelancer['freelancer_id'])) {
            $errors['freelancer_id'] = 'o campo freelancer é obrigatório';
        }

        if (empty($this->dataFreelancer['place_room_id'])) {
            $errors['place_room_id'] = 'o campo sala é obrigatório';
        }

        if (empty($this->dataFreelancer['days'])) {
            $errors['days'] = 'o campo dias é obrigatório';
        }

        if (empty($this->dataFreelancer['quantity'])) {
            $errors['quantity'] = 'o campo quantidade é obrigatório';
        }

        if (count($errors) > 0) {
            return $this->emit('freelancerError', $errors);
        } else {
            $this->emit('freelancerError', null);
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

        $freelancer = Freelancer::find($this->dataFreelancer['freelancer_id']);

        OrderServiceRoomFreelancer::create([
            'order_service_id' => $this->orderService->id,
            'place_room_id' => $this->dataFreelancer['place_room_id'],
            'freelancer_id' => $this->dataFreelancer['freelancer_id'],
            'days' => $this->dataFreelancer['days'],
            'quantity' => $this->dataFreelancer['quantity'],
            'price' => $freelancer->price,
        ]);

        $this->orderService->last_user_id = auth()->user()->id;
        $this->orderService->saveQuietly();
        $this->orderService->refresh();

        $this->dataFreelancer = [];
        $this->emit('freelancerSaved');

        return $this->mountOrderService();
    }

    public function saveProvider()
    {
        $errors = [];

        if (empty($this->dataProvider['provider_id'])) {
            $errors['provider_id'] = 'o campo fornecedor é obrigatório';
        }

        if (empty($this->dataProvider['category_id'])) {
            $errors['category_id'] = 'o campo categoria é obrigatório';
        }

        if (empty($this->dataProvider['product_id'])) {
            $errors['product_id'] = 'o campo equipamento é obrigatório';
        }

        if (empty($this->dataProvider['place_room_id'])) {
            $errors['place_room_id'] = 'o campo sala é obrigatório';
        }

        if (empty($this->dataProvider['quantity'])) {
            $errors['quantity'] = 'o campo quantidade é obrigatório';
        }

        if (count($errors) > 0) {
            return $this->emit('providerError', $errors);
        } else {
            $this->emit('providerError', null);
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

        OrderServiceRoomProvider::create([
            'order_service_id' => $this->orderService->id,
            'place_room_id' => $this->dataProvider['place_room_id'],
            'os_product_id' => $this->dataProvider['product_id'],
            'days' => implode(',', $days),
            'quantity' => $this->dataProvider['quantity'],
        ]);

        $this->checkSubleaseProvider($this->dataProvider['product_id']);

        $this->orderService->last_user_id = auth()->user()->id;
        $this->orderService->saveQuietly();
        $this->orderService->refresh();

        $this->dataProvider = [];
        $this->emit('providerSaved');

        return $this->mountOrderService();
    }

    public function saveStatus()
    {
        $errors = [];

        if (empty($this->dataStatus['status_id'])) {
            $errors['status_id'] = 'o campo status é obrigatório';
        }

        if (count($errors) > 0) {
            return $this->emit('statusError', $errors);
        } else {
            $this->emit('statusError', null);
        }

        $this->orderService->os_status_id = $this->dataStatus['status_id'];
        $this->orderService->last_user_id = auth()->user()->id;
        $this->orderService->saveQuietly();
        $this->orderService->refresh();

        $this->dataStatus = [];
        $this->emit('statusUpdated');
    }

    public function confirmProductRemove(OrderServiceRoomProduct $orderServiceRoomProduct)
    {
        return $this->emit('confirmProductRemove', $orderServiceRoomProduct->id);
    }

    public function removeProduct(OrderServiceRoomProduct $orderServiceRoomProduct)
    {
        $osProductId = $orderServiceRoomProduct->os_product_id;

        $orderServiceRoomProduct->delete();

        $this->checkSublease($osProductId, true);

        $this->orderService->last_user_id = auth()->user()->id;
        $this->orderService->saveQuietly();
        $this->orderService->refresh();

        return $this->mountOrderService();
    }

    public function confirmGroupRemove(OrderServiceRoomGroup $orderServiceRoomGroup)
    {
        return $this->emit('confirmGroupRemove', $orderServiceRoomGroup->id);
    }

    public function removeGroup(OrderServiceRoomGroup $orderServiceRoomGroup)
    {
        $groupId = $orderServiceRoomGroup->group_id;
        $orderServiceRoomGroup->delete();

        $this->checkSubleaseGroup($groupId);

        $this->orderService->last_user_id = auth()->user()->id;
        $this->orderService->saveQuietly();
        $this->orderService->refresh();

        return $this->mountOrderService();
    }

    public function confirmFreelancerRemove(OrderServiceRoomFreelancer $orderServiceRoomFreelancer)
    {
        return $this->emit('confirmFreelancerRemove', $orderServiceRoomFreelancer->id);
    }

    public function removeFreelancer(OrderServiceRoomFreelancer $orderServiceRoomFreelancer)
    {
        $orderServiceRoomFreelancer->delete();

        $this->orderService->last_user_id = auth()->user()->id;
        $this->orderService->saveQuietly();
        $this->orderService->refresh();

        return $this->mountOrderService();
    }

    public function confirmProviderRemove(OrderServiceRoomProvider $orderServiceRoomProvider)
    {
        return $this->emit('confirmProviderRemove', $orderServiceRoomProvider->id);
    }

    public function removeProvider(OrderServiceRoomProvider $orderServiceRoomProvider)
    {
        $osProductId = $orderServiceRoomProvider->os_product_id;

        $orderServiceRoomProvider->delete();

        $this->checkSubleaseProvider($osProductId, true);

        $this->orderService->last_user_id = auth()->user()->id;
        $this->orderService->saveQuietly();
        $this->orderService->refresh();

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

        $this->orderService->last_user_id = auth()->user()->id;
        $this->orderService->saveQuietly();
        $this->orderService->refresh();

        return $this->mountOrderService();
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

        $this->orderService->last_user_id = auth()->user()->id;
        $this->orderService->saveQuietly();
        $this->orderService->refresh();

        return $this->mountOrderService();
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

        $this->orderService->last_user_id = auth()->user()->id;
        $this->orderService->saveQuietly();
        $this->orderService->refresh();

        return $this->mountOrderService();
    }

    public function onChangeProductRoom(OrderServiceRoomProduct $orderServiceRoomProduct, $placeRoomId)
    {
        if (!empty($placeRoomId)) {
            $orderServiceRoomProduct->place_room_id = $placeRoomId;
        } else {
            $orderServiceRoomProduct->place_room_id = null;
        }

        $orderServiceRoomProduct->save();

        $this->orderService->last_user_id = auth()->user()->id;
        $this->orderService->saveQuietly();
        $this->orderService->refresh();

        return $this->mountOrderService();
    }

    public function onChangeGroupRoom(OrderServiceRoomGroup $orderServiceRoomGroup, $placeRoomId)
    {
        if (!empty($placeRoomId)) {
            $orderServiceRoomGroup->place_room_id = $placeRoomId;
        } else {
            $orderServiceRoomGroup->place_room_id = null;
        }

        $orderServiceRoomGroup->save();

        $this->orderService->last_user_id = auth()->user()->id;
        $this->orderService->saveQuietly();
        $this->orderService->refresh();

        return $this->mountOrderService();
    }

    public function onChangeProviderRoom(OrderServiceRoomProvider $orderServiceRoomProvider, $placeRoomId)
    {
        if (!empty($placeRoomId)) {
            $orderServiceRoomProvider->place_room_id = $placeRoomId;
        } else {
            $orderServiceRoomProvider->place_room_id = null;
        }

        $orderServiceRoomProvider->save();

        $this->orderService->last_user_id = auth()->user()->id;
        $this->orderService->saveQuietly();
        $this->orderService->refresh();

        return $this->mountOrderService();
    }

    public function onChangeFreelancerRoom(OrderServiceRoomFreelancer $orderServiceRoomFreelancer, $placeRoomId)
    {
        if (!empty($placeRoomId)) {
            $orderServiceRoomFreelancer->place_room_id = $placeRoomId;
        } else {
            $orderServiceRoomFreelancer->place_room_id = null;
        }

        $orderServiceRoomFreelancer->save();

        $this->orderService->last_user_id = auth()->user()->id;
        $this->orderService->saveQuietly();
        $this->orderService->refresh();

        return $this->mountOrderService();
    }

    public function onChangeQuantityProduct(OrderServiceRoomProduct $orderServiceRoomProduct, $quantity)
    {
        if ($quantity > 0) {
            $orderServiceRoomProduct->quantity = $quantity;
            $orderServiceRoomProduct->save();

            $this->checkSublease($orderServiceRoomProduct->os_product_id);

            $this->orderService->last_user_id = auth()->user()->id;
            $this->orderService->saveQuietly();
            $this->orderService->refresh();

            return $this->mountOrderService();
        }
    }

    public function onChangeQuantityGroup(OrderServiceRoomGroup $orderServiceRoomGroup, $quantity)
    {
        if ($quantity > 0) {
            $orderServiceRoomGroup->quantity = $quantity;
            $orderServiceRoomGroup->save();

            $this->checkSubleaseGroup($orderServiceRoomGroup->group_id);

            $this->orderService->last_user_id = auth()->user()->id;
            $this->orderService->saveQuietly();
            $this->orderService->refresh();

            return $this->mountOrderService();
        }
    }

    public function onChangeQuantityProvider(OrderServiceRoomProvider $orderServiceRoomProvider, $quantity)
    {
        if ($quantity > 0) {
            $orderServiceRoomProvider->quantity = $quantity;
            $orderServiceRoomProvider->save();

            $this->checkSubleaseProvider($orderServiceRoomProvider->os_product_id);

            $this->orderService->last_user_id = auth()->user()->id;
            $this->orderService->saveQuietly();
            $this->orderService->refresh();

            return $this->emit('saved');
        }
    }

    public function onChangeQuantityFreelancer(OrderServiceRoomFreelancer $orderServiceRoomFreelancer, $quantity)
    {
        if ($quantity > 0) {
            $orderServiceRoomFreelancer->quantity = $quantity;
            $orderServiceRoomFreelancer->save();

            $this->orderService->last_user_id = auth()->user()->id;
            $this->orderService->saveQuietly();
            $this->orderService->refresh();

            return $this->emit('saved');
        }
    }

    public function onChangeDaysFreelancer(OrderServiceRoomFreelancer $orderServiceRoomFreelancer, $days)
    {
        if ($days > 0) {
            $orderServiceRoomFreelancer->days = $days;
            $orderServiceRoomFreelancer->save();

            $this->orderService->last_user_id = auth()->user()->id;
            $this->orderService->saveQuietly();
            $this->orderService->refresh();

            return $this->emit('saved');
        }
    }

    public function updateVersion()
    {
        $this->orderService->budget_version = $this->orderService->budget->budget_version;
        $this->orderService->last_user_id = auth()->user()->id;
        $this->orderService->saveQuietly();
        $this->orderService->refresh();

        $this->emit('versionUpdated');
    }

    public function checkSublease($osProductId, $hideNotification = false)
    {
        $statusReproved = OsStatus::where('slug', 'reprovado')->first();

        $osRoomProductQuantity = OrderServiceRoomProduct::with('orderService')
            ->where('os_product_id', $osProductId)
            ->get()
            ->where('orderService.os_status_id', '!=', $statusReproved->id)
            ->whereBetween('orderService.budget.mount_date', [$this->orderService->budget->mount_date, $this->orderService->budget->unmount_date])
            ->sum('quantity');

        $osProductStockQuantity = OsProductStock::where('os_product_id', $osProductId)->count();

        $diff = $osProductStockQuantity - $osRoomProductQuantity;

        if ($diff < 0) {
            $sublease = Sublease::firstOrCreate([
                'order_service_id' => $this->orderService->id,
                'status' => 1,
            ]);

            $subleaseItem = SubleaseItem::where('sublease_id', $sublease->id)
                ->where('os_product_id', $osProductId)
                ->first();

            if (!empty($subleaseItem)) {
                $subleaseItem->quantity = abs($diff);
                $subleaseItem->save();
            } else {
                $subleaseItem = SubleaseItem::create([
                    'sublease_id' => $sublease->id,
                    'os_product_id' => $osProductId,
                    'quantity' => abs($diff),
                    'status' => 1,
                ]);
            }

            if (!$hideNotification) {
                $this->emit('subleaseError');
            }
        } else {
            $sublease = Sublease::firstOrCreate([
                'order_service_id' => $this->orderService->id,
                'status' => 1,
            ]);

            $subleaseItem = SubleaseItem::where('sublease_id', $sublease->id)
                ->where('os_product_id', $osProductId)
                ->whereNull('group_id')
                ->whereNull('provider_id')
                ->first();

            if (!empty($subleaseItem)) {
                $subleaseItem->delete();

                if ($sublease->items->count() == 0) {
                    $sublease->delete();
                }
            }
        }
    }

    public function checkSubleaseGroup($groupId, $hideNotification = false)
    {
        $statusReproved = OsStatus::where('slug', 'reprovado')->first();

        $osRoomGroupQuantity = OrderServiceRoomGroup::with('orderService')
            ->where('group_id', $groupId)
            ->get()
            ->where('orderService.os_status_id', '!=', $statusReproved->id)
            ->whereBetween('orderService.budget.mount_date', [$this->orderService->budget->mount_date, $this->orderService->budget->unmount_date])
            ->sum('quantity');

        $groupProducts = GroupProduct::where('group_id', $groupId)->pluck('os_product_id');

        foreach ($groupProducts as $osProductId) {
            $osProductStockQuantity = OsProductStock::where('os_product_id', $osProductId)->count();

            $diff = $osProductStockQuantity - $osRoomGroupQuantity;

            if ($diff < 0) {
                $sublease = Sublease::firstOrCreate([
                    'order_service_id' => $this->orderService->id,
                    'status' => 1,
                ]);

                $subleaseItem = SubleaseItem::where('sublease_id', $sublease->id)
                    ->where('os_product_id', $osProductId)
                    ->first();

                if (!empty($subleaseItem)) {
                    $subleaseItem->quantity = abs($diff);
                    $subleaseItem->save();
                } else {
                    $subleaseItem = SubleaseItem::create([
                        'sublease_id' => $sublease->id,
                        'os_product_id' => $osProductId,
                        'group_id' => $groupId,
                        'quantity' => abs($diff),
                        'status' => 1,
                    ]);
                }

                if (!$hideNotification) {
                    $this->emit('subleaseError');
                }
            } else {
                $sublease = Sublease::firstOrCreate([
                    'order_service_id' => $this->orderService->id,
                    'status' => 1,
                ]);

                $subleaseItem = SubleaseItem::where('sublease_id', $sublease->id)
                    ->where('os_product_id', $osProductId)
                    ->where('group_id', $groupId)
                    ->whereNull('provider_id')
                    ->first();

                if (!empty($subleaseItem)) {
                    $subleaseItem->delete();

                    if ($sublease->items->count() == 0) {
                        $sublease->delete();
                    }
                }
            }
        }
    }

    public function checkSubleaseProvider($osProductId, $hideNotification = false)
    {
        $osProduct = OsProduct::find($osProductId);

        $statusReproved = OsStatus::where('slug', 'reprovado')->first();

        $osRoomGroupQuantity = OrderServiceRoomProvider::with('orderService')
            ->where('os_product_id', $osProduct->id)
            ->get()
            ->where('orderService.os_status_id', '!=', $statusReproved->id)
            ->whereBetween('orderService.budget.mount_date', [$this->orderService->budget->mount_date, $this->orderService->budget->unmount_date])
            ->sum('quantity');

        $osProductStockQuantity = OsProductStock::where('os_product_id', $osProduct->id)->count();

        $diff = $osProductStockQuantity - $osRoomGroupQuantity;

        if ($diff < 0) {
            $sublease = Sublease::firstOrCreate([
                'order_service_id' => $this->orderService->id,
                'status' => 1,
            ]);

            $subleaseItem = SubleaseItem::where('sublease_id', $sublease->id)
                ->where('os_product_id', $osProduct->id)
                ->first();

            if (!empty($subleaseItem)) {
                $subleaseItem->quantity = abs($diff);
                $subleaseItem->save();
            } else {
                $subleaseItem = SubleaseItem::create([
                    'sublease_id' => $sublease->id,
                    'os_product_id' => $osProduct->id,
                    'provider_id' => $osProduct->provider_id,
                    'quantity' => abs($diff),
                    'status' => 1,
                ]);
            }

            if (!$hideNotification) {
                $this->emit('subleaseError');
            }
        } else {
            $sublease = Sublease::firstOrCreate([
                'order_service_id' => $this->orderService->id,
                'status' => 1,
            ]);

            $subleaseItem = SubleaseItem::where('sublease_id', $sublease->id)
                ->where('os_product_id', $osProduct->id)
                ->where('provider_id', $osProduct->provider_id)
                ->whereNull('group_id')
                ->first();

            if (!empty($subleaseItem)) {
                $subleaseItem->delete();

                if ($sublease->items->count() == 0) {
                    $sublease->delete();
                }
            }
        }
    }
}
