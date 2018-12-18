<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Appinstalacao */

$this->title = 'Create Appinstalacao';
$this->params['breadcrumbs'][] = ['label' => 'Appinstalacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appinstalacao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
