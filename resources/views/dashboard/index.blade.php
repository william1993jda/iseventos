<x-app-layout>
    <h2 class="intro-y text-lg font-medium mt-10">
        Dashboard
    </h2>
    <div class="grid grid-cols-12 gap-5 mt-5">
        <!-- BEGIN: Calendar Side Menu -->
        <div class="col-span-12 xl:col-span-4 2xl:col-span-3">
            <div class="report-box zoom-in mb-8">
                <div class="box p-5">
                    <div class="flex">
                        <i data-lucide="clipboard-check" class="report-box__icon text-primary"></i>
                        <div class="ml-auto"></div>
                    </div>
                    <div class="text-3xl font-medium leading-8 mt-6">{{ $budgets }}</div>
                    <div class="text-base text-slate-500 mt-1">Orçamentos</div>
                </div>
            </div>
            <div class="report-box zoom-in mb-8">
                <div class="box p-5">
                    <div class="flex">
                        <i data-lucide="clipboard-list" class="report-box__icon text-primary"></i>
                        <div class="ml-auto"></div>
                    </div>
                    <div class="text-3xl font-medium leading-8 mt-6">{{ $orderServices }}</div>
                    <div class="text-base text-slate-500 mt-1">Ordens de Serviço</div>
                </div>
            </div>
            <div class="report-box zoom-in mb-8">
                <div class="box p-5">
                    <div class="flex">
                        <i data-lucide="package-search" class="report-box__icon text-primary"></i>
                        <div class="ml-auto"></div>
                    </div>
                    <div class="text-3xl font-medium leading-8 mt-6">{{ $subleases }}</div>
                    <div class="text-base text-slate-500 mt-1">Equipamentos Sublocados</div>
                </div>
            </div>
            <div class="report-box zoom-in mb-8">
                <div class="box p-5">
                    <div class="flex">
                        <i data-lucide="truck" class="report-box__icon text-primary"></i>
                        <div class="ml-auto"></div>
                    </div>
                    <div class="text-3xl font-medium leading-8 mt-6">{{ $providers }}</div>
                    <div class="text-base text-slate-500 mt-1">Fornecedores</div>
                </div>
            </div>


        </div>
        <!-- END: Calendar Side Menu -->
        <!-- BEGIN: Calendar Content -->
        <div class="col-span-12 xl:col-span-8 2xl:col-span-9">
            <div class="box p-5">
                <div class="full-calendar" id="calendar"></div>
            </div>
        </div>
        <!-- END: Calendar Content -->
    </div>

    <div id="modal-event-detail" class="modal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto" id="modal-event-detail-title"></h2>
                </div>
                <div class="modal-body" id="modal-event-detail-body">
                </div>
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Fechar</button>
                    <a href="#" target="_blank" class="btn btn-primary w-20"
                        id="modal-event-detail-link">Visualizar</a>
                </div>
            </div>
        </div>
    </div>
    @push('custom-scripts')
        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function(e) {
                const modalEventDetail = tailwind.Modal.getInstance(document.querySelector(
                    "#modal-event-detail"));
                const modalEventDetailTitle = document.getElementById('modal-event-detail-title');
                const modalEventDetailBody = document.getElementById('modal-event-detail-body');
                const modalEventDetailLink = document.getElementById('modal-event-detail-link');

                const divCalendar = document.getElementById('calendar');

                const today = "{{ $today }}";
                const events = @json($events);

                let calendar = new Calendar(divCalendar, {
                    locale: brLocale,
                    plugins: [
                        interactionPlugin,
                        dayGridPlugin,
                        timeGridPlugin,
                        listPlugin,
                    ],
                    headerToolbar: {
                        left: "prev,next today",
                        center: "title",
                        right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
                    },
                    initialDate: today,
                    events: events,
                    eventClick: function(info) {
                        const props = info.event._def.extendedProps;

                        let modalBody = `
                        <div><strong>Local</strong>: ${props.place}</div>
                        <div><strong>Data</strong>: ${props.dates}</div>
                        <div><strong>Cliente</strong>: ${props.customer}</div>
                        <div><strong>Status</strong>: ${props.status}</div>
                        `;

                        modalEventDetailTitle.innerHTML = info.event.title;
                        modalEventDetailBody.innerHTML = modalBody;
                        modalEventDetailLink.href = props.link;

                        modalEventDetail.show();
                    }
                });

                calendar.render();
            });
        </script>
    @endpush
</x-app-layout>
