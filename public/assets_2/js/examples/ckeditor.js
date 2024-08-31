'use strict';
$(document).ready(function () {

    if($('#editor-demo1').length) {
        CKEDITOR.replace('editor-demo1');
    }

    if($('#editor-demo2').length) {
        CKEDITOR.replace('editor-demo2', {
            // Define the toolbar groups as it is a more accessible solution.
            toolbarGroups: [{
                "name": "basicstyles",
                "groups": ["basicstyles"]
            },
                {
                    "name": "links",
                    "groups": ["links"]
                },
                {
                    "name": "paragraph",
                    "groups": ["list", "blocks"]
                },
                {
                    "name": "insert",
                    "groups": ["insert"]
                }
            ],
            // Remove the redundant buttons from toolbar groups defined above.
            removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
        });
    }

    if($('#editor-demo3').length) {
        CKEDITOR.replace('editor-demo3', {
            uiColor: '#CCEAEE'
        });
    }

    if($('#email-compose-editor').length) {
        CKEDITOR.replace('email-compose-editor', {
            toolbarGroups: [{
                "name": "basicstyles",
                "groups": ["basicstyles"]
            },
                {
                    "name": "links",
                    "groups": ["links"]
                },
                {
                    "name": "paragraph",
                    "groups": ["list", "blocks"]
                },
                {
                    "name": "insert",
                    "groups": ["insert"]
                }
            ],
            removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
        });
    }

});

if($('#editor-demo4').length) {
    CKEDITOR.disableAutoInline = true;
    CKEDITOR.inline('editor-demo4');
}

if($('#editor-demo5').length) {
    CKEDITOR.disableAutoInline = true;
    CKEDITOR.inline('editor-demo5');
}

if($('#editor-demo6').length) {
    CKEDITOR.disableAutoInline = true;
    CKEDITOR.inline('editor-demo6');
}