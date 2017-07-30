<style>
    .minimal-content-area .minimal {
        margin: 0;
        padding: 0;
    }

    /*noinspection CssUnusedSymbol*/
    .minimal-content-area .minimal.clear:after {
        content: "";
        display: block;
        clear: both;

    }

    /*noinspection CssUnusedSymbol,CssUnusedSymbol,CssUnusedSymbol,CssUnusedSymbol*/
    .minimal-content-area .minimal.area-top-bar,
    .minimal-content-area .minimal.edit-top-bar,
    .minimal-content-area .minimal.area-bottom-bar,
    .minimal-content-area .minimal.edit-bottom-bar {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        height: 25px;
        line-height: 21px;
        background: #6B8E23;
        padding: 1px 8px;
        border: 1px solid #7ea426;
        border-right: 1px solid #637a33;
        border-bottom: 1px solid #637a33;
        border-radius: 2px;
        font-family: monospace;
        font-size: 13px;
        color: white;
    }

    /*noinspection CssUnusedSymbol,CssUnusedSymbol*/
    .minimal-content-area .minimal.edit-top-bar,
    .minimal-content-area .minimal.edit-bottom-bar {
        background: #939b25;
        border-color: #a0a826;
        border-right-color: #7e8624;
        border-bottom-color: #7e8624;
    }

    /*noinspection CssUnusedSymbol,CssUnusedSymbol*/
    .minimal-content-area .minimal.area-top-bar,
    .minimal-content-area .minimal.edit-top-bar {
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    /*noinspection CssUnusedSymbol,CssUnusedSymbol*/
    .minimal-content-area .minimal.area-bottom-bar,
    .minimal-content-area .minimal.edit-bottom-bar {
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
        text-align: right;
    }

    /*noinspection CssOverwrittenProperties,CssOverwrittenProperties*/
    .minimal-content-area .minimal button {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        border: none;
        background: #789c24;
        cursor: pointer;
        height: 19px;
        line-height: 10px;
        margin-top: 1px;
        padding: 4px 5px;
        border: 1px solid #7ea426;
        border-right: 1px solid #637a33;
        border-bottom: 1px solid #637a33;
        border-radius: 3px;
        font-family: monospace;
        font-size: 13px;
        color: white;
    }

    .minimal-content-area .minimal button:focus {
        outline: 0;
    }

    /*noinspection CssUnusedSymbol*/
    .minimal-content-area .form-check-label {
        padding-left: 1.75rem;
    }

    /*noinspection CssUnusedSymbol*/
    .minimal-content-area  .form-check-input {
        margin-left: -1.75rem;
    }

    /*noinspection CssUnusedSymbol*/
    .minimal-content-area .edit-top-bar .title {
        float: left;
    }

    /*noinspection CssUnusedSymbol*/
    .minimal-content-area .edit-top-bar .controls {
        float: right;
    }

</style>
<?php
    $content = isset($content) ? $content : null;
    $modal = isset($modal) ? $modal : null;
?>
<div class="minimal-content-area">
    <?= $content ?>
    <?= $modal ?>
</div>