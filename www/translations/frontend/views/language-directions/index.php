<?php

use common\models\LanguageDirection;
use common\models\Task;
use common\models\UserLanguageDirection;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

function getMinutesUntilWeekend() {
    $currentDateTime = new DateTime();
    $currentDay = (int)$currentDateTime->format('w');

    if ($currentDay === 6) {
        if ($currentDateTime->format('H') === '00' && $currentDateTime->format('i') === '00') {
            $daysUntilSaturday = 7;
        } else {
            $daysUntilSaturday = 7;
        }
    } else {
        $daysUntilSaturday = (6 - $currentDay);
    }

    $nextSaturday = clone $currentDateTime;
    $nextSaturday->modify("+$daysUntilSaturday days");
    $nextSaturday->setTime(0, 0);

    $interval = $currentDateTime->diff($nextSaturday);
    $minutesUntilSaturday = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;

    $nextSunday = clone $nextSaturday;
    $nextSunday->modify("+1 day");
    $intervalToSunday = $currentDateTime->diff($nextSunday);
    $minutesUntilSunday = ($intervalToSunday->days * 24 * 60) + ($intervalToSunday->h * 60) + $intervalToSunday->i;

    return $minutesUntilSaturday + $minutesUntilSunday;
}

?>

<h1><?= Html::encode($this->title) ?></h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <strong>Validation Errors:</strong>
        <ul>
            <?php foreach ($errors as $attribute => $errorList): ?>
                <li><?php echo htmlspecialchars($attribute) . ': ' . implode(', ', $errorList); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="language-directions-form">
    <?php $form = ActiveForm::begin(['action' => ['language-directions/create']]); ?>

    <?= $form->field($model, 'language_from')->dropDownList($langOptions, ['prompt' => 'Select Language From']) ?>

    <?= $form->field($model, 'language_to')->dropDownList($langOptions, ['prompt' => 'Select Language To']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>


<div class="language-directions-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataDirectionsProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'language_from',
                'label' => 'Language From',
                'value' => function ($model) {
                    return $model->languageFrom->name;
                },
            ],
            [
                'attribute' => 'language_to',
                'label' => 'Language To',
                'value' => function ($model) {
                    return $model->languageTo->name;
                },
            ],

            [
                'attribute' => 'Capacity',
                'label' => 'Capacity',
                'value' => function ($model) {
                    $sum = 0;

                     $sum+= UserLanguageDirection::find()->joinWith('user')
                        ->where(['language_direction_id'=> $model->id])
                             ->andWhere(['in_house'=> 1])
                        ->sum('speed') * getMinutesUntilWeekend();

                    $sum+= UserLanguageDirection::find()->joinWith('user')
                            ->where(['language_direction_id'=> $model->id])
                            ->andWhere(['freelancer'=> 1])
                            ->sum('speed') * 2880;

                     return $sum;
                },
            ],
            [
                'attribute' => 'Load',
                'label' => 'Load',
                'value' => function ($model) {
                    return (int) $model->getTasks()->where(['status' => Task::STATUS_WAITING])->sum('words');
                },
            ],

            [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => ''
            ],
        ],
    ]); ?>

</div>
