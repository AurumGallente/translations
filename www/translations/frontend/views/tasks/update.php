<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tasks */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Update Task: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Task', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tasks-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="tasks-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'language_direction_id')->textInput() ?>
        <?= $form->field($model, 'status')->textInput() ?>
        <?= $form->field($model, 'words')->textInput() ?>

        <div class="form-group">
            <label for="user_id">Assign user (optional):</label>
            <select name="user_id" class="form-control">
                <option value=""></option>
                <?php foreach($users as $user): ?>
                    <option <?= $user->id == $model->user_id ? "selected='selected'" : '' ?> value="<?= $user->id ?>"><?= $user->username ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>