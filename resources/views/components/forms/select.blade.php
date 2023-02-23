@props(['name', 'label', 'class' => 'tom-select form-control w-full', 'options'])
<div @error($name) class="has-error" @enderror>
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    {!! Form::select($name, $options, null, [
        'class' => $class,
        'id' => $name,
        $attributes,
    ]) !!}
    @error($name)
        <div class="pristine-error text-danger mt-2">{{ $message }}</div>
    @enderror
</div>
