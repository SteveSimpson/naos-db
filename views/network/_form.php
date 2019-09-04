<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\db\Network */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="network-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'network_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'location_name')->dropDownList($locations) ?>

    <?= $form->field($model, 'prefix4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'prefix6')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mask4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mask6')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dnsdomain')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
