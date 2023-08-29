<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Project $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->context->layout = 'admin';




?>

<a href="<?= Yii::$app->request->referrer ?>" class="back-arrow">
    <span class="arrow">&#8592;</span> Back
</a>

    <div id="page-container">
        <!-- ============================================================== -->
        <!-- Sales Cards  -->
        <!-- ============================================================== -->
        
        <div class="row">
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            'budget',
            'user_id',
            // [
            //     'attribute' => 'user_id',
            //     'value' => 'user.email',
            // ],
            [
                'attribute' => 'start_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->start_at);
                },
            ],
            [
                'attribute' => 'end_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->end_at);
                },
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->created_at);
                },
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->updated_at);
                },
            ],
            [
                'attribute' => 'progress',
                'format' => 'raw',
                'value' => function ($model) {
                    $progress = $model->progress;
                    $progressBar = '<div class="progress progress_sm">';
                    $progressBar .= '<div class="progress-bar bg-green" role="progressbar" style="width: ' . $progress . '%;"></div>';
                    $progressBar .= '</div>';
                    $progressBar .= '<small>' . $progress . '% Complete</small>';
                    return $progressBar;
                },
            ],
            
//          [
//     'attribute' => 'status',
//     'value' => function ($model) {
//         return getStatusLabel($model->status);
//     },
//     'format' => 'raw',
//     'contentOptions' => ['class' => function ($model) {
//         return getStatusClass($model->status);
//     }],
//     'headerOptions' => ['class' => 'status-column-header'],
//     'class' => 'yii\grid\DataColumn',
// ],
            // 'progress',
            //  'status',
            
            'created_by',
            'ducument',
        ],
    ]) ?>
<?php
function getStatusLabel($status)
{
    $statusLabels = [
        1 => '<span class="label label-active">Active</span>',
        2 => '<span class="label label-inactive">Inactive</span>',
        3 => '<span class="label label-onhold">On Hold</span>',
    ];

    return isset($statusLabels[$status]) ? $statusLabels[$status] : '';
}

function getStatusClass($status)
{
    $statusClasses = [
       
        1 => 'status-active',
        2 => 'status-inactive',
        3 => 'status-onhold',
    ];

    return isset($statusClasses[$status]) ? $statusClasses[$status] : '';
}



$currentDate = date('Y-m-d');
if ($model->start_at && $model->end_at) {
    if ($currentDate > $model->end_at) {
        echo '<span class="alert alert-danger">Expired</span>';
    }
    else {
        echo '<span class= "alert alert-success">Not Yet Expired</span>';
    }
}

?>
<h3 class="display-6">Task creted for this project</h3>




<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Task</th>
      <th scope="col">Budget</th>
      <th scope="col">Description</th>
      <th scope="col">Team</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($tasks as $task): ?>
    <tr>
      <th scope="row">1</th>
      <td><?= $task->title ?></td>
      <td><?= $task->budget ?></td>
      <td><?= $task->description ?></td>
      <td><?= $task->team->name?></td>

    </td>

    </tr>
    <?php endforeach; ?>
  </tbody>
</table>


     
       
   
</div>


        </div>
    </div>
</div>



