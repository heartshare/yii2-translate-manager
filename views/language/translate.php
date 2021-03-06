<?php
/**
 * @author Lajos Molnár <lajax.m@gmail.com>
 * @since 1.0
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use lajax\translatemanager\helpers\Language;

/* @var $this \yii\web\View */
/* @var $language_id integer */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel lajax\translatemanager\models\searches\LanguageSourceSearch */

$this->title = Yii::t('language', 'Translation into {language_id}', ['language_id' => $language_id]);;
$this->params['breadcrumbs'][] = ['label' => Yii::t('language', 'Languages'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>
<?= $this->title ?>
</h1>
    <?= Html::hiddenInput('language_id', $language_id, ['id' => 'language_id', 'data-url' => Yii::$app->urlManager->createAbsoluteUrl('/translatemanager/language/save')]); ?>
<div id="translates" class="<?= $language_id ?>">
    <?php
    Pjax::begin([
        'id' => 'translates'
    ]);
    echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'format' => 'text',
                    'filter' => Language::getCategories(),
                    'attribute' => 'category',
                    'filterInputOptions' => ['class' => 'form-control', 'id' => 'category'],
                ],
                [
                    'format' => 'text',
                    'attribute' => 'message',
                    'filterInputOptions' => ['class' => 'form-control', 'id' => 'message'],
                    'label' => Yii::t('language', 'Source'),
                    'content' => function ($data) {
                        return Html::activeTextarea($data, 'message', ['name' => 'LanguageSource[' . $data->id . ']', 'class' => 'form-control source', 'readonly' => 'readonly']);
                    },
                ],
                [
                    'format' => 'text',
                    'attribute' => 'translation',
                    'filterInputOptions' => ['class' => 'form-control', 'id' => 'translation'],
                    'label' => Yii::t('language', 'Translation'),
                    'content' => function ($data) {
                        return Html::activeTextarea($data, 'translation', ['name' => 'LanguageTranslate[' . $data->id . ']', 'class' => 'form-control translation', 'data-id' => $data->id, 'tabindex' => $data->id]);
                    },
                ],
                [
                    'format' => 'html',
                    'attribute' => Yii::t('language', 'Action'),
                    'content' => function ($data) {
                        return Html::button(Yii::t('language', 'Save'), ['type' => 'button', 'data-id' => $data['id'], 'class' => 'btn btn-lg btn-success']);
                    },
                ],
            ],
        ]);
        Pjax::end();
        ?>
</div>