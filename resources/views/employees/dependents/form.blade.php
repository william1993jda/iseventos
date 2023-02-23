<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ $employee->user->name }} - Dependente
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('employees.banks.index', $employee->id) }}"
                class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
        </div>
        <div class="intro-y col-span-12">
            @if (empty($dependent->id))
                {!! Form::open([
                    'route' => ['employees.dependents.store', $employee->id],
                    'method' => 'post',
                    'class' => 'needs-validation',
                ]) !!}
            @else
                {!! Form::model($dependent, [
                    'route' => ['employees.dependents.update', [$employee->id, $dependent->id]],
                    'method' => 'put',
                    'class' => 'needs-validation',
                ]) !!}
            @endif
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div class="sm:grid grid-cols-1 gap-2">
                    <div>
                        <label for="name" class="form-label">Nome</label>
                        {!! Form::text('name', null, ['class' => 'form-control w-full', 'required' => 'required', 'id' => 'name']) !!}
                    </div>
                </div>
                <div class="sm:grid grid-cols-2 gap-2 mt-3">
                    <div>
                        <label for="birthday" class="form-label">Data de Nascimento</label>
                        {!! Form::date('birthday', null, ['class' => 'form-control w-full', 'id' => 'birthday']) !!}
                    </div>
                    <div>
                        <label for="identification" class="form-label">Parentesco</label>
                        {!! Form::text('identification', null, [
                            'class' => 'form-control w-full',
                            'required' => 'required',
                            'id' => 'identification',
                        ]) !!}
                    </div>
                    <div>
                        <label for="social_security" class="form-label">CPF</label>
                        {!! Form::text('social_security', null, [
                            'class' => 'form-control w-full',
                            'required' => 'required',
                            'id' => 'social_security',
                        ]) !!}
                    </div>
                </div>
                @if (!isset($showMode))
                    <div class="text-right mt-5">
                        <button type="reset" class="btn btn-outline-secondary w-24 mr-1">Cancelar</button>
                        <button type="submit" class="btn btn-primary w-24">Salvar</button>
                    </div>
                @endif
            </div>
            {!! Form::close() !!}
            <!-- END: Form Layout -->
        </div>
    </div>
</x-app-layout>
