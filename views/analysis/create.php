<?php

use app\models\Project;
use yii\helpers\Html;
use yii\bootstrap5\Modal;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Analysis $model */

$this->title = 'Create Analysis';
$this->params['breadcrumbs'][] = ['label' => 'Analyses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin';

$project = Project::findOne($projectId);
$projectName = $project ? $project->title : '';
$this->title = 'Create Analysis for :' . $projectName . ' Project';


?>
<a href="<?= Yii::$app->request->referrer ?>" class="back-arrow">
    <span class="arrow">&#8592;</span> Back
</a>
<div class="analysis-create">

<h1 style=" color: blue;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'details' => $details,
        'projectId' => $projectId,
        'projectAmount'=>$projectAmount,
    ]) ?>




</div>


