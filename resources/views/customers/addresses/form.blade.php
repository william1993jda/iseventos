<x-app-layout>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ $customer->fantasy_name }} - Endereço
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('customers.addresses.index', $customer->id) }}"
                class="btn btn-secondary shadow-md mr-2">Voltar</a>
            <div class="hidden md:block mx-auto text-slate-500"></div>
        </div>
        <div class="intro-y col-span-12">
            @if (empty($address->id))
                {!! Form::open([
                    'route' => ['customers.addresses.store', $customer->id],
                    'method' => 'post',
                    'class' => 'needs-validation',
                ]) !!}
            @else
                {!! Form::model($address, [
                    'route' => ['customers.addresses.update', [$customer->id, $address->id]],
                    'method' => 'put',
                    'class' => 'needs-validation',
                ]) !!}
            @endif
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div class="sm:grid grid-cols-2 gap-2">
                    <x-forms.text name="name" label="Nome" />
                    <div class="flex items-end">
                        <div class="w-full">
                            <x-forms.text name="zipcode" label="CEP" mask="'99.999-999'" />
                        </div>
                        <button type="button" class="btn btn-primary shadow-md ml-2"
                            onclick="getAddress()">Buscar</button>
                    </div>
                </div>
                <div class="sm:grid grid-cols-3 gap-2 mt-3">
                    <x-forms.text name="street" label="Logradouro" />
                    <x-forms.text name="number" label="Número" />
                    <x-forms.text name="complement" label="Complemento" />
                </div>
                <div class="sm:grid grid-cols-3 gap-2 mt-3">
                    <x-forms.text name="district" label="Bairro" />
                    <x-forms.text name="city" label="Cidade" />
                    <x-forms.select name="state" label="Estado" :options="$states" />
                </div>
                <x-forms.buttons.save-cancel :showMode="isset($showMode) ? $showMode : false" :model="$address" />
            </div>
            {!! Form::close() !!}
            <!-- END: Form Layout -->
        </div>
    </div>
    @push('custom-scripts')
        <script type="text/javascript">
            function getAddress() {
                let zipcode = document.getElementById('zipcode').value;

                if (zipcode.length < 10) {
                    return showErrorZipcode();
                }

                zipcode = zipcode.replace(/\D/g, '');

                fetch("https://viacep.com.br/ws/" + zipcode + "/json/", {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    }).then((response) => response.json())
                    .then((data) => {
                        if (!data) {
                            return showErrorZipcode();
                        }

                        document.getElementById('street').value = data.logradouro;
                        document.getElementById('district').value = data.bairro;
                        document.getElementById('city').value = data.localidade;
                        const state = document.getElementById('state').tomselect;
                        state.setValue(data.uf);
                    })
                    .catch((error) => {
                        return showErrorZipcode();
                    });
            }

            function showErrorZipcode() {
                document.getElementById('error-notification-title').innerHTML = 'CEP inválido';
                document.getElementById('error-notification-message').innerHTML = 'Informe um CEP válido.';

                Toastify({
                    node: $("#error-notification").clone().removeClass("hidden")[0],
                    duration: 5000,
                    newWindow: true,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "transparent",
                    stopOnFocus: true,
                }).showToast();
            }
        </script>
    @endpush
</x-app-layout>
