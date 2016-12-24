<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Transfer */

$this->title = Yii::t('app', 'Update Transfer: {modelName}', [
    'modelName' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transfers'), 'url' => Url::previous()];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="transfer-update">

    <div class="page-title">
        <h2><?= Html::encode($this->title) ?></h2>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>