<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\LanguageDirection; // Ensure you've imported your model

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Create Task';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="task-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="task-form">

        <?php $form = ActiveForm::begin(); ?>


        <div class="form-group">
            <label for="language_direction_id">Language Direction:</label>
            <select name="language_direction_id" required class="form-control">
                <?php foreach($languageDirections as $direction): ?>
                    <option value="<?= $direction->id ?>"><?= $direction->getLanguagesFormatted() ?></option>
                <?php endforeach; ?>
            </select>
        </div>


        <div class="form-group">
            <label for="user_id">Assign user (optional):</label>
            <select name="user_id" class="form-control">
                <option value=""></option>
                <?php foreach($users as $user): ?>
                    <option value="<?= $user->id ?>"><?= $user->username ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="language_direction_id">Amount of words:</label>
            <input name="words" required type="number" class="form-control"/>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
