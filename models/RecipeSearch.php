<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class RecipeSearch extends Recipe
{
    public function rules()
    {
        return [
            [['id', 'cooking_time', 'user_id'], 'integer'],
            [['title', 'description', 'difficulty'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Recipe::find()->with('user');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'cooking_time' => $this->cooking_time,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'difficulty', $this->difficulty]);

        return $dataProvider;
    }
}