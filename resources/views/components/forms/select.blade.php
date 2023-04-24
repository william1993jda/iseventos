@props(['name', 'label', 'class' => 'tom-select form-control w-full', 'options', 'selected' => null])
<div @error($name) class="has-error" @enderror>
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    {!! Form::select($name, $options, $selected, [
        'class' => $class,
        'id' => $name,
        $attributes,
    ]) !!}
    @error($name)
        <div class="pristine-error text-danger mt-2">{{ $message }}</div>
    @enderror
</div>
