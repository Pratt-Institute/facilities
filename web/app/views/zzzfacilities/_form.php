<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Facilities */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="facilities-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bldg_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'owned_leased')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bldg_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bldg_abbre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'floor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'room_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'new_room_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'line')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'station_count')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sf')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sf_fte')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'space_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'room_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'donor_space')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'av')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ceiling_hgt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'department')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'space')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'proration')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'calcuated_sf')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'function_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'major_category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'functional_category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'functional_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'on_off_campus')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
