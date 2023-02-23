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
            <td style="text-align:center;">
                <img src="{{ public_path('assets/admin/images/logo-horizontal.png') }}" width="300">
            </td>
        </tr>
    </tbody>
</table>

<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:left;">
                Nome do Evento
            </th>
            <th style="text-align:left;">
                Tipo de Evento
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                {{ $name }}
            </td>
            <td>
                {{ $event_type }}
            </td>
        </tr>
    </tbody>
</table>

<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:left;">
                Local do Evento
            </th>
            <th style="text-align:left;">
                Salas
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                {{ $place }}
            </td>
            <td>
                {{ $rooms }}
            </td>
        </tr>
    </tbody>
</table>

<br />

<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:center; background-color: #FFF;" colspan="2">
                Montagem
            </th>
            <th style="text-align:center; background-color: #FFF;" colspan="2">
                Ensaio
            </th>
            <th style="text-align:center; background-color: #FFF;" colspan="2">
                Evento
            </th>
        </tr>
    </thead>
    <thead>
        <tr>
            <th style="text-align:center;">
                Início
            </th>
            <th style="text-align:center;">
                Fim
            </th>
            <th style="text-align:center;">
                Início
            </th>
            <th style="text-align:center;">
                Fim
            </th>
            <th style="text-align:center;">
                Início
            </th>
            <th style="text-align:center;">
                Fim
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align:center;">
                {{ $mounting_start }}
            </td>
            <td style="text-align:center;">
                {{ $mounting_end }}
            </td>
            <td style="text-align:center;">
                {{ $assay_start }}
            </td>
            <td style="text-align:center;">
                {{ $assay_end }}
            </td>
            <td style="text-align:center;">
                {{ $event_start }}
            </td>
            <td style="text-align:center;">
                {{ $event_end }}
            </td>
        </tr>
    </tbody>
</table>
<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:left;">
                Qtd Convidados
            </th>
            <th style="text-align:left;">
                Qtd Staff
            </th>
            <th style="text-align:left;">
                Formato do Evento
            </th>
            <th style="text-align:left;">
                BU
            </th>
            <th style="text-align:left;">
                Head do Evento
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                {{ $guests }}
            </td>
            <td>
                {{ $staff }}
            </td>
            <td>
                {{ $event_format }}
            </td>
            <td>
                {{ $bu }}
            </td>
            <td>
                {{ $event_head }}
            </td>
        </tr>
    </tbody>
</table>

<br />

<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:center; background-color: #FFF;" colspan="6">
                Agência
            </th>
        </tr>
    </thead>
    <thead>
        <tr>
            <th style="text-align:left;">
                Nome
            </th>
            <th style="text-align:left;">
                Contato
            </th>
            <th style="text-align:left;">
                Telefone
            </th>
            <th style="text-align:left;">
                E-mail
            </th>
            <th style="text-align:left;">
                Produção
            </th>
            <th style="text-align:left;">
                Criação
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                {{ $agency_name }}
            </td>
            <td>
                {{ $agency_contact }}
            </td>
            <td>
                {{ $agency_phone }}
            </td>
            <td>
                {{ $agency_email }}
            </td>
            <td>
                {{ $agency_production }}
            </td>
            <td>
                {{ $agency_creation }}
            </td>
        </tr>
    </tbody>
</table>

<br />

{{-- <table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:center; background-color: #FFF;" colspan="6">
                BCD
            </th>
        </tr>
    </thead>
</table>
<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:left;">
                Contato
            </th>
            <th style="text-align:left;">
                Telefone
            </th>
            <th style="text-align:left;">
                E-mail
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                {{ $bcd_contact }}
            </td>
            <td>
                {{ $bcd_phone }}
            </td>
            <td>
                {{ $bcd_email }}
            </td>
        </tr>
    </tbody>
</table>

<br /> --}}

<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:left;">
                Alimentação
            </th>
            <th style="text-align:left;">
                Hospedagem
            </th>
            <th style="text-align:left;">
                Estacionamento
            </th>
            <th style="text-align:left;">
                Participantes Simultaneos no Palco
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                {{ $food }}
            </td>
            <td>
                {{ $hosting }}
            </td>
            <td>
                {{ $parking }}
            </td>
            <td>
                {{ $simultaneous_people }}
            </td>
        </tr>
    </tbody>
</table>
<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:left;">
                Formato da Sala
            </th>
            <th style="text-align:left;">
                Outros
            </th>
            <th style="text-align:left;">
                Pulpito
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                {{ $room_format }}
            </td>
            <td>
                {{ $room_format_others }}
            </td>
            <td>
                {{ $pulpit }}
            </td>
        </tr>
    </tbody>
</table>

<br />

