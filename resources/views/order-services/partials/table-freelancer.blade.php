<div>
    @if (!empty($listFreelancers['freelancers']))
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <h2 class="font-medium text-base mr-auto">FREELANCER</h2>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            {{-- <button class="btn btn-primary shadow-md mr-2" onclick="changeRoomFreelancer()">
                Trocar sala
            </button> --}}
            <a href="{{ route('orderServices.print.freelancer', $orderService->id) }}" target="_blank"
                class="btn btn-primary shadow-md">
                Imprimir
            </a>
        </div>
        <div class="intro-y col-span-12 box px-5 pt-5 my-3">
            <table class="table">
                <thead>
                    <tr>
                        {{-- <th class="whitespace-nowrap">
                            <input type="checkbox" name="checkbox_product" onclick="checkAllFreelancer()">
                        </th> --}}
                        <th class="whitespace-nowrap">EQUIPAMENTO</th>
                        <th class="whitespace-nowrap text-center w-10">SALA</th>
                        <th class="whitespace-nowrap text-center w-28">DIAS</th>
                        <th class="whitespace-nowrap text-center w-28">QUANTIDADE</th>
                        <th class="whitespace-nowrap w-10">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listFreelancers['freelancers'] as $freelancer)
                        <tr>
                            {{-- <td class="whitespace-nowrap w-4">
                                <input type="checkbox" class="checkbox_product" value="{{ $freelancer['id'] }}">
                            </td> --}}
                            <td class="whitespace">
                                {{ $freelancer['name'] }}
                            </td>
                            <td class="whitespace-nowrap w-48">
                                <select name="place_room_id" class="form-control w-full"
                                    wire:change="onChangeFreelancerRoom({{ $freelancer['id'] }}, $event.target.value)">
                                    <option value="">Selecione</option>
                                    @foreach ($placeRooms as $placeRoomId => $placeRoomName)
                                        @if ($placeRoomId == $freelancer['place_room_id'])
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
                            <td class="whitespace-nowrap w-28">
                                <x-forms.number name="days_freelancer_{{ $freelancer['id'] }}" min="1"
                                    :value="$freelancer['days']"
                                    wire:change="onChangeDaysFreelancer({{ $freelancer['id'] }}, $event.target.value)" />
                            </td>
                            <td class="whitespace-nowrap w-28">
                                <x-forms.number name="quantity_freelancer_{{ $freelancer['id'] }}" min="1"
                                    :value="$freelancer['quantity']"
                                    wire:change="onChangeQuantityFreelancer({{ $freelancer['id'] }}, $event.target.value)" />
                            </td>
                            <td class="whitespace-nowrap">
                                <button class="btn btn-sm btn-primary delete-confirmation-button" type="button"
                                    wire:click="confirmFreelancerRemove({{ $freelancer['id'] }})">
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
