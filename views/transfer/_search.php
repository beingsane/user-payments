<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\helpers\Render;
use app\models\User;
use app\models\TransferState;
use app\models\TransferType;

/* @var $this yii\web\View */
/* @var $model app\models\TransferSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transfer-search">

    <?php
        $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'enableClientValidation' => false,
        ]);

        $render = new Render($form, $model);
    ?>

    <div class="row">

        <div class="col-sm-3">
            <?= $render->textField('id') ?>
        </div>

        <div class="col-sm-3">
            <?= $render->selectField('type_id', TransferType::getList()) ?>
        </div>

        <div class="col-sm-3">
            <?= $render->selectField('from_user_id', User::getList()) ?>
        </div>

        <div class="col-sm-3">
            <?= $render->selectField('to_user_id', User::getList()) ?>
        </div>

        <div class="col-sm-3">
            <?= $render->textField('amount') ?>
        </div>

        <div class="col-sm-3">
            <?= $render->selectField('state_id', TransferState::getList()) ?>
        </div>

        <div class="col-sm-3">
            <?= $render->textField('created_at') ?>
        </div>

    </div>

    <div class="form-group no-margin">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
