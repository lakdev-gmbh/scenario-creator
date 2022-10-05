document.addEventListener("turbo:load", () => {

    // based on https://github.com/quilljs/quill/issues/650

    let showTooltip = (el) => {
        let tool = el.className.replace('ql-', '');
        if (tooltips[tool]) {
            console.log(tooltips[tool]);
            $(el).attr("title", tooltips[tool]);
        }
    };

    let tooltips = {
        'bold': 'Bold (ctrl+B)',
        'italic': 'Italic (ctrl+I)',
        'underline': 'Underline (ctrl+U)',
        'strike': 'Strike',
        'link': 'Link',
        'clean': 'Clean',
        'color ql-picker ql-color-picker': 'Font color',
        'background ql-picker ql-color-picker': 'Background color',
        'blockquote': 'Quote',
        'code-block': 'Code',
        'header': 'Header',
        'list': 'List',
        'indent': 'Indent',
        'align ql-picker ql-icon-picker': 'Align',
        'image': 'Image',
        'video': 'Video'
    };

    let toolbarElement = document.querySelector('.ql-toolbar');
    if (toolbarElement) {
        let matches = toolbarElement.querySelectorAll('button');
        for (let element of matches) {
            showTooltip(element);
        }
        let spans = toolbarElement.querySelectorAll('span');
        for (let element of spans) {
            showTooltip(element);
        }
    }
});