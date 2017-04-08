
<table cellpadding="10" style="width:100%;background-color:rgb(238,242,245);font-family:'segoeui','arial'">
	<tbody><tr>
		<td style="padding:40px 30px 15px 30px" colspan="2">
			<!-- <img src="http://iab.com.bd/test_run/themes/mytheme/img/logo.png" class="CToWUd"> -->
			Logo here
		</td>
	</tr>
	<tr align="center" style="border:1px solid rgba(0,0,0,.1);background:#fff none repeat scroll 0 0;float:left;font-size:15px;margin:1%;width:98%">
		<td style="padding:50px 100px;color:rgb(105,103,104);line-height:25px" colspan="2">
			<span style="float:left;font-size:22px;margin-bottom:12px;text-align:center;text-transform:uppercase;width:100%">
			New <?= $form_data->form_name; ?>  !</span> <br>
					
			<table cellpadding="10" cellspacing="0" style="width:100%;background-color:rgb(255,255,255);font-family:'segoeui','arial'">
				<?php
					if(!empty($fields)){
						foreach ($fields as $key => $value) {
							if($value->field_type != 'fileInput'){
				?>
							<tr width="100%">
								<td style="border-bottom:1px solid #666;"><?= $value->label; ?></td>
								<td style="border-bottom:1px solid #666;">: <?= isset($post_fields[$value->field_key])?$post_fields[$value->field_key]:''; ?></td>
							</tr>
				<?php
							}
						}
					}
				?>
				
			</table>

				
		</td>
	</tr>
	

	
</tbody></table>