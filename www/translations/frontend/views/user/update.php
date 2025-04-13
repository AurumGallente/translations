<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\LanguageDirection;


/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */


$this->title = 'Update User: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <label for="languageDirections">Select Language Directions</label>
            <select class="form-control" id="languageDirections" name="languageDirections[]" multiple>
                <?php foreach(LanguageDirection::find()->all() as $languageDirection): ?>
                    <option value="<?= $languageDirection->id ?>"
                    <?php  if(in_array($languageDirection->id, $userLanguageDirectionIds)): ?>
                        selected="selected"
                    <?php  endif ?>
                    >
                        <?= $languageDirection->getLanguagesFormatted() ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <div class="form-check">
            <label for="in_house">In House?</label>
            <input class="form-check-input" type="checkbox" id="in_house" name="in_house" <?= $model->in_house ? "checked" : ''; ?>>
        </div>

        <div class="form-check">
            <label for="freelancer">Is Freelancer?</label>
            <input class="form-check-input" type="checkbox" id="freelancer" name="freelancer" <?= $model->freelancer ? "checked" : ''; ?>>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