<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:center; background-color: #FFF;" colspan="5">
                Mobiliário
            </th>
        </tr>
    </thead>
    <thead>
        <tr>
            <th style="text-align:left;">
                Poltrona
            </th>
            <th style="text-align:left;">
                Lounge
            </th>
            <th style="text-align:left;">
                Mesinha
            </th>
            <th style="text-align:left;">
                Palco
            </th>
            <th style="text-align:left;">
                Tela
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                {{ $armchair_forniture }}
            </td>
            <td>
                {{ $armchair_lounge }}
            </td>
            <td>
                {{ $armchair_table }}
            </td>
            <td>
                {{ $stage }}
            </td>
            <td>
                {{ $screen }}
            </td>
        </tr>
    </tbody>
</table>

<br />

<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:center; background-color: #FFF;" colspan="2">
                Flip Chart
            </th>
            <th style="text-align:center; background-color: #FFF;" colspan="2">
                Totem
            </th>
            <th style="text-align:center; background-color: #FFF;" colspan="2">
                Rádio
            </th>
        </tr>
    </thead>
    <thead>
        <tr>
            <th style="text-align:left;">
                Tipo
            </th>
            <th style="text-align:left;">
                Quantidade
            </th>
            <th style="text-align:left;">
                Tipo
            </th>
            <th style="text-align:left;">
                Quantidade
            </th>
            <th style="text-align:left;">
                Rádios
            </th>
            <th style="text-align:left;">
                Quantidade
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                {{ $flip_chart }}
            </td>
            <td>
                {{ $flip_chart_quantity }}
            </td>
            <td>
                {{ $totem }}
            </td>
            <td>
                {{ $totem_quantity }}
            </td>
            <td>
                {{ $radios }}
            </td>
            <td>
                {{ $radios_quantity }}
            </td>
        </tr>
    </tbody>
</table>

<br />

<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:center; background-color: #FFF;">
                Sistema
            </th>
            <th style="text-align:center; background-color: #FFF;" colspan="2">
                Recepcionista
            </th>
            <th style="text-align:center; background-color: #FFF;">
                Balcão
            </th>
            <th style="text-align:center; background-color: #FFF;">
                Backdroop
            </th>
        </tr>
    </thead>
    <thead>
        <tr>
            <th style="text-align:center;">
                Credenciamento
            </th>
            <th style="text-align:left;">
                Credenciamento
            </th>
            <th style="text-align:left;">
                Sala
            </th>
            <th style="text-align:center;">
                Credenciamento
            </th>
            <th style="text-align:center;">
                Credenciamento
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                {{ $accreditation }}
            </td>
            <td>
                {{ $receptionist_accreditation }}
            </td>
            <td>
                {{ $receptionist_room }}
            </td>
            <td>
                {{ $accreditation_desk }}
            </td>
            <td>
                {{ $accreditation_backdroop }}
            </td>
        </tr>
    </tbody>
</table>

<br />

<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:center; background-color: #FFF;" colspan="2">
                Paisagismo
            </th>
            <th style="text-align:center; background-color: #FFF;" colspan="2">
                Decoração Mesas de Jantar
            </th>
        </tr>
    </thead>
    <thead>
        <tr>
            <th style="text-align:left;">
                Mosso
            </th>
            <th style="text-align:left;">
                Areca
            </th>
            <th style="text-align:left;">
                Referencia
            </th>
            <th style="text-align:left;">
                Quantidade
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                {{ $landscaping_mosso }}
            </td>
            <td>
                {{ $landscaping_areca }}
            </td>
            <td>
                {{ $decoration_table_reference }}
            </td>
            <td>
                {{ $decoration_table_quantity }}
            </td>
    </tbody>
</table>

<br />

<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:center; background-color: #FFF;" colspan="6">
                Iluminação
            </th>
        </tr>
    </thead>
</table>
<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:left;">
                Paredes da Sala
            </th>
            <th style="text-align:left;">
                Foyer
            </th>
            <th style="text-align:left;">
                Restaurante
            </th>
            <th style="text-align:left;">
                Palco
            </th>
            <th style="text-align:left;">
                Efeitos
            </th>
            <th style="text-align:left;">
                Lona
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                {{ $lighting_walls }}
            </td>
            <td>
                {{ $lighting_foyer }}
            </td>
            <td>
                {{ $lighting_restaurant }}
            </td>
            <td>
                {{ $lighting_stage }}
            </td>
            <td>
                {{ $lighting_effects }}
            </td>
            <td>
                {{ $lighting_led_canvas }}
            </td>
        </tr>
    </tbody>
</table>

<br />

<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:center; background-color: #FFF;" colspan="6">
                Sonorização
            </th>
        </tr>
    </thead>
