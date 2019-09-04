<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\db\Host */
/* @var $form yii\widgets\ActiveForm */

$types = $model::listTypes();
?>

<div class="host-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hostname')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'network_name')->dropDownList($networks) ?>
    
    <?= $form->field($model, 'type')->dropDownList($types) ?>
    
    <?= $form->field($model, 'service')->textInput(['maxlength' => true]) ?>
    
	<?php if($model->isNewRecord) { ?>
	
		<?= $form->field($model, 'host_ip_last')->textInput(['maxlength' => true]) ?>
	
	<?php } else { ?>

        <?= $form->field($model, 'fqdn')->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($model, 'location_name')->dropDownList($locations) ?>
    
        <?= $form->field($model, 'ipv4')->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($model, 'ipv6')->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($model, 'mask4')->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($model, 'mask6')->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($model, 'monitor_ip')->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($model, 'enabled')->radioList([1=>'Yes',0=>'No']) ?>

    <?php } ?>
    
    <?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>
    
    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <?php if($model->isNewRecord) { ?>
        	<?= Html::submitButton('Save + Create Another', ['class' => 'btn btn-primary', 'name' => 'another', 'value'=>'yes']) ?>
        <?php } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
