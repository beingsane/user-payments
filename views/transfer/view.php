<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Transfer */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transfers'), 'url' => Url::previous()];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transfer-view">

    <div class="page-title">
        <div class="row">
            <div class="col-sm-8">
                <h2><?= Html::encode($this->title) ?></h2>
            </div>

            <div class="col-sm-4">
                <div class="pull-right">
                    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

                    <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type.name',
            'fromUser.name',
            'toUser.name',
            'amount',
            'state.name',
            'created_at:datetime',
        ],
    ]) ?>

</div>
