<?php

namespace app\controllers;

use app\models\Event;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\EventCategory;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use Yii;
use yii\helpers\Url;
use app\models\Guest;
use app\models\Expense;
use app\models\Task;

/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller
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
                            // Для создания и просмотра - всем авторизованным
                            if (in_array($action->id, ['create', 'view', 'calendar', 'filter'])) {
                                return true;
                            }
                            
                            // Для других действий - проверка владельца
                            if (in_array($action->id, ['update', 'delete'])) {
                                $id = Yii::$app->request->get('id');
                                $model = $this->findModel($id);
                                
                                if ($model->organizer_id !== Yii::$app->user->id) {
                                    throw new ForbiddenHttpException('У вас нет прав для этого действия');
                                }
                                
                                return true;
                            }
                            
                            return true;
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    /**
     * Lists all Event models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Event::find()
                ->select(['id', 'title', 'event_date', 'location', 'organizer_id'])
                ->with([
                    'organizer' => function($query) {
                        $query->select(['id', 'username']);
                    }
                ]),
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'event_date' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Event model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        // Получаем гостей через связь
        $guests = $model->getGuests()
            ->select(['id', 'name', 'contact_info', 'status', 'is_waiting'])
            ->all();

        // Получаем расходы через связь
        $expenses = $model->getExpenses()
            ->select(['id', 'description', 'amount', 'category'])
            ->all();

        // Получаем задачи через связь
        $tasks = $model->getTasks()
            ->select(['id', 'title', 'description', 'deadline', 'status'])
            ->all();

        // Сумма расходов через метод модели
        $totalExpenses = $model->getTotalExpenses();

        return $this->render('view', [
            'model' => $model,
            'guests' => $guests,
            'expenses' => $expenses,
            'tasks' => $tasks,
            'totalExpenses' => $totalExpenses
        ]);
    }

    /**
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Event();
        $model->organizer_id = Yii::$app->user->id;
        
        try {
            if ($model->load(Yii::$app->request->post())) {
                // Минимальная валидация
                if ($model->validate(['title', 'event_date', 'location'])) {
                    if ($model->save(false)) { // false = пропустить валидацию
                        return $this->redirect(['index']); // Редирект на список вместо просмотра
                    }
                }
            }
            
            return $this->render('create', [
                'model' => $model,
                'categories' => []
            ]);
            
        } catch (\Exception $e) {
            Yii::error("Ошибка создания мероприятия: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Updates an existing Event model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            // Упрощаем преобразование даты
            if (is_string($model->event_date)) {
                $model->event_date = date('Y-m-d H:i:s', strtotime($model->event_date));
            }
            
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        // Загружаем только необходимые данные
        $categories = EventCategory::find()
            ->select(['id', 'name'])
            ->asArray()
            ->all();

        return $this->render('update', [
            'model' => $model,
            'categories' => $categories
        ]);
    }

    /**
     * Deletes an existing Event model.
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

    public function actionFilter($category_id = null, $location = null, $skill_level = null)
    {   
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $query = Event::find()
            ->select(['id', 'title', 'event_date', 'location']);
        
        if ($category_id) {
            $query->andWhere(['category_id' => $category_id]);
        }
        
        if ($location) {
            $query->andWhere(['like', 'location', $location]);
        }
        
        if ($skill_level) {
            $query->andWhere(['skill_level' => $skill_level]);
        }
        
        $events = $query->asArray()->all();
        $result = [];
        
        foreach ($events as $event) {
            $result[] = [
                'title' => $event['title'],
                'start' => $event['event_date'],
                'url' => Url::to(['event/view', 'id' => $event['id']]),
                'color' => '#0a7cc4',
                'extendedProps' => [
                    'location' => $event['location'],
                ]
            ];
        }
        
        return $result;
    }
    
    public function actionCalendar()
    {
        // Используем минимальный набор данных
        $events = Event::find()
            ->select(['id', 'title', 'event_date', 'location'])
            ->asArray()
            ->all();

        $calendarEvents = [];
        foreach ($events as $event) {
            $calendarEvents[] = [
                'title' => $event['title'],
                'start' => $event['event_date'],
                'url' => Url::to(['event/view', 'id' => $event['id']]),
            ];
        }

        $categories = EventCategory::find()
            ->select(['id', 'name'])
            ->asArray()
            ->all();

        return $this->render('calendar', [
            'events' => $calendarEvents,
            'categories' => $categories
        ]);
    }

    /**
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        // Используем минимальный набор полей
        $model = Event::find()
            ->select(['id', 'title', 'event_date', 'location', 'organizer_id'])
            ->where(['id' => $id])
            ->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
