<?php
    // Get the current route URL

use yii\helpers\Url;

   // Get the current route URL
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
/** @var yii\web\View $this */

$this->title = 'My Yii Application';

$this->context->layout = 'admin';
?>
<div id="logo">
        <span class="big-logo">BPM System</span>
        
    </div>

    <div id="left-menu">
    <ul>
        <?php foreach ($sidebarItems as $sidebarItem): ?>
            <li class="<?= Url::toRoute($sidebarItem['url']) === $currentUrl ? 'active' : '' ?>">
                <a href="<?= Url::to($sidebarItem['url']) ?>">
                    <i class="<?= $sidebarItem['icon'] ?>"></i>
                    <span><?= $sidebarItem['label'] ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
    <div id="main-content">
        <div id="header">
            <div class="header-left float-left">
                <i id="toggle-left-menu" class="ion-android-menu"></i>
            </div>
            <div class="header-right float-right">
                <i class="ion-ios-people"></i>
            </div>
        </div>

        <div id="page-container">
        
          <!-- ============================================================== -->
          <!-- Sales Cards  -->
          <!-- ============================================================== -->
          <div class="row">

<!-- Column -->
<div class="col-md-6 col-lg-4 col-xlg-3">
    <div class="card card-hover">
        <div class="box bg-success text-center">
            <h1 class="font-light text-white">
                <i class="bi bi-layers"></i>
            </h1>
            <h6 class="text-white">Total Tender</h6>
            <h3 class="text-white"><?= $total ?></h3>
        </div>
    </div>
</div>
<!-- Column -->

<!-- Column -->
<div class="col-md-6 col-lg-4 col-xlg-3">
    <div class="card card-hover">
        <div class="box bg-task text-center">
            <h1 class="font-light text-white">
                <i class="bi bi-check2-square"></i>
            </h1>
            <h6 class="text-white">Total Task</h6>
            <h3 class="text-white"><?=$task?></h3>
        </div>
    </div>
</div>
<!-- Column -->

<!-- Column -->
<div class="col-md-6 col-lg-4 col-xlg-3">
    <div class="card card-hover">
        <div class="box bg-blue text-center"> <!-- Update the class to "bg-blue" -->
            <h1 class="font-light text-white">
                <i class="bi bi-people"></i>
            </h1>
            <h6 class="text-white">Team</h6>
            <h3 class="text-white"><?=$team?></h3></h3>
        </div>
    </div>
</div>

<div class="col-md-6 col-lg-4 col-xlg-3">
    <div class="card card-hover">
        <div class="box bg-complete text-center"> <!-- Update the class to "bg-blue" -->
            <h1 class="font-light text-white">
                <i class="bi bi-shield-check"></i>
            </h1>
            <h6 class="text-white">Complete Tender</h6>
            <h3 class="text-white"><?= $successCount ?></h3>
        </div>
    </div>
</div>

<div class="col-md-6 col-lg-4 col-xlg-3">
    <div class="card card-hover">
        <div class="box bg-fail text-center"> <!-- Update the class to "bg-blue" -->
            <h1 class="font-light text-white">
                <i class="bi bi-shield-fill-exclamation"></i>
            </h1>
            <h6 class="text-white">Fail Tender</h6>
            <h3 class="text-white"><?= $fail?></h3>
        </div>
    </div>
</div>


<!-- Column -->
<div class="col-md-6 col-lg-4 col-xlg-3">
    <div class="card card-hover">
        <div class="box bg-employee text-center">
            <h1 class="font-light text-white">
                <i class="bi bi-person"></i>
            </h1>
            <h6 class="text-white">Employee</h6>
            <h3 class="text-white">100</h3>
        </div>
    </div>
</div>
<!-- Column -->
<div>
    <center>
<h3 class="align-text-center mt-10 mr-20">
 Graph of Complete Tender per Moth|Year
</h3></center>
<!-- Add the canvas element where the graph will be rendered -->
<canvas id="projectChart"></canvas>

<!-- Include the Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Create a script block to define and render the graph -->
<script>
    // Retrieve the data for the chart from the server
    var chartData = <?= json_encode($chartData) ?>; // $chartData should be an array of data containing monthly and yearly counts

    // Create a new Chart instance
    var ctx = document.getElementById('projectChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Total Success Projects',
                data: chartData.data,
                backgroundColor: 'rgba(75, 192, 192, 0.5)', // Customize the bar background color
                borderColor: 'rgba(75, 192, 192, 1)', // Customize the bar border color
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>






<center>
<h3 class="align-text-center mt-10 mr-20">
 Graph of Incomplete Tender per Moth|Year
</h3></center>
<!-- Add the canvas element where the graph will be rendered -->
<canvas id="projectCharts"></canvas>

<!-- Include the Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Create a script block to define and render the graph -->
<script>
    // Retrieve the data for the chart from the server
    var chartDatas = <?= json_encode($chartDatas) ?>; // $chartData should be an array of data containing monthly and yearly counts

    // Create a new Chart instance
    var ctx = document.getElementById('projectCharts').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartDatas.labels,
            datasets: [{
                label: 'Total Fail Projects',
                data: chartDatas.data,
                backgroundColor: 'rgba(255, 99, 132, 0.5)', // Customize the bar background color
                borderColor: 'rgba(255, 99, 132, 1)', // Customize the bar border color
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>

</div>

</div>

</div>
</div>
    <span id="show-lable">Hello</span>


    