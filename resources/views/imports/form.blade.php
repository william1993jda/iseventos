<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Importar Equipamentos Comercial
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12">
            {!! Form::open([
                'route' => ['imports.products'],
                'method' => 'post',
                'class' => 'needs-validation',
                'files' => 'true',
            ]) !!}
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div class="sm:grid grid-cols-2 gap-2">
                    <div>
                        <label for="file" class="form-label">Arquivo</label>
                        {!! Form::file('filename', ['class' => 'w-full', 'required' => 'required', 'id' => 'filename']) !!}
                    </div>
                </div>
                <div class="text-right mt-5">
                    <button type="reset" class="btn btn-outline-secondary w-24 mr-1">Cancelar</button>
                    <button type="submit" class="btn btn-primary w-24">Salvar</button>
                </div>
            </div>
            {!! Form::close() !!}
            <!-- END: Form Layout -->
        </div>
    </div>
</x-app-layout>
