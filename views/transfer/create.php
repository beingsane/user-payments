<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Transfer */

$this->title = Yii::t('app', 'Create Transfer');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Your transfers'), 'url' => ['transfer/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transfer-create">

    <div class="page-title">
        <h2><?= Html::encode($this->title) ?></h2>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
