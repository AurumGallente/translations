<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Language */ // Adjust according to your actual model
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Update Language: ' . $model->name; // Assuming 'name' is a field in your model
$this->params['breadcrumbs'][] = ['label' => 'Languages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]]; // Adjust the viewing logic
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="language-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="language-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?> <!-- Language code field -->
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?> <!-- Language name field -->

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-danger']) ?> <!-- Button to cancel and go back to index -->
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

