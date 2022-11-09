rules = [
    {
        "lvl":"error",
        "reg":r".*custom-control-indicator.*",
        "msg":"removed .custom-control-indicator,Now, we have .custom-control-label::before for the fill and gradient and .custom-control-label::after handles the icon. link: https://getbootstrap.com/docs/4.0/migration/#forms"
    },
    {
        "lvl":"warn",
        "reg":r'.*data-toggle="buttons".*',
        "msg":'Instead of [data-toggle="buttons"] { } for style and behavior, we use the data attribute just for JS behaviors and rely on a new .btn-group-toggle class for styling. link: https://getbootstrap.com/docs/4.0/migration/#forms'
    },
    {
        "lvl":"error",
        "reg":r'.*col-form-legend.*',
        "msg":"Removed .col-form-legend in favor of a slightly improved .col-form-label. This way .col-form-label-sm and .col-form-label-lg can be used on <legend> elements with ease. link: https://getbootstrap.com/docs/4.0/migration/#forms"
    },
    {
        "lvl":"error",
        "reg":r'input-group-addon|input-group-btn',
        "msg":'Input group addons are now specific to their placement relative to an input. We’ve dropped .input-group-addon and .input-group-btn for two new classes, .input-group-prepend and .input-group-append. You must explicitly use an append or a prepend now, simplifying much of our CSS. Within an append or prepend, place your buttons as they would exist anywhere else, but wrap text in .input-group-text. link: https://getbootstrap.com/docs/4.0/migration/#input-groups'
    },
    {
        "lvl":"warn",
        "reg":'input-group',
        "msg":'Sizing classes must be on the parent .input-group and not the individual form elements.'
    },
]