<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\db\Os */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="os-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'os_name_version')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'os_stig')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
