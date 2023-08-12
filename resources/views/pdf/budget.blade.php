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
<table style="border:none;border-collapse:collapse; width: 100%; background-color: lightgrey; padding: 20px;">
    <tbody>
        <tr>
            <td style="text-align:center; border:none; width: 100%;">
                <span style="font-size: 22px; font-weight: bold;">PROPOSTA</span>
            </td>
            <td style="text-align:right; border:none;">
                <img src="{{ public_path('dist/images/logo_is_vermelho_preto_squad.png') }}" width="100">
            </td>
        </tr>
    </tbody>
</table>
<table style="border:none;border-collapse:collapse; width: 100%; background-color: lightgrey; padding: 5px;">
    <tbody>
        <tr>
            <td style="text-align:left; border:none; width: 70%;">
                <strong>Data da solicitação</strong>:&nbsp;{{ $request_date }}
            </td>
            <td style="text-align:left; border:none; width: 30%;">
                <strong>Status</strong>:&nbsp;{{ $status }}
            </td>
        </tr>
        <tr>
            <td style="text-align:left; border:none; width: 70%;">
                <strong>Orçamento N&deg;</strong>:&nbsp;{{ $budget_number }}
            </td>
            <td style="text-align:left; border:none; width: 30%;">
                &nbsp;
            </td>
        </tr>
    </tbody>
</table>
<table style="border:none;border-collapse:collapse; width: 100%; background-color: #F4F4F4; padding: 5px;">
    <tbody>
        <tr>
            <td style="text-align:center; border:none;">
                <strong>Dados do Cliente</strong>
            </td>
        </tr>
    </tbody>
</table>
<table style="border:none; border-collapse:collapse; width: 100%; padding: 5px 0px;">
    <tbody>
        <tr>
            <td style="text-align:left; border:none; width: 50%;">
                <strong>Cliente</strong>:&nbsp;{{ $customer }}
            </td>
            <td style="text-align:left; border:none; width: 50%;">
                <strong>CNPJ</strong>:&nbsp;{{ $customer_ein }}
            </td>
        </tr>
        <tr>
            <td style="text-align:left; border:none; width: 50%;">
                <strong>Contato</strong>:&nbsp;{{ $customer_name }}
            </td>
            <td style="text-align:left; border:none; width: 50%;">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td style="text-align:left; border:none; width: 50%;">
                <strong>E-mail</strong>:&nbsp;{{ $customer_email }}
            </td>
            <td style="text-align:left; border:none; width: 50%;">
                <strong>Telefone</strong>:&nbsp;{{ $customer_phone }}
            </td>
        </tr>
    </tbody>
</table>
<table style="border:none;border-collapse:collapse; width: 100%; background-color: #F4F4F4; padding: 5px;">
    <tbody>
        <tr>
            <td style="text-align:center; border:none;">
                <strong>Dados do Evento</strong>
            </td>
        </tr>
    </tbody>
