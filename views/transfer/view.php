<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Transfer */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Your transfers'), 'url' => ['transfer/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transfer-view">

    <div class="page-title">
        <div class="row">
            <div class="col-sm-8">
                <h2><?= Html::encode($this->title) ?></h2>
            </div>

            <?php if ($model->isControlAllowed()) { ?>
                <div class="col-sm-4">
                    <div class="pull-right">
                        <?= Html::a(Yii::t('app', 'Accept'), ['accept', 'id' => $model->id], [
                            'class' => 'btn btn-primary',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to accept this item?'),
                                'method' => 'post',
                            ],
                        ]) ?>

                        <?= Html::a(Yii::t('app', 'Decline'), ['decline', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to decline this item?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                </div>
            <?php } ?>
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
