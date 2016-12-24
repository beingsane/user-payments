<?php

namespace app\models;

use Yii;
use app\models\Transfer;
use yii\helpers\ArrayHelper;

/**
 * TransferForm is used for creating Transfer object
 */
class TransferForm extends Transfer
{
    /** @var string */
    public $username;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['username'], 'required'],
            [['username'], 'string'],
        ]);
    }

    /**
     * Loads model fields from form values
     * @param Transfer $model
     * @return bool
     */
    public function loadModel($model)
    {
        $toUser = User::ensureUserExists($this->username);
        if (!$toUser) {
            return false;
        }

        $model->load($this->getAttributes(), '');
        $model->state_id = TransferState::AWAITING;
        $model->from_user_id = Yii::$app->user->identity->id;
        $model->to_user_id = $toUser->id;

        return true;
    }
}
