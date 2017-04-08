<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$fields = $model->fields;
?>
<div class="wrapper">
    <div class="panel panel-default">
        <div class="panel-heading font-bold">
          <?= $this->title; ?>
        </div>
        <div class="panel-body">

            <ul class="nav nav-tabs page_tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#general" aria-controls="general" role="tab" data-toggle="tab">General Info</a>
                </li>
                <li role="presentation">
                    <a href="#sending_options" aria-controls="sending_options" role="tab" data-toggle="tab">Sending options</a>
                </li>
                <?php
                    if(!$model->isNewRecord){
                ?>
                <li role="presentation">
                    <a href="#Fields" aria-controls="Fields" role="tab" data-toggle="tab">Fields</a>
                </li>
                <?php
                    }
                ?>
            </ul>

            <?php $form = ActiveForm::begin([
                                'id' => 'form',
                                'options'=>['class'=>'form-horizontal'],
                                'fieldConfig' => [
                                    'template' => "{label}\n<div class=\"col-sm-10\">{input}\n{hint}\n{error}</div>",
                                ],
                        ]); ?>
            <div class="tab-content page_tabs_cont">
                <div role="tabpanel" class="tab-pane active" id="general">
                    <p>&nbsp;</p>

                    <?= $form->field($model, 'form_name',['labelOptions' => [ 'class' => 'col-sm-2 control-label' ]])->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'form_id',['labelOptions' => [ 'class' => 'col-sm-2 control-label' ]])->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'form_class',['labelOptions' => [ 'class' => 'col-sm-2 control-label' ]])->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'submit_button_template',['labelOptions' => [ 'class' => 'col-sm-2 control-label' ]])->textArea(['maxlength' => true,'rows'=>9])->hint('Required variables: {{button}}') ?>

                    <?= $form->field($model, 'success_error_position',['labelOptions' => [ 'class' => 'col-sm-2 control-label' ]])
                                        ->dropDownList(
                                            ['top'=>'Top of the form','bottom'=>'Bottom of the form','before_submit_button'=>'Before submit button'],
                                            [
                                              'class'=>'form-control page-types',
                                              'data-placeholder' => 'Select type'   
                                            ]
                                        ); ?>
                    <?= $form->field($model, 'success_template',['labelOptions' => [ 'class' => 'col-sm-2 control-label' ]])->textArea(['maxlength' => true,'rows'=>9])->hint('Required variables: {{wrapper_class}}, {{message}}') ?>

                    <?= $form->field($model, 'error_template',['labelOptions' => [ 'class' => 'col-sm-2 control-label' ]])->textArea(['maxlength' => true,'rows'=>9])->hint('Required variables: {{wrapper_class}}, {{message}}') ?>

                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>
                    </div>



                </div>
                <div role="tabpanel" class="tab-pane" id="sending_options">
                    <p>&nbsp;</p>

                    <?= $form->field($model, 'subject',['labelOptions' => [ 'class' => 'col-sm-2 control-label' ]])->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'from_email',['labelOptions' => [ 'class' => 'col-sm-2 control-label' ]])->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'from_name',['labelOptions' => [ 'class' => 'col-sm-2 control-label' ]])->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'send_to',['labelOptions' => [ 'class' => 'col-sm-2 control-label' ]])->textArea(['maxlength' => true,'rows'=>1])->hint('use comma(,) to separate two mail address') ?>

                    <?= $form->field($model, 'cc',['labelOptions' => [ 'class' => 'col-sm-2 control-label' ]])->textArea(['maxlength' => true,'rows'=>1])->hint('use comma(,) to separate two mail address') ?>

                    <?= $form->field($model, 'bcc',['labelOptions' => [ 'class' => 'col-sm-2 control-label' ]])->textArea(['maxlength' => true,'rows'=>1])->hint('use comma(,) to separate two mail address') ?>

                    

                    <div class="col-sm-4 col-sm-offset-2">
                        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>

                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <?php
                if(!$model->isNewRecord){
            ?>
            <div class="tab-content page_tabs_cont">
                <div role="tabpanel" class="tab-pane" id="Fields">
                    <p>&nbsp;</p>
                    <div class="container-fluid">
                        <a href="" class="add_new_field_modal_btn btn btn-sm btn-info">Add new Field</a><br/><br/>
                        <div class="fields">
                            <?php \yii\widgets\Pjax::begin([
                                                    'enablePushState'=>FALSE,
                                                    'id' => 'list_of_fields',
                                                    'timeout' => 500000
                                                ]); ?>

                                <table id="sort"  class="table table-condenced" data-table="form_fields" data-pjaxid="list_of_fields">
                                    <tr>
                                        <th>#</th>
                                        <th>Field Key</th>
                                        <th>Label</th>
                                        <th>Field Type</th>
                                        <th>Validators</th>
                                        <th>Sort Order</th>
                                        <th></th>
                                    </tr>
                                    <?php
                                        $i=0;
                                        if(!empty($fields)){
                                            foreach ($fields as $key => $value) {
                                                $i++;
                                    ?>
                                                <tr class="holder_row" data-id="<?= $value->id; ?>">
                                                    <td class="index"><?= $i; ?></td>
                                                    <td><?= $value->field_key; ?></td>
                                                    <td><?= $value->label; ?></td>
                                                    <td><?= $value->field_type; ?></td>
                                                    <td><?= $value->validators; ?></td>
                                                    <td><input type="text" name="sort_order" value="<?= $value->sort_order; ?>" class="sort_order_field"></td>
                                                    <td>
                                                        <a data-pjax="false" title="update" href="<?= Url::toRoute(['forms/get_update_data','id'=>$value->id]); ?>" class="update_field_btn"><i class="glyphicon glyphicon-pencil"></i></a>
                                                        <a data-pjax="false" title="delete" href="<?= Url::toRoute(['forms/delete_field','id'=>$value->id]); ?>" class="delete_field_btn"><i class="glyphicon glyphicon-trash text-danger"></i></a>
                                                    </td>
                                                </tr>
                                    <?php
                                            }
                                        }
                                    ?>
                                    
                                </table>


                            <?php \yii\widgets\Pjax::end(); ?>
                            <button class="manual_save_order_btn btn btn-primary" data-table="sort">Save Order</button>
                        </div>
                    </div>
                </div>

            </div>
            <?php
                }
            ?>

        </div>


        
    </div>
