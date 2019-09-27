<?php

namespace app\controllers;

use Yii;
use app\models\db\Host;
use app\models\db\HostSearch;
use app\models\db\Location;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\db\Network;
use app\models\db\DnsCname;

/**
 * HostController implements the CRUD actions for Host model.
 */
class HostController extends Controller
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
     * Lists all Host models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $this->layout = "nagios";
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Host model.
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
     * Creates a new Host model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "nagios";
        
        $model = new Host();


        if ($model->load(Yii::$app->request->post())) {
            $net = Network::find()->where(['network_name'=>$model->network_name])->one();
            
            //echo "<pre>"; print_r(Yii::$app->request->post()); die();
            
            if ($net) {
                $model->fqdn = trim($model->hostname) . "." . trim($net->dnsdomain);
                $model->location_name = $net->location_name;
                $model->ipv4 = trim($net->prefix4, " .") . "." . $model->host_ip_last;
                $model->ipv6 = trim($net->prefix6) . $model->host_ip_last;
                $model->mask4 = $net->mask4;
                $model->mask6 = $net->mask6;
                $model->monitor_ip = $model->ipv4;
                $model->enabled = 1;
            }
            
            if($model->save()) {
                if (array_key_exists('anthor',Yii::$app->request->post()) && Yii::$app->request->post()['another'] == 'yes') {
                    return $this->redirect(['create']);
                } else {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }
        
        $networks = [];
        foreach (Network::find()->all() as $network) {
            $networks[$network->network_name] = $network->network_name;
        }

        return $this->render('create', [
            'model' => $model,
            'networks' => $networks,
        ]);
    }

    /**
     * Updates an existing Host model.
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
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        $locations = [];
        foreach (Location::find()->all() as $location) {
            $locations[$location->location_name] = $location->location_name;
        }
        
        $networks = [];
        foreach (Network::find()->all() as $network) {
            $networks[$network->network_name] = $network->network_name;
        }

        return $this->render('update', [
            'model' => $model,
            'locations' => $locations,
            'networks' => $networks,
        ]);
    }

    /**
     * Deletes an existing Host model.
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
    
    public function actionEtcHosts()
    {
        $hosts = Host::find()->select(['hostname','network_name','fqdn','ipv4', 'ipv6'])->orderBy(['network_name'=>SORT_ASC,'ipv4'=>SORT_ASC])->asArray(true)->all();
        
        $this->layout = false;
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'text/plain');
        
        return $this->render('etc-hosts', [
            'hosts' => $hosts,
        ]);
    }
    
    public function actionZones()
    {
        $hosts = Host::find()->select(['hostname','network_name','fqdn','ipv4', 'ipv6'])->orderBy(['network_name'=>SORT_ASC,'ipv4'=>SORT_ASC])->asArray(true)->all();
        
        $this->layout = false;
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'text/plain');
        
        $cnames = DnsCname::find()->asArray(true)->all();
        
        $nets = Network::find()->asArray(true)->all();
        
        return $this->render('zones', [
            'hosts'  => $hosts,
            'cnames' => $cnames,
            'nets'   => $nets,
        ]);
    }
    
    public function actionCheckList($format='html')
    {
        $this->layout = false;
        $hosts = Host::find()->select(['fqdn'])->orderBy(['fqdn'=>SORT_ASC])->asArray(true)->all();
        Yii::$app->response->format = Response::FORMAT_RAW;
        
        if ($format != 'html') {
            $format == 'text';
            Yii::$app->response->headers->add('Content-Type', 'text/plain');
        }
        
        return $this->render('check-list',[
            'hosts'  => $hosts,
            'format' => $format,
        ]);
    }

    /**
     * Finds the Host model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Host the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Host::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
