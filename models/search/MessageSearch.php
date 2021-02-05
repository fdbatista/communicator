<?php

namespace app\models\search;

use app\models\entities\Message;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MessageSearch represents the model behind the search form of `app\models\entities\Message`.
 */
class MessageSearch extends Message
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type_id', 'unread', 'sender_id', 'recipient_id'], 'integer'],
            [['subject', 'body', 'date_sent', 'date_received'], 'safe'],
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
        $query = Message::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'type_id' => $this->type_id,
            'unread' => $this->unread,
            'sender_id' => $this->sender_id,
            'recipient_id' => $this->recipient_id,
            'date_sent' => $this->date_sent,
            'date_received' => $this->date_received,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'body', $this->body]);

        return $dataProvider;
    }
}
