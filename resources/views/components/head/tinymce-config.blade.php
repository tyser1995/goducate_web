<script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script>


const desc_notes = {
    selector: 'div#desc_notes',
    menubar: false,
    /*inline: true,*/
    toolbar_sticky: true,
    fixed_toolbar_container:'div#desc_notes_container',
    plugins: [
        'link', 'lists', 'autolink',
    ],
    toolbar: [
        'undo redo alignleft aligncenter alignright alignjustify bold underline italic bullist numlist forecolor link'
    ],
    valid_elements: 'p[style],strong,em,span[style],a[href],ul,ol,li',
    valid_styles: {
        '*': 'font-size,font-family,color,text-decoration,text-align'
    },
    browser_spellcheck: true,
    contextmenu: 'link useBrowserSpellcheck image table',
};

tinymce.init(desc_notes);

</script>
