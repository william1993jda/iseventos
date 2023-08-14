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

    .text-fee {
        color: #22C55E;
        font-weight: bold;
    }

    .text-discount {
        color: #EF4444;
        font-weight: bold;
    }

    .text-total {
        font-weight: bold;
        font-size: 14px;
    }
</style>
<table style="border:none;border-collapse:collapse; width: 100%;">
    <tbody>
        <tr>
            <td style="text-align:center; border:none;">
                <img src="{{ public_path('dist/images/logo-horizontal.png') }}" width="300">
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
                <strong>Alterado por</strong>
            </td>
        </tr>
        <tr>
            <td style="border:none">
                {{ $name }}
            </td>
            <td style="text-align:center; width: 120px; border:none;">
                {{ $last_user_name }}
            </td>
        </tr>
    </tbody>
</table>
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

<br />

<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:left; width: 100%;">
                FREELANCER
            </th>
            <th style="text-align:center; width: 60px;">
                QUANTIDADE
            </th>
            <th style="text-align:center; width: 60px;">
                DIAS
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
            <tr>
                <td style="text-align:left;">{{ $product['name'] }}</td>
                <td style="text-align:center;">
                    {{ $product['quantity'] }}
                </td>
                <td style="text-align:center;">
                    {{ count(explode(',', $product['days'])) }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
