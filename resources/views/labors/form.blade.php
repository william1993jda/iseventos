<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Mão de obra
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('labors.index') }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
        </div>
        <div class="intro-y col-span-12">
            @if (empty($labor->id))
                {!! Form::open([
                    'route' => 'labors.store',
                    'method' => 'post',
                    'class' => 'needs-validation',
                ]) !!}
            @else
                {!! Form::model($labor, [
                    'route' => ['labors.update', $labor->id],
                    'method' => 'put',
                    'class' => 'needs-validation',
                ]) !!}
            @endif
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div class="sm:grid grid-cols-2 gap-2">
                    <div @error('category_id') class="has-error" @enderror>
                        <label for="category_id" class="form-label">Categoria</label>
                        {!! Form::select('category_id', $categories, null, ['class' => 'tom-select w-full', 'id' => 'category_id']) !!}
                        @error('category_id')
                            <div class="pristine-error text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div @error('name') class="has-error" @enderror>
                        <label for="name" class="form-label">Nome</label>
                        {!! Form::text('name', null, [
                            'class' => 'form-control w-full',
                            'id' => 'name',
                        ]) !!}
                        @error('name')
                            <div class="pristine-error text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="sm:grid grid-cols-2 gap-2 mt-3">
                    <div @error('price') class="has-error" @enderror>
                        <label for="price" class="form-label">Preço</label>
                        {!! Form::text('price', null, ['class' => 'form-control w-full money', 'id' => 'price']) !!}
                        @error('price')
                            <div class="pristine-error text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="type" class="form-label">Ativo</label>
                        <div class="form-switch mt-2">
                            {!! Form::checkbox('active', 1, $labor->getActive(), ['class' => 'form-check-input']) !!}
                        </div>
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
