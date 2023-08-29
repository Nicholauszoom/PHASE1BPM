<?php

use app\models\Project;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\i18n\Formatter;

/** @var yii\web\View $this */
/** @var app\models\ProjectSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
// $this->context->layout = 'admin';
$this->title = 'Projects-pm';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin';
$currentUrl = Url::toRoute(Yii::$app->controller->getRoute());
$this->registerCssFile('https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
$this->registerJsFile('https://code.jquery.com/ui/1.12.1/jquery-ui.js');

// Define an array of sidebar items with their URLs and labels
$sidebarItems = [
    ['url' => ['/dashboard/admin'], 'label' => 'Home', 'icon' => 'bi bi-house'],
    ['url' => ['/project'], 'label' => 'Projects', 'icon' => 'bi bi-layers'],
    ['url' => ['/task'], 'label' => 'Task', 'icon' => 'bi bi-check2-square'],
    ['url' => ['/team'], 'label' => 'Team', 'icon' => 'bi bi-people'],
    ['url' => ['/member'], 'label' => 'Member', 'icon' => 'bi bi-person'],
    ['url' => ['/report'], 'label' => 'Report', 'icon' => 'bi bi-file-text'],
    ['url' => ['/setting'], 'label' => 'Settings', 'icon' => 'bi bi-gear'],
];
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
       
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
    
                
    'dataProvider' => new \yii\data\ArrayDataProvider([
        'allModels' => $projects,
        'pagination' => [
            'pageSize' => 10, // Adjust the page size as per your requirement
        ],
    ]),
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        'title',
        'budget',
                    
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
            'attribute' => 'created_at',
            'value' => function ($model) {
                return Yii::$app->formatter->asDatetime($model->created_at);
            },
        ],
        // [
        //     'class' => ActionColumn::className(),
        //     'urlCreator' => function ($action, Project $model, $key, $index, $column) {
        //         return Url::toRoute([$action, 'id' => $model->id]);
        //     }
        // ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{create-analysis} {view} {update} {delete}',
            'buttons' => [
                'create-analysis' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-file"></span>', ['analysis/create', 'projectId' => $model->id], [
                        'class' => 'btn btn-success',
                        'title' => 'Create Analysis',
                        'aria-label' => 'Create Analysis',
                    ]);
                },
            ],
        ],
        // Additional columns if needed
    ],
]); ?>


<?php
function getStatusLabel($status)
{
    $statusLabels = [
        1 => '<span class="badge badge-success">Active</span>',
        2 => '<span class="badge badge-warning">Inactive</span>',
        3 => '<span class="badge badge-secondary">On Hold</span>',
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