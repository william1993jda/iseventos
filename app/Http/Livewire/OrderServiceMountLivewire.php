<?php

namespace App\Http\Livewire;

use App\Models\BudgetRoomLabor;
use App\Models\BudgetRoomProduct;
use App\Models\Category;
use App\Models\Labor;
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
    public $osStatuses = [];
    public $products = [];
    public $providers = [];
    public $placeRooms = [];
    public $rooms = [];
    public $dataOrderService = [];
    public $dataProduct = [];
    public $dataProvider = [];
    public $dataStatus = [];

    public function mount($orderService)
    {
        $this->osStatuses = OsStatus::pluck('name', 'id')->prepend('Selecione', '');
        $this->placeRooms = $orderService->budget->place->rooms->pluck('name', 'id')->prepend('Selecione', '');

        $this->getRooms();
    }

    public function getRooms()
    {
        $orderServiceRoomProducts = OrderServiceRoomProduct::where('order_service_id', $this->orderService->id)->pluck('place_room_id')->toArray();
        $orderServiceRoomProviders = OrderServiceRoomProvider::where('order_service_id', $this->orderService->id)->pluck('place_room_id')->toArray();
        $placeRoomIds = array_unique(array_merge($orderServiceRoomProducts, $orderServiceRoomProviders));

        $arRoom = [];

        foreach ($placeRoomIds as $placeRoomId) {
            $placeRoom = PlaceRoom::find($placeRoomId);

            $products = OrderServiceRoomProduct::where('order_service_id', $this->orderService->id)->where('place_room_id', $placeRoom->id);
            $productsId = $products->pluck('os_product_id')->toArray();
            $productsList = $products->get();

            $providers = OrderServiceRoomProvider::where('order_service_id', $this->orderService->id)->where('place_room_id', $placeRoom->id);
            $providersId = $providers->pluck('os_product_id')->toArray();
            $providersList = $providers->get();

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
                ];

                array_push($arCategories, $obCategory);
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
        return view('orderServices.livewire.mount');
    }

    public function addProduct()
    {
        $osCategories = OsCategory::pluck('name', 'id')->prepend('Selecione', '');

        $this->emit('addProduct', $osCategories);
    }

    public function addProvider()
    {
        $providers = Provider::pluck('fantasy_name', 'id')->prepend('Selecione', '');

        $this->emit('addProvider', $providers);
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

    public function onSelectCategory(OsCategory $osCategory)
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
        $this->orderService->update($this->dataOrderService);

        return $this->emit('editObservation');
    }

    public function saveProduct()
    {
        // $this->validate([
        //     'dataProduct.category_id' => 'required',
        //     'dataProduct.product_id' => 'required',
        //     'dataProduct.place_room_id' => 'required',
        //     'dataProduct.quantity' => 'required',
        // ], [], [
        //     'dataProduct.category_id' => 'categoria',
        //     'dataProduct.product_id' => 'equipamento',
        //     'dataProduct.place_room_id' => 'sala',
        //     'dataProduct.quantity' => 'quantidade',
        // ]);

        if (empty($this->dataProduct['category_id'])) {
            return $this->emit('productError', true);
        }

        if (empty($this->dataProduct['product_id'])) {
            return $this->emit('productError', true);
        }

        if (empty($this->dataProduct['place_room_id'])) {
            return $this->emit('productError', true);
        }

        if (empty($this->dataProduct['quantity'])) {
            return $this->emit('productError', true);
        }

        $this->emit('productError', false);

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

    public function checkDayRoom(BudgetRoomProduct $budgetRoomProduct, $roomDate)
    {
        $days = explode(',', $budgetRoomProduct->days);

        if (in_array($roomDate, $days)) {
            unset($days[array_search($roomDate, $days)]);
        } else {
            $days[] = $roomDate;
        }

        $budgetRoomProduct->days = implode(',', $days);
        $budgetRoomProduct->save();

        // $this->getRooms();
        return $this->emit('saved');
    }

    public function onChangeQuantity(BudgetRoomProduct $budgetRoomProduct, $quantity)
    {
        if ($quantity > 0) {
            $budgetRoomProduct->quantity = $quantity;
            $budgetRoomProduct->save();

            // $this->dataProduct = [];
            // $this->getRooms();
            return $this->emit('saved');
        }
    }

    public function onChangeLaborQuantity(BudgetRoomLabor $budgetRoomLabor, $quantity)
    {
        if ($quantity > 0) {
            $budgetRoomLabor->quantity = $quantity;
            $budgetRoomLabor->save();

            // $this->dataLabor = [];
            // $this->getRooms();
            return $this->emit('saved');
        }
    }

    public function onChangeLaborDays(BudgetRoomLabor $budgetRoomLabor, $days)
    {
        if ($days > 0) {
            $budgetRoomLabor->days = $days;
            $budgetRoomLabor->save();

            // $this->dataLabor = [];
            // $this->getRooms();
            return $this->emit('saved');
        }
    }
}
