<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Transfer;

/**
 * TransferSearch represents the model behind the search form about `app\models\Transfer`.
 */
class TransferSearch extends Model
{
    public $id;
    public $type_id;
    public $from_user_id;
    public $to_user_id;
    public $amount;
    public $state_id;
    public $created_at;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type_id', 'from_user_id', 'to_user_id', 'state_id'], 'integer'],
            [['amount'], 'number'],
            [['created_at'], 'safe'],
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
     * Checks if the filter panel should be showed as open
     * @return bool Returns true if any search attribute is filled
     */
    public function isOpen()
    {
        $attributes = $this->safeAttributes();
        foreach ($attributes as $attribute) {
            if (!empty($this->$attribute)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Transfer::find();
        $query->joinWith(['fromUser fromUser']);
        $query->joinWith(['toUser toUser']);
        $query->joinWith(['state']);
        $query->joinWith(['type']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['fromUser.name'] = [
            'asc'  => ['user.id' => SORT_ASC],
            'desc' => ['user.id' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['toUser.name'] = [
            'asc'  => ['user.id' => SORT_ASC],
            'desc' => ['user.id' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['state.name'] = [
            'asc'  => ['transfer_state.name' => SORT_ASC],
            'desc' => ['transfer_state.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['type.name'] = [
            'asc'  => ['transfer_type.name' => SORT_ASC],
            'desc' => ['transfer_type.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'transfer.id' => $this->id,
            'transfer.type_id' => $this->type_id,
            'transfer.from_user_id' => $this->from_user_id,
            'transfer.to_user_id' => $this->to_user_id,
            'transfer.amount' => $this->amount,
            'transfer.state_id' => $this->state_id,
            'transfer.created_at' => $this->created_at,
        ]);

        if (Yii::$app->user->isGuest) {
            $query->andWhere('0 = 1');
        } else {
            $query->andWhere(['or', ['from_user_id' => Yii::$app->user->id], ['to_user_id' => Yii::$app->user->id]]);
        }


        return $dataProvider;
    }
}
