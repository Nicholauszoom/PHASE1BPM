<?php

namespace app\controllers;

use app\models\Analysis;
use app\models\AnalysisSearch;
use app\models\Project;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * AnalysisController implements the CRUD actions for Analysis model.
 */
class AnalysisController extends Controller
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
     * Lists all Analysis models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AnalysisSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Analysis model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    // public function actionView($id)
    // {
    //     $project = Project::findOne($id);
    //     $tasks = $project->tasks;
        
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //         'tasks' => $tasks,
    //     ]);
    // }

    /**
     * Creates a new Analysis model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($projectId)
    {
        $model = new Analysis();

        $model->project = $projectId;

        // $details = Analysis::find()->all();
        
        
       //////////////
        $details = Analysis::find()
        ->where(['project' => $projectId])
        ->all();
    ///////////////
        
    //find and  calculate the  total amount of the each one  given project

//count project by user_id




// Find projects assigned 
$analysis = Analysis::find()
    ->where(['project' => $projectId])
    ->all();

// Calculate the total project budget for the assigned projects
$projectAmount = 0;
foreach ($analysis as $analysis) {
    $projectAmount += $analysis->cost;
}


    //end

    
        if ($this->request->isPost) {
            $model->load($this->request->post());
    
            // Create the upload directory if it doesn't exist
            $uploadDir = Yii::getAlias('@webroot/upload/');
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
    
            // Upload the files
            $files = UploadedFile::getInstances($model, 'files');
            if (!empty($files)) {
                $filePaths = [];
                foreach ($files as $file) {
                    $filePath = $uploadDir . $file->baseName . '.' . $file->extension;
                    if ($file->saveAs($filePath)) {
                        $filePaths[] = $filePath;
                    }
                }
                $model->files = implode(',', $filePaths);
            }
    
            // Upload the BOQ file
            $boqFile = UploadedFile::getInstance($model, 'boq');
            if ($boqFile !== null) {
                $boqFilePath = $uploadDir . $boqFile->baseName . '.' . $boqFile->extension;
                if ($boqFile->saveAs($boqFilePath)) {
                    $model->boq = $boqFilePath;
                }
            }
    
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }
    
        return $this->render('create', [
            'model' => $model,
            'details' => $details,
           'projectId' => $projectId,
           'projectAmount'=>$projectAmount,
        ]);
    }

    /**
     * Updates an existing Analysis model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            
        ]);
    }

    /**
     * Deletes an existing Analysis model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['#']);
    }

    /**
     * Finds the Analysis model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Analysis the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Analysis::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    
 
    public function actionOpenBoq($id)
    {
        // Find the details record based on the provided $id
        $details = Analysis::findOne($id);
    
        if (!$details) {
            throw new NotFoundHttpException('The requested details record does not exist.');
        }
    
        // Get the path to the BOQ file
        $boqFilePath = Yii::getAlias('@webroot/upload/') . $details->boq;
    
        // Check if the BOQ file exists
        if (!file_exists($boqFilePath)) {
            throw new NotFoundHttpException('The BOQ file does not exist.');
        }
    
        // Set the appropriate response headers
        Yii::$app->response->headers->set('Content-Type', 'application/pdf');
    
        // Read the file content
        $fileContent = file_get_contents($boqFilePath);
    
        // Send the file content as the response
        Yii::$app->response->sendContentAsFile($fileContent, $details->boq, ['inline' => true]);
    
        // Return the response to end the action
        return Yii::$app->response;
    }
    
}
