<x-front-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Breafing Híbrido
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('front.briefings.index') }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
        </div>
        <div class="intro-y col-span-12">
            <!-- BEGIN: Form Layout -->
            {!! Form::open([
                'route' => 'front.briefings.store.hybrid',
                'method' => 'post',
                'class' => 'needs-validation',
            ]) !!}
            <div class="col-span-12 xl:col-span-8 mt-6">
                <div class="intro-y box p-5 mt-12 sm:mt-5">
                    <div class="sm:grid grid-cols-1 gap-2">
                        <x-forms.text name="name" label="Nome do Evento" />
                    </div>
                    <div class="sm:grid grid-cols-1 gap-2 mt-3">
                        <x-forms.text name="local" label="Local" />
                    </div>
                    <div class="sm:grid grid-cols-3 gap-2 mt-3">
                        <x-forms.text name="company" label="Empresa" />
                        <x-forms.text name="email" label="E-mail" />
                        <x-forms.text name="phone" label="Telefone" mask="'(99) 99999-9999'" />
                    </div>
                    <div class="sm:grid grid-cols-3 gap-2 mt-3">
                        <div class="sm:grid grid-cols-1 gap-2 mt-3 text-center">
                            <div class="font-bold">Montagem</div>
                        </div>
                        <div class="sm:grid grid-cols-1 gap-2 mt-3 text-center">
                            <div class="font-bold">Ensaio</div>
                        </div>
                        <div class="sm:grid grid-cols-1 gap-2 mt-3 text-center">
                            <div class="font-bold">Evento</div>
                        </div>
                    </div>
                    <div>
                        <div class="sm:grid grid-cols-3 gap-2 mt-3">
                            <div class="sm:grid grid-cols-2 gap-2 mt-3">
                                <x-forms.text name="start_date_mount" label="Início"
                                    class="datepicker form-control w-full" data-single-mode="true" />
                                <x-forms.text name="end_date_mount" label="Fim"
                                    class="datepicker form-control w-full" data-single-mode="true" />
                            </div>
                            <div class="sm:grid grid-cols-2 gap-2 mt-3">
                                <x-forms.text name="start_date_rehearsal" label="Início"
                                    class="datepicker form-control w-full" data-single-mode="true" />
                                <x-forms.text name="end_date_rehearsal" label="Fim"
                                    class="datepicker form-control w-full" data-single-mode="true" />
                            </div>
                            <div class="sm:grid grid-cols-2 gap-2 mt-3">
                                <x-forms.text name="start_date_event" label="Início"
                                    class="datepicker form-control w-full" data-single-mode="true" />
                                <x-forms.text name="end_date_event" label="Fim"
                                    class="datepicker form-control w-full" data-single-mode="true" />
                            </div>
                        </div>
                    </div>
                    <div class="sm:grid grid-cols-3 gap-2 mt-3">
                        <div class="sm:grid grid-cols-1 gap-2 mt-3">
                            <x-forms.number name="public" label="Quantidade de participantes" />
                        </div>
                        <div class="sm:grid grid-cols-1 gap-2 mt-3">
                            <x-forms.text name="bu" label="BU" />
                        </div>
                        <div class="sm:grid grid-cols-1 gap-2 mt-3">
                            <x-forms.text name="focal_point" label="Focal Point" />
                        </div>
                    </div>
                </div>
                <h3 class="text-lg font-medium truncate mt-3">
                    Agência
                </h3>
                <div class="intro-y box p-5 mt-12 sm:mt-3">
                    <div class="sm:grid grid-cols-3 gap-2 mt-3">
                        <x-forms.text name="agency_name" label="Nome" />
                        <x-forms.text name="agency_contact" label="Contato" />
                        <x-forms.text name="agency_phone" label="Telefone" mask="'(99) 99999-9999'" />
                    </div>
                    <div class="sm:grid grid-cols-4 gap-2 mt-3">
                        <x-forms.text name="agency_email" label="E-mail" />
                        <x-forms.select name="agency_production" label="Produção" :options="['' => 'Selecione...', '1' => 'Sim', '0' => 'Não']" />
                        <x-forms.select name="agency_criation" label="Criação" :options="['' => 'Selecione...', '1' => 'Sim', '0' => 'Não']" />
                        <x-forms.select name="agency_logistic" label="Logística" :options="['' => 'Selecione...', '1' => 'Sim', '0' => 'Não']" />
                    </div>
                </div>
                <h3 class="text-lg font-medium truncate mt-3">
                    Salas
                </h3>
                <div class="intro-y box p-5 mt-12 sm:mt-3">
                    <div id="box-rooms">
                        @if (!empty($briefing->hybrid->rooms))
                            @foreach ($briefing->hybrid->rooms as $index => $room)
                                <div id="room_{{ $index }}">
                                    <div class="sm:grid grid-cols-2 gap-2 mt-3">
                                        <x-forms.text name="room_name[{{ $index }}]" label="Nome"
                                            value="{{ $room->name }}" />
                                        <x-forms.select name="room_format[{{ $index }}]" label="Formato"
                                            :selected="$room->room_format" :options="[
                                                '' => 'Selecione...',
                                                'espinha_peixe' => 'Espinha de peixe',
                                                'u' => 'U',
                                                'meia_lua' => 'Meia Lua',
                                                'auditorio' => 'Auditório',
                                                'escolar' => 'Escolar',
                                                'mesa_redonda' => 'Mesa redonda',
                                            ]" />
                                    </div>
                                    <div class="sm:grid grid-cols-1 gap-2 mt-3">
                                        <x-forms.textarea name="room_description[{{ $index }}]"
                                            label="Comentários" value="{{ $room->comments }}" />
                                        <a href="javascript:void(0);" onclick="deleteRoom('{{ $index }}')"
                                            class="btn btn-primary shadow-md btn-remove-room">Remover sala</a>
                                        <hr>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div id="room_0">
                                <div class="sm:grid grid-cols-2 gap-2 mt-3">
                                    <x-forms.text name="room_name[0]" label="Nome" />
                                    <x-forms.select name="room_format[0]" label="Formato" :options="[
                                        '' => 'Selecione...',
                                        'espinha_peixe' => 'Espinha de peixe',
                                        'u' => 'U',
                                        'meia_lua' => 'Meia Lua',
                                        'auditorio' => 'Auditório',
                                        'escolar' => 'Escolar',
                                        'mesa_redonda' => 'Mesa redonda',
                                    ]" />
                                </div>
                                <div class="sm:grid grid-cols-1 gap-2 mt-3">
                                    <x-forms.textarea name="room_description[0]" label="Comentários" />
                                    <hr>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="mt-3">
                        <a href="javascript:void(0);" onclick="addRoom()" class="btn btn-primary shadow-md">Adicionar
                            sala</a>
                    </div>
                </div>
                <h3 class="text-lg font-medium truncate mt-3">
                    Mobiliário
                </h3>
                <div class="intro-y box p-5 mt-12 sm:mt-3">
                    <div class="sm:grid grid-cols-3 gap-2 mt-3">
                        <x-forms.select name="armchair" label="Poltrona" :options="['' => 'Selecione...', '1' => 'Sim', '0' => 'Não']" />
                        <x-forms.number name="armchair_quantity" label="Quantidade" />
                        <x-forms.text name="armchair_description" label="Observações" />
                    </div>
                    <div class="sm:grid grid-cols-3 gap-2 mt-3">
                        <x-forms.select name="pulpit" label="Pulpito" :options="['' => 'Selecione...', '1' => 'Sim', '0' => 'Não']" />
                        <x-forms.number name="pulpit_quantity" label="Quantidade" />
                        <x-forms.text name="pulpit_description" label="Observações" />
                    </div>
                    <div class="sm:grid grid-cols-2 gap-2 mt-3">
                        <x-forms.select name="table" label="Mesa de centro/canto" :options="['' => 'Selecione...', '1' => 'Sim', '0' => 'Não']" />
                        <x-forms.text name="table_description" label="Observações" />
                    </div>
                    <div class="sm:grid grid-cols-2 gap-2 mt-3">
                        <x-forms.select name="lounge" label="Lounge" :options="['' => 'Selecione...', '1' => 'Sim', '0' => 'Não']" />
                        <x-forms.text name="lounge_description" label="Observações" />
                    </div>
                    <div class="sm:grid grid-cols-1 gap-2 mt-3">
                        <x-forms.textarea name="others" label="Descreva" />
                    </div>
                </div>
                <h3 class="text-lg font-medium truncate mt-3">
                    Tela
                </h3>
                <div class="intro-y box p-5 mt-12 sm:mt-3">
                    <x-forms.select name="screen" label="Tela" :options="[
                        '' => 'Selecione...',
                        'Lona impressa' => 'Lona impressa',
                        'LED' => 'LED',
                        'Tela de armação' => 'Tela de armação',
                        'Tela em box' => 'Tela em box',
                        'TV' => 'TV',
                        'Vídeo All' => 'Vídeo All',
                    ]" />
                </div>
                <h3 class="text-lg font-medium truncate mt-3">
                    Iluminação
                </h3>
                <div class="intro-y box p-5 mt-12 sm:mt-3">
                    <div class="sm:grid grid-cols-3 gap-2 mt-3">
                        <x-forms.select name="lighting_decorative" label="Decorativa" :options="['' => 'Selecione...', '1' => 'Sim', '0' => 'Não']" />
                        <x-forms.select name="lighting_foyer" label="Foyer" :options="['' => 'Selecione...', '1' => 'Sim', '0' => 'Não']" />
                        <x-forms.select name="lighting_restaurant" label="Restaurante" :options="['' => 'Selecione...', '1' => 'Sim', '0' => 'Não']" />
                    </div>
                    <div class="sm:grid grid-cols-2 gap-2 mt-3">
                        <x-forms.select name="lighting_stage" label="Palco" :options="['' => 'Selecione...', '1' => 'Sim', '0' => 'Não']" />
                        <x-forms.select name="lighting_effects" label="Efeitos" :options="['' => 'Selecione...', '1' => 'Sim', '0' => 'Não']" />
                    </div>
                </div>
                <h3 class="text-lg font-medium truncate mt-3">
                    Sonorização
                </h3>
                <div class="intro-y box p-5 mt-12 sm:mt-3">
                    <div class="sm:grid grid-cols-4 gap-2 mt-3">
                        <x-forms.select name="sound_room" label="Sala" :options="['' => 'Selecione...', '1' => 'Sim', '0' => 'Não']" />
                        <x-forms.select name="sound_foyer" label="Foyer" :options="['' => 'Selecione...', '1' => 'Sim', '0' => 'Não']" />
                        <x-forms.select name="sound_restaurant" label="Restaurante" :options="['' => 'Selecione...', '1' => 'Sim', '0' => 'Não']" />
                        <x-forms.number name="microphone_quantity" label="Quantidade de Microfones" />
                    </div>
                </div>
                <h3 class="text-lg font-medium truncate mt-3">
                    Tradução
                </h3>
                <div class="intro-y box p-5 mt-12 sm:mt-3">
                    <div class="sm:grid grid-cols-2 gap-2 mt-3">
                        <x-forms.select name="translation" label="Tradução Virtual" :options="['' => 'Selecione...', '1' => 'Sim', '0' => 'Não']" />
                        <x-forms.select name="languages[]" label="Idiomas" :options="['' => 'Selecione...', 'pt' => 'Português', 'en' => 'Inglês', 'es' => 'Espanhol']" multiple />
                    </div>
                    <div class="sm:grid grid-cols-1 gap-2 mt-3">
                        <x-forms.textarea name="translation_comments" label="Descreva" />
                    </div>
                    <div class="sm:grid grid-cols-3 gap-2 mt-3">
                        <x-forms.number name="radio_quantity" label="Quantidade de rádios" />
                        <x-forms.text name="name_interpreter" label="Interprete - Nome" />
                        <x-forms.text name="phone_interpreter" label="Interprete - Telefone" />
                    </div>
                </div>
                <h3 class="text-lg font-medium truncate mt-3">
                    Plataforma de transmissão
                </h3>
                <div class="intro-y box p-5 mt-12 sm:mt-3">
                    <div class="sm:grid grid-cols-2 gap-2 mt-3">
                        <x-forms.select name="platform_transmission" label="Plataforma" :options="[
                            '' => 'Selecione...',
                            'Zoom meeting' => 'Zoom meeting',
                            'Zoom webinar' => 'Zoom webinar',
                            'Zoom +' => 'Zoom +',
                        ]" />
                        <x-forms.text name="link_event" label="Link zoom - IS" />
                    </div>
                    <div class="sm:grid grid-cols-2 gap-2 mt-3">
                        <x-forms.text name="site_landing" label="Site/Landing Page" />
                        <x-forms.text name="social_network" label="Rede Social" />
                    </div>
                </div>
                <h3 class="text-lg font-medium truncate mt-3">
                    Captação de Imagem
                </h3>
                <div class="intro-y box p-5 mt-12 sm:mt-3">
                    <div class="sm:grid grid-cols-3 gap-2 mt-3">
                        <x-forms.select name="speaker" label="Speaker remoto" :options="['' => 'Selecione...', '1' => 'Sim', '0' => 'Não']" />
                        <x-forms.number name="speaker_quantity" label="Quantidade" />
                        <x-forms.text name="speaker_description" label="Observações" />
                    </div>
                    <div class="sm:grid grid-cols-3 gap-2 mt-3">
                        <x-forms.select name="direction" label="Direção artística" :options="['' => 'Selecione...', '1' => 'Sim', '0' => 'Não']" />
                        <x-forms.number name="direction_quantity" label="Quantidade" />
                        <x-forms.text name="direction_description" label="Observações" />
                    </div>
                    <div class="sm:grid grid-cols-3 gap-2 mt-3">
                        <x-forms.select name="speaker_studio" label="Speaker em estúdio" :options="['' => 'Selecione...', '1' => 'Sim', '0' => 'Não']" />
                        <x-forms.number name="speaker_studio_quantity" label="Quantidade" />
                        <x-forms.text name="speaker_studio_description" label="Observações" />
                    </div>
                    <div class="sm:grid grid-cols-2 gap-2 mt-3">
                        <x-forms.select name="rehearsal" label="Ensaio" :options="['' => 'Selecione...', '1' => 'Sim', '0' => 'Não']" />
                        <x-forms.text name="rehearsal_address" label="Endereço" />
                    </div>
                    <div class="sm:grid grid-cols-2 gap-2 mt-3">
                        <x-forms.select name="recording" label="Gravação" :options="['' => 'Selecione...', '1' => 'Sim', '0' => 'Não']" />
                        <x-forms.text name="recording_address" label="Endereço" />
                    </div>
                </div>
                <h3 class="text-lg font-medium truncate mt-3">
                    Equipamentos transmissão
                </h3>
                <div class="intro-y box p-5 mt-12 sm:mt-3">
                    <div class="sm:grid grid-cols-2 gap-2 mt-3">
                        <x-forms.select name="teleprompter" label="Teleprompter" :options="['' => 'Selecione...', '1' => 'Sim', '0' => 'Não']" />
                        <x-forms.number name="teleprompter_quantity" label="Quantidade" />
                    </div>
                    <div class="sm:grid grid-cols-2 gap-2 mt-3">
                        <x-forms.select name="ipad" label="Ipad" :options="['' => 'Selecione...', '1' => 'Sim', '0' => 'Não']" />
                        <x-forms.number name="ipad_quantity" label="Quantidade" />
                    </div>
                    <div class="sm:grid grid-cols-1 gap-2 mt-3">
                        <x-forms.textarea name="ipad_description" label="Observações" />
                    </div>
                </div>
                <h3 class="text-lg font-medium truncate mt-3">
                    Estúdio
                </h3>
                <div class="intro-y box p-5 mt-12 sm:mt-3">
                    <div class="sm:grid grid-cols-2 gap-2 mt-3">
                        <x-forms.text name="studio_local" label="Local" />
                        <x-forms.text name="studio_room" label="Sala" />
                    </div>
                    <div class="sm:grid grid-cols-2 gap-2 mt-3">
                        <x-forms.text name="studio_speakers_quantity" label="Quantos speakers in loco" />
                        <x-forms.text name="studio_type" label="Tipo de estúdio" />
                    </div>
                </div>
                <h3 class="text-lg font-medium truncate mt-3">
                    Adicionais
                </h3>
                <div class="intro-y box p-5 mt-12 sm:mt-3">
                    <div class="sm:grid grid-cols-3 gap-2">
                        <div class="flex flex-col">
                            @if (!empty($briefing->hybrid) && in_array('totem', $briefing->hybrid->additionals))
                                <x-forms.checkbox-vertical name="additionals['totem']" label="Totem"
                                    :checked="true" />
                            @else
                                <x-forms.checkbox-vertical name="additionals['totem']" label="Totem"
                                    :checked="false" />
                            @endif
                            @if (!empty($briefing->hybrid) && in_array('flip_chart', $briefing->hybrid->additionals))
                                <x-forms.checkbox-vertical name="additionals['flip_chart']" label="Flip chart"
                                    :checked="true" />
                            @else
                                <x-forms.checkbox-vertical name="additionals['flip_chart']" label="Flip chart"
                                    :checked="false" />
                            @endif
                            @if (!empty($briefing->hybrid) && in_array('radio', $briefing->hybrid->additionals))
                                <x-forms.checkbox-vertical name="additionals['radio']" label="Rádio"
                                    :checked="true" />
                            @else
                                <x-forms.checkbox-vertical name="additionals['radio']" label="Rádio"
                                    :checked="false" />
                            @endif
                            @if (!empty($briefing->hybrid) && in_array('credenciamento', $briefing->hybrid->additionals))
                                <x-forms.checkbox-vertical name="additionals['credenciamento']" label="Credenciamento"
                                    :checked="true" />
                            @else
                                <x-forms.checkbox-vertical name="additionals['credenciamento']" label="Credenciamento"
                                    :checked="false" />
                            @endif
                            @if (!empty($briefing->hybrid) && in_array('recepcionista', $briefing->hybrid->additionals))
                                <x-forms.checkbox-vertical name="additionals['recepcionista']" label="Recepcionista"
                                    :checked="true" />
                            @else
                                <x-forms.checkbox-vertical name="additionals['recepcionista']" label="Recepcionista"
                                    :checked="false" />
                            @endif
                        </div>
                        <div class="flex flex-col mt-2">
                            @if (!empty($briefing->hybrid) && in_array('balcao', $briefing->hybrid->additionals))
                                <x-forms.checkbox-vertical name="additionals['balcao']" label="Balcão"
                                    :checked="true" />
                            @else
                                <x-forms.checkbox-vertical name="additionals['balcao']" label="Balcão"
                                    :checked="false" />
                            @endif
                            @if (!empty($briefing->hybrid) && in_array('backdrop', $briefing->hybrid->additionals))
                                <x-forms.checkbox-vertical name="additionals['backdrop']" label="Backdrop"
                                    :checked="true" />
                            @else
                                <x-forms.checkbox-vertical name="additionals['backdrop']" label="Backdrop"
                                    :checked="false" />
                            @endif
                            @if (!empty($briefing->hybrid) && in_array('paisagismo', $briefing->hybrid->additionals))
                                <x-forms.checkbox-vertical name="additionals['paisagismo']" label="Paisagismo"
                                    :checked="true" />
                            @else
                                <x-forms.checkbox-vertical name="additionals['paisagismo']" label="Paisagismo"
                                    :checked="false" />
                            @endif
                            @if (!empty($briefing->hybrid) && in_array('decoracao_jantar', $briefing->hybrid->additionals))
                                <x-forms.checkbox-vertical name="additionals['decoracao_jantar']"
                                    label="Decoração Jantar" :checked="true" />
                            @else
                                <x-forms.checkbox-vertical name="additionals['decoracao_jantar']"
                                    label="Decoração Jantar" :checked="false" />
                            @endif
                            @if (!empty($briefing->hybrid) && in_array('dj_sonoplasta', $briefing->hybrid->additionals))
                                <x-forms.checkbox-vertical name="additionals['dj_sonoplasta']" label="DJ / Sonoplasta"
                                    :checked="true" />
                            @else
                                <x-forms.checkbox-vertical name="additionals['dj_sonoplasta']" label="DJ / Sonoplasta"
                                    :checked="false" />
                            @endif
                        </div>
                        <div class="flex flex-col mt-2">
                            @if (!empty($briefing->hybrid) && in_array('gerador', $briefing->hybrid->additionals))
                                <x-forms.checkbox-vertical name="additionals['gerador']" label="Gerador"
                                    :checked="true" />
                            @else
                                <x-forms.checkbox-vertical name="additionals['gerador']" label="Gerador"
                                    :checked="false" />
                            @endif
                            @if (!empty($briefing->hybrid) && in_array('internet_dedicada', $briefing->hybrid->additionals))
                                <x-forms.checkbox-vertical name="additionals['internet_dedicada']"
                                    label="Internet dedicada" :checked="true" />
                            @else
                                <x-forms.checkbox-vertical name="additionals['internet_dedicada']"
                                    label="Internet dedicada" :checked="false" />
                            @endif
                            @if (!empty($briefing->hybrid) && in_array('votacao_interativa', $briefing->hybrid->additionals))
                                <x-forms.checkbox-vertical name="additionals['votacao_interativa']"
                                    label="Votacao Interativa" :checked="true" />
                            @else
                                <x-forms.checkbox-vertical name="additionals['votacao_interativa']"
                                    label="Votacao Interativa" :checked="false" />
                            @endif
                        </div>
                    </div>
                </div>
                <h3 class="text-lg font-medium truncate mt-3">
                    Observações/Outros:
                </h3>
                <div class="intro-y box p-5 mt-12 sm:mt-3">
                    <div class="sm:grid grid-cols-1 gap-2 mt-3">
                        <x-forms.textarea name="observations" label="Descreva" />
                    </div>
                </div>
                <div class="text-right my-5">
                    <button type="reset" class="btn btn-outline-secondary w-24 mr-1">Limpar</button>
                    <button type="submit" class="btn btn-primary w-24">Salvar</button>
                </div>
            </div>
            {!! Form::close() !!}
            <!-- END: Form Layout -->
        </div>
    </div>
    @push('custom-scripts')
        <script type="text/javascript">
            function addRoom() {
                const index = document.querySelectorAll('.btn-remove-room').length + 1;

                const formRoomElement = `
                    <div id="room_${index}">
                        <div class="sm:grid grid-cols-2 gap-2 mt-3">
                            <x-forms.text name="room_name[${index}]" label="Nome" />
                            <x-forms.select name="room_format[${index}]" label="Formato" :options="[
                                '' => 'Selecione...',
                                'espinha_peixe' => 'Espinha de peixe',
                                'u' => 'U',
                                'meia_lua' => 'Meia Lua',
                                'auditorio' => 'Auditório',
                                'escolar' => 'Escolar',
                                'mesa_redonda' => 'Mesa redonda',
                            ]" />
                        </div>
                        <div class="sm:grid grid-cols-1 gap-2 mt-3">
                            <x-forms.textarea name="room_description[${index}]" label="Comentários" />
                            <a href="javascript:void(0);" onclick="deleteRoom(${index})"
                                class="btn btn-primary shadow-md btn-remove-room">Remover sala</a>
                            <hr>
                        </div>
                    </div>`;

                const boxRooms = document.getElementById('box-rooms');
                boxRooms.insertAdjacentHTML('beforeend', formRoomElement);
            }

            function deleteRoom(index) {
                const room = document.getElementById(`room_${index}`);
                room.remove();
            }
        </script>
    @endpush
</x-front-layout>
