<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ $customer->fantasy_name }} - Documento
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('customers.documents.index', $customer->id) }}"
                class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
        </div>
        <div class="intro-y col-span-12">
            @if (empty($document->id))
                {!! Form::open([
                    'route' => ['customers.documents.store', $customer->id],
                    'method' => 'post',
                    'class' => 'needs-validation',
                    'files' => 'true',
                ]) !!}
            @else
                {!! Form::model($document, [
                    'route' => ['customers.documents.update', [$customer->id, $document->id]],
                    'method' => 'put',
                    'class' => 'needs-validation',
                    'files' => 'true',
                ]) !!}
            @endif
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div class="sm:grid grid-cols-1 gap-2">
                    <x-forms.text name="name" label="Nome" />
                </div>
                <div class="sm:grid grid-cols-1 gap-2 mt-3">
                    <x-forms.file name="file" label="Arquivo" />
                </div>
                <x-forms.buttons.save-cancel :showMode="isset($showMode) ? $showMode : false" :model="$document" />
            </div>
            {!! Form::close() !!}
            <!-- END: Form Layout -->
        </div>
    </div>
</x-app-layout>
