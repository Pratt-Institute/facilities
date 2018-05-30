<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Facilities */

$this->title = 'Update Facilities: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Facilities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<style>

div.form-group {
	width: 300px !important;
	float: left !important;
	margin-right: 35px !important;
}

</style>


<div class="facilities-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
