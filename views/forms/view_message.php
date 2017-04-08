<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Submitted Form List', 'url' => ['submitted_forms']];
$this->params['breadcrumbs'][] = $this->title;

$sent_options = json_decode($model->sent_options);
$sent_data = json_decode($model->sent_data);

// echo '<pre>';
// foreach ($sent_data as $key => $value) {
// 	var_dump($value);
// }

// exit();
?>

<div class="wrapper-md">
  <div class="row">

		<div class="col-md-6">
			<div class="panel panel-info">
		        <div class="panel-heading">
		            Form Details
		        </div>
		        <div class="list-group">
		            <table class="table table-striped table-bordered detail-view">
			            <tr>
			            	<th>Form name</th>
			            	<td><?= $model->form_name; ?></td>
			            </tr>
			            <tr>
			            	<th>Form ID</th>
			            	<td><?= $model->form_id; ?></td>
			            </tr>
			            <tr>
			            	<th>Form Subject</th>
			            	<td><?= $model->form_subject; ?></td>
			            </tr>
			            <tr>
			            	<th>Sent to</th>
			            	<td><?= $model->sent_to; ?></td>
			            </tr>
			            <tr>
			            	<th>Cc</th>
			            	<td><?= $sent_options->cc; ?></td>
			            </tr>
			            <tr>
			            	<th>Bcc</th>
			            	<td><?= $sent_options->bcc; ?></td>
			            </tr>
			            <tr>
			            	<th>From name</th>
			            	<td><?= $sent_options->from_name; ?></td>
			            </tr>
			            <tr>
			            	<th>From email</th>
			            	<td><?= $sent_options->from_email; ?></td>
			            </tr>
		            </table>
		        </div>
		        <div class="row">
	                <div class="col-md-12 text-center">
	                	<?php
	                		if($model->is_seen == 1){
	                			echo Html::a('Mark as Unseen', ['markunseen', 'id' => $model->id], ['class' => 'btn btn-primary']);
	                		}
	                	?>
	                    
	                    <?= Html::a('Delete', ['deletemessage', 'id' => $model->id], ['class' => 'btn btn-danger','data-method'=>'post']) ?>

	                    <p>&nbsp;</p>
	                </div>
	            </div>

		    </div>
		</div>


		<div class="col-md-6">
			<div class="panel panel-info">
		        <div class="panel-heading">
		            Form Data
		        </div>
		        <div class="list-group">
		            <table class="table table-striped table-bordered detail-view">
		            	<?php
		            		if(!empty($sent_data)){
		            			foreach ($sent_data as $key => $value) {
		            				$ext_q = explode('.', $value);
		            				if(!empty($ext_q)){
		            					$ext = end($ext_q);
		            					$file = Url::base().'/form_files/'.$value;
		            				}else{
		            					$ext = '';
		            				}
		            				$ext_array = array('jpg','jpeg','png','txt');
		            	?>
		            				<tr>
						            	<th><?= $key; ?></th>
						            	<td>
						            		<?php
						            			if(file_exists(\Yii::getAlias('@webroot').'/form_files/'.$value)){
						            				echo '<a href="'.$file.'" target="_blank" class="text-info">'.$value.'</a>';
						            			}else{
						            				echo $value;
						            			}
						            		?>
						            	</td>
						            </tr>
		            	<?php
		            			}
		            		}
		            	?>
			            
		            </table>
		        </div>
		    </div>
		</div>

	</div>
</div>