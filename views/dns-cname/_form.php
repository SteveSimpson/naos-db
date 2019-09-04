<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\db\DnsCname */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dns-cname-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="container"><div class="row">
		<div class="col-md-2">
			<?= $form->field($model, 'cname')->textInput(['maxlength' => true]) ?>
        	
    	</div>
    	<div class="col-md-5">
        	<?= $form->field($model, 'domain')->dropDownList($domains) ?>
        </div>

    	<div class="col-md-5">
        	<?= $form->field($model, 'target')->textInput(['maxlength' => true]) ?>
    	</div>
    </div></div>
    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
