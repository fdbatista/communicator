<?php

namespace app\controllers;

use app\models\entities\Message;
use app\models\entities\MessageRecipient;
use app\models\search\VMessageRecipientSearch;
use app\utils\AuthUtil;
use app\utils\EncryptUtil;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class MessagesController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            return AuthUtil::iAmAdmin();
                        }
                    ],
                    [
                        'actions' => ['index', 'view', 'create', 'delete', 'reply'],
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

    public function actionIndex()
    {
        /*if (AuthUtil::iAmAdmin()) {
            $searchModel = new MessageSearch();
            $searchModel->re = AuthUtil::getMyId();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $view = 'index';
        } else {*/
            $searchModel = new VMessageRecipientSearch();
            $searchModel->recipient_id = AuthUtil::getMyId();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $view = 'index-recipient';
        //}

        return $this->render($view, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $messageRecipient = MessageRecipient::findOne([
            'message_id' => $id,
            'recipient_id' => AuthUtil::getMyId(),
        ]);

        if ($messageRecipient) {
            $messageRecipient->updateAttributes(['unread' => 0]);
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Message();

        if ($model->load(Yii::$app->request->post())) {
            $recipients = Yii::$app->request->post('recipients');

            if ($recipients) {
                $model->sender_id = AuthUtil::getMyId();
                $model->subject = EncryptUtil::encrypt($model->subject);
                $model->body = EncryptUtil::encrypt($model->body);

                if ($model->save()) {
                    $this->saveRecipients($model, $recipients);

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

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $recipients = Yii::$app->request->post('recipients');

            if ($recipients) {
                $model->subject = EncryptUtil::encrypt($model->subject);
                $model->body = EncryptUtil::encrypt($model->body);

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

    public function actionDelete($id)
    {
        /*if (AuthUtil::iAmAdmin()) {
            $this->findModel($id)->delete();
        } else {*/
            MessageRecipient::findOne($id)->delete();
        //}

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Message::findOne($id)) !== null) {
            $model->subject = EncryptUtil::decrypt($model->subject);
            $model->body = EncryptUtil::decrypt($model->body);

            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function saveRecipients(Message $model, $recipients)
    {
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

        return $this->saveRecipients($model, Yii::$app->request->post('recipients'));
    }

    public function actionReply($id)
    {
        $originalMessage = $this->findModel($id);

        $model = new Message([
            'subject' => "Re: $originalMessage->subject",
            'sender_id' => AuthUtil::getMyId(),
        ]);

        if ($model->load(Yii::$app->request->post())) {
            $recipients = [$originalMessage->sender_id];

            $model->subject = EncryptUtil::encrypt($model->subject);
            $model->body = EncryptUtil::encrypt($model->body);

            if ($model->save()) {
                $this->saveRecipients($model, $recipients);

                return $this->redirect(['index']);
            }
        }

        return $this->render('reply', [
            'model' => $model,
        ]);
    }

}
