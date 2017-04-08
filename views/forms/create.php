<?php

use yii\helpers\Html;

$this->title = 'Create Form';
$this->params['breadcrumbs'][] = ['label' => 'Form Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-list-create">

    <?= $this->render('_form', [
        'model' => $model,
                'field_model' => $field_model
    ]) ?>

</div>
