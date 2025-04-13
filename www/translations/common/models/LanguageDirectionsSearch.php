<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class LanguageDirectionsSearch extends Model
{
    public $language_from;
    public $language_to;


    public function rules()
    {
        return [
            [['language_from', 'language_to'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = LanguageDirection::find();

        // Create a new Active Data Provider instance
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // Load the search parameters
        $this->load($params);

        // If validation fails, we return the empty data provider
        if (!$this->validate()) {
            return $dataProvider;
        }

        // Add filters for the search query
        $query->andFilterWhere(['like', 'language_from', $this->language_from])
            ->andFilterWhere(['like', 'language_to', $this->language_to]);

        return $dataProvider;
    }
}