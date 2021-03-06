<?php

/* @var $this BgController */
/* @var $model Bg */
$this->layout = NULL;
?>

<?php

$this->breadcrumbs = array(
    'Bgs' => array('index'),
    'Create',
);

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-list', 'label' => 'List Bg', 'url' => array('index')),
    array('icon' => 'glyphicon glyphicon-tasks', 'label' => 'Manage Bg', 'url' => array('admin')),
);
?>

<?php echo BsHtml::pageHeader('Create', 'Bg') ?>

<?php $this->renderPartial('_form', array('model' => $model)); ?>