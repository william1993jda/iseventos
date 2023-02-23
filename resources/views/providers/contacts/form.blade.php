<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ $provider->fantasy_name }} - Contato
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('providers.contacts.index', $provider->id) }}"
                class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
        </div>
        <div class="intro-y col-span-12">
            @if (empty($contact->id))
                {!! Form::open([
                    'route' => ['providers.contacts.store', $provider->id],
                    'method' => 'post',
                    'class' => 'needs-validation',
                ]) !!}
            @else
                {!! Form::model($contact, [
                    'route' => ['providers.contacts.update', [$provider->id, $contact->id]],
                    'method' => 'put',
                    'class' => 'needs-validation',
                ]) !!}
            @endif
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div class="sm:grid grid-cols-3 gap-2">
                    <div>
                        <label for="name" class="form-label">Nome</label>
                        {!! Form::text('name', null, ['class' => 'form-control w-full', 'required' => 'required', 'id' => 'name']) !!}
                    </div>
                    <div>
                        <label for="email" class="form-label">E-mail</label>
                        {!! Form::email('email', null, ['class' => 'form-control w-full', 'id' => 'email']) !!}
                    </div>
                    <div>
                        <label for="phone" class="form-label">Telefone</label>
                        {!! Form::text('phone', null, ['class' => 'form-control w-full', 'id' => 'phone']) !!}
                    </div>
                </div>
                <div class="sm:grid grid-cols-1 gap-2 mt-3">
                    <div>
                        <label for="observation" class="form-label">Observação</label>
                        {!! Form::textarea('observation', null, ['class' => 'form-control w-full', 'id' => 'observation']) !!}
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
