<?php

namespace App\Http\Livewire;

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
        $this->orderServiceCheckItems = OrderServiceCheckItem::where('order_service_check_id', $this->orderServiceCheck->id)
            ->whereNull('group_id')
            ->get()
            ->map(function ($item) {
                $sku = null;

                if (!empty($item->os_product_stock_id)) {
                    $sku = $item->osProductStock->sku;
                }

                $item->sku = $sku;

                return $item;
            });

        $this->orderServiceCheckItemGroups = OrderServiceCheckItem::where('order_service_check_id', $this->orderServiceCheck->id)->whereNotNull('group_id')->get();
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
        $orderServiceCheckItem->save();

        return $this->orderServiceCheckItems = OrderServiceCheckItem::where('order_service_check_id', $this->orderServiceCheck->id)->whereNull('group_id')->get();
    }
}
