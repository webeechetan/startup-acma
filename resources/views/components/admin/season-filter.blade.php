<x-admin.select id="season-select" name="season_id" :options="$seasons" :selected="$selectedSeason" :config="[
    'placeholder' => 'Select Season',
]"
    class="w-px-200" />

@push('scripts')
    <script defer>
        document.addEventListener('DOMContentLoaded', () => {
            let selectElement = $('#season-select');

            if (selectElement.data('select2')) {
                selectElement.select2('destroy');
            }
            selectElement.select2();

            selectElement.on('select2:select', function(e) {
                const seasonId = e.params.data.id;
                const url = new URL(window.location.href);
                url.searchParams.set('season_id', seasonId);
                window.location.href = url.toString();
            });
        });
    </script>
@endpush
