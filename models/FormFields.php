<?php

namespace shimuldas72\forms\models;

use Yii;

class FormFields extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'form_fields';
    }


    public function rules()
    {
        return [
            [['field_key', 'label', 'field_type', 'validators'], 'required'],
            [['form_id','sort_order'], 'integer'],
            [['options', 'validators','template','placeholder'], 'string'],
            [['field_key', 'label', 'hint', 'field_type'], 'string', 'max' => 255],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'form_id' => 'Form ID',
            'field_key' => 'Field Key',
            'label' => 'Label',
            'hint' => 'Hint',
            'field_type' => 'Field Type',
            'options' => 'Options',
            'validators' => 'Validators',
        ];
    }
}
