<?php

namespace App\Http\Livewire;

use App\Models\OsCategory;
use App\Models\OsProduct;
use Livewire\Component;

class GroupProductLivewire extends Component
{
    public $group;
    public $product;
    public $showMode;
    public $osCategories = [];
    public $osProducts = [];
    public $dataGroup = [];

    public function mount($group)
    {
        $this->osCategories = OsCategory::pluck('name', 'id')->prepend('Selecione', '');
    }

    public function render()
    {
        return view('groups.products.livewire.form');
    }

    public function onSelectCategory(OsCategory $osCategory)
    {
        $this->dataGroup['os_category_id'] = $osCategory->id;

        $products = OsProduct::where('os_category_id', $osCategory->id)->pluck('name', 'id')->prepend('Selecione', '');

        $this->emit('updateProductGroupList', $products);
    }
}
