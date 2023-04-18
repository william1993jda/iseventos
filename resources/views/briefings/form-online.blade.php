<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Briefing
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('briefings.index') }}" class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            @if (!empty($briefing->id))
                <x-forms.buttons.primary route="briefings.documents.index" :id="$briefing->id" label="Documentos" />
            @endif
        </div>
        <div class="intro-y col-span-12">
            <!-- BEGIN: Form Layout -->
            @if (empty($briefing->id))
                {!! Form::open([
                    'route' => 'briefings.store.online',
                    'method' => 'post',
                    'class' => 'needs-validation',
                ]) !!}
            @else
                {!! Form::model($briefing, [
                    'route' => ['briefings.update.online', $briefing->id],
                    'method' => 'put',
                    'class' => 'needs-validation',
                ]) !!}
            @endif
            <div class="col-span-12 xl:col-span-8 mt-6">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Breafings Online:
                    </h2>
                </div>
                <div class="intro-y box p-5 mt-12 sm:mt-5">
                    <div class="sm:grid grid-cols-1 gap-2">
                        <x-forms.text name="name" label="Nome do Evento" />
                    </div>
                    <div class="sm:grid grid-cols-1 gap-2 mt-3">
                        <x-forms.text name="local" label="Local" />
                    </div>
                    <div class="sm:grid grid-cols-1 gap-2 mt-3">
                        <x-forms.text name="type_event" label="Tipo Evento" />
                    </div>
                    <div class="sm:grid grid-cols-1 gap-2 mt-3">
                        <x-forms.text name="room" label="Sala" />
                    </div>
                    <div class="sm:grid grid-cols-3 gap-2 mt-3">
                        <x-forms.text name="company" label="Empresa" />
                        <x-forms.text name="email" label="E-mail" />
                        <x-forms.text name="phone" label="Telefone" mask="'(99) 99999-9999'" />
                    </div>
                    <div class="sm:grid grid-cols-2 gap-2 mt-3">
                        <div class="sm:grid grid-cols-4 gap-2 mt-3">
                            <div class="font-bold">Ensaio:</div>
                        </div>
                        <div class="sm:grid grid-cols-2 gap-2 mt-3">
                            <div class="font-bold">Evento:</div>
                        </div>
                    </div>
                    <div>
                        <div class="sm:grid grid-cols-2 gap-2 mt-3">
                            <div class="sm:grid grid-cols-4 gap-2 mt-3">
                                <x-forms.text name="start_date_rehearsal" label="Inicio"
                                    class="datepicker form-control w-full" data-single-mode="true" />
                                <x-forms.text name="end_date_rehearsal" label="Fim"
                                    class="datepicker form-control w-full" data-daterange="true" />
                                <x-forms.text name="start_date_rehearsal" label="Inicio"
                                    class="datepicker form-control w-full" data-single-mode="true" />
                                <x-forms.text name="end_date_rehearsal" label="Fim"
                                    class="datepicker form-control w-full" data-daterange="true" />
                            </div>
                            <div class="sm:grid grid-cols-2 gap-2 mt-3">
                                <x-forms.text name="start_date_event" label="Inicio"
                                    class="datepicker form-control w-full" data-single-mode="true" />
                                <x-forms.text name="end_date_event" label="Fim"
                                    class="datepicker form-control w-full" data-daterange="true" />
                            </div>
                        </div>
                    </div>
                    <div class="sm:grid grid-cols-3  gap-2 mt-3">
                        <div class="sm:grid grid-cols-1 gap-2 mt-3">
                            <x-forms.text name="pax" label="Quantidade Pax:" />
                        </div>
                        <div class="sm:grid grid-cols-1 gap-2 mt-3">
                            <x-forms.text name="bu" label="BU:" />
                        </div>
                        <div class="sm:grid grid-cols-1 gap-2 mt-3">
                            <x-forms.text name="focal_point" label="Focal Point" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 xl:col-span-8 mt-6">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Agência
                    </h2>

                </div>
                <div class="intro-y box p-5 mt-12 sm:mt-5">
                    <div class="sm:grid grid-cols-3 gap-2 mt-3">
                        <x-forms.text name="agency_name" label="Nome" />
                        <x-forms.text name="agency_contact" label="Contato" />
                        <x-forms.text name="agency_phone" label="Telefone" mask="'(99) 99999-9999'" />
                    </div>
                    <div class="sm:grid grid-cols-4 gap-2 mt-3">
                        <x-forms.text name="agency_email" label="E-mail" />
                        <x-forms.text name="agency_production" label="Produção" />
                        <x-forms.text name="agency_criation" label="Criação" />
                        <x-forms.text name="agency_logistic" label="Logística" />
                    </div>
                </div>
            </div>
            <div class="col-span-12 xl:col-span-8 mt-6">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Sala
                    </h2>
                </div>
                <div class="intro-y box p-5 mt-12 sm:mt-5">
                    <div class="sm:grid grid-cols-2 gap-2 mt-3">
                        <x-forms.text name="room_quantity" label="Quantidade de Salas" />
                        <x-forms.text name="room_format" label="Formato" />
                    </div>
                    <div class="sm:grid grid-cols-1 gap-2 mt-3">
                        <x-forms.textarea name="room_description"
                            label="Comentários (Se houver mais de uma sala, especifique a montagem desejada em cada uma delas):" />
                    </div>
                </div>
            </div>
            <div class="col-span-12 xl:col-span-8 mt-6">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Plataforma de transmissão
                    </h2>

                </div>
                <div class="intro-y box p-5 mt-12 sm:mt-5">
                    <div class="sm:grid grid-cols-2 gap-2 mt-3">
                        <x-forms.select name="platform_transmission" label="Plataforma:" :options="[
                            '0' => 'Selecione...',
                            '1' => 'Zoom meeting',
                            '2' => 'Zoom webinar',
                            '3' => 'Zoom +',
                        ]" />
                        <x-forms.select name="link_event" label="Link zoom - IS:" :options="['0' => 'Selecione...', '1' => 'Sim', '2' => 'Não']" />
                    </div>
                    <div class="intro-y box p-5 mt-12 sm:mt-5">
                        <div class="sm:grid grid-cols-2 gap-2 mt-3">
                            <x-forms.text name="site_landing" label="Site/Landing Page:" />
                            <x-forms.text name="social_network" label="Rede Social:" />
                        </div>
                    </div>
                </div>
                <div class="col-span-12 xl:col-span-8 mt-6">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Captação de Imagem
                        </h2>

                    </div>
                    <div class="intro-y box p-5 mt-12 sm:mt-5">
                        <div class="sm:grid grid-cols-3 gap-2 mt-3">
                            <x-forms.select name="speaker" label="Speaker remoto:" :options="['0' => 'Selecione...', '1' => 'Sim', '2' => 'Não']" />
                            <x-forms.text name="speaker_quantity" label="Quantidade" />
                            <x-forms.text name="speaker_description" label="Observações" />
                        </div>
                    </div>
                    <div class="intro-y box p-5 mt-12 sm:mt-5">
                        <div class="sm:grid grid-cols-3 gap-2 mt-3">
                            <x-forms.select name="artistic_direction" label="Direção artística:" :options="[
                                '0' => 'Selecione...',
                                '1' => 'Pulpito em acrílico com monitor de retorno interno, monitor de 40 LCD frontal',
                                '2' => 'Pulpito em acrílico sem monitor de retorno interno',
                                '3' => 'Pulpito em madeira com monitor de retorno interno, monitor de 40 LCD frontal',
                            ]" />
                            <x-forms.text name="direction_quantity" label="Quantidade" />
                            <x-forms.text name="direction_description" label="Observações" />
                        </div>
                    </div>
                    <div class="intro-y box p-5 mt-12 sm:mt-5">
                        <div class="sm:grid grid-cols-2 gap-2 mt-3">
                            <x-forms.select name="rehearsal" label="Ensaio" :options="['0' => 'Selecione...', '1' => 'Sim', '2' => 'Não']" />
                            <x-forms.text name="rehearsal_address" label="Endereço:" />
                        </div>
                    </div>
                    <div class="intro-y box p-5 mt-12 sm:mt-5">
                        <div class="sm:grid grid-cols-2 gap-2 mt-3">
                            <x-forms.select name="recording" label="Gravação:" :options="['0' => 'Selecione...', '1' => 'Sim', '2' => 'Não']" />
                            <x-forms.text name="recording_address" label="Endereço:" />
                        </div>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-8 mt-6">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Tradução
                        </h2>
                    </div>
                    <div class="intro-y box p-5 mt-12 sm:mt-5">
                        <div class="sm:grid grid-cols-2 gap-2 mt-3">
                            <x-forms.select name="translation" label="Tradução Virtual:" :options="['0' => 'Selecione...', '1' => 'Sim', '2' => 'Não']" />
                            <x-forms.text name="languages" label="Idiomas:" />
                        </div>
                    </div>
                    <div class="intro-y box p-5 mt-12 sm:mt-5">
                        <div class="sm:grid grid-cols-3 gap-2 mt-3">
                            <x-forms.select name="recommendation_translation" label="Indicação de Interprete:"
                                :options="['0' => 'Selecione...', '1' => 'Sim', '2' => 'Não']" />
                            <x-forms.text name="name_interpreter" label="Nome:" />
                            <x-forms.text name="phone_interpreter" label="Telefone" mask="'(99) 99999-9999'" />
                        </div>
                    </div>
                </div>
                <div class="col-span-12 xl:col-span-8 mt-6">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Adicionais
                        </h2>
                    </div>
                    <div class="intro-y box p-5 mt-12 sm:mt-5">
                        <div class="sm:grid grid-cols-1 gap-2 mt-3">
                            <x-forms.textarea name="additional_description" label="Descreva:" />
                        </div>
                    </div>
                </div>
                <div class="col-span-12 xl:col-span-8 mt-6">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Observações/Outros:
                        </h2>

                    </div>
                    <div class="intro-y box p-5 mt-12 sm:mt-5">
                        <div class="sm:grid grid-cols-1 gap-2 mt-3">
                            <x-forms.textarea name="observation_description" label="Descreva:" />
                        </div>
                    </div>
                    <x-forms.buttons.save-cancel :showMode="isset($showMode) ? $showMode : false" :model="$briefing" />
                </div>
                {!! Form::close() !!}
                <!-- END: Form Layout -->
            </div>
        </div>
</x-app-layout>
