<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%payment_type}}".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Payment[] $payments
 */
class PaymentType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%payment_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['type_id' => 'id']);
    }

    /**
     * Returns string representation of entity name
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
