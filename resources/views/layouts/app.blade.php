<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="utf-8">
    <link href="{{ asset('dist/images/logo.svg') }}" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="IS Eventos">
    <meta name="keywords" content="IS Eventos">
    <meta name="author" content="IS Eventos">
    <title>IS Eventos</title>

    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <link rel="stylesheet" href="{{ url(mix('css/app.css')) }}">
    <script src="{{ url(mix('js/app.js')) }}" defer></script>

    @livewireStyles
    @livewireScripts
</head>
<!-- END: Head -->

<body class="py-5 md:py-0">

    @include('layouts.mobile-menu')

    @include('layouts.header')

    <div class="flex overflow-hidden">

        @include('layouts.side-menu')

        <!-- BEGIN: Content -->
        <div class="content" x-data="">
            {{ $slot }}
        </div>
        <!-- END: Content -->
    </div>

    <!-- BEGIN: Delete Confirmation Modal -->
    <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Deseja remover?</div>
                        <div class="text-slate-500 mt-2">
                            Tem certeza que deseja remover esse item?
                        </div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        <form action="#" method="POST" id="delete-confirmation-modal-form">
                            @csrf
                            @method('delete')
                            <button type="button" data-tw-dismiss="modal"
                                class="btn btn-outline-secondary w-24 mr-1">Cancelar</button>
                            <button type="submit" class="btn btn-danger w-24">Remover</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Delete Confirmation Modal -->

    @stack('custom-scripts')
</body>

</html>
