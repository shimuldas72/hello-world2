<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php 
	if($field_model->isNewRecord){
		$field_model->form_id = $model->id;
	    $form = ActiveForm::begin([
	                    'id' => 'field-form',
	                    'options'=>['class'=>'form-horizontal field-form'],
	                    'action' => ['forms/save_field'],
	                    'fieldConfig' => [
	                        'template' => "{label}\n<div class=\"col-sm-10\">{input}\n{hint}\n{error}</div>",
	                    ],
	            ]); 
	}else{
	    $form = ActiveForm::begin([
	                    'id' => 'field-form_update',
	                    'options'=>['class'=>'form-horizontal field-form'],
	                    'action' => ['forms/save_field','id'=>$field_model->id],
	                    'fieldConfig' => [
	                        'template' => "{label}\n<div class=\"col-sm-10\">{input}\n{hint}\n{error}</div>",
	                    ],
	            ]); 
	}
    
?>

        <div class="hide">
            <?= $form->field($field_model, 'form_id',['labelOptions' => [ 'class' => 'col-sm-2 control-label' ]])->textInput(['maxlength' => true]) ?>7
        </div>

        <?= $form->field($field_model, 'field_key',['labelOptions' => [ 'class' => 'col-sm-2 control-label' ]])->textInput(['maxlength' => true])->hint('No apace or special character allowed. Use "_" instead.'); ?>

        <?= $form->field($field_model, 'label',['labelOptions' => [ 'class' => 'col-sm-2 control-label' ]])->textInput(['maxlength' => true]) ?>

        <?= $form->field($field_model, 'placeholder',['labelOptions' => [ 'class' => 'col-sm-2 control-label' ]])->textInput(['maxlength' => true]) ?>

        <?= $form->field($field_model, 'hint',['labelOptions' => [ 'class' => 'col-sm-2 control-label' ]])->textInput(['maxlength' => true]) ?>

        <?= $form->field($field_model, 'field_type',['labelOptions' => [ 'class' => 'col-sm-2 control-label' ]])
                                    ->dropDownList(
                                        ['textInput'=>'textInput','textArea'=>'textArea','dropDownList'=>'dropDownList','checkBox'=>'checkBox','radioButton'=>'radioButton','fileInput'=>'fileInput'],
                                        [
                                          'class'=>'form-control page-types',
                                          'data-placeholder' => 'Select type'   
                                        ]
                                    ); ?>

        <?= $form->field($field_model, 'options',['labelOptions' => [ 'class' => 'col-sm-2 control-label' ]])->textArea(['maxlength' => true]) ?>

        <?= $form->field($field_model, 'validators',['labelOptions' => [ 'class' => 'col-sm-2 control-label' ]])->textArea(['maxlength' => true])->hint('Avaliable validators: string, required, integer, email, safe') ?>

        <?= $form->field($field_model, 'template',['labelOptions' => [ 'class' => 'col-sm-2 control-label' ]])->textArea(['maxlength' => true,'rows'=>9])->hint('Variables: {{name}}, {{label}}, {{placeholder}}, {{hint}} Optional: {{filefield}} for fileInput type') ?>

        <div class="form-group ">
            <div class="col-sm-10 col-sm-offset-2">
                <?= Html::submitButton($field_model->isNewRecord ? 'Add' : 'Update', ['class' => $field_model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>

<?php ActiveForm::end(); ?>