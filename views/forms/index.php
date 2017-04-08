<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

$this->title = 'Forms';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php \yii\widgets\Pjax::begin([
                                'enablePushState'=>FALSE,
                                'id' => 'list_of_category',
                                'timeout' => 500000
                            ]); ?>

<div class="fade-in-up" style="">
    <div class="hbox hbox-auto-xs hbox-auto-sm">
        
        <div class="col">
            <div class="wrapper">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      List of Category <?= Html::a('<i class="fa fa-plus fa-fw m-r-xs"></i>New', Url::toRoute(['create']), ['class' => 'btn btn-xs btn-success pull-right','data-pjax'=>'false']) ?>
                    </div>
                    <div class="row wrapper">
                      <div class="col-sm-5 m-b-xs">
                                     
                      </div>
                      <div class="col-sm-4">
                      </div>
                      <div class="col-sm-3">
                        <?php $form = ActiveForm::begin([
                            'method' => 'get',
                            'options' => ['data-pjax' => true ],
                        ]); ?>
                        <div class="input-group">
                          <input class="input-sm form-control" placeholder="Search" type="text" name="FormListSearch[form_name]" value="<?= $searchModel->form_name; ?>">
                          <span class="input-group-btn">
                            <button class="btn btn-sm btn-default" type="submit">Go!</button>
                          </span>
                        </div>
                        <?php ActiveForm::end(); ?>
                      </div>
                    </div>
                    <div class="table-responsive">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                //'id',
                                'form_name',
                                'form_id',
                                'created_at',
                                'updated_at',
                                // 'created_by',
                                // 'updated_by',

                                [
                                  'class' => 'yii\grid\ActionColumn',
                                  'template' => '{view}{update}{copy}{delete}', 
                                  'headerOptions'=>['style'=>'width:100px;'], 
                                  'contentOptions'=>['class'=>'custom_action_column'], 
                                  'buttons' => [
                                      'copy' => function ($url, $model, $key) {
                                          return Html::a('<span class="fa fa-copy text-primary"></span>', ['copy', 'id'=>$model->id],['title'=>'Copy','class'=>'copy_btn','data-pjax'=>'false']);
                                      },
                                  ]
                                ],
                            ],
                        ]); ?>


                    </div>
                    <footer class="panel-footer">
                      <div class="row">
                        <div class="col-sm-4 hidden-xs">
                                            
                        </div>
                        <div class="col-sm-4 text-center">
                          <small class="text-muted inline m-t-sm m-b-sm"></small>
                        </div>
                        <div class="col-sm-4 text-right text-center-xs">                
                            <?php      
                                echo \yii\widgets\LinkPager::widget([
                                    'pagination'=>$dataProvider->pagination,
                                    'nextPageLabel' => '<i class="fa fa-chevron-right"></i>',
                                    'prevPageLabel' => '<i class="fa fa-chevron-left"></i>',
                                    'options' => ['class'=>'pagination pagination-sm m-t-none m-b-none default_pagination'],
                                    'lastPageCssClass' => 'page_last'
                                ]);
                            ?>   
                        </div>
                      </div>
                    </footer>
                  </div>
            </div>
        </div>
        <!-- /.col -->
    </div>
</div>
<?php \yii\widgets\Pjax::end(); ?>


<?php
    $this->registerJs("
        

        $(document).delegate('.copy_btn', 'click', function() { 
            var url = $(this).attr('href');

            smoke.confirm('Are you sure?',function(e){
                if (e){
                    location.href = url;
                    return false;
                }else{
                    return false;
                }
                
            }, {cancel:'No',ok:'Yes'});


            
            return false;
        });

    ", yii\web\View::POS_READY, 'forms_general');
?>

