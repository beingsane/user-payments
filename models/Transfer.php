<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression as DbExpression;

/**
 * This is the model class for table "{{%transfer}}".
 *
 * @property integer $id
 * @property integer $type_id
 * @property integer $from_user_id
 * @property integer $to_user_id
 * @property string $amount
 * @property integer $state_id
 * @property string $created_at
 *
 * @property User $fromUser
 * @property User $toUser
 * @property TransferState $state
 * @property TransferType $type
 */
class Transfer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%transfer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'from_user_id', 'to_user_id', 'amount', 'state_id'], 'required'],
            [['type_id', 'from_user_id', 'to_user_id', 'state_id'], 'integer'],
            [['amount'], 'number'],
            [['from_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['from_user_id' => 'id']],
            [['to_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['to_user_id' => 'id']],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => TransferState::className(), 'targetAttribute' => ['state_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TransferType::className(), 'targetAttribute' => ['type_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type_id' => Yii::t('app', 'Type'),
            'from_user_id' => Yii::t('app', 'From User'),
            'to_user_id' => Yii::t('app', 'To User'),
            'amount' => Yii::t('app', 'Amount'),
            'state_id' => Yii::t('app', 'State'),
            'created_at' => Yii::t('app', 'Created At'),

            'fromUser.name' => Yii::t('app', 'From User'),
            'toUser.name' => Yii::t('app', 'To User'),
            'state.name' => Yii::t('app', 'State'),
            'type.name' => Yii::t('app', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromUser()
    {
        return $this->hasOne(User::className(), ['id' => 'from_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToUser()
    {
        return $this->hasOne(User::className(), ['id' => 'to_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(TransferState::className(), ['id' => 'state_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(TransferType::className(), ['id' => 'type_id']);
    }

    /**
     * Returns string representation of entity name
     * @return string
     */
    public function getName()
    {
        return $this->id;
    }

    /**
     * Returns list of entities as id => name
     * @return array
     */
    public static function getList()
    {
        $models = self::find()->all();
        $list = ArrayHelper::map($models, 'id', 'name');
        return $list;
    }

    /**
     * Returns true if this transfer is in awating state
     * @return bool
     */
    public function isAwaiting()
    {
        return $this->state_id == TransferState::AWAITING;
    }

    /**
     * Returns true if this transfer is of send type
     * @return bool
     */
    public function isSendType()
    {
        return $this->type_id == TransferType::SEND;
    }

    /**
     * Returns true if this transfer is of send type
     * @return bool
     */
    public function isReceiveType()
    {
        return $this->type_id == TransferType::RECEIVE;
    }

    /**
     * Returns true if the user is allowed to control this transfer
     * @return bool
     */
    public function isControlAllowed()
    {
        return ($this->isAwaiting() && (
               $this->isSendType() && $this->from_user_id == Yii::$app->user->id
            || $this->isReceiveType() && $this->to_user_id == Yii::$app->user->id
        ));
    }

    /**
     * Accepts the transfer
     */
    public function accept()
    {
        if (!$this->isControlAllowed()) {
            return;
        }

        if ($this->type_id == TransferType::SEND) {
            $fromAccount = $this->fromUser->account;
            $toAccount = $this->toUser->account;
            $this->processTransfer($fromAccount, $toAccount, $this->amount);

        } elseif ($this->type_id == TransferType::RECEIVE) {

            $fromAccount = $this->toUser->account;
            $toAccount = $this->fromUser->account;
            $this->processTransfer($fromAccount, $toAccount, $this->amount);
        }
    }

    /**
     * Process the transfer
     * All actions are performed in DB transaction
     * @param Account $fromAccount
     * @param Account $toAccount
     * @param integer $amount
     */
    public function processTransfer($fromAccount, $toAccount, $amount)
    {
        $dbTransaction = $this->db->beginTransaction();

            $transaction = new PaymentTransaction();
            $transaction->save();

            $debetPayment = new Payment();
            $debetPayment->transaction_id = $transaction->id;
            $debetPayment->account_id = $fromAccount->id;
            $debetPayment->type_id = PaymentType::DEBET;
            $debetPayment->amount = $amount;
            $debetPayment->save();

            $creditPayment = new Payment();
            $creditPayment->transaction_id = $transaction->id;
            $creditPayment->account_id = $toAccount->id;
            $creditPayment->type_id = PaymentType::CREDIT;
            $creditPayment->amount = $amount;
            $creditPayment->save();

            // perform addition via database because in application decimal values will be converted to float

            $this->db->createCommand()->update(
                $fromAccount->tableName(),
                ['amount' => new DbExpression('amount - :amount')],
                ['id' => $fromAccount->id],
                [':amount' => $amount]
            )->execute();

            $this->db->createCommand()->update(
                $toAccount->tableName(),
                ['amount' => new DbExpression('amount + :amount')],
                ['id' => $toAccount->id],
                [':amount' => $amount]
            )->execute();

            $fromAccount->refresh();
            $toAccount->refresh();

            $this->state_id = TransferState::ACCEPTED;
            $this->save();

        $dbTransaction->commit();
    }

    /**
     * Declines the transfer
     */
    public function decline()
    {
        if (!$this->isControlAllowed()) {
            return;
        }

        $this->state_id = TransferState::DECLINED;
        $this->save();
    }
}
