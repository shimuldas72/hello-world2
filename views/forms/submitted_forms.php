<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

$this->title = 'Submitted Form List';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php \yii\widgets\Pjax::begin([
                                'enablePushState'=>FALSE,
                                'id' => 'list_of_submitted_forms',
                                'timeout' => 500000
                            ]); ?>

<div class="fade-in-up" style="">
    <div class="hbox hbox-auto-xs hbox-auto-sm">
        
        <div class="col">
            <div class="wrapper">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      List of submitted forms
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
                                'form_subject',
                                'sent_to',

                                [
                                  'class' => 'yii\grid\ActionColumn',
                                  'template' => '{view}{unseen}', 
                                  'headerOptions'=>['style'=>'width:100px;'], 
                                  'contentOptions'=>['class'=>'custom_action_column'], 
                                  'buttons' => [
                                      'view' => function ($url, $model, $key) {
                                          return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/f/forms/view_message', 'id'=>$model->id],['title'=>'View','class'=>'','data-pjax'=>'false']);
                                      },
                                      'unseen' => function ($url, $model, $key) {
                                        if($model->is_seen == 1){
                                          return Html::a('<span class="glyphicon glyphicon-eye-close text-warning" aria-hidden="true"></span>', ['/f/forms/markunseen', 'id'=>$model->id],['title'=>'Mark as Unseen','class'=>'','data-pjax'=>'false']);
                                        }else{
                                          return '';
                                        }
                                      },
                                  ]
                                ],
                            ],
                            'rowOptions' => function ($model, $index, $widget, $grid){
                              if($model->is_seen == 0){
                                return ['class' => 'row_unseen'];
                              }else{
                                return [];
                              }
                            },
                        ]); ?>


                    </div>
                    <footer class="panel-footer">
                      <div class="row">
                        
                        <div class="col-sm-4 col-sm-offset-4 text-center">
                          <small class="text-muted inline m-t-sm m-b-sm"><?= \Yii::$app->GlobalClass->getPaginationSummary($dataProvider); ?></small>
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

