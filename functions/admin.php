<?php

add_action('admin_head', function () {
    echo '<style>
    .dn{display:none!important;}
    .block-editor-block-list__block[data-type^="acf/"]::before{
        content:attr(data-title);
        position:relative;
        display:block;
        font-size:20px;
        font-weight:700;
        max-width:1050px;
        margin:0 auto 16px;
        line-height:1;
    }
    .block-editor-block-list__block[data-type^="acf/"] .acf-block-component{
        max-width:1050px;
        margin:0 auto;
    }
    </style>';
});

