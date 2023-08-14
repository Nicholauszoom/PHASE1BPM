<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Task $model */


$this->title = 'Create Task';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin';

?>

<div id="main-content ">
   
    <div id="page-container">
        <!-- ============================================================== -->
        <!-- Sales Cards  -->
        <!-- ============================================================== -->
        <div class="row"></div>

        <div class="task-index mx-0">
<div class="task-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'projectList'=> $projectList,
        'teamList'=>$teamList,
    ]) ?>

</div>
    </div>
    </div>