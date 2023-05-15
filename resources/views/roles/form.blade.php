<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Perfil de Usuário - {{ $role->name }}
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('roles.index') }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <button type="button" onclick="checkAll()" class="btn btn-primary shadow-md ml-2">Marcar todos</button>
            <button type="button" onclick="unCheckAll()" class="btn btn-primary shadow-md ml-2">Desmarcar todos</button>
        </div>
        <div class="intro-y col-span-12">
            {!! Form::open([
                'route' => ['roles.store', $role->id],
                'method' => 'post',
                'class' => 'needs-validation',
            ]) !!}
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                <table class="table table-report -mt-2">
                    {{-- <thead>
                        <tr>
                            <th class="whitespace-nowrap">NOME</th>
                            <th class="text-center whitespace-nowrap">LISTAR</th>
                            <th class="text-center whitespace-nowrap">CRIAR</th>
                            <th class="text-center whitespace-nowrap">EDITAR</th>
                            <th class="text-center whitespace-nowrap">DELETAR</th>
                        </tr>
                    </thead> --}}
                    <tbody>
                        @foreach ($permissions as $module => $permission)
                            <tr class="intro-x">
                                {{-- <td class="font-medium whitespace-nowrap">{{ $module }}</td> --}}
                                @foreach ($permission as $key => $value)
                                    <td class="text-center">
                                        {{ $value->name }}
                                        <x-forms.checkbox name="permission_id[]" value="{{ $value->id }}"
                                            :checked="in_array(
                                                $value->id,
                                                $role
                                                    ->getAllPermissions()
                                                    ->pluck('id')
                                                    ->toArray(),
                                            )" />
                                    </td>
                                @endforeach
                                {{-- <td class="table-report__action w-56">
                                    <div class="flex justify-center items-center">
                                        <x-forms.buttons.icon route="roles.permissions', $role->id)" icon="list-checks" label="Permissões" />
                                    </div>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-right mt-5">
                <button type="submit" class="btn btn-primary w-24">Salvar</button>
            </div>
        </div>
        {!! Form::close() !!}
        <!-- END: Form Layout -->
    </div>
    </div>
    @push('custom-scripts')
        <script type="text/javascript">
            function checkAll() {
                const checkboxes = document.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach((checkbox) => {
                    checkbox.checked = true;
                });
            }

            function unCheckAll() {
                const checkboxes = document.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach((checkbox) => {
                    checkbox.checked = false;
                });
            }
        </script>
    @endpush
</x-app-layout>
