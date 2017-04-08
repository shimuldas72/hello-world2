<?php

use yii\helpers\Html;

$this->title = 'Update Form: ' . $model->form_name;
$this->params['breadcrumbs'][] = ['label' => 'Forms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->form_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="form-list-update">

    <?= $this->render('_form', [
        'model' => $model,
        'field_model' => $field_model
    ]) ?>

</div>
