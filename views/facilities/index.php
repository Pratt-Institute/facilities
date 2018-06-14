<style>

div.container {
	/*width: auto !important;
	min-width: 970px !important;*/
	width: 1630px !important;
	/*display:inline-block;*/
	width: auto;
	font-size: 80% !important;
	white-space: nowrap !important;
}

div.facilities-index {
	display:inline-block;
	width: auto;
}

div.grid-view {
	display:inline-block;
	width: auto;
}

table.table {
	width: 1% !important;
}

td {
	max-width: 175px !important;
	overflow: hidden !important;
	text-overflow: ellipsis !important;
}

</style>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FacilitiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Facilities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="facilities-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--<p>
        <?= Html::a('Create Facilities', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'bldg_code',
            //'owned_leased',
            'bldg_name',
            'bldg_abbre',
            'floor',
            'room_no',
            'new_room_no',
            //'line',
            //'status',
            //'station_count',
            //'sf',
            //'sf_fte',
            'space_type',
            'room_name',
            //'donor_space',
            //'av',
            //'ceiling_hgt',
            'department',
            //'space',
            //'time',
            //'proration',
            //'calcuated_sf',
            'function_code',
            'major_category',
            'functional_category',
            'functional_title',
            //'on_off_campus',

			// 	[
			// 		'class' => 'yii\grid\CheckboxColumn',
			// 		'checkboxOptions' => [
			// 			'onclick' => 'js:toggleMapDisplay(this)',
			// 			'checked' => function ($model){
			// 				return false;
			// 				//($model->gk_display=='Y'?true:false)
			// 			}
			// 		]
			// 	],

            [
            	'class' => 'yii\grid\CheckboxColumn',
            	'checkboxOptions' => function($model, $key, $index, $widget) {
            		return [
            			'onclick' => 'js:toggleMapDisplay(this)',
            			'checked' => ($model->gk_display=='Y'?true:false)
            		];
            	},
            	'header' => false,
            ],

            [
            	'class' => 'yii\grid\ActionColumn',
            	'template' => '{myButton}',
            	'buttons' => [
					'myButton' => function($url, $model, $key) {
						return Html::a('Edit', ['facilities/update', 'id'=>$model->id], ['class' => 'btn btn-success btn-xs']);
					}
				]
            ],

			// 	[
			// 		'label' => 'My Label',
			// 		'format' => 'raw',
			// 		'value' => Html::a('Click me', ['site/index'], ['class' => 'btn btn-success btn-xs', 'data-pjax' => 0])
			// 	]


        ],
    ]); ?>
</div>

<script>

function toggleMapDisplay(obj) {

	//alert( $(obj).closest('tr').attr('data-key') );
	var display = 'N';
	ckb = $(obj).is(':checked');
	if (ckb == true) {
		display = 'Y';
	}

	$.ajax({
		url: "http://localhost/facilities/toggle",
		data: {
			id: $(obj).closest('tr').attr('data-key'),
			display: display
		},
		type: "POST",
		//beforeSend: function(xhr){xhr.setRequestHeader('X-Test-Header', 'test-value');},
		success: function(ret) {
			console.log(ret)
		}
	});

}

</script>
