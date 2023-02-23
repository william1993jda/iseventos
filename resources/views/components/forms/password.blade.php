@props(['type' => 'password', 'name', 'label', 'class' => 'sm:col-span-3', 'required' => false])
<div class="{{ $class }}">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
    </label>
    <div class="mt-1">
        {!! Form::$type($name, ['class' => 'form-input', 'required' => $required, 'id' => $name, $attributes]) !!}
    </div>
    @error($name)
        <div class="form-error">
            {{ $message }}
        </div>
    @enderror
</div>
