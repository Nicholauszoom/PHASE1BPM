<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Permission $model */

$this->title = 'Create Permission';
$this->params['breadcrumbs'][] = ['label' => 'Permissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin';

?>

<a href="<?= Yii::$app->request->referrer ?>" class="back-arrow">
    <span class="arrow">&#8592;</span> Back
</a>

<div id="main-content ">


   <div id="page-container">
       <!-- ============================================================== -->
       <!-- Sales Cards  -->
       <!-- ============================================================== -->
       <div class="row"></div>
<div class="permission-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'roleList'=>$roleList,
    ]) ?>

</div>
   </div>
</div>

