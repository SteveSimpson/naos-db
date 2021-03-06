<?php

namespace app\controllers;

use Yii;
use app\models\db\Host;
use app\models\db\Location;
use app\models\db\Network;
use app\models\db\NetworkSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotAcceptableHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;


/**
 * NetworkController implements the CRUD actions for Network model.
 */
class NetworkController extends Controller
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
     * Lists all Network models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NetworkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->layout = "nagios";
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Network model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout = "nagios";
        
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Network model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Network();
        
        $this->layout = "nagios";

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $locations = [];
        foreach (Location::find()->all() as $location) {
            $locations[$location->location_name] = $location->location_name;
        }
        
        return $this->render('create', [
            'model' => $model,
            'locations' => $locations,
        ]);
    }

    /**
     * Updates an existing Network model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $this->layout = "nagios";

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            Host::updateAll(['network_name'=>$model->network_name],['network_name'=>$model->oldAttributes['network_name']]);
            
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        $locations = [];
        foreach (Location::find()->all() as $location) {
            $locations[$location->location_name] = $location->location_name;
        }

        return $this->render('update', [
            'model' => $model,
            'locations' => $locations,
        ]);
    }

    /**
     * Deletes an existing Network model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        
        if (Host::find()->where(['network_name'=>$model->network_name])->all()) {
            throw new NotAcceptableHttpException('Hosts exists with the Network.');
        }
        
        $model->delete();
        
        return $this->redirect(['index']);
    }

    public function actionNetDiagram($net, $format='html')
    {
        if ($format ==  'html') {
            $this->layout = "nagios";
            $html = true;
        } else {
            $this->layout = false;
            Yii::$app->response->format = Response::FORMAT_RAW;
            Yii::$app->response->headers->add('Content-Disposition', 'attachment; filename="hwlist.txt"');
            Yii::$app->response->headers->add('Content-Type', 'text/plain');
            $html=false;
        }
        $net = filter_var($net, FILTER_SANITIZE_STRING);
        
        $format = filter_var($format, FILTER_SANITIZE_STRING);
        
        $hosts = Host::find()->where(['hw_show'=>1, 'network_name'=>$net])->orderBy(['network_name'=>SORT_ASC,'hostname'=>SORT_ASC])->all();
        return $this->render('net-diagram',[
            'hosts'  => $hosts,
            'html' => $html,
            'format' => $format,
        ]);
    }
    
    /**
     * Finds the Network model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Network the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Network::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
