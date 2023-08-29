<?php

namespace app\controllers;

use app\models\Project;
use app\models\Task;
use app\models\Team;
use yii\helpers\Json;
use Yii;

class DashboardController extends \yii\web\Controller
{
    public function actionAdmin()
    {

        //count project by user_id
        $userId = Yii::$app->user->id;
        $projectCount = Project::find()
            ->where(['user_id' => $userId])
            ->all();
     
// Calculate the assigned project budget for given project manager
$projectBudget = array_sum( $projectCount);


        // Query the project table to fetch the budget values
$budgets = Project::find()->select('budget')->column();

// Calculate the total budget
$totalBudget = array_sum($budgets);
//TOTAL BUDGET  PER PROJECT IN YEAR
$data = Project::find()
    ->select([new \yii\db\Expression('EXTRACT(YEAR FROM created_at) AS year'), 'SUM(budget) AS total_budget'])
    ->groupBy(['EXTRACT(YEAR FROM created_at)'])
    ->asArray()
    ->all();

    $formattedData = [];
    foreach ($data as $item) {
        $formattedData[] = [
            'year' => (int)$item['year'],
            'total_budget' => (float)$item['total_budget'],
        ];
    }

    $chartDataSS = Json::encode($formattedData);



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
        //->where(['NOT', ['status' => 1]]) // Exclude projects with status 1
        ->where(['status' => 2])
        ->groupBy(['month'])
        ->asArray()
        ->all();

    $yearlyCounts = Project::find()
        ->select(['YEAR(created_at) AS year', 'COUNT(*) AS count'])
        // ->where(['NOT', ['status' => 1]]) // Exclude projects with status 1
        ->where(['status' => 2])
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
            'totalBudget'=>$totalBudget, //TOTAL BUDGET
            'data' => $chartDataSS ,// DATA FOR LINE CHART FOR BUDGET PER YEAR
            'projectCount '=> $projectCount ,//count all projects assigned to a project manager
            'projectBudget'=>$projectBudget,
            
        ]);
    }

}
