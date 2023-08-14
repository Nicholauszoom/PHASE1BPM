<?php

use app\models\Task;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TaskSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tasks';
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

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
</p>

<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="table-responsive"> <!-- Add a container div with "table-responsive" class -->
<?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-striped table-bordered', 'style' => 'width: 80%;'], // Add custom CSS styles to the table// Add custom CSS classes to the table
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'budget',
            [
                'attribute' => 'project_id',
                'value' => 'project.title',
            ],
            [
                'attribute' => 'team_id',
                'value' => 'team.name',
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDateTime($model->created_at, 'medium'); // Change the time format
                },
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return getStatusLabel($model->status);
                },
                'format' => 'raw',
                'contentOptions' => function ($model) {
                    return ['class' => getStatusClass($model->status)];
                },
            ],
            
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Task $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

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
?>

</div>

</div>
</div>
</div>
</div>