</table>
<table style="border:none; border-collapse:collapse; width: 100%; padding: 5px 0px;">
    <tbody>
        <tr>
            <td style="text-align:left; border:none; width: 50%;">
                <strong>Evento</strong>:&nbsp;{{ $name }}
            </td>
            <td style="text-align:left; border:none; width: 50%;">
                <strong>Quantidade de participantes</strong>:&nbsp;{{ $public }}
            </td>
        </tr>
        <tr>
            <td style="text-align:left; border:none; width: 50%;">
                <strong>Local</strong>:&nbsp;{{ $place }}
            </td>
            <td style="text-align:left; border:none; width: 50%;">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td style="text-align:left; border:none; width: 50%;" colspan="2">
                <strong>Endereço</strong>:&nbsp;{{ $place_address }}
            </td>
        </tr>
        <tr>
            <td style="text-align:left; border:none; width: 50%;">
                <strong>Data de início</strong>:&nbsp;{{ $start_date }}
            </td>
            <td style="text-align:left; border:none; width: 50%;">
                <strong>Data de término</strong>:&nbsp;{{ $end_date }}
            </td>
        </tr>
        <tr>
            <td style="text-align:left; border:none; width: 50%;">
                <strong>Data de montagem</strong>:&nbsp;{{ $mount_date }}
            </td>
            <td style="text-align:left; border:none; width: 50%;">
                <strong>Data de desmontagem</strong>:&nbsp;{{ $unmount_date }}
            </td>
        </tr>
        <tr>
            <td style="text-align:left; border:none; width: 50%;" colspan="2">
                <strong>Observações</strong>:&nbsp;<br />
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
@php $total = 0; @endphp
@foreach ($rooms as $room)
    <table style="border:none;border-collapse:collapse; width: 100%;">
        <thead>
            <tr>
                <th style="text-align:center; background-color: #FFF;">
                    {{ $room['name'] }}
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
                    DIAS
                </th>
                <th style="text-align:center; width: 60px;">
                    QTD
                </th>
                <th style="text-align:center; width: 60px;">
                    VALOR
                </th>
                <th style="text-align:center; width: 80px;">
                    TOTAL
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($room['categories'] as $category)
                <tr>
                    <td colspan="5" style="background-color: #F4F4F4;"><strong>{{ $category['name'] }}</strong></td>
                </tr>
                @foreach ($category['products'] as $product)
                    @php
                        $total += $product['quantity'] * $product['price'] * $product['days'];
                    @endphp
                    <tr>
                        <td style="text-align:left;">{{ $product['name'] }}</td>
                        <td style="text-align:center;">
                            {{ $product['days'] }}
                        </td>
                        <td style="text-align:center;">
                            {{ $product['quantity'] }}
                        </td>
                        <td style="text-align:center;">
                            {{ number_format($product['price'], 2, ',', '.') }}
                        </td>
                        <td style="text-align:right;">
                            {{ number_format($product['quantity'] * $product['price'] * $product['days'], 2, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    <br />
    {{-- <table style="border:none;border-collapse:collapse; width: 100%;">
        <thead>
            <tr>
                <th style="text-align:left; width: 100%;">
                    MÃO DE OBRA
                </th>
                <th style="text-align:center; width: 60px;">
                    SALA
                </th>
                <th style="text-align:center; width: 60px;">
                    DIAS
                </th>
                <th style="text-align:center; width: 60px;">
                    QTD
                </th>
                <th style="text-align:center; width: 60px;">
                    VALOR
                </th>
                <th style="text-align:center; width: 80px;">
                    TOTAL
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($labors as $labor)
                @php
                    $total += $labor['quantity'] * $labor['price'] * $labor['days'];
                @endphp
                <tr>
                    <td style="text-align:left;">{{ $labor['name'] }}</td>
                    <td style="text-align:center;">
                        {{ $product['place_room_name'] }}
                    </td>
                    <td style="text-align:center;">
                        {{ $labor['days'] }}
                    </td>
                    <td style="text-align:center;">
                        {{ $labor['quantity'] }}
                    </td>
                    <td style="text-align:center;">
                        {{ number_format($labor['price'], 2, ',', '.') }}
                    </td>
                    <td style="text-align:right;">
                        {{ number_format($labor['quantity'] * $labor['price'] * $labor['days'], 2, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table> --}}
    <br />
@endforeach

<table style="border:none;border-collapse:collapse; width: 100%;">
    <tr>
        <td style="text-align:right;"><strong>SUBTOTAL</strong></td>
        <td style="text-align:right; width: 150px;"><strong>R$ {{ number_format($total, 2, ',', '.') }}</strong>
        </td>
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
                <td style="text-align:right; width: 150px;">
                    <span class="text-fee">R$ {{ number_format($totalFeePercentage, 2, ',', '.') }}</span>
                </td>
            @else
                @php
                    $totalFee = $fee;
                @endphp
                <td style="text-align:right;"><span class="text-fee">TAXA (R$
                        {{ number_format($fee, 2, ',', '.') }}):</span></td>
                <td style="text-align:right; width: 150px;">
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
                <td style="text-align:right;"><span class="text-discount">DESCONTO ({{ $discount }}%):</span>
                </td>
                <td style="text-align:right; width: 150px;">
                    <span class="text-discount">R$
                        {{ number_format($totalDiscountPercentage, 2, ',', '.') }}</span>
                </td>
            @else
                @php
                    $totalDiscount = $discount;
                @endphp
                <td style="text-align:right;"><span class="text-discount">DESCONTO (R$
                        {{ number_format($discount, 2, ',', '.') }}):</span></td>
                <td style="text-align:right; width: 150px;">
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
        <td style="text-align:right; width: 150px;">
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

@if (!empty($commercial_conditions))
    <p style="font-weight: bold;">CONDIÇÕES COMERCIAIS:</p>
    <p>{!! nl2br($commercial_conditions) !!}</p>
@endif
