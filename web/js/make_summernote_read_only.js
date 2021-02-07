$('document').ready(function () {
    makeSummerNoteReadOnly();
});

function makeSummerNoteReadOnly() {
    setTimeout(function () {
        let summernoteDiv = $('.note-editable');

        summernoteDiv.attr('contenteditable', false);

        summernoteDiv.css({
            'background-color': 'white'
        });
    }, 250);
}
