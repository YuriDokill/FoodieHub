<?php

namespace app\controllers;

use app\models\Expense;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Event;
use yii\filters\VerbFilter;
use Yii;
use app\models\User;
use app\models\Task;
use yii\mpdf\Pdf;
use app\models\ExpenseSearch;

/**
 * ExpenseController implements the CRUD actions for Expense model.
 */
class ExpenseController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Expense models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ExpenseSearch(); // Добавляем модель поиска
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel, // Передаем в представление
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Expense model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Expense model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Expense(); // Исправлено с Task на Expense
        $model->event_id = Yii::$app->request->get('event_id');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['event/view', 'id' => $model->event_id]);
        }

        $categories = ['Питание', 'Аренда', 'Материалы', 'Транспорт']; // Категории расходов
        return $this->render('create', [
            'model' => $model,
            'events' => Event::find()->all(),
            'categories' => $categories
        ]);
    }

    /**
     * Updates an existing Expense model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Expense model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

   public function actionExportPdf($event_id)
    {
        $event = Event::findOne($event_id);
        if (!$event) {
            throw new NotFoundHttpException('Событие не найдено');
        }

        $expenses = Expense::find()->where(['event_id' => $event_id])->all();
        $total = Expense::find()->where(['event_id' => $event_id])->sum('amount');

        // Генерируем HTML
        $html = $this->renderPartial('pdf_report', [
            'event' => $event,
            'expenses' => $expenses,
            'total' => $total
        ]);

        // Возвращаем HTML, который пользователь может сохранить как PDF через браузер
        return $html;
    }

    public function actionExportExcel($event_id)
    {
        $event = Event::findOne($event_id);
        if (!$event) {
            throw new NotFoundHttpException('Событие не найдено');
        }

        $expenses = Expense::find()->where(['event_id' => $event_id])->all();
        $total = Expense::find()->where(['event_id' => $event_id])->sum('amount');

        $filename = 'budget_report_' . $event_id . '.csv';
        
        // Заголовки для скачивания файла
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        // Создаем выходной поток
        $output = fopen('php://output', 'w');
        
        // Заголовок отчета
        fputcsv($output, ['Отчет по бюджету: ' . $event->title]);
        fputcsv($output, ['Дата: ' . date('d.m.Y')]);
        fputcsv($output, []); // Пустая строка
        
        // Заголовки таблицы
        fputcsv($output, ['Описание', 'Категория', 'Сумма']);
        
        // Данные
        foreach ($expenses as $expense) {
            fputcsv($output, [
                $expense->description,
                $expense->category,
                number_format($expense->amount, 2)
            ]);
        }
        
        // Итог
        fputcsv($output, []); // Пустая строка
        fputcsv($output, ['', 'Итого:', number_format($total, 2)]);
        
        // Закрываем поток и завершаем выполнение
        fclose($output);
        Yii::$app->end();
    }

    /**
     * Finds the Expense model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Expense the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Expense::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
