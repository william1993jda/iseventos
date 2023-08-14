<div>
    @if (!empty($listGroups['groups']))
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <h2 class="font-medium text-base mr-auto">KITS</h2>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            {{-- <button class="btn btn-primary shadow-md mr-2" onclick="changeRoomGroup()">
                Trocar sala
            </button> --}}
        </div>
        <div class="intro-y col-span-12 box px-5 pt-5 my-3">
            <table class="table">
                <thead>
                    <tr>
                        {{-- <th class="whitespace-nowrap">
                            <input type="checkbox" name="checkbox_product" onclick="checkAllGroup()">
                        </th> --}}
                        <th class="whitespace-nowrap">EQUIPAMENTO</th>
                        @foreach ($listGroups['days'] as $day)
                            <th class="whitespace-nowrap w-10">{{ $day }}</th>
                        @endforeach
                        <th class="whitespace-nowrap text-center w-10">SALA</th>
                        <th class="whitespace-nowrap text-center w-10">QUANTIDADE</th>
                        <th class="whitespace-nowrap w-10">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listGroups['groups'] as $group)
                        <tr>
                            {{-- <td class="whitespace-nowrap w-4">
                                <input type="checkbox" class="checkbox_product" value="{{ $group['id'] }}">
                            </td> --}}
                            <td class="whitespace">
                                <div class="font-medium">
                                    {{ $group['name'] }}
                                </div>
                                <ul>
                                    @foreach ($group['products'] as $product)
                                        <li>{{ $product['name'] }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            @foreach ($listGroups['days'] as $day)
                                <td class="whitespace-nowrap">
                                    @if (in_array($day, explode(',', $group['days'])))
                                        <x-forms.checkbox name="active" :checked="true"
                                            wire:click="checkDayRoomGroup({{ $group['id'] }}, '{{ $day }}')" />
                                    @else
                                        <x-forms.checkbox name="active" :checked="false"
                                            wire:click="checkDayRoomGroup({{ $group['id'] }}, '{{ $day }}')" />
                                    @endif
                                </td>
                            @endforeach
                            <td class="whitespace-nowrap w-48">
                                <select name="place_room_id" class="form-control w-full"
                                    wire:change="onChangeGroupRoom({{ $group['id'] }}, $event.target.value)">
                                    <option value="">Selecione</option>
                                    @foreach ($placeRooms as $placeRoomId => $placeRoomName)
                                        @if ($placeRoomId == $group['place_room_id'])
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
                                <x-forms.number name="quantity_product_{{ $group['id'] }}" min="1"
                                    :value="$group['quantity']"
                                    wire:change="onChangeQuantityGroup({{ $group['id'] }}, $event.target.value)" />
                            </td>
                            <td class="whitespace-nowrap">
                                <button class="btn btn-sm btn-primary delete-confirmation-button" type="button"
                                    wire:click="confirmGroupRemove({{ $group['id'] }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
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
                </tbody>
            </table>
        </div>
    @endif
</div>
