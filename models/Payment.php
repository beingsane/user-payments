<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%payment}}".
 *
 * @property integer $id
 * @property integer $transaction_id
 * @property integer $account_id
 * @property integer $type_id
 * @property string $amount
 * @property string $created_at
 *
 * @property Account $account
 * @property PaymentTransaction $transaction
 * @property PaymentType $type
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%payment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transaction_id', 'account_id', 'type_id', 'amount'], 'required'],
            [['transaction_id', 'account_id', 'type_id'], 'integer'],
            [['amount'], 'number'],
            [['created_at'], 'safe'],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['account_id' => 'id']],
            [['transaction_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentTransaction::className(), 'targetAttribute' => ['transaction_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentType::className(), 'targetAttribute' => ['type_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'transaction_id' => Yii::t('app', 'Transaction'),
            'account_id' => Yii::t('app', 'Account'),
            'type_id' => Yii::t('app', 'Type'),
            'amount' => Yii::t('app', 'Amount'),
            'created_at' => Yii::t('app', 'Created At'),

            'account.name' => Yii::t('app', 'Account'),
            'transaction.name' => Yii::t('app', 'Transaction'),
            'type.name' => Yii::t('app', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaction()
    {
        return $this->hasOne(PaymentTransaction::className(), ['id' => 'transaction_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(PaymentType::className(), ['id' => 'type_id']);
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
}
