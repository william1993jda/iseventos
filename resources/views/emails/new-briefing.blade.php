<div>
    <p><strong>NOME:</strong> {{ $briefing->name }}</p>
    <p><strong>LOCAL:</strong> {{ $briefing->local }}</p>
    <p><strong>TIPO DE EVENTO:</strong> {{ $briefing->getEventType() }}</p>
    <p><strong>EMPRESA:</strong> {{ $briefing->company }}</p>
</div>
