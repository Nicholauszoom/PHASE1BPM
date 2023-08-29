<?php

namespace app\controllers;

use app\models\AuthAssignment;
use app\models\Project;
use app\models\ProjectSearch;
use app\models\Role;
use app\models\RoleUser;
use app\models\Task;
use app\models\User;
use app\models\Users;
use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use TCPDF;
use yii\helpers\FileHelper;
use yii\mail\MailerInterface;
use yii\helpers\Html;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }



    /**
     * Lists all Project models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('admin'))
        {


        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }else
    {
        throw new ForbiddenHttpException;
    }
    }


    //Project manager authentication on view projects 
    /**
     * Lists Project models by author/p.manager role.
     *
     * @return string
     */
    public function actionPm()
    {
        if(Yii::$app->user->can('author'))
        {
     // Get the logged-in user
    $userId = Yii::$app->user->id;

    // Find the assignments for the user with the "author" item_name
    // $assignments = AuthAssignment::find()
    //     ->where(['user_id' => $userId, 'item_name' => 'author'])
    //     ->all();

    // Retrieve the projects assigned to the user
    $projects = Project::find()
        ->where(['user_id' => $userId])
        ->all();

      

    return $this->render('pm', [
        'projects' => $projects,
        
    ]);
    }else
    {
        throw new ForbiddenHttpException;
    }
    }





    /**
     * Displays a single Project model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $project = Project::findOne($id);
        $tasks = $project->tasks;
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'tasks' => $tasks,
        ]);
    }


 
    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    
    

     
     public function actionCreate()
     {
         if (Yii::$app->user->can('admin')) {
             $model = new Project();
             $users = User::find()->all();
     
             if ($model->load(Yii::$app->request->post())) {
                 $model->ducument = UploadedFile::getInstance($model, 'ducument');
     
                 if ($model->validate()) {
                     // Save the uploaded PDF file and perform any other necessary actions
                     if ($model->ducument) {
                         $filePath = 'path/to/save/' . $model->ducument->name;
                         $model->ducument->saveAs($filePath);
                         $model->ducument = $filePath;
                     }

                  
                     // Assign the project manager ID from the selected user
                     $selectedProjectManager = Yii::$app->request->post('Project')['user_id'];
                     if (!empty($selectedProjectManager)) {
                         $model->user_id = $selectedProjectManager;
                         // Save the project
                         if ($model->save()) {
                             // Send an email to the assigned project user
                                     // Find the user with the same ID as the created_by ID in the project
                        $projectManagers = User::findOne(['id' => $model->created_by]);
                             $projectManager = User::findOne($selectedProjectManager);
                             if ($projectManager && !empty($projectManager->email)) {
                                 /** @var MailerInterface $mailer */
                                 $mailer = Yii::$app->mailer;
                                 $message = $mailer->compose()
                                     ->setFrom('nicholaussomi5@gmail.com')
                                     ->setTo($projectManager->email)
                                     ->setSubject('TeraTech Company')
                                     ->setHtmlBody('
                                     <html>
                                     <head>
                                         <style>
                                             /* CSS styles for the email body */
                                             body {
                                                 font-family: Arial, sans-serif;
                                                 background-color: #f4f4f4;
                                             }
                                 
                                             .container {
                                                 max-width: 600px;
                                                 margin: 0 auto;
                                                 padding: 20px;
                                                 background-color: #ffffff;
                                                 border: 1px solid #dddddd;
                                                 border-radius: 4px;
                                                 box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                                             }
                                 
                                             h1 {
                                                 color: blue;
                                                 text-align: center;

                                             }
                                           
                                 
                                             p {
                                                 color: #666666;
                                             }
                                 
                                             .logo {
                                                 text-align: center;
                                                 margin-bottom: 20px;
                                             }
                                 
                                             .logo img {
                                                 max-width: 200px;
                                             }
                                 
                                             .assigned-by {
                                                 font-weight: bold;
                                             }
                                 
                                             .button {
                                                 display: inline-block;
                                                 padding: 10px 20px;
                                                 background-color: #3366cc;
                                                 color: white;
                                                 text-decoration: none;
                                                 border-radius: 4px;
                                                 margin-top: 20px;
                                             }
                                 
                                             .button:hover {
                                                 background-color: #235daa;
                                             }
                                         </style>
                                     </head>
                                     <body>
                                         <div class="container">
                                             <div class="logo">
                                             <img src="https://teratechcomponents.com/wp-content/uploads/2011/06/Tera_14_screen-234x60.png" alt="teralogo">                                           </div>
                                             <h1>TERATECH ANNOUCEMENT</h1>
                                             <p>Dear ' . Html::encode($projectManager->username) . ',</p>
                                             <p>Your project has been assigned to you Please find the details below:</p>
                                             <ul>
                                                 <li>Project Name: ' . Html::encode($model->title) . '</li>
                                                 <li>Project Deadline: ' . Html::encode($model->end_at) . '</li>
                                                 <li>Assigned By: ' . Html::encode($projectManagers->username) . '</li>
                                             </ul>
                                             <p>If you have any questions or need further assistance, feel free to contact us.</p>
                                             <a href="http//localhost:8080/" class="button">View Project</a>
                                         </div>
                                     </body>
                                     </html>
                                 ');
                                     
                                 if ($model->ducument) {
                                     $message->attach($model->ducument);
                                 }
                                     
                                 $message->send();
                             }
                             return $this->redirect(['view', 'id' => $model->id]);
                         }
                     }
                 }
             } else {
                 $model->loadDefaultValues();
             }
     
             return $this->render('create', [
                 'model' => $model,
                 'users' => $users,
             ]);
         } else {
             throw new ForbiddenHttpException;
         }
     }

    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */

     public function actionUpdate($id)
     {
        $users= User::find()->all();
        if(Yii::$app->user->can('admin'))
        {
         $model = $this->findModel($id);
                     // Retrieve project manager role

     
         if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
             return $this->redirect(['view', 'id' => $model->id]);
         }
     
         return $this->render('update', [
             'model' => $model,
             'users'=>$users,
            
         ]);

        }else
        {
            throw new ForbiddenHttpException;
        }
     }
    // public function actionUpdate($id)
    // {
    //     if (Yii::$app->user->can('updateProject')) {
    //         $model = $this->findModel($id);

    //         if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
    //             return $this->redirect(['view', 'id' => $model->id]);
    //         }

    //         return $this->render('update', [
    //             'model' => $model,
    //         ]);
    //     } else {
    //         throw new \yii\web\ForbiddenHttpException('You are not allowed to update thisproject.');
    //     }
    // }


    /**
     * Deletes an existing Project model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // if(Yii::$app->user->can('admin'))
        // {

        if (Yii::$app->user->can('admin')) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
       
    }else
    {
        throw new ForbiddenHttpException;
    }
    }

    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    
    
}