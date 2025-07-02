<?php

namespace app\controllers;

use app\models\Task;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use app\models\EventCategory;
use app\models\Event;
use Yii;
use yii\helpers\Url;
use app\models\User;
use app\models\TaskSearch;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if ($action->id === 'create') {
                                return true;
                            }
                        
                            if (in_array($action->id, ['update', 'delete'])) {
                                $id = Yii::$app->request->get('id');
                                $task = Task::findOne($id);
                                
                                // Проверка существования задачи и связанного события
                                if (!$task || !$task->event) {
                                    return false;
                                }
                                
                                return $task->event->organizer_id === Yii::$app->user->id;
                            }
                        
                            return true;
                        }
                    ],
                ],
            ],
            'verbs' => [ // Добавлено
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Task models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch(); // Добавляем модель поиска
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel, // Передаем в представление
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Task model.
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
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Task();
        $model->status = Task::STATUS_PENDING;
        
        // Получаем список мероприятий
        $events = Event::find()
            ->select(['id', 'title'])
            ->asArray()
            ->all();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                // Отправка уведомления...
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'events' => $events, // Передаем в представление
            'users' => User::find()->all(),
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        // Получаем список мероприятий
        $events = Event::find()
            ->select(['id', 'title'])
            ->asArray()
            ->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'events' => $events, // Передаем в представление
            'users' => User::find()->all(),
        ]);
    }

    /**
     * Deletes an existing Task model.
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



    public function actionCalendar()
{
    $events = Event::find()->all();
    $tasks = [];

    foreach ($events as $event) {
        $tasks[] = [
            'title' => $event->title,
            'start' => $event->event_date,
            'url' => Url::to(['event/view', 'id' => $event->id]),
            'color' => '#0a7cc4',
        ];
    }

    return $this->render('calendar', [
        'events' => $tasks,
        'categories' => EventCategory::find()->all()
    ]);
}

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
