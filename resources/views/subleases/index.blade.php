<x-app-layout>
    <h2 class="intro-y text-lg font-medium mt-10">
        Equipamentos Sublocados
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">PRODUTO</th>
                        <th class="text-center whitespace-nowrap">LOCAR</th>
                        <th class="text-center whitespace-nowrap">OS Nº</th>
                        <th class="text-center whitespace-nowrap">DIAS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="intro-x">
                            <td>
                                <span class="font-medium whitespace-nowrap">{{ $product['name'] }}</span>
                            </td>
                            <td class="text-center">{{ $product['quantity'] }}</td>
                            <td class="text-center">{{ $product['os_number'] }}</td>
                            <td class="text-center">{{ $product['days'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->

    </div>
</x-app-layout>
