@props(['name', 'label' => null, 'value' => null, 'class' => 'form-control w-full'])
<div @error($name) class="has-error" @enderror>
    @if (!empty($label))
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif
    {!! Form::textarea($name, $value, [
        'class' => $class,
        'id' => $name,
        $attributes,
    ]) !!}
    @error($name)
        <div class="pristine-error text-danger mt-2">{{ $message }}</div>
    @enderror
</div>
