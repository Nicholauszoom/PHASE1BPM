<?php

use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Analysis $model */
/** @var yii\widgets\ActiveForm $form */


// Modal pop-up
Modal::begin([
    'id' => 'createModal',
    'title' => 'Create',
]);

// Header
echo '<div class="modal-header">';
echo '</div>';

// Form
$form = ActiveForm::begin([
   
]);
echo $form->field($model, 'title')->textInput(['maxlength' => true]);
echo $form->field($model, 'item')->textInput(['maxlength' => true]);
echo $form->field($model, 'description')->textarea(['maxlength' => true]);
echo $form->field($model, 'quantity')->textInput();
echo $form->field($model, 'cost')->textInput();
echo $form->field($model, 'boq')->fileInput();
echo $form->field($model, 'files')->fileInput();
echo $form->field($model, 'project')->hiddenInput(['value' => $projectId])->label(false);
// Add remaining form fields...

echo '<div class="modal-footer">';
echo Html::submitButton('Save', ['class' => 'btn btn-success']);
echo '</div>';

ActiveForm::end();

Modal::end();
?>

<div class="analysis-form">


    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">item</th>
      <th scope="col">description</th>
      <th scope="col">quantity</th>
      <th scope="col">amount</th>
      <th scope="col">boq attachments</th>
      <th scope="col">other attachment..</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($details as $details): ?>
    <tr>
      <th scope="row">1</th>
      <td><?= $details->item ?></td>
      <td><?= $details->description ?></td>
      <td><?= $details->quantity ?></td>
      <td><?= $details->cost ?></td>
      <td>
    <?php
    $filePaths = explode(',', $details->boq);
    foreach ($filePaths as $filePath) {
        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
        if ($fileExtension === 'pdf') {
            echo '<iframe src="' . Yii::getAlias('@web') . '/' . $filePath . '" width="100%" height="600px"></iframe>';
        } elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif','pptx','pdf','docx','odt','xlsx'])) {
            echo '<img src="' . Yii::getAlias('@web') . '/' . $filePath . '">';
        } else {
            echo 'File format not supported.';
        }
        echo '<br>';
    }
    ?>

      </td>
     
      <td>
    <?php
    $filePaths = explode(',', $details->files);
    foreach ($filePaths as $filePath) {
        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
        if ($fileExtension === 'pdf') {
            echo '<iframe src="' . Yii::getAlias('@web') . '/' . $filePath . '" width="100%" height="600px"></iframe>';
        } elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif','pptx','pdf','docx','odt','xlsx'])) {
            echo '<img src="' . Yii::getAlias('@web') . '/' . $filePath . '">';
        } else {
            echo 'File format not supported.';
        }
        echo '<br>';
    }
    ?>
</td>
      <td>
      <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $details->id], [
            'title' => 'Delete',
            'data-confirm' => 'Are you sure you want to delete this item?',
            'data-method' => 'post',
            'data-pjax' => '0',
        ]) ?>
    </td>
    </tr>
    <?php endforeach; ?>
    
    <tr>
      <td>
             
      <?= Html::a('+ Add a line', '#', [ 'data-toggle' => 'modal', 'data-target' => '#createModal']) ?>
    </td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td>Total Amount: <?=$projectAmount?></td>
      <td>Profit %: </td>
      <td></td>
    </tr>
    
  </tbody>
</table>
</div>
