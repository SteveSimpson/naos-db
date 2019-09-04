<?php

namespace app\controllers;

use Yii;
use app\models\db\DnsCname;
use app\models\db\DnsCnameSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\db\Network;

/**
 * DnsCnameController implements the CRUD actions for DnsCname model.
 */
class DnsCnameController extends Controller
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
     * Lists all DnsCname models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DnsCnameSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $this->layout = "nagios";
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DnsCname model.
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
     * Creates a new DnsCname model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DnsCname();
        $this->layout = "nagios";

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        $domains = [];
        $nets = Network::find()->select(['dnsdomain'])->asArray(true)->orderBy(['dnsdomain'=>SORT_ASC])->all();
        foreach ($nets as $net) {
            $domains[$net['dnsdomain']] = $net['dnsdomain'];
        }
        

        return $this->render('create', [
            'model' => $model,
            'domains' => $domains,
        ]);
    }

    /**
     * Updates an existing DnsCname model.
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
        
        $domains = [];
        $nets = Network::find()->select(['dnsdomain'])->asArray(true)->orderBy(['dnsdomain'=>SORT_ASC])->all();
        foreach ($nets as $net) {
            $domains[$net['dnsdomain']] = $net['dnsdomain'];
        }

        return $this->render('update', [
            'model' => $model,
            'domains' => $domains,
        ]);
    }

    /**
     * Deletes an existing DnsCname model.
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
     * Finds the DnsCname model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DnsCname the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DnsCname::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
