<?php

namespace shimuldas72\forms\models;

use Yii;

class FormSubmitted extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'form_submitted';
    }


    public function rules()
    {
        return [
            [['form_id', 'form_name', 'form_actual_id', 'form_subject', 'sent_to', 'sent_options', 'sent_data'], 'required'],
            [['form_actual_id'], 'integer'],
            [['sent_to', 'sent_options', 'sent_data'], 'string'],
            [['created_at'], 'safe'],
            [['form_id', 'form_name', 'form_subject'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'form_id' => 'Form ID',
            'form_name' => 'Form Name',
            'form_actual_id' => 'Form Actual ID',
            'form_subject' => 'Form Subject',
            'sent_to' => 'Sent To',
            'sent_options' => 'Sent Options',
            'sent_data' => 'Sent Data',
            'created_at' => 'Created At',
        ];
    }
}
