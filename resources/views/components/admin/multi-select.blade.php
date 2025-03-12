@props([
    'id',
    'name',
    'options' => [],
    'selected' => [],
    'config' => [],
    'class' => 'w-100',
    'multiple' => true,
    'selectAll' => true,
    'required' => false,
])

<select id="{{ $id }}" name="{{ $name }}{{ $multiple ? '[]' : '' }}" {{ $multiple ? 'multiple' : '' }}
    class="{{ $class }}" {{ $required ? 'required' : '' }}>

    @if ($selectAll)
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
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            let selectElement = $('#{{ $id }}');

            // Initialize Select2
            selectElement.select2(@json($config));

            // Handle "Select All" functionality
            selectElement.on('select2:select', function(e) {
                let selectedValue = e.params.data.id;

                if (selectedValue === "select_all") {
                    // Select all options except "Select All"
                    let allValues = selectElement.find('option[value!="select_all"]').map(function() {
                        return $(this).val();
                    }).get();

                    selectElement.val(allValues).trigger('change');
                }
            });
        });
    </script>
@endpush
