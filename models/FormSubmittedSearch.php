<?php

namespace shimuldas72\forms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\forms\models\FormSubmitted;

class FormSubmittedSearch extends FormSubmitted
{

    public function rules()
    {
        return [
            [['form_actual_id'], 'integer'],
            [['sent_to', 'sent_options', 'sent_data'], 'string'],
            [['created_at'], 'safe'],
            [['form_id', 'form_name', 'form_subject'], 'string', 'max' => 255],
        ];
    }


    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = FormSubmitted::find()->orderBy('id desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'form_actual_id' => $this->form_actual_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'form_id', $this->form_id])
            ->andFilterWhere(['like', 'form_subject', $this->form_subject])
            ->andFilterWhere(['like', 'sent_to', $this->sent_to])
            ->andFilterWhere(['like', 'form_name', $this->form_name]);

        return $dataProvider;
    }
}
