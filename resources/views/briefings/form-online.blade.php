<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Breafing Online
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
                {!! Form::model($briefing->toArray() + $briefing->online->toArray(), [
                    'route' => ['briefings.update.online', $briefing->online->id],
                    'method' => 'put',
                    'class' => 'needs-validation',
                ]) !!}
            @endif
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
                </div>
                <h3 class="text-lg font-medium truncate mt-3">
                    Adicionais
                </h3>
                <div class="intro-y box p-5 mt-12 sm:mt-3">
                    <div class="sm:grid grid-cols-3 gap-2">
                        <div class="flex flex-col">
                            @if (!empty($briefing->online) && in_array('gerador', $briefing->online->additionals))
                                <x-forms.checkbox-vertical name="additionals['gerador']" label="Gerador"
                                    :checked="true" />
                            @else
                                <x-forms.checkbox-vertical name="additionals['gerador']" label="Gerador"
                                    :checked="false" />
                            @endif
                            @if (!empty($briefing->online) && in_array('internet_dedicada', $briefing->online->additionals))
                                <x-forms.checkbox-vertical name="additionals['internet_dedicada']"
                                    label="Internet dedicada" :checked="true" />
                            @else
                                <x-forms.checkbox-vertical name="additionals['internet_dedicada']"
                                    label="Internet dedicada" :checked="false" />
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
                <x-forms.buttons.save-cancel :showMode="isset($showMode) ? $showMode : false" :model="$briefing" />
            </div>
            {!! Form::close() !!}
            <!-- END: Form Layout -->
        </div>
    </div>
</x-app-layout>