</table>
<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:left;">
                Sala
            </th>
            <th style="text-align:left;">
                Foyer
            </th>
            <th style="text-align:left;">
                Restaurante
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                {{ $sound_room }}
            </td>
            <td>
                {{ $sound_foyer }}
            </td>
            <td>
                {{ $sound_restaurant }}
            </td>
        </tr>
    </tbody>
</table>

<br />
<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:center; background-color: #FFF;" colspan="2">
                Tradução
            </th>
            <th style="text-align:center; background-color: #FFF;" colspan="3">
                Idioma
            </th>
        </tr>
    </thead>
    <thead>
        <tr>
            <th style="text-align:left;">
                Remoto
            </th>
            <th style="text-align:left;">
                Presencial
            </th>
            <th style="text-align:left;">
                Português
            </th>
            <th style="text-align:left;">
                Inglês
            </th>
            <th style="text-align:left;">
                Espanhol
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                {{ $translation_remote }}
            </td>
            <td>
                {{ $translation_presential }}
            </td>
            <td>
                {{ $translation_language_pt }}
            </td>
            <td>
                {{ $translation_language_en }}
            </td>
            <td>
                {{ $translation_language_es }}
            </td>
        </tr>
    </tbody>
</table>

<br />

<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:center;">
                Libras
            </th>
            <th style="text-align:center;">
                Transcrição
            </th>
            <th style="text-align:center;">
                DJ
            </th>
            <th style="text-align:center;">
                Sonoplastia
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                {{ $pounds }}
            </td>
            <td>
                {{ $transcription }}
            </td>
            <td>
                {{ $dj_name }} - {{ $dj_date }}
            </td>
            <td>
                {{ $sonoplast_name }}
            </td>
        </tr>
    </tbody>
</table>
<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:left;">
                Gerador
            </th>
            <th style="text-align:left;">
                Internet
            </th>
            <th style="text-align:left;">
                Captação e Corte
            </th>
            <th style="text-align:left;">
                Quantidade
            </th>
            <th style="text-align:left;">
                Transmissão Simultanea
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                {{ $generator }}
            </td>
            <td>
                {{ $internet }}
            </td>
            <td>
                {{ $capture_and_cut }}
            </td>
            <td>
                {{ $capture_and_cut_quantity }}
            </td>
            <td>
                {{ $simulcast }}
            </td>
    </tbody>
</table>
<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:CENTER;">
                Plataforma de Transmissão
            </th>
        </tr>
    </thead>
</table>
<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:left;">
                ZOOM MEETING
            </th>
            <th style="text-align:left;">
                Link
            </th>
            <th style="text-align:left;">
                ZOOM+(MET E WEB)
            </th>
            <th style="text-align:left;">
                Link
            </th>
            <th style="text-align:left;">
                ZOOM WEBINAR
            </th>
            <th style="text-align:left;">
                SITE
            </th>
            <th style="text-align:left;">
                INSTAGRAM
            </th>
            <th style="text-align:left;">
                FACEBOOK
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                {{ $zoom_meeting }}
            </td>
            <td>
                {{ $zoom_meeting_link }}
            </td>
            <td>
                {{ $zoom_meeting_plus }}
            </td>
            <td>
                {{ $zoom_meeting_plus_link }}
            </td>
            <td>
                {{ $zoom_webinar }}
            </td>
            <td>
                {{ $site }}
            </td>
            <td>
                {{ $instagram }}
            </td>
            <td>
                {{ $facebook }}
            </td>
    </tbody>
</table>
<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:left;">
                Edição
            </th>
            <th style="text-align:left;">
                Speaker Remoto
            </th>
            <th style="text-align:left;">
                Teleprompter
            </th>
            <th style="text-align:left;">
                Impressora
            </th>
            <th style="text-align:left;">
                Ipad (Perguntas Remotas)
            </th>
            <th style="text-align:left;">
                Biombos (1 á 100)
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                {{ $edition }}
            </td>
            <td>
                {{ $remote_speaker }}
            </td>
            <td>
                {{ $telepronter }}
            </td>
            <td>
                {{ $printer }}
            </td>
            <td>
                {{ $ipad }}
            </td>
            <td>
                {{ $folding_screen }}
            </td>
    </tbody>
</table>
<table style="border:none;border-collapse:collapse; width: 100%;">
    <thead>
        <tr>
            <th style="text-align:left;">
                Direção Artistica
            </th>
            <th style="text-align:left;">
                Roteiro
            </th>
            <th style="text-align:left;">
                Happy Hour
            </th>
            <th style="text-align:left;">
                Grua
            </th>
            <th style="text-align:left;">
                Fotógrafo
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                {{ $direction_artistic }}
            </td>
            <td>
                {{ $script }}
            </td>
            <td>
                {{ $happy_hour_place }}
            </td>
            <td>
                {{ $crane }}
            </td>
            <td>
                {{ $photographer }}
            </td>
    </tbody>
</table>

<br />
