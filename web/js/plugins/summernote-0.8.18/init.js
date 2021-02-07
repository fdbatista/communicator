$(document).ready(function() {
    $('.summernote').summernote({
        lang: 'es-MX',
        placeholder: 'Escriba su mensaje...',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert', ['link', 'picture', 'video']]
        ]
    });
});
