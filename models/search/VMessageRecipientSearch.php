<?php

namespace app\models\search;

use app\models\entities\VMessageRecipient;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * VMessageRecipientSearch represents the model behind the search form of `app\models\entities\VMessageRecipient`.
 */
class VMessageRecipientSearch extends VMessageRecipient
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'message_id', 'recipient_id', 'unread'], 'integer'],
            [['sender', 'subject', 'body', 'created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = VMessageRecipient::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'unread' => SORT_DESC,
                    'created_at' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'message_id' => $this->message_id,
            'recipient_id' => $this->recipient_id,
            'created_at' => $this->created_at,
            'unread' => $this->unread,
        ]);

        $query->andFilterWhere(['like', 'sender', $this->sender])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'body', $this->body]);

        return $dataProvider;
    }
}
