$(function() {
    tinymce.init({
        "selector":"textarea.tinymce",
        // "language":"it_IT",
        "fix_list_elements":true,
        "entity_encoding":"raw",
        "convert_urls":false,
        "height": 600,
        "max_height": 600,
        "plugins":"link autolink autoresize anchor image charmap codesample code table insertdatetime media preview searchreplace wordcount lists advlist visualblocks autosave emoticons fullscreen visualchars",
        "menubar": "file edit insert view format table tools",
        "toolbar":"undo redo | alignleft aligncenter alignright | formatselect | searchreplace | bullist numlist outdent indent | bold italic underline | link anchor image | insertdatetime table | media | codesample code | charmap restoredraft emoticons fullscreen visualchars",
        "toolbar_mode": "wrap",
        "link_list":"",
        "media_live_embeds":true,
        "noneditable_class":"non-editable",
        "insertdatetime_formats":["%d/%m/%Y","%H:%M:%S","%d/%m","%H:%M","%d/%m/%Y %H:%M:%S","%Y-%m-%d","%m-%d","%Y-%m-%d %H:%M:%S"],
        "content_css":"default,/css/tinymce-custom.css",
        "image_dimensions":true,
        "image_title:":true,
        "image_caption":true,
        "image_advtab":true,
        "image_class_list": [
            {title:"None", value:""},
            {title:"No border", value:"image-no-border"},
            {title:"Border", value:"img-with-border"}
        ],
        "skin": "oxide",
        "codesample_languages": [
            {"text": 'HTML/XML', value: 'markup'},
            {"text": 'JavaScript', value: 'javascript'},
            {"text": 'CSS', value: 'css'},
            {"text": 'PHP', value: 'php'},
            {"text": 'SQL', value: 'sql'},
            {"text": 'Python', value: 'python'},
            {"text": 'Bash', value: 'bash'}
        ],
        "rel_list": [
            {"title": "Normal Link", "value": ""},
            {"title": "External Link", "value": "external noreferrer nofollow noopener"},
            {"title": "No Referrer", "value": "noreferrer"}
        ],
        "autosave_retention":"300m",
        "style_formats":[
            {"name":"cta-1", "title":"Call to Action 1", "selector":"a", "classes":["cta", "cta-1"], "inline":"a"},

            {"name":"alert-info", "title":"Alert info", "classes":["alert", "is-info"], "block":"div", "merge_siblings":true, "exact":true, "wrapper":true},
            {"name":"alert-error", "title":"Alert danger", "classes":["alert", "is-danger"], "block":"div", "merge_siblings":true, "exact":true, "wrapper":true},
            {"name":"alert-warning", "title":"Alert warning", "classes":["alert", "is-warning"], "block":"div", "merge_siblings":true, "exact":true, "wrapper":true},
            {"name":"alert-confirm", "title":"Alert success", "classes":["alert", "is-success"], "block":"div", "merge_siblings":true, "exact":true, "wrapper":true},

            {"name":"highlighted-1", "title":"Highlighted purple", "classes":["highlighted", "highlighted-1"], "inline":"span"},
            {"name":"highlighted-2", "title":"Highlighted gray", "classes":["highlighted", "highlighted-2"], "inline":"span"},
            {"name":"highlighted-3", "title":"Highlighted black", "classes":["highlighted", "highlighted-3"], "inline":"span"},
            {"name":"highlighted-4", "title":"Highlighted orange", "classes":["highlighted", "highlighted-4"], "inline":"span"},

            {"name":"textblock-background-1", "title":"Block with purple background", "classes":["textblock", "background-color-1"], "block":"div", "merge_siblings":true, "exact":true, "wrapper":true},
            {"name":"textblock-background-2", "title":"Block with gray background", "classes":["textblock", "background-color-2"], "block":"div", "merge_siblings":true, "exact":true, "wrapper":true},
            {"name":"textblock-background-3", "title":"Block with black background", "classes":["textblock", "background-color-3"], "block":"div", "merge_siblings":true, "exact":true, "wrapper":true},
            {"name":"textblock-background-4", "title":"Block with orange background", "classes":["textblock", "background-color-4"], "block":"div", "merge_siblings":true, "exact":true, "wrapper":true},

            {"name":"textblock-code-1", "title":"Code", "classes":["code"],"block":"div"},

            {"name":"table-of-contents", "title":"Table of Contents", "classes":["table-of-contents"], "block":"div", "merge_siblings":true, "exact":true, "wrapper":true},

            {"name":"spoiler", "title":"Spoiler", "classes":["text-spoiler"], "block":"div", "merge_siblings":true, "exact":true, "wrapper":true},
        ],
        "style_formats_merge":true,
        "visualblocks_default_state":true,
        "visualchars_default_state":true,
        "end_container_on_empty_block":false,
        "extended_valid_elements":"img[class=image|src|alt=|title|width=|height=|loading=lazy]",
        "a11y_advanced_options":true
    })
    .then(editors => {
        editors.forEach(editor => {
            // console.log(editor.getContent());
        });
    })
    .catch(error => console.log(error));
});