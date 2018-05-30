<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FacilitiesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="facilities-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'bldg_code') ?>

    <?= $form->field($model, 'owned_leased') ?>

    <?= $form->field($model, 'bldg_name') ?>

    <?= $form->field($model, 'bldg_abbre') ?>

    <?php // echo $form->field($model, 'floor') ?>

    <?php // echo $form->field($model, 'room_no') ?>

    <?php // echo $form->field($model, 'new_room_no') ?>

    <?php // echo $form->field($model, 'line') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'station_count') ?>

    <?php // echo $form->field($model, 'sf') ?>

    <?php // echo $form->field($model, 'sf_fte') ?>

    <?php // echo $form->field($model, 'space_type') ?>

    <?php // echo $form->field($model, 'room_name') ?>

    <?php // echo $form->field($model, 'donor_space') ?>

    <?php // echo $form->field($model, 'av') ?>

    <?php // echo $form->field($model, 'ceiling_hgt') ?>

    <?php // echo $form->field($model, 'department') ?>

    <?php // echo $form->field($model, 'space') ?>

    <?php // echo $form->field($model, 'time') ?>

    <?php // echo $form->field($model, 'proration') ?>

    <?php // echo $form->field($model, 'calcuated_sf') ?>

    <?php // echo $form->field($model, 'function_code') ?>

    <?php // echo $form->field($model, 'major_category') ?>

    <?php // echo $form->field($model, 'functional_category') ?>

    <?php // echo $form->field($model, 'functional_title') ?>

    <?php // echo $form->field($model, 'on_off_campus') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
