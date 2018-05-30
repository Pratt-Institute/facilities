<style>

div.container {
	/*width: auto !important;
	min-width: 970px !important;*/
	width: 1250px !important;
	font-size: 80% !important;
	white-space: nowrap !important;
}

table.table {
	width: 1% !important;
}

td {
	max-width: 125px !important;
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

    <p>
        <?= Html::a('Create Facilities', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
            //'space_type',
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
            'on_off_campus',

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
