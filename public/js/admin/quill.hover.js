document.addEventListener('orchid:quill', (event) => {

    //let quill = event.detail.quill;
    let quill = event.target;
    //alert(quill);
    alert(event.target)

    document.ready(function() { alert("loaded") });

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
        'strike': 'Strike'
    };

    let toolbarElement = document.querySelector('.ql-toolbar');
    if (toolbarElement) {
        let matches = toolbarElement.querySelectorAll('button');
        for (let el of matches) {
            showTooltip(el);
        }
    }
})