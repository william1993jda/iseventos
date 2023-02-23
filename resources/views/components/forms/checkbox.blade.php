@props(['name', 'label' => null, 'checked' => true])
<div class="mt-3">
    @if ($label)
        <label>{{ $label }}</label>
    @endif
    <div class="form-switch mt-2">
        {!! Form::checkbox($name, true, $checked, ['class' => 'form-check-input', $attributes]) !!}
    </div>
</div>
