<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Orders;

/**
 * SearchOrders represents the model behind the search form about `common\models\Orders`.
 */
class SearchOrders extends Orders
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'goodsid', 'cateid', 'number','seller_confirm_time', 'is_seller_confirm', 'is_buyer_confirm', 'break_uid','break_type', 'cancel_uid', 'cancel_type', 'status'], 'integer'],
            [['orderno', 'goods_name', 'remark', 'year', 'year_month', 'year_month_day'], 'safe'],
            [['goods_price', 'amount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = Orders::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'type' => $this->type,
            'goodsid' => $this->goodsid,
            'goods_price' => $this->goods_price,
            'cateid' => $this->cateid,
            'number' => $this->number,
            'amount' => $this->amount,
            'is_buyer_confirm' => $this->is_buyer_confirm,
            'break_uid' => $this->break_uid,
            'break_type' => $this->break_type,
            'cancel_uid' => $this->cancel_uid,
            'cancel_type' => $this->cancel_type,
            'status' => $this->status,
            'deal_time' => $this->deal_time,
            'cancel_time' => $this->cancel_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'orderno', $this->orderno])
            ->andFilterWhere(['like', 'goods_name', $this->goods_name])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'year', $this->year])
            ->andFilterWhere(['like', 'year_month', $this->year_month])
            ->andFilterWhere(['like', 'year_month_day', $this->year_month_day]);

        return $dataProvider;
    }
}
