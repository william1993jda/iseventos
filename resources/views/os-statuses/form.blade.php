<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Status Estoque
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('os-statuses.index') }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
        </div>
        <div class="intro-y col-span-12">
            @if (empty($OsStatus->id))
                {!! Form::open([
                    'route' => 'os-statuses.store',
                    'method' => 'post',
                    'class' => 'needs-validation',
                ]) !!}
            @else
                {!! Form::model($OsStatus, [
                    'route' => ['os-statuses.update', $OsStatus->id],
                    'method' => 'put',
                    'class' => 'needs-validation',
                ]) !!}
            @endif
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div class="sm:grid grid-cols-3 gap-2">
                    <x-forms.text name="name" label="Nome" />
                    <x-forms.text name="color" label="Cor" />
                    <x-forms.checkbox name="active" label="Ativo" :checked="$OsStatus->getActive()" />
                </div>

                <x-forms.buttons.save-cancel :showMode="isset($showMode) ? $showMode : false" :model="$OsStatus" />
            </div>
            {!! Form::close() !!}
            <!-- END: Form Layout -->
        </div>
    </div>
</x-app-layout>