</div>

<div class="modal fade" id="add_new_field_modal" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:0;">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add new field</h4>
            </div>
            <div class="modal-body">
                <?php
                    echo $this->render('_field_form',['field_model'=>$field_model,'model'=>$model])
                ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="update_field_modal" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:0;">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Update Field</h4>
            </div>
            <div class="modal-body">
                
            </div>
        </div>
    </div>
</div>

<?php
    $this->registerJsFile("https://code.jquery.com/ui/1.12.1/jquery-ui.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
    
    $this->registerJs("
        var fixHelperModified = function(e, tr) {
            var originals = tr.children();
            var helper = tr.clone();
            helper.children().each(function(index) {
              $(this).width(originals.eq(index).width())
            });
            return helper;
          },
        
        updateIndex = function(e, ui) {
            $('td.index', ui.item.parent()).each(function(i) {
              $(this).html(i + 1);
              $(this).closest('tr').find('.sort_order_field').val(i + 1);
            });
        };

        saveOrder = function(e, ui) {
            var table = ui.item.parent().closest('table');
            var dbtable = table.attr('data-table');
            var pjax_id = table.attr('data-pjaxid');

            setTimeout(function(){
                var serial_array = [];
                table.find('tr.holder_row').each(function(index,val){
                    var sub_array = [];
                    sub_array.push($(val).attr('data-id'));
                    sub_array.push($(val).find('.sort_order_field').val());
                    serial_array.push(sub_array);
                });

                saveOrderAjax(serial_array,dbtable,pjax_id);
                
            },500);
        };

        function saveOrderAjax(serial_array,dbtable,pjax_id){
            $.ajax({
                type : 'POST',
                dataType : 'json',
                url : '".Url::toRoute(['forms/save_order_all','id'=>$model->id])."',
                data: {serial_array:serial_array,dbtable:dbtable},
                beforeSend : function( request ){
                    
                },
                success : function( data )
                { 
                    if(data.result == 'success'){
                        toastr.success(data.msg,'');

                        if(pjax_id != ''){
                            $.pjax.reload({container:'#'+pjax_id});
                        }
                        
                    }else{
                        toastr.error(data.msg,'');
                    }
                }
            });

            return true;
        }

        $('#sort tbody').sortable({
          helper: fixHelperModified,
          stop: updateIndex,
          update: saveOrder
        }).disableSelection();


        $(\"#list_of_fields\").on(\"pjax:end\", function () {
            $('#sort tbody').sortable({
              helper: fixHelperModified,
              stop: updateIndex,
              update: saveOrder
            }).disableSelection();
        });

        $(document).delegate('.manual_save_order_btn','click',function(){
            var table_id = $(this).attr('data-table');
            
            var table = $('#'+table_id);
            var dbtable = table.attr('data-table');
            var pjax_id = table.attr('data-pjaxid');

            var serial_array = [];
            table.find('tr.holder_row').each(function(index,val){
                var sub_array = [];
                sub_array.push($(val).attr('data-id'));
                sub_array.push($(val).find('.sort_order_field').val());
                serial_array.push(sub_array);
            });

            saveOrderAjax(serial_array,dbtable,pjax_id);


            return false;
        })

    ", yii\web\View::POS_READY, "sorting");

    $this->registerJs("
        $('.page_tabs a').on('click',function(){
            $('.page_tabs_cont .tab-pane').removeClass('active');
        });

        $('#formlist-form_name').on('keyup',function (e) {  

            var page_title = $(this).val();
            var page_slug = page_title.replace(/\s+/g, '-').toLowerCase();
            page_slug = page_slug.replace(/&|_/g,'');

            $('#formlist-form_id').val(page_slug);
            
        });

        $(document).delegate('.add_new_field_modal_btn','click',function(){
            $('#add_new_field_modal').modal('show');
            return false;
        });

        $(document).delegate('.field-form', 'beforeSubmit', function(event, jqXHR, settings) {
                        
            var form = $(this);
            if(form.find('.has-error').length) {
                return false;
            }
            
            $.ajax({
                    url: form.attr('action'),
                    type: 'post',
                    data: form.serialize(),
                    success: function(data) {

                        if(data.result=='success'){
                            $('#add_new_field_modal').modal('hide');
                            $('#update_field_modal').modal('hide');
                            form[0].reset();

                            setTimeout(function(){
                                $.pjax.reload({container:'#list_of_fields'});
                            },200);
                        }else{
                            toastr.error(data.msg,'');
                        }
                    }
            });
            
            return false;
        });

        $(document).delegate('.update_field_btn', 'click', function() { 
            var url = $(this).attr('href');
            $.ajax({
                type : 'POST',
                dataType : 'json',
                url : url,
                data: {},
                beforeSend : function( request ){
                    $('#update_field_modal').modal('show');
                },
                success : function( data )
                { 
                    if(data.result == 'success'){
                        $('#update_field_modal .modal-body').html(data.msg);
                    }else{
                        toastr.error(data.msg,'');
                    }
                }
            });
            return false;
        });

        $(document).delegate('.delete_field_btn', 'click', function() { 
            var url = $(this).attr('href');

            smoke.confirm('Are you sure?',function(e){
                if (e){
                    $.ajax({
                        type : 'POST',
                        dataType : 'json',
                        url : url,
                        data: {},
                        beforeSend : function( request ){
                            
                        },
                        success : function( data )
                        { 
                            if(data.result == 'success'){
                                toastr.success(data.msg,'');
                                $.pjax.reload({container:'#list_of_fields'});
                            }else{
                                toastr.error(data.msg,'');
                            }
                        }
                    });
                    return false;
                }else{
                    return false;
                }
                
            }, {cancel:'No',ok:'Yes'});


            
            return false;
        });

    ", yii\web\View::POS_READY, 'forms_general');
?>

