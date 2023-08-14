<?php

namespace app\controllers;

use app\models\Project;
use app\models\Task;
use app\models\Team;

class DashboardController extends \yii\web\Controller
{
    public function actionAdmin()
    {
        //TOTAL SUCCESS TASK PER M | YEAR
        //retrieve the monthly and yearly success project counts from the database
    $monthlyCounts = Project::find()
    ->select(['MONTH(created_at) AS month', 'COUNT(*) AS count'])
    ->where(['status' => 1])
    ->groupBy(['month'])
    ->asArray()
    ->all();

$yearlyCounts = Project::find()
    ->select(['YEAR(created_at) AS year', 'COUNT(*) AS count'])
    ->where(['status' => 1])
    ->groupBy(['year'])
    ->asArray()
    ->all();

$chartData = [
    'labels' => [],
    'data' => [],
];

// Prepare the data for the chart
foreach ($monthlyCounts as $count) {
    $chartData['labels'][] = date('F', mktime(0, 0, 0, $count['month'], 1)); // Format the month name
    $chartData['data'][] = (int)$count['count'];
}

// Prepare the data for the yearly chart
foreach ($yearlyCounts as $count) {
    $chartData['labels'][] = $count['year'];
    $chartData['data'][] = (int)$count['count'];
}
      
//TOTAL FAIL TASK PER M | YEAR


    // Retrieve the monthly and yearly project counts with statuses other than 1 from the database
    $monthlyCounts = Project::find()
        ->select(['MONTH(created_at) AS month', 'COUNT(*) AS count'])
        ->where(['NOT', ['status' => 1]]) // Exclude projects with status 1
        ->groupBy(['month'])
        ->asArray()
        ->all();

    $yearlyCounts = Project::find()
        ->select(['YEAR(created_at) AS year', 'COUNT(*) AS count'])
        ->where(['NOT', ['status' => 1]]) // Exclude projects with status 1
        ->groupBy(['year'])
        ->asArray()
        ->all();

    $chartDatas = [
        'labels' => [],
        'data' => [],
    ];

    // Prepare the data for the chart
    foreach ($monthlyCounts as $count) {
        $chartDatas['labels'][] = date('F', mktime(0, 0, 0, $count['month'], 1)); // Format the month name
        $chartDatas['data'][] = (int)$count['count'];
    }

    // Prepare the data for the yearly chart
    foreach ($yearlyCounts as $count) {
        $chartDatas['labels'][] = $count['year'];
        $chartDatas['data'][] = (int)$count['count'];
    }

   


        $team= Team::find()->count();
        $total= Project::find()->count();
        $task= Task::find()->count();
        $successCount = Project::find()->where(['status' => 1])->count();
        $failCount = Project::find()->where(['status' => 2])->count();
        return $this->render('admin', [
            'successCount' => $successCount,
            'total' => $total,
            'fail' => $failCount,
            'task' => $task,
            'team'=>$team,
            'chartData' => $chartData,// this is for project successs
            'chartDatas' => $chartDatas, //this is for  project fail
            
        ]);
    }

}
