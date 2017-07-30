<?
    $elements = isset($elements) ? $elements : [];
    $currentUri = isset($currentUri) ? $currentUri : $_SERVER['REQUEST_URI'];
    $i = 0;
?>
<? foreach ($elements as $element) : ?>
    <?= ($i > 0) ? '<hr>' : ''; $i++ ?>
    <div class="form-check">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" name="element"
                   value="<?= $element['name']?>">
            <h5><?= $element['label']?></h5>
            <p><?= $element['description'] ?></p>
        </label>
    </div>
    <!--suppress HtmlUnknownTarget -->
    <form method="post" action="/contents">
        <div class="form-group">
            <!--suppress HtmlFormInputWithoutLabel -->
            <input class="form-control" type="text" name="page[name]" value="<?=$currentUri?>">
        </div>
        <div class="form-group">
            <!--suppress HtmlFormInputWithoutLabel -->
            <input class="form-control" type="text" name="area[name]"
                   value="<?= /** @noinspection PhpUndefinedVariableInspection */
                   $areaName ?>">
        </div>
        <div class="form-group">
            <!--suppress HtmlFormInputWithoutLabel -->
            <input class="form-control" type="text" name="element[name]"
                   value="<?= $element['name'] ?>">
        </div>
        <div class="form-group">
            <label>Title</label>
            <!--suppress HtmlFormInputWithoutLabel -->
            <input class="form-control" type="text" name="content[title]" value="">
        </div>
        <div class="form-group">
            <label>Text</label>
            <!--suppress HtmlFormInputWithoutLabel -->
            <input class="form-control" type="text" name="content[text]" value="">
        </div>
        <button type="submit">Save</button>
    </form>
<? endforeach ?>