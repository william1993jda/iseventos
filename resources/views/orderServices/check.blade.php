<x-app-layout>
    @livewire('order-service-check-livewire', [
        'budget' => $budget,
        'orderService' => $orderService,
        'orderServiceCheck' => $orderServiceCheck,
    ])
</x-app-layout>
