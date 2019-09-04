<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\db\FwConfig */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fw-config-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fw_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fw_type')->radioList($model::types()) ?>
    
    <?= $form->field($model, 'fw_config')->textarea(['rows' => 12]) ?>

    <?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
