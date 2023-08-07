<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Ordem de Serviço
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('orderServices.index') }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            @if (!empty($orderService->id))
                <x-forms.buttons.primary route="orderServices.documents.index" :id="$orderService->id" label="Documentos" />
                <x-forms.buttons.primary route="orderServices.mount" :id="$orderService->id" label="Montar" />
            @endif
        </div>
        <div class="intro-y col-span-12">
            @if (empty($orderService->id))
                {!! Form::open([
                    'route' => 'orderServices.store',
                    'method' => 'post',
                    'class' => 'needs-validation',
                ]) !!}
            @else
                {!! Form::model($orderService, [
                    'route' => ['orderServices.update', $orderService->id],
                    'method' => 'put',
                    'class' => 'needs-validation',
                ]) !!}
            @endif
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div class="sm:grid grid-cols-2 gap-2">
                    {{-- <x-forms.select name="os_status_id" label="Status" :options="$osStatuses" /> --}}
                    <x-forms.select name="budget_id" label="Orçamento" :options="$budgets" />
                </div>
                {{-- <div class="sm:grid grid-cols-1 gap-2 mt-3">
                    <x-forms.textarea name="observation" label="Observações" />
                </div> --}}
                <x-forms.buttons.save-cancel :showMode="isset($showMode) ? $showMode : false" :model="$orderService" />
            </div>
            {!! Form::close() !!}
            <!-- END: Form Layout -->
        </div>
    </div>
</x-app-layout>
