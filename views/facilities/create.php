<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Facilities */

$this->title = 'Create Facilities';
$this->params['breadcrumbs'][] = ['label' => 'Facilities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="facilities-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
