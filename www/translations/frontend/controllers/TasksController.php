<?php

namespace frontend\controllers;

use common\models\LanguageDirection;
use Yii;
use common\models\Task;
use common\models\TaskSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\User;
use common\models\User as UserModel;

class TasksController extends Controller
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
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        $model = new Task();
        $languageDirections = LanguageDirection::find()->all();
        $users = UserModel::find()->all();

        if (Yii::$app->request->post()) {
            $model->words = Yii::$app->request->post('words');
            $model->language_direction_id = Yii::$app->request->post('language_direction_id');
            if(Yii::$app->request->post('user_id')){
                $model->user_id = Yii::$app->request->post('user_id');
                $model->status = Task::STATUS_IN_PROGRESS;
            }
            $model->status = Task::STATUS_WAITING;
            $model->save();

            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'languageDirections' => $languageDirections,
            'users' => $users
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $users = UserModel::find()->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if(Yii::$app->request->post('user_id')){
                $model->user_id = Yii::$app->request->post('user_id');
                $model->status = Task::STATUS_IN_PROGRESS;
            } else {
                $model->user_id = NUll;
            }
            $model->save();
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'users' => $users
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}