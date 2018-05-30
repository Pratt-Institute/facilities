<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\Autocomplete;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\Facilities */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="facilities-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    	echo $form->field($model, 'bldg_code')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'bldg_code']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term)!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?= $form->field($model, 'owned_leased')->textInput(['maxlength' => true]) ?>

    <?php
    	echo $form->field($model, 'bldg_name')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'bldg_name']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?php
    	echo $form->field($model, 'bldg_abbre')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'bldg_abbre']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?php
    	echo $form->field($model, 'floor')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'floor']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?php
    	echo $form->field($model, 'room_no')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'room_no']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?php
    	echo $form->field($model, 'new_room_no')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'new_room_no']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?php
    	echo $form->field($model, 'line')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'line']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?php
    	echo $form->field($model, 'status')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'status']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?php
    	echo $form->field($model, 'station_count')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'station_count']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?php
    	echo $form->field($model, 'sf')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'sf']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?php
    	echo $form->field($model, 'sf_fte')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'sf_fte']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?php
    	echo $form->field($model, 'space_type')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'space_type']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?php
    	echo $form->field($model, 'room_name')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'room_name']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?php
    	echo $form->field($model, 'donor_space')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'donor_space']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?php
    	echo $form->field($model, 'av')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'av']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?php
    	echo $form->field($model, 'ceiling_hgt')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'ceiling_hgt']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?php
    	echo $form->field($model, 'department')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'department']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?php
    	echo $form->field($model, 'space')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'space']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?php
    	echo $form->field($model, 'time')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'time']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?php
    	echo $form->field($model, 'proration')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'proration']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?php
    	echo $form->field($model, 'calcuated_sf')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'calcuated_sf']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?php
    	echo $form->field($model, 'function_code')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'function_code']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?php
    	echo $form->field($model, 'major_category')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'major_category']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?php
    	echo $form->field($model, 'functional_category')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'functional_category']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?php
    	echo $form->field($model, 'functional_title')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'functional_title']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

    <?php
    	echo $form->field($model, 'on_off_campus')->widget(AutoComplete::classname(), [
			'options' => ['class' => 'form-control'],
			'clientOptions' => [ 'source' => new JsExpression('
				function(request, response) {
					console.log(request);
					jQuery.getJSON(
						"'.Url::to(['facilities/lookup', 'field' => 'on_off_campus']).'",
						{query: request.term},
						function(data) {
							var suggestions = [];
							jQuery.each(data, function(index, ele) {
								if (ele.indexOf(request.term.toUpperCase())!=-1||ele.indexOf(request.term.toLowerCase())!=-1) {
									suggestions.push({ value: ele });
								}
							});
						response(suggestions);
					});
				}'), ], ])
	?>

	<?= $form->field($model, 'latitude')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'longitude')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'accessible')->dropDownList(['Y' => 'Yes', 'N' => 'No'],['prompt'=>'']) ?>

	<br clear="all">

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
