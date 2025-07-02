<?php

namespace app\controllers;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Guest;
use app\models\Event;
use Yii;
use yii\filters\AccessControl;
use app\models\GuestSearch;

/**
 * GuestController implements the CRUD actions for Guest model.
 */
class GuestController extends Controller
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
                            // Разрешаем создание всем авторизованным
                            if ($action->id === 'create') {
                                return true;
                            }
                            
                            // Для других действий - проверка через связь с мероприятием
                            if (in_array($action->id, ['update', 'delete', 'view'])) {
                                $id = Yii::$app->request->get('id');
                                $guest = Guest::findOne($id);
                                
                                // Если гостя не существует, разрешаем (попадет на 404)
                                if (!$guest) {
                                    return true;
                                }
                                
                                // Проверка что текущий пользователь - организатор мероприятия
                                return $guest->event->organizer_id === Yii::$app->user->id;
                            }
                            
                            return true;
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Guest models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new GuestSearch(); // Добавляем модель поиска
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel, // Передаем в представление
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Guest model.
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
     * Creates a new Guest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Guest();
        $events = Event::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                // Перенаправляем на страницу гостя вместо мероприятия
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'events' => $events,
        ]);
    }

    /**
     * Updates an existing Guest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */

     public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $events = Event::find()->all(); // Получаем все мероприятия

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'events' => $events, // Передаем в представление
        ]);
    }

    /**
     * Deletes an existing Guest model.
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

    /**
     * Finds the Guest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Guest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Guest::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
