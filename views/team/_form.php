<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Team $model */
/** @var yii\widgets\ActiveForm $form */
$this->context->layout = 'admin';

?>

<div class="team-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_id')->checkboxList(
    \yii\helpers\ArrayHelper::map($userList, 'id', 'username')
) ?>

    <?= $form->field($model, 'status')->dropDownList(
    [
        1 => 'Active',
        2 => 'Inactive',
        3 => 'On Hold',
    ],
    ['prompt' => 'Select Team Status']
); ?>


 

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
