<?php

namespace app\controllers;

use app\models\entities\Message;
use app\models\entities\MessageRecipient;
use app\models\search\MessageSearch;
use app\models\search\VMessageRecipientSearch;
use app\utils\AuthUtil;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * MessagesController implements the CRUD actions for Message model.
 */
class MessagesController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['create', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            return AuthUtil::iAmAdmin();
                        }
                    ],
                    [
                        'actions' => ['index', 'view', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
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
     * Lists all Message models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (AuthUtil::iAmAdmin()) {
            $searchModel = new MessageSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $view = 'index';
        } else {
            $searchModel = new VMessageRecipientSearch();
            $searchModel->recipient_id = AuthUtil::getMyId();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $view = 'index-recipient';
        }

        return $this->render($view, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Message model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (!AuthUtil::iAmAdmin()) {
            MessageRecipient::findOne([
                'message_id' => $id,
                'recipient_id' => AuthUtil::getMyId(),
            ])->updateAttributes(['unread' => 0]);
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Message();

        if ($model->load(Yii::$app->request->post())) {
            $recipients = Yii::$app->request->post('recipients');

            if ($recipients) {
                $model->sender_id = AuthUtil::getMyId();

                if ($model->save()) {
                    $this->saveRecipients($model);

                    return $this->redirect(['index']);
                }
            } else {
                Yii::$app->session->setFlash('danger', 'Debe seleccionar al menos un destinatario');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Message model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $recipients = Yii::$app->request->post('recipients');

            if ($recipients) {
                $model->save();
                $this->updateRecipients($model);

                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('danger', 'Debe seleccionar al menos un destinatario');
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Message model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (AuthUtil::iAmAdmin()) {
            $this->findModel($id)->delete();
        } else {
            MessageRecipient::findOne($id)->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Message model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Message the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Message::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function saveRecipients(Message $model)
    {
        $recipients = Yii::$app->request->post('recipients');
        $transaction = Yii::$app->db->beginTransaction();

        foreach ($recipients as $recipient) {
            $recipientModel = new MessageRecipient([
                'message_id' => $model->id,
                'recipient_id' => $recipient,
                'unread' => 1,
            ]);

            $recipientModel->save();
        }
        $transaction->commit();
    }

    private function updateRecipients(Message $model)
    {
        MessageRecipient::deleteAll(['message_id' => $model->id]);

        return $this->saveRecipients($model);
    }

}
