@props(['name', 'value' => '', 'label' => '', 'required' => false])

{{-- Load CKEditor scripts only once --}}
@once
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
@endonce

<div class="mb-4">
    @if ($label)
        <label for="{{ $name }}" class="form-label">
            {{ $label }}
            @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <textarea id="{{ $name }}" name="{{ $name }}" class="form-control">{{ $value }}</textarea>

    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (CKEDITOR.instances['{{ $name }}']) {
            CKEDITOR.instances['{{ $name }}'].destroy();
        }

        CKEDITOR.replace('{{ $name }}', {
            height: 300,
            toolbar: [
                ['Bold', 'Italic', 'Underline'],
                ['NumberedList', 'BulletedList', 'Blockquote'],
                ['Format'],
                ['Link']
            ],
            format_tags: 'p;h2;h3;h4;h5;h6',
            removePlugins: 'elementspath,resize,image,table,horizontalrule,pagebreak,iframe,flash,about,specialchar,scayt,wsc',
            contentsCss: ['https://cdn.ckeditor.com/4.22.1/standard/contents.css'],
            allowedContent: true,
            enterMode: CKEDITOR.ENTER_P,
            forcePasteAsPlainText: true,
            basicEntities: true,
            entities: true,
            removeDialogTabs: 'link:advanced;link:target',
            contentsClass: 'rounded',
            versionCheck: false,
        });
    });
</script>
