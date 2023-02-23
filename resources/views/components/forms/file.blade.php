@props(['name', 'label', 'class' => 'form-control w-full'])
<div @error($name) class="has-error" @enderror>
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    {!! Form::file($name, null, [
        'class' => $class,
        'id' => $name,
        $attributes,
    ]) !!}
    @error($name)
        <div class="pristine-error text-danger mt-2">{{ $message }}</div>
    @enderror
</div>
