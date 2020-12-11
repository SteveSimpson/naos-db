<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\NotAcceptableHttpException;
use yii\filters\VerbFilter;
use app\models\Nagios;


class NagiosController extends Controller
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
                ],
            ],
        ];
    }
    
    public function actionMenu()
    {
        return $this->renderPartial('menu', [
            'model' => Nagios::menuItems(),
        ]);
    }
    
    public function actionSearch()
    {
        return $this->renderPartial('search', [
        ]);
    }
    
    public function actionTop()
    {
        return $this->renderPartial('top',[
            'logoImage' => (array_key_exists('logoImage', Yii::$app->params) ? Yii::$app->params['logoImage'] : false),
            'logoText' => (array_key_exists('logoText', Yii::$app->params) ? Yii::$app->params['logoText'] : false),
        ]);
    }
}