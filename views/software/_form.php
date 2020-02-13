<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\db\Software */
/* @var $form yii\widgets\ActiveForm */

define('YesOrNo', [1=>'Yes', 0=>'No']);
?>

<div class="software-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList($model::listTypes()) ?>

    <?= $form->field($model, 'version')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'manufacturer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'license_or_contract')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'licenses_total')->textInput() ?>

    <?= $form->field($model, 'licenses_used')->textInput() ?>

    <?= $form->field($model, 'dod_approval')->dropDownList($model::listApprovalStatus())  ?>

    <?= $form->field($model, 'critical')->radioList(YesOrNo) ?>

    <?= $form->field($model, 'stig')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hosts_os_notes')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'support_links')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'other_notes')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
