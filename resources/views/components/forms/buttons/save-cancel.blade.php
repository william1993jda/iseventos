@props(['showMode', 'model'])
@if (!$showMode)
    <div class="text-right mt-5">
        @if (empty($model->id))
            <button type="reset" class="btn btn-outline-secondary w-24 mr-1">Limpar</button>
        @endif
        <button type="submit" class="btn btn-primary w-24">Salvar</button>
    </div>
@else
    <style>
        /* select[readonly].select2-hidden-accessible+.select2-container {
                pointer-events: none;
                touch-action: none;
            }

            select[readonly].select2-hidden-accessible+.select2-container .select2-selection {
                background: #eee;
                box-shadow: none;
            }

            select[readonly].select2-hidden-accessible+.select2-container .select2-selection__arrow,
            select[readonly].select2-hidden-accessible+.select2-container .select2-selection__clear {
                display: none;
            } */
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.form-action-buttons').forEach(function(element) {
                element.style.display = 'none';
            });
            document.querySelectorAll('input').forEach(function(input) {
                input.setAttribute('readonly', true);
            });
            document.querySelectorAll('textarea').forEach(function(input) {
                input.setAttribute('readonly', true);
            });
            document.querySelectorAll('select').forEach(function(select) {
                select.setAttribute('readonly', true);
            });
            document.querySelectorAll('.tom-select').forEach(function(select) {
                if (select.tomselect) {
                    select.tomselect.disable();
                }
            });
        });
    </script>
@endif
