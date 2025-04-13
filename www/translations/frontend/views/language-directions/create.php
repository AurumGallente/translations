<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LanguageDirection */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Create Language Direction';
$this->params['breadcrumbs'][] = ['label' => 'Language Directions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="language-directions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="language-directions-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'language_from')->textInput() ?>
        <?= $form->field($model, 'language_to')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

