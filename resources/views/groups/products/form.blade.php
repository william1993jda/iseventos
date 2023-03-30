<x-app-layout>
    @livewire('group-product-livewire', ['group' => $group, 'product' => $product, 'showMode' => isset($showMode) ? $showMode : false])
</x-app-layout>
