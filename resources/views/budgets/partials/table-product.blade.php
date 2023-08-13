<div>
    @if (!empty($listProducts['categories']))
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <h2 class="font-medium text-base mr-auto">EQUIPAMENTOS</h2>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            @if ($canEdit && !empty($budget->place_id))
                <button class="btn btn-primary shadow-md mr-2" onclick="applyBvProduct()">
                    Aplicar BV
                </button>
                <button class="btn btn-primary shadow-md mr-2" onclick="changeRoomProduct()">
                    Trocar sala
                </button>
            @else
                <button class="btn btn-primary shadow-md mr-2" disabled>Aplicar BV</button>
                <button class="btn btn-primary shadow-md mr-2" disabled>Trocar sala</button>
            @endif
        </div>
        <div class="intro-y col-span-12 box px-5 pt-5 my-3">
            <table class="table">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">
                            @if ($canEdit)
                                <input type="checkbox" name="checkbox_product" onclick="checkAllProduct()">
                            @endif
                        </th>
                        <th class="whitespace-nowrap">EQUIPAMENTO</th>
                        @foreach ($listProducts['days'] as $day)
                            <th class="whitespace-nowrap w-10">{{ $day }}</th>
                        @endforeach
                        <th class="whitespace-nowrap text-center w-10">SALA</th>
                        <th class="whitespace-nowrap text-center w-10">QUANTIDADE</th>
                        <th class="whitespace-nowrap text-center w-10">BV %</th>
                        <th class="whitespace-nowrap text-center w-10">VALOR</th>
                        <th class="whitespace-nowrap text-center w-10">TOTAL</th>
                        <th class="whitespace-nowrap w-10">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listProducts['categories'] as $category)
                        <tr class="bg-red-100">
                            <td class="whitespace-nowrap">&nbsp;</td>
                            <td class="whitespace-nowrap font-medium">
                                {{ $category['name'] }}
                            </td>
                            <td class="whitespace-nowrap" colspan="{{ count($listProducts['days']) + 6 }}">
                                &nbsp;</td>
                        </tr>
                        @foreach ($category['products'] as $product)
                            <tr>
                                <td class="whitespace-nowrap w-4">
                                    @if ($canEdit)
                                        <input type="checkbox" class="checkbox_product" value="{{ $product['id'] }}">
                                    @endif
                                </td>
                                <td class="whitespace">{{ $product['name'] }}</td>
                                @foreach ($listProducts['days'] as $day)
                                    <td class="whitespace-nowrap">
                                        @if ($canEdit)
                                            @if (in_array($day, explode(',', $product['days'])))
                                                <x-forms.checkbox name="active" :checked="true"
                                                    wire:click="checkDayRoom({{ $product['id'] }}, '{{ $day }}')" />
                                            @else
                                                <x-forms.checkbox name="active" :checked="false"
                                                    wire:click="checkDayRoom({{ $product['id'] }}, '{{ $day }}')" />
                                            @endif
                                        @else
                                            @if (in_array($day, explode(',', $product['days'])))
                                                <x-forms.checkbox name="active" :checked="true" disabled />
                                            @else
                                                <x-forms.checkbox name="active" :checked="false" disabled />
                                            @endif
                                        @endif
                                    </td>
                                @endforeach
                                <td class="whitespace-nowrap w-48">
                                    @if ($canEdit)
                                        <select name="place_room_id" class="form-control w-full"
                                            wire:change="onChangeProductRoom({{ $product['id'] }}, $event.target.value)">
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
                                    @else
                                        <div class="text-center">
                                            @if ($product['place_room_id'] == 0)
                                                &nbsp;
                                            @else
                                                @foreach ($placeRooms as $placeRoomId => $placeRoomName)
                                                    @if ($placeRoomId == $product['place_room_id'])
                                                        {{ $placeRoomName }}
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap">
                                    @if ($canEdit)
                                        <x-forms.number name="quantity_product_{{ $product['id'] }}" min="1"
                                            :value="$product['quantity']"
                                            wire:change="onChangeQuantity({{ $product['id'] }}, $event.target.value)" />
                                    @else
                                        <div class="text-center">
                                            {{ $product['quantity'] }}
                                        </div>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap">
                                    {{ number_format($product['bv'], 2, ',', '.') }}
                                </td>
                                <td class="whitespace-nowrap">
                                    {{ number_format($product['price'], 2, ',', '.') }}
                                </td>
                                <td class="whitespace-nowrap">
                                    {{ number_format($product['quantity'] * $product['price'] * count(explode(',', $product['days'])), 2, ',', '.') }}
                                </td>
                                <td class="whitespace-nowrap">
                                    @if ($canEdit)
                                        <button class="btn btn-sm btn-primary delete-confirmation-button" type="button"
                                            wire:click="confirmProductRemove({{ $product['id'] }})">
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
                                    @else
                                        <button class="btn btn-sm btn-primary delete-confirmation-button" type="button"
                                            disabled>
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
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
