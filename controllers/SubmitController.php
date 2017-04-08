<?php
namespace shimuldas72\forms\controllers;

use Yii;
use yii\helpers\Html;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

use frontend\models\Pagemethods;
use yii\base\DynamicModel;
use shimuldas72\forms\models\FormList;
use shimuldas72\forms\models\FormSubmitted;

class SubmitController extends Controller
{

	public function actionDynamic_form(){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $response['result'] = 'error';

        if(isset($_POST['form_id'])){
            $form_id = $_POST['form_id'];
        }else{
            $form_id = '';
        }
        $fields_list = '';

        if($form_id != ''){
            $form_data = FormList::find()->where(['form_id'=>$form_id])->one();
            if(!empty($form_data)){
                $fields = $form_data->fields;
                if(!empty($fields)){
                    $c=0;
                    foreach ($fields as $key => $value) {
                        if($c==0){
                            $fields_list .= "'".$value->field_key."'";
                        }else{
                            $fields_list .= ", '".$value->field_key."'";
                        }
                        $c++;

                    }

                    $model = new DynamicModel($_POST['Dynamicform']);
                    foreach ($fields as $key => $value) {
                        $rules = explode(',', $value->validators);
                        if(!empty($rules)){
                            foreach ($rules as $v_key => $v_value) {
                                $model->addRule([$value->field_key], trim($v_value));
                            }
                        }
                    }

                    $valid = $model->validate();
                    if($valid){


                        $mail_data = $this->renderPartial('mail/_default_template',[
                            'form_data' => $form_data,
                            'fields' => $fields,
                            'post_fields' => $_POST['Dynamicform']
                        ]);

                        $is_mail_sent = 0;
                      	//yii2 smtp mail
                        $message = Yii::$app->mailer->compose();
                        $message->SetFrom([$form_data->from_email=>$form_data->from_name]);
                        $message->setTo(explode(',', $form_data->send_to));
                        if(!empty($form_data->cc)){
                            $message->setCc(explode(',', $form_data->cc));
                        }
                        if(!empty($form_data->bcc)){
                            $message->setBcc(explode(',', $form_data->bcc));
                        }
                        
                        $message->setSubject($form_data->subject);
                        $message->setHtmlBody($mail_data);

                        foreach ($fields as $key => $value) {
                            if($value->field_type == 'fileInput'){
                                $filename = \Yii::getAlias('@backend').'/web/form_files/'.$_POST['Dynamicform'][$value->field_key];
                                $message->attach($filename);
                            }
                        }

                        if($message->send()){
                        	$is_mail_sent = 1;
                        }
                        //yii2 smtp mail


                        //basic php mail
						$to      = $form_data->send_to;
						$subject = $form_data->subject;
						$message = $mail_data;
						$headers = 'From: '.$form_data->from_email . "\r\n" .
						    'Reply-To: '.$form_data->from_email . "\r\n" .
						    'X-Mailer: PHP/' . phpversion();

						/*if(mail($to, $subject, $message, $headers)){
							$is_mail_sent = 1;
						}*/
						//basic php mail

                        if($is_mail_sent){
                            $sent_options = [];
                            $sent_options['cc'] = $form_data->cc;
                            $sent_options['bcc'] = $form_data->bcc;
                            $sent_options['from_name'] = $form_data->from_name;
                            $sent_options['from_email'] = $form_data->from_email;

                            $submit_model = new FormSubmitted();
                            $submit_model->form_id = $form_data->form_id;
                            $submit_model->form_name = $form_data->form_name;
                            $submit_model->form_actual_id = $form_data->id;
                            $submit_model->form_subject = $form_data->subject;
                            $submit_model->sent_to = $form_data->send_to;
                            $submit_model->sent_options = json_encode($sent_options);
                            $submit_model->sent_data = json_encode($_POST['Dynamicform']);

                            


                            if($submit_model->save()){

                            }else{
                                $response['msg'] = Html::errorSummary($submit_model);
                                return $response;
                            }

                            $response['result'] = 'success';
                        	$response['msg'] = 'Form submitted successfully.'.$to;
                        }
                        else{
                        	$response['msg'] = 'Unable to send mail.';
                        }


                        
                    }else{
                        $response['msg'] = Html::errorSummary($model);
                    }
                }else{
                    $response['msg'] = 'Form fields are invalid.';
                }
            }else{
                $response['msg'] = 'Undefined form.';
            }
        }else{
            $response['msg'] = 'Invalid form ID.';
        }

        return $response;

    }

}