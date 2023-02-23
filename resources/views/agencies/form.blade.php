<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Agência
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('agencies.index') }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            @if (!empty($agency->id))
                <a href="{{ route('agencies.contacts.index', $agency->id) }}"
                    class="btn btn-primary shadow-md mr-2">Contatos</a>
                <a href="{{ route('agencies.addresses.index', $agency->id) }}"
                    class="btn btn-primary shadow-md mr-2">Endereços</a>
            @endif
        </div>
        <div class="intro-y col-span-12">
            @if (empty($agency->id))
                {!! Form::open([
                    'route' => 'agencies.store',
                    'method' => 'post',
                    'class' => 'needs-validation',
                ]) !!}
            @else
                {!! Form::model($agency, [
                    'route' => ['agencies.update', $agency->id],
                    'method' => 'put',
                    'class' => 'needs-validation',
                ]) !!}
            @endif
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div class="sm:grid grid-cols-2 gap-2">
                    <div>
                        <label for="fantasy_name" class="form-label">Nome Fantasia</label>
                        {!! Form::text('fantasy_name', null, [
                            'class' => 'form-control w-full',
                            'required' => 'required',
                            'id' => 'fantasy_name',
                        ]) !!}
                    </div>
                    <div>
                        <label for="corporate_name" class="form-label">Razão Social</label>
                        {!! Form::text('corporate_name', null, ['class' => 'form-control w-full', 'id' => 'corporate_name']) !!}
                    </div>
                </div>
                <div class="sm:grid grid-cols-3 gap-2 mt-3">
                    <div>
                        <label for="ein" class="form-label">CNPJ</label>
                        {!! Form::text('ein', null, ['class' => 'form-control w-full', 'id' => 'ein']) !!}
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
