<style>
    * {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
    }

    th {
        background-color: lightgrey;
        padding: 0px 4px 2px 4px;
        border: 1px solid black;

    }

    td {
        padding: 0px 4px 2px 4px;
        border: 1px solid black;

    }

    .text-center {
        text-align: center;
    }
</style>
<table style="border:none;border-collapse:collapse; width: 100%;">
    <tbody>
        <tr>
            <td style="text-align:center; border:none;">
                <img src="{{ public_path('assets/admin/images/logo-horizontal.png') }}" width="300">
            </td>
        </tr>
    </tbody>
</table>

<br />

<table style="border:none;border-collapse:collapse; width: 100%;">
    <tbody>
        <tr>
            <td style="text-align:left; border:none;">
                <strong>Nome do Evento</strong>
            </td>
            <td style="text-align:center; width: 120px; border:none;">
                <strong>Data da solicitação</strong>
            </td>
        </tr>
        <tr>
            <td style="border:none">
                {{ $name }}
            </td>
            <td style="text-align:center; width: 120px; border:none;">
                {{ $request_date }}
            </td>
        </tr>
    </tbody>
</table>
<table style="border:none;border-collapse:collapse; width: 100%;">
    <tbody>
        <tr>
            <td style="text-align:left; border:none;">
                <strong>Cliente</strong>
            </td>
            <td style="text-align:left; border:none;">
                <strong>Contato</strong>
            </td>
            <td style="text-align:left; border:none;">
                <strong>Telefone</strong>
            </td>
            <td style="text-align:left; border:none;">
                <strong>E-mail</strong>
            </td>
        </tr>
        <tr>
            <td style="border:none;">
                {{ $customer }}
            </td>
            <td style="border:none;">
                {{ $customer_name }}
            </td>
            <td style="border:none;">
                {{ $customer_phone }}
            </td>
            <td style="border:none;">
                {{ $customer_email }}
            </td>
        </tr>
    </tbody>
</table>
@if (!empty($agency))
<table style="border:none;border-collapse:collapse; width: 100%;">
    <tbody>
        <tr>
            <td style="text-align:left; border:none;">
                <strong>Agência</strong>
            </td>
        </tr>
        <tr>
            <td style="border:none;">
                {{ $agency }}
            </td>
        </tr>
    </tbody>
</table>
@endif
<table style="border:none;border-collapse:collapse; width: 100%;">
    <tbody>
        <tr>
            <td style="text-align:left; border:none;">
                <strong>Data Início</strong>
            </td>
            <td style="text-align:left; border:none;">
                <strong>Data Fim</strong>
            </td>
            <td style="text-align:left; border:none;">
                <strong>Data Montagem</strong>
            </td>
            <td style="text-align:left; border:none;">
                <strong>Data Desmontagem</strong>
            </td>
        </tr>
        <tr>
            <td style="text-align:left; border:none;">
                {{ $start_date }}
            </td>
            <td style="text-align:left; border:none;">
                {{ $end_date }}
            </td>
            <td style="text-align:left; border:none;">
                {{ $mount_date }}
            </td>
            <td style="text-align:left; border:none;">
                {{ $unmount_date }}
            </td>
        </tr>
    </tbody>
</table>
@if (!empty($public) || !empty($situation))
<table style="border:none;border-collapse:collapse; width: 100%;">
    <tbody>
        <tr>
            <td style="text-align:left; border:none;">
                <strong>Público</strong>
            </td>
            <td style="text-align:left; border:none;">
                <strong>Situação</strong>
            </td>
        </tr>
        <tr>
            <td style="text-align:left; border:none;">
                {{ $public }}
            </td>
            <td style="text-align:left; border:none;">
                {{ $situation }}
            </td>
        </tr>
    </tbody>
</table>
@endif
<table style="border:none;border-collapse:collapse; width: 100%;">
    <tbody>
        <tr>
            <td style="text-align:left; border:none;">
                <strong>Local</strong>
            </td>
            <td style="text-align:left; border:none;">
                <strong>Cidade</strong>
            </td>
        </tr>
        <tr>
            <td style="text-align:left; border:none;">
                @if (!empty($place))
                {{ $place }}
                @else
                &nbsp;
                @endif
            </td>
            <td style="text-align:left; border:none;">
                {{ $city }}
            </td>
        </tr>
    </tbody>
</table>
<table style="border:none;border-collapse:collapse; width: 100%;">
    <tbody>
        <tr>
            <td style="text-align:left; border:none;">
                <strong>Observações</strong>
            </td>
        </tr>
        <tr>
            <td style="text-align:left; border:none;">
                @if (!empty($observation))
                {!! nl2br($observation) !!}
                @else
                &nbsp;
                @endif
            </td>
        </tr>
    </tbody>
</table>

<br />

@foreach ($rooms as $room)
<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:center; background-color: #FFF;">
                {{ $room['place_room_name'] }}
            </th>
        </tr>
    </thead>
</table>

<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:left; width: 100%;">
                EQUIPAMENTOS
            </th>
            @foreach (explode(',', $room['days']) as $roomDate)
            <th style="text-align:center; width: 60px;">
                {{ substr($roomDate, 0, 5) }}
            </th>
            @endforeach
            <th style="text-align:center; width: 60px;">
                Quantidade
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($room['categories'] as $category)
        <tr>
            <td><strong>{{ $category['name'] }}</strong></td>
            <td colspan="{{ count(explode(',', $room['days'])) + 1 1}}">&nbsp;</td>
        </tr>
        @foreach ($category['products'] as $product)
        @php
        $days = count(explode(',', $product['days']));
        @endphp
        <tr>
            <td style="text-align:left;">{{ $product['product']['name'] }}</td>
            @foreach (explode(',', $room['days']) as $roomDate)
            <td style="text-align:center;">
                @if (in_array($roomDate, explode(',', $product['days'])))
                x
                @endif
            </td>
            @endforeach
            <td style="text-align:center;">
                {{ $product['quantity'] }}
            </td>
        </tr>
        @endforeach
        @endforeach
    </tbody>
</table>
<br />
@endforeach