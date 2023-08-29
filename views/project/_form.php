<?php
use kartik\date\DatePickerAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\jui\DatePicker;

/** @var yii\web\View $this */
/** @var app\models\Project $model */
/** @var yii\widgets\ActiveForm $form */
$this->context->layout = 'admin';
// DatePickerAsset::register($this);

$this->registerCssFile('https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
$this->registerJsFile('https://code.jquery.com/ui/1.12.1/jquery-ui.js');
?>

<div id="main-content">
    <div id="header">
        <div class="header-left float-left">
            <i id="toggle-left-menu" class="ion-android-menu"></i>
        </div>
        <div class="header-right float-right">
            <i class="ion-ios-people"></i>
        </div>
    </div>

    <div id="page-container">
        <!-- ============================================================== -->
        <!-- Sales Cards  -->
        <!-- ============================================================== -->
        <div class="row">

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'budget')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ducument')->fileInput() ?>

    <?= $form->field($model, 'progress')->dropDownList([
    '0' => '0%',
    '30' => '30%',
    '50' => '50%',
    '70' => '70%',
    '90' => '90%',
    '100' => '100%',
]) ?>
 
 <?php echo $form->field($model, 'user_id')->dropDownList(
    \yii\helpers\ArrayHelper::map($users, 'id', 'username'),
    ['prompt' => 'Select Project Manager']
); ?>


<?= $form->field($model, 'start_at')->widget(DatePicker::class, [
    'dateFormat' => 'yyyy-MM-dd',
    'options' => ['class' => 'form-control'],
]) ?>

<?= $form->field($model, 'end_at')->widget(DatePicker::class, [
    'dateFormat' => 'yyyy-MM-dd',
    'options' => ['class' => 'form-control'],
]) ?>

    <?= $form->field($model, 'status')->dropDownList(
    [
        1 => 'Active',
        2 => 'Inactive',
        3 => 'On Hold',
    ],
    ['prompt' => 'Select Project Status']
); ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
        </div>
    </div>
</div>
