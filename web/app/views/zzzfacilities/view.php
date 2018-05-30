<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Facilities */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Facilities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="facilities-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'bldg_code',
            'owned_leased',
            'bldg_name',
            'bldg_abbre',
            'floor',
            'room_no',
            'new_room_no',
            'line',
            'status',
            'station_count',
            'sf',
            'sf_fte',
            'space_type',
            'room_name',
            'donor_space',
            'av',
            'ceiling_hgt',
            'department',
            'space',
            'time',
            'proration',
            'calcuated_sf',
            'function_code',
            'major_category',
            'functional_category',
            'functional_title',
            'on_off_campus',
        ],
    ]) ?>

</div>
