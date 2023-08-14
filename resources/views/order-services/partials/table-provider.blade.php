<div>
    @if (!empty($listProviders['providers']))
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <h2 class="font-medium text-base mr-auto">FORNECEDORES</h2>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            {{-- <button class="btn btn-primary shadow-md mr-2" onclick="changeRoomProvider()">
                Trocar sala
            </button> --}}
        </div>
        <div class="intro-y col-span-12 box px-5 pt-5 my-3">
            @foreach ($listProviders['providers'] as $provider)
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                    <h3 class="font-medium text-base mr-auto">{{ $provider['name'] }}</h3>
                    <a href="{{ route('orderServices.print.provider', [$orderService->id, $provider['id']]) }}"
                        target="_blank" class="btn btn-primary shadow-md">
                        Imprimir
                    </a>
                </div>
                <table class="table mb-3">
                    <thead>
                        <tr>
                            {{-- <th class="whitespace-nowrap">
                                <input type="checkbox" name="checkbox_provider" onclick="checkAllProvider()">
                            </th> --}}
                            <th class="whitespace-nowrap">EQUIPAMENTO</th>
                            @foreach ($listProviders['days'] as $day)
                                <th class="whitespace-nowrap w-10">{{ $day }}</th>
                            @endforeach
                            <th class="whitespace-nowrap text-center w-10">SALA</th>
                            <th class="whitespace-nowrap text-center w-10">QUANTIDADE</th>
                            <th class="whitespace-nowrap w-10">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($provider['categories'] as $category)
                            <tr class="bg-red-100">
                                {{-- <td class="whitespace-nowrap">&nbsp;</td> --}}
                                <td class="whitespace-nowrap font-medium">
                                    {{ $category['name'] }}
                                </td>
                                <td class="whitespace-nowrap" colspan="{{ count($listProviders['days']) + 5 }}">
                                    &nbsp;</td>
                            </tr>
                            @foreach ($category['products'] as $product)
                                <tr>
                                    {{-- <td class="whitespace-nowrap w-4">
                                        <input type="checkbox" class="checkbox_provider" value="{{ $product['id'] }}">
                                    </td> --}}
                                    <td class="whitespace">{{ $product['name'] }}</td>
                                    @foreach ($listProviders['days'] as $day)
                                        <td class="whitespace-nowrap">
                                            @if (in_array($day, explode(',', $product['days'])))
                                                <x-forms.checkbox name="active" :checked="true"
                                                    wire:click="checkDayRoomProvider({{ $product['id'] }}, '{{ $day }}')" />
                                            @else
                                                <x-forms.checkbox name="active" :checked="false"
                                                    wire:click="checkDayRoomProvider({{ $product['id'] }}, '{{ $day }}')" />
                                            @endif
                                        </td>
                                    @endforeach
                                    <td class="whitespace-nowrap w-48">
                                        <select name="place_room_id" class="form-control w-full"
                                            wire:change="onChangeProviderRoom({{ $product['id'] }}, $event.target.value)">
                                            <option value="">Selecione</option>
                                            @foreach ($placeRooms as $placeRoomId => $placeRoomName)
                                                @if ($placeRoomId == $product['place_room_id'])
                                                    <option value="{{ $placeRoomId }}" selected>
                                                        {{ $placeRoomName }}
                                                    </option>
                                                @else
                                                    <option value="{{ $placeRoomId }}">
                                                        {{ $placeRoomName }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <x-forms.number name="quantity_provider_{{ $product['id'] }}" min="1"
                                            :value="$product['quantity']"
                                            wire:change="onChangeQuantityProvider({{ $product['id'] }}, $event.target.value)" />
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <button class="btn btn-sm btn-primary delete-confirmation-button" type="button"
                                            wire:click="confirmProviderRemove({{ $product['id'] }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-trash-2 w-5 h-5">
                                                <path d="M3 6h18" />
                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                                <line x1="10" x2="10" y1="11" y2="17" />
                                                <line x1="14" x2="14" y1="11" y2="17" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        </div>
    @endif
</div>
