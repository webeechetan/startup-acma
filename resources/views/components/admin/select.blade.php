@props(['id', 'name', 'options' => [], 'selected' => [], 'config' => [], 'class' => ''])

<select id="{{ $id }}" name="{{ $name }}{{ $config['multiple'] ?? false ? '[]' : '' }}"
    class="{{ $class }}" {{ $config['multiple'] ?? false ? 'multiple' : '' }}
    {{ $config['required'] ?? false ? 'required' : '' }}>

    @if (($config['selectAll'] ?? false) && count($options) > 0)
        <option value="select_all">Select All</option>
    @endif

    @foreach ($options as $value => $label)
        <option value="{{ $value }}" @selected(in_array($value, (array) $selected))>
            {{ $label }}
        </option>
    @endforeach
</select>

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            let selectElement = $('#{{ $id }}');

            // Initialize Select2 with the provided config
            selectElement.select2(@json($config));

            // Handle "Select All" functionality
            selectElement.on('select2:select', function(e) {
                if (e.params.data.id === "select_all") {
                    let allValues = selectElement.find('option[value!="select_all"]').map(function() {
                        return $(this).val();
                    }).get();

                    selectElement.val(allValues).trigger('change');
                }
            });

            // Handle "Deselect All" when all options are selected
            selectElement.on('select2:unselect', function(e) {
                if (e.params.data.id === "select_all") {
                    selectElement.val(null).trigger('change');
                }
            });
        });
    </script>
@endpush
