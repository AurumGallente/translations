<?php

namespace frontend\controllers;

use common\models\Language;
use common\models\UserLanguageDirection;
use Yii;
use common\models\LanguageDirection;
use common\models\LanguageDirectionsSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class LanguageDirectionsController extends Controller
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
        $searchModel = new LanguageDirectionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $languages = Language::find()->select(['id', 'name'])->asArray()->all();
        $langOptions = ArrayHelper::map($languages, 'id', 'name');
        $model = new LanguageDirection();
        $errors = Yii::$app->session->getFlash('errors');
        $languageDirections = LanguageDirection::find()->all();
        $dataDirectionsProvider = new ActiveDataProvider([
            'query' => LanguageDirection::find()->with(['languageFrom', 'languageTo']),
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'langOptions' => $langOptions,
            'model' => $model,
            'dataDirectionsProvider' => $dataDirectionsProvider,
            'languageDirections' => $languageDirections,
            'errors' => $errors,
        ]);
    }

    public function actionCreate()
    {
        $model = new LanguageDirection();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        Yii::$app->session->setFlash('errors', $model->getErrors());
        return $this->redirect(['index']);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = LanguageDirection::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}