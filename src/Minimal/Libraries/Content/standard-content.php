<?
    $title = isset($title) ? $title : '';
    $text = isset($text) ? $text : '';
?>
<?=$this->getEditTopBar()?>
<h2><?=$title?></h2>
<p><?=$text?></p>
<?= $this->getEditBottomBar() ?>
