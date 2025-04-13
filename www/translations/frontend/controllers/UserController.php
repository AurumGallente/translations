<?php

namespace frontend\controllers;

use common\models\LanguageDirection;
use common\models\User;
use common\models\UserLanguageDirection;
use common\models\UserSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        //var_dump(Yii::$app->urlManager->createAbsoluteUrl(['user/update', 'id' => 8]));exit;
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $models = $dataProvider->getModels();
        //var_dump($dataProvider->getModels());exit;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'models' => $models,
            'jsonModels' => json_encode($models)
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $userLanguageDirections = ArrayHelper::getColumn($model->getUserLanguageDirections()->all(), 'language_direction_id');
        if ($model->load(Yii::$app->request->post())) {
            $selectedLanguageDirectionIds = Yii::$app->request
                ->post('languageDirections', []);
            $model->in_house = Yii::$app->request->post('in_house') ? 1 : 0;
            $model->freelancer = Yii::$app->request->post('freelancer') ? 1 : 0;

            $this->updateUserLanguageDirections($model->id, $selectedLanguageDirectionIds);
            if($model->save()){
                return $this->redirect(['index', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'userLanguageDirectionIds' => $userLanguageDirections,
        ]);
    }

    public function actionDelete($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    protected function updateUserLanguageDirections($userId, $selectedIds)
    {
        UserLanguageDirection::deleteAll(['user_id' => $userId]);

        foreach ($selectedIds as $id) {
            $userLanguageDirection = new UserLanguageDirection();
            $userLanguageDirection->user_id = $userId;
            $userLanguageDirection->language_direction_id = $id;
            $userLanguageDirection->speed = 1;
            $userLanguageDirection->save();
        }
    }


}