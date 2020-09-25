<?php

namespace app\controllers;

use Yii;
use app\models\db\FwConfig;
use app\models\db\FwConfigSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\db\Pps;
use app\models\db\FwApp;
use app\models\db\FwAppSet;
use app\models\db\FwAddresses;

/**
 * PpsController implements the CRUD actions for FwConfig model.
 */
class PpsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all FwConfig models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FwConfigSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->layout = "nagios";
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FwConfig model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        
        $pps = Pps::find()->where(['fw_name'=>$model->fw_name])->one();
        
        $this->layout = "nagios";
        
        return $this->render('view', [
            'model' => $model,
            'pps' => $pps,
        ]);
    }

    /**
     * Creates a new FwConfig model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FwConfig();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        $this->layout = "nagios";

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing FwConfig model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $this->layout = "nagios";
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
    public function actionShow($name)
    {
        $policies = Pps::find()->where(['fw_name'=>$name])->orderBy(['source_zone'=>SORT_ASC,'destination_zone'=>SORT_ASC,'line'=>SORT_ASC])->all();
        
        if ($policies == false || count($policies) == 0) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        
        $this->layout = "nagios";

        return $this->render('show', [
            'apps'=>FwApp::find()->where(['fw_name'=>$policies[0]->fw_name])->all(),
            'appSets'=>FwAppSet::find()->where(['fw_name'=>$policies[0]->fw_name])->all(),
            'policies' => $policies,
            'addresses' => FwAddresses::find()->where(['fw_name'=>$policies[0]->fw_name])->orderBy(['fw_zone'=>SORT_ASC,'name'=>SORT_ASC,'ip'=>SORT_ASC])->all(),
        ]);
    }
    
    
    public function actionRules($name)
    {   
        $sources = Pps::find()->asArray(true)->distinct(true)->select(['source_zone','fw_name'])
        ->where(['fw_name'=>$name])
        ->andWhere(['<>', 'source_zone', ''])
        ->orderBy(['source_zone'=>SORT_ASC])
        ->all();
        
        $destinations = Pps::find()->asArray(true)->distinct(true)->select(['destination_zone'])
        ->where(['fw_name'=>$name])
        ->andWhere(['<>', 'destination_zone', ''])
        ->orderBy(['destination_zone'=>SORT_ASC])
        ->all();
        
        
        $policies = [];
        $sourcesSelected = [];
        $destinationsSelected = [];
        $applicationFilter = false;
        $sourceFilter = false;
        $desintationFilter = false;
        
        if(Yii::$app->request->isPost && Yii::$app->request->validateCsrfToken() 
        && isset(Yii::$app->request->post()['sources']) && isset(Yii::$app->request->post()['desintations'])) {
                
            //echo "<pre>";
            //print_r(Yii::$app->request->post());
            //die();
            
            $sourcesSelected = Yii::$app->request->post()['sources'];
            $destinationsSelected = Yii::$app->request->post()['desintations'];
           
            $policiesQuery = Pps::find()->where(['fw_name'=>$name])
            ->andWhere(['source_zone' => $sourcesSelected])
            ->andWhere(['destination_zone' => $destinationsSelected])
            ->orderBy(['source_zone'=>SORT_ASC,'destination_zone'=>SORT_ASC,'line'=>SORT_ASC]);
            
            if(isset(Yii::$app->request->post()['applicationFilter']) && strlen(Yii::$app->request->post()['applicationFilter']) >= 1) {
                $applicationFilter = Yii::$app->request->post()['applicationFilter'];
                $policiesQuery->andWhere(['like', 'application', $applicationFilter]);
            }
            
            if(isset(Yii::$app->request->post()['sourceFilter']) && strlen(Yii::$app->request->post()['sourceFilter']) >= 1) {
                $sourceFilter = Yii::$app->request->post()['sourceFilter'];
                $policiesQuery->andWhere(['like', 'source_address', $sourceFilter]);
            }
            
            if(isset(Yii::$app->request->post()['desintationFilter']) && strlen(Yii::$app->request->post()['desintationFilter']) >= 1) {
                $desintationFilter = Yii::$app->request->post()['desintationFilter'];
                $policiesQuery->andWhere(['like', 'destination_address', $desintationFilter]);
            }
            
            $policies = $policiesQuery->all();
        } 
        
        $this->layout = "nagios";
        
        return $this->render('rules', [
            'post' => Yii::$app->request->isPost,
            'sources'=>$sources,
            'destinations'=>$destinations,
            'sourcesSelected'=>$sourcesSelected,
            'destinationsSelected'=>$destinationsSelected,
            'applicationFilter'=> $applicationFilter,
            'sourceFilter' => $sourceFilter,
            'desintationFilter'=> $desintationFilter,
            'policies'=>$policies,
        ]);
    }

    /**
     * Deletes an existing FwConfig model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FwConfig model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FwConfig the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FwConfig::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
