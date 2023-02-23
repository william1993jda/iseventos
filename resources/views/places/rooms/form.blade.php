<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ $place->name }} - Sala
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('places.rooms.index', $place->id) }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
        </div>
        <div class="intro-y col-span-12">
            @if (empty($room->id))
                {!! Form::open([
                    'route' => ['places.rooms.store', $place->id],
                    'method' => 'post',
                    'class' => 'needs-validation',
                ]) !!}
            @else
                {!! Form::model($room, [
                    'route' => ['places.rooms.update', [$place->id, $room->id]],
                    'method' => 'put',
                    'class' => 'needs-validation',
                ]) !!}
            @endif
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div class="sm:grid grid-cols-2 gap-2">
                    <x-forms.text name="name" label="Nome" />
                    <x-forms.checkbox name="active" label="Ativo" :checked="$room->active" />
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
