<?php

namespace shimuldas72\forms\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use backend\models\User;

class FormList extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                ],
        ];
    }

    public static function tableName()
    {
        return 'form_list';
    }


    public function rules()
    {
        return [
            [['form_name', 'form_id','send_to','subject','from_email','from_name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['form_name', 'form_id','form_class','success_error_position','subject','from_email','from_name'], 'string', 'max' => 255],
            [['submit_button_template', 'success_template','error_template','cc','bcc'], 'string'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'form_name' => 'Form Name',
            'form_id' => 'Form ID',
            'submit_button_template' => 'Submit Button Template',
            'success_template' => 'Success Template',
            'error_template' => 'Error Template',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'success_error_position' => 'Success and Error Message Position',
            'send_to' => 'Send mail to',
            'subject' => 'Mail Subject'
        ];
    }


    public function getFields()
    {
       return $this->hasMany(FormFields::className(), ['form_id' => 'id'])->orderBy('sort_order asc');
    }
}
