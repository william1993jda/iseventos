<x-front-layout>
    <div class="text-center">
        <h2 class="intro-y text-lg font-medium mb-2">
            Briefing
        </h2>
        <h4 class="intro-y text-m font-medium mb-4">Selecione o tipo do evento abaixo</h4>
        <a href="{{ route('front.briefings.create.type', 'online') }}" class="btn btn-primary shadow-md mr-2">Online</a>
        <a href="{{ route('front.briefings.create.type', 'person') }}"
            class="btn btn-primary shadow-md mr-2">Presencial</a>
        <a href="{{ route('front.briefings.create.type', 'hybrid') }}" class="btn btn-primary shadow-md mr-2">Híbrido</a>
    </div>
    @push('custom-scripts')
        @if (session('success'))
            <script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function(e) {
                    document.getElementById('success-notification-title').innerHTML = "IS Eventos";
                    document.getElementById('success-notification-message').innerHTML = "{{ session('success') }}";

                    Toastify({
                        node: $("#success-notification").clone().removeClass("hidden")[0],
                        duration: 5000,
                        newWindow: true,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "transparent",
                        stopOnFocus: true,
                    }).showToast();
                });
            </script>
        @endif
    @endpush
</x-front-layout>
