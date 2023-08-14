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
$this->context->layout = 'admin';
$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;

$currentUrl = Url::toRoute(Yii::$app->controller->getRoute());

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
<div id="logo">
    <span class="big-logo">BPM System</span>
    <h3><?= Html::encode($this->title) ?></h3>
</div>

<div id="left-menu">
    <ul>
        <?php foreach ($sidebarItems as $sidebarItem): ?>
            <li class="<?= Url::to($sidebarItem['url']) === $currentUrl ? 'active' : '' ?>">
                <a href="<?= Url::to($sidebarItem['url']) ?>">
                    <i class="<?= $sidebarItem['icon'] ?>"></i>
                    <span><?= $sidebarItem['label'] ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>


<div id="main-content ">
   
    <div id="page-container">
        <!-- ============================================================== -->
        <!-- Sales Cards  -->
        <!-- ============================================================== -->
        <div class="row"></div>
            <p>
                <?= Html::a('Create Project', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'id',
                    'title',
                    // 'description:ntext',
                    'budget',
                    
                    [
                        'attribute' => 'created_at',
                        'value' => function ($model) {
                            return Yii::$app->formatter->asDatetime($model->created_at);
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
                    //'updated_at',
                    //'created_by',
                    //'ducument',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, Project $model, $key, $index, $column) {
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