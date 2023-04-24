@props(['name', 'label' => null, 'checked' => true])
<div class="mt-3">
    <div class="form-switch mt-2">
        {!! Form::checkbox($name, true, $checked, ['class' => 'form-check-input', $attributes]) !!}
        @if ($label)
            <label class="ml-2">{{ $label }}</label>
        @endif
    </div>
</div>
