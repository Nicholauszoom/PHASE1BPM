<?php
    // Get the current route URL

use yii\helpers\Url;
use app\models\Project;

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



   <!-- top tiles -->

<div class="row justify-content-center">
  <div class="tile_count">

  <!-- /admin dash  -->
  <?php if (Yii::$app->user->can('admin')) : ?>
          
        
    <div class="col-md-2 col-sm-4 tile_stats_count">
      <span class="count_top"><i class="fa fa-clone"></i> Total Projects</span>
      <div class="count"><?= $total ?></div>
      <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i></i> </span>
    </div>
   
   <div class="col-md-2 col-sm-4 tile_stats_count">
      <span class="count_top"><i class="fa fa-users"></i> Team </span>
      <div class="count "><?=$team?></div>
      <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i></i> </span>
    </div> 


    <div class="col-md-2 col-sm-4 tile_stats_count">
      <span class="count_top"><i class="fa fa-check"></i> Complete Projects</span>
      <div class="count "><?= $successCount ?></div>
      <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i></i></span>
    </div>


    <div class="col-md-2 col-sm-4 tile_stats_count">
      <span class="count_top"><i class="fa fa-close"></i> Fail Projects</span>
      <div class="count "><?= $fail?></div>
      <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i></i> </span>
    </div>


    <div class="col-md-2 col-sm-6 tile_stats_count">
  <span class="count_top"><i class="fa fa-money"></i>Total Projects Budget</span>
  <div class="">
    TSH <?=$totalBudget ?>
  </div>
  <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i></i></span>
</div>
<?php endif; ?>
<!-- /admin dash end -->

<!-- /Project Manager Dashboard -->
<?php if (Yii::$app->user->can('author')) : ?>
      
<div class="col-md-2 col-sm-4 tile_stats_count">
      <span class="count_top"><i class="fa fa-clone"></i> Assigned Project</span>
      <?php
        $userId = Yii::$app->user->getId();
        $projectCount = Project::find()
            ->where(['user_id' => $userId])
            ->count();
        ?>
        <div class="count"><?= $projectCount ?></div>
      <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i></i> </span>
    </div>

    <div class="col-md-2 col-sm-4 tile_stats_count">
    <?php
        $userId = Yii::$app->user->getId();
        $projectSuccess = Project::find()
            ->where(['user_id' => $userId])
            ->andWhere(['status' => 1])
            ->count();
        ?>
      <span class="count_top"><i class="fa fa-check"></i> Complete Project</span>
      <div class="count "><?=$projectSuccess?></div>
      <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i></i></span>
    </div>

    <div class="col-md-2 col-sm-4 tile_stats_count">
    <?php
        $userId = Yii::$app->user->getId();
        $projectHold = Project::find()
            ->where(['user_id' => $userId])
            ->andWhere(['status' => 3])
            ->count();
        ?>
      <span class="count_top"><i class="fa fa-check"></i> Projects OnHold</span>
      <div class="count "><?=$projectHold?></div>
      <span class="count_bottom"><i class="warning" style="color:yellow"> <i class="fa fa-sort-asc"></i></i></span>
    </div>

    <div class="col-md-2 col-sm-4 tile_stats_count">
    <?php
$userId = Yii::$app->user->getId();

// Count failed projects for the logged-in user
$projectFail = Project::find()
    ->where(['user_id' => $userId])
    ->andWhere(['status' => 2])
    ->count();
?>
      <span class="count_top"><i class="fa fa-close"></i> Fail Project</span>
      <div class="count "><?=$projectFail?></div>
      <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i></i> </span>
    </div>


    <div class="col-md-2 col-sm-6 tile_stats_count">

    <?php
$userId = Yii::$app->user->getId();

// Find projects assigned to the user
$projects = Project::find()
    ->where(['user_id' => $userId])
    ->all();

// Calculate the total project budget for the assigned projects
$projectBudget = 0;
foreach ($projects as $project) {
    $projectBudget += $project->budget;
}
?>
  <span class="count_top"><i class="fa fa-money"></i>Projects Budget</span>
  <div class="">
    <?=$projectBudget?>
  </div>
  <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i></i></span>
</div>
<?php endif; ?>
<!-- /pm end -->
  </div>
</div>
          <!-- /top tiles -->
       
           
          <div class="row">
            <div class="col-md-12 col-sm-12 ">
              <div class="dashboard_graph">

                <div class="row x_title">
                  <div class="col-md-6">
                   
                  

                  </div>
                  <div class="col-md-6">
                   
                  </div>
                </div>
                <?php if (Yii::$app->user->can('admin')) : ?>
                <div class="col-md-9 col-sm-9 ">
                  <div id="chart_plot_01" class="demo-placeholder"></div>
                </div>
              
                <div class="col-md-3 col-sm-3  bg-white">
                  <div class="x_title">

                  <h6 class="align-text-center mt-10 mr-20">
 Graph of Complete Tender per Moth|Year
</h6>
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

                   
                    <h6 class="align-text-center mt-10 mr-20">
 Graph of Incomplete Tender per Moth|Year
</h6>
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
               
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
               
                <canvas id="chart"></canvas>

<script>
    var data = <?= $data ?>;

    // Prepare the data for the chart
    var labels = data.map(item => item.year);
    var values = data.map(item => item.total_budget);

    // Create the chart
    var ctx = document.getElementById('chart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Budget',
                data: values,
                backgroundColor: 'blue'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<?php endif; ?>

                <div class="clearfix"></div>
              </div>
            </div>

          </div>
          <br />

       


     
           


             
                

 