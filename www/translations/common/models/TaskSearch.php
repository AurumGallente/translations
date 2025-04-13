<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Task;

class TaskSearch extends Task
{
    public function rules()
    {
        return [
            [['id', 'language_direction_id', 'status'], 'integer'],
            [['words'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Task::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // if validation fails, return all results
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'language_direction_id' => $this->language_direction_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'words', $this->words]);

        return $dataProvider;
    }
}