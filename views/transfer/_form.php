<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\helpers\Render;
use app\models\User;
use app\models\TransferState;
use app\models\TransferType;

/* @var $this yii\web\View */
/* @var $model app\models\Transfer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transfer-form">

    <?php
        $form = ActiveForm::begin();

        $render = new Render($form, $model);
    ?>

    <?= $render->selectField('type_id', TransferType::getList()) ?>

    <?= $render->textField('username') ?>

    <?= $render->textField('amount', [], ['maxlength' => true]) ?>

    <div class="form-group m-t-md">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
