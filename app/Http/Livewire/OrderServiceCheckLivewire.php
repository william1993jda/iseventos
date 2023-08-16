<?php

namespace App\Http\Livewire;

use App\Models\Group;
use App\Models\OrderServiceCheckItem;
use App\Models\OsProduct;
use Livewire\Component;

class OrderServiceCheckLivewire extends Component
{
    public $budget;
    public $orderService;
    public $orderServiceCheck;
    public $orderServiceCheckItems;
    public $orderServiceCheckItemGroups;
    public $dataCheck = [];

    public function mount()
    {
        return $this->updateItems();
    }

    public function render()
    {
        return view('order-services.livewire.check');
    }

    public function updateItems()
    {
        $this->dataCheck = [];

        $this->orderServiceCheckItems = OrderServiceCheckItem::where('order_service_check_id', $this->orderServiceCheck->id)
            ->whereNull('group_id')
            ->get()
            ->map(function ($item) {
                $sku = null;

                if (!empty($item->os_product_stock_id)) {
                    $sku = $item->osProductStock->sku;
                }

                $item->sku = $sku;

                return [
                    'id' => $item->id,
                    'os_product_id' => $item->os_product_id,
                    'os_product_stock_id' => $item->os_product_stock_id,
                    'sku' => $sku,
                    'name' => $item->osProduct->name,
                    'checkout_date' => $item->checkout_date ? $item->checkout_date->format('d/m/Y') : null,
                    'checkin_date' => $item->checkin_date ? $item->checkin_date->format('d/m/Y') : null,
                    'status' => $item->status
                ];
            });

        $groupIds = OrderServiceCheckItem::where('order_service_check_id', $this->orderServiceCheck->id)
            ->whereNotNull('group_id')
            ->pluck('group_id')
            ->unique()
            ->toArray();

        $arGroups = [];

        foreach ($groupIds as $groupId) {
            $group = Group::find($groupId);

            $groupProducts = OrderServiceCheckItem::where('order_service_check_id', $this->orderServiceCheck->id)
                ->where('group_id', $groupId)
                ->get()
                ->map(function ($item) {
                    $sku = null;

                    if (!empty($item->os_product_stock_id)) {
                        $sku = $item->osProductStock->sku;
                    }

                    $item->sku = $sku;

                    return [
                        'id' => $item->id,
                        'os_product_id' => $item->os_product_id,
                        'os_product_stock_id' => $item->os_product_stock_id,
                        'sku' => $sku,
                        'name' => $item->osProduct->name,
                        'checkout_date' => $item->checkout_date ? $item->checkout_date->format('d/m/Y') : null,
                        'checkin_date' => $item->checkin_date ? $item->checkin_date->format('d/m/Y') : null,
                        'status' => $item->status
                    ];
                });

            array_push($arGroups, [
                'id' => $group->id,
                'name' => $group->name,
                'products' => $groupProducts
            ]);
        }

        $this->orderServiceCheckItemGroups = $arGroups;
    }

    public function onChangeSku(OrderServiceCheckItem $orderServiceCheckItem, $sku)
    {
        $osProduct = $orderServiceCheckItem->osProduct;
        $osProductStock = $osProduct->stocks()->where('os_product_id', $osProduct->id)->where('sku', $sku)->first();

        if (empty($osProductStock)) {
            $this->emit('notificationError', ['title' => 'SKU inválido', 'message' => 'Informe um SKU registrado no produto selecionado.']);
            return;
        }

        $orderServiceCheckItem->os_product_stock_id = $osProductStock->id;
        $orderServiceCheckItem->checkout_date = now();
        $orderServiceCheckItem->status = '2';
        $orderServiceCheckItem->save();

        return $this->updateItems();
    }

    public function cancelCheckout(OrderServiceCheckItem $orderServiceCheckItem)
    {
        $orderServiceCheckItem->os_product_stock_id = null;
        $orderServiceCheckItem->checkout_date = null;
        $orderServiceCheckItem->checkin_date = null;
        $orderServiceCheckItem->observation = null;
        $orderServiceCheckItem->status = '1';
        $orderServiceCheckItem->save();

        return $this->updateItems();
    }

    public function confirmCheckin(OrderServiceCheckItem $orderServiceCheckItem)
    {
        $orderServiceCheckItem->checkin_date = now();
        $orderServiceCheckItem->status = '3';
        $orderServiceCheckItem->save();

        return $this->updateItems();
    }

    public function informProblem(OrderServiceCheckItem $orderServiceCheckItem)
    {
        $this->dataCheck = [];
        $this->dataCheck['id'] = $orderServiceCheckItem->id;

        return $this->emit('editCheckObservation');
    }

    public function cancelProblem(OrderServiceCheckItem $orderServiceCheckItem)
    {
        $orderServiceCheckItem->observation = null;
        $orderServiceCheckItem->checkin_date = null;
        $orderServiceCheckItem->status = 2;
        $orderServiceCheckItem->save();

        return $this->updateItems();
    }

    public function saveCheckObservation()
    {
        $orderServiceCheckItem = OrderServiceCheckItem::find($this->dataCheck['id']);
        $orderServiceCheckItem->observation = $this->dataCheck['observation'];
        $orderServiceCheckItem->checkin_date = now();
        $orderServiceCheckItem->status = 4;
        $orderServiceCheckItem->save();

        $this->emit('checkObservationUpdated');
        return $this->updateItems();
    }
}
