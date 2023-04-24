@props(['name', 'label', 'class' => 'form-control w-full'])
<div @error($name) class="has-error" @enderror>
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    {!! Form::text($name, null, [
        'class' => $class,
        'id' => $name,
        'onkeyup' => 'convertToCurrency(this)',
        $attributes,
    ]) !!}
    @error($name)
        <div class="pristine-error text-danger mt-2">{{ $message }}</div>
    @enderror
</div>

<script>
    function convertToCurrency(input) {
        var value = input.value;
        value = value.replace(/\D/g, "");

        if (value.length > 2) {
            value = value.replace(/(\d)(\d{8})$/, "$1.$2");
            value = value.replace(/(\d)(\d{5})$/, "$1.$2");
            value = value.replace(/(\d)(\d{2})$/, "$1,$2");
        }

        input.value = value;
    }
</script>
