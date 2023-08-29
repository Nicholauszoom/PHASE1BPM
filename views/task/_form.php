<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Task $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'budget')->textInput() ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php echo $form->field($model, 'project_id')->dropDownList(
    \yii\helpers\ArrayHelper::map($projectList, 'id', 'title'),
    ['prompt' => 'Select Project']
); ?>

<?php echo $form->field($model, 'team_id')->dropDownList(
    \yii\helpers\ArrayHelper::map($teamList, 'id', 'name'),
    ['prompt' => 'Select Team']
); ?>

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
