@props(['name', 'label', 'class' => 'form-control w-full', 'mask' => null])
<div @error($name) class="has-error" @enderror>
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    {!! Form::text($name, null, [
        'class' => $class,
        'id' => $name,
        'x-mask:dynamic' => $mask ?? null,
        $attributes,
    ]) !!}
    @error($name)
        <div class="pristine-error text-danger mt-2">{{ $message }}</div>
    @enderror
</div>
