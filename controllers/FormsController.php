<?php

namespace shimuldas72\forms\controllers;

use Yii;
use yii\helpers\Html;
use shimuldas72\forms\models\FormList;
use shimuldas72\forms\models\FormListSearch;
use shimuldas72\forms\models\FormFields;
use shimuldas72\forms\models\FormSubmittedSearch;
use shimuldas72\forms\models\FormSubmitted;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;


class FormsController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }




    public function actionIndex()
    {

        $searchModel = new FormListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionCreate()
    {

        $model = new FormList();
        $field_model = new FormFields();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'field_model' => $field_model
            ]);
        }
    }


    public function actionUpdate($id)
    {

        $model = $this->findModel($id);
        $field_model = new FormFields();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'field_model' => $field_model
            ]);
        }
    }

    public function actionSave_field($id=''){
        

        \Yii::$app->response->format = Response::FORMAT_JSON;
        $response['result'] = 'error';

        if($id != ''){
            $model = FormFields::find()->where(['id'=>$id])->one();
        }else{
            $model = new FormFields();
        }
        
        if($model->load(\Yii::$app->request->post())){
            $valid = $model->validate();
            if($valid){
                $model->save();
                $response['result'] = 'success';
                $response['msg'] = 'Field saved successfully.';
            }else{
                $response['msg'] = Html::errorSummary($model);
            }

            return $response;
        }
    }

    public function actionGet_update_data($id){
        
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $response['result'] = 'error';

        $model = FormFields::find()->where(['id'=>$id])->one();
        if(!empty($model)){
            $response['result'] = 'success';
            $response['msg'] = $this->renderAjax('_field_form',['field_model'=>$model]);
        }else{
            $response['msg'] = 'Data not found.';
        }

        return $response;
    }

    public function actionDelete_field($id){
        

        \Yii::$app->response->format = Response::FORMAT_JSON;
        $response['result'] = 'error';

        $model = FormFields::find()->where(['id'=>$id])->one();
        if(!empty($model)){
            $model->delete();

            $response['result'] = 'success';
            $response['msg'] = 'Field removed successfully.';
        }else{
            $response['msg'] = 'Data not found.';
        }

        return $response;
    }


    public function actionCopy($id){
        

        $model = FormList::find()->where(['id'=>$id])->one();
        $last_entry = FormList::find()->orderBy('id desc')->one();
        if(!empty($model)){
            $new_model = new FormList();
            $new_model->attributes = $model->attributes;
            $new_model->form_id = $new_model->form_id.($last_entry->id+1);
            $new_model->form_name = $new_model->form_name.($last_entry->id+1);
            $new_model->save();

            $fields = $model->fields;
            if(!empty($fields)){
                foreach ($fields as $key => $value) {
                    $new_field = new FormFields();
                    $new_field->attributes = $value->attributes;
                    $new_field->form_id = $new_model->id;
                    $new_field->save();
                }
            }

            return $this->redirect(\Yii::$app->request->referrer);
        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        
    }


    public function actionDelete($id)
    {

        $model = $this->findModel($id);

        FormFields::deleteAll(['form_id'=>$id]);
        $model->delete();

        return $this->redirect(['index']);
    }


    public function actionSave_order_all($id){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $response = [];
        $response['result'] = 'error';
        $model = $this->findModel($id);

        $serial_array = $_POST['serial_array'];
        $dbtable = $_POST['dbtable'];

        if($dbtable == 'form_fields'){
            if(!empty($serial_array)){
                foreach ($serial_array as $key => $value) {
                    $field = FormFields::find()->where(['id'=>$value[0]])->one();
                    if(!empty($field)){
                        $field->sort_order = $value[1];
                        $field->save();
                    }
                }
            }

            $response['result'] = 'success';
            $response['msg'] = 'Action Successfull.';
        }else{
            $response['msg'] = 'Action Unsuccessfull.<br/>Unrecognized table name.';
        }

        return $response;
    }








    public function actionSubmitted_forms($id=''){
        

        $searchModel = new FormSubmittedSearch();
        if($id!=''){
            $searchModel->form_actual_id = $id;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('submitted_forms', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView_message($id){
        $model = FormSubmitted::find()->where(['id'=>$id])->one();
        if(empty($model)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if($model->is_seen == 0){
            $model->is_seen = 1;
            $model->save();
        }

        return $this->render('view_message',['model'=>$model]);
    }

    public function actionMarkunseen($id){
        $model = FormSubmitted::find()->where(['id'=>$id])->one();
        if(empty($model)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model->is_seen = 0;
        $model->save();

        return $this->redirect(['submitted_forms']);
    }

    public function actionDeletemessage($id){
        $model = FormSubmitted::find()->where(['id'=>$id])->one();
        if(empty($model)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model->delete();

        return $this->redirect(['submitted_forms']);
    }







    protected function findModel($id)
    {
        if (($model = FormList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
