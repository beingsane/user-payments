<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

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
            [['created_at'], 'safe'],
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
}
