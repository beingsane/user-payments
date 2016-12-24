<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TransferSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Your Transfers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transfer-index">

    <div class="page-title">
        <div class="row">
            <div class="col-sm-8">
                <h2><?= Html::encode($this->title) ?></h2>
            </div>

            <div class="col-sm-4">
                <div class="pull-right">
                    <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <?= Html::a(Yii::t('app', 'Filter'), '#filter', ['data-toggle' => 'collapse']) ?>
            <?= Html::a(Yii::t('app', 'Reset filter'), ['index'], ['class' => 'pull-right reset-filter']) ?>
        </div>
        <div id="filter" class="panel-collapse collapse <?= ($searchModel->isOpen() ? 'in' : '') ?>">
            <div class="panel-body">
                <?= $this->render('_search', ['model' => $searchModel]) ?>
            </div>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'type.name',
            'fromUser.name',
            'toUser.name',
            'amount',
            'state.name',
            'created_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
