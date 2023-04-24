<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ $freelancer->name }} - Dependente
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('freelancers.dependents.index', $freelancer->id) }}"
                class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
        </div>
        <div class="intro-y col-span-12">
            @if (empty($dependent->id))
                {!! Form::open([
                    'route' => ['freelancers.dependents.store', $freelancer->id],
                    'method' => 'post',
                    'class' => 'needs-validation',
                ]) !!}
            @else
                {!! Form::model($dependent, [
                    'route' => ['freelancers.dependents.update', [$freelancer->id, $dependent->id]],
                    'method' => 'put',
                    'class' => 'needs-validation',
                ]) !!}
            @endif
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div class="sm:grid grid-cols-2 gap-2">
                    <x-forms.text name="name" label="Nome" />
                    <x-forms.text name="birthday" label="Data de Nascimento" class="datepicker form-control w-full"
                        data-single-mode="true" />
                </div>
                <div class="sm:grid grid-cols-2 gap-2 mt-3">
                    <x-forms.text name="social_security" label="CPF" mask="'999.999.999-99'" />
                    <x-forms.text name="identification" label="Parentesco" />
                </div>
                <x-forms.buttons.save-cancel :showMode="isset($showMode) ? $showMode : false" :model="$dependent" />
            </div>
            {!! Form::close() !!}
            <!-- END: Form Layout -->
        </div>
    </div>
</x-app-layout>
