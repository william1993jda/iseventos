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
                <strong>Data Inicio</strong>
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
<table style="border:none;border-collapse:collapse; width: 100%;">
    <tbody>
        <tr>
            <td style="text-align:left; border:none;">
                <strong>Condições Comerciais</strong>
            </td>
        </tr>
        <tr>
            <td style="text-align:left; border:none;">
                @if (!empty($commercial_conditions))
                    {!! nl2br($commercial_conditions) !!}
                @else
                    &nbsp;
                @endif
            </td>
        </tr>
    </tbody>
</table>

<br />
@php $total = 0; @endphp
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
                <th style="text-align:center; width: 60px;">
                    VALOR
                </th>
                <th style="text-align:center; width: 60px;">
                    QUANTIDADE
                </th>
                <th style="text-align:center; width: 60px;">
                    DIAS
                </th>
                <th style="text-align:center; width: 80px;">
                    TOTAL
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($room['categories'] as $category)
                <tr>
                    <td><strong>{{ $category['name'] }}</strong></td>
                    <td colspan="4">&nbsp;</td>
                </tr>
                @foreach ($category['products'] as $product)
                    @php
                        $days = count(explode(',', $product['days']));
                        $total += $product['quantity'] * $product['price'] * $days;
                    @endphp
                    <tr>
                        <td style="text-align:left;">{{ $product['product']['name'] }}</td>
                        {{-- @foreach ($room['days'] as $roomDate)
                            <td style="text-align:center;">
                                @if (in_array($roomDate, explode(',', $product['days'])))
                                    x
                                @endif
                            </td>
                        @endforeach --}}
                        <td style="text-align:center;">
                            {{ number_format($product['price'], 2, ',', '.') }}
                        </td>
                        <td style="text-align:center;">
                            {{ $product['quantity'] }}
                        </td>
                        <td style="text-align:center;">
                            {{ count(explode(',', $product['days'])) }}
                        </td>
                        <td style="text-align:right;">
                            {{ number_format($product['quantity'] * $product['price'] * $days, 2, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
                @foreach ($category['labors'] as $labor)
                    @php
                        $days = $labor['days'];
                        $total += $labor['quantity'] * $labor['price'] * $days;
                    @endphp
                    <tr>
                        <td>{{ $labor['labor']['name'] }}</td>
                        <td style="text-align:right;">
                            {{ number_format($labor['price'], 2, ',', '.') }}
                        </td>
                        <td style="text-align:center;">
                            {{ $labor['quantity'] }}
                        </td>
                        <td style="text-align:center;">
                            {{ $labor['days'] }}
                        </td>
                        <td style="text-align:right;">
                            {{ number_format($labor['quantity'] * $labor['price'] * $labor['days'], 2, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    <br />
@endforeach

<table style="border:none;border-collapse:collapse; width: 100%;">
    <tr>
        <td style="text-align:right;"><strong>SUBTOTAL</strong></td>
        <td style="text-align:right; width: 80px;"><strong>R$ {{ number_format($total, 2, ',', '.') }}</strong></td>
    </tr>
</table>

@php
    $subtotal = $total;
    $totalFee = 0;
    $totalDiscount = 0;
@endphp
@if (!empty($fee))
    <table style="border:none;border-collapse:collapse; width: 100%;">
        <tr>
            @if ($fee_type == 'percent')
                @php
                    $feePercentage = $fee;
                    $totalFeePercentage = ($feePercentage / 100) * $subtotal;
                    $totalFee = $totalFeePercentage;
                @endphp
                <td style="text-align:right;"><span class="text-fee">TAXA ({{ $fee }}%):</span></td>
                <td style="text-align:right; width: 80px;">
                    <span class="text-fee">R$ {{ number_format($totalFeePercentage, 2, ',', '.') }}</span>
                </td>
            @else
                @php
                    $totalFee = $fee;
                @endphp
                <td style="text-align:right;"><span class="text-fee">TAXA (R$
                        {{ number_format($fee, 2, ',', '.') }}):</span></td>
                <td style="text-align:right; width: 80px;">
                    <span class="text-fee">R$ {{ number_format($fee, 2, ',', '.') }}</span>
                </td>
            @endif
        </tr>
    </table>
@endif

@if (!empty($discount))
    <table style="border:none;border-collapse:collapse; width: 100%;">
        <tr>
            @if ($discount_type == 'percent')
                @php
                    $discountPercentage = $discount;
                    $totalDiscountPercentage = ($discountPercentage / 100) * $subtotal;
                    $totalDiscount = $totalDiscountPercentage;
                @endphp
                <td style="text-align:right;"><span class="text-discount">DESCONTO ({{ $discount }}%):</span></td>
                <td style="text-align:right; width: 80px;">
                    <span class="text-discount">R$ {{ number_format($totalDiscountPercentage, 2, ',', '.') }}</span>
                </td>
            @else
                @php
                    $totalDiscount = $discount;
                @endphp
                <td style="text-align:right;"><span class="text-discount">DESCONTO (R$
                        {{ number_format($discount, 2, ',', '.') }}):</span></td>
                <td style="text-align:right; width: 80px;">
                    <span class="text-discount">R$ {{ number_format($discount, 2, ',', '.') }}</span>
                </td>
            @endif
        </tr>
    </table>
@endif

@php
    $total = $subtotal - $totalDiscount + $totalFee;
@endphp

<table style="border:none;border-collapse:collapse; width: 100%;">
    <tr>
        <td style="text-align:right;"><span class="text-total">TOTAL:</span></td>
        <td style="text-align:right; width: 80px;">
            <span class="text-total">R$ {{ number_format($total, 2, ',', '.') }}</span>
        </td>
    </tr>
</table>

<br />

<p style="font-weight: bold;">INFORMAÇÕES IMPORTANTES:</p>
<p>
    * O envio dessa proposta não garante reserva dos equipamentos, para aprovação pedimos a gentileza de assinar
    nossa
    proposta e nos enviar por e-mail.
    <br />
    * Orçamento sujeito a alteração após visita técnica e briefing.<br />
    * Testes e ensaios apenas com agendamento antecipado.<br />
    * Equipamentos solicitados no dia do evento estarão sujeitos a disponibilidade e cobranças extras.<br />
    * Diária de suporte técnico: Carga horária técnica é composta por 12 horas totais, caso as horas totais sejam
    ultrapassadas, o orçamento ficará sujeito a cobrança de mais uma diária por cada técnico envolvido no
    evento.<br />
    * O conteúdo da apresentação é de total responsabilidade do cliente, apresentações devem ser entregues a equipe
    técnica via Pen Drive ou HD Externo.<br />
    * Em nosso orçamento não contemplamos testes de covid, caso seja necessário será de responsabilidade da
    contratante.<br />
    * Em caso de extravio, perda, roubo ou furto de equipamentos, a Contratada deverá ser ressarcida pela
    Contratante no
    valor integral dos equipamentos.
</p>

<p style="font-weight: bold;">POLÍTICA DE CANCELAMENTO:</p>
<p>
    Até 7 dias antes do evento, não há cobrança.<br />
    De 6 a 3 dias antes do evento, cobrança de 50% do valor do orçamento.<br />
    Até 2 dias antes do evento, cobrança de 100% do orçamento aprovado.
</p>

@if (!empty($payment_conditions))
    <p style="font-weight: bold;">CONDIÇÕES DE PAGAMENTO:</p>
    <p>{!! nl2br($payment_conditions) !!}</p>
@endif
